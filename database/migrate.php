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

    public function runMigrations(bool $runAll = true): array {
        $pdo = $this->getPDO();
        if ($pdo === null) {
            return ['status' => 'error', 'message' => 'Cannot connect to MySQL database'];
        }

        // Create migrations tracking table if not exists
        try {
            $pdo->exec("CREATE TABLE IF NOT EXISTS `_migrations` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `migration` VARCHAR(255) NOT NULL UNIQUE,
                `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        } catch (\PDOException $e) {
            // ignore if creation fails
        }

        $applied = [];
        try {
            $applied = $pdo->query("SELECT `migration` FROM `_migrations`")->fetchAll(\PDO::FETCH_COLUMN);
        } catch (\PDOException $e) {
            $applied = [];
        }

        $results = [];

        // 1. Run master production SQL if available
        $masterSqlFile = __DIR__ . '/arniya_master_production.sql';
        if (file_exists($masterSqlFile) && !in_array('arniya_master_production.sql', $applied, true)) {
            $sql = file_get_contents($masterSqlFile);
            try {
                $pdo->exec($sql);
                $stmt = $pdo->prepare("INSERT IGNORE INTO `_migrations` (`migration`) VALUES (?)");
                $stmt->execute(['arniya_master_production.sql']);
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

        // 2. Run all migrations in sequential order
        if ($runAll) {
            $migrations = $this->listMigrations();
            foreach ($migrations as $mFile) {
                if (in_array($mFile, $applied, true)) {
                    $results[] = [
                        'file' => $mFile,
                        'status' => 'ALREADY_APPLIED'
                    ];
                    continue;
                }

                $filePath = $this->migrationsPath . '/' . $mFile;
                if (pathinfo($mFile, PATHINFO_EXTENSION) === 'sql') {
                    $sql = file_get_contents($filePath);
                    try {
                        $pdo->exec($sql);
                        $stmt = $pdo->prepare("INSERT IGNORE INTO `_migrations` (`migration`) VALUES (?)");
                        $stmt->execute([$mFile]);
                        $results[] = [
                            'file' => $mFile,
                            'status' => 'EXECUTED_SUCCESSFULLY'
                        ];
                    } catch (\PDOException $e) {
                        $results[] = [
                            'file' => $mFile,
                            'status' => 'ERROR',
                            'error' => $e->getMessage()
                        ];
                    }
                }
            }
        }

        // 3. Fetch table statistics
        $tables = [];
        $tableCounts = [];
        try {
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            foreach ($tables as $t) {
                try {
                    $cStmt = $pdo->query("SELECT COUNT(*) FROM `{$t}`");
                    $tableCounts[$t] = (int)$cStmt->fetchColumn();
                } catch (\Exception $ex) {
                    $tableCounts[$t] = -1;
                }
            }
        } catch (\Exception $ex) {
            // ignore
        }

        return [
            'status' => 'success',
            'executed' => $results,
            'tables_count' => count($tables),
            'tables' => $tableCounts
        ];
    }
}

// Support execution via Web with Auth or CLI
$isCli = (php_sapi_name() === 'cli');
$authKey = $_GET['key'] ?? '';

if ($isCli || $authKey === 'Gautam9006MasterInstall' || $authKey === 'dt_audit_key_2026') {
    $runner = new DatabaseMigrationRunner();
    $action = $_GET['action'] ?? ($isCli ? 'cli' : 'status');

    if ($action === 'run' || $action === 'run_all' || $action === 'migrate') {
        header('Content-Type: application/json');
        echo json_encode($runner->runMigrations(true), JSON_PRETTY_PRINT);
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
} else {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Forbidden: Invalid key'], JSON_PRETTY_PRINT);
    exit;
}
