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
        $this->repairLegacyData($pdo, $results);
        $this->ensureAdminUser($pdo, $results);

        return ['status' => 'success', 'executed' => $results];
    }

    /**
     * Idempotent data repairs for databases seeded before the asset paths were
     * corrected. Every seeded image pointed into /Frontend/Shop/Asset/images/, a
     * directory that does not exist in this docroot, so every product card, category
     * tile and banner on a live install rendered a broken image. A prefix REPLACE is
     * safe to re-run: once the prefix is gone the statement matches nothing.
     *
     * The two phantom filenames (category-sarees.png, hero-banner.png) were column
     * DEFAULTs rather than uploads, so they are cleared to NULL - "no image yet" -
     * instead of being pointed at some other product's photo.
     */
    private function repairLegacyData(\PDO $pdo, array &$results): void {
        $repairs = [
            'products.primary_image' =>
                "UPDATE `products` SET `primary_image` = REPLACE(`primary_image`, '/Frontend/Shop/Asset/images/', '/assets/images/')
                 WHERE `primary_image` LIKE '/Frontend/Shop/Asset/images/%'",
            'product_media.image_url' =>
                "UPDATE `product_media` SET `image_url` = REPLACE(`image_url`, '/Frontend/Shop/Asset/images/', '/assets/images/')
                 WHERE `image_url` LIKE '/Frontend/Shop/Asset/images/%'",
            'product_variants.image' =>
                "UPDATE `product_variants` SET `image` = REPLACE(`image`, '/Frontend/Shop/Asset/images/', '/assets/images/')
                 WHERE `image` LIKE '/Frontend/Shop/Asset/images/%'",
            'categories.image' =>
                "UPDATE `categories` SET `image` = NULL
                 WHERE `image` LIKE '%/category-sarees.png' OR `image` LIKE '/Frontend/Shop/Asset/images/%'",
            'categories.banner_image' =>
                "UPDATE `categories` SET `banner_image` = NULL
                 WHERE `banner_image` LIKE '%/hero-banner.png' OR `banner_image` LIKE '/Frontend/Shop/Asset/images/%'",
            'banners.image_url' =>
                "UPDATE `banners` SET `image_url` = REPLACE(`image_url`, '/Frontend/Shop/Asset/images/', '/assets/images/')
                 WHERE `image_url` LIKE '/Frontend/Shop/Asset/images/%'",
        ];

        foreach ($repairs as $label => $sql) {
            try {
                $n = $pdo->exec($sql);
                $results[] = ['repair' => $label, 'status' => $n > 0 ? 'ROWS_FIXED' : 'NOTHING_TO_FIX', 'rows' => (int)$n];
            } catch (\PDOException $e) {
                $results[] = ['repair' => $label, 'status' => 'ERROR', 'error' => $e->getMessage()];
            }
        }
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
        // Order matters. An `AFTER x` clause fails outright when x is missing, so
        // any column used as an AFTER target below is itself added earlier in this
        // list. `customers.gstin AFTER lifetime_spend` used to be the first entry
        // touching that table, which meant on a database built from the older
        // database/schema.sql - where lifetime_spend does not exist - the ALTER
        // threw, the upgrade was recorded as ERROR, and gstin was never added.
        $upgrades = [
            ['table' => 'orders', 'column' => 'shipping_address', 'definition' => 'TEXT DEFAULT NULL'],
            ['table' => 'products', 'column' => 'is_featured', 'definition' => 'TINYINT(1) DEFAULT 0 AFTER `status`'],

            // ── customers: the columns src/Auth.php depends on ──
            //
            // These are all present in the master schema, but CREATE TABLE IF NOT
            // EXISTS never alters a table that already exists, so a site whose
            // `customers` table was created by database/schema.sql is missing every
            // one of them. That is what made the create-account form answer with a
            // raw SQL message: registration writes password_hash, and "Forgot
            // password" writes reset_token/reset_expires.
            ['table' => 'customers', 'column' => 'password_hash', 'definition' => 'VARCHAR(255) DEFAULT NULL AFTER `email`'],
            ['table' => 'customers', 'column' => 'total_orders', 'definition' => 'INT DEFAULT 0'],
            ['table' => 'customers', 'column' => 'lifetime_spend', 'definition' => 'DECIMAL(12,2) DEFAULT 0.00'],
            ['table' => 'customers', 'column' => 'gstin', 'definition' => 'VARCHAR(20) DEFAULT NULL AFTER `lifetime_spend`'],
            ['table' => 'customers', 'column' => 'pan', 'definition' => 'VARCHAR(20) DEFAULT NULL AFTER `gstin`'],
            ['table' => 'customers', 'column' => 'commission_rate', 'definition' => 'DECIMAL(5,2) DEFAULT 0.00'],
            ['table' => 'customers', 'column' => 'reset_token', 'definition' => 'VARCHAR(100) DEFAULT NULL'],
            ['table' => 'customers', 'column' => 'reset_expires', 'definition' => 'TIMESTAMP NULL DEFAULT NULL'],
            ['table' => 'customers', 'column' => 'last_login', 'definition' => 'TIMESTAMP NULL DEFAULT NULL'],

            // The colour and size the shopper actually picked. Without these the
            // selection made in the quick view / product page was thrown away at
            // checkout, so an order for "Red, 6.3m" reached the warehouse as a
            // bare product title and had to be guessed.
            ['table' => 'order_items', 'column' => 'variant_color', 'definition' => 'VARCHAR(60) DEFAULT NULL AFTER `sku`'],
            ['table' => 'order_items', 'column' => 'variant_size', 'definition' => 'VARCHAR(60) DEFAULT NULL AFTER `variant_color`'],
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

        // `customers.password_hash` must accept NULL. The older schema.sql declared
        // it VARCHAR(255) NOT NULL with no default, and every row this project
        // creates without a password - a guest checkout, an admin import - is then
        // rejected by MySQL in strict mode with "Field 'password_hash' doesn't have
        // a default value", which rolled back the enclosing order transaction.
        // Widening a column to accept NULL cannot lose an existing hash, and on a
        // table that is already nullable this is a no-op.
        try {
            $pdo->exec("ALTER TABLE `customers` MODIFY COLUMN `password_hash` VARCHAR(255) DEFAULT NULL");
            $results[] = ['upgrade' => 'customers.password_hash_nullable', 'status' => 'VERIFIED_OR_MODIFIED'];
        } catch (\PDOException $e) {
            $results[] = ['upgrade' => 'customers.password_hash_nullable', 'status' => 'ERROR', 'error' => $e->getMessage()];
        }

        try {
            $pdo->exec("ALTER TABLE `customers` MODIFY COLUMN `status` ENUM('active', 'pending', 'suspended') DEFAULT 'active'");
            $results[] = ['upgrade' => 'customers.status_enum', 'status' => 'VERIFIED_OR_MODIFIED'];
        } catch (\PDOException $e) {
            $results[] = ['upgrade' => 'customers.status_enum', 'status' => 'ERROR', 'error' => $e->getMessage()];
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
    // On the command line, running the file runs the migrations. It used to only
    // print the file list unless ?action=run was set - which cannot be passed on the
    // CLI - so the instruction "run this file from the command line" did nothing.
    // Pass `status` to list the migration files without touching the database.
    if ($isCli) {
        $cliArgs = $_SERVER['argv'] ?? [];
        $argAction = strtolower(trim((string)($cliArgs[1] ?? 'run')));

        echo "=== DT Brand's Database Migration Runner ===\n";
        $status = $runner->status();
        foreach ($status as $s) {
            echo " - [{$s['status']}] {$s['migration']}\n";
        }
        echo "Total migration files detected: " . count($status) . "\n\n";

        if ($argAction === 'status') {
            echo "Status only (pass no argument to apply the schema).\n";
            exit(0);
        }

        $result = $runner->runMigrations();
        if (($result['status'] ?? '') !== 'success') {
            echo "FAILED: " . ($result['message'] ?? 'unknown error') . "\n";
            exit(1);
        }
        foreach ($result['executed'] as $step) {
            $label = $step['file'] ?? $step['upgrade'] ?? $step['repair'] ?? $step['seed'] ?? 'step';
            $extra = isset($step['rows']) ? " ({$step['rows']} rows)" : '';
            echo " * {$label}: {$step['status']}{$extra}\n";
            if (!empty($step['error'])) {
                echo "     error: {$step['error']}\n";
            }
        }
        echo "\nDone.\n";
        exit(0);
    }

    if (isset($_GET['action']) && $_GET['action'] === 'run') {
        header('Content-Type: application/json');
        echo json_encode($runner->runMigrations(), JSON_PRETTY_PRINT);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode(['status' => 'ready', 'migrations' => $runner->status()], JSON_PRETTY_PRINT);
    exit;
}
