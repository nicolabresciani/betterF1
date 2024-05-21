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
        <input type="submit" id="Submit" value="Invia">
    </form>
    <script>
        document.getElementById('passwordForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const email = document.getElementById("Mail").value;
            if (!email) return;
            // Invia l'email al backend per la verifica
            async function sendEmail(email) {
                try {
                    const response = await fetch('../backend/CambiaPassword.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: "{\"email\": " + email + "}" // JSON.stringify({ email: email })
                    })
                    let r = response.json();
                    console.log(r.then((data) => console.log(data)));
                } catch (error) {
                    console.error(error);
                }
            }
            sendEmail(email);
        });
    </script>
</body>
</html>
