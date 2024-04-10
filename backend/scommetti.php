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
    
    $scommessaIdQuery = "SELECT Scommessa_Id FROM CarrelloProvvisorio WHERE Utente_Username = '$utenteUsername'";
    $result = $conn->query($scommessaIdQuery);

    // Verifica se i dati POST sono stati inviati correttamente
    if(isset($_POST['importo']) && isset($_POST['quota'])) {
        // Definizione delle variabili
        $importo = $_POST['importo'];
        $quota = $_POST['quota'];

        // Query per ottenere il saldo dell'utente
        $query_saldo = "SELECT Saldo FROM Portafoglio WHERE Username = '$utenteUsername'";
        $result_saldo = $conn->query($query_saldo);

        if ($result_saldo->num_rows > 0) {
            $row_saldo = $result_saldo->fetch_assoc();
            $saldo_disponibile = $row_saldo['Saldo'];

            // Controlla se l'importo da scommettere è disponibile
            if ($importo > $saldo_disponibile) {
                echo "Errore: Saldo insufficiente per effettuare la scommessa.";
                exit(); // Interrompi l'esecuzione dello script
            } else {
                // Calcola il nuovo saldo dopo la scommessa
                $nuovo_saldo = $saldo_disponibile - $importo;

                // Query per aggiornare il saldo nel database
                $query_aggiorna_saldo = "UPDATE Portafoglio SET Saldo = $nuovo_saldo WHERE Username = '$utenteUsername'";

                // Esegui la query di aggiornamento del saldo
                if ($conn->query($query_aggiorna_saldo) === TRUE) {
                    echo "Saldo aggiornato correttamente!";
                } else {
                    echo "Errore nell'aggiornamento del saldo: " . $conn->error;
                    exit(); // Interrompi l'esecuzione dello script
                }
            }
        } else {
            echo "Errore nel recupero del saldo dell'utente.";
            exit(); // Interrompi l'esecuzione dello script
        }


        // Verifica se è stata trovata un'ID della scommessa nel carrello provvisorio
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $scommessaId = $row['Scommessa_Id'];

            // Query per inserire la scommessa nel database
            $query_insert_scommessa = "INSERT INTO Scommessa (Id_Scommessa, ImportoScommesso, ImportoVinto, StatoScommessa, Data, Utente_Username, Quota_Id, Amministratore_Username) 
                                VALUES ('$scommessaId', $importo, '0', 'Aperta', CURDATE(), '$utenteUsername', $quota, '$amministratoreUsername')";


            // Esecuzione della query per inserire la scommessa
            if ($conn->query($query_insert_scommessa) === TRUE) {
                // Query per inserire la scommessa nel carrello
                $query_insert_carrello = "INSERT INTO Carrello (Scommessa_Id, Utente_Username, Quota, Importo) 
                    VALUES ('$scommessaId', '$utenteUsername', $quota, $importo)";  

                // Esecuzione della query per inserire la scommessa nel carrello
                if ($conn->query($query_insert_carrello) === TRUE) {
                    // Successo nell'inserimento della scommessa nel carrello
                    echo "Scommessa inserita correttamente nel carrello!";
                    // elimanre la scommessa dal carrello provvisorio
                    $query_delete_carrello_provvisorio = "DELETE FROM CarrelloProvvisorio WHERE Utente_Username = '$utenteUsername'";
                    if ($conn->query($query_delete_carrello_provvisorio) === TRUE) {
                        // Successo nell'eliminazione della scommessa dal carrello provvisorio
                        echo "Scommessa eliminata correttamente dal carrello provvisorio!";
                    } else {
                        // Errore nell'eliminazione della scommessa dal carrello provvisorio
                        echo "Errore: " . $query_delete_carrello_provvisorio . "<br>" . $conn->error;
                    }
                } else {
                    // Errore nell'esecuzione della query per inserire la scommessa nel carrello
                    echo "Errore: " . $query_insert_carrello . "<br>" . $conn->error;
                }
            } else {
                // Errore nell'esecuzione della query
                echo "Errore: " . $query_insert_scommessa . "<br>" . $conn->error;
            }
        } else {
            // Errore nel recupero dell'ID della scommessa
            echo "Errore: Nessuna scommessa trovata nel carrello provvisorio per l'utente.";
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