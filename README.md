# betterF1

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


