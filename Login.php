<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="post" action="LoginController.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Login"><br>
        <a href="RecuperaCredenzialiPassword.php">Hai dimenticato la password ?</a><br><br>
        <a href="RecuperaCredenzialiUsername.php">Hai dimenticato lo username ?</a>

    </form>
</body>
</html>
