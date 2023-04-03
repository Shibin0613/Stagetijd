<?php

namespace Controllers;

use PDO;
use PDOException;

class DB
{
    private static PDO $pdo;



    
    public static function connect()
    {
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "stagetijd";
        
        try {
            self::$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            $message = $error->getMessage();
        }
    }

    public static function select(string $query, array $params = []): array
    {
        $stmt = self::$pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert(string $query, array $params = []): int
    {
        $stmt = self::$pdo->prepare($query);
        $stmt->execute($params);
        return self::$pdo->lastInsertId();
    }

    public static function update(string $query, array $params = []): int
    {
        $stmt = self::$pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}





