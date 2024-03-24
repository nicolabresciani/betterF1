<?php
// Connessione al database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "nome_database";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Gestione della richiesta di cambio ruolo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leggi i dati inviati
    $username = $_POST['username'];
    $newRole = $_POST['newRole'];

    // Controllo per verificare se l'utente è già un sottoamministratore
    $checkQuery = "SELECT * FROM SottoAmministratore WHERE Username='$username'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0 && $newRole === 'utente') {
        // L'utente è un sottoamministratore, ma vuole tornare utente normale
        // Rimuovi l'utente dalla tabella dei sottoamministratori
        $deleteQuery = "DELETE FROM SottoAmministratore WHERE Username='$username'";
        if ($conn->query($deleteQuery) === TRUE) {
            // Aggiorna il ruolo dell'utente nella tabella Utente
            $updateQuery = "UPDATE Utente SET Ruolo='utente' WHERE Username='$username'";
            if ($conn->query($updateQuery) === TRUE) {
                echo json_encode(array("message" => "Ruolo utente ripristinato con successo"));
            } else {
                echo json_encode(array("error" => "Errore nell'aggiornamento del ruolo utente: " . $conn->error));
            }
        } else {
            echo json_encode(array("error" => "Errore nella rimozione dall'elenco dei sottoamministratori: " . $conn->error));
        }
    } elseif ($result->num_rows == 0 && $newRole === 'sottoamministratore') {
        // L'utente è un utente normale e vuole diventare sottoamministratore
        // Inserisci l'utente nella tabella dei sottoamministratori
        $insertQuery = "INSERT INTO SottoAmministratore (Username, Ruolo) VALUES ('$username', 'sottoamministratore')";
        if ($conn->query($insertQuery) === TRUE) {
            // Aggiorna il ruolo dell'utente nella tabella Utente
            $updateQuery = "UPDATE Utente SET Ruolo='sottoamministratore' WHERE Username='$username'";
            if ($conn->query($updateQuery) === TRUE) {
                echo json_encode(array("message" => "Ruolo sottoamministratore aggiornato con successo"));
            } else {
                echo json_encode(array("error" => "Errore nell'aggiornamento del ruolo sottoamministratore: " . $conn->error));
            }
        } else {
            echo json_encode(array("error" => "Errore nell'inserimento nell'elenco dei sottoamministratori: " . $conn->error));
        }
    } else {
        // Ruolo non cambiato
        echo json_encode(array("message" => "Il ruolo dell'utente è già aggiornato"));
    }
}

// Chiudi la connessione
$conn->close();
?>
