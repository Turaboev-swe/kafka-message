FROM php:8.3-fpm

# Install necessary libraries and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    librdkafka-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && pecl install rdkafka \
    && docker-php-ext-enable rdkafka

WORKDIR /var/www

# Copy application code
COPY . .

# Copy Composer from the Composer image and run install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run composer install
RUN composer install

# Set permissions for storage and cache directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Ensure storage logs directory exists with proper permissions
RUN mkdir -p /var/www/storage/logs && chown -R www-data:www-data /var/www/storage/logs
