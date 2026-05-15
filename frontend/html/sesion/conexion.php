<?php

$env = parse_ini_file('.env');

$_servidor = $env['DB_HOST'];
$_bd = $env['DB_NAME'];
$_usuario = $env['DB_USER'];
$_contrasena = $env['DB_PASS'];

//Me conecto al server

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$_conexion = new mysqli($_servidor, $_usuario, $_contrasena, $_bd);

if ($_conexion->connect_error) {
    die("Error de conexión: " . $_conexion->connect_error);
}