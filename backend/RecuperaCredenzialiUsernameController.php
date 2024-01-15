<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "betterF1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Controllo della connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Recupero i dati dal modulo HTML
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = isset($_POST["Nome"]) ? $_POST["Nome"] : '';
        $cognome = isset($_POST["Cognome"]) ? $_POST["Cognome"] : '';
        $cellulare = isset($_POST["Cellulare"]) ? $_POST["Cellulare"] : '';
        $nuovoUsername = isset($_POST["NuovoUsername"]) ? $_POST["NuovoUsername"] : '';
        $confermaNuovoUsername = isset($_POST["ConfermaNuovoUsername"]) ? $_POST["ConfermaNuovoUsername"] : '';

        // Verifica se i nuovi username corrispondono
        if ($nuovoUsername != $confermaNuovoUsername) {
            echo "I nuovi username non corrispondono.";
            exit;
        }

        // Verifica se l'username è già stato utilizzato
        $controlloUsernameUtente = "SELECT * FROM Utente WHERE Username = '$nuovoUsername'";
        $result = $conn->query($controlloUsernameUtente);
        if ($result->num_rows > 0) {
            echo "Username già utilizzato nella tabella Utente.";
            exit;
        }

        // Ottieni l'username attuale
        $controlloVecchioUsername = "SELECT Username FROM Utente WHERE Nome = '$nome' AND Cognome = '$cognome' AND Cellulare = '$cellulare'";
        $resultVecchioUsername = $conn->query($controlloVecchioUsername);
        if ($resultVecchioUsername->num_rows == 1) {
            $row = $resultVecchioUsername->fetch_assoc();
            $usernameAttuale = $row["Username"];

            // Query per aggiornare l'username dell'utente nella tabella Utente
            $updateUsernameUtente = "UPDATE Utente SET Username = '$nuovoUsername' WHERE Nome = '$nome' AND Cognome = '$cognome' AND Cellulare = '$cellulare'";
            if ($conn->query($updateUsernameUtente) === TRUE) {
                echo "Username Utente aggiornato con successo.";
            } else {
                echo "Errore durante l'aggiornamento dell'username Utente: " . $conn->error;
                exit;
            }

            // Query per aggiornare l'username dell'utente nella tabella Portafoglio
            $updateUsernamePortafoglio = "UPDATE Portafoglio SET Username = '$nuovoUsername' WHERE Username = '$usernameAttuale'";
            if ($conn->query($updateUsernamePortafoglio) !== TRUE) {
                echo "Errore durante l'aggiornamento dell'username Portafoglio: " . $conn->error;
                exit;
            }

            // Query per aggiornare l'username dell'utente nella tabella Deposito
            $updateUsernameDeposito = "UPDATE Deposito SET Portafoglio_Username = '$nuovoUsername' WHERE Portafoglio_Username = '$usernameAttuale'";
            if ($conn->query($updateUsernameDeposito) === TRUE) {
                echo "Username Deposito aggiornato con successo.";
                header("Location: ../frontend/Login.php");
                exit(); // Termina lo script dopo il reindirizzamento
            } else {
                echo "Errore durante l'aggiornamento dell'username Deposito: " . $conn->error;
            }
        } else {
            echo "Errore nel recupero dell'username attuale.";
        }
    }
?>
