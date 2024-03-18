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
                        window.location.href = "../frontend/Login.php";
                    } else {
                        alert("Codice di verifica errato");
                    }
                })
                .catch(error => console.error("Errore:", error));
        }

        function codiceConsole(){
            // Esegue una richiesta al backend per ottenere il codice di verifica
            fetch("../backend/EstrazioneCodiceValidazione.php")
                .then(response => response.json())
                .then(data => {
                    if (data.valido) {
                        console.log("Codice di verifica:", data.codice); // Stampa il codice di verifica sulla console
                    } else {
                        console.error("Errore: codice di verifica non disponibile");
                        console.error("Errore:", data.errore);
                    }
                })
                .catch(error => console.error("Errore:", error));
        }

        // Chiama la funzione codiceConsole() quando la pagina è completamente caricata
        document.addEventListener("DOMContentLoaded", function() {
            codiceConsole();
        });
    </script>
</body>
</html>
