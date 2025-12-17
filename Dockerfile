# Sử dụng PHP 8.2 với Apache (Dễ cấu hình nhất cho người mới)
FROM php:8.2-apache

# 1. Cài đặt các thư viện cần thiết cho Laravel và PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev  # Quan trọng: Thư viện để kết nối Postgres

# 2. Cài đặt PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd pdo_pgsql

# 3. Cài đặt Composer (Công cụ quản lý thư viện PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Cấu hình Apache để trỏ vào thư mục /public của Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 5. Bật mod_rewrite của Apache (để Laravel chạy được URL đẹp)
RUN a2enmod rewrite

# 6. Thiết lập thư mục làm việc
WORKDIR /var/www/html

# 7. Copy toàn bộ code từ máy tính vào Docker
COPY . .

# 8. Cài đặt các gói thư viện Laravel (Composer)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 9. Phân quyền cho thư mục storage và cache (Rất quan trọng để tránh lỗi 500)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Mở port 80
EXPOSE 80