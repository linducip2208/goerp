#!/bin/bash
set -e
echo "=== GoERP Production Deploy ==="

echo "[1/6] Install composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "[2/6] Install npm dependencies..."
npm install

echo "[3/6] Build assets..."
npm run build

echo "[4/6] Run migrations..."
php artisan migrate --force

echo "[5/6] Clear & cache config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

echo "[6/6] Restart queue worker..."
sudo supervisorctl restart goerp-worker

echo "=== Deploy complete ==="
echo ""
echo "Platform Admin : https://domain.com/admin"
echo "Customer ERP   : https://domain.com/app"
