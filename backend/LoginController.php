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

// Funzione per verificare l'autenticità dell'utente
function verificaAutenticitaUtente($conn, $username, $password) {
    
    $verifica = "SELECT * FROM Utente WHERE Username='$username' AND password='$password'";
    $result = $conn->query($verifica);

    return $result->num_rows > 0;
}
function verificaAutenticitaSottoAmministratore($conn, $username, $password) {
    
    $verifica = "SELECT * FROM SottoAmministratore WHERE Username='$username' AND password='$password'";
    $result = $conn->query($verifica);

    return $result->num_rows > 0;
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
    } else {
        echo "Errore: Nome utente o password non validi.";
    }
}

// Chiudi connessione database
$conn->close();
?>
