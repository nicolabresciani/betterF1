<?php
// Funzione per verificare l'autenticità dell'utente
function verificaAutenticitaUtente($conn, $username, $password) {
    // Prepara la query per selezionare l'utente con username e password forniti
    $verifica = "SELECT * FROM Utente WHERE Username='$username' AND Password='$password'";
    
    // Esegue la query
    $result = $conn->query($verifica);

    // Verifica se l'utente è stato trovato
    if ($result->num_rows > 0) {
        // Ottieni i dettagli dell'utente
        $row = $result->fetch_assoc();
        
        // Verifica lo stato dell'utente
        if ($row["Stato"] == "attivo" && $row["Ruolo"] == "Utente Normale") {
            return true; // Utente autenticato e attivo
        } else {
            return $row["Stato"]; // Utente trovato ma stato non attivo
        }
    } else {
        return false; // Utente non trovato
    }
}

function verificaAutenticitaSottoAmministratore($conn, $username, $password) {
    $verifica = "SELECT * FROM SottoAmministratore WHERE Username='$username' AND Password='$password'";
    $result = $conn->query($verifica);

    return $result->num_rows > 0;
}

// Start the session
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    // Verifica se l'utente è un "Utente"
    $auth_result = verificaAutenticitaUtente($conn, $username, $password);
    if ($auth_result === true) {
        // Inizializza la sessione
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;

        // Reindirizza alla home
        header("Location: ../frontend/Home.php");
        exit();
    } elseif (verificaAutenticitaSottoAmministratore($conn, $username, $password)) {
        // Inizializza la sessione
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;

        // Reindirizza alla pagina del SottoAmministratore
        header("Location: ../frontend/PaginaSottoAmministratore.php");
        exit();
    } elseif ($auth_result === "sospeso") {
        $_SESSION["error"] = "Account attualmente sospeso";
        header("Location: ../frontend/Login.php");
        exit();
    } else {
        $_SESSION["error"] = "Errore: Nome utente o password non validi.";
        header("Location: ../frontend/Login.php");
        exit();
    }
}

// Chiudi connessione database
$conn->close();
