# deploy/Dockerfile

# stage 1: build stage
FROM php:8.2-fpm-alpine as build


# installing system dependencies and php extensions
RUN apk add --no-cache \
    zip \
    libzip-dev \
    freetype \
    libjpeg-turbo \
    libpng \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    icu-dev \
    oniguruma-dev \
    nodejs \
    npm \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl mbstring pdo_mysql\
    && docker-php-ext-enable intl mbstring pdo_mysql
    

# install composer
COPY --from=composer:2.7.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# copy necessary files and change permissions
COPY . .

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage/app/public \
    && chmod -R 775 /var/www/html/bootstrap/cache


COPY package.json package-lock.json .

RUN npm install

RUN chown -R www-data:www-data /var/www/html/vendor \
    && chmod -R 775 /var/www/html/vendor