FROM php:fpm-alpine

WORKDIR /usr/src/app

RUN apk add --no-cache git nginx

RUN curl -s http://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

COPY composer.json .
COPY composer.lock .

RUN composer install

COPY src/ .

ENTRYPOINT ["/docker-entrypoint.sh"]