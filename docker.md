# WebService - Film

## Description

This project is a web service that allows you to manage a list of movies. It is possible to add, delete, modify and search for a movie. The web service is accessible via a REST API.

## Prérequis

Assurez-vous d'avoir installé les outils suivants sur votre machine avant de commencer :

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Dockerisation du projet

### 1 - Cloner le projet

```bash
git clone https://gitlab.com/manzoneflorianpro/wsmovies.git
```

### 2 - Configuration de l'environnement laravel

Copier le fichier `.env.example` en `.env` (et aussi `docker-compose.yml`) et modifier les variables d'environnement suivantes :

```bash
    MYSQL_DATABASE: wsmovies
    MYSQL_USER: root
    MYSQL_PASSWORD: secret
    MYSQL_ROOT_PASSWORD: secret
```

### 3 - Build et lancement des containers

```bash
docker-compose up -d --build
```

### 4 - Installation des dépendances

```bash
docker-compose exec app composer install
```

### 5 - Exécution des Commandes Artisan
Pour exécuter des commandes Artisan à l'intérieur du conteneur Laravel, utilisez la commande suivante :
```bash
docker-compose exec app php artisan migrate
```
Remplacez php artisan migrate par toute autre commande artisan dont vous pourriez avoir besoin.

### 6 - Accéder au projet

```bash
http://localhost:8080
```

### Arrêter et supprimer les containers
Pour arrêter les conteneurs Docker, utilisez la commande suivante :
```bash
docker-compose down
```
