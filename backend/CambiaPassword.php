<?php
//var_dump ($_POST);

header("Content-Type: application/json");
require '../vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterF1";

// Funzione per inviare email
function sendEmail($to, $from, $subject, $body) {
    $resend = Resend::client('re_STonAqFr_EgaJNcgXzHVcqn6ZD7M7P52m');
    try {
        $result = $resend->sendEmail([
            'id' => 'b1b1b1b1-b1b1-b1b1-b1b1-b1b1b1b1b1b1', // ID della campagna
            'to' => $to,
            'from' => $from,
            'subject' => $subject,
            'text' => $body
        ]);
    } catch (\Exception $e) {
        exit('Error: ' . $e->getMessage());
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
$post_data = file_get_contents('php://input');
//$dati = json_decode($post_data, true);
$dati['email'] = 'nicolabresciani321@gmail.com';

$email = $dati['email'];

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
        $from = $email; // Utilizza un'email valida del mittente, non l'email dell'utente

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
