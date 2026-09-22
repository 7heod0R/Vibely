# config

Ce dossier contient la configuration technique de l'application.

## `Database.php`
Gère la connexion PDO vers MySQL.

- `Database::getConnection()` retourne une connexion unique.
- Les paramètres peuvent venir des variables `VIBELY_DB_*`.
- PDO est configuré pour lever les exceptions et utiliser des requêtes préparées natives.

Le dossier `config` ne contient pas la logique métier ni le HTML.
