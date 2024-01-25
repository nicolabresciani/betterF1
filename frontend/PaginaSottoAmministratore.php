<?php
session_start(); // Inizia la sessione

// Controlla se l'admin è loggato
if(isset($_SESSION["username"])) {
    $nome_admin = $_SESSION["username"]; // Ottieni il nome dell'admin dalla sessione
} else {
    header("Location: ../frontend/Login.php"); // Reindirizza alla pagina di login se l'admin non è loggato
    exit;
}

$username = $_SESSION["username"];
?>

<!DOCTYPE html> 
<html> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Pagina Sotto Amministratore</title> 
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: cursive, sans-serif;
        }

        header, .header {
            background-color: blue;
            padding: 10px;
            display: flex;
            color: white;
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
        }

        button:hover {
            background-color: black;
        }

        .content-container {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .user-management, .bet-management {
            flex-grow: 1; /* Imposta lo spazio flessibile uguale per entrambi */
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .bet-management {
            margin-left: 10px; /* Aggiunge uno spazio tra le sezioni */
        }
    </style>
</head>
<body> 
    <header>
        <div>
            <span>Sei nella pagina Sotto amministratore</span> <br>
            <span>Benvenuto, <?php echo $username; ?>!</span>
        </div>
        <div class="header">
            <form action="../frontend/Logout.php" method="post">
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <div class="content-container">
        <a href="../frontend/GestioneUtenti.php" class="section-link">
            <div class="user-management">
                <h2>Gestione Utenti</h2>
            </div>
        </a>

        <a href="../frontend/gestioneScommesse.php" class="section-link">
            <div class="bet-management">
                <h2>Gestione Scommesse</h2>
            </div>
        </a>

        <a href="../frontend/GestioneMovimenti.php" class="section-link">
            <div class="bet-management">
                <h2> Gestione Movimenti </h2>
            </div>
        </a>
    </div>
</body>
</html>

