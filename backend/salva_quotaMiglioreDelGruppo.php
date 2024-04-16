<?php
session_start();

// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterF1";

// Verifica se l'utente è loggato
if (!isset($_SESSION['username'])) {
    header("Location: ../frontend/Login.php");
    exit();
}

// Verifica se è stato inviato un POST con i dati del pilota e della quota
if (isset($_POST['pilota']) && isset($_POST['quota']) && isset($_POST['scelta'])) {
    $utenteUsername = $_SESSION['username'];
    $quota = $_POST['quota'];
    $pilota = $_POST['pilota'];
    $scelta = $_POST['scelta']; // Si o No, basato sul pulsante cliccato

    // Connessione al database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Controlla se l'utente ha già una quota nel carrello provvisorio
    $checkQuery = "SELECT * FROM CarrelloProvvisorio WHERE Utente_Username = '$utenteUsername'";
    $result = $conn->query($checkQuery);
    if ($result->num_rows > 0) {
        // L'utente ha già una quota nel carrello, invia un messaggio di conferma
        echo "quota-gia-selezionata";
    } else {
        // Genera un ID univoco per la scommessa
        $scommessaId = substr(md5(uniqid(rand(), true)), 0, 10);

        // Prepara e esegui la query di inserimento
        $sql = "INSERT INTO CarrelloProvvisorio (Utente_Username, Scommessa_Id, NominativoPilota, Quota, Importo) VALUES ('$utenteUsername', '$scommessaId','$pilota' ,$quota, 0)";
        if ($conn->query($sql) === TRUE) {
            echo "quota-inserita-correttamente";
        } else {
            echo "Errore durante l'inserimento dei dati nel database: " . $conn->error;
        }   
        // Inserisci la nuova scommessa nella tabella Scommessa
        // quando inserisce la scelta, se è SI allora fa riferimento al primo pilota
        //se inserisce NO fa riferimento al secondo pilota
        $aggiunta ="INSERT INTO Scommessa (Scelta, CampoDiScommessa, nominativo) 
                VALUES ('$scelta', 'Migliore Del Gruppo', '$pilota')";
        if($conn->query($aggiunta) === TRUE){
            echo "quota inserita";
        }else{
            echo "Errore durante l'inserimento dei dati nel database: " . $conn->error;
        }
    }

    // Chiudi la connessione al database
    $conn->close();
} else {
    echo "Errore: Dati mancanti nella richiesta.";
}
?>
