<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia Password</title>
    
</head>
<body>
    <form method="post" action="../backend/CambiaPassword.php">
        <label for="Mail">Mail:</label>
        <input type="text" id="Mail" name="email" required> 
        <br>
        <input type="submit" id="Submit">
    </form>
    <script>
        let valoreMail = document.getElementById("Mail");
        let valoreSubmit = document.getElementById("Submit");


        valoreSubmit.addEventListener("click", (e) => {
            e.preventDefault();
            const email = valoreMail.value;
            if (!email) return;
            
            // Invia l'email al backend per la verifica
            fetch('../backend/CambiaPassword.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email: email }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    //alert("La mail esiste !"); 
                } else {
                    //alert("La mail non esiste "); 
                }
            })
            .catch(error => {
                console.error('Errore:', error);
            });
        });
    </script>
</body>
</html>
