FROM php:8.4.4-fpm-bookworm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y libzip-dev git libpq-dev \
    && docker-php-ext-install \
      opcache \
      pcntl \
      zip

RUN docker-php-ext-install pdo_pgsql pgsql

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY ./app /var/www/html

RUN composer i -o

# User
ARG UID
ARG GID

RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

USER www-data
