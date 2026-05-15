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
<title>BiblioLink - chat</title>
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
    <div class="hidden lg:flex flex-1 justify-center items-center gap-9">
    <div class="w-full flex flex-1 justify-center">
    <div class="layout-content-container flex flex-col w-full">
    <header class="flex items-center justify-between whitespace-nowrap px-4 sm:px-10 py-4 border-b border-solid border-[#E0E2E7] dark:border-[#1E2A38]/50 bg-white dark:bg-[#1E2A38]">
        <div class="flex items-center gap-4 text-[#1E2A38] dark:text-white">
        <div class="hidden lg:flex flex-1 justify-center items-center gap-9">
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
             <!-- <div class="display: none; flex flex-1 justify-end gap-2 sm:gap-4">
                <div class="flex gap-2">
                  <button
                    class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 bg-[#e7ebf3] dark:bg-[#1f2937] text-[#0d121b] dark:text-[#f8f9fc] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
                  >
                    <span class="material-symbols-outlined text-xl"
                      >notifications</span
                    >
                  </button>
                  <button
                    class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 bg-[#e7ebf3] dark:bg-[#1f2937] text-[#0d121b] dark:text-[#f8f9fc] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
                  >
                    <span class="material-symbols-outlined text-xl"
                      >chat_bubble</span
                    >
                  </button>
                </div>
                <div
                  class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                  data-alt="User profile picture, abstract purple and blue gradient"
                  style="
                    background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCjXtKXa96FAWzoXUL5SFc9pf_qWEvFqgZKdtPnx9gwtXFfhEPCZ7GJQ3lIgnIPELcEMJcLjrL5y01RJUJzZs5xEdpMOf6sycRCA4Kq2qcIOSWcEV82lHtXl3g2o7nag8B9YUw_qfWec6iIbfB7WqyigNp7oQHUuChGKjlwds-e00EPJRG7ldFfEA7VjFoVx44z4X-zhVpKn4IFpmXqsxB3nLb9ev0vf1xEaGBhC8bfStRkbW8dF4YDt_0tHO2iddv19uii3dR3dnn6');
                  "
                ></div>
              </div> -->
    </header>
<!-- HeroSection -->
    <main class="w-full">
        <div class="flex items-center justify-between whitespace-nowrap px-4 sm:px-10 py-4 border-b border-solid border-[#E0E2E7] dark:border-[#1E2A38]/50 bg-white dark:bg-[#1E2A38]" style="height: 75vh; min-height: 480px;">
 
            <!-- Chat Header -->
            <div class="flex items-center gap-3 px-5 py-4 bg-white dark:bg-[#253447] border border-[#E0E2E7] dark:border-[#1E2A38]/60 rounded-t-2xl shadow-sm">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-[#46C4B2]/20 flex items-center justify-center text-[#46C4B2]">
                        <span class="material-symbols-outlined !text-xl">person</span>
                    </div>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border-2 border-white dark:border-[#253447] rounded-full"></span>
                </div>
                <div>
                    <p class="font-bold text-sm text-[#1E2A38] dark:text-white leading-tight" style="font-family: 'Poppins', sans-serif;">María González</p>
                    <p class="text-xs text-green-500" style="font-family: 'Poppins', sans-serif;">En línea</p>
                </div>
                <div class="ml-auto flex items-center gap-3">
                    <button
                        id="followBtn"
                        onclick="toggleFollow()"
                        class="h-8 px-4 rounded-full border-2 border-[#1E2A38] dark:border-white text-[#1E2A38] dark:text-white text-xs font-bold transition-all duration-200 hover:opacity-80"
                        style="font-family: 'Poppins', sans-serif;"
                    >Seguir</button>
                    <button class="text-[#1E2A38]/40 dark:text-white/40 hover:text-[#46C4B2] transition-colors p-1">
                        <span class="material-symbols-outlined !text-xl">more_vert</span>
                    </button>
                </div>
            </div>
 
            <!-- Messages Area -->
            <div id="chatMessages" class="flex-1 overflow-y-auto px-5 py-6 flex flex-col gap-4 bg-[#F5F6F8] dark:bg-[#1a2535] border-x border-[#E0E2E7] dark:border-[#1E2A38]/60 scroll-smooth">
 
                <!-- Date separator -->
                <div class="flex items-center gap-3 my-1">
                    <div class="flex-1 h-px bg-[#E0E2E7] dark:bg-white/10"></div>
                    <span class="text-xs text-[#1E2A38]/40 dark:text-white/30 px-2" style="font-family: 'Poppins', sans-serif;">Hoy</span>
                    <div class="flex-1 h-px bg-[#E0E2E7] dark:bg-white/10"></div>
                </div>
 
                <!-- Message LEFT (other person) -->
                <div class="flex items-end gap-2 max-w-[72%] self-start">
                    <div class="w-7 h-7 rounded-full bg-[#46C4B2]/20 flex items-center justify-center text-[#46C4B2] flex-shrink-0 mb-0.5">
                        <span class="material-symbols-outlined !text-sm">person</span>
                    </div>
                    <div>
                        <div class="bg-white dark:bg-[#253447] text-black dark:text-white text-sm px-4 py-3 rounded-2xl rounded-bl-sm shadow-sm border border-[#E0E2E7] dark:border-[#2e3f55]" style="font-family: 'Merriweather', serif; line-height: 1.6;">
                            ¡Hola! Vi que tienes <em>Cien años de soledad</em>, ¿estarías dispuesta a intercambiarlo?
                        </div>
                        <p class="text-[10px] text-[#1E2A38]/35 dark:text-white/30 mt-1 ml-1" style="font-family: 'Poppins', sans-serif;">10:14</p>
                    </div>
                </div>
 
                <!-- Message RIGHT (you) -->
                <div class="flex items-end gap-2 max-w-[72%] self-end flex-row-reverse">
                    <div>
                        <div class="bg-[#46C4B2] text-white text-sm px-4 py-3 rounded-2xl rounded-br-sm shadow-md" style="font-family: 'Merriweather', serif; line-height: 1.6;">
                            ¡Claro que sí! ¿Qué libro me ofrecerías a cambio?
                        </div>
                        <p class="text-[10px] text-[#1E2A38]/35 dark:text-white/30 mt-1 mr-1 text-right" style="font-family: 'Poppins', sans-serif;">10:15</p>
                    </div>
                </div>
 
                <!-- Message LEFT (two lines due to width limit) -->
                <div class="flex items-end gap-2 max-w-[72%] self-start">
                    <div class="w-7 h-7 rounded-full bg-[#46C4B2]/20 flex items-center justify-center text-[#46C4B2] flex-shrink-0 mb-0.5">
                        <span class="material-symbols-outlined !text-sm">person</span>
                    </div>
                    <div>
                        <div class="bg-white dark:bg-[#253447] text-black dark:text-white text-sm px-4 py-3 rounded-2xl rounded-bl-sm shadow-sm border border-[#E0E2E7] dark:border-[#2e3f55]" style="font-family: 'Merriweather', serif; line-height: 1.6;">
                            Tengo <em>El nombre de la rosa</em> de Umberto Eco, está en muy buen estado y creo que te encantaría.
                        </div>
                        <p class="text-[10px] text-[#1E2A38]/35 dark:text-white/30 mt-1 ml-1" style="font-family: 'Poppins', sans-serif;">10:16</p>
                    </div>
                </div>
 
                <!-- Message RIGHT -->
                <div class="flex items-end gap-2 max-w-[72%] self-end flex-row-reverse">
                    <div>
                        <div class="bg-[#46C4B2] text-white text-sm px-4 py-3 rounded-2xl rounded-br-sm shadow-md" style="font-family: 'Merriweather', serif; line-height: 1.6;">
                            ¡Perfecto, me interesa mucho! Entonces, ¿intercambiamos?
                        </div>
                        <p class="text-[10px] text-[#1E2A38]/35 dark:text-white/30 mt-1 mr-1 text-right" style="font-family: 'Poppins', sans-serif;">10:18</p>
                    </div>
                </div>
 
                <!-- Message LEFT -->
                <div class="flex items-end gap-2 max-w-[72%] self-start">
                    <div class="w-7 h-7 rounded-full bg-[#46C4B2]/20 flex items-center justify-center text-[#46C4B2] flex-shrink-0 mb-0.5">
                        <span class="material-symbols-outlined !text-sm">person</span>
                    </div>
                    <div>
                        <div class="bg-white dark:bg-[#253447] text-black dark:text-white text-sm px-4 py-3 rounded-2xl rounded-bl-sm shadow-sm border border-[#E0E2E7] dark:border-[#2e3f55]" style="font-family: 'Merriweather', serif; line-height: 1.6;">
                           Me parece bien.
                        </div>
                        <p class="text-[10px] text-[#1E2A38]/35 dark:text-white/30 mt-1 ml-1" style="font-family: 'Poppins', sans-serif;">10:19</p>
                    </div>
                </div>
 
            </div>
 
            <!-- Input Bar -->
            <div class="flex items-center gap-3 px-4 py-3 bg-white dark:bg-[#253447] border border-t-0 border-[#E0E2E7] dark:border-[#1E2A38]/60 rounded-b-2xl shadow-sm">
                <button class="text-[#1E2A38]/35 dark:text-white/35 hover:text-[#46C4B2] transition-colors p-1 flex-shrink-0">
                    <span class="material-symbols-outlined !text-xl">attach_file</span>
                </button>
                <input
                    id="msgInput"
                    type="text"
                    placeholder="Escribe un mensaje..."
                    class="flex-1 bg-[#F5F6F8] dark:bg-[#1a2535] text-[#1E2A38] dark:text-white placeholder-[#1E2A38]/35 dark:placeholder-white/30 text-sm px-4 py-2.5 rounded-full border border-[#E0E2E7] dark:border-[#2e3f55] outline-none focus:border-[#46C4B2] transition-colors"
                    style="font-family: 'Merriweather', serif;"
                    onkeydown="if(event.key==='Enter') sendMessage()"
                />
                <button onclick="sendMessage()" class="flex-shrink-0 w-10 h-10 rounded-full bg-[#46C4B2] hover:bg-[#3da999] text-white flex items-center justify-center transition-colors shadow-md">
                    <span class="material-symbols-outlined !text-[18px]">send</span>
                </button>
            </div>
 
        </div>
    </main>
    <script>
        function toggleFollow() {
            const btn = document.getElementById('followBtn');
            const following = btn.dataset.following === 'true';
            if (!following) {
                btn.dataset.following = 'true';
                btn.textContent = 'Siguiendo';
                btn.style.backgroundColor = '#46C4B2';
                btn.style.borderColor = '#46C4B2';
                btn.style.color = '#ffffff';
            } else {
                btn.dataset.following = 'false';
                btn.textContent = 'Seguir';
                btn.style.backgroundColor = '';
                btn.style.borderColor = '';
                btn.style.color = '';
            }
        }
 
        function sendMessage() {
            const input = document.getElementById('msgInput');
            const text = input.value.trim();
            if (!text) return;
 
            const container = document.getElementById('chatMessages');
 
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-end gap-2 max-w-[72%] self-end flex-row-reverse';
            wrapper.style.opacity = '0';
            wrapper.style.transform = 'translateY(8px)';
            wrapper.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
 
            wrapper.innerHTML = `
                <div>
                    <div class="bg-[#46C4B2] text-white text-sm px-4 py-3 rounded-2xl rounded-br-sm shadow-md" style="font-family: 'Merriweather', serif; line-height: 1.6;">
                        ${text}
                    </div>
                    <p class="text-[10px] text-[#1E2A38]/35 dark:text-white/30 mt-1 mr-1 text-right" style="font-family: 'Poppins', sans-serif;">${new Date().toLocaleTimeString('es-ES', {hour:'2-digit', minute:'2-digit'})}</p>
                </div>
            `;
 
            container.appendChild(wrapper);
            input.value = '';
            container.scrollTop = container.scrollHeight;
 
            requestAnimationFrame(() => {
                wrapper.style.opacity = '1';
                wrapper.style.transform = 'translateY(0)';
            });
        }
    </script>
    <!-- Footer -->
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