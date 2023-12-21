<?php
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

function generaChiaveUnica($lunghezza = 5, $file) {
    // Genera una chiave unica
    $caratteri = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $chiave = '';
    for ($i = 0; $i < $lunghezza; $i++) {
        $chiave .= $caratteri[rand(0, strlen($caratteri) - 1)];
    }

    // Scrivi sempre la nuova chiave sul file sovrascrivendo quella esistente
    file_put_contents($file, $chiave);

    return $chiave;
}


// Genera una chiave unica
$chiave = generaChiaveUnica(5, 'contieneChiave.txt');
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
    // Verifica se il nome,email esistono già nel database
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

                // Lettura del contenuto del file contieneChiave.txt
                $chiaveContenuto = trim(file_get_contents('contieneChiave.txt')); // Assicurati di rimuovere spazi bianchi


                if ($chiaveContenuto === $ruolo) {
                    // Se corrispondono, ruolo sarà "sottoAmministratore"
                    $ruolo = "sottoAmministratore";
                    $amministratoreUsername = 'Nick';  // L'utente amministratore è sempre lo stesso
                    
                    $inserisci = "INSERT INTO SottoAmministratore(Username, Nome, Cognome, Password, Ruolo, Amministratore_Username) VALUES ('$username', '$nome', '$cognome', '$hashPassword', '$ruolo', '$amministratoreUsername')";
                    
                    // Esegui la query e verifica eventuali errori
                    if ($conn->query($inserisci) === TRUE) {
                        echo "Registrazione avvenuta con successo";
                        header("Location: Login.php");
                    } else {
                        echo "Errore nell'inserimento nella tabella SottoAmministratore: " . $conn->error;
                    }
                } else {
                    // Altrimenti, ruolo sarà "utente"
                    $ruolo = "utente";
                    // Inserimento dati nel database
                    $sql = "INSERT INTO Utente (Username, Nome, Cognome, Password, DataDiNascita, LuogoNascita, Cellulare, Mail, Ruolo) 
                        VALUES ('$username', '$nome', '$cognome', '$hashPassword', '$dataDiNascita', '$luogoNascita', '$cellulare', '$mail', '$ruolo')";   
                }
                
                // Esegui la query solo se $sql è stato inizializzato
                if (!empty($sql)) {
                    if ($conn->query($sql) === TRUE) {
                        echo "Registrazione avvenuta con successo";
                        header("Location: Login.php");
                        exit();
                    } else {
                        echo "Errore: " . $sql . "<br>" . $conn->error;
                    }
                }
            } else {
                echo "Errore: Il numero di telefono deve essere lungo 10 cifre.";
            }
        } else {
            echo "Errore: L'indirizzo email non è valido.";
        }
    }
}

// Chiudi connessione database
$conn->close();


// Esci dallo script
exit();
?>
