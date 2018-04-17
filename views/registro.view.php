<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no,
	 initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	 <link href='https://fonts.googleapis.com/css?family=Raleway:400,300' rel='stylesheet' type='text/css'>
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	 <link rel="stylesheet" href="css/estilos.css">
	<title>Registrate</title>
</head>
<body>
	<div class="contenedor">
		<h1 class="titulo">Registrate</h1>
		<hr class="border">

		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="formulario" name="login" enctype="multipart/form-data" id="formulario">
			<div class="form-group">
				<i class="icono izquierda fa fa-user"></i><input type="text" name="usuario" class="usuario" placeholder="Usuario">
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-user"></i><input type="email" name="correo" class="correo" placeholder="Correo">
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-user"></i><input type="email" name="mercadopago" class="mercadopago" placeholder="Cuenta mercadopago">
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-user"></i><input type="file" name="foto_perfil" class="foto_perfil" placeholder="Foto de perfil">
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-user"></i><select name="type_usuario[]" class="type_usuario" placeholder="Seleccione tipo de registro">
					<option class="type_usuario" value="cliente">Cliente</option>
					<option class="type_usuario" value="cadete">Cadete Particular</option>
					<option class="type_usuario" value="empresa">Empresa</option>
				</select>
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-lock"></i><input type="password" name="password" class="password" placeholder="Contraseña">
			</div>

			<div class="form-group">
				<i class="icono izquierda fa fa-lock"></i><input type="password" name="password2" class="password2" placeholder="Repetir Contraseña">
				<i class="submit-btn fa fa-arrow-right" onclick="login.submit()"></i>
			</div>			

			<?php if(!empty($errores)): ?>
				<div class="error">
					<ul>
						<?php echo $errores; ?>
					</ul>
				</div>
			<?php endif; ?>
		</form>

		<p class="texto-registrate">
			¿ Ya tienes cuenta ?
			<a href="login.php">Iniciar Sesión</a>
		</p>
	</div>
</body>
</html>
