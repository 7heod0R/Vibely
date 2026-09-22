# models

Les modèles représentent les données et contiennent les requêtes SQL.

- `Model.php` : classe abstraite commune et méthodes PDO génériques.
- `Artiste.php` : accès aux artistes.
- `Mood.php` : accès aux moods.
- `Morceau.php` : recherche, création, modification et gestion des moods des morceaux.
- `Playlist.php` : gestion des playlists et des associations playlist/morceau et playlist/mood.
- `Utilisateur.php` : création et recherche des utilisateurs.

Tous les modèles héritent de `Model` et utilisent PDO.
