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

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Assicurati che lo username sia stato impostato nella sessione
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            // Query per ottenere il codice di validazione corrispondente allo username specificato
            $query = "SELECT CodiceValidazione FROM Utente WHERE Username = '$username'";
            echo "Query: " . $query . "<br>"; // Debug della query

            $result = $conn->query($query);

            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $response = array("valido" => true, "codice" => $row['CodiceValidazione']);
                    echo json_encode($response);
                } else {
                    $response = array("valido" => false);
                    echo json_encode($response);
                }
            } else {
                echo "Errore nella query: " . $conn->error; // Debug dell'errore SQL
            }
        } else {
            // Se lo username non è impostato nella sessione, restituisci un errore
            $response = array("valido" => false, "errore" => "Username non impostato nella sessione");
            echo json_encode($response);
        }
    }

    // Chiudi connessione al database
    $conn->close();
?>
