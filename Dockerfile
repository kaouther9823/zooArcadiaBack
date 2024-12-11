# Utiliser l'image PHP 8.2 officielle avec FPM
FROM php:8.2-fpm

# Installer les dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    wget \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Installer les extensions PHP requises pour Symfony
RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    zip \
    mbstring \
    gd

# Installer l'extension MongoDB
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Définir le répertoire de travail
WORKDIR /var/www/symfony

# Copier les fichiers de l'application
COPY . .

# Nettoyer le cache de Composer
RUN composer clear-cache

# Installer Symfony Flex si nécessaire
RUN composer require symfony/flex --no-scripts --no-interaction --ignore-platform-reqs

# Installer les dépendances Composer
RUN composer install --no-scripts --no-interaction --optimize-autoloader

# Permissions pour éviter les conflits sur Windows
RUN chmod -R 775 /var/www/symfony

# Exposer le port utilisé par PHP-FPM
EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]
