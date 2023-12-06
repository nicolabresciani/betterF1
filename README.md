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
![schemaER](https://github.com/nicolabresciani/betterF1/assets/101709282/4b487ed4-b25f-43f7-a69d-5ae8ff2b4925)







## schema relazionale
- Amministratore(<ins>Username</ins>, Nome, Cognome, Password, Ruolo)
- SottoAmministratore(<ins>Username</ins>, Nome, Cognome, Password, Ruolo, Amministratore_Username)
- Utente(<ins>Username</ins>, Nome, Cognome, Password, DataDiNascita, LuogoNascita, Cellulare, Mail, Portafoglio_Username)
- Portafoglio(<ins>Username</ins>, Stato, Saldo)
- Prelievo(<ins>Id</ins>, Data, Importo, Portafoglio_Username)
- Scommessa(<ins>Id</ins>, ImportoScommesso, ImportoVinto, StatoScommessa, Data, Utente_Username, Gara_id, Amministratore_Username)
- Quota(<ins>Id</ins>, Valore, Stato, Gara_Id, SottoAmministratore_Username)
- ScommessaQuota(<ins>Scommessa_Id</ins>,<ins>Quota_Id</ins>)
- Gara(<ins>Id</ins>, Risultato, Stato, LuogoDiSvolta, SottoAmministratore_Username)


## query creazione daabase
-- Creazione del database
CREATE DATABASE betterF1

-- Creazione della tabella Amministratore
CREATE TABLE Amministratore (
    Username VARCHAR(255) PRIMARY KEY,
    Nome VARCHAR(255),
    Cognome VARCHAR(255),
    Password VARCHAR(255),
    Ruolo VARCHAR(255)
);

-- Creazione della tabella SottoAmministratore con il vincolo di chiave esterna
CREATE TABLE SottoAmministratore (
    Username VARCHAR(255) PRIMARY KEY,
    Nome VARCHAR(255),
    Cognome VARCHAR(255),
    Password VARCHAR(255),
    Ruolo VARCHAR(255),
    Amministratore_Username VARCHAR(255),
    FOREIGN KEY (Amministratore_Username) REFERENCES Amministratore(Username)
);

-- Creazione della tabella Utente
CREATE TABLE Utente (
    Username VARCHAR(255) PRIMARY KEY,
    Nome VARCHAR(255),
    Cognome VARCHAR(255),
    Password VARCHAR(255),
    DataDiNascita DATE,
    LuogoNascita VARCHAR(255),
    Cellulare VARCHAR(15),
    Mail VARCHAR(255),
    Portafoglio_Username VARCHAR(255),
    FOREIGN KEY (Portafoglio_Username) REFERENCES Portafoglio(Username)
);

-- Creazione della tabella Portafoglio
CREATE TABLE Portafoglio (
    Username VARCHAR(255) PRIMARY KEY,
    Stato VARCHAR(255),
    Saldo DECIMAL(10, 2)
);

-- Creazione della tabella Prelievo
CREATE TABLE Prelievo (
    Id INT PRIMARY KEY,
    Data DATE,
    Importo DECIMAL(10, 2),
    Portafoglio_Username VARCHAR(255),
    FOREIGN KEY (Portafoglio_Username) REFERENCES Portafoglio(Username)
);

-- Creazione della tabella Scommessa con i relativi vincoli di chiavi esterne
CREATE TABLE Scommessa (
    Id INT PRIMARY KEY,
    ImportoScommesso DECIMAL(10, 2),
    ImportoVinto DECIMAL(10, 2),
    StatoScommessa VARCHAR(255),
    Data DATE,
    Utente_Username VARCHAR(255),
    Gara_id INT,
    Amministratore_Username VARCHAR(255),
    FOREIGN KEY (Utente_Username) REFERENCES Utente(Username),
    FOREIGN KEY (Gara_id) REFERENCES Gara(Id),
    FOREIGN KEY (Amministratore_Username) REFERENCES Amministratore(Username)
);

-- Creazione della tabella Quota con il vincolo di chiave esterna
CREATE TABLE Quota (
    Id INT PRIMARY KEY,
    Valore DECIMAL(10, 2),
    Stato VARCHAR(255),
    Gara_Id INT,
    SottoAmministratore_Username VARCHAR(255),
    FOREIGN KEY (Gara_Id) REFERENCES Gara(Id),
    FOREIGN KEY (SottoAmministratore_Username) REFERENCES SottoAmministratore(Username)
);

-- Creazione della tabella ScommessaQuota con i relativi vincoli di chiavi esterne
CREATE TABLE ScommessaQuota (
    Scommessa_Id INT,
    Quota_Id INT,
    PRIMARY KEY (Scommessa_Id, Quota_Id),
    FOREIGN KEY (Scommessa_Id) REFERENCES Scommessa(Id),
    FOREIGN KEY (Quota_Id) REFERENCES Quota(Id)
);

-- Creazione della tabella Gara
CREATE TABLE Gara (
    Id INT PRIMARY KEY,
    Risultato VARCHAR(255),
    Stato VARCHAR(255),
    LuogoDiSvolta VARCHAR(255),
    SottoAmministratore_Username VARCHAR(255),
    FOREIGN KEY (SottoAmministratore_Username) REFERENCES SottoAmministratore(Username)
);


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
