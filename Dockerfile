FROM php:8.3-apache

# =========================
# DEPENDENCIAS
# =========================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    libzip-dev \
    libpq-dev \
    zip

# =========================
# EXTENSIONES PHP
# =========================
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# =========================
# COMPOSER
# =========================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# =========================
# APACHE
# =========================
RUN a2enmod rewrite

# =========================
# WORKDIR
# =========================
WORKDIR /var/www/html

# =========================
# COPIAR PROYECTO
# =========================
COPY . .

# =========================
# CONFIG APACHE
# =========================
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
/etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
/etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# =========================
# INSTALAR LARAVEL
# =========================
RUN composer install --no-dev --optimize-autoloader

# =========================
# FRONTEND / VITE
# =========================
RUN npm install

ENV NODE_ENV=production

RUN npm run build

# =========================
# PERMISOS
# =========================
RUN chmod -R 777 storage bootstrap/cache

# =========================
# VARIABLES PRODUCCIÓN
# =========================
ENV APP_ENV=production
ENV APP_DEBUG=false

# =========================
# LIMPIAR CACHE
# =========================
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan route:clear

# =========================
# STORAGE LINK
# =========================
RUN php artisan storage:link

# =========================
# MIGRACIONES AUTOMÁTICAS
# =========================
RUN php artisan migrate --force

# =========================
# PUERTO
# =========================
EXPOSE 80