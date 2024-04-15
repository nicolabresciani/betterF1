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
            body {
                margin: 0;
                padding: 0;
                font-family: cursive, sans-serif;
            }

            header,.header {
                background-color: blue;
                padding: 10px;
                display: flex;
                color:white;
                justify-content: space-between;
                align-items: center;
            }

            h1 {
                text-align: center;
            }

            form {
                text-align: center;
                margin-top: 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            button {
                background-color: black;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
                margin-right: 5px; 
                float: right; /* aggiunto */
            }
            button:hover {
                background-color: black;
            }
            .scommesse-container {
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .scommesse-container form {
                margin-right: 10px;
            }
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
                <form action="../frontend/Carello.php" method="post">
                    <button type="submit">Carello</button>
                </form>
                <form action="../frontend/MovimentiUtente.php" method="post">
                    <button type="submit">movimenti</button>
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
    <div>
        <h1>formula 1</h1>
        <div class="scommesse-container">
            <form action="../frontend/VincitoreMondialePiloti.php" method="post">
                <button type="submit">vincitore mondiale piloti</button>
            </form>
            <form action="../frontend/VincitoreMondialeScuderia.php" method="post">
                <button type="submit">vincitore mondiale scuderia</button>
            </form>
            <form action="../frontend/MiglioreGruppo.php" method="post">
                <button type="submit">migliore del gruppo</button>
            </form>
        </div>



        
    
    </div>


</html>