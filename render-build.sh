#!/usr/bin/env bash
set -e

# Instala PHP e extensões
apt-get update
apt-get install -y php8.2 php8.2-cli php8.2-mbstring php8.2-xml \
    php8.2-pgsql php8.2-curl php8.2-zip unzip

# Instala Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Instala dependências Laravel
composer install --no-dev --optimize-autoloader

# Configura Laravel
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan migrate --force