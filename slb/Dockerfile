 # Stage 2: Node
FROM node:22.17.1 AS node_build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build  # vérifie si le dossier final est /build ou /dist

# Stage 1: Composer
FROM composer:2 AS composer_build
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer update && composer install --no-dev --optimize-autoloader 

# Stage 3: PHP
FROM php:8.2-cli AS build
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
     unzip libzip-dev libpng-dev libbz2-dev git \
     && docker-php-ext-install pdo pdo_mysql zip gd \
     && pecl install mongodb \
     && docker-php-ext-enable mongodb \
     && rm -rf /var/lib/apt/lists/*

# Copier les vendor et build
COPY --from=composer_build /app/vendor ./vendor

# Copier le reste du projet
COPY . .

# Lancer serveur PHP (dev)
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
