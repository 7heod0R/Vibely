<?php

require_once __DIR__ . '/../models/Morceau.php';
require_once __DIR__ . '/../models/Mood.php';

class AccueilController
{
    public function index(): void
    {
        $morceauModel = new Morceau();
        $moodModel = new Mood();
        $morceaux = $morceauModel->findFeatured();
        $moods = $moodModel->findAll();

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/accueil.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    public function explorer(): void
    {
        $morceauModel = new Morceau();
        $moodModel = new Mood();
        $recherche = trim($_GET['q'] ?? '');
        $moodId = isset($_GET['mood']) && $_GET['mood'] !== '' ? (int) $_GET['mood'] : null;
        $morceaux = $morceauModel->findAll($recherche, $moodId);
        $moods = $moodModel->findAll();

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/explorer.php';
        require __DIR__ . '/../views/layout/footer.php';
    }
}