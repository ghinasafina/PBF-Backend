# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Install ekstensi PHP yang diperlukan
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy semua file proyek CodeIgniter
COPY . .

# Jalankan CodeIgniter dengan Apache
CMD ["apache2-foreground"]
