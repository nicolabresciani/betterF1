<?php
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

// Verifica se l'utente è autenticato
if (!isset($_SESSION["username"])) {
    header("Location: Login.php");
    exit();
}

$username = $_SESSION["username"];

// Query per ottenere il saldo corrente
$sqlSaldo = "SELECT Saldo FROM Portafoglio WHERE Username = '$username'";
$resultSaldo = $conn->query($sqlSaldo);

if ($resultSaldo === false) {
    die("Errore nella query: " . $conn->error);
}

if ($resultSaldo->num_rows > 0) {
    $rowSaldo = $resultSaldo->fetch_assoc();
    $saldoAttuale = $rowSaldo["Saldo"];
} else {
    $saldoAttuale = 0; // Imposta il saldo a 0 se non viene trovato
}

?>
<!DOCTYPE html> 
<html> 
    <head> 
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Home</title> 
        <style>
            /* Styles here */
        </style>
    </head> 
    <body> 
        <header>
            <div>
                <span>Benvenuto, <?php echo $username; ?>! Saldo: <?php echo $saldoAttuale; ?> EUR</span>
            </div> 
            <div class="header">
                <form action="../frontend/Logout.php" method="post">
                    <button type="submit">Logout</button>
                </form>
                <form action="../frontend/Prelievo.php" method="post">
                    <button type="submit">Prelievo</button>
                </form>
                <form action="../frontend/Deposito.php" method="post">
                    <button type="submit">Deposito</button>
                </form>
            </div>
        </header>
    </body>
</html>