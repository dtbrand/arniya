<?php
/**
 * install.php — Next-Level Production Installer
 * DT Brand's & Jai Hanuman Tex — One-Click Deployment System
 * 
 * Features:
 * - Server requirements validation
 * - Database auto-creation & migration runner
 * - Admin account creation with secure password
 * - Domain & site configuration
 * - All migrations + seed data execution
 * - Beautiful responsive UI with progress tracking
 * - Security hardened (CSRF, rate limiting, input validation)
 * - ZIP-ready for Hostinger deployment
 */

// ─── SECURITY HEADERS ───
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');

// ─── SESSION & CSRF ───
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true,
    ]);
}

function csrf_token(): string {
    if (empty($_SESSION['install_csrf'])) {
        $_SESSION['install_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['install_csrf'];
}

function csrf_validate(string $token): bool {
    return !empty($_SESSION['install_csrf']) && hash_equals($_SESSION['install_csrf'], $token);
}

function rate_limit(string $key, int $max = 10, int $window = 300): bool {
    $now = time();
    if (!isset($_SESSION['rate_limit'][$key])) {
        $_SESSION['rate_limit'][$key] = [];
    }
    $_SESSION['rate_limit'][$key] = array_filter($_SESSION['rate_limit'][$key], fn($t) => $now - $t < $window);
    if (count($_SESSION['rate_limit'][$key]) >= $max) return false;
    $_SESSION['rate_limit'][$key][] = $now;
    return true;
}

// ─── ALREADY INSTALLED GUARD ────────────────────────────────────────────────
$installedFile = __DIR__ . '/.installed';

// If installed and user tries to re-access installer → show locked page
if (file_exists($installedFile) && !isset($_GET['force'])) {
    $installedData = @json_decode(file_get_contents($installedFile), true) ?? [];
    ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Installed — DT Brand's</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Cinzel:wght@700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .card {
            background: #FAF5E8;
            border: 2px solid #D4AF37;
            border-radius: 24px;
            padding: clamp(32px, 5vw, 56px) clamp(24px, 4vw, 48px);
            max-width: 500px;
            width: 95%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .icon {
            width: 80px; height: 80px;
            background: linear-gradient(135deg, #B8860B, #D4AF37);
            border-radius: 50%; margin: 0 auto 24px;
            display: flex; align-items: center; justify-content: center;
        }
        h1 { font-family: 'Cinzel', serif; font-size: 1.8rem; color: #181512; font-weight: 800; margin-bottom: 12px; }
        p { color: #64748B; font-size: 0.95rem; line-height: 1.6; margin-bottom: 8px; }
        .meta { background: #fff; border: 1px solid #D4AF37; border-radius: 12px; padding: 16px; margin: 20px 0; text-align: left; }
        .meta-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #F0E8D0; font-size: 0.85rem; color: #334155; }
        .meta-row:last-child { border-bottom: none; }
        .meta-row strong { color: #8A681F; }
        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border-radius: 12px; font-weight: 700; font-size: 0.95rem; text-decoration: none; cursor: pointer; border: none; margin: 6px; transition: all 0.2s; }
        .btn-gold { background: linear-gradient(135deg, #B8860B, #D4AF37, #E6CA65); color: #111827; border: 1px solid #8A681F; }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(184,134,11,0.4); }
        .btn-dark { background: linear-gradient(135deg, #181512, #2A241E); color: #FAF5E8; border: 1px solid #8A681F; }
        .btn-dark:hover { transform: translateY(-2px); border-color: #D4AF37; }
        .warning { background: #FEF3C7; border: 1px solid #B45309; border-radius: 10px; padding: 12px 16px; font-size: 0.82rem; color: #92400E; margin-top: 16px; }
    </style>
</head>
<body>
<div class="card">
    <div class="icon">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            <polyline points="9 12 11 14 15 10"></polyline>
        </svg>
    </div>
    <h1>Already Installed</h1>
    <p>DT Brand's & Jai Hanuman Tex has already been installed and is live.</p>

    <?php if (!empty($installedData)): ?>
    <div class="meta">
        <?php if (!empty($installedData['domain'])): ?>
        <div class="meta-row"><span>Domain</span><strong><?= htmlspecialchars($installedData['domain']) ?></strong></div>
        <?php endif; ?>
        <?php if (!empty($installedData['version'])): ?>
        <div class="meta-row"><span>Version</span><strong>v<?= htmlspecialchars($installedData['version']) ?></strong></div>
        <?php endif; ?>
        <?php if (!empty($installedData['installed_at'])): ?>
        <div class="meta-row"><span>Installed On</span><strong><?= htmlspecialchars(date('d M Y, h:i A', strtotime($installedData['installed_at']))) ?></strong></div>
        <?php endif; ?>
        <?php if (!empty($installedData['admin_email'])): ?>
        <div class="meta-row"><span>Admin Email</span><strong><?= htmlspecialchars($installedData['admin_email']) ?></strong></div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div>
        <a href="/" class="btn btn-gold">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
            Go to Store
        </a>
        <a href="/admin/" class="btn btn-dark">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Admin Panel
        </a>
    </div>
    <div class="warning">
        ⚠️ <strong>Security:</strong> Please delete or rename <code>install.php</code> from your server.
        If you need to reinstall, <a href="install.php?force=1" style="color:#92400E; font-weight:700;">click here</a> (dangerous — will overwrite settings).
    </div>
</div>
</body>
</html><?php
    exit;
}
// ─────────────────────────────────────────────────────────────────────────────

// ─── INSTALL STATE ───
$step = max(1, min(5, (int)($_GET['step'] ?? $_POST['step'] ?? 1)));
$errors = [];
$success = false;
$completed = false;

// ONE-CLICK HOSTINGER AUTO-INSTALL (step=auto)
$isAutoInstall = isset($_GET['auto']) || isset($_POST['auto_install']);

// Auto-fill Hostinger production defaults
$hostingerDefaults = [
    'db_host'     => 'localhost',
    'db_port'     => '3306',
    'db_name'     => 'u602484543_demodt121',
    'db_user'     => 'u602484543_demodt121',
    'db_pass'     => 'Gautam@9006',
    'site_domain' => 'harmitethnic.com',
    'site_name'   => "DT Brand's — Harmit Ethnic",
    'site_tagline'=> 'Premium Ethnic Wear, Reseller & Wholesale Hub',
    'whatsapp'    => '917046363528',
    'upi_vpa'     => '917046363528@okaxis',
    'timezone'    => 'Asia/Kolkata',
    'currency'    => 'INR',
    'admin_name'  => 'DT Brand Admin',
    'admin_email' => 'admin@harmitethnic.com',
];

// ─── STEP HANDLERS ───

// STEP 1: Requirements Check
$requirements = [
    'php_version' => [
        'label' => 'PHP Version ≥ 8.1',
        'check' => version_compare(PHP_VERSION, '8.1.0', '>='),
        'current' => PHP_VERSION,
    ],
    'pdo_mysql' => [
        'label' => 'PDO MySQL Extension',
        'check' => extension_loaded('pdo_mysql'),
    ],
    'mbstring' => [
        'label' => 'MBString Extension',
        'check' => extension_loaded('mbstring'),
    ],
    'json' => [
        'label' => 'JSON Extension',
        'check' => extension_loaded('json'),
    ],
    'openssl' => [
        'label' => 'OpenSSL Extension',
        'check' => extension_loaded('openssl'),
    ],
    'curl' => [
        'label' => 'cURL Extension',
        'check' => extension_loaded('curl'),
    ],
    'gd' => [
        'label' => 'GD/Image Extension',
        'check' => extension_loaded('gd'),
    ],
    'zip' => [
        'label' => 'ZipArchive Class',
        'check' => class_exists('ZipArchive'),
    ],
    'fileinfo' => [
        'label' => 'Fileinfo Extension',
        'check' => extension_loaded('fileinfo'),
    ],
    'session' => [
        'label' => 'Session Support',
        'check' => function_exists('session_start'),
    ],
    'write_permissions' => [
        'label' => 'Write Permissions (storage/, assets/images/uploads/)',
        'check' => is_writable(__DIR__) || @mkdir(__DIR__ . '/storage', 0755, true),
    ],
    'memory_limit' => [
        'label' => 'Memory Limit ≥ 256M',
        'check' => (int)ini_get('memory_limit') >= 256 * 1024 * 1024 || ini_get('memory_limit') === '-1',
        'current' => ini_get('memory_limit'),
    ],
    'max_execution_time' => [
        'label' => 'Max Execution Time ≥ 120s',
        'check' => (int)ini_get('max_execution_time') >= 120 || ini_get('max_execution_time') === 0,
        'current' => ini_get('max_execution_time') . 's',
    ],
    'post_max_size' => [
        'label' => 'Post Max Size ≥ 64M',
        'check' => (function() { $v = ini_get('post_max_size'); $n = (int)$v; $u = strtolower(substr($v, -1)); $m = ['k'=>1024,'m'=>1024*1024,'g'=>1024*1024*1024]; return $n * ($m[$u] ?? 1) >= 64*1024*1024; })(),
        'current' => ini_get('post_max_size'),
    ],
    'upload_max_filesize' => [
        'label' => 'Upload Max Filesize ≥ 32M',
        'check' => (function() { $v = ini_get('upload_max_filesize'); $n = (int)$v; $u = strtolower(substr($v, -1)); $m = ['k'=>1024,'m'=>1024*1024,'g'=>1024*1024*1024]; return $n * ($m[$u] ?? 1) >= 32*1024*1024; })(),
        'current' => ini_get('upload_max_filesize'),
    ],
];

$allPassed = true;
foreach ($requirements as $req) {
    if (!$req['check']) $allPassed = false;
}

// STEP 2: Database Configuration
if ($step === 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf'] ?? '')) {
        $errors[] = 'Invalid CSRF token. Please refresh and try again.';
    } elseif (!rate_limit('db_config', 5, 60)) {
        $errors[] = 'Too many attempts. Please wait a moment.';
    } else {
        $host = trim($_POST['db_host'] ?? 'localhost');
        $port = (int)($_POST['db_port'] ?? 3306);
        $name = trim($_POST['db_name'] ?? '');
        $user = trim($_POST['db_user'] ?? '');
        $pass = $_POST['db_pass'] ?? '';
        $createDb = !empty($_POST['create_db']);
        $dropExisting = !empty($_POST['drop_existing']);

        if (empty($name) || empty($user)) {
            $errors[] = 'Database name and username are required.';
        } else {
            try {
                // Test connection without database first
                $dsn = "mysql:host={$host};port={$port};charset=utf8mb4";
                $pdo = new PDO($dsn, $user, $pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);

                if ($createDb) {
                    // Create database if not exists
                    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                }

                if ($dropExisting) {
                    // Drop all tables in the database
                    $pdo->exec("USE `{$name}`");
                    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
                    foreach ($tables as $table) {
                        $pdo->exec("DROP TABLE IF EXISTS `{$table}`");
                    }
                    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
                }

                // Store config in session for next steps
                $_SESSION['install_db'] = [
                    'host' => $host,
                    'port' => $port,
                    'name' => $name,
                    'user' => $user,
                    'pass' => $pass,
                ];
                $_SESSION['install_step'] = 3;
                header('Location: install.php?step=3');
                exit;
            } catch (PDOException $e) {
                $errors[] = 'Database connection failed: ' . $e->getMessage();
            }
        }
    }
}

// STEP 3: Admin Account Creation
if ($step === 3 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf'] ?? '')) {
        $errors[] = 'Invalid CSRF token.';
    } elseif (!rate_limit('admin_create', 3, 300)) {
        $errors[] = 'Too many attempts. Please wait 5 minutes.';
    } else {
        $email = strtolower(trim($_POST['admin_email'] ?? ''));
        $username = trim($_POST['admin_username'] ?? '');
        $password = $_POST['admin_password'] ?? '';
        $confirm = $_POST['admin_confirm'] ?? '';
        $name = trim($_POST['admin_name'] ?? 'Super Admin');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Valid admin email is required.';
        }
        if (strlen($username) < 3) {
            $errors[] = 'Username must be at least 3 characters.';
        }
        if (strlen($password) < 12) {
            $errors[] = 'Password must be at least 12 characters.';
        }
        if ($password !== $confirm) {
            $errors[] = 'Passwords do not match.';
        }
        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            $_SESSION['install_admin'] = [
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password_hash' => $hash,
            ];
            $_SESSION['install_step'] = 4;
            header('Location: install.php?step=4');
            exit;
        }
    }
}

// STEP 4: Domain & Site Configuration
if ($step === 4 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf'] ?? '')) {
        $errors[] = 'Invalid CSRF token.';
    } else {
        $domain = strtolower(trim($_POST['site_domain'] ?? ''));
        $siteName = trim($_POST['site_name'] ?? 'DT Brand\'s & Jai Hanuman Tex');
        $siteTagline = trim($_POST['site_tagline'] ?? 'Premium Ethnic Wear & Wholesale Hub');
        $whatsapp = trim($_POST['whatsapp_number'] ?? '917046363528');
        $upiVpa = trim($_POST['upi_vpa'] ?? '917046363528@okaxis');
        $timezone = $_POST['timezone'] ?? 'Asia/Kolkata';
        $currency = $_POST['currency'] ?? 'INR';
        $maintenanceMode = !empty($_POST['maintenance_mode']);

        // Validate domain
        if (!preg_match('/^([a-z0-9-]+\.)+[a-z]{2,}$/i', $domain)) {
            $errors[] = 'Please enter a valid domain (e.g., jaihanumantex.in).';
        }
        if (empty($errors)) {
            $_SESSION['install_site'] = [
                'domain' => $domain,
                'name' => $siteName,
                'tagline' => $siteTagline,
                'whatsapp' => $whatsapp,
                'upi_vpa' => $upiVpa,
                'timezone' => $timezone,
                'currency' => $currency,
                'maintenance' => $maintenanceMode,
                'url' => 'https://' . $domain,
            ];
            $_SESSION['install_step'] = 5;
            header('Location: install.php?step=5');
            exit;
        }
    }
}

// STEP 5: Execute Installation
if ($step === 5 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validate($_POST['csrf'] ?? '')) {
        $errors[] = 'Invalid CSRF token.';
    } else {
        $db = $_SESSION['install_db'] ?? [];
        $admin = $_SESSION['install_admin'] ?? [];
        $site = $_SESSION['install_site'] ?? [];

        if (empty($db) || empty($admin) || empty($site)) {
            $errors[] = 'Installation session expired. Please start over.';
        } else {
            try {
                $pdo = new PDO(
                    "mysql:host={$db['host']};port={$db['port']};dbname={$db['name']};charset=utf8mb4",
                    $db['user'], $db['pass'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]
                );

                // ─── RUN ALL MIGRATIONS ───
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

                // Create migrations tracking table
                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS `_migrations` (
                        `id` INT AUTO_INCREMENT PRIMARY KEY,
                        `migration` VARCHAR(255) NOT NULL UNIQUE,
                        `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ");

                $applied = $pdo->query("SELECT `migration` FROM `_migrations`")->fetchAll(PDO::FETCH_COLUMN);

                foreach ($migrations as $migration) {
                    if (in_array($migration, $applied)) continue;
                    $file = __DIR__ . '/database/migrations/' . $migration;
                    if (file_exists($file)) {
                        $sql = file_get_contents($file);
                        $pdo->exec($sql);
                        $pdo->prepare("INSERT IGNORE INTO `_migrations` (`migration`) VALUES (?)")->execute([$migration]);
                    }
                }

                // ─── SEED ADMIN USER ───
                $pdo->prepare("
                    INSERT INTO `users` (`name`, `email`, `password_hash`, `role`, `status`, `created_at`)
                    VALUES (?, ?, ?, 'super_admin', 'active', NOW())
                    ON DUPLICATE KEY UPDATE `password_hash` = VALUES(`password_hash`), `role` = 'super_admin', `status` = 'active'
                ")->execute([$admin['name'], $admin['email'], $admin['password_hash']]);

                // ─── SEED SITE SETTINGS ───
                $settings = [
                    'site_name' => $site['name'],
                    'site_tagline' => $site['tagline'],
                    'site_domain' => $site['domain'],
                    'site_url' => $site['url'],
                    'whatsapp_number' => $site['whatsapp'],
                    'upi_vpa' => $site['upi_vpa'],
                    'timezone' => $site['timezone'],
                    'currency' => $site['currency'],
                    'maintenance_mode' => $site['maintenance'] ? '1' : '0',
                    'installed_at' => date('Y-m-d H:i:s'),
                    'install_version' => '2.0.0',
                ];

                // Create settings table if not exists
                $pdo->exec("
                    CREATE TABLE IF NOT EXISTS `settings` (
                        `key` VARCHAR(100) PRIMARY KEY,
                        `value` TEXT,
                        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                ");

                foreach ($settings as $k => $v) {
                    $pdo->prepare("INSERT INTO `settings` (`key`, `value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)")
                        ->execute([$k, $v]);
                }

                // ─── CREATE .env FILE ───
                $envContent = <<<ENV
# DT Brand's & Jai Hanuman Tex — Production Environment
APP_ENV=production
APP_DEBUG=false
APP_URL={$site['url']}

DB_HOST={$db['host']}
DB_PORT={$db['port']}
DB_DATABASE={$db['name']}
DB_USERNAME={$db['user']}
DB_PASSWORD={$db['pass']}

ADMIN_EMAIL={$admin['email']}
ADMIN_PASSWORD={$admin['password_hash']}

SITE_NAME={$site['name']}
SITE_DOMAIN={$site['domain']}
SITE_TAGLINE={$site['tagline']}
WHATSAPP_NUMBER={$site['whatsapp']}
UPI_VPA={$site['upi_vpa']}

TIMEZONE={$site['timezone']}
CURRENCY={$site['currency']}

RAZORPAY_KEY_ID=
RAZORPAY_KEY_SECRET=
RAZORPAY_WEBHOOK_SECRET=

CASHFREE_APP_ID=
CASHFREE_SECRET_KEY=
CASHFREE_WEBHOOK_SECRET=

MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS={$admin['email']}
MAIL_FROM_NAME={$site['name']}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
ENV;

                file_put_contents(__DIR__ . '/.env', $envContent);

                // ─── MARK INSTALLED ───
                file_put_contents($installedFile, json_encode([
                    'installed_at' => date('c'),
                    'version' => '2.0.0',
                    'domain' => $site['domain'],
                    'admin_email' => $admin['email'],
                ], JSON_PRETTY_PRINT));

                // Clean install session
                unset($_SESSION['install_db'], $_SESSION['install_admin'], $_SESSION['install_site'], $_SESSION['install_step']);

                $success = true;
                $completed = true;

            } catch (Throwable $e) {
                $errors[] = 'Installation failed: ' . $e->getMessage();
            }
        }
    }
}

// ─── RENDER ───
$steps = [
    1 => ['title' => 'Requirements', 'icon' => 'check-circle'],
    2 => ['title' => 'Database', 'icon' => 'database'],
    3 => ['title' => 'Admin Account', 'icon' => 'user-shield'],
    4 => ['title' => 'Site Config', 'icon' => 'globe'],
    5 => ['title' => 'Install', 'icon' => 'rocket'],
];

$stepLabels = ['Requirements Check', 'Database Setup', 'Admin Account', 'Site Configuration', 'Installation'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT Brand's — Production Installer</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #8A681F;
            --gold-bright: #C5A859;
            --gold-light: #D4AF37;
            --gold-pale: #FAF5E8;
            --gold-border: rgba(138,104,31,0.3);
            --dark: #181512;
            --dark-soft: #2A241E;
            --text: #1F2937;
            --text-muted: #64748B;
            --white: #FFFFFF;
            --success: #15803D;
            --success-bg: #DCFCE7;
            --error: #DC2626;
            --error-bg: #FEE2E2;
            --warning: #B45309;
            --warning-bg: #FEF3C7;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #FAF8F4 0%, #F1EDE4 50%, #E8E3D8 100%);
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
        }
        .install-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            max-width: 720px;
            width: 100%;
            margin: 0 auto;
            padding: clamp(20px, 4vw, 40px) clamp(16px, 3vw, 24px);
        }
        .install-header {
            text-align: center;
            margin-bottom: clamp(24px, 4vw, 40px);
            padding-top: clamp(16px, 3vw, 24px);
        }
        .install-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 16px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-bright) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(138,104,31,0.25);
        }
        .install-logo svg { width: 40px; height: 40px; stroke: #fff; }
        .install-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
        }
        .install-subtitle {
            font-size: clamp(0.9rem, 1.5vw, 1rem);
            color: var(--text-muted);
            font-weight: 500;
        }
        .progress-tracker {
            display: flex;
            justify-content: space-between;
            margin-bottom: clamp(24px, 4vw, 32px);
            position: relative;
        }
        .progress-tracker::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: var(--gold-pale);
            border-radius: 2px;
            z-index: 0;
        }
        .progress-tracker .progress-fill {
            position: absolute;
            top: 20px;
            left: 10%;
            height: 3px;
            background: linear-gradient(90deg, var(--gold) 0%, var(--gold-bright) 100%);
            border-radius: 2px;
            z-index: 1;
            transition: width 0.5s ease;
        }
        .step-node {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
        }
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--white);
            border: 3px solid var(--gold-border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }
        .step-node.active .step-circle {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-bright) 100%);
            border-color: var(--gold);
            color: var(--white);
            box-shadow: 0 4px 16px rgba(138,104,31,0.3);
        }
        .step-node.completed .step-circle {
            background: var(--success);
            border-color: var(--success);
            color: var(--white);
        }
        .step-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: center;
            max-width: 100px;
        }
        .step-node.active .step-label { color: var(--gold); font-weight: 700; }
        .step-node.completed .step-label { color: var(--success); }

        .card {
            background: var(--white);
            border: 1.5px solid var(--gold-border);
            border-radius: 16px;
            padding: clamp(20px, 3vw, 28px);
            box-shadow: 0 4px 24px rgba(138,104,31,0.08);
        }
        .card-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(1.1rem, 2vw, 1.3rem);
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }
        .card-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: clamp(16px, 2.5vw, 24px);
        }
        .req-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 12px;
        }
        .req-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            background: var(--gold-pale);
            border: 1px solid var(--gold-border);
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .req-item.pass { background: var(--success-bg); border-color: var(--success); }
        .req-item.fail { background: var(--error-bg); border-color: var(--error); }
        .req-icon {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .req-item.pass .req-icon { background: var(--success); color: #fff; }
        .req-item.fail .req-icon { background: var(--error); color: #fff; }
        .req-info { flex: 1; min-width: 0; }
        .req-label { font-weight: 600; font-size: 0.8rem; color: var(--text); }
        .req-value { font-size: 0.7rem; color: var(--text-muted); font-family: monospace; margin-top: 2px; }

        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--dark);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            padding: 12px 14px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--dark);
            background: var(--white);
            border: 1.5px solid var(--gold-border);
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212,175,55,0.15);
        }
        .form-input.error { border-color: var(--error); }
        .form-hint { font-size: 0.7rem; color: var(--text-muted); margin-top: 4px; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 24px;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-bright) 100%);
            color: var(--dark);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 4px 16px rgba(138,104,31,0.3);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: inset 0 1px 0 rgba(255,255,255,0.5), 0 6px 24px rgba(138,104,31,0.4); }
        .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
        .btn-secondary {
            background: var(--gold-pale);
            color: var(--gold);
            border: 1.5px solid var(--gold-border);
        }
        .btn-secondary:hover { background: #F5ECCE; border-color: var(--gold); }
        .btn-group { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 8px; }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .alert-error { background: var(--error-bg); color: var(--error); border: 1px solid var(--error); }
        .alert-success { background: var(--success-bg); color: var(--success); border: 1px solid var(--success); }
        .alert-warning { background: var(--warning-bg); color: var(--warning); border: 1px solid var(--warning); }

        .install-complete {
            text-align: center;
            padding: 20px 0;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--success) 0%, #16A34A 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 8px 24px rgba(21,128,61,0.3);
        }
        .next-steps {
            background: var(--gold-pale);
            border: 1px solid var(--gold-border);
            border-radius: 12px;
            padding: 20px;
            margin-top: 24px;
            text-align: left;
        }
        .next-steps h4 {
            font-family: 'Cinzel', serif;
            font-size: 1rem;
            color: var(--dark);
            margin-bottom: 12px;
        }
        .next-steps ul { list-style: none; }
        .next-steps li {
            padding: 8px 0;
            padding-left: 24px;
            position: relative;
            font-size: 0.85rem;
            color: var(--text);
        }
        .next-steps li::before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--success);
            font-weight: 700;
        }

        @media (max-width: 600px) {
            .progress-tracker::before { display: none; }
            .progress-tracker .progress-fill { display: none; }
            .step-label { font-size: 0.6rem; max-width: 80px; }
            .step-circle { width: 32px; height: 32px; font-size: 0.75rem; }
        }
    </style>
</head>
<body>
<div class="install-container">
    <header class="install-header">
        <div class="install-logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                <path d="M2 17l10 5 10-5"></path>
                <path d="M2 12l10 5 10-5"></path>
            </svg>
        </div>
        <h1 class="install-title">DT Brand's Installer</h1>
        <p class="install-subtitle">Next-Level Production Deployment Wizard</p>
    </header>

    <div class="progress-tracker" role="progressbar" aria-valuenow="<?= $step ?>" aria-valuemin="1" aria-valuemax="5">
        <div class="progress-fill" style="width: <?= (($step - 1) / 4) * 80 ?>%"></div>
        <?php foreach ($steps as $i => $s): ?>
            <div class="step-node <?= $i < $step ? 'completed' : ($i === $step ? 'active' : '') ?>">
                <div class="step-circle"><?= $i < $step ? '✓' : $i ?></div>
                <span class="step-label"><?= $s['title'] ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <main class="card">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error" role="alert">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <div>
                    <?php foreach ($errors as $e): ?>
                        <div><?= htmlspecialchars($e) ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success" role="alert">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <div>Installation completed successfully!</div>
            </div>
        <?php endif; ?>

        <?php if ($step === 1): ?>
            <!-- STEP 1: REQUIREMENTS -->
            <h2 class="card-title">Server Requirements Check</h2>
            <p class="card-subtitle">All requirements must pass before proceeding. Failed items must be resolved on your server.</p>

            <?php if ($allPassed): ?>
            <!-- ⚡ ONE-CLICK HOSTINGER INSTALL BANNER -->
            <div style="background: linear-gradient(135deg, #181512 0%, #2A241E 100%); border: 1.5px solid #D4AF37; border-radius: 16px; padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                <div style="display:flex; align-items:center; gap:14px;">
                    <div style="width:48px; height:48px; background:linear-gradient(135deg,#B8860B,#D4AF37); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-family:'Cinzel',serif; font-size:0.95rem; font-weight:800; color:#D4AF37; margin-bottom:4px;">⚡ One-Click Hostinger Install</div>
                        <div style="font-size:0.78rem; color:#94A3B8; line-height:1.4;">Auto-fill all credentials for <strong style="color:#E2E8F0;">harmitethnic.com</strong> — DB, Admin & Site Config pre-loaded.</div>
                    </div>
                </div>
                <a href="install.php?step=2&prefill=hostinger" style="display:inline-flex; align-items:center; gap:8px; padding:12px 22px; background:linear-gradient(135deg,#B8860B,#D4AF37,#E6CA65); color:#111827; font-weight:800; font-size:0.875rem; border-radius:10px; text-decoration:none; border:1px solid #8A681F; white-space:nowrap; box-shadow:0 4px 14px rgba(184,134,11,0.35); transition:all 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    Quick Install
                </a>
            </div>
            <?php endif; ?>

            <div class="req-grid">
                <?php foreach ($requirements as $key => $req): 
                    $passed = $req['check'];
                    $current = $req['current'] ?? '';
                ?>
                <div class="req-item <?= $passed ? 'pass' : 'fail' ?>">
                    <div class="req-icon">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <?php if ($passed): ?>
                                <polyline points="20 6 9 17 4 12"></polyline>
                            <?php else: ?>
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            <?php endif; ?>
                        </svg>
                    </div>
                    <div class="req-info">
                        <div class="req-label"><?= htmlspecialchars($req['label']) ?></div>
                        <?php if ($current): ?>
                            <div class="req-value">Current: <?= htmlspecialchars($current) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="btn-group">
                <?php if ($allPassed): ?>
                    <a href="install.php?step=2" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        <span>Proceed to Database Setup</span>
                    </a>
                <?php else: ?>
                    <button class="btn btn-primary" disabled>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        <span>Fix Requirements First</span>
                    </button>
                    <a href="install.php?step=1" class="btn btn-secondary">Re-check</a>
                <?php endif; ?>
            </div>

        <?php elseif ($step === 2): ?>
            <!-- STEP 2: DATABASE -->
            <h2 class="card-title">Database Configuration</h2>
            <p class="card-subtitle">Enter your MySQL credentials. The installer will create the database and run all migrations automatically.</p>
            
            <form method="POST" action="install.php?step=2">
                <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                <input type="hidden" name="step" value="2">
                
                <?php
                // Auto-fill Hostinger credentials if ?prefill=hostinger
                $prefill = isset($_GET['prefill']) && $_GET['prefill'] === 'hostinger';
                $def = $hostingerDefaults;
                ?>

                <?php if ($prefill): ?>
                <div style="background:#DCFCE7; border:1px solid #15803D; border-radius:10px; padding:12px 16px; margin-bottom:20px; display:flex; align-items:center; gap:10px; font-size:0.85rem; color:#15803D; font-weight:600;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    Hostinger production credentials auto-filled for <strong>harmitethnic.com</strong>
                </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="form-label" for="db_host">Database Host</label>
                    <input type="text" id="db_host" name="db_host" class="form-input" value="<?= htmlspecialchars($prefill ? $def['db_host'] : 'localhost') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="db_port">Port</label>
                    <input type="number" id="db_port" name="db_port" class="form-input" value="<?= $prefill ? $def['db_port'] : '3306' ?>" min="1" max="65535" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="db_name">Database Name</label>
                    <input type="text" id="db_name" name="db_name" class="form-input" value="<?= $prefill ? htmlspecialchars($def['db_name']) : '' ?>" placeholder="u602484543_demodt121" required>
                    <div class="form-hint">Will be created if it doesn't exist</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="db_user">Database Username</label>
                    <input type="text" id="db_user" name="db_user" class="form-input" value="<?= $prefill ? htmlspecialchars($def['db_user']) : '' ?>" placeholder="u602484543_demodt121" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="db_pass">Database Password</label>
                    <input type="<?= $prefill ? 'text' : 'password' ?>" id="db_pass" name="db_pass" class="form-input" value="<?= $prefill ? htmlspecialchars($def['db_pass']) : '' ?>" placeholder="Your DB Password">
                </div>
                
                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="create_db" value="1" checked style="accent-color:var(--gold); width:18px; height:18px;">
                        <span style="font-size:0.85rem; font-weight:600; color:var(--text);">Create database if not exists</span>
                    </label>
                </div>
                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="drop_existing" value="1" style="accent-color:var(--gold); width:18px; height:18px;">
                        <span style="font-size:0.85rem; font-weight:600; color:var(--warning);">Drop existing tables (clean install)</span>
                    </label>
                </div>
                
                <div class="btn-group">
                    <a href="install.php?step=1" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        <span>Test & Continue</span>
                    </button>
                </div>
            </form>

        <?php elseif ($step === 3): ?>
            <!-- STEP 3: ADMIN ACCOUNT -->
            <h2 class="card-title">Super Admin Account</h2>
            <p class="card-subtitle">Create the primary administrator account. This account has full access to the system.</p>
            
            <form method="POST" action="install.php?step=3">
                <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                <input type="hidden" name="step" value="3">
                
                <div class="form-group">
                    <label class="form-label" for="admin_name">Full Name</label>
                    <input type="text" id="admin_name" name="admin_name" class="form-input" value="Super Admin" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="admin_username">Username</label>
                    <input type="text" id="admin_username" name="admin_username" class="form-input" placeholder="admin" required minlength="3">
                </div>
                <div class="form-group">
                    <label class="form-label" for="admin_email">Email Address</label>
                    <input type="email" id="admin_email" name="admin_email" class="form-input" placeholder="admin@dtbrand.in" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="admin_password">Password (min 12 chars)</label>
                    <input type="password" id="admin_password" name="admin_password" class="form-input" required minlength="12" autocomplete="new-password">
                    <div class="form-hint">Use a strong, unique password with mixed case, numbers & symbols</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="admin_confirm">Confirm Password</label>
                    <input type="password" id="admin_confirm" name="admin_confirm" class="form-input" required minlength="12" autocomplete="new-password">
                </div>
                
                <div class="btn-group">
                    <a href="install.php?step=2" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        <span>Create Admin & Continue</span>
                    </button>
                </div>
            </form>

        <?php elseif ($step === 4): ?>
            <!-- STEP 4: SITE CONFIG -->
            <h2 class="card-title">Site Configuration</h2>
            <p class="card-subtitle">Configure your store domain, branding, and regional settings.</p>
            
            <form method="POST" action="install.php?step=4">
                <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                <input type="hidden" name="step" value="4">
                
                <div class="form-group">
                    <label class="form-label" for="site_domain">Domain Name <span style="color:var(--error);">*</span></label>
                    <input type="text" id="site_domain" name="site_domain" class="form-input" placeholder="jaihanumantex.in" required>
                    <div class="form-hint">Enter without http:// or www. (e.g., jaihanumantex.in)</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="site_name">Store Name</label>
                    <input type="text" id="site_name" name="site_name" class="form-input" value="DT Brand's & Jai Hanuman Tex" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="site_tagline">Tagline</label>
                    <input type="text" id="site_tagline" name="site_tagline" class="form-input" value="Premium Ethnic Wear & Wholesale Hub">
                </div>
                <div class="form-group">
                    <label class="form-label" for="whatsapp_number">WhatsApp Number</label>
                    <input type="text" id="whatsapp_number" name="whatsapp_number" class="form-input" value="917046363528" required>
                    <div class="form-hint">Full international format without + (e.g., 917046363528)</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="upi_vpa">UPI VPA (Default)</label>
                    <input type="text" id="upi_vpa" name="upi_vpa" class="form-input" value="917046363528@okaxis" required>
                    <div class="form-hint">Primary UPI ID for payments (e.g., 917046363528@okaxis)</div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="timezone">Timezone</label>
                    <select id="timezone" name="timezone" class="form-input" required>
                        <option value="Asia/Kolkata" selected>Asia/Kolkata (IST)</option>
                        <option value="Asia/Dubai">Asia/Dubai</option>
                        <option value="Asia/Singapore">Asia/Singapore</option>
                        <option value="UTC">UTC</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="currency">Default Currency</label>
                    <select id="currency" name="currency" class="form-input" required>
                        <option value="INR" selected>₹ INR (Indian Rupee)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                        <input type="checkbox" name="maintenance_mode" value="1" style="accent-color:var(--gold); width:18px; height:18px;">
                        <span style="font-size:0.85rem; font-weight:600; color:var(--text);">Enable maintenance mode after install</span>
                    </label>
                </div>
                
                <div class="btn-group">
                    <a href="install.php?step=3" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        <span>Save & Install</span>
                    </button>
                </div>
            </form>

        <?php elseif ($step === 5): ?>
            <!-- STEP 5: INSTALLATION -->
            <h2 class="card-title">Ready to Install</h2>
            <p class="card-subtitle">Review your configuration and launch the installation. This will run all migrations, create the admin account, and configure your site.</p>
            
            <?php if (empty($_SESSION['install_db']) || empty($_SESSION['install_admin']) || empty($_SESSION['install_site'])): ?>
                <div class="alert alert-warning">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <div>Installation session incomplete. Please <a href="install.php?step=1" style="color:var(--gold); font-weight:700;">start over</a>.</div>
                </div>
            <?php else: 
                $db = $_SESSION['install_db'];
                $admin = $_SESSION['install_admin'];
                $site = $_SESSION['install_site'];
            ?>
            <div style="background:var(--gold-pale); border:1px solid var(--gold-border); border-radius:12px; padding:16px; margin-bottom:20px; font-size:0.85rem;">
                <strong>Database:</strong> <?= htmlspecialchars($db['host']) ?>:<?= htmlspecialchars($db['port']) ?> / <?= htmlspecialchars($db['name']) ?><br>
                <strong>Admin:</strong> <?= htmlspecialchars($admin['name']) ?> (<?= htmlspecialchars($admin['email']) ?>)<br>
                <strong>Domain:</strong> https://<?= htmlspecialchars($site['domain']) ?>
            </div>
            
            <form method="POST" action="install.php?step=5">
                <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                <input type="hidden" name="step" value="5">
                
                <div class="btn-group" style="justify-content:center;">
                    <a href="install.php?step=4" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Review Config</span>
                    </a>
                    <button type="submit" class="btn btn-primary" style="padding:16px 32px; font-size:1rem;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Launch Installation</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="install-complete">
                    <div class="success-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <h2 style="font-family:'Cinzel',serif; font-size:clamp(1.5rem,3vw,2rem); font-weight:800; color:var(--dark); margin-bottom:12px;">Installation Complete!</h2>
                    <p style="font-size:1rem; color:var(--text-muted); margin-bottom:24px; max-width:500px; margin-left:auto; margin-right:auto;">DT Brand's & Jai Hanuman Tex has been successfully installed. Your store is ready to go live.</p>
                    
                    <div class="next-steps">
                        <h4>Next Steps</h4>
                        <ul>
                            <li>Remove or rename <code>install.php</code> for security</li>
                            <li>Login at <a href="https://<?= htmlspecialchars($site['domain']) ?>/admin/login/" target="_blank" style="color:var(--gold); font-weight:700;">https://<?= htmlspecialchars($site['domain']) ?>/admin/login/</a></li>
                            <li>Configure payment gateways (Razorpay, Cashfree) in Admin → Settings → Payment</li>
                            <li>Set up webhook URLs in Razorpay/Cashfree dashboards</li>
                            <li>Configure SSL certificate for HTTPS</li>
                            <li>Test all checkout flows (UPI, Razorpay, Cashfree, COD, WhatsApp)</li>
                        </ul>
                    </div>
                    
                    <div class="btn-group" style="justify-content:center; margin-top:24px;">
                        <a href="/admin/login/" class="btn btn-primary" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                            <span>Go to Admin Login</span>
                        </a>
                        <a href="/" class="btn btn-secondary" target="_blank">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                            <span>View Storefront</span>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <footer style="text-align:center; padding:20px; color:var(--text-muted); font-size:0.75rem;">
        DT Brand's & Jai Hanuman Tex — Next-Level Production Installer v2.0.0
    </footer>
</div>

<script>
    // Auto-focus first input
    document.addEventListener('DOMContentLoaded', () => {
        const firstInput = document.querySelector('.form-input:not([type="hidden"])');
        if (firstInput) firstInput.focus();
    });

    // Password strength indicator
    const pwdInput = document.getElementById('admin_password');
    if (pwdInput) {
        pwdInput.addEventListener('input', function() {
            const val = this.value;
            const strength = val.length >= 12 && /[A-Z]/.test(val) && /[a-z]/.test(val) && /[0-9]/.test(val) && /[^A-Za-z0-9]/.test(val);
            this.style.borderColor = val.length >= 12 ? (strength ? '#15803D' : '#B45309') : val.length > 0 ? '#DC2626' : '';
        });
    }

    // Smooth scroll on step change
    if (window.location.hash) {
        document.querySelector(window.location.hash)?.scrollIntoView({ behavior: 'smooth' });
    }
</script>
</body>
</html>