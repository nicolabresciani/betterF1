<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrello</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    .saldo {
        margin-bottom: 20px;
    }
    .saldo span {
        font-weight: bold;
    }
    .home-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }
</style>
</head>
<body>

<div class="container">
    <h1>Carrello</h1>

    <!-- Tabella del carrello -->
    <table id="carrello">
        <thead>
            <tr>
                <th>Nominativo Pilota</th>
                <th>Quota</th>
                <th>Possibile Importo Vittoria</th>
                <th>Stato Scommessa</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <!-- Questo è un esempio di riga aggiunta dinamicamente -->
            <!-- <tr>
                <td>Pilota</td>
                <td>Quota</td>
                <td>Importo Vittoria</td>
                <td>Stato</td>
                <td>Data</td>
            </tr> -->
        </tbody>
    </table>

    <!-- Link per tornare alla Home -->
    <a href="Home.php" class="home-link">Torna alla pagina Home</a>
</div>

<!-- Aggiungi qui eventuali script JavaScript -->

</body>
</html>
