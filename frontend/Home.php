<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION["username"])) {
    header("Location: Login.php");
    exit();
}


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



        </style>
    </head> 
    <body> 
        <header>
            <div>
                <span>Benvenuto, <?php echo $username; ?>!</span>
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

