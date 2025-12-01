#!/bin/bash
set -e

echo "Bajando la app..."
php artisan down || true

echo "Instalando dependencias..."
composer install --no-interaction --prefer-dist

echo "Limpiando caches..."
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
php artisan clear-compiled

echo "Regenerando caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Limpiando sesiones si están en archivos..."
if [ -d storage/framework/sessions ]; then
    rm -f storage/framework/sessions/*
fi

echo "Ajustando permisos..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo "Levantando la app..."
php artisan up

echo "Listo. El proyecto quedó operativo."
