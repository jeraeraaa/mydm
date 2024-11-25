# Menggunakan image PHP dengan Apache
FROM php:8.1-apache

# Install dependensi yang diperlukan
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    && docker-php-ext-install zip pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin semua file ke dalam container
COPY . /var/www/html

# Set direktori kerja
WORKDIR /var/www/html

# Ubah permission folder storage dan bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan perintah artisan untuk cache config
RUN composer install && php artisan config:cache

# Ekspos port 80
EXPOSE 80

# Jalankan server Apache
CMD ["apache2-foreground"]