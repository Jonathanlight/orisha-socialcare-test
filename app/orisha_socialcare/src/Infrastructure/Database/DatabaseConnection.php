<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

abstract class DatabaseConnection
{
    protected static \PDO $pdo;

    /**
     * @param array{host: string, dbname: string, user: string, pass: string} $config
     */
    public static function init(array $config): void
    {
        try {
            self::$pdo = new \PDO(
                sprintf('mysql:host=%s;dbname=%s;charset=utf8', $config['host'], $config['dbname']),
                $config['user'],
                $config['pass'],
                [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
            );
        } catch (\PDOException $e) {
            exit('Connection failed: '.$e->getMessage());
        }
    }

    protected static function getConnection(): \PDO
    {
        if (!isset(self::$pdo)) {
            throw new \RuntimeException('PDO not initialized. Call DatabaseConnection::init() first.');
        }

        return self::$pdo;
    }
}
