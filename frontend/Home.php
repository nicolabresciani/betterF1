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
            font-family: Arial, sans-serif;
        }

        header {
            background-color: blue;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .header {
            display: flex;
        }

        .header form {
            margin-left: 10px;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        button:hover {
            background-color: #333;
        }

        /* Aggiunto stile per l'immagine */
        .logo-container {
            text-align: center;
            position: relative;
        }

        .logo-container img {
            width: 200px; /* Imposta la larghezza desiderata */
            display: block;
            position: absolute;
            bottom: 20px; /* Sposta l'immagine più in alto rispetto al fondo */
            right: 50px; /* Sposta l'immagine leggermente più a destra */
        }


    </style>
</head>
<body>
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
<header>
    <div>
        <div class="form"> <!-- Div aggiunto -->
            <span>Benvenuto, <?php echo $username; ?>! Saldo: <?php echo $saldoAttuale; ?> EUR</span>
        </div>
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

<div class="logo-container">
    <h1>Formula 1</h1> <!-- Titolo qui -->
</div>

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
    <form action="../frontend/PrimoRitirato.php" method="post">
        <button type="submit">primo ritirato</button>
    </form>
    <form action="../frontend/PrimoPitStop.php" method="post">
        <button type="submit">primo pit-stop</button>
    </form>
</div>
<!--
<div>
    <button onclick="startTimer()">Avvia Simulazione</button>
    <div id="timer"></div>
</div>

<script>
    function startTimer() {
        var duration = 0.1 * 60; // Durata in secondi (1 minuto)
        var timerDisplay = document.getElementById("timer");

        var timer = setInterval(function () {
            var minutes = Math.floor(duration / 60);
            var seconds = duration % 60;

            // Formatta il tempo rimanente come mm:ss
            var formattedTime = minutes.toString().padStart(2, '0') + ":" + seconds.toString().padStart(2, '0');
            timerDisplay.textContent = formattedTime;

            if (duration-- < 0) {
                clearInterval(timer);
                //timerDisplay.textContent = "Ciao";
                var img = document.createElement("img");
                img.src = "../frontend/Img/monza.png";
                img.alt = "Monza";
                img.style.width = "500px"; // Ridimensiona l'immagine
                img.style.display = "block";
                img.style.position = "absolute";
                img.style.bottom = "160px"; // Sposta l'immagine più in alto rispetto al fondo
                img.style.right = "90px"; // Sposta l'immagine leggermente più a destra
                img.style.left = "320px";
                document.body.appendChild(img);
            }
        }, 1000); // Esegui la funzione ogni secondo
    }
</script>
-->
</body>
</html>
