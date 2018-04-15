<?php
    /* FUNCIONES DE WOLALOW */

    require 'configuracion.php';

    // CONEXION CON BASE DE DATOS. (PDO)
    function conexion_pdo($BaseDatos_config){
        try {
          $conexion = new PDO('mysql:host=localhost;dbname='.$BaseDatos_config['basedatos'], $BaseDatos_config['bd_usuario'], $BaseDatos_config['bd_pass']);
          return $conexion;
        } catch (PDOException $e) {
          return false;
        }
    }

    // LIMPIA EL CONTENIDO Q SE LE PASE:
  	function limpiarDatos($datos){
        //$datos = strtolower($datos);
    		$datos = trim($datos); // ELIMINA LOS ESPACIOS EN BLANCO EN LOS EXTREMOS.
    		$datos = stripslashes($datos);	// QUITA LAS '/' PARA NO INYECTAR CODIGO.
    		$datos = htmlspecialchars($datos);
    		return $datos;
  	}

    // EXISTENCIA ---> revisar
    function ya_existe($tabla, $campo, $col){
        $statement = $conexion->prepare("SELECT $col FROM $tabla WHERE $campo = :$campo LIMIT 1");
        $statement->execute(array(':'.$campo => '$' . $campo));
        $resultado = $statement->fetch();
        return $resultado;
    }

    // RETORNA LOS VALORES Q SE LE PASE DESPUES DE LIMPIAR LOS DATOS Y PASADOS A INT:
  	function int_datos($datos){
  		  return (int)limpiarDatos($datos);
  	}

    // ENCRIPTO INFORMACION.
    function campo_seguro($dato){
        $dato = hash('sha512', $dato); //sha512: algoritmo de encriptamiento
        return $dato;
    }

    // SUBIMOS LA FOTO.
    function subir_foto($foto, $carpeta){
      $check = @getimagesize($_FILES[$foto]['tmp_name']); //en caso de q no sea una imagen devuelve false
      if ($check !== false) {
          $carpeta_destino = $carpeta .'/'; //carpeta donde guardo la foto.
          $archivo_subido = $carpeta_destino . $_FILES[$foto]['name']; // ruta de la imagen.

          move_uploaded_file($_FILES[$foto]['tmp_name'], $archivo_subido); //para subir la foto.
      }
    }

    // COMPROBAMOS SI HAY SESION.
    function session(){
      if (isset($_SESSION['correo'])) {
        return true;
    	} else {
    		return false;
    	}
    }

    // RECIBE LA FECHA Y LA DEVUELVE DE OTRA MANERA:
  	function fecha($fecha){
  		$timestamp = strtotime($fecha); // CONVIERTE DE CADENA DE TEXTO A TIEMPO.
  		$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

  		$dia = date('d', $timestamp); // OBTENEMOS EL DIA.
  		$mes = date('m', $timestamp) - 1;	// OTENEMOS EL MES.
  		$year = date('Y', $timestamp); // OBTENEMOS EL AÑO.

  		$fecha = "$dia de " . $meses[$mes] . " del $year";
  		return $fecha;
  	}

    //VALIDAR CONTRASEÑA.
    function validar_clave($password,&$error_password){
       if(strlen($password) < 6){
          $error_password = "La clave debe tener al menos 6 caracteres";
          return false;
       }
    //   if(strlen($password) > 16){
    //       $error_password = "La clave no puede tener más de 16 caracteres";
    //       return false;
    //   }
       if (!preg_match('`[0-9]`',$password)){
          $error_password = "La clave debe tener al menos un caracter numérico";
          return false;
       }
       //opcionales:
       // if (!preg_match('`[a-z]`',$password)){
       //    $error_password = "La clave debe tener al menos una letra minúscula";
       //    return false;
       // }
       // if (!preg_match('`[A-Z]`',$password)){
       //    $error_password = "La clave debe tener al menos una letra mayúscula";
       //    return false;
       // }
       $error_password = "";
       return true;
    }
