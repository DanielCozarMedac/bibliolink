<?php
session_start();

if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: perfil.php");
    exit();
}

require "sesion/conexion.php";

function volver_perfil($tipo, $mensaje) {
    header("location: perfil.php?" . $tipo . "=" . urlencode($mensaje));
    exit();
}

$id_intercambio = filter_input(INPUT_POST, "id_intercambio", FILTER_VALIDATE_INT);
$accion = $_POST["accion"] ?? "";

if (!$id_intercambio || !in_array($accion, ["aceptar", "rechazar"], true)) {
    volver_perfil("error", "Solicitud no valida.");
}

$correo_sesion = $_SESSION["correo"];

$stmt_usuario = $_conexion->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
$stmt_usuario->bind_param("s", $correo_sesion);
$stmt_usuario->execute();
$usuario_actual = $stmt_usuario->get_result()->fetch_assoc();
$stmt_usuario->close();

if (!$usuario_actual) {
    volver_perfil("error", "No se ha encontrado el usuario de la sesion.");
}

$id_usuario_actual = (int) $usuario_actual["id_usuario"];

$stmt_solicitud = $_conexion->prepare(
    "SELECT intercambios.id_intercambio,
            intercambios.id_libro,
            intercambios.id_usuario_interesado,
            intercambios.estado,
            libros.titulo,
            libros.id_usuario AS id_usuario_propietario,
            libros.disponible
     FROM intercambios
     JOIN libros ON intercambios.id_libro = libros.id_libro
     WHERE intercambios.id_intercambio = ?"
);
$stmt_solicitud->bind_param("i", $id_intercambio);
$stmt_solicitud->execute();
$solicitud = $stmt_solicitud->get_result()->fetch_assoc();
$stmt_solicitud->close();

if (!$solicitud) {
    volver_perfil("error", "La solicitud no existe.");
}

if ((int) $solicitud["id_usuario_propietario"] !== $id_usuario_actual) {
    volver_perfil("error", "No puedes gestionar solicitudes de libros que no son tuyos.");
}

if ($solicitud["estado"] !== "pendiente") {
    volver_perfil("error", "Esta solicitud ya fue gestionada.");
}

try {
    $_conexion->begin_transaction();

    $id_libro = (int) $solicitud["id_libro"];
    $id_usuario_interesado = (int) $solicitud["id_usuario_interesado"];

    if ($accion === "aceptar") {
        if ((int) $solicitud["disponible"] !== 1) {
            $_conexion->rollback();
            volver_perfil("error", "El libro ya no esta disponible.");
        }

        $estado_aceptado = "aceptado";
        $stmt_estado = $_conexion->prepare("UPDATE intercambios SET estado = ? WHERE id_intercambio = ?");
        $stmt_estado->bind_param("si", $estado_aceptado, $id_intercambio);
        $stmt_estado->execute();
        $stmt_estado->close();

        $stmt_libro = $_conexion->prepare("UPDATE libros SET disponible = FALSE WHERE id_libro = ?");
        $stmt_libro->bind_param("i", $id_libro);
        $stmt_libro->execute();
        $stmt_libro->close();

        $mensaje_aceptado = "Tu solicitud para intercambiar " . $solicitud["titulo"] . " ha sido aceptada.";
        $stmt_notificacion = $_conexion->prepare(
            "INSERT INTO notificaciones (id_usuario_destino, id_intercambio, mensaje)
             VALUES (?, ?, ?)"
        );
        $stmt_notificacion->bind_param("iis", $id_usuario_interesado, $id_intercambio, $mensaje_aceptado);
        $stmt_notificacion->execute();
        $stmt_notificacion->close();

        $mensaje_rechazo = "Tu solicitud para intercambiar " . $solicitud["titulo"] . " ha sido rechazada porque el libro ya no esta disponible.";
        $stmt_notificar_otros = $_conexion->prepare(
            "INSERT INTO notificaciones (id_usuario_destino, id_intercambio, mensaje)
             SELECT id_usuario_interesado, id_intercambio, ?
             FROM intercambios
             WHERE id_libro = ? AND estado = 'pendiente' AND id_intercambio <> ?"
        );
        $stmt_notificar_otros->bind_param("sii", $mensaje_rechazo, $id_libro, $id_intercambio);
        $stmt_notificar_otros->execute();
        $stmt_notificar_otros->close();

        $estado_rechazado = "rechazado";
        $stmt_rechazar_otros = $_conexion->prepare(
            "UPDATE intercambios
             SET estado = ?
             WHERE id_libro = ? AND estado = 'pendiente' AND id_intercambio <> ?"
        );
        $stmt_rechazar_otros->bind_param("sii", $estado_rechazado, $id_libro, $id_intercambio);
        $stmt_rechazar_otros->execute();
        $stmt_rechazar_otros->close();

        $_conexion->commit();
        volver_perfil("mensaje", "Solicitud aceptada correctamente.");
    }

    $estado_rechazado = "rechazado";
    $stmt_estado = $_conexion->prepare("UPDATE intercambios SET estado = ? WHERE id_intercambio = ?");
    $stmt_estado->bind_param("si", $estado_rechazado, $id_intercambio);
    $stmt_estado->execute();
    $stmt_estado->close();

    $mensaje_rechazado = "Tu solicitud para intercambiar " . $solicitud["titulo"] . " ha sido rechazada.";
    $stmt_notificacion = $_conexion->prepare(
        "INSERT INTO notificaciones (id_usuario_destino, id_intercambio, mensaje)
         VALUES (?, ?, ?)"
    );
    $stmt_notificacion->bind_param("iis", $id_usuario_interesado, $id_intercambio, $mensaje_rechazado);
    $stmt_notificacion->execute();
    $stmt_notificacion->close();

    $_conexion->commit();
    volver_perfil("mensaje", "Solicitud rechazada correctamente.");
} catch (Throwable $e) {
    $_conexion->rollback();
    volver_perfil("error", "No se pudo gestionar la solicitud.");
}
?>