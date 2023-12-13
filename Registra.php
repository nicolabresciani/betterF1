<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .login-link {
            text-align: center;
            margin-top: 12px;
        }

        .login-link a {
            color: #4caf50;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
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
    <div class="login-link">
        <form method="post" action="Login.php">
            <input type="submit" value="Hai già un account? Accedi">
        </form>
    </div>
</body>
</html>
