FROM composer:latest AS buiilcomposer

FROM php:8.2

COPY --from=buiilcomposer /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zlib1g-dev \
        libzip-dev \
        libxml2-dev \
        graphviz \
        libonig-dev \
    
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd pdo_mysql mysqli zip sockets \
    && docker-php-source delete


RUN mkdir -p /app
WORKDIR /app
COPY ./main-service .
RUN rm -rf vendor
RUN composer install
CMD [ "php", "artisan", "serve", "--host=0.0.0.0", "--port=8000" ]
EXPOSE 8000