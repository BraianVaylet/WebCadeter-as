<?php session_start();

session_destroy(); //destruimos la sesion para cerrarla
$_SESSION = array(); //dejamos la sesion en cero, la limpiamos.

header('Location: login.php');

?>
