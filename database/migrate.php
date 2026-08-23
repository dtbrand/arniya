<?php
/**
 * migrate.php — Database Migration Runner & Schema Installer
 * DT Brand's & Jai Hanuman Tex — Live Hostinger Production Engine
 */

class DatabaseMigrationRunner {
    private string $migrationsPath;
    private ?\PDO $pdo = null;

    public function __construct(string $migrationsPath = __DIR__ . '/migrations') {
        $this->migrationsPath = $migrationsPath;
    }

    public function getPDO(): ?\PDO {
        if ($this->pdo !== null) {
            return $this->pdo;
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
            $this->pdo = new \PDO($dsn, $username, $password, $options);
        } catch (\PDOException $e) {
            $this->pdo = null;
        }

        return $this->pdo;
    }

    public function listMigrations(): array {
        if (!is_dir($this->migrationsPath)) {
            return [];
        }
        $files = scandir($this->migrationsPath);
        $migrations = [];
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql' || pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $migrations[] = $file;
            }
        }
        sort($migrations);
        return $migrations;
    }

    public function status(): array {
        $all = $this->listMigrations();
        $report = [];
        foreach ($all as $m) {
            $report[] = [
                'migration' => $m,
                'status' => 'PENDING_OR_APPLIED',
                'file_path' => $this->migrationsPath . '/' . $m
            ];
        }
        return $report;
    }

    public function runMigrations(): array {
        $pdo = $this->getPDO();
        if ($pdo === null) {
            return ['status' => 'error', 'message' => 'Cannot connect to MySQL database'];
        }

        $results = [];
        $masterSqlFile = __DIR__ . '/arniya_master_production.sql';
        if (file_exists($masterSqlFile)) {
            $sql = file_get_contents($masterSqlFile);
            try {
                $pdo->exec($sql);
                $results[] = [
                    'file' => 'arniya_master_production.sql',
                    'status' => 'EXECUTED_SUCCESSFULLY'
                ];
            } catch (\PDOException $e) {
                $results[] = [
                    'file' => 'arniya_master_production.sql',
                    'status' => 'ERROR',
                    'error' => $e->getMessage()
                ];
            }
        }

        return ['status' => 'success', 'executed' => $results];
    }
}

// Support execution via Web with Auth or CLI
$isCli = (php_sapi_name() === 'cli');
$authKey = $_GET['key'] ?? '';

if ($isCli || $authKey === 'Gautam9006MasterInstall') {
    $runner = new DatabaseMigrationRunner();
    if (isset($_GET['action']) && $_GET['action'] === 'run') {
        header('Content-Type: application/json');
        echo json_encode($runner->runMigrations(), JSON_PRETTY_PRINT);
        exit;
    }

    if ($isCli) {
        echo "=== DT Brand's Database Migration Runner ===\n";
        $status = $runner->status();
        foreach ($status as $s) {
            echo " - [{$s['status']}] {$s['migration']}\n";
        }
        echo "Total migrations detected: " . count($status) . "\n";
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'ready', 'migrations' => $runner->status()], JSON_PRETTY_PRINT);
        exit;
    }
}
