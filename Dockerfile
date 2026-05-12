FROM php:8.3-cli

# Instalar dependencias
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

# Extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Carpeta proyecto
WORKDIR /app

# Copiar archivos
COPY . .

# Instalar Laravel
RUN composer install --no-dev --optimize-autoloader

# Instalar frontend
RUN npm install
RUN npm run build

# Crear SQLite
RUN mkdir -p database
RUN touch database/database.sqlite

# Permisos Laravel
RUN chmod -R 777 storage bootstrap/cache database

# Variables producción
ENV APP_ENV=production
ENV APP_DEBUG=false

# Limpiar cache
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan view:clear
RUN php artisan route:clear

# Migraciones
RUN php artisan migrate --force

# Optimización Laravel
RUN php artisan optimize

# Puerto Render
EXPOSE 10000

# Ejecutar Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000