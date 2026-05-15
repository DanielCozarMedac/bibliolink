<?php
// 1. Iniciamos sesión y protegemos la página
session_start();
// Si no existe la sesión del correo, mandamos al usuario de patitas al login
if (!isset($_SESSION["correo"])) {
    header("location: sesion/login.php");
    exit();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "sesion/conexion.php";
?>
<!DOCTYPE html>
<html class="light" lang="es"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Comunidad BiblioLink - Conecta con lectores</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;900&amp;family=Merriweather:wght@400;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
<style type="text/tailwindcss">
        body {
            font-family: 'Merriweather', serif;
        }
        h1, h2, h3, h4, h5, h6, button, a, input, label, textarea {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F5F6F8] dark:bg-[#1E2A38] text-[#1E2A38] dark:text-[#F5F6F8]">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
    <div class="layout-container flex h-full grow flex-col">
    <div class="w-full flex flex-1 justify-center">
    <div class="layout-content-container flex flex-col w-full">
    <header class="flex items-center justify-between whitespace-nowrap px-4 sm:px-10 py-4 border-b border-solid border-[#E0E2E7] dark:border-[#1E2A38]/50 bg-white dark:bg-[#1E2A38]">
        <div class="flex items-center gap-4 text-[#1E2A38] dark:text-white">
        <div class="text-[#46C4B2] w-8 h-8 flex items-center justify-center">
        <span class="material-symbols-outlined !text-3xl">import_contacts</span>
        </div>
        <h2 class="text-xl font-bold leading-tight tracking-tight">BiblioLink</h2>
        </div>
        <div class="hidden lg:flex flex-1 justify-center items-center gap-9">
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="inicio.php">Inicio</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="comunidad.php">Comunidad</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="../../backend/php/index.php">Intercambios</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="chat.php">Chats</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="suscripcion.php">Suscripciones</a>
            <a class="text-sm font-medium leading-normal hover:text-[#46C4B2] transition-colors" href="contacto.php">Contacto</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="../../backend/php/perfil.php" class="flex items-center justify-center gap-2 rounded-full border border-[#46C4B2] px-5 py-2 text-sm font-medium hover:bg-[#46C4B2] hover:text-white transition-colors">
                Mi Perfil
            </a>
        </div>
    </header>
    <main class="w-full flex-grow px-4 sm:px-10 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
            <input class="w-full h-12 pl-12 pr-4 rounded-full border border-gray-200 dark:border-white/20 bg-white dark:bg-[#1E2A38] focus:ring-2 focus:ring-[#46C4B2] focus:outline-none transition-shadow" placeholder="Buscar usuarios, grupos o libros..." type="search"/>
        </div>
        <div class="bg-white dark:bg-[#1E2A38] p-4 rounded-lg shadow-sm border border-gray-200 dark:border-white/10">
        <div class="flex items-start gap-4">
        <img class="w-12 h-12 rounded-full" data-alt="User avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAu5rmuSf9ZjodhVl0LJ3sRgOIHbFViGy9YczN3wF9zH1Lfxgo1GG7w89K3XTiUhcN1Q0-gboO7NNMTaGKyDV2hQ57rJYD7zQtyUQQZIm6iTxVa2uQeMW9FN3g6gOvUON0ChR12o3Echr2f4jcJz1iuqfmT91GevDhN2_VgEnmNJ68T04qeo1kOeUiGiqTZHUmkAHHnNEy7SIFC-rjWvyzDZPEtN359HQGJPQMGHDT77llgHJ_r_GMgJMTjmTZjqmh_WLetk1ePBCP2"/>
        <div class="flex-1">
        <textarea class="w-full p-2 border-none rounded-md text-base font-['Merriweather'] bg-transparent focus:ring-0" placeholder="¿Qué estás leyendo, Carlos?" rows="2"></textarea>
        <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-100 dark:border-white/10">
        <div class="flex items-center gap-4 text-gray-500 dark:text-gray-400">
            <button class="hover:text-[#46C4B2] transition-colors flex items-center gap-2"><span class="material-symbols-outlined !text-xl">photo_camera</span></button>
            <button class="hover:text-[#46C4B2] transition-colors flex items-center gap-2"><span class="material-symbols-outlined !text-xl">menu_book</span></button>
            <button class="hover:text-[#46C4B2] transition-colors flex items-center gap-2"><span class="material-symbols-outlined !text-xl">alternate_email</span></button>
        </div>
        <button class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-9 px-5 bg-[#46C4B2] text-white text-sm font-bold leading-normal tracking-wide hover:bg-[#3da999] transition-colors">Publicar</button>
        </div>
        </div>
        </div>
        </div>
        <div class="bg-white dark:bg-[#1E2A38] rounded-lg shadow-sm border border-gray-200 dark:border-white/10 p-5">
        <div class="flex items-start gap-4">
        <img class="w-12 h-12 rounded-full" data-alt="Avatar de Ana García" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCoUit5eJ_BQ5OeYevsG1ZM5BEOFSer58R4fRIGWgaFLxWb8frhONhyDrJNEP3kA6kcVBZpukphOZpR7kydhrqdm8zEmaC1D9V08hGQBWyovUdDyfmhV7sUdI5BE7ne6ZnJW2p2tVUWRS2a5W74O5s9A-w21OTusTZ2HJ0kgD6v2C7vafW_k04lYrZMnIwiQ8gBRE9ejjtKGhwDtjYrEAWLksxFLB7cRRkGaKoVTfSK8A8NmMrG44ALh6wQES4SaBsTMLg2zYKfbDvQ"/>
        <div class="flex-1">
        <p class="text-sm"><strong class="font-bold font-['Poppins']">Ana García</strong> ha añadido una nueva reseña de <strong class="font-bold font-['Poppins']">"Cien Años de Soledad"</strong>.</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">hace 15 minutos</p>
        <div class="mt-3 text-base text-[#1E2A38]/90 dark:text-[#F5F6F8]/90 font-['Merriweather'] italic p-4 bg-[#F5F6F8] dark:bg-white/5 rounded-md border-l-4 border-[#46C4B2]">"Una obra maestra que te transporta a un mundo mágico y familiar a la vez. La narrativa de García Márquez es simplemente inigualable. ¡Lectura obligatoria!"</div>
        <div class="flex items-center gap-6 mt-4 text-sm text-gray-600 dark:text-gray-400">
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">thumb_up</span>23</button>
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">chat_bubble</span>5</button>
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">share</span></button>
        </div>
        </div>
        </div>
        </div>
        <div class="bg-white dark:bg-[#1E2A38] rounded-lg shadow-sm border border-gray-200 dark:border-white/10 p-5">
        <div class="flex items-start gap-4">
        <img class="w-12 h-12 rounded-full" data-alt="Avatar de Laura Jiménez" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCLK8ajAbzmXLZIs8SMOyqljFBx0UDzEC6RFYAzVEIbt1qDqK4MLYE-pwEmtnGaHC9OqxATn7awEKisRnW_jynu286zxUM6trqblfSu7HEGVlYMJ1vXGL4LpcG_m7xRbQb3923RqkFt6IFxETFscUaE00GMm6s6YkO4Bn0DqD8Dal1X_r0R6jPVItfpZcOQYbn4eU_p_Gy5MtGI41nlEFkxyfbpsBKyS-Hv7EwkVR5H87HgDqm1XXPuHN9q1-yyGzloq8R-T__VcP_R"/>
        <div class="flex-1">
        <p class="text-sm"><strong class="font-bold font-['Poppins']">Laura Jiménez</strong> ha añadido <strong class="font-bold font-['Poppins']">"Dune"</strong> a su biblioteca personal.</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">hace 1 hora</p>
        <div class="flex items-center gap-6 mt-4 text-sm text-gray-600 dark:text-gray-400">
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">favorite</span>12</button>
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">chat_bubble</span>3</button>
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">share</span></button>
        </div>
        </div>
        </div>
        </div>
        <div class="bg-white dark:bg-[#1E2A38] rounded-lg shadow-sm border border-gray-200 dark:border-white/10 p-5">
        <div class="flex items-start gap-4">
        <img class="w-12 h-12 rounded-full" data-alt="Avatar de Marco Vega" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAu5rmuSf9ZjodhVl0LJ3sRgOIHbFViGy9YczN3wF9zH1Lfxgo1GG7w89K3XTiUhcN1Q0-gboO7NNMTaGKyDV2hQ57rJYD7zQtyUQQZIm6iTxVa2uQeMW9FN3g6gOvUON0ChR12o3Echr2f4jcJz1iuqfmT91GevDhN2_VgEnmNJ68T04qeo1kOeUiGiqTZHUmkAHHnNEy7SIFC-rjWvyzDZPEtN359HQGJPQMGHDT77llgHJ_r_GMgJMTjmTZjqmh_WLetk1ePBCP2"/>
        <div class="flex-1">
        <p class="text-sm"><strong class="font-bold font-['Poppins']">Marco Vega</strong> ha propuesto un intercambio.</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">hace 3 horas</p>
        <div class="mt-3 text-base text-[#1E2A38]/90 dark:text-[#F5F6F8]/90 font-['Merriweather']">¡Hola, comunidad! Busco intercambiar "El nombre del viento". Está en perfecto estado. Me interesan novelas de fantasía o ciencia ficción.</div>
        <div class="flex items-center gap-6 mt-4 text-sm text-gray-600 dark:text-gray-400">
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">swap_horiz</span>Interesado</button>
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">chat_bubble</span>9</button>
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">share</span></button>
        </div>
        </div>
        </div>
        </div>
        <div class="bg-white dark:bg-[#1E2A38] rounded-lg shadow-sm border border-gray-200 dark:border-white/10 p-5">
        <div class="flex items-start gap-4">
        <div class="w-12 h-12 rounded-full bg-[#46C4B2] text-white flex items-center justify-center">
        <span class="material-symbols-outlined">groups</span>
        </div>
        <div class="flex-1">
        <p class="text-sm">Nueva discusión en el grupo <strong class="font-bold font-['Poppins']">"Club de Lectura de Clásicos"</strong>.</p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">hace 5 horas</p>
        <div class="mt-3">
        <h4 class="font-bold text-base font-['Poppins']">¿Cuál es vuestro personaje favorito de "Orgullo y Prejuicio"?</h4>
        <p class="text-base text-[#1E2A38]/90 dark:text-[#F5F6F8]/90 font-['Merriweather'] mt-1">Abro debate. Para mí, sin duda, es Elizabeth Bennet por su ingenio y fortaleza. ¿Qué opináis?</p>
        </div>
        <div class="flex items-center gap-6 mt-4 text-sm text-gray-600 dark:text-gray-400">
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">add_comment</span>Participar</button>
            <button class="flex items-center gap-2 hover:text-[#46C4B2] transition-colors"><span class="material-symbols-outlined !text-xl">group_add</span>Unirse al grupo</button>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="hidden lg:block space-y-6">
        <div class="bg-white dark:bg-[#1E2A38] rounded-lg shadow-sm border border-gray-200 dark:border-white/10 p-5">
        <h3 class="text-lg font-bold">Sugerencias para ti</h3>
        <ul class="mt-4 space-y-4">
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full" data-alt="Avatar de Elena Ríos" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCoUit5eJ_BQ5OeYevsG1ZM5BEOFSer58R4fRIGWgaFLxWb8frhONhyDrJNEP3kA6kcVBZpukphOZpR7kydhrqdm8zEmaC1D9V08hGQBWyovUdDyfmhV7sUdI5BE7ne6ZnJW2p2tVUWRS2a5W74O5s9A-w21OTusTZ2HJ0kgD6v2C7vafW_k04lYrZMnIwiQ8gBRE9ejjtKGhwDtjYrEAWLksxFLB7cRRkGaKoVTfSK8A8NmMrG44ALh6wQES4SaBsTMLg2zYKfbDvQ"/>
                    <div>
                        <p class="font-bold text-sm">Elena Ríos</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Le gusta la ciencia ficción</p>
                    </div>
                </div>
                <button class="flex min-w-[70px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-4 bg-transparent text-[#46C4B2] border border-[#46C4B2] text-xs font-bold leading-normal tracking-wide hover:bg-[#46C4B2]/10 transition-colors">Seguir</button>
            </li>
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img class="w-10 h-10 rounded-full" data-alt="Avatar de Javier Solís" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAu5rmuSf9ZjodhVl0LJ3sRgOIHbFViGy9YczN3wF9zH1Lfxgo1GG7w89K3XTiUhcN1Q0-gboO7NNMTaGKyDV2hQ57rJYD7zQtyUQQZIm6iTxVa2uQeMW9FN3g6gOvUON0ChR12o3Echr2f4jcJz1iuqfmT91GevDhN2_VgEnmNJ68T04qeo1kOeUiGiqTZHUmkAHHnNEy7SIFC-rjWvyzDZPEtN359HQGJPQMGHDT77llgHJ_r_GMgJMTjmTZjqmh_WLetk1ePBCP2"/>
                    <div>
                        <p class="font-bold text-sm">Javier Solís</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Apasionado de la historia</p>
                    </div>
                </div>
                <button class="flex min-w-[70px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-4 bg-transparent text-[#46C4B2] border border-[#46C4B2] text-xs font-bold leading-normal tracking-wide hover:bg-[#46C4B2]/10 transition-colors">Seguir</button>
            </li>
        </ul>
        </div>
        <div class="bg-white dark:bg-[#1E2A38] rounded-lg shadow-sm border border-gray-200 dark:border-white/10 p-5">
        <h3 class="text-lg font-bold">Grupos populares</h3>
        <ul class="mt-4 space-y-4">
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#F5F6F8] dark:bg-white/10 flex items-center justify-center text-[#46C4B2]"><span class="material-symbols-outlined">rocket_launch</span></div>
                <div>
                    <p class="font-bold text-sm">Adictos a la Ci-Fi</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">2,345 miembros</p>
                </div>
                </div>
                <button class="flex min-w-[70px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-4 bg-[#46C4B2] text-white text-xs font-bold leading-normal tracking-wide hover:bg-[#3da999] transition-colors">Unirse</button>
            </li>
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#F5F6F8] dark:bg-white/10 flex items-center justify-center text-[#46C4B2]"><span class="material-symbols-outlined">scrollable_header</span></div>
                <div>
                    <p class="font-bold text-sm">Clásicos Imprescindibles</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">1,890 miembros</p>
                </div>
                </div>
                <button class="flex min-w-[70px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-4 bg-[#46C4B2] text-white text-xs font-bold leading-normal tracking-wide hover:bg-[#3da999] transition-colors">Unirse</button>
            </li>
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-[#F5F6F8] dark:bg-white/10 flex items-center justify-center text-[#46C4B2]"><span class="material-symbols-outlined">neurology</span></div>
                <div>
                    <p class="font-bold text-sm">Thriller y Misterio</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">3,112 miembros</p>
                </div>
                </div>
                <button class="flex min-w-[70px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-4 bg-[#46C4B2] text-white text-xs font-bold leading-normal tracking-wide hover:bg-[#3da999] transition-colors">Unirse</button>
            </li>
        </ul>
        </div>
        </div>
        </div>
    </main>
    <footer class="bg-[#1E2A38] text-white w-full">
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
        <div>
        <h4 class="font-bold tracking-wide">Legal</h4>
        <ul class="mt-4 space-y-2 text-sm text-white/70">
            <li><a class="hover:text-[#46C4B2] transition-colors" href="#">Política de Privacidad</a></li>
            <li><a class="hover:text-[#46C4B2] transition-colors" href="#">Términos de Servicio</a></li>
        </ul>
        </div>
        <div>
        <h4 class="font-bold tracking-wide">Redes Sociales</h4>
        <ul class="mt-4 space-y-2 text-sm text-white/70">
            <li><a class="hover:text-[#46C4B2] transition-colors" href="#">Facebook</a></li>
            <li><a class="hover:text-[#46C4B2] transition-colors" href="#">Twitter</a></li>
            <li><a class="hover:text-[#46C4B2] transition-colors" href="#">Instagram</a></li>
        </ul>
        </div>
        <div>
        <h4 class="font-bold tracking-wide">Contacto</h4>
        <ul class="mt-4 space-y-2 text-sm text-white/70">
            <li><a class="hover:text-[#46C4B2] transition-colors" href="mailto:hola@bibliolink.com">hola@bibliolink.com</a></li>
        </ul>
        </div>
        </div>
        <div class="border-t border-white/20 py-4 text-center">
            <p class="text-sm text-white/50">© 2024 BiblioLink. Todos los derechos reservados.</p>
        </div>
    </footer>
    </div>
    </div>
    </div>
    </div>

</body></html>