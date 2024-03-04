<!DOCTYPE html> 
<html lang="it"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Home</title> 
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f1f1;
            color: #333;
        }

        header {
            background-color: #e10600;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            text-align: center;
            margin: 0;
            color: #fff;
            font-size: 28px;
            text-transform: uppercase;
        }

        .header-buttons {
            display: flex;
        }

        form {
            margin: 0 10px;
        }

        button {
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
            text-transform: uppercase;
        }

        button:hover {
            background-color: #111;
        }
    </style>
</head> 
<body> 
    <header>
        <h1 class="header-title">Formula 1</h1>
        <div class="header-buttons">
            <form action="Registra.php" method="post">
                <button type="submit">Iscriviti</button>
            </form>
            <form action="Login.php" method="post">
                <button type="submit">Accedi</button>
            </form>
        </div>
    </header>
</body>
</html>
