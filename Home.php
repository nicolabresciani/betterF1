<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION["username"])) {
    header("Location: Login.php");
    exit();
}

/*
/* 
<form action="" method="post">
            <label for="azione">Seleziona un'azione:</label>
            <select name="azione" id="azione">
                <option value="deposito">Deposito</option>
                <option value="prelievo">Prelievo</option>
            </select>
            <button type="submit">Esegui</button>
        </form>
*/

$username = $_SESSION["username"];
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
                font-family: Arial, sans-serif;
            }

            header,.header {
                background-color: #333;
                color: #fff;
                padding: 10px;
                display: flex;
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
                background-color: green;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
                margin-right: 5px; 
                float: right; /* aggiunto */
            }
            button:hover {
                background-color: lightgreen;
            }



        </style>
    </head> 
    <body> 
        <header>
            <div>
                <span>Benvenuto, <?php echo $username; ?>!</span>
            </div>
            <div class="header">
                <form action="Logout.php" method="post">
                    <button type="submit">Logout</button>
                </form>
                <div class=".header">
                    <a href="Portafoglio.php">
                        <img src="portafoglio.png" width="44" height="44">
                    </a>
                </div>
            </div>
        </header>
    </body>
</html>

