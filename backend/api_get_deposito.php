<?php
    // connessione al database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "betterf1";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // verifica della connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // esegui la query per ottenere la data e l'importo dei depositi
    $sql = "SELECT Data, Importo FROM Deposito";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $depositi = array();
        while ($row = $result->fetch_assoc()) {
            $depositi[] = $row;
        }
        echo json_encode($depositi);
    } else {
        echo json_encode(array("message" => "Nessun deposito trovato"));
    }

    $conn->close();
?>