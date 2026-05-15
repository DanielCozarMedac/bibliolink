FROM php:8.2-apache

# 1. Instalamos y activamos la extensión de MySQL
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable mysqli

# 2. Copiamos todo tu repositorio al servidor
COPY . /var/www/html/

# 3. Movemos los archivos de backend (incluido tu index.php) a la raíz
RUN cp -r /var/www/html/backend/php/* /var/www/html/ || true

# 4. Movemos también los archivos de frontend a la raíz
RUN cp -r /var/www/html/frontend/html/* /var/www/html/ || true

# 5. Ajustamos permisos de lectura
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html


