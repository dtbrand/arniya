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

        $this->applyColumnUpgrades($pdo, $results);
        $this->ensureAdminUser($pdo, $results);

        return ['status' => 'success', 'executed' => $results];
    }

    /**
     * Seed the first administrator into the `users` table when it is empty. The
     * master schema intentionally ships no admin row, which would otherwise leave
     * the console unreachable. The password is hashed here on the server (PHP is
     * present at migration time) so no plaintext credential is ever stored. Runs
     * only while the table has zero rows, so re-running never overwrites a real
     * admin or their chosen password.
     */
    private function ensureAdminUser(\PDO $pdo, array &$results): void {
        try {
            $count = (int)$pdo->query("SELECT COUNT(*) FROM `users`")->fetchColumn();
            if ($count > 0) {
                $results[] = ['seed' => 'users.admin', 'status' => 'ALREADY_PRESENT'];
                return;
            }

            $email = strtolower(trim(getenv('ADMIN_EMAIL') ?: 'admin@dtbrand.in'));
            $pass  = getenv('ADMIN_PASSWORD') ?: 'Gautam@9006';
            $name  = getenv('ADMIN_NAME') ?: 'DT Brand Admin';
            $hash  = password_hash($pass, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("INSERT INTO `users` (`name`, `email`, `password_hash`, `role`, `status`, `created_at`) VALUES (?, ?, ?, 'super_admin', 'active', NOW())");
            $stmt->execute([$name, $email, $hash]);
            $results[] = ['seed' => 'users.admin', 'status' => 'ADMIN_CREATED', 'email' => $email];
        } catch (\PDOException $e) {
            $results[] = ['seed' => 'users.admin', 'status' => 'ERROR', 'error' => $e->getMessage()];
        }
    }

    /**
     * Idempotent, safe in-place column upgrades for databases that were created
     * before a column was added to the master schema. Each upgrade checks for the
     * column first and only ALTERs when it is missing, so re-running is always safe
     * and never disturbs existing data.
     */
    private function applyColumnUpgrades(\PDO $pdo, array &$results): void {
        $upgrades = [
            ['table' => 'orders', 'column' => 'shipping_address', 'definition' => 'TEXT DEFAULT NULL AFTER `courier_name`'],
        ];

        foreach ($upgrades as $up) {
            try {
                $chk = $pdo->prepare("SHOW COLUMNS FROM `{$up['table']}` LIKE ?");
                $chk->execute([$up['column']]);
                if ($chk->fetch(\PDO::FETCH_ASSOC)) {
                    $results[] = ['upgrade' => "{$up['table']}.{$up['column']}", 'status' => 'ALREADY_PRESENT'];
                    continue;
                }
                $pdo->exec("ALTER TABLE `{$up['table']}` ADD COLUMN `{$up['column']}` {$up['definition']}");
                $results[] = ['upgrade' => "{$up['table']}.{$up['column']}", 'status' => 'COLUMN_ADDED'];
            } catch (\PDOException $e) {
                $results[] = ['upgrade' => "{$up['table']}.{$up['column']}", 'status' => 'ERROR', 'error' => $e->getMessage()];
            }
        }
    }
}

// Support execution via CLI, or over the web for an administrator.
//
// The web gate used to be a single string literal held in this file:
//     if ($isCli || $authKey === 'Gautam9006MasterInstall')
// That literal is committed to the repository and travelled in the query string,
// so it was public to anyone with source access and logged in browser history,
// proxies and server access logs.
//
// Replacing it with an admin session alone would create a chicken-and-egg on a
// fresh install: a blank database has no administrator to sign in as, so the
// schema could never be created. So the web gate opens in exactly two cases:
//
//   1. A signed-in admin  — the normal case once the shop exists.
//   2. An empty database  — genuine first-install bootstrap. There is no data
//      to protect and no account to authenticate against yet. As soon as the
//      schema exists this window closes by itself.
//
// The migration itself is non-destructive (17 CREATE TABLE IF NOT EXISTS plus
// seeds with explicit ids), so a re-run cannot drop or duplicate live data.
$isCli = (php_sapi_name() === 'cli');

/** True only when the target database has no tables at all. */
function dt_migrate_is_blank_database(DatabaseMigrationRunner $runner): bool {
    try {
        $pdo = $runner->getPDO();
        if ($pdo === null) {
            return false; // cannot prove it is blank -> stay closed
        }
        $tables = $pdo->query("SHOW TABLES")->fetchAll(\PDO::FETCH_COLUMN);
        return count($tables) === 0;
    } catch (\Throwable $e) {
        return false;
    }
}

$runner = new DatabaseMigrationRunner();
$webAllowed = false;

if (!$isCli) {
    require_once __DIR__ . '/../api/_guard.php';
    $webAllowed = dt_api_is_admin() || dt_migrate_is_blank_database($runner);

    if (!$webAllowed) {
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'error'   => 'unauthorized',
            'message' => 'Admin sign-in required to run migrations. Please sign in at /admin/login.php, or run this file from the command line: php database/migrate.php'
        ], JSON_PRETTY_PRINT);
        exit;
    }
}

if ($isCli || $webAllowed) {
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
