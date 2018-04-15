<?php session_start();
  require 'funciones.php';

  // CONEXION CON LA BASE DE DATOS. (PDO)
  $conexion = conexion_pdo($BaseDatos_config);
  if (!$conexion) {
    echo "Error de CONEXION!!!";
  } else {
    echo "CONEXION exitosa!!!";
    require(RAIZ . '/views/index.view.php');

  }
