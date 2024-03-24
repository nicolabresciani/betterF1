<?php
header("Content-Type: application/json");

// Verifica se l'username dell'utente è stato fornito
if (!isset($_POST['username'])) {
    echo json_encode(array("success" => false, "message" => "Username not provided"));
    exit;
}

// Ottieni l'username dell'utente
$user_input = $_POST['username'];

// Connessione al database
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "betterF1";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    echo json_encode(array("success" => false, "message" => "Connection failed: " . $conn->connect_error));
    exit;
}

// Esegui la query per sospendere l'utente
$sql = "UPDATE Utente SET Stato = 'attivo' WHERE Username = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $user_input);
    if ($stmt->execute()) {
        echo json_encode(array("success" => true, "message" => "User suspended successfully"));
    } else {
        echo json_encode(array("success" => false, "message" => "Error suspending user"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Error preparing statement"));
}

$stmt->close();
$conn->close();
?>
