<?php
// Funzione per verificare l'autenticità dell'utente
function verificaAutenticitaUtente($conn, $username, $password) {
    // Prepara la query per selezionare l'utente con username e password forniti
    $verifica = "SELECT * FROM Utente WHERE Username='$username' AND password='$password'";
    
    // Esegue la query
    $result = $conn->query($verifica);

    // Verifica se l'utente è stato trovato
    if ($result->num_rows > 0) {
        // Ottieni i dettagli dell'utente
        $row = $result->fetch_assoc();
        
        // Verifica lo stato dell'utente
        if ($row["Stato"] == "attivo") {
            return true; // Utente autenticato e attivo
        } else {
            return "sospeso"; // Utente trovato ma stato non attivo
        }
    } else {
        return false; // Utente non trovato
    }
}
function verificaAutenticitaSottoAmministratore($conn, $username, $password) {
    
    $verifica = "SELECT * FROM SottoAmministratore WHERE Username='$username' AND password='$password'";
    $result = $conn->query($verifica);

    return $result->num_rows > 0;
}

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
    if (verificaAutenticitaUtente($conn, $username, $password)) {
        // Inizializza la sessione
        session_start();

        // Memorizza l'username nella sessione
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;

        // Reindirizza alla home
        header("Location: ../frontend/Home.php");
        exit();
    } elseif (verificaAutenticitaSottoAmministratore($conn, $username, $password)) {
        // Inizializza la sessione
        session_start();

        // Memorizza l'username nella sessione
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;

        // Reindirizza alla pagina del SottoAmministratore
        header("Location: ../frontend/PaginaSottoAmministratore.php");
        exit();
    } elseif ($auth_result === "sospeso") {
        echo "account attualmente sospeso";
    } else {
        echo "Errore: Nome utente o password non validi.";
    }
}

// Chiudi connessione database
$conn->close();
?>
