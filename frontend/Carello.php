<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrello</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
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
    color: #333;
}
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}
th {
    background-color: #f2f2f2;
    font-weight: bold;
}
.scommetti-input {
    width: 80px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}
.action-cell {
    text-align: center;
}
.scommetti-button, .elimina-button {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    outline: none;
    transition: transform 0.2s ease-in-out;
}
.scommetti-button {
    background-color: #007bff;
    color: #fff;
}
.scommetti-button:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}
.elimina-button {
    background-color: #dc3545;
    color: #fff;
}
.elimina-button:hover {
    background-color: #bd2130;
    transform: translateY(-2px);
}
.scommetti-button:focus, .elimina-button:focus {
    box-shadow: 0 0 0 2px #007bff;
}
.date-cell {
    white-space: nowrap; /* Impedisce il testo di andare a capo */
}
.home-link {
    display: block;
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
    color: #333;
    font-weight: bold;
    transition: color 0.3s ease;
}
.home-link:hover {
    color: #007bff;
}
</style>
</head>
<body>
<div class="container">
    <h1>Carrello</h1>
    <table>
        <thead>
            <tr>
                <th>Pilota</th>
                <th>Quota</th>
                <th>Importo</th>
                <th>Possibile Vittoria</th>
                <th>Stato</th>
                <th>Data</th>
                <th>Azione</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- PHP per recupero dati dal database -->
            <?php
            session_start();
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "betterF1";
            if (!isset($_SESSION['username'])) {
                header("Location: ../frontend/Login.php");
                exit();
            }
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connessione fallita: " . $conn->connect_error);
            }
            $utenteUsername = $_SESSION['username'];
            $query = "SELECT Id, NominativoPilota, Quota FROM CarrelloProvvisorio WHERE Utente_Username = '$utenteUsername'";
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                // Array per memorizzare le quote
                $quote = array();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='row_" . $row["Id"] . "'>";
                    echo "<td>" . $row["NominativoPilota"] . "</td>";
                    echo "<td>" . $row["Quota"] . "</td>";
                    echo "<td> <input type='number' step='0.1' class='scommetti-input' id='importo_" . $row["Id"] . "' oninput='updatePossibleWin(this)' min='1' </td>";
                    echo "<td class='possibile-vittoria'></td>";
                    echo "<td>Aperta</td>";
                    echo "<td class='date-cell'>" . date("Y-m-d") . "</td>";
                    echo "<td class='action-cell'>";
                    echo "<button id='scommetti_button_" . $row["Id"] . "' class='scommetti-button' onclick='scommetti(" . $row["Id"] . ", " . $row["Quota"] . ")'>Scommetti</button>";
                    echo "<button class='elimina-button' onclick='eliminaScommessa(" . $row["Id"] . ")'>Elimina</button>";
                    echo "</td>";
                    echo "</tr>";
                    // Aggiungi la quota all'array delle quote
                    $quote[$row["Id"]] = $row["Quota"];
                }
                // Trasforma l'array PHP in un array JavaScript
                echo "<script>var quote = " . json_encode($quote) . ";</script>";
            } else {
                $query = "SELECT  NominativoPilota FROM CarrelloProvvisorio WHERE Utente_Username = '$utenteUsername'";
                $queryDatiCarrello = "SELECT * FROM Carrello WHERE Utente_Username = '$utenteUsername'";
                $result = $conn->query($queryDatiCarrello);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr id='row_" . $row["Id"] . "'>";
                    echo "<td>" . $row["NominativoPilota"] . "</td>";
                    echo "<td>" . $row["Quota"] . "</td>";
                    echo "<td> <input type='number' step='0.1' class='scommetti-input' id='importo_" . $row["Id"] . "' oninput='updatePossibleWin(this)' min='1' </td>";
                    echo "<td class='possibile-vittoria'></td>";
                    echo "<td>Aperta</td>";
                    echo "<td class='date-cell'>" . date("Y-m-d") . "</td>";
                    echo "<td class='action-cell'>";
                    echo "</td>";
                    echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Nessun elemento nel carrello provvisorio.</td></tr>";
                }
            }
            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="../frontend/Home.php" class="home-link">Torna alla pagina Home</a>
</div>

<script>
    function updatePossibleWin(input) {
        var id = input.id.split("_")[1];
        var importo = parseFloat(input.value); // Converti l'importo in un numero
        // Verifica se l'importo è inferiore a 1 e se sì, imposta il valore a 1
        if (importo < 1) {
            importo = 1;
            input.value = importo; // Imposta il valore dell'input a 1
        }
        var quota = quote[id]; // Recupera la quota dall'array JavaScript
        var possibileVittoria = (importo * quota).toFixed(2); // Limita la vittoria a due decimali
        input.parentNode.nextElementSibling.innerHTML = possibileVittoria;
    }

    function scommetti(id, quota) {
        var importo = parseFloat(document.getElementById('importo_' + id).value); // Converti l'importo in un numero
        var possibileVittoria = (importo * quota).toFixed(2); // Limita la vittoria a due decimali
        
        // Invia i dati al server per l'elaborazione della scommessa utilizzando AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200){
                confermato = mostraScommessaConfermata(id);
                if(confermato == true){
                    var xhrState = new XMLHttpRequest();
                    xhrState.open("POST", "../backend/scommetti.php", true);
                    xhrState.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhrState.send("id=" + id + "&stato=true"); // Invia lo stato TRUE al server
                }
            }
        };
        xhr.open("POST", "../backend/scommetti.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("importo=" + importo + "&id=" + id + "&quota=" + quota);
    }


    function mostraScommessaConfermata(id) {
            // Chiedi all'utente se desidera confermare la scommessa
            var conferma = confirm("Vuoi confermare la scommessa nel carrello?");
            if (conferma) {
                // Disabilita il pulsante "Scommetti" e lascia i dati della schedina
                var button = document.getElementById('scommetti_button_' + id);
                button.disabled = true;
                button.innerText = 'Confermata';
                
                // Nascondi il pulsante "Elimina"
                var deleteButton = document.querySelector('#row_' + id + ' .elimina-button');
                deleteButton.style.display = 'none';
                return true;
            } else {
                // Rimuovi la riga corrispondente dal carrello provvisorio
                var rowToRemove = document.getElementById('row_' + id);
                rowToRemove.parentNode.removeChild(rowToRemove);
                return false;
            }
    }

    // JavaScript - Modifica della funzione eliminaScommessa() per aggiornare lo stato della schedina nel database quando viene eliminata
    function eliminaScommessa(id) {
        // Invia una richiesta AJAX per aggiornare lo stato della schedina nel database
        var xhrState = new XMLHttpRequest();
        xhrState.open("POST", "../backend/scommetti.php", true);
        xhrState.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhrState.onreadystatechange = function() {
            if (xhrState.readyState === 4 && xhrState.status === 200) {
                // Rimuovi la riga corrispondente dal DOM
                var rowToRemove = document.getElementById('row_' + id);
                rowToRemove.parentNode.removeChild(rowToRemove);
            }
        };
        xhrState.send("id=" + id + "&stato=false"); // Invia lo stato FALSE al server
    }

</script>

</body>
</html>