<?php
    // Avvia la sessione
    session_start();

    // Connessione al database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "betterF1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Controllo della connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Query per ottenere il codice di validazione corrispondente allo username specificato
        $query = "SELECT CodiceValidazione FROM Utente WHERE Username = '$username'";

        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $codice = $row['CodiceValidazione'];

            // Restituisci il codice come parte di una risposta JSON
            echo json_encode(['valido' => true, 'codice' => $codice]);
        } else {
            // Restituisci un messaggio di errore come parte di una risposta JSON
            echo json_encode(['valido' => false, 'errore' => 'Codice di validazione non disponibile']);
        }
    } else {
        // Restituisci un messaggio di errore come parte di una risposta JSON
        echo json_encode(['valido' => false, 'errore' => 'Username non impostato nella sessione']);
    }

    $conn->close();
?>
