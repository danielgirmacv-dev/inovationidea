#!/bin/sh
set -e

echo "==> Waiting for database connection..."
until php artisan db:monitor --databases=mysql > /dev/null 2>&1; do
    sleep 2
done

echo "==> Running migrations..."
php artisan migrate --force --no-interaction

echo "==> Seeding database (if empty)..."
USER_COUNT=$(php artisan tinker --execute 'echo App\Models\User::count();' 2>/dev/null | tr -d '\r\n')
if [ "$USER_COUNT" = "0" ]; then
    echo "==> Database is empty, running seeders..."
    php artisan db:seed --force --no-interaction
else
    echo "==> Database already has $USER_COUNT users, skipping seed."
fi

echo "==> Clearing and caching config/routes/views..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Fixing storage permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "==> Starting Laravel server..."
exec php artisan serve --host=0.0.0.0 --port=8000
