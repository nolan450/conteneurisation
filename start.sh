#!/bin/bash

# Installer les dépendances avec Composer
composer install

# Générer la clé d'application Laravel
php artisan key:generate

# Exécuter les migrations
php artisan migrate

# Démarrer Apache en arrière-plan
apache2-foreground
