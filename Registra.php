<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
</head>
<body>
    <form method="post" action="RegistraController.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>
        <br>
        <label for="cognome">Cognome:</label>
        <input type="text" name="cognome" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="dataDiNascita">Data di Nascita:</label>
        <input type="date" name="dataDiNascita" required>
        <br>
        <label for="luogoNascita">Luogo di Nascita:</label>
        <input type="text" name="luogoNascita" required>
        <br>
        <label for="cellulare">Cellulare:</label>
        <input type="text" name="cellulare" maxlength="10" required>
        <br>
        <label for="mail">Mail:</label>
        <input type="email" name="mail" required>
        <br>
        <label for="ruolo">Ruolo:</label>
        <input type="text" name="ruolo" required>
        <br>
        <input type="submit" value="Registrati">
    </form>
</body>
</html>
