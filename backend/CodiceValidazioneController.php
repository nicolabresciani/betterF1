<?php
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
    // Ottieni il codice di verifica dalla richiesta GET
    $codiceInput = $_GET["codice"];

    // Query per ottenere il codice di verifica dalla tabella Utente
    $query = "SELECT CodiceValidazione FROM Utente WHERE CodiceValidazione = '$codiceInput'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Il codice è valido
        $row = $result->fetch_assoc();
        $response = array("valido" => true, "codice" => $row['CodiceValidazione']);
        echo json_encode($response);
    } else {
        // Il codice non è valido
        $response = array("valido" => false);
        echo json_encode($response);
    }
}

// Chiudi connessione al database
$conn->close();
?>
