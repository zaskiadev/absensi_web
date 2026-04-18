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
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
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

# Buat .env dari example supaya script tidak gagal saat build
RUN cp .env.example .env

# Install dependencies Laravel (tanpa menjalankan post-install scripts)
RUN composer install --no-interaction --optimize-autoloader --no-scripts

# Install Node dependencies dan build assets
RUN npm install && npm run build

# Expose port untuk local development
EXPOSE 8000

# Jalankan server bawaan Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000