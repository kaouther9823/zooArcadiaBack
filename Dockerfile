# Utiliser une image PHP officielle avec Apache
FROM php:8.2-fpm

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg-dev \
    && docker-php-ext-install \
    intl pdo_mysql zip gd mongodb

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copier le code Symfony dans le conteneur
WORKDIR /var/www/symfony
COPY . /var/www/symfony

# Donner les permissions
RUN chown -R www-data:www-data /var/www/symfony

# Installer les dépendances Symfony
RUN composer install --no-scripts --no-interaction

# Exposer le port pour le backend
EXPOSE 9000

CMD ["php-fpm"]
