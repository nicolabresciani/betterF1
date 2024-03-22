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
    $username = isset($_POST["username"]) ? $_POST["username"] : '';
    $nome = isset($_POST["Nome"]) ? $_POST["Nome"] : '';
    $cognome = isset($_POST["Cognome"]) ? $_POST["Cognome"] : '';
    $cellulare = isset($_POST["Cellulare"]) ? $_POST["Cellulare"] : '';
    $password = isset($_POST["Password"]) ? $_POST["Password"] : '';
    $confermaPassword = isset($_POST["ConfermaPassword"]) ? $_POST["ConfermaPassword"] : '';

    // Verifica se le password corrispondono
    if ($password != $confermaPassword) {
        echo "Le password non corrispondono.";
        exit;
    }

    // Crittografia della password con MD5
    $hashedPassword = md5($password);

    // Query per cercare l'utente nella tabella Utente
    $sql_utente = "SELECT * FROM Utente WHERE Username = '$username' AND Nome = '$nome' AND Cognome = '$cognome' AND Cellulare = '$cellulare'";
    $result_utente = $conn->query($sql_utente);

    // Verifica se l'utente è presente nella tabella Utente
    if ($result_utente->num_rows > 0) {
        // Query per aggiornare la password dell'utente
        $sql = "UPDATE Utente SET Password = '$hashedPassword' WHERE Username = '$username' AND Nome = '$nome' AND Cognome = '$cognome' AND  Cellulare = '$cellulare'";

        if ($conn->query($sql) === TRUE) {
            echo "Password aggiornata con successo.";
            header("Location: ../frontend/Login.php");
        } else {
            echo "Errore durante l'aggiornamento della password: " . $conn->error;
        }
    } else {
        echo "Nessun utente trovato con le informazioni fornite.";
    }
}

// Chiudi la connessione al database
$conn->close();
?>
