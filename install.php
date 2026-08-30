<?php
/**
 * install.php — One-shot Production Installer & Verifier
 * DT Brand's & Jai Hanuman Tex
 *
 * Run from CLI:  php install.php
 * Or via the browser:  /install.php  (then DELETE this file when done)
 *
 * Steps performed (idempotent — safe to re-run):
 *   1. Verify PHP version and required extensions.
 *   2. Apply every SQL file under database/migrations/ in order.
 *   3. Seed the minimum real dataset (categories, admin user, coupons, banners).
 *   4. Verify the database is reachable and the tables now exist.
 *   5. Print a deploy-readiness summary.
 */

declare(strict_types=1);

$basePath = __DIR__;

function out(string $line): void
{
    echo $line . PHP_EOL;
}

function ok(string $msg): void
{
    out("  ✓ " . $msg);
}

function warn(string $msg): void
{
    out("  ! " . $msg);
}

function fail(string $msg): void
{
    out("  ✗ " . $msg);
}

out("===============================================================");
out(" DT BRAND'S & JAI HANUMAN TEX — INSTALLER");
out("===============================================================");

// ─── 1. Environment checks ─────────────────────────────────────────────
out("[1/5] Verifying PHP runtime…");

if (version_compare(PHP_VERSION, '8.1.0', '<')) {
    fail("PHP 8.1 or newer required (this server has " . PHP_VERSION . ").");
    exit(1);
}
ok("PHP " . PHP_VERSION);

foreach (['pdo', 'pdo_mysql', 'mbstring', 'json', 'openssl', 'curl', 'gd', 'intl'] as $ext) {
    if (extension_loaded($ext)) {
        ok("Extension: $ext");
    } else {
        warn("Extension $ext is not loaded. Some features will degrade.");
    }
}

// ─── 2. Configuration check ────────────────────────────────────────────
out("");
out("[2/5] Reading configuration…");

if (!file_exists($basePath . '/.env')) {
    warn(".env not found. Falling back to environment variables and src/Database.php defaults.");
} else {
    $envLines = file($basePath . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
            continue;
        }
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $v = trim($v, "\"' \t");
        if (getenv($k) === false || getenv($k) === '') {
            putenv("$k=$v");
            $_ENV[$k] = $v;
        }
    }
    ok(".env loaded");
}

require_once $basePath . '/src/Database.php';

use DTBrand\Database;

// ─── 3. Database connection ────────────────────────────────────────────
out("");
out("[3/5] Connecting to MySQL…");

$pdo = Database::getConnection();
if ($pdo === null) {
    fail("Cannot reach the database. Check DB_HOST/DB_PORT/DB_NAME/DB_USER/DB_PASS in .env.");
    out("       Last PDO error was: " . error_get_last()['message'] ?? 'unknown');
    exit(2);
}
ok("Connected to " . getenv('DB_NAME') . " as " . getenv('DB_USER'));

if (Database::isMockMode()) {
    fail("Database fell back to mock mode — credentials were rejected. Fix .env and retry.");
    exit(2);
}

// ─── 4. Apply migrations ───────────────────────────────────────────────
out("");
out("[4/5] Applying migrations…");

$migrationsDir = $basePath . '/database/migrations';
$files = glob($migrationsDir . '/*.sql');
sort($files);
if (empty($files)) {
    warn("No SQL files found under $migrationsDir.");
}

$ensure = $pdo->prepare(
    "CREATE TABLE IF NOT EXISTS `migrations` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `filename` VARCHAR(255) NOT NULL UNIQUE,
        `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
);
$ensure->execute();

$applied = $pdo->query('SELECT filename FROM migrations')->fetchAll(PDO::FETCH_COLUMN);
foreach ($files as $file) {
    $name = basename($file);
    if (in_array($name, $applied, true)) {
        ok("$name (already applied)");
        continue;
    }
    out("  → applying $name…");
    $sql = file_get_contents($file);
    if ($sql === false) {
        fail("Could not read $name");
        exit(3);
    }
    try {
        $pdo->exec($sql);
        $pdo->prepare('INSERT INTO migrations (filename) VALUES (?)')->execute([$name]);
        ok("$name applied");
    } catch (Throwable $e) {
        fail("$name failed: " . $e->getMessage());
        exit(3);
    }
}

// ─── 5. Seed minimum-real data ─────────────────────────────────────────
out("");
out("[5/5] Seeding minimum-real data…");

require_once $basePath . '/database/seeders/DatabaseSeeder.php';
use Database\Seeders\DatabaseSeeder;

$seedReport = DatabaseSeeder::run();
ok(json_encode($seedReport, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// ─── 6. Verify tables ──────────────────────────────────────────────────
out("");
out("Verification:");
$expected = ['categories', 'products', 'customers', 'users', 'orders', 'order_items',
             'cart_items', 'wishlist_items', 'coupons', 'banners', 'addresses',
             'product_media', 'product_colors', 'product_sizes', 'product_variants',
             'reviews', 'subcategories', 'notifications', 'audit_logs', 'webhook_events'];
foreach ($expected as $table) {
    try {
        $count = (int) $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        ok("Table $table — $count rows");
    } catch (Throwable $e) {
        warn("Table $table missing — re-run migrations.");
    }
}

out("");
out("===============================================================");
out(" Install complete. Next steps:");
out("   1. Set up your Hostinger cron jobs (see README.md).");
out("   2. Point your domain at /public_html and reload.");
out("   3. Sign in at /admin/login.php (admin@jaihanumantex.in).");
out("   4. DELETE install.php from the server when done.");
out("===============================================================");