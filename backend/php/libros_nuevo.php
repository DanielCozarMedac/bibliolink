<?php
session_start();

// 1. Protección: solo usuarios registrados
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}

require "sesion/conexion.php";
$correo_sesion = $_SESSION["correo"];

// 2. Obtener el ID del usuario actual
$res_user = $_conexion->query("SELECT id_usuario FROM usuarios WHERE email = '$correo_sesion'");
$usuario = $res_user->fetch_assoc();
$id_usuario = $usuario['id_usuario'] ?? 0;

$error = null;

// 3. Lógica al enviar el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST["titulo"] ?? '');
    $autor = trim($_POST["autor"] ?? '');
    $descripcion = trim($_POST["descripcion"] ?? '');
    $precio = $_POST["precio"] ?? 0;
    $tipo_oferta = $_POST["tipo_oferta"] ?? 'intercambio';

    if (empty($titulo) || empty($autor)) {
        $error = "El título y el autor son obligatorios.";
    } else {
        $sql_insert = "INSERT INTO libros (titulo, autor, descripcion, precio, tipo_oferta, id_usuario)
                       VALUES ('$titulo', '$autor', '$descripcion', '$precio', '$tipo_oferta', '$id_usuario')";

        if ($_conexion->query($sql_insert)) {
            header("location: perfil.php?mensaje=Libro creado correctamente");
            exit();
        } else {
            $error = "Error al guardar el libro: " . $_conexion->error;
        }
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Añadir Nuevo Libro - BiblioLink</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;family=Merriweather:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <style type="text/tailwindcss">
        body { font-family: 'Merriweather', serif; }
        h1, h2, h3, h4, h5, h6, button, a, input, label, select, textarea {
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

        <a href="perfil.php" class="text-sm font-medium hover:text-[#46C4B2] transition-colors">
            ← Volver a Mi Perfil
        </a>
    </header>

    <main class="flex-grow px-4 sm:px-10 py-12 max-w-2xl mx-auto w-full">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold">Publicar Nuevo Libro</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Comparte tu libro con la comunidad</p>
        </div>

        <div class="bg-white dark:bg-[#1E2A38] rounded-3xl shadow-sm border border-gray-100 dark:border-white/10 p-8">
            
            <?php if ($error): ?>
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="" method="post" class="space-y-6">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Título del Libro</label>
                    <input type="text" name="titulo" 
                           class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-[#46C4B2] focus:outline-none"
                           placeholder="Ej: El Quijote" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Autor</label>
                    <input type="text" name="autor" 
                           class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-[#46C4B2] focus:outline-none"
                           placeholder="Ej: Miguel de Cervantes" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                    <textarea name="descripcion" rows="4"
                              class="w-full px-5 py-4 rounded-2xl border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-[#46C4B2] focus:outline-none"
                              placeholder="Cuéntanos un poco sobre el libro..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio (€)</label>
                        <input type="number" step="0.01" name="precio" 
                               class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-[#46C4B2] focus:outline-none"
                               value="0.00">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Oferta</label>
                        <select name="tipo_oferta" 
                                class="w-full h-12 px-5 rounded-2xl border border-gray-200 dark:border-white/20 focus:ring-2 focus:ring-[#46C4B2] focus:outline-none">
                            <option value="intercambio">Intercambio</option>
                            <option value="venta">Venta</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="submit" 
                            class="flex-1 bg-[#46C4B2] hover:bg-[#3da999] transition-colors text-white font-semibold py-4 rounded-2xl text-lg">
                        Publicar Libro
                    </button>
                    <a href="perfil.php" 
                       class="flex-1 text-center border border-gray-300 dark:border-white/20 font-semibold py-4 rounded-2xl hover:bg-gray-100 dark:hover:bg-white/5 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
</div>
</body>
</html>