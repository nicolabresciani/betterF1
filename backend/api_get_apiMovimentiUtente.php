<?php
// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterF1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ottieni il nome utente dalla richiesta GET
$selectedUsername = $_GET['username'];

// Query per ottenere i prelievi correlati al nome utente
$sqlPrelievi = "SELECT Data, Prelievo AS Importo, 'Prelievo' AS Tipo FROM Prelievo WHERE Portafoglio_Username = '$selectedUsername'";
$resultPrelievi = $conn->query($sqlPrelievi);

// Query per ottenere i depositi correlati al nome utente
$sqlDepositi = "SELECT Data, Importo, 'Deposito' AS Tipo FROM Deposito WHERE Portafoglio_Username = '$selectedUsername'";
$resultDepositi = $conn->query($sqlDepositi);

if ($resultPrelievi->num_rows > 0 || $resultDepositi->num_rows > 0) {
    $movimenti = array();

    // Aggiungi i prelievi all'array
    while ($rowPrelievi = $resultPrelievi->fetch_assoc()) {
        $movimenti[] = $rowPrelievi;
    }

    // Aggiungi i depositi all'array
    while ($rowDepositi = $resultDepositi->fetch_assoc()) {
        $movimenti[] = $rowDepositi;
    }

    // Ordina l'array di movimenti per data in ordine decrescente
    usort($movimenti, function($a, $b) {
        return strtotime($b['Data']) - strtotime($a['Data']);
    });

    echo json_encode($movimenti);
} else {
    echo json_encode(array("message" => "Nessun movimento trovato per l'utente"));
}

$conn->close();
?>
