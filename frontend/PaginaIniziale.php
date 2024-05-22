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
                font-family: Arial, sans-serif;
                background-color: #f4f4f4; /* sfondo cambiato in grigio chiaro */
            }

            header,.header {
                background-color: #333;
                padding: 10px;
                display: flex;
                color:white;
                justify-content: center;
                align-items: center;
            }

            h1 {
                text-align: center;
                color: #333;
            }

            .header {
                text-align: center;
                margin-top: 20px;
                display: flex;
                justify-content: center; /* centra i pulsanti orizzontalmente */
                align-items: center;
            }

            button {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
                margin-right: 5px; 
            }
            button:hover {
                background-color: #45a049;
            }
        </style>
    </head> 
    <body> 
        <header>
            <div>
                
            </div>
            <div class="header">
                <form action="Registra.php" method="post">
                    <button type="submit">Registra</button>
                </form>
                <form action="Login.php" method="post">
                    <button type="submit">Accedi</button>
                </form>
            </div>
        </header>
    </body>
</html>