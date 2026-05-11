FROM php:8.3-cli

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    libzip-dev \
    zip

# Extensiones PHP
RUN docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Carpeta proyecto
WORKDIR /app

# Copiar archivos
COPY . .

# Instalar Laravel
RUN composer install --no-dev --optimize-autoloader

# Instalar Vite
RUN npm install
RUN npm run build

# Puerto Render
EXPOSE 10000

# Ejecutar Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000