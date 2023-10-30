# betterF1

problema: gestione delle quote e delle scommesse sulla f1 (ispirato alla better)

target: centri scommesse di piccole dimensioni

## funzionalità:
- registrare un utente ( username, password, mail, cell) e (nome, cognome, luogo di nascita, anno di nascita)
- far accedere un utente (username e password)
- recupero credenziali (password) oppure recupero credenziali (username) 
- avere un portafoglio virtuale e caricare i soldi
- poter far scommettere gli utenti
- gestione delle scommesse (poter annullare le scommesse, visualizzarle)
- far vedere i risulati della simulazione

## schema e/r
![Screenshot 2023-10-30 121318](https://github.com/nicolabresciani/betterF1/assets/101709282/f5f7789b-c040-4716-be11-6becd4a92ea4)




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
