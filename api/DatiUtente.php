<?php
// 1. connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterF1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// 2. verifica se viene richiesto l'elenco completo degli utenti o solo uno specifico
if(isset($_GET['id'])) {
    // Se è specificato un ID, esegui la query per ottenere solo l'utente specificato
    $userId = $_GET['id'];
    $sqlUtenti = "SELECT * FROM Utente WHERE Id = $userId";
} else {
    // Altrimenti, esegui la query per ottenere tutti gli utenti
    $sqlUtenti = "SELECT * FROM Utente";
}

$resultUtenti = $conn->query($sqlUtenti);

// Controllo se la query ha prodotto risultati
if ($resultUtenti === false) {
    die("Errore nella query: " . $conn->error);
}

// Array per contenere i dati degli utenti
$utenti = array();

// Iterazione sui risultati della query per estrarre i dati degli utenti
while ($rowUtente = $resultUtenti->fetch_assoc()) {
    $username = $rowUtente["Username"];
    $nome = isset($rowUtente["Nome"]) ? $rowUtente["Nome"] : "";
    $cognome = isset($rowUtente["Cognome"]) ? $rowUtente["Cognome"] : "";
    $dataDiNascita = isset($rowUtente["DataDiNascita"]) ? $rowUtente["DataDiNascita"] : "";
    $luogoDiNascita = isset($rowUtente["LuogoNascita"]) ? $rowUtente["LuogoNascita"] : "";
    $cellulare = isset($rowUtente["Cellulare"]) ? $rowUtente["Cellulare"] : "";
    $email = isset($rowUtente["Mail"]) ? $rowUtente["Mail"] : "";
    $saldo = 0; 
    
    // Query per ottenere il saldo dalla tabella Portafoglio
    $sqlSaldo = "SELECT Saldo FROM Portafoglio WHERE Username = '$username'";
    $resultSaldo = $conn->query($sqlSaldo);
    if ($resultSaldo->num_rows > 0) {
        $rowSaldo = $resultSaldo->fetch_assoc();
        $saldo = isset($rowSaldo["Saldo"]) ? $rowSaldo["Saldo"] : 0;
    } else {
        $saldo = 0;
    }

    // Aggiungi i dati dell'utente all'array degli utenti
    $utente = array(
        "username" => $username,
        "nome" => $nome,
        "cognome" => $cognome,
        "dataDiNascita" => $dataDiNascita,
        "LuogoNascita" => $luogoDiNascita,
        "cellulare" => $cellulare,
        "email" => $email,
        "saldo" => $saldo
    );

    // Aggiungi l'utente all'array degli utenti
    $utenti[] = $utente;
}

// 4. restituire i dati in formato JSON
header('Content-Type: application/json');
echo json_encode($utenti);

// 5. Chiudi la connessione
$conn->close();
?>
