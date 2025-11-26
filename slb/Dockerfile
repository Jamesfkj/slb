# Stage 1: Composer - Installer les dépendances PHP
FROM composer:2 AS composer_build
WORKDIR /app

# Copier les fichiers composer
COPY composer.json composer.lock ./

# Ignorer les requirements de plateforme pour le build
RUN composer install --no-dev --optimize-autoloader --no-scripts --ignore-platform-reqs

# Stage 2: PHP avec Apache - Image finale
FROM php:8.2-apache
WORKDIR /var/www/html

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP nécessaires pour Laravel
RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    intl \
    pcntl \
    bcmath \
    gd \
    zip

# Activer mod_rewrite pour Laravel
RUN a2enmod rewrite

# Copier TOUT le projet
COPY --chown=www-data:www-data . .

# Copier les vendor depuis composer_build
COPY --from=composer_build /app/vendor ./vendor

# Créer les dossiers Laravel et configurer les permissions
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Configuration Apache pour Laravel
RUN echo '<VirtualHost *:80>\n\
    ServerAdmin webmaster@localhost\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Script de démarrage
RUN echo '#!/bin/bash\n\
set -e\n\
cd /var/www/html\n\
\n\
if [ ! -z "$MYSQLHOST" ]; then\n\
    echo "Waiting for MySQL..."\n\
    until mysqladmin ping -h"$MYSQLHOST" -P"$MYSQLPORT" -u"$MYSQLUSER" -p"$MYSQLPASSWORD" --silent 2>/dev/null; do\n\
        sleep 2\n\
    done\n\
    echo "MySQL is ready!"\n\
fi\n\
\n\
php artisan key:generate --force --no-interaction || true\n\
php artisan migrate --force --no-interaction || true\n\
php artisan config:cache || true\n\
\n\
apache2-foreground' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
