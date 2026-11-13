#!/bin/bash
set -e

echo "Deploying My Daily Life (ជីវិតប្រចាំថ្ងៃរបស់ខ្ញុំ)..."

# 1. Maintenance Mode
php artisan down --secret="mdl-deploy-bypass" || true

# 2. Update Codebase
git fetch origin master
git reset --hard origin/master

# 3. Dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
npm ci
npm run build

# 4. Migrate Database
php artisan migrate --force

# 5. Production Optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Restart Services
sudo systemctl reload php8.5-fpm || true
sudo supervisorctl restart all || true

# 7. Bring Application Online
php artisan up

echo "Deployment finished successfully!"
