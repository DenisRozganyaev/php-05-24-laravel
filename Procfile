release: ./scripts/release.sh
web: vendor/bin/heroku-php-apache2 public/
tasks: npm install && npm run build && php artisan migrate --force && php artisan queue:listen --queue=default,wishlist,wishlist-notifications,admin-mail,admin-telegram,listeners
