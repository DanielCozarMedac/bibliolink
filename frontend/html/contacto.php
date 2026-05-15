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
<title>Contacto - BiblioLink</title>
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
<main class="w-full flex-grow">
<section class="bg-white dark:bg-[#1E2A38] text-center px-4 sm:px-10 py-16 sm:py-24">
<h1 class="text-4xl md:text-5xl font-bold text-[#1E2A38] dark:text-white">Ponte en contacto con nosotros</h1>
<p class="mt-4 max-w-3xl mx-auto text-lg text-gray-600 dark:text-gray-400 font-['Merriweather']">¿Tienes alguna pregunta, sugerencia o simplemente quieres saludar? Estamos aquí para ayudarte. Rellena el formulario o utiliza una de nuestras otras vías de contacto.</p>
</section>
<section class="px-4 sm:px-10 py-16 sm:py-20">
<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-12 lg:gap-16">
<div class="lg:col-span-2">
<h2 class="text-3xl font-bold text-[#1E2A38] dark:text-white">Envíanos un mensaje</h2>
<form class="mt-8 space-y-6">
<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="name">Nombre completo</label>
<input class="w-full rounded-md border-gray-300 dark:border-white/20 dark:bg-white/5 shadow-sm focus:border-[#46C4B2] focus:ring-[#46C4B2] dark:text-white" id="name" name="name" placeholder="Tu nombre" type="text"/>
</div>
<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="email">Correo electrónico</label>
<input class="w-full rounded-md border-gray-300 dark:border-white/20 dark:bg-white/5 shadow-sm focus:border-[#46C4B2] focus:ring-[#46C4B2] dark:text-white" id="email" name="email" placeholder="tu@email.com" type="email"/>
</div>
</div>
<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="subject">Asunto</label>
<input class="w-full rounded-md border-gray-300 dark:border-white/20 dark:bg-white/5 shadow-sm focus:border-[#46C4B2] focus:ring-[#46C4B2] dark:text-white" id="subject" name="subject" placeholder="¿Sobre qué quieres hablar?" type="text"/>
</div>
<div>
<label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" for="message">Mensaje</label>
<textarea class="w-full rounded-md border-gray-300 dark:border-white/20 dark:bg-white/5 shadow-sm focus:border-[#46C4B2] focus:ring-[#46C4B2] dark:text-white" id="message" name="message" placeholder="Escribe aquí tu mensaje..." rows="6"></textarea>
</div>
<div>
<button class="w-full md:w-auto flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-8 bg-[#46C4B2] text-white text-base font-bold leading-normal tracking-wide hover:bg-[#3da999] transition-colors" type="submit">
<span class="truncate">Enviar Mensaje</span>
</button>
</div>
</form>
</div>
<div class="lg:col-span-1">
<div class="bg-white dark:bg-[#283748] p-8 rounded-lg shadow-md">
<h2 class="text-2xl font-bold text-[#1E2A38] dark:text-white">Información de Contacto</h2>
<div class="mt-8 space-y-6">
<div class="flex items-start gap-4">
<div class="flex-shrink-0 w-10 h-10 bg-[#46C4B2]/10 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-[#46C4B2]">email</span>
</div>
<div>
<h3 class="font-bold text-lg">Correo de soporte</h3>
<p class="mt-1 text-sm text-gray-600 dark:text-gray-400 font-['Merriweather']">Para dudas técnicas.</p>
<a class="font-semibold text-sm text-[#46C4B2] hover:underline" href="mailto:soporte@bibliolink.com">soporte@bibliolink.com</a>
</div>
</div>
<div class="flex items-start gap-4">
<div class="flex-shrink-0 w-10 h-10 bg-[#46C4B2]/10 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-[#46C4B2]">call</span>
</div>
<div>
<h3 class="font-bold text-lg">Teléfono</h3>
<p class="mt-1 text-sm text-gray-600 dark:text-gray-400 font-['Merriweather']">Lun-Vie, 9am - 5pm.</p>
<a class="font-semibold text-sm text-[#46C4B2] hover:underline" href="tel:+34912345678">+34 912 345 678</a>
</div>
</div>
<div class="flex items-start gap-4">
<div class="flex-shrink-0 w-10 h-10 bg-[#46C4B2]/10 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-[#46C4B2]">group</span>
</div>
<div>
<h3 class="font-bold text-lg">Redes Sociales</h3>
<p class="mt-1 text-sm text-gray-600 dark:text-gray-400 font-['Merriweather']">Síguenos para novedades.</p>
<div class="flex gap-4 mt-2">
<a class="text-gray-500 dark:text-gray-400 hover:text-[#46C4B2] transition-colors" href="#">
<svg class="w-6 h-6" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
</a>
<a class="text-gray-500 dark:text-gray-400 hover:text-[#46C4B2] transition-colors" href="#">
<svg class="w-6 h-6" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M22 4s-.7 2.1-2 3.4c1.6 1.4 3.3 4.9 3.3 4.9s-1.4-1.3-3.5-2.2c-2.3 2.1-6.1 3.5-9.4 3.5-3.1 0-5.4-1.3-6.6-2.9C3 13.2 3 11 3 9.8c0-2.5 1.5-5 5.1-6.5C9.4 2.5 12.4 2 15.2 2c2.2 0 4.3.4 6.1 1.2"></path></svg>
</a>
<a class="text-gray-500 dark:text-gray-400 hover:text-[#46C4B2] transition-colors" href="#">
<svg class="w-6 h-6" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><rect height="20" rx="5" ry="5" width="20" x="2" y="2"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line></svg>
</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<section class="bg-white dark:bg-[#1E2A38] px-4 sm:px-10 py-16 sm:py-20">
<div class="max-w-3xl mx-auto">
<h2 class="text-3xl font-bold text-center mb-12 text-[#1E2A38] dark:text-white">Preguntas Frecuentes</h2>
<div class="space-y-4">
<details class="group bg-gray-50 dark:bg-white/5 rounded-lg p-6">
<summary class="flex items-center justify-between cursor-pointer list-none">
<h3 class="font-bold text-lg text-[#1E2A38] dark:text-white">¿Cómo funciona el intercambio de libros?</h3>
<span class="material-symbols-outlined text-gray-500 dark:text-gray-400 transition-transform duration-300 group-open:rotate-180">expand_more</span>
</summary>
<div class="mt-4 text-gray-600 dark:text-gray-300 font-['Merriweather']">
<p>Una vez que encuentras un libro que te interesa en la biblioteca de otro usuario, puedes enviarle una propuesta de intercambio. Si la acepta, os pondremos en contacto para que acordéis los detalles del encuentro presencial para intercambiar los libros.</p>
</div>
</details>
<details class="group bg-gray-50 dark:bg-white/5 rounded-lg p-6">
<summary class="flex items-center justify-between cursor-pointer list-none">
<h3 class="font-bold text-lg text-[#1E2A38] dark:text-white">¿Puedo añadir libros a mi biblioteca que no tengan ISBN?</h3>
<span class="material-symbols-outlined text-gray-500 dark:text-gray-400 transition-transform duration-300 group-open:rotate-180">expand_more</span>
</summary>
<div class="mt-4 text-gray-600 dark:text-gray-300 font-['Merriweather']">
<p>¡Claro! Aunque recomendamos usar el ISBN para cargar la información automáticamente, también puedes añadir libros de forma manual, rellenando tú mismo los campos de título, autor, etc. Esto es ideal para ediciones antiguas o especiales.</p>
</div>
</details>
<details class="group bg-gray-50 dark:bg-white/5 rounded-lg p-6">
<summary class="flex items-center justify-between cursor-pointer list-none">
<h3 class="font-bold text-lg text-[#1E2A38] dark:text-white">¿Es seguro encontrarse con otros usuarios para el intercambio?</h3>
<span class="material-symbols-outlined text-gray-500 dark:text-gray-400 transition-transform duration-300 group-open:rotate-180">expand_more</span>
</summary>
<div class="mt-4 text-gray-600 dark:text-gray-300 font-['Merriweather']">
<p>La seguridad de nuestra comunidad es prioritaria. Recomendamos siempre realizar los intercambios en lugares públicos y concurridos, como cafeterías o bibliotecas. Además, contamos con un sistema de valoración de usuarios para generar confianza.</p>
</div>
</details>
</div>
</div>
</section>
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