<?php

$_servidor = "localhost";
$_usuario = "MEDAC";
$_contrasena = "MEDAC";
$_bd = "intercambios_bd";

//Me conecto al server

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$_conexion = new mysqli($_servidor, $_usuario, $_contrasena, $_bd);

if ($_conexion->connect_error) {
    die("Error de conexión: " . $_conexion->connect_error);
}