<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utenti</title>
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

        .changeRoleButton {
            background-color: green;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .changeRoleButton:hover {
            background-color: darkgreen;
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
                window.location.href = "../frontend/PaginaSottoAmministratore.php";
            }
            var searchTimeout;

            function searchUsers() {
    clearTimeout(searchTimeout);
    var input = document.getElementById("searchInput");
    var filter = input.value.toUpperCase();
    
    clearInterval(updateInterval); // Interrompi l'aggiornamento

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../backend/api_get_users.php?search=" + filter, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                try {
                    var userListContainer = document.getElementById("user-list-container");
                    var fieldsRow = document.getElementById("fields-row");
                    var response = JSON.parse(xhr.responseText);

                    // Assicurati che la risposta contenga dati JSON validi
                    if (response && Array.isArray(response.users)) {
                        var users = response.users;

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
                                var thChangeRole = document.createElement("th");
                                thChangeRole.textContent = "Cambia Ruolo";
                                fieldsRow.appendChild(thChangeRole);
                            }

                            // Crea una riga per ogni utente
                            var tr = document.createElement("tr");
                            for (var field in user) {
                                var td = document.createElement("td");
                                td.textContent = user[field];
                                tr.appendChild(td);
                            }

                            // Aggiungi il pulsante "Cambia Ruolo"
                            var tdChangeRole = document.createElement("td");
                            var changeRoleButton = document.createElement("button");
                            changeRoleButton.className = "changeRoleButton";
                            changeRoleButton.textContent = "Cambia Ruolo";
                            changeRoleButton.onclick = function() {
                                // Chiamata alla funzione per cambiare il ruolo dell'utente (con conferma)
                                var confirmation = confirm("Sei sicuro di voler cambiare il ruolo dell'utente?");
                                if (confirmation) {
                                    // Implementa la logica per cambiare il ruolo dell'utente dal database
                                    changeUserRole(user.Username);
                                }
                            };
                            tdChangeRole.appendChild(changeRoleButton);
                            tr.appendChild(tdChangeRole);

                            userListContainer.appendChild(tr);
                        });

                        // Riprendi l'aggiornamento solo se la barra di ricerca è vuota
                        if (filter === "") {
                            searchTimeout = setTimeout(function () {
                                updateInterval = setInterval(getUsers, 5000);
                            }, 1000);
                        }
                    } else {
                        console.error("La risposta non contiene dati utente validi:", response);
                    }
                } catch (error) {
                    console.error("Errore durante il parsing della risposta JSON:", error);
                }
            } else {
                console.error("Si è verificato un errore durante la richiesta:", xhr.status);
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
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            var userListContainer = document.getElementById("user-list-container");
                            var fieldsRow = document.getElementById("fields-row");
                            var users;
                            try {
                                users = JSON.parse(xhr.responseText);
                            } catch (error) {
                                console.error("Errore durante il parsing della risposta JSON:", error);
                                return;
                            }

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
                                    var thChangeRole = document.createElement("th");
                                    thChangeRole.textContent = "Cambia Ruolo";
                                    fieldsRow.appendChild(thChangeRole);
                                }

                                // Crea una riga per ogni utente
                                var tr = document.createElement("tr");
                                for (var field in user) {
                                    var td = document.createElement("td");
                                    td.textContent = user[field];
                                    tr.appendChild(td);
                                }

                                // Aggiungi il pulsante "Cambia Ruolo"
                                var tdChangeRole = document.createElement("td");
                                var changeRoleButton = document.createElement("button");
                                changeRoleButton.className = "changeRoleButton";
                                changeRoleButton.textContent = "Cambia Ruolo";
                                changeRoleButton.onclick = function() {
                                    // Chiamata alla funzione per cambiare il ruolo dell'utente (con conferma)
                                    var confirmation = confirm("Sei sicuro di voler cambiare il ruolo dell'utente?");
                                    if (confirmation) {
                                        // Implementa la logica per cambiare il ruolo dell'utente dal database
                                        changeUserRole(user.Username);
                                    }
                                };
                                tdChangeRole.appendChild(changeRoleButton);
                                tr.appendChild(tdChangeRole);

                                userListContainer.appendChild(tr);
                            });
                        } else {
                            console.error("Si è verificato un errore durante la richiesta:", xhr.status);
                        }
                    }
                };
                xhr.send();
            }

            // Funzione per cambiare il ruolo dell'utente nel database
            function changeUserRole(username) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../backend/api_change_user_role.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            try {
                                var response = JSON.parse(xhr.responseText);
                                if (response && response.message) {
                                    alert(response.message);
                                } else {
                                    console.error("La risposta non contiene il messaggio atteso:", response);
                                }
                            } catch (error) {
                                console.error("Errore durante il parsing della risposta JSON:", error);
                            }
                        } else {
                            console.error("Si è verificato un errore durante la richiesta:", xhr.status);
                        }
                    }
                };
                xhr.send("username=" + username);
            }

        </script>
    </div>
</body>
</html>
