<?php session_start();
require 'funciones.php';

// comprobamos q el usuario no tenga una sesion iniciada.
if (isset($_SESSION['correo'])) {
	header('Location: index.php');
}

$errores = '';

// Comprobamos si los datos se enviaron.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$correo = limpiarDatos(filter_var($_POST['correo']),FILTER_VALIDATE_EMAIL); // pasamos a minuscula y quitamos los caracteres especiales.
	$password = limpiarDatos(filter_var($_POST['password']),FILTER_SANITIZE_STRING);
	$password = hash('sha512', $password); // hasheamos la contraseña. usamos algoritmo de cifrado sha512.

	// Nos Conectamos a la base de datos:
	$conexion = conexion_pdo($BaseDatos_config);
  if (!$conexion) { echo "ERROR de conexión!!!"; } else { echo "EXITO en la conexión!!!"; }

	 // verificamos si hay usuarios en la base de datos:
	 // Consultas:
	$statement = $conexion->prepare('SELECT * FROM usuarios WHERE correo = :correo AND password = :password');
	$statement->execute(array(
		':correo' => $correo,
		':password' => $password
	));

	$resultado = $statement->fetch(); // fetch devuelve el resultado.

	if ($resultado !== false) {
		$_SESSION['correo'] = $correo; // creamos una sesion.
		header('Location: index.php');
	} else {
		$errores .= '<li>No hay usuarios en la base de datos</li>';
	}
}

require 'views/login.view.php';

?>
