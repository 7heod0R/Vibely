<?php
require_once __DIR__ . '/../models/Utilisateur.php';
class UtilisateurController
{
    private Utilisateur $utilisateurModel;
    public function __construct(){ $this->utilisateurModel=new Utilisateur(); }
    public function connexion(): void
    {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $email=filter_var(trim($_POST['email']??''),FILTER_VALIDATE_EMAIL); $motDePasse=(string)($_POST['mot_de_passe']??''); $u=$email?$this->utilisateurModel->findByEmail($email):null;
            if($u && password_verify($motDePasse,$u['mot_de_passe'])) { session_regenerate_id(true); $_SESSION['utilisateur']=['id'=>(int)$u['id'],'nom'=>$u['nom'],'email'=>$u['email'],'role'=>$u['role']]; header('Location: index.php?route=accueil/index'); exit; }
            $erreur='Email ou mot de passe incorrect.';
        }
        require __DIR__.'/../views/layout/header.php'; require __DIR__.'/../views/utilisateur/connexion.php'; require __DIR__.'/../views/layout/footer.php';
    }
    public function inscription(): void
    {
        if($_SERVER['REQUEST_METHOD']==='POST'){ $nom=trim($_POST['nom']??''); $email=filter_var(trim($_POST['email']??''),FILTER_VALIDATE_EMAIL); $pass=(string)($_POST['mot_de_passe']??''); if($nom!==''&&$email&&strlen($pass)>=8&&!$this->utilisateurModel->findByEmail($email)){ $this->utilisateurModel->create($nom,$email,$pass); header('Location: index.php?route=utilisateur/connexion&inscription=ok'); exit; } $erreur='Vérifie tes informations. Le mot de passe doit contenir au moins 8 caractères.'; }
        require __DIR__.'/../views/layout/header.php'; require __DIR__.'/../views/utilisateur/inscription.php'; require __DIR__.'/../views/layout/footer.php';
    }
    public function deconnexion(): void { $_SESSION=[]; session_destroy(); header('Location: index.php?route=accueil/index'); exit; }
}
