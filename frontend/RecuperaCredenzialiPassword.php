<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia Password</title>
</head>
<body>
    <form id="passwordForm">
        <label for="Mail">Mail:</label>
        <input type="email" id="Mail" name="email" required> 
        <br>
        <input type="submit" id="Submit" value="Invia">
    </form>
    <script>
        document.getElementById('passwordForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById("Mail").value;
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
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Errore:', error);
            });
        });
    </script>
</body>
</html>
