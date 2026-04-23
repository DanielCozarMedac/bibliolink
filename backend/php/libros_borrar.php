<?php
session_start();

// 1. Verificamos que el usuario esté logueado
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

require "sesion/conexion.php";

// 2. Comprobamos que nos llega un ID por la URL
if (isset($_GET["id"])) {
    $id_libro = $_GET["id"];
    $correo_sesion = $_SESSION["correo"];

    // 3. SEGURIDAD: Obtenemos el ID del usuario actual
    // Esto evita que alguien borre libros de otros usuarios manipulando la URL
    $sql_user = "SELECT id_usuario FROM usuarios WHERE email = '$correo_sesion'";
    $res_user = $_conexion->query($sql_user);
    $usuario = $res_user->fetch_assoc();
    $id_usuario = $usuario['id_usuario'];

    // 4. Ejecutamos el borrado
    // Solo se borrará si el ID del libro coincide Y el id_usuario es el del dueño
    $sql_borrar = "DELETE FROM libros WHERE id_libro = '$id_libro' AND id_usuario = '$id_usuario'";
    
    if ($_conexion->query($sql_borrar)) {
        // Redirigimos al perfil con un mensaje de éxito (opcional)
        header("location: perfil.php?mensaje=eliminado");
    } else {
        // Si hay error, volvemos con aviso de error
        header("location: perfil.php?error=no_borrado");
    }
} else {
    // Si alguien intenta entrar a este archivo sin un ID, lo mandamos al perfil
    header("location: perfil.php");
}
exit();
?>