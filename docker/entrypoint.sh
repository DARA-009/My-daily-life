#!/usr/bin/env bash
set -e

echo "============================================="
echo " Starting My Daily Life (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ) "
echo "============================================="

# Ensure an APP_KEY is always set even if not yet configured in Railway variables
if [ -z "$APP_KEY" ]; then
    echo "Notice: APP_KEY not provided in environment, applying fallback application key."
    export APP_KEY="base64:v/nVbbB7Lid37bz1Fp/kmM+F6/dr4aK+tJSenBArzO4="
fi

# Railway dynamic port
PORT="${PORT:-80}"
echo "[1/6] Configuring Nginx to listen on port: $PORT"
if [ "$PORT" != "80" ] && [ "$PORT" != "9000" ]; then
    sed -i "s/listen 80;/listen $PORT;/g" /etc/nginx/conf.d/default.conf
fi

echo "[2/6] Linking storage..."
php artisan storage:link --force || true

echo "[3/6] Checking database environment..."
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

echo "[4/6] Optimizing Laravel configuration cache..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "[5/6] Starting PHP-FPM daemon..."
php-fpm -D
sleep 1

echo "[6/6] Testing and starting Nginx on ports 80 and 9000 (and $PORT)..."
nginx -t
exec nginx -g "daemon off;"
