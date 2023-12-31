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
        $nuovoUsername = isset($_POST["NuovoUsername"]) ? $_POST["NuovoUsername"] : '';
        $confermaNuovoUsername = isset($_POST["ConfermaNuovoUsername"]) ? $_POST["ConfermaNuovoUsername"] : '';

        // Verifica se i nuovi username corrispondono
        if ($nuovoUsername != $confermaNuovoUsername) {
            echo "I nuovi username non corrispondono.";
            exit;
        }

        // Verifica se l'username è già stato utilizzato
        $sql = "SELECT * FROM SottoAmministratore WHERE Username = '$nuovoUsername'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            echo "Username già utilizzato nella tabella SottoAmministratore.";
            exit;
        }

        // Query per aggiornare l'username del SottoAmministratore
        $sql = "UPDATE SottoAmministratore SET Username = '$nuovoUsername' WHERE Nome = '$nome' AND Cognome = '$cognome'";
        if($conn->query($sql) === TRUE) {
            echo "Username aggiornato con successo.";
            header("Location: Login.php");
        } else {
            echo "Errore durante l'aggiornamento dell'username: " . $conn->error;
        }

        // Verifica se l'username è già stato utilizzato
        $controlloUsername = "SELECT * FROM Utente WHERE Username = '$nuovoUsername'";
        $result = $conn->query($controlloUsername);
        if($result->num_rows > 0) {
            echo "Username già utilizzato nella tabella Utente.";
            exit;
        }

        // Query per aggiornare l'username dell'utente
        $controlloUsername = "UPDATE Utente SET Username = '$nuovoUsername' WHERE Nome = '$nome' AND Cognome = '$cognome'";
        if($conn->query($controlloUsername) === TRUE) {
            echo "Username aggiornato con successo.";
            header("Location: Login.php");
        } else {
            echo "Errore durante l'aggiornamento dell'username: " . $conn->error;
        }
    }
?>
