FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev \
 && docker-php-ext-install pdo pdo_mysql gd zip

RUN groupadd -g 1000 sail \
 && useradd -ms /bin/bash -u 1000 -g sail sail

# Xdebug (по запросу)
RUN pecl install xdebug && docker-php-ext-enable xdebug

WORKDIR /app
