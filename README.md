# Contexte du projet

## Prérequis

Assurez-vous d'avoir installé les outils suivants avant de commencer :

- [Docker](https://www.docker.com/)
- [Docker compose](https://docs.docker.com/compose/)

## Clonage du projet

```sh
git clone https://github.com/nolan450/conteneurisation.git
```

## Utilisation des Dockerfiles

### Environnement de développement

Pour construire et lancer l'image Docker pour l'environnement de développement, exécutez les commandes suivantes :

```bash
docker build -f Dockerfile.dev -t conteneurisation-symfony-dev .
docker run -p 80:80 conteneurisation-symfony-dev
```

### Environnement de production

Pour construire et lancer l'image Docker pour l'environnement de production, exécutez les commandes suivantes :

```bash
docker build -f Dockerfile.prod -t conteneurisation-symfony-prod .
docker run -p 80:80 conteneurisation-symfony-prod
```


## Arrêt et suppression des containers

Pour arrêter et supprimer les conteneurs Docker, utilisez la commande suivante :

```sh
docker-compose down
```
