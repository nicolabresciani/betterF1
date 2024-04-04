<?php
    session_start();

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

    // Verifica se è stato inviato l'ID della scommessa da eliminare
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        // Query per eliminare la scommessa dal carrello
        $query_delete_carrello_provvisorio = "DELETE FROM CarrelloProvvisorio WHERE Id = '$delete_id'";
        
        // Esegui la query per eliminare la scommessa dal carrello provvisorio
        if ($conn->query($query_delete_carrello_provvisorio) === TRUE) {
            // Successo nell'eliminazione della scommessa dal carrello provvisorio
            echo "Scommessa eliminata correttamente dal carrello provvisorio.";
        } else {
            // Errore nell'eliminazione della scommessa dal carrello provvisorio
            echo "Errore nell'eliminazione della scommessa dal carrello provvisorio: " . $conn->error;
        }
    }

    // Verifica se sono stati ricevuti i dati POST per l'inserimento della scommessa
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['importo']) && isset($_POST['quota'])) {
        // Definizione delle variabili
        $importo = $_POST['importo'];
        $quota = $_POST['quota'];

        // Assicurati che $importo contenga un valore numerico
        if (!is_numeric($importo)) {
            echo "Errore: L'importo deve essere un numero.";
            exit();
        }

        // Query per inserire la scommessa nel database
        $scommessaIdQuery = "SELECT Scommessa_Id FROM CarrelloProvvisorio WHERE Utente_Username = '$utenteUsername'";
        $result = $conn->query($scommessaIdQuery);

        // Verifica se è stata trovata un'ID della scommessa nel carrello provvisorio
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $scommessaId = $row['Scommessa_Id'];

            // Query per inserire la scommessa nel database
            $query_insert_scommessa = "INSERT INTO Scommessa (Id_Scommessa, ImportoScommesso, ImportoVinto, StatoScommessa, Data, Utente_Username, Quota_Id, Amministratore_Username) 
                                VALUES ('$scommessaId', $importo, '0', 'Aperta', CURDATE(), '$utenteUsername', $quota, '$amministratoreUsername')";

            // Esecuzione della query per inserire la scommessa
            if ($conn->query($query_insert_scommessa) === TRUE) {
                // PHP - Modifica della query di inserimento della schedina nel carrello
                $query_insert_carrello = "INSERT INTO Carrello (Scommessa_Id, Utente_Username, Quota, Importo, Stato) 
                VALUES ('$scommessaId', '$utenteUsername', $quota, $importo, TRUE)"; // Stato impostato a TRUE inizialmente
                
                // Esegui la query per inserire la scommessa nel carrello
                if ($conn->query($query_insert_carrello) === TRUE) {
                    // Successo nell'inserimento della scommessa nel carrello
                    echo "Scommessa inserita correttamente nel carrello!";
                    // eliminare la scommessa dal carrello provvisorio solo se l'utente conferma
                    if (isset($_POST['conferma']) && $_POST['conferma'] == 'true') {
                        // Query per eliminare la scommessa dal carrello provvisorio
                        $query_delete_carrello_provvisorio = "DELETE FROM CarrelloProvvisorio WHERE Utente_Username = '$utenteUsername'";
                        if ($conn->query($query_delete_carrello_provvisorio) === TRUE) {
                            // Successo nell'eliminazione della scommessa dal carrello provvisorio
                            echo "Scommessa eliminata correttamente dal carrello provvisorio!";
                        } else {
                            // Errore nell'eliminazione della scommessa dal carrello provvisorio
                            echo "Errore: " . $query_delete_carrello_provvisorio . "<br>" . $conn->error;
                        }
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
            // Errore nel recupero dell'ID della scommessa dal carrello provvisorio
            echo "Errore: Nessun ID di scommessa trovato nel carrello provvisorio.";
        }
    }
    // Query per recuperare le scommesse presenti nel carrello principale
    $query_carrello_principale = "SELECT * FROM Carrello WHERE Utente_Username = '$utenteUsername'";
    $result_carrello_principale = $conn->query($query_carrello_principale);

    // Verifica se ci sono scommesse nel carrello principale
    if ($result_carrello_principale && $result_carrello_principale->num_rows > 0) {
        // Se esistono scommesse nel carrello principale, visualizzale
        echo "<h2>Scommesse nel carrello principale:</h2>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Pilota</th>";
        echo "<th>Quota</th>";
        echo "<th>Importo</th>";
        echo "<th>Possibile Vittoria</th>";
        echo "<th>Stato</th>";
        echo "<th>Data</th>";
        echo "<th>Azione</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        // Itera sui risultati e stampa ogni riga del carrello principale
        while ($row_carrello_principale = $result_carrello_principale->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_carrello_principale["NominativoPilota"] . "</td>";
            echo "<td>" . $row_carrello_principale["Quota"] . "</td>";
            echo "<td>" . $row_carrello_principale["Importo"] . "</td>";
            // Calcola la possibile vittoria se necessario
            echo "<td>" . $row_carrello_principale["PossibileVittoria"] . "</td>";
            echo "<td>" . $row_carrello_principale["Stato"] . "</td>";
            echo "<td>" . $row_carrello_principale["Data"] . "</td>";
            // Mostra solo il pulsante "Confermata" nella colonna Azione
            echo "<td><button class='confermata-button' onclick='confermaScommessa(" . $row_carrello_principale["Id"] . ")'>Confermata</button></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        // Se non ci sono scommesse nel carrello principale, mostra un messaggio appropriato
        echo "<p>Nessuna scommessa nel carrello principale.</p>";
    }


// Chiusura della connessione al database
$conn->close();
?>
