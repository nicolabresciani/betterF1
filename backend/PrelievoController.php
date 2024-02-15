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

// Funzione per verificare se il numero della carta è numerico e lungo 16 cifre
function isValidCardNumber($cardNumber) {
    return is_numeric($cardNumber) && strlen($cardNumber) == 16;
}

// Funzione per verificare il formato della data (MM/YYYY)
function isValidDateFormat($dateString) {
    $pattern = '/^(0[1-9]|1[0-2])\/[0-9]{4}$/';
    return preg_match($pattern, $dateString);
}

// Funzione per verificare il CVV
function isValidCVV($cvv) {
    return $cvv == "123"; // CVV di esempio, modifica secondo le tue esigenze di sicurezza
}

// Funzione per ottenere la data odierna nel formato Y-m-d
function getCurrentDate() {
    return date("Y-m-d");
}

// Verifica se l'utente è autenticato
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $importo = $_POST["importo"];
        $numeroCarta = $_POST["numero_carta"];
        $scadenzaCarta = $_POST["scadenza_carta"];
        $cvv = $_POST["cvv"];

        // Verifica delle condizioni
        if (isValidCardNumber($numeroCarta) && isValidDateFormat($scadenzaCarta) && isValidCVV($cvv)) {
            //controllo se il saldo è sufficiente
            $sqlControlloSaldo = "SELECT Saldo FROM Portafoglio WHERE Username = '$username'";
            $result = $conn->query($sqlControlloSaldo);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $saldoAttuale = $row["Saldo"];

                if ($saldoAttuale >= $importo) {
                    // Inserimento dati nel database nella tabella Prelievo
                    $sqlPrelievo = "INSERT INTO Prelievo (Data, Prelievo, Portafoglio_Username) 
                                    VALUES ('" . getCurrentDate() . "', '$importo', '$username')";
                    
                    if ($conn->query($sqlPrelievo) === TRUE) {
                        echo "Prelievo avvenuto con successo";
                        // Aggiornamento del saldo nella tabella Portafoglio
                        $sqlUpdateSaldo = "UPDATE Portafoglio SET Saldo = Saldo - $importo WHERE Username = '$username'";
                        $conn->query($sqlUpdateSaldo);
                        header("Location: ../frontend/Home.php");
                    } else {
                        echo "Errore nell'esecuzione della query di prelievo: " . $sqlPrelievo . "<br>" . $conn->error;
                    }
                } else {
                    echo "Errore: Saldo insufficiente. Saldo attuale: $saldoAttuale";
                }
            } else {
                echo "Errore nel recupero del saldo: " . $conn->error;
            }
        } else {
            echo "Errore: Controlla i dati inseriti.";
        }
    }
}
?>
