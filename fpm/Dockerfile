FROM php:8.2-fpm

RUN apt-get clean

RUN apt-get update

RUN apt-get install -y zlib1g-dev libicu-dev g++ libpq-dev libxml2-dev libjpeg-dev libpng-dev unzip libzip-dev wget libonig-dev

RUN docker-php-ext-install pdo_mysql bcmath mbstring zip intl sockets

RUN docker-php-ext-configure intl

RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

RUN docker-php-ext-enable opcache \
&& echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini \
&& echo "opcache.enable_cli=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/bin --filename=composer --quiet --version=2.3.5

