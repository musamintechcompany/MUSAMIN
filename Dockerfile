# Use PHP 8.2 FPM as base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libxpm-dev \
    libicu-dev \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all files
COPY . /var/www/html/

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Create supervisor config for queue worker
RUN echo '[program:laravel-queue]' > /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'command=php /var/www/html/artisan queue:work --sleep=3 --tries=3' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'autostart=true' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'autorestart=true' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'user=www-data' >> /etc/supervisor/conf.d/laravel-queue.conf

# Start script
RUN echo '#!/bin/bash' > /start.sh \
    && echo 'php artisan config:cache' >> /start.sh \
    && echo 'php artisan migrate --force' >> /start.sh \
    && echo 'php artisan storage:link' >> /start.sh \
    && echo 'supervisord -n &' >> /start.sh \
    && echo 'php-fpm' >> /start.sh \
    && chmod +x /start.sh

EXPOSE 9000

CMD ["/start.sh"]