FROM php:8.1-fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y libzip-dev zip \
    && docker-php-ext-install zip pdo_mysql

COPY php.ini $PHP_INI_DIR

CMD ["php-fpm"]

EXPOSE 9003

WORKDIR /var/www
