#!/bin/bash

# Navigate to working directory
cd /var/www/html

# Install dependencies if not already installed
if [ ! -f vendor/bin/phpunit ]; then
    echo "Installing Composer dependencies..."
    composer install || composer require --dev phpunit/phpunit ^10
fi

# Run the main PHP-FPM process
exec docker-php-entrypoint php-fpm