-- Creazione del database

CREATE DATABASE betterF1


CREATE TABLE Portafoglio ( Username VARCHAR(255) PRIMARY KEY, Stato VARCHAR(255), Saldo DECIMAL(10, 2) ); 

CREATE TABLE Utente (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) UNIQUE,
    Nome VARCHAR(255),
    Cognome VARCHAR(255),
    Password VARCHAR(255),
    DataDiNascita DATE,
    LuogoNascita VARCHAR(255),
    Cellulare VARCHAR(15),
    Mail VARCHAR(255),
    Ruolo VARCHAR(20),
    CodiceValidazione INT(6),
    Stato ENUM('attivo', 'sospeso') DEFAULT 'attivo'
);

CREATE TABLE Amministratore ( Username VARCHAR(255) PRIMARY KEY, Nome VARCHAR(255), Cognome VARCHAR(255), Password VARCHAR(255), Ruolo VARCHAR(255) );  


CREATE TABLE SottoAmministratore ( Username VARCHAR(255) PRIMARY KEY, Nome VARCHAR(255), Cognome VARCHAR(255), Password VARCHAR(255), Ruolo VARCHAR(255), Amministratore_Username VARCHAR(255), FOREIGN KEY (Amministratore_Username) REFERENCES Amministratore(Username) ); 



CREATE TABLE Prelievo (
    Prelievo_Id INT AUTO_INCREMENT PRIMARY KEY,
    Data DATE,
    Prelievo DECIMAL(10, 2),
    Portafoglio_Username VARCHAR(255),
    FOREIGN KEY (Portafoglio_Username) REFERENCES Portafoglio(Username)
); 



CREATE TABLE Deposito (
    Deposito_Id INT AUTO_INCREMENT PRIMARY KEY,
    Data DATE,
    Importo DECIMAL(10, 2),
    Portafoglio_Username VARCHAR(255),
    FOREIGN KEY (Portafoglio_Username) REFERENCES Portafoglio(Username)
);


CREATE TABLE Scommessa (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Id_Scommessa VARCHAR(10) UNIQUE,
    ImportoScommesso DECIMAL(10, 2),
    ImportoVinto DECIMAL(10, 2),
    StatoScommessa VARCHAR(255),
    Data DATE,
    Utente_Username VARCHAR(255),
    Quota_Id DECIMAL(10,2),
    Amministratore_Username VARCHAR(255),
    Scelta VARCHAR(2),
    CampoDiScommessa VARCHAR (255),
    nominativo  VARCHAR(255),
    FOREIGN KEY (Utente_Username) REFERENCES Utente(Username),
    FOREIGN KEY (Amministratore_Username) REFERENCES Amministratore(Username)
);

CREATE TABLE ScommessaQuota (
    Scommessa_Id VARCHAR(10),
    Quota_Id DECIMAL(10,2),
    PRIMARY KEY (Scommessa_Id, Quota_Id),
    FOREIGN KEY (Scommessa_Id) REFERENCES Scommessa(Id_Scommessa)
);

CREATE TABLE Carrello (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Scommessa_Id VARCHAR(10),
    Utente_Username VARCHAR(255),
    Quota DECIMAL(10,2),
    Importo DECIMAL(10,2),
    FOREIGN KEY (Scommessa_Id) REFERENCES Scommessa(Id_Scommessa)
);


CREATE TABLE CarrelloProvvisorio (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Utente_Username VARCHAR(255),
    Scommessa_Id VARCHAR(10),
    NominativoPilota VARCHAR(255),
    Quota DECIMAL(10,2),
    Importo INT,
    FOREIGN KEY (Utente_Username) REFERENCES Utente(Username)
);

INSERT INTO `Amministratore` (`Username`, `Nome`, `Cognome`, `Password`, `Ruolo`) VALUES ('Nick', 'Nick', 'Nick', 'Nick', 'Amministratore');
INSERT INTO `SottoAmministratore` (`Username`, `Nome`, `Cognome`, `Password`, `Ruolo`, `Amministratore_Username`) VALUES ('a', 'a', 'a', '0cc175b9c0f1b6a831c399e269772661', 'SottoAmministratore', 'Nick');
INSERT INTO `Utente` (`Id`, `Username`, `Nome`, `Cognome`, `Password`, `DataDiNascita`, `LuogoNascita`, `Cellulare`, `Mail`, `Ruolo`, `CodiceValidazione`, `Stato`)
VALUES ('1', 'b', 'b', 'b', '92eb5ffee6ae2fec3ad71c777531578f', '2002-03-04', 'Bergamo', '3283993729', 'b@b.com', 'Utente Normale', '222222', 'attivo');
INSERT INTO `Portafoglio` (`Username` , `Stato`, `Saldo`) VALUES ('b', 1, 0.00);
