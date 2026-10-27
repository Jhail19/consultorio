#!/bin/sh
set -e

# Render (y otras plataformas) indican el puerto en $PORT
PORT="${PORT:-10000}"
sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Crea/actualiza las tablas (NUNCA migrate:fresh en producción)
php artisan migrate --force

# Solo si SEED_DB=true: carga los datos de ejemplo y el usuario admin
if [ "${SEED_DB}" = "true" ]; then
    php artisan db:seed --force
fi

exec apache2-foreground