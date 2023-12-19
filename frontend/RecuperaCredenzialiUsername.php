<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia Credenziali</title>
    
</head>
<body>
    <form method="post" action="RecuperaCredenzialiUsernameController.php">
        <label for="Nome">Nome:</label>
        <input type="text" name="Nome" required>
        <br>
        <label for="Cognome">Cognome:</label>
        <input type="text" name="Cognome" required>
        <br>
        <label for="Password">Password:</label>
        <input type="password" name="Password" required>
        <br>
        <label for="NuovoUsername">Nuovo username:</label>
        <input type="text" name="NuovoUsername" required>
        <br>
        <label for="ConfermaNuovoUsername">Conferma nuovo username:</label>
        <input type="text" name="ConfermaNuovoUsername" required>
        <br>
        <input type="submit" value="Registra nuove credenziali">
    </form>
</body>
</html>
