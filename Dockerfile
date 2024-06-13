# Utiliser l'image officielle PHP avec Apache
FROM php:8.1-apache

# Installer les dépendances système pour les extensions PHP et Composer
RUN apt-get update && apt-get install -y libpng-dev libonig-dev libxml2-dev zip unzip git curl && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Activer le mod_rewrite pour Apache
RUN a2enmod rewrite

# Copier l'application dans le conteneur et définir les permissions
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Définir les permissions appropriées pour les dossiers et fichiers
RUN find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

# Définir le répertoire de travail
WORKDIR /var/www/html

# Exposer le port 80
EXPOSE 80

# Commande pour démarrer les services nécessaires
CMD composer install --no-interaction && \
    php artisan key:generate && \
    php artisan migrate:fresh --seed && \
    apache2-foreground
