#pa- betterF1

problema: gestione delle quote e delle scommesse sulla f1 (ispirato alla better)

target: centri scommesse di piccole dimensioni

## funzionalità:
- Gli utenti possono registrarsi fornendo le informazioni richieste ( username, password, mail, cell) e (nome, cognome, luogo di nascita, anno di nascita)    "(svolto)"
- Gli utenti possono accedere utilizzando le loro credenzial (username e password)    "(svolto)"
- Gli utenti possono recuperare credenziali (password) oppure recupero credenziali (username) oppure entrambe    "(ci sto lavorando)"
- Gli utenti possono effettuare transazioni di deposito e prelievo nel loro portafoglio virtuale    "(ci sto lavorando)"
- Gli utenti possono effettuare scommesse sulla Formula 1.
- gestione delle scommesse (poter annullare le scommesse, visualizzarle)
- Gli amministratori possono gestire le quote per le varie gare di Formula 1.
- I risultati delle simulazioni delle gare sono visualizzabili dagli utenti.


## come far partire il progetto
-step1: accedere al codespaces online

-step2: verifica che sia installata l'estensione docker, se non fosse installata installarla

step3: incollare il seguente link nel terminale e aspettare che finisca di installare le estensioni docker run --name myXampp -p 41061:22 -p 41062:80 -d -v /workspaces/betterF1:/www tomsik68/xampp:8

step4: aprire l'estensione docker, aprire la sezione CONTAINERS, aprire l'eventuale se presente Individual Containers, e far partire il tutto cliccando con il tasto destro del mouse start su  tomsik68/xampp:8.  possiamo capire che è partito perche prima di tomsik68/xampp:8 apparirà un triangolo verde.se apparirà un traingolo verde cliccare di nuovo con il tasto destro open in browser su tomsik68/xampp:8. invece se apparirà invece un quadrato rosso significa che non è partito, quindi rifare la procedura per farlo partire.
step5: se clicclando  su open in browser ti apparirà l'immagine di defoult di xampp allora significa che funziona tutto

step6: cliccare su phpMyAdmin

step7: creare il database tramite il file database.sql se non è già presente il database betterF1

step8:dublicare la pagina

step9: andare nell'URL ed eliminare 



## schema e/r
![schemaER](https://github.com/nicolabresciani/betterF1/assets/101709282/1b4f7bf7-cb14-47b5-aefa-30d2936eb99e)



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



## immagine Idea progetto
![Screenshot 2023-10-30 124605](https://github.com/nicolabresciani/betterF1/assets/101709282/c4a65f3f-4bbc-495b-aa68-a6455c455e50)
![Screenshot 2023-10-30 124650](https://github.com/nicolabresciani/betterF1/assets/101709282/9276a2b4-d547-4f94-8f66-5360d9b1b2c4)
![Screenshot 2023-10-30 124736](https://github.com/nicolabresciani/betterF1/assets/101709282/659aa23f-dda3-4ff1-9199-2db008fa4a90)
![Screenshot 2023-10-30 125728](https://github.com/nicolabresciani/betterF1/assets/101709282/7129b54e-0136-45f8-a05a-c8bdd7cae0c9)
![Screenshot 2023-10-30 125753](https://github.com/nicolabresciani/betterF1/assets/101709282/eaea51d6-bb07-4d17-ad48-70b2275489dc)


