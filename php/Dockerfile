FROM php:5.5.38-apache
MAINTAINER MasahiroSaito (m411momo)

RUN apt-get update
RUN docker-php-ext-install pdo_mysql mbstring

ADD [ "cakephp.conf", "/etc/apache2/conf-enabled/cakephp.conf" ]
ADD [ "php.ini", "/usr/local/etc/php/conf.d/php.ini" ]