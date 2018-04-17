<?php session_start();
require 'funciones.php';

if (isset($_SESSION['correo'])) {
	require 'views/contenido.view.php';
} else {
	header('Location: login.php');
}

?>
