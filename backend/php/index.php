<?php
// 1. Iniciamos sesión y protegemos la página
session_start();
// Si no existe la sesión del correo, mandamos al usuario de patitas al login
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}
// 2. Incluimos la conexión (ajusta la ruta según tu carpeta)
require "sesion/conexion.php";

$mensaje_exito = $_GET["mensaje"] ?? "";
$mensaje_error = $_GET["error"] ?? "";

// 3. Consultamos los libros y el nombre del dueño (JOIN)
$consulta = "SELECT libros.*, usuarios.nombre_usuario
FROM libros
JOIN usuarios ON libros.id_usuario = usuarios.id_usuario";
$resultado = $_conexion->query($consulta);
?>

<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bibliolink - Panel Principal</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&amp;family=Merriweather:wght@400;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <style type="text/tailwindcss">
            body {
                font-family: 'Merriweather', serif;
            }
            h1, h2, h3, h4, h5, h6, button, a, input, label, textarea, select, [data-faq-toggle] {
                font-family: 'Poppins', sans-serif;
            }
    </style>
</head>
<body>
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<div class="w-full flex flex-1 justify-center">
<div class="layout-content-container flex flex-col w-full">

    <!-- HEADER -->
    <header class="flex items-center justify-between whitespace-nowrap px-4 sm:px-10 py-4 border-b border-solid border-[#E0E2E7] dark:border-[#1E2A38]/50 bg-white dark:bg-[#1E2A38]">
        <div class="flex items-center gap-4 text-[#1E2A38] dark:text-white">
            <div class="text-[#46C4B2] w-8 h-8 flex items-center justify-center">
                <span class="material-symbols-outlined !text-3xl">import_contacts</span>
            </div>
            <h2 class="text-xl font-bold leading-tight tracking-tight">BiblioLink</h2>
        </div>

        <div class="hidden lg:flex flex-1 justify-center items-center gap-9">
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/inicio.php">Inicio</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/comunidad.php">Comunidad</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="index.php">Intercambios</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/chat.php">Chats</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/suscripcion.php">Suscripciones</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../frontend/html/contacto.php">Contacto</a>
        </div>

        <div class="flex items-center gap-4">
            <a href="perfil.php" class="flex items-center justify-center gap-2 rounded-full border border-[#46C4B2] px-5 py-2 text-sm font-medium hover:bg-[#46C4B2] hover:text-white transition-colors">
                Mi Perfil
            </a>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="w-full flex-grow px-4 sm:px-10 py-8">
        <!-- Mensajes -->
        <?php if ($mensaje_exito !== ""): ?>
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-lg">
                <?php echo htmlspecialchars($mensaje_exito); ?>
            </div>
        <?php endif; ?>

        <?php if ($mensaje_error !== ""): ?>
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg">
                <?php echo htmlspecialchars($mensaje_error); ?>
            </div>
        <?php endif; ?>

        <div class="text-center mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-[#1E2A38] dark:text-white">Libros Disponibles</h1>
            <p class="mt-2 text-lg text-gray-600 dark:text-gray-400 font-['Merriweather']">
                Explora los libros que han subido otros usuarios
            </p>
        </div>

        <!-- Filtros (mantengo los del diseño original) -->
        <div class="bg-white dark:bg-[#1E2A38] p-4 sm:p-6 rounded-2xl shadow-sm border border-gray-200 dark:border-white/10 mb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buscar libro</label>
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 mt-3">search</span>
                    <input class="w-full h-11 pl-10 pr-4 rounded-xl border border-gray-200 dark:border-white/20 bg-gray-50 dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2] focus:outline-none" placeholder="Título, autor..." type="search"/>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Género</label>
                    <select class="w-full h-11 px-3 rounded-xl border border-gray-200 dark:border-white/20 bg-gray-50 dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2]">
                        <option>Todos los géneros</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Condición</label>
                    <select class="w-full h-11 px-3 rounded-xl border border-gray-200 dark:border-white/20 bg-gray-50 dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2]">
                        <option>Cualquier condición</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de oferta</label>
                    <select class="w-full h-11 px-3 rounded-xl border border-gray-200 dark:border-white/20 bg-gray-50 dark:bg-white/5 focus:ring-2 focus:ring-[#46C4B2]">
                        <option>Intercambio o Regalo</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Libros -->
        <?php if ($resultado->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($libro = $resultado->fetch_assoc()): ?>
                <div class="bg-white dark:bg-[#1E2A38] rounded-3xl overflow-hidden shadow-sm border border-gray-100 dark:border-white/10 hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h5 class="font-bold text-xl leading-tight"><?php echo htmlspecialchars($libro['titulo']); ?></h5>
                                <h6 class="text-[#46C4B2] mt-1"><?php echo htmlspecialchars($libro['autor']); ?></h6>
                            </div>
                            <span class="px-4 py-1.5 text-xs font-semibold rounded-2xl 
                                <?php echo $libro['tipo_oferta'] === 'intercambio' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700'; ?>">
                                <?php echo ucfirst($libro['tipo_oferta']); ?>
                            </span>
                        </div>

                        <p class="text-gray-600 dark:text-gray-400 line-clamp-3 mb-6">
                            <?php echo htmlspecialchars($libro['descripcion']); ?>
                        </p>

                        <div class="flex items-center justify-between">
                            <div class="text-2xl font-bold text-emerald-600">
                                <?php echo $libro['precio'] > 0 ? $libro['precio'] . '€' : 'Gratis'; ?>
                            </div>
                            <div class="text-sm text-gray-500">
                                por <span class="font-medium"><?php echo htmlspecialchars($libro['nombre_usuario']); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-white/10 px-6 py-5">
                        <?php if ((int)$libro['disponible'] === 1 && $libro['tipo_oferta'] === 'intercambio'): ?>
                            <form action="solicitar_intercambio.php" method="post">
                                <input type="hidden" name="id_libro" value="<?php echo (int)$libro['id_libro']; ?>">
                                <input type="hidden" name="origen" value="index.php">
                                <button type="submit" class="w-full bg-[#46C4B2] hover:bg-[#3da999] transition-colors text-white font-semibold py-3.5 rounded-2xl">
                                    Solicitar intercambio
                                </button>
                            </form>
                        <?php elseif ($libro['tipo_oferta'] === 'intercambio'): ?>
                            <button disabled class="w-full bg-gray-300 text-gray-500 font-semibold py-3.5 rounded-2xl cursor-not-allowed">
                                No disponible
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-20">
                <h3 class="text-2xl font-bold mb-3">No hay libros publicados todavía</h3>
                <p class="text-gray-500">¡Sé el primero en publicar uno!</p>
            </div>
        <?php endif; ?>
    </main>

    <!-- FOOTER -->
    <footer class="bg-[#1E2A38] text-white mt-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-10 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="md:col-span-1">
                <div class="flex items-center gap-3">
                    <div class="text-[#46C4B2] w-8 h-8 flex items-center justify-center">
                        <span class="material-symbols-outlined !text-3xl">import_contacts</span>
                    </div>
                    <h2 class="text-xl font-bold">BiblioLink</h2>
                </div>
                <p class="mt-4 text-sm text-white/70">Conectando lectores, un libro a la vez.</p>
            </div>
            <!-- resto del footer igual que en tu html -->
            <div>
                <h4 class="font-bold tracking-wide">Legal</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    <li><a href="#" class="hover:text-[#46C4B2]">Política de Privacidad</a></li>
                    <li><a href="#" class="hover:text-[#46C4B2]">Términos de Servicio</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold tracking-wide">Redes Sociales</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    <li><a href="#" class="hover:text-[#46C4B2]">Instagram</a></li>
                    <li><a href="#" class="hover:text-[#46C4B2]">Twitter</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold tracking-wide">Contacto</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/70">
                    <li><a href="mailto:hola@bibliolink.com" class="hover:text-[#46C4B2]">hola@bibliolink.com</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/20 py-6 text-center text-sm text-white/50">
            © 2026 BiblioLink. Todos los derechos reservados.
        </div>
    </footer>

</div>
</div>
</div>
</div>
</body>
</html>