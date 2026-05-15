FROM php:8.2-apache

# 1. Instala y activa las extensiones oficiales de MySQL en el servidor
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli

# 2. Copia todo tu repositorio a la carpeta del servidor
COPY . /var/www/html/

# 3. Mantenemos la configuración de acceso a los directorios
RUN echo "<Directory /var/www/html/>" >> /etc/apache2/apache2.conf \
    && echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf \
    && echo "    AllowOverride All" >> /etc/apache2/apache2.conf \
    && echo "    Require all granted" >> /etc/apache2/apache2.conf \
    && echo "</Directory>" >> /etc/apache2/apache2.conf
