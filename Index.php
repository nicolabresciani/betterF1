<?php
session_start();

// Verifica se l'utente è autenticato
if (isset($_SESSION["username"])) {
    // Se l'utente è autenticato, reindirizza alla home
    header("Location: home.php");
    exit();
} else {
    // Se l'utente non è autenticato, reindirizza alla pagina di registrazione
    header("Location: Registra.php");
    exit();
}
?>
