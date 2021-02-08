cd /var/www/laravel
npm install
composer install
chmod 777 -R /var/www/laravel/storage/
php artisan key:generate
php artisan storage:link
php artisan config:clear
php-fpm