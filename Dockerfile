FROM php:8.2-apache

# 1. Copiamos todo el contenido de tus carpetas al servidor
COPY ./frontend/html/ /var/www/html/
COPY ./backend/php/ /var/www/html/

# 2. Corregimos los permisos de los archivos para que Apache pueda leerlos
RUN chown -W www-data:www-data /var/www/html/* && chmod -R 755 /var/www/html

# 3. Forzamos a Apache a permitir el acceso al directorio raíz
RUN echo "<Directory /var/www/html/>" >> /etc/apache2/apache2.conf \
    && echo "    Options Indexes FollowSymLinks" >> /etc/apache2/apache2.conf \
    && echo "    AllowOverride All" >> /etc/apache2/apache2.conf \
    && echo "    Require all granted" >> /etc/apache2/apache2.conf \
    && echo "</Directory>" >> /etc/apache2/apache2.conf