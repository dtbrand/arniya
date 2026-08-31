<?php
/**
 * db_sync.php — Enterprise Database Synchronization & Migration Engine
 * DT Brand's & Jai Hanuman Tex — Live Hostinger Production
 */
header('Content-Type: application/json; charset=utf-8');

$key = $_GET['key'] ?? ($_POST['key'] ?? '');
if ($key !== 'Gautam9006MasterInstall' && $key !== 'dt_audit_key_2026') {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Forbidden: Invalid authorization key'], JSON_PRETTY_PRINT);
    exit;
}

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_NAME') ?: 'u602484543_demodt121';
$username = getenv('DB_USER') ?: 'u602484543_demodt121';
$password = getenv('DB_PASS') ?: 'Gautam@9006';

$pdo = null;
$connectErrors = [];

$hosts = ['localhost', '127.0.0.1', '147.93.99.134'];
foreach ($hosts as $h) {
    try {
        $dsn = "mysql:host={$h};port={$port};dbname={$dbName};charset=utf8mb4";
        $p = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);
        $pdo = $p;
        break;
    } catch (PDOException $e) {
        $connectErrors[$h] = $e->getMessage();
    }
}

if ($pdo === null) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to connect to MySQL database',
        'errors' => $connectErrors
    ], JSON_PRETTY_PRINT);
    exit;
}

// 1. Create _migrations table if not exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `_migrations` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `migration` VARCHAR(255) NOT NULL UNIQUE,
        `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
} catch (Exception $e) {}

$applied = [];
try {
    $applied = $pdo->query("SELECT `migration` FROM `_migrations`")->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {}

$results = [];

// 2. Run master SQL if present
$masterSql = __DIR__ . '/../database/arniya_master_production.sql';
if (file_exists($masterSql) && !in_array('arniya_master_production.sql', $applied, true)) {
    $sql = file_get_contents($masterSql);
    try {
        $pdo->exec($sql);
        $stmt = $pdo->prepare("INSERT IGNORE INTO `_migrations` (`migration`) VALUES (?)");
        $stmt->execute(['arniya_master_production.sql']);
        $results[] = ['file' => 'arniya_master_production.sql', 'status' => 'EXECUTED_SUCCESSFULLY'];
    } catch (Exception $e) {
        $results[] = ['file' => 'arniya_master_production.sql', 'status' => 'ERROR', 'error' => $e->getMessage()];
    }
}

// 3. Run all migrations in sequential order
$migrationsDir = __DIR__ . '/../database/migrations';
if (is_dir($migrationsDir)) {
    $files = scandir($migrationsDir);
    sort($files);
    foreach ($files as $f) {
        if (pathinfo($f, PATHINFO_EXTENSION) === 'sql') {
            if (in_array($f, $applied, true)) {
                $results[] = ['file' => $f, 'status' => 'ALREADY_APPLIED'];
                continue;
            }

            $sqlPath = $migrationsDir . '/' . $f;
            $sqlContent = file_get_contents($sqlPath);
            try {
                $pdo->exec($sqlContent);
                $stmt = $pdo->prepare("INSERT IGNORE INTO `_migrations` (`migration`) VALUES (?)");
                $stmt->execute([$f]);
                $results[] = ['file' => $f, 'status' => 'EXECUTED_SUCCESSFULLY'];
            } catch (Exception $e) {
                $results[] = ['file' => $f, 'status' => 'ERROR', 'error' => $e->getMessage()];
            }
        }
    }
}

// 4. Fetch table counts and database statistics
$tables = [];
$tableStats = [];
try {
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $t) {
        try {
            $cnt = (int)$pdo->query("SELECT COUNT(*) FROM `{$t}`")->fetchColumn();
            $tableStats[$t] = $cnt;
        } catch (Exception $ex) {
            $tableStats[$t] = -1;
        }
    }
} catch (Exception $ex) {}

echo json_encode([
    'success' => true,
    'database' => $dbName,
    'host' => $host,
    'total_tables' => count($tables),
    'table_counts' => $tableStats,
    'migrations_executed' => $results,
    'timestamp' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT);
