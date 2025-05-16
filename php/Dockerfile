FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN a2enmod rewrite 
# Apache 2 Enable Module Rewrite
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html