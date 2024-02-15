<?php
header("Content-Type: application/json");

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

// Se c'è un parametro 'search', esegui la query di ricerca
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT Username, Nome, Cognome, DataDiNascita, LuogoNascita, Cellulare, Mail, Ruolo FROM Utente WHERE Username LIKE '%$search%' OR Nome LIKE '%$search%' OR Cognome LIKE '%$search%'";
} else {
    // Altrimenti, esegui la query per ottenere tutti gli utenti
    $sql = "SELECT Username, Nome, Cognome, DataDiNascita, LuogoNascita, Cellulare, Mail, Ruolo FROM Utente";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $users = array();

    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    echo json_encode($users);
} else {
    echo json_encode(array("message" => "Nessun utente trovato"));
}

$conn->close();
?>
