web: vendor/bin/heroku-php-apache2 public/
tasks: npm install && npm run build && php artisan migrate --force && php artisan queue:work --queue=default,wishlist,wishlist-notifications,admin-mail,admin-telegram,listeners --sleep=3 --tries=3 --max-time=3600 --daemon
