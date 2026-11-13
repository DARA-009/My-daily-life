#!/usr/bin/env bash
set -e

echo "============================================="
echo " Starting My Daily Life (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ) "
echo "============================================="

# Railway assigns a dynamic $PORT (default to 9000 which Railway generated, or 80)
PORT="${PORT:-9000}"
echo "[1/5] Configuring Nginx to listen on port: $PORT"
sed -i "s/listen [0-9]\+;/listen $PORT;/g" /etc/nginx/sites-available/default

echo "[2/5] Linking storage..."
php artisan storage:link --force || true

echo "[3/5] Checking and running database migrations..."
# Auto-detect Railway PostgreSQL environment variables
if [ -z "$DB_HOST" ] && [ -n "$PGHOST" ]; then
    echo "Detected Railway Postgres variables (PGHOST=$PGHOST)"
    export DB_CONNECTION="${DB_CONNECTION:-pgsql}"
    export DB_HOST="$PGHOST"
    export DB_PORT="${PGPORT:-5432}"
    export DB_DATABASE="$PGDATABASE"
    export DB_USERNAME="$PGUSER"
    export DB_PASSWORD="$PGPASSWORD"
fi

if [ -n "$DATABASE_URL" ] && [ -z "$DB_URL" ]; then
    export DB_CONNECTION="${DB_CONNECTION:-pgsql}"
    export DB_URL="$DATABASE_URL"
fi

if [ -n "$DB_HOST" ] || [ -n "$DATABASE_URL" ] || [ -n "$PGHOST" ]; then
    echo "Running database migrations..."
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
