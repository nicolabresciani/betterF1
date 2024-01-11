<?php
session_start(); // Inizia la sessione
if(isset($_SESSION["username"])) { // Controlla se l'admin è loggato
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
        <title>Pagina sottoAmministratore</title> 
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
                <span> Sei nella pagina sotto amministratore </span> <br>
                <span>Benvenuto, <?php echo $username; ?>!</span>
            </div>
            <div class="header">
                <form action="../frontend/Logout.php" method="post">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </header>
    </body>
</html>