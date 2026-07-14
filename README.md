# Musicaly

Application web PHP suivant l'architecture MVC permettant de rechercher des artistes, albums et titres via l'API Spotify, de consulter leurs informations, et de laisser des avis (note + commentaire) sur les titres. Les utilisateurs peuvent créer un compte, se connecter, et consulter l'historique de leurs avis.

## Fonctionnalités

- Recherche d'artistes, albums et titres via l'API Spotify (Client Credentials Flow)
- Consultation des détails d'un artiste, d'un album ou d'un titre
- Inscription / connexion / déconnexion (session + cookie de restauration)
- Ajout d'avis (note et commentaire) sur un titre
- Historique de ses propres avis
- Affichage des avis des autres utilisateurs
- Affichage des derniers avis sur la page d'accueil

## Architecture

Le projet suit une architecture **MVC** (Modèle-Vue-Contrôleur) :

- `models/` : accès aux données (connexion PDO, requêtes SQL)
- `views/` : templates HTML/PHP affichés à l'utilisateur
- `controllers/` : logique applicative, fait le lien entre les modèles et les vues
- `index.php` : point d'entrée qui route les requêtes vers le bon contrôleur selon le paramètre `page`

## Stack technique

- PHP (sans framework, routage via `index.php?page=...`)
- MySQL / PDO
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) pour la gestion des variables d'environnement
- API Spotify (Web API)

## Prérequis

- PHP >= 8.0 avec l'extension `curl` et `pdo_mysql`
- Composer
- MySQL / MariaDB
- Des identifiants d'application Spotify (créés sur le [Spotify Developer Dashboard](https://developer.spotify.com/dashboard))

## Installation

1. Cloner le dépôt

   ```bash
   git clone <url-du-depot>
   ```

2. Installer les dépendances PHP

   ```bash
   composer install
   ```

3. Créer un fichier `.env` à la racine du projet avec vos identifiants Spotify :

   ```env
   SPOTIFY_CLIENT_ID = votre_client_id
   SPOTIFY_CLIENT_SECRET = votre_client_secret
   ```

4. Créer la base de données et importer le fichier `bdd_musicaly.sql` (via phpMyAdmin ou en ligne de commande) :

   ```bash
   mysql -u root -p < bdd_musicaly.sql
   ```

   Par défaut, la connexion à la base se fait avec l'utilisateur `root` sans mot de passe sur `localhost` (voir `models/dbconnexion.php`). Adaptez ces valeurs à votre environnement local si nécessaire.

5. Lancer un serveur PHP local

   ```bash
   php -S localhost:8000
   ```

   Puis ouvrir [http://localhost:8000](http://localhost:8000) dans votre navigateur.

## Structure du projet

```
├── assets/         # CSS, JS et images
├── controllers/     # Logique applicative et routage des actions
├── models/           # Connexion base de données et requêtes
├── views/            # Templates HTML/PHP
├── index.php         # Point d'entrée et routeur principal
└── bdd_musicaly.sql   # Dump de la base de données
```

## Remarques

- Le fichier `.env` n'est pas versionné (voir `.gitignore`) : chaque développeur doit créer le sien avec ses propres identifiants Spotify.
- Le dossier `vendor/` n'est pas versionné, il est régénéré via `composer install`.
