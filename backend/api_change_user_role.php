<?php
session_start();

// Connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "betterF1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Gestione della richiesta di cambio ruolo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leggi i dati inviati
    $username = $_POST['username'];

    // Controllo per verificare se l'utente è già un sottoamministratore
    $checkQuery = "SELECT * FROM SottoAmministratore WHERE Username='$username'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // L'utente è un sottoamministratore, rimuovi l'utente dalla tabella dei sottoamministratori
        $deleteQuery = "DELETE FROM SottoAmministratore WHERE Username='$username'";
        if ($conn->query($deleteQuery) === TRUE) {
            // Aggiorna il ruolo dell'utente nella tabella Utente
            $updateUserRoleQuery = "UPDATE Utente SET Ruolo='Utente Normale' WHERE Username='$username'";
            $updateUserQuery = "UPDATE Utente SET stato = 'attivo' WHERE Username='$username'";
            if ($conn->query($updateUserRoleQuery) === TRUE && $conn->query($updateUserQuery) === TRUE) {
                echo json_encode(array("message" => "Ruolo utente ripristinato con successo"));
            } else {
                echo json_encode(array("error" => "Errore nell'aggiornamento del ruolo utente: " . $conn->error));
            }
        } else {
            echo json_encode(array("error" => "Errore nella rimozione dall'elenco dei sottoamministratori: " . $conn->error));
        }
    } else {
        // Query per ottenere i dati dell'utente dal database
        $getUserQuery = "SELECT Nome, Cognome, Password FROM Utente WHERE Username='$username'";
        $userResult = $conn->query($getUserQuery);

        if ($userResult !== false && $userResult->num_rows > 0) {
            // Ottieni i dati dell'utente dal risultato della query
            $userData = $userResult->fetch_assoc();
            $nome = $userData['Nome'];
            $cognome = $userData['Cognome'];
            $password = $userData['Password'];
            
            // Assegna l'username dell'amministratore (che è sempre "Nick")
            $amministratore_username = "Nick";

            // Controllo per verificare se l'utente è già un sottoamministratore
            $checkQuery = "SELECT * FROM SottoAmministratore WHERE Username='$username'";
            $result = $conn->query($checkQuery);

            if ($result->num_rows > 0) {
                // L'utente è già un sottoamministratore
                echo json_encode(array("error" => "L'utente è già un sottoamministratore"));
            } else {
                // L'utente non è un sottoamministratore, inseriscilo nella tabella dei sottoamministratori
                $insertQuery = "INSERT INTO SottoAmministratore (Username, Nome, Cognome, Password, Ruolo, Amministratore_Username) 
                                VALUES ('$username', '$nome', '$cognome', '$password', 'SottoAmministratore', '$amministratore_username')";
                if ($conn->query($insertQuery) === TRUE) {
                    // Aggiorna il ruolo dell'utente nella tabella Utente
                    $updateUserRoleQuery = "UPDATE Utente SET Ruolo='SottoAmministratore' WHERE Username='$username'";
                    $updateUserQuery = "UPDATE Utente SET stato='sospeso' WHERE Username='$username'";
                    if ($conn->query($updateUserRoleQuery) === TRUE && $conn->query($updateUserQuery) === TRUE) {
                        echo json_encode(array("message" => "Ruolo sottoamministratore aggiornato con successo"));
                    } else {
                        echo json_encode(array("error" => "Errore nell'aggiornamento del ruolo sottoamministratore: " . $conn->error));
                    }
                } else {
                    echo json_encode(array("error" => "Errore nell'inserimento nell'elenco dei sottoamministratori: " . $conn->error));
                }
            }
        } else {
            echo json_encode(array("error" => "Nessun utente trovato con il nome utente specificato"));
        }
    }
}

// Chiudi la connessione
$conn->close();
?>
