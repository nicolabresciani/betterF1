<?php
    header("Content-Type: application/json");
    require 'vendor/autoload.php';

    use Resend\Resend;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "betterF1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Controllo della connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }
    // Create a DateTime object representing the current date and time
    $currentDate = new DateTime();

    // Convert the DateTime object to a string
    $taken = $currentDate->format('Y-m-d H:i:s');


    $resend = new Resend('re_STonAqFr_EgaJNcgXzHVcqn6ZD7M7P52m');

    // Construct the link with the unique code
    $link = "http://localhost:41062/reset-passowrd.php?token=" . $taken;

    // Send the email using Resend
    $resend->emails->send([
        'from' => 'Acme <onboarding@resend.dev>',
        'to' => [$email], // Use the email obtained from the frontend
        'subject' => 'Reset Password Link',
        'text' => 'Here is your reset password link: ' . $link,
        'headers' => [
            'X-Entity-Ref-ID' => '123456789',
        ],
        'tags' => [
            [
                'name' => 'category',
                'value' => 'reset_password',
            ],
        ],
    ]);


    // Ottieni l'email inviata dal frontend
    $json = file_get_contents('php://input');
    $dati = json_decode($json, true);
    $email = $dati['email'];

    // Query per aggiornare il campo PasswordResentToken nel database
    $sql = "SELECT * FROM Utente WHERE Mail = '$email'";

    $result = $conn->query($sql);

    // Controlla se l'aggiornamento nel database è avvenuto con successo
    if ($result && $result->num_rows > 0) {
        $sql = "UPDATE Utente SET PasswordResentToken = '$taken' WHERE Mail = '$email'";
        $conn->query($sql);
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }
    echo json_encode($response);



    // Chiudi la connessione al database
    $conn->close();
exit(); // Assicura che il processo PHP termini qui
?>
