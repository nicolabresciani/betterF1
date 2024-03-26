
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrello</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .saldo {
        margin-bottom: 20px;
    }
    .saldo span {
        font-weight: bold;
    }
    .home-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }
</style>
</head>
<body>

<div class="container">
    <h1>Carrello</h1>
                 <!-- PHP per recupero dati dal database -->
            <?php
            session_start();

            // Connessione al database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "betterF1";

            // Verifica se l'utente è loggato
            if (!isset($_SESSION['username'])) {
                header("Location: ../frontend/Login.php");
                exit();
            }

            // Connessione al database
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }

            // Recupera l'username dell'utente loggato
            $utenteUsername = $_SESSION['username'];
            

            // Query per selezionare i dati dal carrello provvisorio dell'utente
            $query = "SELECT NominativoPilota, Quota FROM CarrelloProvvisorio WHERE Utente_Username = '$utenteUsername'";
            $result = $conn->query($query);

            // Verifica se sono presenti risultati
            if ($result->num_rows > 0) {
                // Stampa i dati nella tabella del carrello
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["NominativoPilota"] . "</td>";
                    echo "<td>" . $row["Quota"] . "</td>";
                    // Aggiungi campo di input per l'importo scommesso
                    echo "<td><input type='text' id='importo_" . $row["Id"] . "'></td>";
                    // Calcola il possibile importo della vittoria basato sull'importo scommesso e sulla quota
                    echo "<td>" . $row["Quota"] * 100 . "</td>";
                    echo "<td>Aperta</td>";
                    echo "<td>" . date("Y-m-d") . "</td>";
                    // Aggiungi pulsante "Scommetti" e associa la funzione scommetti() al suo click
                    echo "<td><button onclick='scommetti(" . $row["Id"] . ")'>Scommetti</button></td>";
                    echo "</tr>";
                }
            } else {
                // Nessun risultato trovato nel carrello provvisorio
                echo "<tr><td colspan='7'>Nessun elemento nel carrello provvisorio.</td></tr>";
            }

            // Chiudi la connessione
            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="../frontend/Home.php" class="home-link">Torna alla pagina Home</a>
</div>

<!-- Aggiunto script JavaScript per gestire il click del pulsante "Scommetti" -->
<script>
    // Funzione per gestire il click del pulsante "Scommetti"
    function scommetti(id) {
        var importo = document.getElementById('importo_' + id).value;
        // Invia i dati al server per l'elaborazione della scommessa
        // Puoi usare AJAX per inviare i dati al server
    }
</script>

</body>
</html>