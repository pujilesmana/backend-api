# Gunakan base image PHP 8.3 FPM
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer (copy dari image composer)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy semua file ke container
COPY . .

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Copy .env.example -> .env jika belum ada
RUN cp .env.example .env || true

# Generate key
RUN php artisan key:generate

# Ubah permission storage & bootstrap
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 5000
CMD ["php-fpm"]
