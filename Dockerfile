# Etapa 1: construir dependencias PHP
FROM composer:2 AS build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader
COPY . .

# Etapa 2: servidor final
FROM php:8.2-apache

# Habilitar extensiones necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Copiar el código desde la etapa build
COPY --from=build /app /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Configurar permisos y optimizar Laravel
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite \
    && echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>" > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# Exponer puerto 80
EXPOSE 80

# Comando de inicio
CMD ["apache2-foreground"]
