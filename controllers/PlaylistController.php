<?php
require_once __DIR__ . '/../models/Playlist.php'; require_once __DIR__ . '/../models/Mood.php'; require_once __DIR__ . '/../models/Morceau.php';
class PlaylistController
{
    private Playlist $playlistModel; 
    private Mood $moodModel; 
    private Morceau $morceauModel;
    public function __construct(){ 
        $this->playlistModel=new Playlist(); 
        $this->moodModel=new Mood(); 
        $this->morceauModel=new Morceau(); 
    }
    
    private function requireAuth(): int { 
        if(empty($_SESSION['utilisateur']['id'])){ 
            header('Location: index.php?route=utilisateur/connexion'); 
            exit; 
        } 
        return (int)$_SESSION['utilisateur']['id'];
    }
    
    public function liste(): void { 
        $uid=$this->requireAuth(); 
        $playlists=$this->playlistModel->findAllByUser($uid); 
        require __DIR__.'/../views/layout/header.php'; 
        require __DIR__.'/../views/playlist/liste.php'; 
        require __DIR__.'/../views/layout/footer.php'; 
    }
    
    public function detail(): void { 
        $uid=$this->requireAuth(); 
        $id=(int)($_GET['id']??0); 
        $playlist=$this->playlistModel->findByIdForUser($id,$uid); 
        
        if(!$playlist){http_response_code(404);
                       echo 'Playlist introuvable.';
                       return;
                      } 
        
        $morceaux=$this->playlistModel->getMorceaux($id); 
        $moods=$this->playlistModel->getMoods($id); 
        $morceauxDisponibles=$this->morceauModel->findAll(); 
        require __DIR__.'/../views/layout/header.php'; 
        require __DIR__.'/../views/playlist/detail.php';
        require __DIR__.'/../views/layout/footer.php'; 
    }
    
    public function creer(): void { 
        if($_SERVER['REQUEST_METHOD']==='POST'){ 
            $uid=$this->requireAuth(); $nom=trim($_POST['nom']??''); 
            $moodId=(int)($_POST['mood_id']??0)?:null; 
            if($nom!==''){ 
                $this->playlistModel->create($uid,$nom,$moodId); 
                header('Location: index.php?route=playlist/liste');
                exit;
            } 
        } 
        $this->requireAuth(); 
        $moods=$this->moodModel->findAll(); 
        require __DIR__.'/../views/layout/header.php'; 
        require __DIR__.'/../views/playlist/creer.php'; 
        require __DIR__.'/../views/layout/footer.php'; 
    }
    
    public function supprimer(): void { 
        $uid=$this->requireAuth(); 
        $this->playlistModel->delete((int)($_POST['id']??0),$uid); 
        header('Location: index.php?route=playlist/liste');exit; 
    }
    
    public function ajouterMorceau(): void { 
        $uid=$this->requireAuth(); 
        $pid=(int)($_POST['playlist_id']??0); 
        if($this->playlistModel->findByIdForUser($pid,$uid))$this->playlistModel->addMorceau($pid,(int)($_POST['morceau_id']??0)); 
        header('Location: index.php?route=playlist/detail&id='.$pid);
        exit; 
    }
    
    public function retirerMorceau(): void { 
        $uid=$this->requireAuth();
        $pid=(int)($_POST['playlist_id']??0); 
        if($this->playlistModel->findByIdForUser($pid,$uid))$this->playlistModel->removeMorceau($pid,(int)($_POST['morceau_id']??0)); 
        header('Location: index.php?route=playlist/detail&id='.$pid);exit; }
}
