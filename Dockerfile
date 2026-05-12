FROM php:8.3-cli

# =========================
# INSTALAR DEPENDENCIAS
# =========================
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    zip

# =========================
# EXTENSIONES PHP
# =========================
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

# =========================
# INSTALAR COMPOSER
# =========================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# =========================
# CARPETA PROYECTO
# =========================
WORKDIR /app

# =========================
# COPIAR ARCHIVOS
# =========================
COPY . .

# =========================
# INSTALAR LARAVEL
# =========================
RUN composer install --no-dev --optimize-autoloader

# =========================
# INSTALAR FRONTEND
# =========================
RUN npm install
RUN npm run build

# =========================
# CREAR SQLITE
# =========================
RUN mkdir -p database
RUN touch database/database.sqlite

# =========================
# PERMISOS
# =========================
RUN chmod -R 777 storage bootstrap/cache database

# =========================
# VARIABLES PRODUCCIÓN
# =========================
ENV APP_ENV=production
ENV APP_DEBUG=false

# =========================
# LIMPIAR CONFIG
# =========================
RUN php artisan config:clear
RUN php artisan view:clear

# =========================
# STORAGE LINK
# =========================
RUN php artisan storage:link

# =========================
# MIGRACIONES
# =========================
RUN php artisan migrate --force

# =========================
# OPTIMIZAR LARAVEL
# =========================
RUN php artisan optimize

# =========================
# PUERTO RENDER
# =========================
EXPOSE 10000

# =========================
# EJECUTAR LARAVEL
# =========================
CMD php artisan serve --host=0.0.0.0 --port=10000