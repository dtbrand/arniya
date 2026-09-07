<?php
// TEMPORARY DEBUG — delete after use
$key = $_GET['key'] ?? '';
if ($key !== 'dtdebug2026') { die('Forbidden'); }

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<pre style='background:#111;color:#0f0;padding:20px;font-size:13px;'>";
echo "=== DT BRAND DEBUG REPORT ===\n\n";

// PHP Info
echo "PHP: " . PHP_VERSION . "\n";
echo "Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'unknown') . "\n\n";

// .env check
$envFile = __DIR__ . '/.env';
echo ".env file: " . ($envFile) . "\n";
echo ".env exists: " . (file_exists($envFile) ? 'YES (' . filesize($envFile) . ' bytes)' : 'NO') . "\n";
echo ".installed: " . (file_exists(__DIR__ . '/.installed') ? 'YES' : 'NO') . "\n\n";

// Load .env
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        if (strpos($line, '=') !== false) {
            [$k, $v] = explode('=', $line, 2);
            putenv(trim($k) . '=' . trim($v));
        }
    }
}

// DB Connection test
echo "--- DB CONNECTION ---\n";
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'u602484543_demodt121';
$user = getenv('DB_USER') ?: 'u602484543_demodt121';
$pass = getenv('DB_PASS') ?: 'Gautam@9006';
echo "Host: $host | Port: $port | DB: $db | User: $user\n";
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "DB CONNECTION: SUCCESS\n";
    // Tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables (" . count($tables) . "): " . implode(', ', $tables) . "\n\n";
    
    // Check _migrations
    echo "--- APPLIED MIGRATIONS ---\n";
    try {
        $migs = $pdo->query("SELECT migration, applied_at FROM _migrations ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($migs as $m) echo "  + {$m['migration']} @ {$m['applied_at']}\n";
    } catch (Exception $e) { echo "No _migrations table: " . $e->getMessage() . "\n"; }
    
    // Check settings
    echo "\n--- SETTINGS ---\n";
    try {
        $settings = $pdo->query("SELECT key_name, value FROM settings LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($settings as $s) echo "  {$s['key_name']} = {$s['value']}\n";
    } catch (Exception $e) { echo "settings error: " . $e->getMessage() . "\n"; }
    
    // Check users (admin)
    echo "\n--- ADMIN USERS ---\n";
    try {
        $users = $pdo->query("SELECT id, name, email, role, status FROM users LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $u) echo "  ID:{$u['id']} {$u['name']} ({$u['email']}) role={$u['role']} status={$u['status']}\n";
        if (empty($users)) echo "  NO USERS FOUND - need to run install!\n";
    } catch (Exception $e) { echo "users error: " . $e->getMessage() . "\n"; }

} catch (PDOException $e) {
    echo "DB CONNECTION FAILED: " . $e->getMessage() . "\n";
}

// File existence checks
echo "\n--- CRITICAL FILES ---\n";
$files = ['src/Database.php', 'src/Auth.php', 'src/ProductCatalog.php', 'src/OrderManager.php', 'src/CustomerManager.php', 'admin/index.php', 'admin/login.php', 'admin/includes/adminguard.php', 'includes/bootstrap.php'];
foreach ($files as $f) {
    $path = __DIR__ . '/' . $f;
    echo "  $f: " . (file_exists($path) ? 'OK (' . filesize($path) . 'b)' : 'MISSING!') . "\n";
}

// Admin index include test
echo "\n--- ADMIN INCLUDES TEST ---\n";
try {
    require_once __DIR__ . '/src/Database.php';
    echo "  src/Database.php: OK\n";
} catch (Throwable $e) { echo "  src/Database.php: ERROR - " . $e->getMessage() . "\n"; }
try {
    require_once __DIR__ . '/src/ProductCatalog.php';
    echo "  src/ProductCatalog.php: OK\n";
} catch (Throwable $e) { echo "  src/ProductCatalog.php: ERROR - " . $e->getMessage() . "\n"; }
try {
    require_once __DIR__ . '/src/CustomerManager.php';
    echo "  src/CustomerManager.php: OK\n";
} catch (Throwable $e) { echo "  src/CustomerManager.php: ERROR - " . $e->getMessage() . "\n"; }
try {
    require_once __DIR__ . '/src/OrderManager.php';
    echo "  src/OrderManager.php: OK\n";
} catch (Throwable $e) { echo "  src/OrderManager.php: ERROR - " . $e->getMessage() . "\n"; }

echo "\n=== DELETE THIS FILE AFTER DEBUGGING ===\n";
echo "</pre>";
