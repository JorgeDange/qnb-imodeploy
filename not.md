
php artisan key:generate --force
php artisan migrate --force
php artisan view:cache
php artisan config:cache
php artisan route:cache


php artisan key:generate --force
php artisan migrate --force
php artisan db:seed --force --class=PlanosSeeder
php artisan db:seed --force --class=AmenidadesSeeder
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan config:publish view
php artisan view:cache