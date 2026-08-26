<?php
/**
 * db_health.php — Enterprise Database Health & Auto-Migrator
 * DT Brand's & Jai Hanuman Tex
 */
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$key = $_GET['key'] ?? '';
if ($key !== 'Gautam9006MasterInstall' && $key !== 'dt_audit_key_2026') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

$diag = [];
$candidates = [
    ['host' => 'localhost', 'user' => 'u602484543_demodt121', 'pass' => 'Gautam@9006', 'db' => 'u602484543_demodt121'],
    ['host' => '127.0.0.1', 'user' => 'u602484543_demodt121', 'pass' => 'Gautam@9006', 'db' => 'u602484543_demodt121'],
    ['host' => '147.93.99.134', 'user' => 'u602484543_demodt121', 'pass' => 'Gautam@9006', 'db' => 'u602484543_demodt121'],
];

$workingPdo = null;
$workingConfig = null;

foreach ($candidates as $cand) {
    try {
        $dsn = "mysql:host={$cand['host']};port=3306;dbname={$cand['db']};charset=utf8mb4";
        $p = new PDO($dsn, $cand['user'], $cand['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $workingPdo = $p;
        $workingConfig = $cand;
        $diag[$cand['host']] = 'CONNECTED_SUCCESSFULLY';
        break;
    } catch (PDOException $e) {
        $diag[$cand['host']] = $e->getMessage();
    }
}

if ($workingPdo === null) {
    echo json_encode([
        'success' => false,
        'diagnostics' => $diag,
        'message' => 'Could not connect to MySQL database via any candidate.'
    ], JSON_PRETTY_PRINT);
    exit;
}

$pdo = $workingPdo;

$action = $_GET['action'] ?? 'status';

try {
    if ($action === 'status') {
        $tables = [];
        $stmt = $pdo->query("SHOW TABLES");
        $tableList = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $counts = [];
        foreach ($tableList as $tbl) {
            try {
                $cStmt = $pdo->query("SELECT COUNT(*) FROM `{$tbl}`");
                $counts[$tbl] = (int)$cStmt->fetchColumn();
            } catch (\Exception $e) {
                $counts[$tbl] = 'Error: ' . $e->getMessage();
            }
        }

        echo json_encode([
            'success' => true,
            'tables' => $tableList,
            'row_counts' => $counts,
            'database' => 'u602484543_demodt121'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'test_catalog') {
        $dbConn = Database::getConnection();
        $isMock = Database::isMockMode();
        $allProds = ProductCatalog::getAll();
        $allCats = ProductCatalog::getCategoriesWithDetails();

        echo json_encode([
            'success' => true,
            'db_connected' => ($dbConn !== null),
            'is_mock_mode' => $isMock,
            'all_products_count' => count($allProds),
            'all_categories_count' => count($allCats),
            'first_product' => $allProds[0] ?? null
        ], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'migrate') {
        $applied = [];
        $files = ['schema.sql', 'seeders.sql'];

        foreach ($files as $file) {
            $path = __DIR__ . '/../database/' . $file;
            if (file_exists($path)) {
                $sql = file_get_contents($path);
                // Multi-query execution
                $pdo->exec($sql);
                $applied[] = $file;
            }
        }

        // Also ensure admin table has the master admin credentials
        $hash = password_hash('Gautam@9006', PASSWORD_BCRYPT);
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `admins` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(150) NOT NULL DEFAULT 'Gautam Sethi',
                `email` VARCHAR(191) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `role` VARCHAR(50) NOT NULL DEFAULT 'super_admin',
                `status` VARCHAR(20) NOT NULL DEFAULT 'active',
                `last_login` DATETIME NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $check = $pdo->prepare("SELECT id FROM admins WHERE email = 'admin@dtbrand.in'");
        $check->execute();
        if (!$check->fetch()) {
            $ins = $pdo->prepare("INSERT INTO admins (name, email, password, role, status) VALUES ('Gautam Sethi', 'admin@dtbrand.in', ?, 'super_admin', 'active')");
            $ins->execute([$hash]);
        } else {
            $up = $pdo->prepare("UPDATE admins SET password = ?, status = 'active' WHERE email = 'admin@dtbrand.in'");
            $up->execute([$hash]);
        }

        // Count products and categories
        $prodCount = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $catCount = (int)$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();

        echo json_encode([
            'success' => true,
            'message' => 'Schema & Seeders successfully executed!',
            'applied_files' => $applied,
            'products_count' => $prodCount,
            'categories_count' => $catCount
        ], JSON_PRETTY_PRINT);
        exit;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
}
