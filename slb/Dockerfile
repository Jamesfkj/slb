# ============================================================
#  STAGE 1 — COMPOSER (build des vendor)
# ============================================================
FROM composer:2 AS composer_build
WORKDIR /app

# Copier uniquement les fichiers composer (cache + rapidité)
COPY composer.json composer.lock ./

# Installation sans vérifier la version PHP (utile pour rendu Docker)
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --ignore-platform-reqs


# ============================================================
#  STAGE 2 — PHP 8.2 + Apache
# ============================================================
FROM php:8.2-apache
WORKDIR /var/www/html

# ------------------------------------------------------------
# Installer les dépendances système
# ------------------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# ------------------------------------------------------------
# Installer les extensions PHP nécessaires à Laravel
# ------------------------------------------------------------
RUN docker-php-ext-configure intl
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    intl \
    pcntl \
    bcmath \
    gd \
    zip

# ------------------------------------------------------------
# Activer mod_rewrite (important pour Laravel)
# ------------------------------------------------------------
RUN a2enmod rewrite


# ------------------------------------------------------------
# Copier entièrement le projet
# ------------------------------------------------------------
COPY --chown=www-data:www-data . .

# Copier le dossier vendor compilé dans le container
COPY --from=composer_build /app/vendor ./vendor


# ------------------------------------------------------------
# Créer les dossiers Laravel obligatoires + permissions
# ------------------------------------------------------------
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data .

# ------------------------------------------------------------
# Config Apache pour Laravel
# ------------------------------------------------------------
RUN printf "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" \
    > /etc/apache2/sites-available/000-default.conf


# ============================================================
# Script de démarrage du container
# ============================================================
RUN printf "#!/bin/bash\n\
set -e\n\
cd /var/www/html\n\
\n\
# Si variables MySQL présentes → attendre la DB\n\
if [ ! -z \"\$MYSQLHOST\" ]; then\n\
    echo \"⏳ Waiting for MySQL...\"\n\
    until mysqladmin ping -h\"\$MYSQLHOST\" -P\"\$MYSQLPORT\" -u\"\$MYSQLUSER\" -p\"\$MYSQLPASSWORD\" --silent; do\n\
        sleep 2\n\
    done\n\
    echo \"✅ MySQL is ready!\"\n\
fi\n\
\n\
# Commandes Laravel\n\
php artisan key:generate --force || true\n\
php artisan migrate --force || true\n\
php artisan config:cache || true\n\
\n\
exec apache2-foreground\n" \
> /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh


# ------------------------------------------------------------
# Exposer HTTP
# ------------------------------------------------------------
EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
