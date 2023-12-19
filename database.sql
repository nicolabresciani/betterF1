-- Creazione del database

CREATE DATABASE betterF1

-- Creazione della tabella Amministratore

CREATE TABLE Amministratore ( Username VARCHAR(255) PRIMARY KEY, Nome VARCHAR(255), Cognome VARCHAR(255), Password VARCHAR(255), Ruolo VARCHAR(255) );

-- Creazione della tabella SottoAmministratore con il vincolo di chiave esterna

CREATE TABLE SottoAmministratore ( Username VARCHAR(255) PRIMARY KEY, Nome VARCHAR(255), Cognome VARCHAR(255), Password VARCHAR(255), Ruolo VARCHAR(255), Amministratore_Username VARCHAR(255), FOREIGN KEY (Amministratore_Username) REFERENCES Amministratore(Username) );

-- Creazione della tabella Utente

CREATE TABLE Utente ( Username VARCHAR(255) PRIMARY KEY, Nome VARCHAR(255), Cognome VARCHAR(255), Password VARCHAR(255), DataDiNascita DATE, LuogoNascita VARCHAR(255), Cellulare VARCHAR(15), Mail VARCHAR(255), Portafoglio_Username VARCHAR(255), FOREIGN KEY (Portafoglio_Username) REFERENCES Portafoglio(Username) );

-- Creazione della tabella Portafoglio

CREATE TABLE Portafoglio ( Username VARCHAR(255) PRIMARY KEY, Stato VARCHAR(255), Saldo DECIMAL(10, 2) );

-- Creazione della tabella Prelievo

CREATE TABLE Prelievo ( Id INT PRIMARY KEY, Data DATE, Importo DECIMAL(10, 2), Portafoglio_Username VARCHAR(255), FOREIGN KEY (Portafoglio_Username) REFERENCES Portafoglio(Username) );

-- Creazione della tabella Scommessa con i relativi vincoli di chiavi esterne

CREATE TABLE Scommessa ( Id INT PRIMARY KEY, ImportoScommesso DECIMAL(10, 2), ImportoVinto DECIMAL(10, 2), StatoScommessa VARCHAR(255), Data DATE, Utente_Username VARCHAR(255), Gara_id INT, Amministratore_Username VARCHAR(255), FOREIGN KEY (Utente_Username) REFERENCES Utente(Username), FOREIGN KEY (Gara_id) REFERENCES Gara(Id), FOREIGN KEY (Amministratore_Username) REFERENCES Amministratore(Username) );

-- Creazione della tabella Quota con il vincolo di chiave esterna

CREATE TABLE Quota ( Id INT PRIMARY KEY, Valore DECIMAL(10, 2), Stato VARCHAR(255), Gara_Id INT, SottoAmministratore_Username VARCHAR(255), FOREIGN KEY (Gara_Id) REFERENCES Gara(Id), FOREIGN KEY (SottoAmministratore_Username) REFERENCES SottoAmministratore(Username) );

-- Creazione della tabella ScommessaQuota con i relativi vincoli di chiavi esterne

CREATE TABLE ScommessaQuota ( Scommessa_Id INT, Quota_Id INT, PRIMARY KEY (Scommessa_Id, Quota_Id), FOREIGN KEY (Scommessa_Id) REFERENCES Scommessa(Id), FOREIGN KEY (Quota_Id) REFERENCES Quota(Id) );

-- Creazione della tabella Gara

CREATE TABLE Gara ( Id INT PRIMARY KEY, Risultato VARCHAR(255), Stato VARCHAR(255), LuogoDiSvolta VARCHAR(255), SottoAmministratore_Username VARCHAR(255), FOREIGN KEY (SottoAmministratore_Username) REFERENCES SottoAmministratore(Username) );