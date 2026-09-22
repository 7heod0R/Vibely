# core

Ce dossier contient les composants techniques communs au fonctionnement de l'application.

## `Router.php`
Lit `?route=...`, identifie le contrôleur et la méthode à appeler, puis lance cette méthode.

Exemple : `?route=playlist/liste` devient `PlaylistController::liste()`.
