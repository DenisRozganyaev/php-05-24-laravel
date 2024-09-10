#!/bin/sh

php artisan migrate --force;
php artisan optimize;
php artisan event:cache;
