FROM php:8.3-apache
WORKDIR /var/www/html
RUN apt-get update -y && apt-get install -y libmariadb-dev libicu-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get update -y && apt-get install -y sendmail libpng-dev

RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev

RUN docker-php-ext-install mbstring

RUN docker-php-ext-install zip

RUN docker-php-ext-install gd

RUN apt-get update && \
apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
docker-php-ext-install gd