CREATE DATABASE IF NOT EXISTS vibely CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vibely;

CREATE TABLE IF NOT EXISTS utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('utilisateur','administrateur') DEFAULT 'utilisateur',
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS artiste (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS morceau (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    duree INT NOT NULL,
    artiste_id INT NOT NULL,
    fichier_audio VARCHAR(255) NOT NULL,
    date_ajout DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_morceau_artiste FOREIGN KEY (artiste_id) REFERENCES artiste(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS mood (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS morceau_mood (
    morceau_id INT NOT NULL,
    mood_id INT NOT NULL,
    PRIMARY KEY (morceau_id, mood_id),
    CONSTRAINT fk_mm_morceau FOREIGN KEY (morceau_id) REFERENCES morceau(id) ON DELETE CASCADE,
    CONSTRAINT fk_mm_mood FOREIGN KEY (mood_id) REFERENCES mood(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS playlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    utilisateur_id INT NOT NULL,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_playlist_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS playlist_morceau (
    playlist_id INT NOT NULL,
    morceau_id INT NOT NULL,
    PRIMARY KEY (playlist_id, morceau_id),
    CONSTRAINT fk_pm_playlist FOREIGN KEY (playlist_id) REFERENCES playlist(id) ON DELETE CASCADE,
    CONSTRAINT fk_pm_morceau FOREIGN KEY (morceau_id) REFERENCES morceau(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS playlist_mood (
    playlist_id INT NOT NULL,
    mood_id INT NOT NULL,
    PRIMARY KEY (playlist_id, mood_id),
    CONSTRAINT fk_pmo_playlist FOREIGN KEY (playlist_id) REFERENCES playlist(id) ON DELETE CASCADE,
    CONSTRAINT fk_pmo_mood FOREIGN KEY (mood_id) REFERENCES mood(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT IGNORE INTO mood (id, nom) VALUES
(1, 'Chill'), (2, 'Energie'), (3, 'Melancolie'), (4, 'Focus'), (5, 'Soiree');

INSERT IGNORE INTO artiste (id, nom) VALUES
(1, 'Lumen Coast'), (2, 'Nova June'), (3, 'Milo North');

INSERT IGNORE INTO utilisateur (id, nom, email, mot_de_passe, role) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$12$hNhYkLNW2euSsTSZmPWyduRmw9FoqIuAQFy54/7GC7ECrBKQscQLq', 'administrateur');
