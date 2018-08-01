FROM php:7.1-cli

COPY ini/php.ini /usr/local/etc/php/

RUN apt-get update -y \
    && apt-get install -y \
        libxml2-dev \
    && apt-get clean -y \
    && pecl install xdebug-2.6.0 \
    && docker-php-ext-install soap \
    && docker-php-ext-enable xdebug soap