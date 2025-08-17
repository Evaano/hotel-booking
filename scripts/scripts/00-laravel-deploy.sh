#!/usr/bin/env bash
echo "Running composer"
# Check if composer is installed
if ! [ -x "$(command -v composer)" ]; then
  echo "Installing composer..."
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

# Install dependencies
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force