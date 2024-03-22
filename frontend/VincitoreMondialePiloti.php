<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vincitore Mondiale Piloti</title>
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
    td input {
        width: 60px;
        padding: 5px;
        box-sizing: border-box;
        text-align: center;
        border: none;
        border-radius: 4px;
        background-color: #f9f9f9;
    }
    td button {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        padding: 5px 10px;
        transition: background-color 0.3s;
        display: block;
        margin: 0 auto; /* Centra il pulsante */
    }
    td.selected {
        background-color: orange; /* Cambia il colore di sfondo della cella selezionata */
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
    <h1>Vincitore Mondiale Piloti</h1>

    <table>
        <thead>
            <tr>
                <th>Nominativi piloti</th>
                <th>Si</th>
                <th>No</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Nomi dei piloti
            $piloti = array("Max Verstappen", "Pilota 2", "Pilota 3", "Pilota 4", "Pilota 5", 
                            "Pilota 6", "Pilota 7", "Pilota 8", "Pilota 9", "Pilota 10", 
                            "Pilota 11", "Pilota 12", "Pilota 13", "Pilota 14", "Pilota 15", 
                            "Pilota 16", "Pilota 17", "Pilota 18", "Pilota 19", "Pilota 20");

            // Calcolo delle quote per la colonna del "Si"
            $quote_si = array();
            for ($i = 0; $i < count($piloti); $i++) {
                $quote_si[] = round(1 + log($i + 2, count($piloti)) * 49 * 0.9, 2); // Applica uno sconto del 10%
            }

            // Calcolo delle quote per la colonna del "No"
            $quote_no = array();
            for ($i = 0; $i < count($piloti); $i++) {
                $quote_no[] = round(50 - log($i + 2, count($piloti)) * 49 * 0.9, 2); // Applica uno sconto del 10%
            }

            // Stampa dei piloti e input per le quote dei pulsanti Si/No
            for ($i = 0; $i < count($piloti); $i++) {
                echo "<tr>";
                echo "<td>$piloti[$i]</td>";
                echo "<td><button class='si-button' data-pilota='$piloti[$i]' data-quote='$quote_si[$i]'>$quote_si[$i]</button></td>";
                echo "<td><button class='no-button' data-pilota='$piloti[$i]' data-quote='$quote_no[$i]'>$quote_no[$i]</button></td>";
                echo "</tr>";
            }
            ?> 
        </tbody>
    </table>

    <a href="../frontend/Home.php" class="home-link">Torna alla pagina Home</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('button.si-button, button.no-button');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Recupera i dati dalla selezione
            var pilota = this.getAttribute('data-pilota');
            var quota = this.getAttribute('data-quote');

            // Crea una richiesta AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../backend/salva_quota.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Gestione della risposta AJAX
            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText === "quota-gia-selezionata") {
                        alert("Hai già selezionato una quota nel carrello provvisorio. Per cambiarla, elimina la quota attuale dal carrello e seleziona una nuova.");
                    } else {
                        console.log(xhr.responseText); // Stampa la risposta del server nella console
                        // Aggiungi qui altre azioni se necessario
                    }
                } else {
                    console.error('Errore durante la richiesta AJAX: ' + xhr.statusText);
                }
            };


            // Gestisci gli errori
            xhr.onerror = function() {
                console.error('Errore durante la richiesta AJAX.');
            };

            // Invia i dati al server
            xhr.send('pilota=' + encodeURIComponent(pilota) + '&quota=' + encodeURIComponent(quota));
        });
    });
});

</script>

</body>
</html>

