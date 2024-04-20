FROM php:7.4-apache

LABEL maintainer="Gbenga Oni B. <onigbenga@yahoo.ca>" version="1.0"

COPY --chown=www-data:www-data . /srv/app

COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf 

WORKDIR /srv/app

RUN sed -i -e 's/^zpost_max_size\s*=.*/post_max_size = 100M/' /etc/php/7.4/apache2/php.ini
RUN sed -i -e 's/^upload_max_filesize\s*=.*/upload_max_filesize = 100M/' /etc/php/7.4/apache2/php.ini

RUN a2enmod rewrite

RUN a2enmod rewrite

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql pdo \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql



EXPOSE 80