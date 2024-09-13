# Sử dụng base image php:8.2.11-apache
FROM php:8.2.11-apache

# Cài đặt các phụ thuộc hệ thống cần thiết
RUN apt-get update && \
  apt-get install -y \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libzip-dev \
  unzip \
  git && \
  # Cấu hình và cài đặt các extension PHP
  docker-php-ext-configure gd --with-freetype --with-jpeg && \
  docker-php-ext-install gd zip pdo pdo_mysql && \
  # Cài đặt và kích hoạt Xdebug
  pecl install xdebug && \
  docker-php-ext-enable xdebug

# Kích hoạt các module Apache cần thiết
RUN a2enmod rewrite ssl && \
  a2enmod mpm_prefork

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Đặt thư mục làm việc trong container
WORKDIR /var/www/html

# Sao chép cấu hình Apache và các script vào container
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html

# Cài đặt các phụ thuộc của Laravel bằng Composer
# RUN composer install --no-dev --optimize-autoloader

# Cấp quyền cho thư mục ứng dụng
RUN chmod -R 777 /var/www/html

# Dọn dẹp để giảm kích thước image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Xác định các cổng cần mở
EXPOSE 80
EXPOSE 443

# Khởi động Apache khi container chạy
CMD ["apache2-foreground"]
