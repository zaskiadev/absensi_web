FROM php:8.4-cli

# Install system dependencies (termasuk libicu-dev untuk intl)
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    default-mysql-client \
    libicu-dev

# --- TAMBAHAN BARU: Install Node.js dan NPM ---
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs
    
# Install PHP extensions yang dibutuhkan Laravel & Filament
RUN docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl intl

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