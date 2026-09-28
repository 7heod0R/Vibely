<?php
require_once __DIR__ . '/Model.php';
class Playlist extends Model
{
    public function findAllByUser(int $userId): array
    {
        return $this->fetchAll('SELECT p.*, COUNT(pm.morceau_id) AS nombre_morceaux FROM playlist p LEFT JOIN playlist_morceau pm ON pm.playlist_id = p.id WHERE p.utilisateur_id = :user GROUP BY p.id ORDER BY p.date_creation DESC', ['user' => $userId]);
    }
    public function findByIdForUser(int $id, int $userId): ?array
    {
        return $this->fetchOne('SELECT p.*, u.nom AS proprietaire FROM playlist p JOIN utilisateur u ON u.id = p.utilisateur_id WHERE p.id = :id AND p.utilisateur_id = :user', ['id' => $id, 'user' => $userId]);
    }
    public function create(int $userId, string $nom, ?int $moodId): int
    {
        $this->execute('INSERT INTO playlist (nom, utilisateur_id) VALUES (:nom, :user)', ['nom' => $nom, 'user' => $userId]);
        $id = (int) $this->db->lastInsertId();
        if ($moodId) $this->execute('INSERT INTO playlist_mood (playlist_id, mood_id) VALUES (:playlist, :mood)', ['playlist' => $id, 'mood' => $moodId]);
        return $id;
    }
    public function delete(int $id, int $userId): bool { 
        return $this->execute('DELETE FROM playlist WHERE id = :id AND utilisateur_id = :user', ['id' => $id, 'user' => $userId]); }
    public function getMorceaux(int $id): array
    {
        return $this->fetchAll('SELECT m.*, a.nom AS artiste_nom FROM playlist_morceau pm JOIN morceau m ON m.id = pm.morceau_id JOIN artiste a ON a.id = m.artiste_id WHERE pm.playlist_id = :id ORDER BY m.titre', ['id' => $id]);
    }
    public function getMoods(int $id): array { 
        return $this->fetchAll('SELECT mo.* FROM playlist_mood pm JOIN mood mo ON mo.id = pm.mood_id WHERE pm.playlist_id = :id ORDER BY mo.nom', ['id' => $id]); 
    }
    public function addMorceau(int $playlistId, int $morceauId): bool { 
        return $this->execute('INSERT IGNORE INTO playlist_morceau (playlist_id, morceau_id) VALUES (:playlist, :morceau)', ['playlist' => $playlistId, 'morceau' => $morceauId]); 
    }
    public function removeMorceau(int $playlistId, int $morceauId): bool { 
        return $this->execute('DELETE FROM playlist_morceau WHERE playlist_id = :playlist AND morceau_id = :morceau', ['playlist' => $playlistId, 'morceau' => $morceauId]); 
    }
}
