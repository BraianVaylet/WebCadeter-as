<?php session_start();

// comprobamos q el usuario no tenga una sesion iniciada.
if (isset($_SESSION['correo'])) {
	header('Location: contenido.php');
} else {
	header('Location: login.php');
}

 ?>
