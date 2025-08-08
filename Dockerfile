# Gunakan image PHP + Apache + Composer
FROM composer:2.6 AS build

# Copy semua file ke container
WORKDIR /app
COPY . .

# Install dependency
RUN composer install --no-dev --optimize-autoloader

# Copy ke PHP-apache image
FROM php:8.2-apache

# Install ekstensi PHP Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy kode Laravel dari stage build
COPY --from=build /app /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set working dir
WORKDIR /var/www/html

# Environment Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Ubah config apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
