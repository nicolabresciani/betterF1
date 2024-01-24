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
    </style>
</head>
<body>
    <div class="user-list">
        <!-- Aggiunto il pulsante di ritorno indietro -->
        <button onclick="goBack()">Torna Indietro</button>
        
        <!-- Aggiunto campo di input e pulsante di ricerca -->
        <label for="searchInput">Cerca per lettera:</label>
        <input type="text" id="searchInput" oninput="searchUsers()">
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

            // Funzione per ottenere gli utenti dal server
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
                            }

                            // Crea una riga per ogni utente
                            var tr = document.createElement("tr");
                            for (var field in user) {
                                var td = document.createElement("td");
                                td.textContent = user[field];
                                tr.appendChild(td);
                            }
                            userListContainer.appendChild(tr);
                        });
                    }
                };
                xhr.send();
            }


            // Funzione di ricerca
            function searchUsers() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("searchInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("user-list-container");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[1]; // Modifica 1 con l'indice del campo su cui vuoi eseguire la ricerca (Nome)
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

            // Esegui getUsers ogni 5 secondi (puoi modificare il valore secondo le tue esigenze)
            setInterval(getUsers, 5000);

            // Chiamata iniziale
            getUsers();
        </script>
    </div>
</body>
</html>