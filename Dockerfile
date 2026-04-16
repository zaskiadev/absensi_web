FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    default-mysql-client

# Install PHP extensions yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Salin seluruh kode aplikasi
COPY . .

# Install dependencies Laravel
RUN composer install --no-interaction --optimize-autoloader

# Expose port untuk local development
EXPOSE 8000

# Jalankan server bawaan Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000