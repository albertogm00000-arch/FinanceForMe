# Etapa 1: construir dependencias PHP (Alpine)
FROM composer:2 AS build
WORKDIR /app

# Instalar zip/unzip en Alpine
RUN apk add --no-cache zip unzip

# Copiar archivos de Composer y ejecutar instalación
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copiar el resto del código
COPY . .

# Etapa 2: servidor final (PHP + Apache)
FROM php:8.2-apache

# Instalar extensiones necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Copiar código del build
COPY --from=build /app /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Configurar permisos y Apache
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
