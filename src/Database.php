<?php

namespace DTBrand;

/**
 * Database — Enterprise PDO Database Connection & Query Engine
 * DT Brand's & Jai Hanuman Tex — Live Hostinger Production Credentials
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

        $host = getenv('DB_HOST') ?: 'localhost';
        $port = getenv('DB_PORT') ?: '3306';
        $dbName = getenv('DB_NAME') ?: 'u602484543_demodt121';
        $username = getenv('DB_USER') ?: 'u602484543_demodt121';
        $password = getenv('DB_PASS') ?: 'Gautam@9006';

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
     * Execute parameterized query safely and return all rows
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
            return $stmt->fetchAll() ?: [];
        } catch (\PDOException $e) {
            error_log("[DATABASE ERROR] Query Failed: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Execute parameterized query and return single row or null
     */
    public static function fetchOne(string $sql, array $params = []): ?array
    {
        $pdo = self::getConnection();
        if ($pdo === null) {
            return null;
        }

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $row = $stmt->fetch();
            return is_array($row) ? $row : null;
        } catch (\PDOException $e) {
            error_log("[DATABASE ERROR] FetchOne Failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Execute insert/update/delete statement safely
     */
    public static function execute(string $sql, array $params = []): bool
    {
        $pdo = self::getConnection();
        if ($pdo === null) {
            return false;
        }

        try {
            $stmt = $pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (\PDOException $e) {
            error_log("[DATABASE ERROR] Execute Failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get ID of last inserted record
     */
    public static function lastInsertId(): string
    {
        $pdo = self::getConnection();
        return $pdo !== null ? $pdo->lastInsertId() : '0';
    }
}
