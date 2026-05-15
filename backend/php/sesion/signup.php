<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

require "conexion.php";

$err_usuario = $err_email = $err_contrasena = $err_rol = $mensaje_exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tmp_usuario = trim($_POST["usuario"] ?? '');
    $tmp_email = trim($_POST["email"] ?? '');
    $tmp_contrasena = $_POST["contrasena"] ?? '';
    $tmp_rol = $_POST["rol"] ?? '';

    // Validaciones
    if (empty($tmp_usuario)) $err_usuario = "Introduce tu nombre";
    if (empty($tmp_email)) $err_email = "Introduce tu correo electrónico";
    if (empty($tmp_contrasena)) $err_contrasena = "Introduce una contraseña";
    if (empty($tmp_rol) || $tmp_rol === "disabled selected") $err_rol = "Selecciona un tipo de suscripción";

    // Si no hay errores, procedemos a registrar
    if (empty($err_usuario) && empty($err_email) && empty($err_contrasena) && empty($err_rol)) {
        
        $contrasena_cifrada = password_hash($tmp_contrasena, PASSWORD_DEFAULT);

        $consulta = "INSERT INTO usuarios (nombre_usuario, email, contrasena, tipo_suscripcion) 
                     VALUES ('$tmp_usuario', '$tmp_email', '$contrasena_cifrada', '$tmp_rol')";

        try {
            if ($_conexion->query($consulta)) {
                $mensaje_exito = "¡Registro exitoso! Ya puedes iniciar sesión.";
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $err_email = "Este correo electrónico ya está registrado.";
            } else {
                $err_email = "Error al registrar: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Registro - BiblioLink</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Merriweather:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <style type="text/tailwindcss">
        body {
            font-family: 'Merriweather', serif;
        }
        h1, h2, h3, h4, h5, h6, button, a, input, label, select {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F5F6F8] dark:bg-[#1E2A38] min-h-screen flex items-center justify-center">

<div class="max-w-md w-full mx-auto px-6 py-12">
    
    <!-- Logo y Título -->
    <img src="../../../img/bibliolink.png" alt="No image">

    <div class="bg-white dark:bg-[#1E2A38] rounded-3xl shadow-xl border border-gray-100 dark:border-white/10 p-8">
        
        <h2 class="text-2xl font-bold text-center mb-8">Crear Cuenta</h2>

        <?php if (!empty($mensaje_exito)): ?>
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-5 py-4 rounded-2xl text-center">
                <?= htmlspecialchars($mensaje_exito) ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nombre Completo</label>
                <input type="text" name="usuario" 
                       class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 bg-white dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2]"
                       value="<?= htmlspecialchars($tmp_usuario ?? '') ?>" required>
                <?php if (!empty($err_usuario)): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $err_usuario ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correo Electrónico</label>
                <input type="email" name="email" 
                       class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 bg-white dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2]"
                       value="<?= htmlspecialchars($tmp_email ?? '') ?>" required>
                <?php if (!empty($err_email)): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $err_email ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contraseña</label>
                <input type="password" name="contrasena" 
                       class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 bg-white dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2]"
                       required>
                <?php if (!empty($err_contrasena)): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $err_contrasena ?></p>
                <?php endif; ?>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo de Suscripción</label>
                <select name="rol" 
                        class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 bg-white dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2]">
                    <option value="">-- Seleccione --</option>
                    <option value="gratuita" <?= ($tmp_rol ?? '') == 'gratuita' ? 'selected' : '' ?>>Gratuita</option>
                    <option value="premium" <?= ($tmp_rol ?? '') == 'premium' ? 'selected' : '' ?>>Premium</option>
                </select>
                <?php if (!empty($err_rol)): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $err_rol ?></p>
                <?php endif; ?>
            </div>

            <button type="submit" 
                    class="w-full bg-[#46C4B2] hover:bg-[#3da999] transition-colors text-white font-semibold py-4 rounded-2xl text-lg">
                Registrarse
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">
                ¿Ya tienes cuenta? 
                <a href="login.php" class="text-[#46C4B2] hover:underline font-medium">Inicia sesión</a>
            </p>
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="../index.php" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
            ← Volver al inicio
        </a>
    </div>
</div>

</body>
</html>