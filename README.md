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
 - Utente("Username", Nome, Cognome, Password, DataDiNascita,LuogoNascita,Cellulare,Mail, Portafoglio_Username)
 - Portafoglio("Username",StoricoTransizioni,Stato,Saldo)
 - Scommessa("Id", ImportoScommesso, ImportoVinto,StatoScomessa,Data,Utente_Username,Gara_Id)
 - Gara("Id",Risultato,Stato,LuogoDiSvolta)
 - Quota("Id",Valore,Stato,Gara_Id)
 - Corrisponde("Scomessa_Id", "Quota_Id")


## immagine Idea progetto
[https://www.figma.com/file/b57SL7CJmJw4aP5jxUB6Uh/Untitled?type=design&node-id=1%3A7&mode=design&t=qWkPDgJFIFG2SPJi-1](https://www.figma.com/file/b57SL7CJmJw4aP5jxUB6Uh/Untitled?type=design&node-id=1-7&mode=design&t=xn2yJvzScWvV6kkU-0)https://www.figma.com/file/b57SL7CJmJw4aP5jxUB6Uh/Untitled?type=design&node-id=1-7&mode=design&t=xn2yJvzScWvV6kkU-0

