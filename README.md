# Contexte du projet
> Projet en *collaboration* avec **Bonal Tristan**, **Hamzaoui Ammar** et **El Assi Nolan**.

Pour un cours sur les Web Services nous devions en faire un pour des films. 

## Prérequis

Assurez-vous d'avoir installé les outils suivants avant de commencer :

- [Docker](https://www.docker.com/)
- [Docker compose](https://docs.docker.com/compose/)

## Clonage du projet

```sh
git clone https://gitlab.com/manzoneflorianpro/wsmovies.git
```

## Build et lancement des containers

```sh
docker-compose up -d --build
```

## Installation des dépendances

Une fois le projet cloné, vous devez installer les dépendances pour qu'il puisse fonctionner correctement.

```sh
composer install && composer require spatie/array-to-xml

docker-compose exec app composer install
```

## Lancement du projet 

Pour lancer ce projet, il suffit de créer un fichier `.env` pour cela, il y a un fichier `.env.example` qu'il faudra copier entièrement et coller dans le nouveau.

La seule partie qu'il faudra modifier pour le projet est :

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=le_nom_de_votre_db
DB_USERNAME=le_nom_de_votre_utilisateur
DB_PASSWORD=votre_mdp
```

Ensuite il reste très peu de choses à faire.

```sh
docker-compose exec app php artisan migrate

docker-compose exec app php artisan db:seed

docker-compose exec app php artisan serve
```

## Accès au projet



## Arrêt et suppression des containers

Pour arrêter et supprimer les conteneurs Docker, utilisez la commande suivante :

```sh
docker-compose down
```
