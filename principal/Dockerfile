FROM php:8.1-apache

RUN apt update -y
RUN apt upgrade -y
RUN apt install vim -y

RUN apt install -y libzip-dev unzip

RUN docker-php-ext-install zip pdo pdo_mysql

COPY . .

RUN mv index\ .html index.html
