FROM php:7.1-apache

COPY app/ /var/www/

RUN sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www
