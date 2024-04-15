<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Primo Ritirato</title>
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
    <h1>Primo Ritirato</h1>

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
            $piloti = array("Max Verstappen", "Sergio Perez", "Charles Leclerc", "Carlos Sainz", "Lewis Hamilton", 
                            "George Russell","Lando Norris", "Oscar Piastri", "Lance Stroll", "Fernando Alonso", 
                            "Pierre Gasly", "Esteban Ocon", "Logan Sargeant", "Alexander Albon", "Yuki Tsunoda",
                            "Daniel Ricciardo", "Zhou Guanyu", "Valtteri Bottas","Nico Hulkenberg", "Kevin Magnussen");

            // Calcolo delle quote per la colonna del "Si"
            $quote_si = array();
            for ($i = 0; $i < count($piloti); $i++) {
                if ($i < 10) { // Abbassiamo le quote per i primi 5 piloti
                    $quote_si[] = round(1 + log($i + 2, count($piloti)) * 49 * 0.38, 2); // Applica uno sconto del 10% e un fattore di 20
                } else {
                    $quote_si[] = round(1 + log($i + 2, count($piloti)) * 49 * 0.68, 2); // Manteniamo le quote più alte per i piloti successivi
                }
            }
            
            

            // Calcolo delle quote per la colonna del "No"
            $quote_no = array();
            $numero_piloti = count($piloti);
            for ($i = 0; $i < $numero_piloti; $i++) {
                if ($i >= 10) { // Aumentiamo le quote per i piloti dal decimo al ventesimo posto
                    $quote_no[] = round(1 + log($numero_piloti - $i + 1, $numero_piloti) * 49 * 0.34, 2); // Applica uno sconto del 10%
                } else {
                    $quote_no[] = round(50 - log($i + 2, $numero_piloti) * 49 * 0.8, 2); // Manteniamo le quote invariate per i primi nove piloti
                }
            }
            // Stampa dei piloti e input per le quote dei pulsanti Si/No
            for ($i = 0; $i < count($piloti); $i++) {
                echo "<tr>";
                echo "<td>$piloti[$i]</td>";
                echo "<td><button class='si-button' data-pilota='$piloti[$i]' data-quote='$quote_si[$i]' data-scelta='SI'>$quote_si[$i]</button></td>";
                echo "<td><button class='no-button' data-pilota='$piloti[$i]' data-quote='$quote_no[$i]' data-scelta='NO'>$quote_no[$i]</button></td>";
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
            var pilota = this.getAttribute('data-pilota');
            var quota = this.getAttribute('data-quote');
            var scelta = this.getAttribute('data-scelta'); // Aggiunta: recupera il valore di data-scelta

            // Crea una richiesta AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../backend/salva_quotaPrimoRitirato.php', true);
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
            xhr.send('pilota=' + encodeURIComponent(pilota) + '&quota=' + encodeURIComponent(quota) + '&scelta=' + encodeURIComponent(scelta));
        });
    });
});

</script>
</body>
</html>