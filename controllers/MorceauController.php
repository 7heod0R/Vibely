<?php
require_once __DIR__ . '/../models/Morceau.php';
require_once __DIR__ . '/../models/Mood.php';
require_once __DIR__ . '/../models/Artiste.php';

class MorceauController
{
    private Morceau $morceauModel; 
    private Mood $moodModel; 
    private Artiste $artisteModel;
    public function __construct() { 
        $this->morceauModel = new Morceau(); 
        $this->moodModel = new Mood(); 
        $this->artisteModel = new Artiste(); 
    }
    private function requireAdmin(): void
    {
        if (empty($_SESSION['utilisateur']['id']) || ($_SESSION['utilisateur']['role'] ?? '') !== 'administrateur') {
            header('Location: index.php?route=utilisateur/connexion'); 
            exit;
        }
    }
    private function durationToSeconds(string $value): int
    {
        $parts = explode(':', trim($value));
        if (count($parts) === 2 && ctype_digit($parts[0]) && ctype_digit($parts[1])) 
            return ((int)$parts[0] * 60) + (int)$parts[1];
        return max(1, (int)$value);
    }
    public function admin(): void
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ((array)($_POST['morceaux'] ?? []) as $id => $donnees) {
                $id=(int)$id; 
                if ($id<=0 || !is_array($donnees)) continue;
                $titre=trim((string)($donnees['titre']??'')); 
                $duree=$this->durationToSeconds((string)($donnees['duree']??'0'));
                $moodIds=is_array($donnees['mood_id']??null)?$donnees['mood_id']:[];
                if ($titre!=='' && $this->morceauModel->findById($id)) { 
                    $this->morceauModel->update($id,$titre,$duree); 
                    $this->morceauModel->setMoods($id,$moodIds); }
            }
            header('Location: index.php?route=morceau/admin&ok=1'); exit;
        }
        $morceaux=$this->morceauModel->findAllWithMoods(); $moods=$this->moodModel->findAll(); $artistes=$this->artisteModel->findAll();
        require __DIR__.'/../views/layout/header.php'; require __DIR__.'/../views/morceau/admin.php'; require __DIR__.'/../views/layout/footer.php';
    }
    public function creer(): void
    {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titre=trim((string)($_POST['titre']??'')); 
            $artisteId=(int)($_POST['artiste_id']??0); 
            $duree=$this->durationToSeconds((string)($_POST['duree']??'0')); 
            $fichier=trim((string)($_POST['fichier_audio']??'')); 
            $moodIds=is_array($_POST['mood_id']??null)?$_POST['mood_id']:[];
            if ($titre!=='' && $artisteId>0 && $fichier!=='') { 
                $id=$this->morceauModel->create($titre,$duree,$artisteId,$fichier); 
                $this->morceauModel->setMoods($id,$moodIds); }
            header('Location: index.php?route=morceau/admin&ok=1'); exit;
        }
        $moods=$this->moodModel->findAll(); $artistes=$this->artisteModel->findAll();
        require __DIR__.'/../views/layout/header.php'; require __DIR__.'/../views/morceau/creer.php'; require __DIR__.'/../views/layout/footer.php';
    }
}
