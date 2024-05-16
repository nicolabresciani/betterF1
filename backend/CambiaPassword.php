<?php
header("Content-Type: application/json");
require 'vendor/autoload.php';

use SendGrid\Mail\Mail;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterF1";

// Funzione per inviare email
function sendEmail($to, $from, $subject, $body) {
    $email = new Mail();
    $email->setFrom($from);
    $email->setSubject($subject);
    $email->addTo($to);
    $email->addContent("text/plain", $body);
    
    $sendgrid = new \SendGrid('YOUR_SENDGRID_API_KEY'); // Inserisci qui la tua chiave API di SendGrid

    try {
        $response = $sendgrid->send($email);
        if ($response->statusCode() >= 200 && $response->statusCode() < 300) {
            return true;
        } else {
            error_log('SendGrid error: ' . $response->body());
            return false;
        }
    } catch (Exception $e) {
        error_log('Caught exception: '. $e->getMessage());
        return false;
    }
}

// Funzione per generare un token
function generateToken() {
    return bin2hex(random_bytes(50));
}

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Lettura e decodifica dei dati JSON
$json = file_get_contents('php://input');
$dati = json_decode($json, true);

if (!isset($dati['email'])) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit();
}

$email = $conn->real_escape_string($dati['email']);

// Preparazione e esecuzione della query
$stmt = $conn->prepare("SELECT * FROM Utente WHERE Mail = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $token = generateToken();
    $link = "http://localhost:41062/reset-password.php?token=" . $token;

    // Aggiornamento del token nel database
    $stmt = $conn->prepare("UPDATE Utente SET PasswordResetToken = ? WHERE Mail = ?");
    $stmt->bind_param("ss", $token, $email);
    $stmt->execute();

    // Verifica se l'aggiornamento è andato a buon fine
    if ($stmt->affected_rows > 0) {
        // Invia l'email di reimpostazione della password
        $subject = 'Reimposta la tua password';
        $body = "Clicca sul seguente link per reimpostare la tua password: " . $link;
        $from = 'mittente@example.com'; // Utilizza un'email valida del mittente, non l'email dell'utente

        if (sendEmail($email, $from, $subject, $body)) {
            $response = ['success' => true, 'message' => 'Email inviata con successo'];
        } else {
            $response = ['success' => false, 'message' => 'Errore durante l\'invio dell\'email'];
        }
    } else {
        $response = ['success' => false, 'message' => 'Errore durante l\'aggiornamento del token'];
    }
} else {
    $response = ['success' => false, 'message' => 'Utente non trovato'];
}

echo json_encode($response);
$conn->close();
exit();
?>
