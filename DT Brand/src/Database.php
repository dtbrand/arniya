<?php

namespace DTBrand;

/**
 * Database — Enterprise PDO Database Connection & Query Engine
 * DT Brand's & Jai Hanuman Tex — Live Hostinger Production Engine
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

        $candidates = [
            $host,
            'localhost',
            '127.0.0.1',
        ];

        foreach (array_unique($candidates) as $h) {
            try {
                $dsn = "mysql:host={$h};port={$port};dbname={$dbName};charset=utf8mb4";
                $options = [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false
                ];
                self::$pdo = new \PDO($dsn, $username, $password, $options);
                self::$isMockMode = false;
                return self::$pdo;
            } catch (\PDOException $e) {
                // Try next candidate
            }
        }

        // Graceful fallback when MySQL server is offline / local development mode
        self::$isMockMode = true;
        self::$pdo = null;
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
     * Execute parameterized query safely (SELECT)
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

    /**
     * Execute parameterized write query (INSERT/UPDATE/DELETE)
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
     * Fetch single row safely
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
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (\PDOException $e) {
            error_log("[DATABASE ERROR] fetchOne Failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Begin database transaction
     */
    public static function beginTransaction(): bool
    {
        $pdo = self::getConnection();
        if ($pdo && !$pdo->inTransaction()) {
            return $pdo->beginTransaction();
        }
        return false;
    }

    /**
     * Commit database transaction
     */
    public static function commit(): bool
    {
        $pdo = self::getConnection();
        if ($pdo && $pdo->inTransaction()) {
            return $pdo->commit();
        }
        return false;
    }

    /**
     * Roll back database transaction
     */
    public static function rollBack(): bool
    {
        $pdo = self::getConnection();
        if ($pdo && $pdo->inTransaction()) {
            return $pdo->rollBack();
        }
        return false;
    }

    /**
     * Check if currently in transaction
     */
    public static function inTransaction(): bool
    {
        $pdo = self::getConnection();
        return $pdo ? $pdo->inTransaction() : false;
    }

    /**
     * Get last inserted ID
     */
    public static function lastInsertId(): string
    {
        $pdo = self::getConnection();
        return $pdo ? $pdo->lastInsertId() : '0';
    }
}

