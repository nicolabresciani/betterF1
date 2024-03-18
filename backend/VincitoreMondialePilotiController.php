<?php
// Connessione al database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "betterf1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Gestione dell'invio del form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal form
    $scommessaId = $_POST["scommessaId"];
    $utenteUsername = $_POST["utenteUsername"];
    $quantita = $_POST["quantita"];

    // Verifica se la scommessa esiste nel database
    $query = "SELECT * FROM Scommessa WHERE Id = $scommessaId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Scommessa trovata, aggiungi al carrello
        $row = $result->fetch_assoc();
        $importoScommesso = $row["ImportoScommesso"];
        $importoVinto = $row["ImportoVinto"];
        $statoScommessa = $row["StatoScommessa"];
        $data = $row["Data"];
        $amministratoreUsername = $row["Amministratore_Username"];

        // Inserimento della scommessa nel carrello
        $query = "INSERT INTO Carrello (Utente_Username, Scommessa_Id, Quantita) VALUES ('$utenteUsername', $scommessaId, $quantita)";
        if ($conn->query($query) === TRUE) {
            echo "Scommessa aggiunta al carrello con successo.";
        } else {
            echo "Errore nell'aggiunta della scommessa al carrello: " . $conn->error;
        }
    } else {
        echo "Scommessa non trovata nel database.";
    }
}

// Chiusura della connessione
$conn->close();
?>
