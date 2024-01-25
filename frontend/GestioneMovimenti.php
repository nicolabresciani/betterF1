<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione movimenti</title>
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
            margin-right: 5px;
            float: right;
        }

        button:hover {
            background-color: black;
        }

        .user-list {
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        label {
            margin-right: 10px;
        }

        #searchInput {
            width: 246px;
            padding: 10px;
            border: 1px solid black;
            border-radius: 15px;
            font-size: 14px;
        }

        .deleteButton {
            background-color: red;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .deleteButton:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="user-list">
        <!-- Aggiunto il pulsante di ritorno indietro -->
        <button onclick="goBack()">Torna Indietro</button>

        <!-- Aggiunto campo di input e pulsante di ricerca -->
        <label for="searchInput">Cerca:</label>
        <input type="text" id="searchInput" onkeyup="searchUsers()" placeholder="Cerca per Username, Nome, Cognome...">
        <br>

        <h2>Elenco Utenti</h2>
        <table>
            <thead>
                <tr id="fields-row"></tr>
            </thead>
            <tbody id="user-list-container"></tbody>
        </table>

        <script>
            function goBack() {
                window.history.back();
            }
            var searchTimeout;

            function searchUsers() {
                clearTimeout(searchTimeout);
                var input, filter;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                
                // Interrompi l'aggiornamento
                clearInterval(updateInterval);

                var xhr = new XMLHttpRequest();
                xhr.open("GET", "../backend/api_get_users.php?search=" + filter, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var userListContainer = document.getElementById("user-list-container");
                        var fieldsRow = document.getElementById("fields-row");
                        var users = JSON.parse(xhr.responseText);

                        // Pulisci la tabella
                        userListContainer.innerHTML = "";
                        fieldsRow.innerHTML = "";

                        // Visualizza gli utenti nella lista
                        users.forEach(function (user, index) {
                            if (index === 0) {
                                // Se è il primo utente, crea la riga con i nomi dei campi
                                for (var field in user) {
                                    var th = document.createElement("th");
                                    th.textContent = field;
                                    fieldsRow.appendChild(th);
                                }
                                var thDelete = document.createElement("th");
                                thDelete.textContent = "visualizza movimenti";
                                fieldsRow.appendChild(thDelete);
                            }

                            // Crea una riga per ogni utente
                            var tr = document.createElement("tr");
                            for (var field in user) {
                                var td = document.createElement("td");
                                td.textContent = user[field];
                                tr.appendChild(td);
                            }

                            // Aggiungi il pulsante "Elimina"
                            var tdDelete = document.createElement("td");
                            var deleteButton = document.createElement("button");
                            deleteButton.className = "moveButton";
                            deleteButton.textContent = "visualizza movimenti";
                            deleteButton.onclick = function() {
                                // Chiamata alla funzione per eliminare l'utente (con conferma)
                                var confirmation = confirm("Sei sicuro di voler eliminare l'utente?");
                                if (confirmation) {
                                    // Implementa la logica per eliminare l'utente dal database
                                    deleteUser(user.Username);
                                    // Rimuovi la riga dalla pagina
                                    tr.remove();
                                }
                            };
                            tdDelete.appendChild(deleteButton);
                            tr.appendChild(tdDelete);

                            userListContainer.appendChild(tr);
                        });

                        // Riprendi l'aggiornamento solo se la barra di ricerca è vuota
                        if (filter === "") {
                            searchTimeout = setTimeout(function () {
                                updateInterval = setInterval(getUsers, 5000);
                            }, 1000);
                        }
                    }
                };
                xhr.send();
            }

            // Aggiornamento ogni 5 secondi
            var updateInterval = setInterval(getUsers, 2000);

            function getUsers() {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "../backend/api_get_users.php", true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var userListContainer = document.getElementById("user-list-container");
                        var fieldsRow = document.getElementById("fields-row");
                        var users = JSON.parse(xhr.responseText);

                        // Pulisci la tabella
                        userListContainer.innerHTML = "";
                        fieldsRow.innerHTML = "";

                        // Visualizza gli utenti nella lista
                        users.forEach(function (user, index) {
                            if (index === 0) {
                                // Se è il primo utente, crea la riga con i nomi dei campi
                                for (var field in user) {
                                    var th = document.createElement("th");
                                    th.textContent = field;
                                    fieldsRow.appendChild(th);
                                }
                                var thDelete = document.createElement("th");
                                thDelete.textContent = "visualizza movimenti";
                                fieldsRow.appendChild(thDelete);
                            }

                            // Crea una riga per ogni utente
                            var tr = document.createElement("tr");
                            for (var field in user) {
                                var td = document.createElement("td");
                                td.textContent = user[field];
                                tr.appendChild(td);
                            }

                            // Aggiungi il pulsante "Elimina"
                            var tdDelete = document.createElement("td");
                            var deleteButton = document.createElement("button");
                            deleteButton.className = "moveButton";
                            deleteButton.textContent = "visualizza movimenti";
                            tdDelete.appendChild(deleteButton);
                            tr.appendChild(tdDelete);

                            userListContainer.appendChild(tr);
                        });
                    }
                };
                xhr.send();
            }
        </script>
    </div>
</body>
</html>
