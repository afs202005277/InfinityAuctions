#!/bin/bash
set -e

cd /var/www
env >> /var/www/.env
php artisan clear-compiled
php artisan config:clear

env >> /var/www/.env
php-fpm8.1 -D
cron
nginx -g "daemon off;"
