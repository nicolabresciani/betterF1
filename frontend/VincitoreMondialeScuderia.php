<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vincitore Mondiale Costruttori</title>
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
    <h1>Vincitore Mondiale Costruttori</h1>

    <table>
        <thead>
            <tr>
                <th>Nomi Scuderie</th>
                <th>Si</th>
                <th>No</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Nomi delle scuderie
            $scuderie = array("Mercedes-AMG Petronas Formula One Team", "Red Bull Racing", "Scuderia Ferrari", "McLaren F1 Team", "Alpine F1 Team", 
                            "Scuderia AlphaTauri", "Aston Martin Cognizant Formula One Team", "Alfa Romeo Racing Orlen", "Williams Racing", "Haas F1 Team");

            // Calcolo delle quote per la colonna del "Si"
            $quote_si = array();
            for ($i = 0; $i < count($scuderie); $i++) {
                if ($i < 5) { // Abbassiamo le quote per le prime 5 scuderie
                    $quote_si[] = round(1 + log($i + 2, count($scuderie)) * 20 * 0.9, 2); // Applica uno sconto del 10% e un fattore di 20
                } else {
                    $quote_si[] = round(1 + log($i + 2, count($scuderie)) * 50 * 0.9, 2); // Manteniamo le quote più alte per le scuderie successive
                }
            }

            // Calcolo delle quote per la colonna del "No"
            $quote_no = array();
            $numero_scuderie = count($scuderie);
            for ($i = 0; $i < $numero_scuderie; $i++) {
                if ($i >= 5) { // Alziamo le quote per le scuderie dal sesto posto in poi
                    $quote_no[] = round(1 + log($numero_scuderie - $i + 1, $numero_scuderie) * 49 * 0.1, 2); // Applica uno sconto del 10%
                } else {
                    $quote_no[] = round(50 - log($i + 2, $numero_scuderie) * 49 * 0.9, 2); // Manteniamo le quote invariate per le prime cinque scuderie
                }
            }

            // Stampa delle scuderie e input per le quote dei pulsanti Si/No
            for ($i = 0; $i < count($scuderie); $i++) {
                echo "<tr>";
                echo "<td>$scuderie[$i]</td>";
                echo "<td><button class='si-button' data-pilota='$scuderie[$i]' data-quote='$quote_si[$i]' data-scelta='SI'>$quote_si[$i]</button></td>";
                echo "<td><button class='no-button' data-pilota='$scuderie[$i]' data-quote='$quote_no[$i]' data-scelta='NO'>$quote_no[$i]</button></td>";
                echo "</tr>";
            }
            ?> 
        </tbody>
    </table>

    <a href="../frontend/Home.php" class="home-link">Torna alla pagina Home</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Modifica del codice JavaScript per includere il valore di data-scelta nella richiesta AJAX
    var buttons = document.querySelectorAll('button.si-button, button.no-button');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Recupera i dati dalla selezione
            var scuderia = this.getAttribute('data-pilota');
            var quota = this.getAttribute('data-quote');
            var scelta = this.getAttribute('data-scelta'); // Aggiunta: recupera il valore di data-scelta

            // Crea una richiesta AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../backend/salva_quotaCostruttori.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Gestione della risposta AJAX
            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText === "quota-gia-selezionata") {
                        alert("Hai già selezionato una quota nel carrello provvisorio. Per cambiarla, elimina la quota attuale dal carrello e seleziona una nuova.");
                    } else if (xhr.responseText === "quota-inserita-correttamente") {
                        alert("La quota è stata inserita correttamente nel carrello!");
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

            // Invia i dati al server, incluso il valore di scelta
            xhr.send('scuderia=' + encodeURIComponent(scuderia) + '&quota=' + encodeURIComponent(quota) + '&scelta=' + encodeURIComponent(scelta));
        });
    });
});
</script>

</body>
</html>
