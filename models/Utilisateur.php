<?php
require_once __DIR__ . '/Model.php';
class Utilisateur extends Model
{
    public function create(string $nom, string $email, string $motDePasse): int
    {
        $this->execute('INSERT INTO utilisateur (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, :role)', [
            'nom' => $nom, 'email' => $email, 'mot_de_passe' => password_hash($motDePasse, PASSWORD_DEFAULT), 'role' => 'utilisateur'
        ]);
        return (int) $this->db->lastInsertId();
    }
    public function findByEmail(string $email): ?array { return $this->fetchOne('SELECT * FROM utilisateur WHERE email = :email', ['email' => $email]); 
                                                       }
    public function findById(int $id): ?array { return $this->fetchOne('SELECT id, nom, email, role, date_inscription FROM utilisateur WHERE id = :id', ['id' => $id]); 
                                              }
}
