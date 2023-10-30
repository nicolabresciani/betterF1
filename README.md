# betterF1

problema: gestione delle quote e delle scommesse sulla f1 (ispirato alla better)

## funzionalità:
- registrare un utente ( username, password, mail, cell) e (nome, cognome, luogo di nascita, anno di nascita)
- far accedere un utente (username e password)
- recupero credenziali (password) oppure recupero credenziali (username) 
- avere un portafoglio virtuale e caricare i soldi
- poter far scommettere gli utenti
- gestione delle scommesse (poter annullare le scommesse, visualizzarle)
- calcolo delle quote
- gestione delle quote(poter modificare le quote delle scommesse in base alla simulazione) //pensare a come modificare le quote
- simulazione della gara
- far vedere i risulati della simulazione

## schema e/r
[https://app.creately.com/d/z5yEZSXlUGu/edit](https://app.creately.com/d/z5yEZSXlUGu/edit)https://app.creately.com/d/z5yEZSXlUGu/edit



## schema relazionale
 - Utente(<ins>Username</ins>, Nome, Cognome, Password, DataDiNascita,LuogoNascita,Cellulare,Mail, Portafoglio_Username)
 - Portafoglio(<ins>Username</ins>,StoricoTransizioni,Stato,Saldo)
 - Scommessa(<ins>Id</ins>, ImportoScommesso, ImportoVinto,StatoScomessa,Data,Utente_Username,Gara_Id)
 - Gara(<ins>Id</ins>,Risultato,Stato,LuogoDiSvolta)
 - Quota(<ins>Id</ins>,Valore,Stato,Gara_Id)
 - Corrisponde(<ins>Scomessa_Id</ins>, "Quota_Id")


## immagine Idea progetto

![Screenshot 2023-10-30 120900](https://github.com/nicolabresciani/betterF1/assets/101709282/cca38373-e7b8-4f6c-86ba-9b8300813c21)
![Screenshot 2023-10-30 120921](https://github.com/nicolabresciani/betterF1/assets/101709282/f58d0515-d352-4f97-ae74-03e3264ae6a1)
![Screenshot 2023-10-30 120940](https://github.com/nicolabresciani/betterF1/assets/101709282/e7c852b6-d424-4a84-a4da-c48dbccdb06e)
![Screenshot 2023-10-30 120955](https://github.com/nicolabresciani/betterF1/assets/101709282/5b039b06-2973-4812-b1b2-109cf659649d)
