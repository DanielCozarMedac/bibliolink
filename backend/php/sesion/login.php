<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

require "conexion.php";

$error_general = "";

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tmp_correo = trim($_POST["correo"] ?? '');
    $tmp_contrasena = $_POST["contrasena"] ?? '';

    if (empty($tmp_correo)) {
        $error_general = "Por favor ingresa tu correo electrónico.";
    } elseif (empty($tmp_contrasena)) {
        $error_general = "Por favor ingresa tu contraseña.";
    } else {
        $consulta = "SELECT * FROM usuarios WHERE email = '$tmp_correo'";
        $resultado = $_conexion->query($consulta);

        if ($resultado->num_rows === 0) {
            $error_general = "El correo electrónico no está registrado.";
        } else {
            $user_info = $resultado->fetch_assoc();

            if (!password_verify($tmp_contrasena, $user_info["contrasena"])) {
                $error_general = "Contraseña incorrecta.";
            } else {
                // Login exitoso
                $_SESSION["correo"] = $tmp_correo;
                $_SESSION["admin"] = $user_info["tipo_suscripcion"] ?? 'gratuita';

                header("location: ../../../frontend/html/inicio.php");
                exit();
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
    <title>Iniciar Sesión - BiblioLink</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Merriweather:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <style type="text/tailwindcss">
        body {
            font-family: 'Merriweather', serif;
        }
        h1, h2, h3, h4, h5, h6, button, a, input, label {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F5F6F8] dark:bg-[#1E2A38] min-h-screen flex items-center justify-center">

<div class="max-w-md w-full mx-auto px-6 py-12">
    
    <!-- Logo y Título -->
    <img src="../../../img/bibliolink.png" alt="No image">

    <div class="bg-white dark:bg-[#1E2A38] rounded-3xl shadow-xl border border-gray-100 dark:border-white/10 p-8">
        
        <h2 class="text-2xl font-bold text-center mb-8">Iniciar Sesión</h2>

        <?php if (!empty($error_general)): ?>
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-2xl text-sm">
                <?= htmlspecialchars($error_general) ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="space-y-6">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correo Electrónico</label>
                <input type="email" name="correo" 
                       class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 bg-white dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2] focus:outline-none transition-all"
                       placeholder="tu@email.com" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contraseña</label>
                <input type="password" name="contrasena" 
                       class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 bg-white dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2] focus:outline-none transition-all"
                       placeholder="••••••••" required>
            </div>

            <button type="submit" 
                    class="w-full bg-[#46C4B2] hover:bg-[#3da999] transition-colors text-white font-semibold py-4 rounded-2xl text-lg mt-4">
                Iniciar Sesión
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-600 dark:text-gray-400">
                ¿No tienes cuenta? 
                <a href="signup.php" class="text-[#46C4B2] hover:underline font-medium">Regístrate aquí</a>
            </p>
        </div>
    </div>

    <div class="text-center mt-8">
        <a href="../index.php" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
            ← Volver al inicio
        </a>
    </div>
</div>

</body>
</html>