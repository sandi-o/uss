#!/bin/bash
cd /var/www/html/uss
php artisan migrate --force
php artisan config:cache