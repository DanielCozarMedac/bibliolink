<?php

session_start(); //Recuperamos sesión

$_SESSION = []; //Limpiamos los datos del array global sesión

session_destroy(); //Elimina todos los datos de la sesión en la parte del servidor.
//PERO la cookie PHPSESSID sigue existiendo en el navegador (pero sin datos asociados)

header("location: login.php"); //Redirigimos el cliente al login
exit();