<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Protección de ruta
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

require "sesion/conexion.php";
$correo_sesion = $_SESSION["correo"];
$mensaje_url = $_GET["mensaje"] ?? "";
$error_url = $_GET["error"] ?? "";

// 2. Obtener datos del usuario
$sql = "SELECT * FROM usuarios WHERE email = '$correo_sesion'";
$resultado = $_conexion->query($sql);
$usuario = $resultado->fetch_assoc();

$id_usuario_actual = $usuario['id_usuario'] ?? 0;

// 3. Lógica de actualización del perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = trim($_POST["nombre"] ?? '');
    $nueva_suscripcion = $_POST["suscripcion"] ?? 'gratuita';

    $sql_update = "UPDATE usuarios 
                   SET nombre_usuario = '$nuevo_nombre', 
                       tipo_suscripcion = '$nueva_suscripcion'
                   WHERE email = '$correo_sesion'";

    if ($_conexion->query($sql_update)) {
        $mensaje = "Perfil actualizado correctamente.";
        $usuario['nombre_usuario'] = $nuevo_nombre;
        $usuario['tipo_suscripcion'] = $nueva_suscripcion;
        $_SESSION["admin"] = $nueva_suscripcion;
    } else {
        $error = "Error al actualizar el perfil.";
    }
}

// 4. Consultas
$sql_mis_libros = "SELECT * FROM libros WHERE id_usuario = '$id_usuario_actual' ORDER BY id_libro DESC";
$mis_libros = $_conexion->query($sql_mis_libros);

$sql_solicitudes_recibidas = "SELECT i.id_intercambio, i.fecha, i.estado,
                                     l.titulo, u.nombre_usuario, u.email
                              FROM intercambios i
                              JOIN libros l ON i.id_libro = l.id_libro
                              JOIN usuarios u ON i.id_usuario_interesado = u.id_usuario
                              WHERE l.id_usuario = '$id_usuario_actual'
                              ORDER BY i.fecha DESC";

$solicitudes_recibidas = $_conexion->query($sql_solicitudes_recibidas);

$sql_solicitudes_enviadas = "SELECT i.fecha, i.estado,
                                    l.titulo, u.nombre_usuario AS propietario
                             FROM intercambios i
                             JOIN libros l ON i.id_libro = l.id_libro
                             JOIN usuarios u ON l.id_usuario = u.id_usuario
                             WHERE i.id_usuario_interesado = '$id_usuario_actual'
                             ORDER BY i.fecha DESC";

$solicitudes_enviadas = $_conexion->query($sql_solicitudes_enviadas);

$sql_notificaciones = "SELECT mensaje, fecha, leida
                       FROM notificaciones
                       WHERE id_usuario_destino = '$id_usuario_actual'
                       ORDER BY fecha DESC";

$notificaciones = $_conexion->query($sql_notificaciones);
?>

<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Mi Perfil - BiblioLink</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&amp;family=Merriweather:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <style type="text/tailwindcss">
        body { font-family: 'Merriweather', serif; }
        h1, h2, h3, h4, h5, h6, button, a, input, label, select {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F5F6F8] dark:bg-[#1E2A38] text-[#1E2A38] dark:text-[#F5F6F8]">

<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
<div class="flex h-full grow flex-col">

    <!-- HEADER -->
    <header class="flex items-center justify-between whitespace-nowrap px-4 sm:px-10 py-4 border-b border-[#E0E2E7] dark:border-[#1E2A38]/50 bg-white dark:bg-[#1E2A38]">
        <div class="flex items-center gap-4 text-[#1E2A38] dark:text-white">
            <div class="text-[#46C4B2] w-8 h-8 flex items-center justify-center">
                <span class="material-symbols-outlined !text-3xl">import_contacts</span>
            </div>
            <h2 class="text-xl font-bold">BiblioLink</h2>
        </div>

        <div class="hidden lg:flex flex-1 justify-center items-center gap-9">
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/inicio.php">Inicio</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/comunidad.php">Comunidad</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="index.php">Intercambios</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/chat.php">Chats</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/suscripcion.php">Suscripciones</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/contacto.php">Contacto</a>
        </div>

        <a href="sesion/logout.php" class="text-red-500 hover:text-red-600 font-medium transition-colors">
            Cerrar Sesión
        </a>
    </header>

    <main class="flex-grow px-4 sm:px-10 py-8 max-w-7xl mx-auto w-full">
        
        <!-- Mensajes -->
        <?php if (!empty($mensaje_url)): ?>
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl"><?= htmlspecialchars($mensaje_url) ?></div>
        <?php endif; ?>
        <?php if (!empty($error_url)): ?>
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl"><?= htmlspecialchars($error_url) ?></div>
        <?php endif; ?>
        <?php if (isset($mensaje)): ?>
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl"><?= $mensaje ?></div>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl"><?= $error ?></div>
        <?php endif; ?>

        <h1 class="text-4xl font-bold text-center mb-10">Mi Perfil</h1>

        <!-- GESTIÓN DE PERFIL -->
        <div class="bg-white dark:bg-[#1E2A38] rounded-3xl shadow-sm border border-gray-100 dark:border-white/10 p-8 mb-12">
            <h2 class="text-2xl font-bold mb-6">Gestionar Perfil</h2>
            <form action="" method="post" class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo Electrónico</label>
                    <input type="text" class="w-full h-11 px-4 rounded-2xl border border-gray-200 dark:border-white/20 bg-gray-50 dark:bg-white/5" 
                           value="<?= htmlspecialchars($usuario['email']) ?>" disabled>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre de Usuario</label>
                    <input type="text" name="nombre" class="w-full h-11 px-4 rounded-2xl border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-[#46C4B2]" 
                           value="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Suscripción</label>
                    <select name="suscripcion" class="w-full h-11 px-4 rounded-2xl border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-[#46C4B2]">
                        <option value="gratuita" <?= ($usuario['tipo_suscripcion'] ?? '') == 'gratuita' ? 'selected' : '' ?>>Gratuita</option>
                        <option value="premium" <?= ($usuario['tipo_suscripcion'] ?? '') == 'premium' ? 'selected' : '' ?>>Premium</option>
                    </select>
                </div>
                <div class="md:col-span-2 flex gap-4">
                    <button type="submit" class="flex-1 bg-[#46C4B2] hover:bg-[#3da999] text-white font-semibold py-4 rounded-2xl transition-colors">
                        Guardar Cambios
                    </button>
                    <a href="index.php" class="flex-1 text-center border border-gray-300 dark:border-white/20 font-semibold py-4 rounded-2xl hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- MIS LIBROS -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold">Mis Libros Subidos</h3>
                <a href="libros_nuevo.php" class="bg-[#46C4B2] hover:bg-[#3da999] text-white px-6 py-3 rounded-2xl flex items-center gap-2 font-medium">
                    <span class="material-symbols-outlined">add</span> Añadir Libro
                </a>
            </div>

            <?php if ($mis_libros->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($libro = $mis_libros->fetch_assoc()): ?>
                <div class="bg-white dark:bg-[#1E2A38] rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-white/10">
                    <div class="p-6">
                        <h4 class="font-bold text-lg"><?= htmlspecialchars($libro['titulo']) ?></h4>
                        <p class="text-[#46C4B2]"><?= htmlspecialchars($libro['autor']) ?></p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xl font-bold text-emerald-600">
                                <?= $libro['precio'] > 0 ? $libro['precio'] . '€' : 'Gratis' ?>
                            </span>
                            <div class="flex gap-2">
                                <a href="libros_editar.php?id=<?= $libro['id_libro'] ?>" 
                                   class="px-4 py-2 text-sm bg-amber-100 text-amber-700 rounded-2xl hover:bg-amber-200 transition-colors">Editar</a>
                                <a href="libros_borrar.php?id=<?= $libro['id_libro'] ?>" 
                                   onclick="return confirm('¿Eliminar este libro permanentemente?')" 
                                   class="px-4 py-2 text-sm bg-red-100 text-red-700 rounded-2xl hover:bg-red-200 transition-colors">Borrar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
            <?php else: ?>
                <div class="bg-white dark:bg-[#1E2A38] rounded-3xl p-12 text-center text-gray-500">
                    Aún no has subido ningún libro.
                </div>
            <?php endif; ?>
        </div>

        <!-- SOLICITUDES RECIBIDAS -->
        <div class="mb-12">
            <h3 class="text-2xl font-bold mb-6">Solicitudes de Intercambio Recibidas</h3>
            <div class="bg-white dark:bg-[#1E2A38] rounded-3xl overflow-hidden border border-gray-100 dark:border-white/10">
                <table class="w-full">
                    <thead class="bg-[#1E2A38] text-white">
                        <tr>
                            <th class="text-left p-6">Libro</th>
                            <th class="text-left p-6">Solicitante</th>
                            <th class="text-left p-6">Fecha</th>
                            <th class="text-left p-6">Estado</th>
                            <th class="p-6 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                        <?php if ($solicitudes_recibidas->num_rows > 0): ?>
                            <?php while ($s = $solicitudes_recibidas->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="p-6 font-medium"><?= htmlspecialchars($s['titulo']) ?></td>
                                <td class="p-6"><?= htmlspecialchars($s['nombre_usuario']) ?></td>
                                <td class="p-6 text-sm text-gray-500"><?= $s['fecha'] ?></td>
                                <td class="p-6">
                                    <?php 
                                    if ($s['estado'] == 'pendiente') echo '<span class="px-4 py-1 text-xs font-semibold rounded-2xl bg-amber-100 text-amber-700">Pendiente</span>';
                                    elseif ($s['estado'] == 'aceptado') echo '<span class="px-4 py-1 text-xs font-semibold rounded-2xl bg-green-100 text-green-700">Aceptado</span>';
                                    else echo '<span class="px-4 py-1 text-xs font-semibold rounded-2xl bg-red-100 text-red-700">Rechazado</span>';
                                    ?>
                                </td>
                                <td class="p-6">
                                    <?php if ($s['estado'] == 'pendiente'): ?>
                                    <div class="flex gap-3 justify-center">
                                        <form action="gestionar_intercambio.php" method="post">
                                            <input type="hidden" name="id_intercambio" value="<?= $s['id_intercambio'] ?>">
                                            <input type="hidden" name="accion" value="aceptar">
                                            <button type="submit" class="px-5 py-2 bg-green-600 text-white text-sm rounded-2xl hover:bg-green-700">Aceptar</button>
                                        </form>
                                        <form action="gestionar_intercambio.php" method="post">
                                            <input type="hidden" name="id_intercambio" value="<?= $s['id_intercambio'] ?>">
                                            <input type="hidden" name="accion" value="rechazar">
                                            <button type="submit" class="px-5 py-2 bg-red-600 text-white text-sm rounded-2xl hover:bg-red-700">Rechazar</button>
                                        </form>
                                    </div>
                                    <?php else: ?>
                                        <p class="text-center text-gray-500 text-sm">Gestionada</p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-500">No has recibido solicitudes de intercambio todavía.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- HISTORIAL DE SOLICITUDES ENVIADAS -->
        <div class="mb-12">
            <h3 class="text-2xl font-bold mb-6">Historial de Mis Solicitudes Enviadas</h3>
            <div class="bg-white dark:bg-[#1E2A38] rounded-3xl overflow-hidden border border-gray-100 dark:border-white/10">
                <table class="w-full">
                    <thead class="bg-[#1E2A38] text-white">
                        <tr>
                            <th class="text-left p-6">Libro</th>
                            <th class="text-left p-6">Propietario</th>
                            <th class="text-left p-6">Fecha</th>
                            <th class="text-left p-6">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                        <?php if ($solicitudes_enviadas->num_rows > 0): ?>
                            <?php while ($s = $solicitudes_enviadas->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="p-6 font-medium"><?= htmlspecialchars($s['titulo']) ?></td>
                                <td class="p-6"><?= htmlspecialchars($s['propietario']) ?></td>
                                <td class="p-6 text-sm text-gray-500"><?= $s['fecha'] ?></td>
                                <td class="p-6">
                                    <?php 
                                    if ($s['estado'] == 'pendiente') echo '<span class="px-4 py-1 text-xs font-semibold rounded-2xl bg-amber-100 text-amber-700">Pendiente</span>';
                                    elseif ($s['estado'] == 'aceptado') echo '<span class="px-4 py-1 text-xs font-semibold rounded-2xl bg-green-100 text-green-700">Aceptado</span>';
                                    else echo '<span class="px-4 py-1 text-xs font-semibold rounded-2xl bg-red-100 text-red-700">Rechazado</span>';
                                    ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="p-12 text-center text-gray-500">Aún no has enviado ninguna solicitud.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- NOTIFICACIONES -->
        <div>
            <h3 class="text-2xl font-bold mb-6">Notificaciones</h3>
            <div class="bg-white dark:bg-[#1E2A38] rounded-3xl overflow-hidden border border-gray-100 dark:border-white/10">
                <table class="w-full">
                    <thead class="bg-[#1E2A38] text-white">
                        <tr>
                            <th class="text-left p-6">Mensaje</th>
                            <th class="text-left p-6">Fecha</th>
                            <th class="text-left p-6">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/10">
                        <?php if ($notificaciones->num_rows > 0): ?>
                            <?php while ($n = $notificaciones->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="p-6"><?= htmlspecialchars($n['mensaje']) ?></td>
                                <td class="p-6 text-sm text-gray-500"><?= $n['fecha'] ?></td>
                                <td class="p-6">
                                    <?php if ((int)$n['leida'] === 1): ?>
                                        <span class="px-4 py-1 text-xs font-semibold rounded-2xl bg-gray-100 text-gray-600">Leída</span>
                                    <?php else: ?>
                                        <span class="px-4 py-1 text-xs font-semibold rounded-2xl bg-blue-100 text-blue-700">Nueva</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="p-12 text-center text-gray-500">No tienes notificaciones por el momento.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>
</div>
</body>
</html>