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
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home</title>
    </head>
    <body>
        <h1>Benvenuto, <?php echo $username; ?>!</h1>
        <p>benvenuto nella pagina riservata ai sotto Amministratori</p>
        <a href="Logout.php">Logout</a>
    </body>
</html>