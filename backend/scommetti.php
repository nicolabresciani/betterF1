<?php
session_start();

// Verifica se la richiesta è una richiesta POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di login
    if (!isset($_SESSION['username'])) {
        header("Location: ../frontend/Login.php");
        exit();
    }

    // Informazioni per la connessione al database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "betterF1";

    // Creazione della connessione
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica della connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Altre informazioni necessarie
    $utenteUsername = $_SESSION['username'];
    $amministratoreUsername = "Nick"; // Presumo che 'Nick' sia il nome utente dell'amministratore, modificarlo se diverso

    // Verifica se i dati POST sono stati inviati correttamente
    if(isset($_POST['importo']) && isset($_POST['quota'])) {
        // Definizione delle variabili
        $importo = $_POST['importo'];
        $quota = $_POST['quota'];
    
        // valore autoincrementale
        $id = 0;

        $si = $id + 1;
        // Query per inserire la scommessa nel database
        $query_insert_scommessa = "INSERT INTO Scommessa (ImportoScommesso, ImportoVinto, StatoScommessa, Data, Utente_Username, Quota_Id, Amministratore_Username) 
                            VALUES ('$importo', '0', 'Aperta', CURDATE(), '$utenteUsername', '$quota', '$amministratoreUsername')";

        // Esecuzione della query per inserire la scommessa
        if ($conn->query($query_insert_scommessa) === TRUE) {
            // Query per inserire la scommessa nel carrello
            $scommessaId = $conn->insert_id; // Ottieni l'ID della scommessa appena inserita

            $query_insert_carrello = "INSERT INTO Carrello (Utente_Username, Scommessa_Id, Quota, Importo) 
                                      VALUES ('$utenteUsername', '$scommessaId', '$quota', '$importo')";

            // Esecuzione della query per inserire la scommessa nel carrello
            if ($conn->query($query_insert_carrello) === TRUE) {
                // Successo nell'inserimento della scommessa nel carrello
                echo "Scommessa inserita correttamente nel carrello!";
            } else {
                // Errore nell'esecuzione della query per inserire la scommessa nel carrello
                echo "Errore: " . $query_insert_carrello . "<br>" . $conn->error;
            }
        } else {
            // Errore nell'esecuzione della query
            echo "Errore: " . $query_insert_scommessa . "<br>" . $conn->error;
        }

        // Controllo aggiuntivo sull'operazione di inserimento
        if ($conn->affected_rows > 0) {
            // L'operazione di inserimento è stata eseguita correttamente
            echo "Scommessa inserita correttamente nel database.";
        } else {
            // Si è verificato un errore durante l'inserimento dei dati nel database
            echo "Errore durante l'inserimento della scommessa nel database.";
        }
    } else {
        // Messaggio di errore se i dati POST non sono stati inviati correttamente
        echo "Errore: Dati POST non ricevuti correttamente.";
    }

    // Chiudi la connessione
    $conn->close();
} else {
    // Messaggio di errore se la richiesta non è una richiesta POST
    echo "Errore: Questa pagina accetta solo richieste POST.";
}
?>
