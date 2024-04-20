FROM php:7.4-apache

LABEL maintainer="Gbenga Oni B. <onigbenga@yahoo.ca>" version="1.0"

COPY --chown=www-data:www-data . /srv/app

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf 

WORKDIR /srv/app


RUN a2enmod rewrite

RUN a2enmod rewrite

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql pdo \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql


RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
    sed -i 's/upload_max_filesize = 200M/upload_max_filesize = 1280M/g' /usr/local/etc/php/php.ini && \
    sed -i 's/whatever_option = 1234/whatever_option = 4321/g' /usr/local/etc/php/php.ini && \
    sed -i -e 's/^zpost_max_size\s*=.*/post_max_size = 100M/' /etc/php/7.4/apache2/php.ini



EXPOSE 80