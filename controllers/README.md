# controllers

Les contrôleurs reçoivent les requêtes utilisateur et coordonnent les modèles et les vues.

- `AccueilController.php` : accueil et recherche.
- `MorceauController.php` : catalogue et création de morceaux, réservé à l'administrateur.
- `PlaylistController.php` : playlists et contrôle de propriété.
- `UtilisateurController.php` : inscription, connexion et déconnexion.

Un contrôleur ne doit pas contenir le HTML complet ni centraliser les requêtes SQL.
