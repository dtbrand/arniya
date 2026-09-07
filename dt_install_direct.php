<?php
/**
 * TEMPORARY ONE-TIME SCRIPT — DELETE IMMEDIATELY AFTER USE!
 * Direct installer that runs all migrations without session dependency.
 * Uses the credentials stored in .env
 */
$key = $_GET['key'] ?? '';
if ($key !== 'dtbrand2026install') { http_response_code(403); die('Forbidden'); }

// Load .env
$envFile = __DIR__ . '/.env';
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

$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbPort = getenv('DB_PORT') ?: '3306';
$dbName = getenv('DB_DATABASE') ?: (getenv('DB_NAME') ?: 'u602484543_demodt121');
$dbUser = getenv('DB_USERNAME') ?: (getenv('DB_USER') ?: 'u602484543_demodt121');
$dbPass = getenv('DB_PASSWORD') ?: (getenv('DB_PASS') ?: 'Gautam@9006');

$adminName  = getenv('SITE_NAME') ?: 'DT Brand Admin';
$adminEmail = getenv('ADMIN_EMAIL') ?: 'admin@dtbrand.in';
$adminPass  = 'Gautam@9006';
$siteName   = getenv('SITE_NAME') ?: "DT Brand's & Jai Hanuman Tex";
$siteUrl    = getenv('APP_URL') ?: 'https://harmitethnic.com';
$siteDomain = getenv('SITE_DOMAIN') ?: 'harmitethnic.com';
$whatsapp   = getenv('WHATSAPP_NUMBER') ?: '917046363528';
$upiVpa     = getenv('UPI_VPA') ?: '917046363528@okaxis';

echo "<pre style='background:#111;color:#0f0;padding:20px;font-size:13px;font-family:monospace;'>";
echo "=== DT BRAND DIRECT INSTALLER ===\n\n";

try {
    $pdo = new PDO(
        "mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4",
        $dbUser, $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => true]
    );
    echo "DB Connected: {$dbHost}/{$dbName}\n\n";

    // Create migrations tracking table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `_migrations` (`id` INT AUTO_INCREMENT PRIMARY KEY, `migration` VARCHAR(255) NOT NULL UNIQUE, `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "Migration table ready.\n\n";

    $applied = $pdo->query("SELECT `migration` FROM `_migrations`")->fetchAll(PDO::FETCH_COLUMN);

    $migrations = [
        '2026_08_23_000001_create_initial_schema.sql',
        '2026_08_24_000001_full_production_schema.sql',
        '2026_08_25_production_upgrade.sql',
        '2026_08_29_000001_reconcile_full_schema.sql',
        '2026_08_30_000001_add_brands_and_admin_tables.sql',
        '2026_08_31_000001_seed_ethnic_pillars_and_subcategories.sql',
        '2026_09_02_000001_create_payment_gateways_and_webhooks.sql',
        '2026_09_07_000001_add_missing_columns_indexes_and_fixes.sql',
    ];

    echo "--- RUNNING MIGRATIONS ---\n";
    foreach ($migrations as $migration) {
        if (in_array($migration, $applied)) {
            echo "  SKIP (already applied): {$migration}\n";
            continue;
        }
        $file = __DIR__ . '/database/migrations/' . $migration;
        if (!file_exists($file)) {
            echo "  WARN file not found: {$migration}\n";
            continue;
        }
        $sql = file_get_contents($file);
        $statements = array_filter(
            array_map('trim', preg_split('/;\s*$/m', $sql)),
            fn($s) => $s !== '' && !preg_match('/^\s*(--.*)?$/', $s)
        );
        $stmtCount = 0;
        $errors = [];
        foreach ($statements as $stmt) {
            if (trim($stmt) === '') continue;
            try {
                $pdo->exec($stmt);
                $stmtCount++;
            } catch (PDOException $e) {
                // Ignore duplicate column / table exists errors (idempotent)
                $errCode = $e->getCode();
                $errMsg  = $e->getMessage();
                if (strpos($errMsg, 'Duplicate column') !== false
                    || strpos($errMsg, 'already exists') !== false
                    || $errCode === '42S01' || $errCode === '42S21') {
                    // Safe to ignore
                } else {
                    $errors[] = substr(trim($stmt), 0, 80) . ' -> ' . $errMsg;
                }
            }
        }
        $pdo->prepare("INSERT IGNORE INTO `_migrations` (`migration`) VALUES (?)")->execute([$migration]);
        if (empty($errors)) {
            echo "  OK ({$stmtCount} stmts): {$migration}\n";
        } else {
            echo "  WARN ({$stmtCount} stmts, " . count($errors) . " errors): {$migration}\n";
            foreach (array_slice($errors, 0, 3) as $err) {
                echo "    ! {$err}\n";
            }
        }
    }

    // Create settings table
    echo "\n--- SEEDING SETTINGS ---\n";
    $hasKeyCol = $pdo->query("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='settings' AND COLUMN_NAME='key'")->fetchColumn();
    if ($hasKeyCol) {
        $pdo->exec("DROP TABLE IF EXISTS `settings`");
        echo "  Dropped bad settings table (had 'key' column)\n";
    }
    $pdo->exec("CREATE TABLE IF NOT EXISTS `settings` (`id` INT AUTO_INCREMENT PRIMARY KEY, `key_name` VARCHAR(100) NOT NULL UNIQUE, `value` TEXT NULL, `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    $settings = [
        'site_name'        => $siteName,
        'site_tagline'     => 'Premium Ethnic Wear — Wholesale & Retail',
        'site_domain'      => $siteDomain,
        'site_url'         => $siteUrl,
        'whatsapp_number'  => $whatsapp,
        'upi_vpa'          => $upiVpa,
        'timezone'         => 'Asia/Kolkata',
        'currency'         => 'INR',
        'maintenance_mode' => '0',
        'installed_at'     => date('Y-m-d H:i:s'),
        'install_version'  => '2.0.0',
    ];
    foreach ($settings as $k => $v) {
        $pdo->prepare("INSERT INTO `settings` (`key_name`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)")->execute([$k, $v]);
    }
    echo "  " . count($settings) . " settings seeded OK\n";

    // Seed admin user
    echo "\n--- SEEDING ADMIN USER ---\n";
    $hash = password_hash($adminPass, PASSWORD_BCRYPT);
    $pdo->prepare("INSERT INTO `users` (`name`, `email`, `password_hash`, `role`, `status`, `created_at`) VALUES (?, ?, ?, 'super_admin', 'active', NOW()) ON DUPLICATE KEY UPDATE `password_hash` = VALUES(`password_hash`), `role` = 'super_admin', `status` = 'active'")->execute(['DT Brand Admin', $adminEmail, $hash]);
    echo "  Admin: {$adminEmail} | Pass: {$adminPass}\n";

    // Write .installed
    file_put_contents(__DIR__ . '/.installed', json_encode([
        'installed_at' => date('c'),
        'version'      => '2.0.0',
        'domain'       => $siteDomain,
        'admin_email'  => $adminEmail,
    ], JSON_PRETTY_PRINT));
    echo "\n.installed written OK\n";

    echo "\n=== INSTALLATION COMPLETE! ===\n\n";
    echo "Admin Login: https://harmitethnic.com/admin/login/\n";
    echo "Email: {$adminEmail}\n";
    echo "Password: {$adminPass}\n\n";
    echo "DELETE THIS FILE (dt_install_direct.php) FROM SERVER!\n";

} catch (Throwable $e) {
    echo "\nFATAL ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}

echo "</pre>";
