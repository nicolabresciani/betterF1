<?php
session_start();

// Distruggi tutte le variabili di sessione
session_destroy();

// Reindirizza alla pagina di login
header("Location:../frontend/Login.php");
exit();
?>
