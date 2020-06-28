#!/bin/sh

set -e
composer install

php-fpm -D
nginx