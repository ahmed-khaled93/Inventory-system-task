FROM php:8.3-fpm

WORKDIR /var/www

# install dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# copy project files
COPY . .

# 
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache

# 
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache