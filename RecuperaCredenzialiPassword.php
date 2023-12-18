<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia Password</title>
    
</head>
<body>
    <form method="post" action="RecuperaCredenzialiPasswordController.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="Nome">Nome:</label>
        <input type="text" name="Nome" required>
        <br>
        <label for="Cognome">Cognome:</label>
        <input type="text" name="Cognome" required>
        <br>
        <label for="Password">Inserire nuova password:</label>
        <input type="password" name="Password" required><br>
        <label for="ConfermaPassword">Conferma nuova password:</label>
        <input type="password" name="ConfermaPassword" required><br>
        <input type="submit" value="Registra nuova password">
    </form>
</body>
</html>
