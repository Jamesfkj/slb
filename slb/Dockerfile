# Stage 1: Composer - Installer les dépendances PHP
FROM composer:2 AS composer_build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

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

# Copier les vendor depuis composer_build
COPY --from=composer_build /app/vendor ./vendor

# Copier tout le projet
COPY . .

# Créer les dossiers Laravel s'ils n'existent pas et configurer les permissions
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
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
\n\
# Attendre MySQL\n\
if [ ! -z "$MYSQLHOST" ]; then\n\
    echo "Waiting for MySQL..."\n\
    until mysqladmin ping -h"$MYSQLHOST" -P"$MYSQLPORT" -u"$MYSQLUSER" -p"$MYSQLPASSWORD" --silent 2>/dev/null; do\n\
        echo "MySQL is unavailable - sleeping"\n\
        sleep 2\n\
    done\n\
    echo "MySQL is up!"\n\
fi\n\
\n\
# Générer la clé Laravel\n\
php artisan key:generate --force --no-interaction || true\n\
\n\
# Exécuter les migrations\n\
php artisan migrate --force --no-interaction\n\
\n\
# Optimisations Laravel\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Démarrer Apache\n\
apache2-foreground' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
