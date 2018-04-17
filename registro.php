<?php session_start();
			require 'funciones.php';

// comprobamos q el usuario no tenga una sesion iniciada.
if (isset($_SESSION['correo'])) {
	header('Location: index.php');
}

// LEVANTO VALORES DEL FORM.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$usuario = limpiarDatos(filter_var($_POST['usuario']),FILTER_SANITIZE_STRING);
		$correo = limpiarDatos(filter_var($_POST['correo']),FILTER_VALIDATE_EMAIL);
		$password = limpiarDatos(filter_var($_POST['password']),FILTER_SANITIZE_STRING);
		$password2 = limpiarDatos(filter_var($_POST['password2']),FILTER_SANITIZE_STRING);
		$mercadopago = limpiarDatos(filter_var($_POST['mercadopago']),FILTER_VALIDATE_EMAIL);
		$foto_perfil = $_FILES['foto_perfil']['tmp_name'];

	$errores = '';

	// TRABAJO LOS SELECT
	if (isset($_POST['type_usuario'])) {
		$type_usuario = $_POST['type_usuario'];
		for ($i = 0; $i < count($type_usuario); $i++) {
				$type_usuario = $type_usuario[$i];
		}
	} else {
		$errores = 'error';
	}

	// ENCRIPTAMOS LA CONTRASEÑA
	$password = campo_seguro($password);
	$password2 = campo_seguro($password2);

	// VALIDACION DEL FORMULARIO
	// COMPROBAMOS SI LOS CAMPOS ESTAN VACIOS
	if (empty($usuario)) {
		$errores = 'error';
	}

	if (empty($correo)) {
		$errores = 'error';
	}

	if (empty($password)) {
		$errores = 'error';
	} else {
		// Validacion del password.
		if (validar_clave($password, $error_encontrado)){
		}else{
			$errores = 'error';
		}
	}

	if (empty($password2)) {
		$errores = 'error';
	} elseif ($password2 != $password) {
		$errores = 'error';
	}

	if (empty($mercadopago)) {
		$errores = 'error';
	}

	// CONEXION CON LA BASE DE DATOS. (PDO)
	$conexion = conexion_pdo($BaseDatos_config);
	if (!$conexion) {
		echo "ERROR de conexión con la Base de Datos!!!";
		header('Location: ../error_conexion.php');
	} else {

				echo "CONEXION exitosa!!!";

				// CONSULTAS SQL EN LA BD. (PDO)
				// // #CASO EN Q EXISTA EL USUARIO
				// $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
				// $statement->execute(array(':usuario' => $usuario));
				// $resultado_usuario = $statement->fetch();
				// if ($resultado_usuario != false) {
				// 	$errores .= '<li>El nombre de usuario ya existe</li>';
				// }

				// // #CASO EN Q EXISTA EL CORREO
				// $statement = $conexion->prepare('SELECT * FROM usuarios WHERE correo = :correo LIMIT 1');
				// $statement->execute(array(':correo' => $correo));
				// $resultado_correo = $statement->fetch();
				// if ($resultado_correo != false) {
				// 	$errores .= '<li>ya existe una cuenta asociada a este correo</li>';
				// }

				// SUBIMOS LA FOTO
				$carpeta = 'fotos_perfiles';
				$foto = 'foto_perfil';
				subir_foto($foto, $carpeta);
				$foto_subida = $_FILES['foto_perfil']['name'];
				// CASO DE NO SUBIR IMAGEN, USO AVATAR
				if ($foto_subida == null) {
						$foto_subida = 'no_borrar/avatar.png';
				}

				// INSERTAMOS LOS DATOS EN LA BASE DE DATOS: (PDO)
				if ($errores == '') {
						$statement = $conexion->prepare('INSERT INTO usuarios (id, usuario, correo, password, mercadopago, type_usuario, foto_perfil) VALUES (null, :usuario, :correo, :password, :mercadopago, :type_usuario, :foto_perfil)');
						$statement->execute(array(
								':usuario' => $usuario,
								':correo' => $correo,
								':password' => $password,
								':mercadopago' => $mercadopago,
								':type_usuario' => $type_usuario,
								':foto_perfil' => $foto_subida
						));
						$filas = $statement->rowCount();
						if ($filas == 0) {
							header('Location: ../error_conexion.php');;
						}
						$_SESSION['correo'] = $correo;
						header('Location: contenido.php');
					}
				}
	}
require(RAIZ . 'views/registro.view.php');



?>
