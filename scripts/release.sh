#!/bin/sh

npm install;
npm run build;
php artisan migrate --force;
php artisan optimize;
php artisan event:cache;
php artisan queue:listen --queue=default,wishlist,wishlist-notifications,admin-mail,admin-telegram,listeners;
