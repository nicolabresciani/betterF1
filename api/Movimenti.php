<?php
// Tirare fuori i dati dell'utente con aggiunta dei movimenti del prelievo e deposito
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

    // Query per ottenere il saldo dalla tabella Portafoglio
    $sqlSaldo = "SELECT Saldo FROM Portafoglio WHERE Username = '$username'";
    $resultSaldo = $conn->query($sqlSaldo);
    if ($resultSaldo->num_rows > 0) {
        $rowSaldo = $resultSaldo->fetch_assoc();
        $saldo = isset($rowSaldo["Saldo"]) ? $rowSaldo["Saldo"] : 0;
    } else {
        $saldo = 0;
    }

    // Query per ottenere i movimenti di deposito
    $sqlMovimentiDeposito = "SELECT * FROM Deposito WHERE Portafoglio_Username = '$username'";
    $resultMovimentiDeposito = $conn->query($sqlMovimentiDeposito);

    // Query per ottenere i movimenti di prelievo
    $sqlMovimentiPrelievo = "SELECT * FROM Prelievo WHERE Portafoglio_Username = '$username'";
    $resultMovimentiPrelievo = $conn->query($sqlMovimentiPrelievo);

    // Array per contenere i movimenti dell'utente
    $movimenti = array();

    // Iterazione sui risultati della query per estrarre i movimenti di deposito dell'utente
    while ($rowMovimentoDeposito = $resultMovimentiDeposito->fetch_assoc()) {
        $movimenti[] = array(
            "tipo" => "Deposito",
            "data" => $rowMovimentoDeposito["Data"],
            "importo" => $rowMovimentoDeposito["Importo"] // Correzione qui
        );
    }

    // Iterazione sui risultati della query per estrarre i movimenti di prelievo dell'utente
    while ($rowMovimentoPrelievo = $resultMovimentiPrelievo->fetch_assoc()) {
        $movimenti[] = array(
            "tipo" => "Prelievo",
            "data" => $rowMovimentoPrelievo["Data"],
            "importo" => $rowMovimentoPrelievo["Prelievo"]
        );
    }

    // Aggiungi i dati dell'utente all'array degli utenti
    $utenti[] = array(
        "username" => $username,
        "nome" => $nome,
        "cognome" => $cognome,
        "dataDiNascita" => $dataDiNascita,
        "LuogoNascita" => $luogoDiNascita,
        "cellulare" => $cellulare,
        "email" => $email,
        "saldo" => $saldo,
        "movimenti" => $movimenti
    );
}

// Chiudi la connessione
$conn->close();

// Restituisci i dati degli utenti in formato JSON
header('Content-Type: application/json');
echo json_encode($utenti);
?>
