# betterF1

problema: gestione delle quote e delle scommesse sulla f1 (ispirato alla better)

target: centri scommesse di piccole dimensioni

## funzionalità:
- Gli utenti possono registrarsi fornendo le informazioni richieste ( username, password, mail, cell) e (nome, cognome, luogo di nascita, anno di nascita)    "(svolto)"
- Gli utenti possono accedere utilizzando le loro credenzial (username e password)    "(svolto)"
- Gli utenti possono recuperare credenziali (password) oppure recupero credenziali (username)     "(svolto)"
- Gli utenti possono effettuare transazioni di deposito e prelievo nel loro portafoglio virtuale    "(svolto)"
- Gli utenti possono effettuare scommesse sulla Formula 1. ("svolto")



## come far partire il progetto
-step1: accedere al codespaces online

-step2: verifica che sia installata l'estensione docker, se non fosse installata installarla

step3: incollare il seguente link nel terminale e aspettare che finisca di installare le estensioni docker run --name myXampp -p 41061:22 -p 41062:80 -d -v /workspaces/betterF1:/www tomsik68/xampp:8

step4: aprire l'estensione docker, aprire la sezione CONTAINERS, aprire l'eventuale se presente Individual Containers, e far partire il tutto cliccando con il tasto destro del mouse start su  tomsik68/xampp:8.  cliccare  su  tomsik68/xampp:8 con il tasto destro e selezionale  open in browser.  

step5: se clicclando  su open in browser ti apparirà l'immagine di defoult di xampp allora significa che funziona tutto

step6: cliccare su phpMyAdmin

step7: creare il database tramite il file database.sql se non è già presente il database betterF1

step8:dublicare la pagina

step9: andare nell'URL ed cambiare /phpmyadmin/ con /www/






## schema e/r

![er](https://github.com/nicolabresciani/betterF1/assets/101709282/a2ad5dc0-c726-4014-aa03-e1512023751b)




## schema relazionale
- Amministratore(<ins>Username</ins>, Nome, Cognome, Password, Ruolo)
- SottoAmministratore(<ins>Username</ins>, Nome, Cognome, Password, Ruolo, Amministratore_Username)
- Utente(<ins>Username</ins>, Nome, Cognome, Password, DataDiNascita, LuogoNascita, Cellulare, Mail,Ruolo, Portafoglio_Username)
- Portafoglio(<ins>Username</ins>, Stato, Saldo)
- Prelievo(<ins>Id</ins>, Data, Importo, Portafoglio_Username)
- Scommessa(<ins>Id</ins>, ImportoScommesso, ImportoVinto, StatoScommessa, Data, Utente_Username, Gara_id, Amministratore_Username)
- Quota(<ins>Id</ins>, Valore, Stato, Gara_Id, SottoAmministratore_Username)
- ScommessaQuota(<ins>Scommessa_Id</ins>,<ins>Quota_Id</ins>)
- Gara(<ins>Id</ins>, Risultato, Stato, LuogoDiSvolta, SottoAmministratore_Username)
- Gestione(<ins> Id</ins>, NomeProgramma, SocietaAcquirente, DataVendita, DettagliVendita)





