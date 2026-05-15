<?php
session_start();

if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("location: index.php");
    exit();
}

require "sesion/conexion.php";

$correo_sesion = $_SESSION["correo"];
$id_libro = filter_input(INPUT_POST, "id_libro", FILTER_VALIDATE_INT);
$origen = $_POST["origen"] ?? "index.php";
$destino = $origen === "buscarLibros.php" ? "buscarLibros.php" : "index.php";

if ($destino === "buscarLibros.php" && isset($_POST["titulo"])) {
    $destino .= "?titulo=" . urlencode($_POST["titulo"]);
}

function volver_con_mensaje($destino, $tipo, $mensaje) {
    $separador = strpos($destino, "?") === false ? "?" : "&";
    header("location: " . $destino . $separador . $tipo . "=" . urlencode($mensaje));
    exit();
}

if (!$id_libro) {
    volver_con_mensaje($destino, "error", "Libro no valido.");
}

$stmt_usuario = $_conexion->prepare("SELECT id_usuario, nombre_usuario FROM usuarios WHERE email = ?");
$stmt_usuario->bind_param("s", $correo_sesion);
$stmt_usuario->execute();
$usuario_actual = $stmt_usuario->get_result()->fetch_assoc();
$stmt_usuario->close();

if (!$usuario_actual) {
    volver_con_mensaje($destino, "error", "No se ha encontrado el usuario de la sesion.");
}

$id_usuario_actual = (int) $usuario_actual["id_usuario"];

$stmt_libro = $_conexion->prepare(
    "SELECT id_libro, titulo, disponible, tipo_oferta, id_usuario
     FROM libros
     WHERE id_libro = ?"
);
$stmt_libro->bind_param("i", $id_libro);
$stmt_libro->execute();
$libro = $stmt_libro->get_result()->fetch_assoc();
$stmt_libro->close();

if (!$libro) {
    volver_con_mensaje($destino, "error", "El libro solicitado no existe.");
}

$id_usuario_propietario = (int) $libro["id_usuario"];

if ($id_usuario_propietario === $id_usuario_actual) {
    volver_con_mensaje($destino, "error", "No puedes solicitar el intercambio de tu propio libro.");
}

if ((int) $libro["disponible"] !== 1 || $libro["tipo_oferta"] !== "intercambio") {
    volver_con_mensaje($destino, "error", "El libro no esta disponible para intercambio.");
}

$stmt_duplicado = $_conexion->prepare(
    "SELECT id_intercambio
     FROM intercambios
     WHERE id_libro = ? AND id_usuario_interesado = ? AND estado = 'pendiente'"
);
$stmt_duplicado->bind_param("ii", $id_libro, $id_usuario_actual);
$stmt_duplicado->execute();
$intercambio_existente = $stmt_duplicado->get_result()->fetch_assoc();
$stmt_duplicado->close();

if ($intercambio_existente) {
    volver_con_mensaje($destino, "error", "Ya tienes una solicitud pendiente para este libro.");
}

try {
    $_conexion->begin_transaction();

    $estado = "pendiente";
    $stmt_insert = $_conexion->prepare(
        "INSERT INTO intercambios (id_libro, id_usuario_interesado, fecha, estado)
         VALUES (?, ?, CURDATE(), ?)"
    );
    $stmt_insert->bind_param("iis", $id_libro, $id_usuario_actual, $estado);
    $stmt_insert->execute();
    $id_intercambio = $stmt_insert->insert_id;
    $stmt_insert->close();

    $mensaje = $usuario_actual["nombre_usuario"] . " ha solicitado intercambiar " . $libro["titulo"] . ".";
    $stmt_notificacion = $_conexion->prepare(
        "INSERT INTO notificaciones (id_usuario_destino, id_intercambio, mensaje)
         VALUES (?, ?, ?)"
    );
    $stmt_notificacion->bind_param("iis", $id_usuario_propietario, $id_intercambio, $mensaje);
    $stmt_notificacion->execute();
    $stmt_notificacion->close();

    $_conexion->commit();
    volver_con_mensaje($destino, "mensaje", "Solicitud de intercambio enviada correctamente.");
} catch (Throwable $e) {
    $_conexion->rollback();
    volver_con_mensaje($destino, "error", "No se pudo registrar la solicitud de intercambio.");
}
?>
