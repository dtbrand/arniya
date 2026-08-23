<?php

namespace DTBrand;

/**
 * Database — Enterprise PDO Database Connection & Query Engine
 * DT Brand's & Jai Hanuman Tex
 */
class Database
{
    private static ?\PDO $pdo = null;
    private static bool $isMockMode = false;

    /**
     * Get or initialize PDO connection with fallback support
     */
    public static function getConnection(): ?\PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3306';
        $dbName = getenv('DB_NAME') ?: 'u602484543_arniya';
        $username = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASS') ?: '';

        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ];
            self::$pdo = new \PDO($dsn, $username, $password, $options);
            self::$isMockMode = false;
        } catch (\PDOException $e) {
            // Graceful fallback when MySQL server is offline / local development mode
            self::$isMockMode = true;
            self::$pdo = null;
        }

        return self::$pdo;
    }

    /**
     * Check if currently operating in high-fidelity offline fallback mode
     */
    public static function isMockMode(): bool
    {
        if (self::$pdo === null) {
            self::getConnection();
        }
        return self::$isMockMode;
    }

    /**
     * Execute parameterized query safely
     */
    public static function query(string $sql, array $params = []): array
    {
        $pdo = self::getConnection();
        if ($pdo === null) {
            return [];
        }

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            error_log("[DATABASE ERROR] Query Failed: " . $e->getMessage());
            return [];
        }
    }
}
