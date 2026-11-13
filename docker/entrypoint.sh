#!/usr/bin/env bash
set -e

echo "============================================="
echo " Starting My Daily Life (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ) "
echo "============================================="

# Railway assigns a dynamic $PORT (defaults to 80 if not set)
PORT="${PORT:-80}"
echo "[1/5] Configuring Nginx to listen on port: $PORT"
sed -i "s/listen [0-9]\+;/listen $PORT;/g" /etc/nginx/sites-available/default

echo "[2/5] Linking storage..."
php artisan storage:link --force || true

echo "[3/5] Checking and running database migrations..."
if [ -n "$DB_HOST" ] || [ -n "$DATABASE_URL" ]; then
    php artisan migrate --force || echo "Warning: Migration failed, will continue boot."
else
    echo "Notice: DB_HOST not yet configured, skipping migrations."
fi

echo "[4/5] Caching application routes and configuration..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "[5/5] Launching PHP-FPM and Nginx..."
php-fpm -D
exec nginx -g "daemon off;"
