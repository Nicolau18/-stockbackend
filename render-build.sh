#!/usr/bin/env bash
set -e

echo "===> A instalar PHP 8.2..."
apt-get update -y
apt-get install -y \
    php8.2 \
    php8.2-cli \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-pgsql \
    php8.2-mysql \
    php8.2-curl \
    php8.2-zip \
    php8.2-bcmath \
    php8.2-tokenizer \
    unzip \
    curl

echo "===> A instalar Composer..."
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

echo "===> A instalar dependências Laravel..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "===> A configurar Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "===> A correr migrações..."
php artisan migrate --force

echo "===> Build concluído com sucesso!"