FROM php:7.4-fpm

RUN apt-get update \
  && apt-get install -y --no-install-recommends git apache2-utils libonig-dev libyaml-dev libzip-dev mariadb-client librabbitmq-dev && docker-php-ext-install pdo_mysql mysqli mbstring sockets zip \
  && pecl install yaml \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && pecl install amqp \
  && docker-php-ext-enable amqp

COPY "memory-limit-php.ini" "/usr/local/etc/php/conf.d/memory-limit-php.ini"

WORKDIR /var/www/html
