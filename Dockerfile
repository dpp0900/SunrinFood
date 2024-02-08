FROM php:7.4-apache

RUN apt-get update
RUN apt-get install openssh-server -y

COPY ./src /var/www/html

EXPOSE 80

RUN a2enmod rewrite
RUN a2enmod headers
RUN apache2ctl -k graceful
