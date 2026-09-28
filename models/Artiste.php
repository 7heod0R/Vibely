<?php
require_once __DIR__ . '/Model.php';
class Artiste extends Model
{
    public function findAll(): array { 
        return $this->fetchAll('SELECT * FROM artiste ORDER BY nom'); 
    }
    public function findById(int $id): ?array { 
        return $this->fetchOne('SELECT * FROM artiste WHERE id = :id', ['id' => $id]); 
    }
}
