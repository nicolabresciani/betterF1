<?php
// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bettterF1"; // Sostituisci con il nome effettivo del tuo database

$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    // Invia una risposta JSON indicando un errore se la connessione fallisce
    echo json_encode(array("success" => false, "message" => "Connessione fallita: " . $conn->connect_error));
    exit(); // Termina lo script dopo l'invio della risposta JSON
}

// Verifica se il metodo della richiesta è POST e se è stato fornito un username
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    // Ottieni l'username dall'input POST
    $username = $_POST['username'];

    // Query per cambiare il ruolo dell'utente nel database
    $sql = "UPDATE Utente SET Ruolo = CASE WHEN Ruolo = 'Utente' THEN 'Sotto Amministratore' END WHERE Username = '$username'";

    // Esegui la query
    if ($conn->query($sql) === TRUE) {
        // Invia una risposta JSON per indicare il successo dell'operazione
        echo json_encode(array("success" => true, "message" => "Ruolo dell'utente cambiato con successo"));
    } else {
        // Invia una risposta JSON indicando un errore
        echo json_encode(array("success" => false, "message" => "Errore durante il cambio di ruolo dell'utente: " . $conn->error));
    }
} else {
    // Invia una risposta JSON indicando un errore se l'input è mancante
    echo json_encode(array("success" => false, "message" => "Username non fornito o richiesta non valida"));
}

// Chiudi la connessione al database
$conn->close();
?>
