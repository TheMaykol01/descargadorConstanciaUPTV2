FROM php:8.5-fpm-alpine

# Carpeta de trabajo dentro del contenedor
WORKDIR /var/www/html

# 1. Instalar extensiones (MySQL, GD para PDFs) y Composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_mysql gd zip @composer

# 2. Configuración de PHP (memoria, tiempos y zona horaria)
COPY docker/php/custom.ini $PHP_INI_DIR/conf.d/custom.ini

# 3. Copiar el código del proyecto con permisos para el usuario www-data
COPY --chown=www-data:www-data . .

# 4. Seguridad: no ejecutar como root
USER www-data

# 5. Puerto y arranque de PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
