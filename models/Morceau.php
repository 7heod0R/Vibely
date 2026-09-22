<?php

require_once __DIR__ . '/Model.php';

class Morceau extends Model
{
    public function findAll(string $search = '', ?int $moodId = null): array
    {
        $sql = 'SELECT m.*, a.nom AS artiste_nom FROM morceau m JOIN artiste a ON a.id = m.artiste_id';
        $conditions = [];
        $params = [];

        if ($search !== '') {
            $conditions[] = 'm.titre LIKE :search_title';
            $params['search_title'] = $search . '%';
        }
        if ($moodId !== null) {
            $conditions[] = 'EXISTS (SELECT 1 FROM morceau_mood mm WHERE mm.morceau_id = m.id AND mm.mood_id = :mood)';
            $params['mood'] = $moodId;
        }
        if ($conditions) $sql .= ' WHERE ' . implode(' AND ', $conditions);
        $sql .= ' ORDER BY m.date_ajout DESC, m.titre';
        return $this->fetchAll($sql, $params);
    }

    public function getMoods(int $morceauId): array
    {
        return $this->fetchAll(
            'SELECT mo.* FROM morceau_mood mm JOIN mood mo ON mo.id = mm.mood_id WHERE mm.morceau_id = :id ORDER BY mo.nom',
            ['id' => $morceauId]
        );
    }

    public function findById(int $id): ?array
    {
        return $this->fetchOne(
            'SELECT m.*, a.nom AS artiste_nom FROM morceau m JOIN artiste a ON a.id = m.artiste_id WHERE m.id = :id',
            ['id' => $id]
        );
    }

    public function create(string $titre, int $duree, int $artisteId, string $fichierAudio): int
    {
        $this->execute(
            'INSERT INTO morceau (titre, duree, artiste_id, fichier_audio) VALUES (:titre, :duree, :artiste, :fichier_audio)',
            ['titre' => $titre, 'duree' => $duree, 'artiste' => $artisteId, 'fichier_audio' => $fichierAudio]
        );
        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, string $titre, int $duree): bool
    {
        return $this->execute(
            'UPDATE morceau SET titre = :titre, duree = :duree WHERE id = :id',
            ['titre' => $titre, 'duree' => $duree, 'id' => $id]
        );
    }

    public function findFeatured(int $limit = 6): array
    {
        $limit = max(1, min($limit, 20));
        return $this->fetchAll("SELECT m.*, a.nom AS artiste_nom FROM morceau m JOIN artiste a ON a.id = m.artiste_id ORDER BY m.date_ajout DESC LIMIT {$limit}");
    }

    public function findAllWithMoods(): array
    {
        $morceaux = $this->fetchAll('SELECT m.*, a.nom AS artiste_nom FROM morceau m JOIN artiste a ON a.id = m.artiste_id ORDER BY m.titre');
        if (!$morceaux) return $morceaux;

        $lignes = $this->fetchAll('SELECT mm.morceau_id, mo.id, mo.nom FROM morceau_mood mm JOIN mood mo ON mo.id = mm.mood_id');
        $parMorceau = [];
        foreach ($lignes as $ligne) {
            $parMorceau[(int) $ligne['morceau_id']][] = [
                'id' => (int) $ligne['id'],
                'nom' => $ligne['nom'],
            ];
        }
        foreach ($morceaux as &$morceau) {
            $morceau['moods'] = $parMorceau[(int) $morceau['id']] ?? [];
        }
        unset($morceau);
        return $morceaux;
    }

    public function setMoods(int $morceauId, array $moodIds): void
    {
        $this->execute('DELETE FROM morceau_mood WHERE morceau_id = :id', ['id' => $morceauId]);
        foreach (array_unique(array_map('intval', $moodIds)) as $moodId) {
            if ($moodId > 0) {
                $this->execute(
                    'INSERT IGNORE INTO morceau_mood (morceau_id, mood_id) VALUES (:morceau, :mood)',
                    ['morceau' => $morceauId, 'mood' => $moodId]
                );
            }
        }
    }
}
