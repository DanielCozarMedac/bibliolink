FROM php:8.2-apache

# 1. Copia los archivos de diseño y vistas a la raíz del servidor
COPY ./frontend/html/ /var/www/html/

# 2. Copia todos los archivos de lógica (incluyendo tu index.php) a la raíz para que Apache los encuentre
COPY ./backend/php/ /var/www/html/