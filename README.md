# betterF1

problema: gestione delle quote e delle scommesse sulla f1 (ispirato alla better)

target: centri scommesse di piccole dimensioni

## funzionalità:
- Gli utenti possono registrarsi fornendo le informazioni richieste ( username, password, mail, cell) e (nome, cognome, luogo di nascita, anno di nascita)
- Gli utenti possono accedere utilizzando le loro credenzial (username e password)
- Gli utenti possono recuperare credenziali (password) oppure recupero credenziali (username) oppure entrambe
- Gli utenti possono effettuare transazioni di deposito e prelievo nel loro portafoglio virtuale
- Gli utenti possono effettuare scommesse sulla Formula 1.
- gestione delle scommesse (poter annullare le scommesse, visualizzarle)
- Gli amministratori possono gestire le quote per le varie gare di Formula 1.
- I risultati delle simulazioni delle gare sono visualizzabili dagli utenti.


## schema e/r
![Screenshot 2023-10-30 132546](https://github.com/nicolabresciani/betterF1/assets/101709282/aa58f256-7ac6-43fd-a940-da152f4aa990)





## schema relazionale
 - Utente(<ins>Username</ins>, Nome, Cognome, Password, DataDiNascita,LuogoNascita,Cellulare,Mail, Portafoglio_Username)
 - Portafoglio(<ins>Username</ins>,StoricoTransizioni,Stato,Saldo)
 - Scommessa(<ins>Id</ins>, ImportoScommesso, ImportoVinto,StatoScomessa,Data,Utente_Username,Gara_Id)
 - Gara(<ins>Id</ins>,Risultato,Stato,LuogoDiSvolta)
 - Quota(<ins>Id</ins>,Valore,Stato,Gara_Id)
 - Corrisponde(<ins>Scomessa_Id</ins>, "Quota_Id")




## immagine Idea progetto
![Screenshot 2023-10-30 124605](https://github.com/nicolabresciani/betterF1/assets/101709282/c4a65f3f-4bbc-495b-aa68-a6455c455e50)
![Screenshot 2023-10-30 124650](https://github.com/nicolabresciani/betterF1/assets/101709282/9276a2b4-d547-4f94-8f66-5360d9b1b2c4)
![Screenshot 2023-10-30 124736](https://github.com/nicolabresciani/betterF1/assets/101709282/659aa23f-dda3-4ff1-9199-2db008fa4a90)
![Screenshot 2023-10-30 125728](https://github.com/nicolabresciani/betterF1/assets/101709282/7129b54e-0136-45f8-a05a-c8bdd7cae0c9)
![Screenshot 2023-10-30 125753](https://github.com/nicolabresciani/betterF1/assets/101709282/eaea51d6-bb07-4d17-ad48-70b2275489dc)


## pagina login
<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h2>Login</h2>
    <form action="authentication.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>

## autotentificazione
?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        
        $randomNumber = rand(1, 100);
        
        if ($randomNumber % 2 === 0) {
            header("Location: userpage.php?username=" . urlencode($username));
        } else {
            header("Location: login.php");
        }
    }
}
?>
## userpage
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['username'])) {
    $username = $_GET['username'];
    
    echo "<h2>Benvenuto, $username!</h2>";
} else {
    header("Location: login.php");
}
?>
