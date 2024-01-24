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

// Ottieni l'username dell'utente
$username = $_POST['username'];

// Verifica che l'ID dell'utente sia stato fornito
if (!isset($_POST['username'])) {
    echo json_encode(array("success" => false, "message" => "Username not provided"));
    exit;
}


// Esegui la query di eliminazione
$sql = "DELETE FROM Utente WHERE username = ?";
$stmt = $conn->prepare($sql);

// Verifica che la query sia stata eseguita con successo
if ($stmt) {
    $stmt->bind_param("s", $username);
    $stmt->execute();

    //echo json_encode(array("success" => true, "message" => "User deleted successfully"));
} else {
    echo json_encode(array("success" => false, "message" => "Error during query execution"));
}

$stmt->close();
$conn->close();
?>
