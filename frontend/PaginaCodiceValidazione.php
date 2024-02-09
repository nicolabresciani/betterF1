<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica Codice</title>
</head>
<body>
    <h1>Inserisci il Codice di Verifica</h1>
    <input type="text" id="codiceInput" placeholder="Inserisci il Codice">
    <button onclick="verificaCodice()">Verifica</button>

    <script>
        function verificaCodice() {
            var codiceInput = document.getElementById("codiceInput").value;

            // Effettua una richiesta al backend per verificare il codice
            fetch("../backend/CodiceValidazioneController.php?codice=" + codiceInput)
                .then(response => response.json())
                .then(data => {
                    if (data.valido) {
                        // Stampa il codice di verifica nella console
                        console.log("Codice di verifica corretto:", data.codice);
                        // Rimani sulla stessa pagina e visualizza un messaggio di successo
                        //alert("Codice di verifica corretto: " + data.codice);
                        window.location.href = "../frontend/Login.php";
                    } else {
                        alert("Codice di verifica errato");
                    }
                })
                .catch(error => console.error("Errore:", error));
        }
    </script>
</body>
</html>
