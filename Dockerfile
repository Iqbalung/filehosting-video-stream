FROM php:7.4-apache

LABEL maintainer="Gbenga Oni B. <onigbenga@yahoo.ca>" version="1.0"

COPY --chown=www-data:www-data . /srv/app

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf 

WORKDIR /srv/app

RUN a2enmod rewrite

RUN a2enmod rewrite

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql pdo


EXPOSE 80