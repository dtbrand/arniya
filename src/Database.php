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
     * True once a connection has been attempted, successfully or not.
     *
     * Without this the null $pdo of a failed connection is indistinguishable
     * from "not connected yet", so every getConnection()/isMockMode()/query()
     * call re-dialled all three host candidates. A page that asks the catalogue
     * a dozen questions paid a dozen TCP timeouts before rendering.
     */
    private static bool $attempted = false;

    /**
     * Get or initialize PDO connection with fallback support
     */
    public static function getConnection(): ?\PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }
        if (self::$attempted) {
            // Already tried and failed — stay in mock mode, do not re-dial.
            return null;
        }
        self::$attempted = true;

        // Auto-load .env if not loaded yet
        if (!getenv('DB_DATABASE') && !getenv('DB_NAME')) {
            $envFile = dirname(__DIR__) . '/.env';
            if (!file_exists($envFile)) {
                $envFile = dirname(dirname(__DIR__)) . '/.env';
            }
            if (!file_exists($envFile) && isset($_SERVER['DOCUMENT_ROOT'])) {
                $envFile = rtrim((string)$_SERVER['DOCUMENT_ROOT'], '/\\') . '/.env';
            }
            if (file_exists($envFile)) {
                $lines = @file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
                foreach ($lines as $line) {
                    $line = trim($line);
                    if ($line === '' || $line[0] === '#') continue;
                    if (strpos($line, '=') !== false) {
                        [$k, $v] = explode('=', $line, 2);
                        $k = trim($k);
                        $v = trim($v, " \t\"'");
                        if (!getenv($k)) {
                            putenv("{$k}={$v}");
                            $_ENV[$k] = $v;
                            $_SERVER[$k] = $v;
                        }
                    }
                }
            }
        }

        $host     = getenv('DB_HOST')     ?: 'localhost';
        $port     = getenv('DB_PORT')     ?: '3306';
        $dbName   = getenv('DB_DATABASE') ?: (getenv('DB_NAME') ?: 'u602484543_demodt121');
        $username = getenv('DB_USERNAME') ?: (getenv('DB_USER') ?: 'u602484543_demodt121');
        $password = getenv('DB_PASSWORD') ?: (getenv('DB_PASS') ?: 'Gautam@9006');

        $candidates = [
            $host,
            'localhost',
            '127.0.0.1',
        ];

        // Ensure both the configured and master production db name are attempted
        $dbCandidates = array_unique([$dbName, 'u602484543_demodt121']);

        foreach ($dbCandidates as $dbTarget) {
            $userTarget = ($dbTarget === 'u602484543_demodt121') ? 'u602484543_demodt121' : $username;
            foreach (array_unique($candidates) as $h) {
                try {
                    $dsn = "mysql:host={$h};port={$port};dbname={$dbTarget};charset=utf8mb4";
                    $options = [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false
                    ];
                    self::$pdo = new \PDO($dsn, $userTarget, $password, $options);
                    self::$isMockMode = false;
                    return self::$pdo;
                } catch (\PDOException $e) {
                    // Try next candidate
                }
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
        if (self::$pdo === null && !self::$attempted) {
            self::getConnection();
        }
        return self::$isMockMode;
    }

    /**
     * Force the next call to re-dial. Only useful after credentials or the
     * server state have changed inside one request (migrations, health checks).
     */
    public static function reset(): void
    {
        self::$pdo = null;
        self::$isMockMode = false;
        self::$attempted = false;
    }

    /**
     * Override PDO connection (primarily for testing and in-memory mock fixtures).
     */
    public static function setPdo(?\PDO $pdo, bool $isMock = false): void
    {
        self::$pdo = $pdo;
        self::$isMockMode = $isMock;
        self::$attempted = true;
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

