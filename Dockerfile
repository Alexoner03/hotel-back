FROM php:7.3-fpm

LABEL name="Juan Carlos Perdomo Quiceno"
LABEL maintainer="jcpq60981@gmail.com"


ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get -y upgrade

#install composer 
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composers

# install extencion php
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install zip
RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/  &&  \
    docker-php-ext-install gd
# clear  lib
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# copy source sh
COPY ./docker/start.sh /home/start.sh

# copy
RUN chmod 777 /home/start.sh

# Set working directory
WORKDIR /var/www/laravel

# Expose ports
EXPOSE 9000 

# execute command
CMD ["/home/start.sh"]