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
    jpegoptim optipng pngquant gifsicle \
    vim \
    supervisor \
    cron \
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

# Copy composer files first
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy application files
COPY . .

# Run composer scripts
RUN composer run-script post-autoload-dump

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Create supervisor config for queue worker
RUN echo '[program:laravel-queue]' > /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'process_name=%(program_name)s_%(process_num)02d' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'command=php /var/www/html/artisan queue:work --sleep=3 --tries=3 --max-time=3600' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'autostart=true' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'autorestart=true' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'user=www-data' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'numprocs=2' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'redirect_stderr=true' >> /etc/supervisor/conf.d/laravel-queue.conf \
    && echo 'stdout_logfile=/var/www/html/storage/logs/queue.log' >> /etc/supervisor/conf.d/laravel-queue.conf

# Create startup script
RUN echo '#!/bin/bash' > /usr/local/bin/start.sh \
    && echo 'php artisan config:cache' >> /usr/local/bin/start.sh \
    && echo 'php artisan route:cache' >> /usr/local/bin/start.sh \
    && echo 'php artisan view:cache' >> /usr/local/bin/start.sh \
    && echo 'php artisan migrate --force' >> /usr/local/bin/start.sh \
    && echo 'php artisan storage:link' >> /usr/local/bin/start.sh \
    && echo 'supervisord -c /etc/supervisor/supervisord.conf &' >> /usr/local/bin/start.sh \
    && echo 'php-fpm' >> /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

# Expose port 9000
EXPOSE 9000

# Start services
CMD ["/usr/local/bin/start.sh"]