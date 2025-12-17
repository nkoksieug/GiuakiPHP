FROM php:8.2-apache

# Cài đặt thư viện hệ thống
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl

# Cài đặt PHP Extension (Quan trọng: pdo_mysql)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cấu hình Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Bật mod_rewrite
RUN a2enmod rewrite

# Copy code vào Docker
WORKDIR /var/www/html
COPY . .

# Chạy Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Cấp quyền (Mở rộng quyền ghi 777 cho thư mục log để tránh lỗi Permission denied)
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 80

# --- SỬA ĐỔI QUAN TRỌNG: Tự động fix quyền sau khi migrate ---
# 1. Chạy migrate
# 2. Cấp lại quyền cho file log vừa sinh ra (để tránh lỗi Permission denied)
# 3. Khởi động Apache
CMD bash -c "php artisan migrate --force; chmod -R 777 storage/logs; apache2-foreground"