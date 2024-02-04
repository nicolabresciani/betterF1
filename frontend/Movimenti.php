<?php
    include "../backend/api_get_prelievo.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimenti Utente</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: cursive, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .movements-container {
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .sections-container {
            display: flex; /* Display flessibile per allineare su una riga */
            justify-content: space-between; /* Spaziatura uniforme tra le sezioni */
            width: 100%; /* Occupa l'intera larghezza disponibile */
        }

        .table-container {
            margin-top: 20px;
            flex: 1;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Movimenti Utente</h1>
        <button onclick="goBack()">Torna Indietro</button>
    </header>

    <div class="movements-container">
        <div class="sections-container">
            <h2>Estratti Prelievi</h2>
            <h2>Estratti Depositi</h2>
        </div>

        <div class="table-container" id="prelievi-container"></div>
        <div class="table-container" id="depositi-container"></div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        function fetchAndDisplayData() {
            var prelieviContainer = document.getElementById("prelievi-container");

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../backend/api_get_movements.php?username=" + selectedUsername, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var prelieviData = JSON.parse(xhr.responseText);

                    // Pulisci la tabella
                    prelieviContainer.innerHTML = "";

                    // Crea la tabella e le intestazioni
                    var table = document.createElement("table");
                    var thead = document.createElement("thead");
                    var tbody = document.createElement("tbody");

                    var headerRow = document.createElement("tr");
                    for (var field in prelieviData[0]) {
                        var th = document.createElement("th");
                        th.textContent = field;
                        headerRow.appendChild(th);
                    }
                    thead.appendChild(headerRow);

                    // Aggiungi i dati alla tabella
                    prelieviData.forEach(function (row) {
                        var tr = document.createElement("tr");
                        for (var field in row) {
                            var td = document.createElement("td");
                            td.textContent = row[field];
                            tr.appendChild(td);
                        }
                        tbody.appendChild(tr);
                    });

                    // Aggiungi la testata e il corpo alla tabella
                    table.appendChild(thead);
                    table.appendChild(tbody);

                    // Aggiungi la tabella al container
                    prelieviContainer.appendChild(table);
                }
            };
            xhr.send();
        }

        // Aggiorna i dati ogni 2 secondi
        setInterval(fetchAndDisplayData, 2000);

        // Chiamare fetchAndDisplayData() all'inizio o dopo aver estratto i movimenti dell'utente
        fetchAndDisplayData();

 
    </script>
</body>
</html>
