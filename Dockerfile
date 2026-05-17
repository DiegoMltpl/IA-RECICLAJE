FROM php:8.3-apache

# Dependencias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    libzip-dev \
    libpq-dev \
    sqlite3 \
    libsqlite3-dev \
    zip

# PHP Extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql zip
# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache rewrite
RUN a2enmod rewrite

# Carpeta app
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Config Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
/etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
/etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Laravel
RUN composer install --no-dev --optimize-autoloader

# Frontend
RUN npm install
RUN npm run build



# Permisos
RUN chmod -R 777 storage bootstrap/cache database

# Variables
ENV APP_ENV=production
ENV APP_DEBUG=false

# Laravel
RUN php artisan config:clear
RUN php artisan view:clear
RUN php artisan storage:link
RUN php artisan migrate --force

# Puerto
EXPOSE 80