<?php

/**
 * Classe Router
 * Routeur minimaliste : lit l'URL (via ?route=...) et appelle
 * le bon Contrôleur + la bonne méthode.
 *
 * Exemple d'URL : index.php?route=playlist/liste
 * -> appelle PlaylistController::liste()
 */
class Router
{
    public function dispatch(): void
    {
        $route = trim($_GET['route'] ?? 'accueil/index', '/');

        // Sépare "playlist/liste" en ["playlist", "liste"]
        [$nomController, $methode] = array_pad(explode('/', $route), 2, 'index');
        $nomController = preg_replace('/[^a-zA-Z0-9]/', '', $nomController);
        $methode = preg_replace('/[^a-zA-Z0-9]/', '', $methode);

        // Transforme "playlist" en "PlaylistController"
        $nomClasseController = ucfirst($nomController) . 'Controller';
        $cheminFichier = __DIR__ . '/../controllers/' . $nomClasseController . '.php';

        if (!file_exists($cheminFichier)) {
            http_response_code(404);
            echo "Page introuvable (contrôleur '$nomClasseController' inexistant).";
            return;
        }

        require_once $cheminFichier;

        if (!class_exists($nomClasseController)) {
            http_response_code(500);
            echo "Erreur : la classe $nomClasseController n'existe pas dans le fichier.";
            return;
        }

        $controller = new $nomClasseController();

        if (!method_exists($controller, $methode)) {
            http_response_code(404);
            echo "Méthode '$methode' introuvable dans $nomClasseController.";
            return;
        }

        // Appelle la méthode demandée (ex: liste(), detail(), etc.)
        $controller->$methode();
    }
}
