# 1️⃣ Gunakan image PHP dengan extensions yang dibutuhkan Laravel
FROM php:8.3-fpm

# 2️⃣ Install sistem dependencies dan ekstensi PHP tambahan
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 3️⃣ Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# 4️⃣ Set working directory
WORKDIR /var/www/html

# 5️⃣ Copy semua file ke container
COPY . .

# 6️⃣ Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# 7️⃣ Build frontend (jika pakai Vite)
RUN apt-get install -y nodejs npm && npm ci && npm run build

# 8️⃣ Expose port dan start Laravel
EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
