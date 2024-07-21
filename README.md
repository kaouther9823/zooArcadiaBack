# zooArcadiaBack
La partie backend du site zooArcadia.

## Configuration de l'environnement de travail

## Prérequis
- Windows 10 ou supérieur
- XAMPP : PHP, MySQL et Apache
- Composer
- MongoDB
- Symfony CLI
- Git

## Installation

#### XAMPP
- Télécharger le zip via ce lien : https://www.apachefriends.org/download.html
- Dézipper le fichier
- Lancer le script initialisation: setup_xampp.bat
- Démarrer vos services apache et mysql depuis le contrôle panel : xampp-control.exe
- Php est installé sous le dossier Chemin d'installation\xampp\php

#### Composer

- Télécharger le fichier d'install Composer-Setup.exe depuis https://getcomposer.org/download/
- Installer composer
- La variable PATH sera mis à jour automatiquement en rajoutant le repertoire d'insall dans le PATH windows ce qui va permettre de lancer la commande composer depuis n'importe quel répertoire
- vérifier si l'outil est bien installé en lançanat la commande : ```composer --version```
- Vous devez avoir un résultat qui ressemble à ça :
.. code-block:: bash ```
  C:\Windows>composer --version
Composer version 2.7.7 2024-06-10 22:11:12
PHP version 8.2.12 (C:\xampp\php\php.exe)
Run the "diagnose" command to get more detailed diagnostics output.```

#### MongoDB
- Télécharger le fichier d'installation : https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-windows/
- Exécuter le progamme d'install

### Symfony CLI
- installer scoop : https://scoop.sh/
- Utiliser scoop pour installer Symfony: ```scoop install symfony-cli```
- Vérifier l'installation avaec la commande ``` symfony -V```

### Git
- Télécharger Git depuis git-sm.com
- Installer git
- Configurer git en lançant les commandes suivantes : 
```git config --global user.name "Prenom Nom"```
```git config --global user.email "youremail@yourdomain.com"```

## initialisation
Ce projet a été initialisé avec symfony via la commande suivante :

```symfony new --webapp --dir zooArcadiaBack```

## Création utilisateur de base de données
- Ouvrir phpMyAdmin et exécuter le script sql :
```CREATE USER 'arcadia-zoo' IDENTIFIED BY 'xxxxxx';```


### Installer les dépendances requises
- ```composer require dep```

Ci-dessous les commandes pratiques Symfony

## Création de la database
```symfony console doctrine:database:create  ```
## Ajouter des entités
```symfony console make:entity```

## Générer les CRUD
``` symfony console make:crud```
## Générer des migrations
```symfony console make:migration```
## Exécuter les migrations
``` symfony console doctrine:migrations:migrate```
## Configurer CROS
- installer le bundle sensio/framework-extra-bundle
```composer require nelmio/cors-bundle ```
- Configurer le bundle : https://symfony.com/bundles/NelmioCorsBundle/current/index.html
## Lancer le serveur en local
```symfony serve```

## Arrêter le serveur en local
```symfony server:stop```

### Configuration de l'authentiifcation à l'aide des token JWT
- Installer le bundle lexik/jwt-authentication-bundle
```composer require lexik/jwt-authentication-bundle 3.1.0```
- - Configurer le bundle : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/3.x/Resources/doc/index.rst#installation
