<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Account Utente</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: cursive, sans-serif;
        }

        header, .header {
            background-color: blue;
            padding: 10px;
            display: flex;
            color: white;
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
        }

        button:hover {
            background-color: black;
        }
    </style>
</head>
<body>
    <script>
        //vorrei che l'admin posso gestire l'account dell'utente. 
        //ovvero l'admin può sospendere l'account dell'utente e sospendere il portafoglio dell'utente

        //funzione per sospendere l'account dell'utente
        function sospendiAccountUtente() {
            //chiedo all'admin di inserire l'username dell'utente
            var username = prompt("Inserisci l'username dell'utente che vuoi sospendere");
            //chiedo all'admin di inserire il motivo della sospensione
            var motivo = prompt("Inserisci il motivo della sospensione");
            //invio i dati al backend
            fetch('backend/SospendiAccountUtenteController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username: username, motivo: motivo }),
            })
                .then(response => response.json())
                .then(data => {
                    //mostro un messaggio di conferma
                    alert(data.message);
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }  
    </script>
</body>


