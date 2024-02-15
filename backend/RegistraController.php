<?php
session_start();
// Connessione al database 
$servename = "localhost";
$username = "root";
$password = "";
$dbname = "betterF1";

$conn = new mysqli($servename, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Funzione per validare l'email
function validaEmail($email) {
    return strpos($email, '@') !== false
        && (strpos($email, '.it') !== false || strpos($email, '.com') !== false);
}

// Funzione per validare il numero di telefono (10 cifre)
function validaNumeroTelefono($numero) {
    return preg_match('/^\d{10}$/', $numero);
}

// Funzione per verificare il formato della data di nascita
function isValidDateFormat($dateString) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $dateString);
    return $dateTime && $dateTime->format('Y-m-d') === $dateString;
}

// funzione che crea un token lungo 6 numeri che vanno a 0 a 9
function generaToken() {
    $token = "";
    for ($i = 0; $i < 6; $i++) {
        $token .= rand(0, 9);
    }
    return $token;
}


// Registrazione utente
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $password = $_POST["password"];
    $dataDiNascita = $_POST["dataDiNascita"];
    $luogoNascita = $_POST["luogoNascita"];
    $cellulare = $_POST["cellulare"];
    $mail = $_POST["mail"];
    $ruolo = $_POST["ruolo"];

    $hashPassword = md5($password);

    // Verifica se il nome, email esistono già nel database
    $verifica = "SELECT * FROM Utente WHERE Username='$username' AND Mail='$mail' AND cellulare='$cellulare'";
    $result = $conn->query($verifica);

    if ($result->num_rows > 0) {
        echo "Errore: Il nome utente '$username' o l'indirizzo email '$mail' sono già in uso o il numero di telefono '$cellulare' è già registrato.";
    } else {
        // Validazione dell'email
        if (validaEmail($mail)) {
            // Validazione del numero di telefono
            if (validaNumeroTelefono($cellulare)) {
                // Validazione del formato della data di nascita
                if (!isValidDateFormat($dataDiNascita)) {
                    echo "Errore: Il formato della data di nascita non è valido.";
                    exit();
                }   

                $true = true;     
                // Genera il token
                $token = generaToken();        
                
                // Determina il ruolo
                $ruoloAssegnato = ($ruolo === "sottoAmministratore") ? "SottoAmministratore" : "Utente Normale";

                // Inserimento dati nel database - Utente solo se il ruolo non è "SottoAmministratore"
                if ($ruoloAssegnato !== "SottoAmministratore") {
                    $sql = "INSERT INTO Utente (Username, Nome, Cognome, Password, DataDiNascita, LuogoNascita, Cellulare, Mail, Ruolo, CodiceValidazione) 
                            VALUES ('$username', '$nome', '$cognome', '$hashPassword', '$dataDiNascita', '$luogoNascita', '$cellulare', '$mail', '$ruoloAssegnato', '$token')";

                    // Esegui la query solo se $sql è stato inizializzato
                    if (!empty($sql)) {
                        if ($conn->query($sql) !== TRUE) {
                            echo "Errore: " . $sql . "<br>" . $conn->error;
                            exit();
                        }
                    }
                }

                // Inserimento dati nel database - Portafoglio solo per gli utenti normali
                if ($ruoloAssegnato === "Utente Normale") {
                    $crea = "INSERT INTO Portafoglio (Username, Stato, Saldo) VALUES ('$username', '$true', 0)";

                    // Esegui la query solo se $crea è stato inizializzato
                    if (!empty($crea)) {
                        if ($conn->query($crea) !== TRUE) {
                            echo "Errore: " . $crea . "<br>" . $conn->error;
                            exit();
                        }
                    } else {
                        echo "Errore: La query di inserimento nel Portafoglio non è stata inizializzata correttamente.";
                        exit();
                    }
                }

                // Inserimento dati nella tabella sottoAmministratore se l'utente è un sottoAmministratore
                if ($ruoloAssegnato === "SottoAmministratore") {
                    // Verifica se l'amministratore "Nick" esiste nella tabella Amministratore
                    $verificaAmministratore = "SELECT * FROM Amministratore WHERE Username='Nick'";
                    $resultAmministratore = $conn->query($verificaAmministratore);

                    if ($resultAmministratore->num_rows > 0) {
                        $inserisciSottoAmministratore = "INSERT INTO SottoAmministratore (Username, Nome, Cognome, Password, Ruolo, Amministratore_Username) 
                                                        VALUES ('$username', '$nome', '$cognome', '$hashPassword', '$ruoloAssegnato', 'Nick')";

                        if ($conn->query($inserisciSottoAmministratore) !== TRUE) {
                            echo "Errore nell'inserimento nella tabella sottoAmministratore: " . $conn->error;
                            exit();
                        }
                    } else {
                        echo "Errore: L'amministratore 'Nick' non esiste nella tabella Amministratore.";
                        exit();
                    }
                }

                echo "Registrazione avvenuta con successo";
                // Carica l'username in sessione
                $_SESSION["username"] = $username;
                header("location: ../frontend/PaginaCodiceValidazione.php");
                exit();
            } else {
                echo "Errore: Il numero di telefono deve essere lungo 10 cifre.";
                exit();
            }
        } else {
            echo "Errore: L'indirizzo email non è valido.";
            exit();
        }
    }
}

// Chiudi connessione database
$conn->close();

// Esci dallo script
exit();
?>
