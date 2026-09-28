<?php
require_once __DIR__ . '/Model.php';
class Mood extends Model
{
    public function findAll(): array { 
        return $this->fetchAll('SELECT * FROM mood ORDER BY nom'); 
    }
    public function findById(int $id): ?array { 
        return $this->fetchOne('SELECT * FROM mood WHERE id = :id', ['id' => $id]); 
    }
}
