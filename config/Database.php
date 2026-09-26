<?php

class Database
{
    private static ?PDO $connexion = null;

    public static function getConnection(): PDO
    {
        if (self::$connexion === null) {

            // Configuration de la connexion
            $host = getenv('VIBELY_DB_HOST') ?: '127.0.0.1';
            $port = getenv('VIBELY_DB_PORT') ?: '3306';
            $database = getenv('VIBELY_DB_NAME') ?: 'vibely';
            $user = getenv('VIBELY_DB_USER') ?: 'root';
            $password = getenv('VIBELY_DB_PASSWORD') ?: 'root';

            $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";

            try {
                self::$connexion = new PDO($dsn, $user, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                die('Erreur de connexion à la base Vibely : ' . $e->getMessage());
            }
        }

        return self::$connexion;
    }
}