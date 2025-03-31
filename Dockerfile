# Sử dụng PHP 8.2 với Apache
FROM php:8.2-apache

# Cài đặt các dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql gd

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Tạo thư mục cho dự án
WORKDIR /var/www/html

# Copy toàn bộ mã nguồn vào container
COPY . .

# Cài đặt dependencies của Laravel
RUN composer install --no-dev --optimize-autoloader

# Tạo APP_KEY
RUN php artisan key:generate

# Thiết lập quyền cho storage
RUN chmod -R 777 storage bootstrap/cache

# Cấu hình Apache
RUN chown -R www-data:www-data /var/www/html

# Expose cổng 80
EXPOSE 80

# Lệnh chạy server
CMD ["apache2-foreground"]
