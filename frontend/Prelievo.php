<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposito Virtuale</title>
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
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #4caf50;
        }

    </style>
</head>
<body>

    <form action="../backend/PrelievoController.php" method="post">
        <label for="importo">Prelievo:</label>
        <input type="number" name="importo" step="1" min="0" required>

        <label for="numero_carta">Numero della Carta:</label>
        <input type="text" name="numero_carta" maxlength="16">

        <label for="scadenza_carta">Scadenza della Carta (MM/YYYY):</label>
        <input type="text" name="scadenza_carta" required>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" required>

        <input type="submit" value="Effettua Deposito">
        <a href="Home.php">torna alla home</a>
    </form>
</body>
</html>
