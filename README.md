# Vibely

Vibely est une application web musicale réalisée en **PHP orienté objet**, avec **MySQL**, **PDO**, **HTML/CSS** et un peu de **JavaScript**.

L'objectif du projet est de proposer un petit catalogue musical dans lequel un utilisateur peut rechercher des morceaux, filtrer par mood et créer ses propres playlists. Un compte administrateur permet de gérer le catalogue.

## Fonctionnalités

### Utilisateur
- inscription ;
- connexion / déconnexion ;
- session PHP ;
- accès à ses playlists ;
- création et suppression de playlists ;
- ajout et retrait de morceaux dans une playlist ;
- filtrage par mood ;
- recherche par préfixe du titre ;
- lecture d'un fichier audio depuis le lecteur intégré.

### Recherche
La recherche est volontairement basée sur le **début du titre** :

- `s` → titres commençant par `s` ;
- `sa` → titres commençant par `sa` ;
- `sof` → titres commençant par `sof`.

La requête est exécutée uniquement lorsque l'utilisateur valide le formulaire, soit avec **Entrée**, soit avec le bouton **Filtrer** sur la page Explorer. La recherche n'est donc pas envoyée à chaque frappe.

### Administrateur
Le catalogue est réservé au rôle `administrateur`.

Le compte fourni dans `database/schema.sql` est :

```text
Email : admin@gmail.com
Mot de passe : admin
```

Le mot de passe enregistré en base est un hash bcrypt. Il n'est jamais stocké en clair.

Le catalogue permet de modifier plusieurs morceaux dans **un seul formulaire** avec **un seul bouton Enregistrer**.

## Architecture

Le projet suit une architecture MVC simplifiée :

```text
Navigateur
   ↓
index.php
   ↓
Router
   ↓
Controller
   ↓
Model
   ↓
PDO / MySQL
   ↓
Model
   ↓
Controller
   ↓
View
   ↓
HTML envoyé au navigateur
```

### Rôle des couches

- **Router** : lit la route et appelle le bon contrôleur.
- **Controller** : reçoit la requête, valide les données, vérifie les droits et coordonne les modèles.
- **Model** : contient les requêtes SQL et l'accès aux données.
- **View** : affiche les données reçues du contrôleur.
- **Config** : contient la connexion PDO.
- **Core** : contient les composants techniques communs, ici le routeur.
- **Public** : contient le point d'entrée public, le CSS et le JavaScript.
- **Database** : contient le schéma SQL servant de référence pour la structure de la base.

## Arborescence

```text
Vibely-main/
├── config/
│   └── Database.php
├── controllers/
│   ├── AccueilController.php
│   ├── MorceauController.php
│   ├── PlaylistController.php
│   └── UtilisateurController.php
├── core/
│   └── Router.php
├── database/
│   └── schema.sql
├── models/
│   ├── Model.php
│   ├── Artiste.php
│   ├── Mood.php
│   ├── Morceau.php
│   ├── Playlist.php
│   └── Utilisateur.php
├── nbproject/
├── public/
│   ├── css/style.css
│   ├── js/app.js
│   └── index.php
├── views/
│   ├── layout/
│   │   ├── header.php
│   │   └── footer.php
│   ├── morceau/
│   │   ├── admin.php
│   │   └── creer.php
│   ├── playlist/
│   │   ├── liste.php
│   │   ├── detail.php
│   │   └── creer.php
│   ├── utilisateur/
│   │   ├── connexion.php
│   │   └── inscription.php
│   ├── accueil.php
│   └── explorer.php
├── DOCUMENTATION_ORAL.md
├── README.md
└── index.php
```

## Base de données

Le fichier `database/schema.sql` est la référence de la structure SQL.

Tables principales :

- `utilisateur`
- `artiste`
- `morceau`
- `mood`
- `morceau_mood`
- `playlist`
- `playlist_morceau`
- `playlist_mood`

Les relations plusieurs-à-plusieurs sont représentées par les tables de liaison.

## Installation avec MAMP

1. Placer le dossier du projet dans le dossier `htdocs` de MAMP.
2. Démarrer Apache et MySQL.
3. Importer `database/schema.sql` dans MySQL/phpMyAdmin.
4. Vérifier les paramètres de connexion dans `config/Database.php` ou avec les variables d'environnement `VIBELY_DB_*`.
5. Ouvrir le projet depuis le serveur Apache.

La configuration par défaut du projet utilise :

```text
Hôte : 127.0.0.1
Port : 3306
Base : vibely
Utilisateur : root
Mot de passe : root
```

## Sécurité

- requêtes préparées PDO ;
- `password_hash()` à l'inscription ;
- `password_verify()` à la connexion ;
- régénération de l'identifiant de session après connexion ;
- contrôle serveur du rôle administrateur ;
- contrôle serveur de la propriété des playlists ;
- `htmlspecialchars()` pour l'affichage des données dynamiques.

## Dossiers

Chaque dossier important possède également son propre `README.md` afin de pouvoir expliquer rapidement son rôle pendant la présentation.
