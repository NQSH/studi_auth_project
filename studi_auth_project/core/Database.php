<?php

use MongoDB\Driver\Exception\Exception as MongoDBException;

class Database
{
    private static $PDOconnection;
    private static $MongoDBconnection;

    public static function getPDOConnection(): PDO
    {
        if (!self::$PDOconnection) {
            try {
                self::$PDOconnection = new PDO(DB_DSN, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                log_db_error($e);
                die('Erreur de connexion à la base de données MySQL.');
            }
        }
        return self::$PDOconnection;
    }

    private static function getMongoDBConnection(): MongoDB\Client
    {
        if (!self::$MongoDBconnection) {
            try {
                self::$MongoDBconnection = new MongoDB\Client(BLOG_DB_DSN);
            } catch (MongoDBException $e) {
                log_db_error($e);
                die('Erreur de connexion à la base de données MongoDB.');
            }
        }
        return self::$MongoDBconnection;
    }

    public static function getMongoDBCollection(string $collectionName): MongoDB\Collection
    {
        return self::getMongoDBConnection()->selectCollection(BLOG_DB_NAME, $collectionName);
    }
}
