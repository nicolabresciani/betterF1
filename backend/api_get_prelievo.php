<?php
// connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterF1";

$conn = new mysqli($servername, $username, $password, $dbname);

// verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Ottieni il nome utente dalla richiesta GET
$selectedUsername = $_GET['username'];

// Esegui la query per ottenere i prelievi correlati al nome utente
$sql = "SELECT Prelievo_Id, Data, Prelievo FROM Prelievo WHERE Portafoglio_Username = '$selectedUsername'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $prelievi = array();
    while ($row = $result->fetch_assoc()) {
        $prelievi[] = $row;
    }
    echo json_encode($prelievi);
} else {
    echo json_encode(array("message" => "Nessun prelievo trovato per l'utente"));
}

$conn->close();
?>
