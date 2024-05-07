<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storico Scommesse</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            overflow-y: auto;
            position: relative; /* Per il posizionamento assoluto */
            max-width: 800px; /* Limite massimo per il contenitore */
            margin: auto; /* Centra il contenitore orizzontalmente */
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
        .home-button-container {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #fff;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .home-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        /* Stile per i pulsanti "Seleziona Data" */
        .select-date-button {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .select-date-button:hover {
            background-color: #0056b3;
        }

        /* Stili per rendere responsive */
        @media screen and (max-width: 600px) {
            /* Riduci il padding del corpo e del contenitore */
            body, .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="home-button-container">
            <button class="home-button" onclick="window.location.href='../frontend/Home.php'">Torna alla Home</button>
        </div>

        <h1>Storico delle Scommesse</h1>

        <form method="POST" action="">

            <label for="dataInizio">Data di Inizio:</label>
            <input type="date" id="dataInizio" name="dataInizio" required>

            <label for="dataFine">Data di Fine:</label>
            <input type="date" id="dataFine" name="dataFine" required>

            <button type="button" id="submitButton">Visualizza Scommesse</button>
        </form>
    
        <?php
        session_start();
        // Verifica se l'utente è loggato
        if(isset($_SESSION['username'])) {
            if(isset($_POST['dataInizio']) && isset($_POST['dataFine'])) {
                $dataInizio = $_POST['dataInizio'];
                $dataFine = $_POST['dataFine'];
    
                $Username = $_SESSION['username'];
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "betterF1";
    
                $conn = new mysqli($servername, $username, $password, $dbname);
    
                // Verifica della connessione
                if ($conn->connect_error) {
                    die("Connessione fallita: " . $conn->connect_error);
                }
    
                $sql = "SELECT * FROM Scommessa WHERE Utente_Username = '$Username' AND Data BETWEEN '$dataInizio' AND '$dataFine'";
                $result = $conn->query($sql);
    
                if ($result->num_rows > 0) {
                    // Output dei risultati
                    echo "<table>";
                    echo "<tr><th>ID</th><th>ID Scommessa</th><th>Importo Scommesso</th><th>Importo Vinto</th><th>Stato</th><th>Data</th><th>Quota</th><th>Scelta</th><th>Campo di Scommessa</th><th>Nominativo</th></tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>".$row["Id"]."</td><td>".$row["Id_Scommessa"]."</td><td>".$row["ImportoScommesso"]."</td><td>".$row["ImportoVinto"]."</td><td>".$row["StatoScommessa"]."</td><td>".$row["Data"]."</td><td>".$row["Quota_Id"]."</td><td>".$row["Scelta"]."</td><td>".$row["CampoDiScommessa"]."</td><td>".$row["nominativo"]."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p class='error'>Nessuna scommessa trovata nell'intervallo selezionato.</p>";
                }
    
                // Chiusura della connessione
                $conn->close();
            } else {
                echo "<p class='error'>Seleziona un intervallo di date per visualizzare le scommesse.</p>";
            }
        } else {
            echo "<p class='error'>Effettua il login per visualizzare lo storico delle scommesse.</p>";
        }
        ?>

        <script>
            document.getElementById('submitButton').addEventListener('click', function() {
                var dataInizio = document.getElementById('dataInizio').value;
                var dataFine = document.getElementById('dataFine').value;

                if(dataInizio && dataFine) {
                    document.querySelector('form').submit();
                } else {
                    alert('Seleziona entrambe le date per visualizzare le scommesse.');
                }
            });
        </script>
    </div>
</body>
</html>
