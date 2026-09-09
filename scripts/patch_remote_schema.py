import urllib.request
import ftplib
import json
import ssl
import time
import io

FTP_HOST = '147.93.99.134'
FTP_USER = 'u602484543.harmitethnic.com'
FTP_PASS = 'Gautam@9006'

PATCH_PHP = """<?php
require_once __DIR__ . '/src/Database.php';
use DTBrand\\Database;

$pdo = Database::getConnection();
if (!$pdo || Database::isMockMode()) {
    echo json_encode(['error' => 'No live DB connection']);
    exit;
}

$results = [];

// Helper function to add column if not exists
function ensureColumn($pdo, $table, $column, $definition, &$results) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = ?");
        $stmt->execute([$table, $column]);
        if ((int)$stmt->fetchColumn() === 0) {
            $pdo->exec("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}");
            $results["{$table}.{$column}"] = 'ADDED';
        } else {
            $results["{$table}.{$column}"] = 'ALREADY_EXISTS';
        }
    } catch (\\Throwable $e) {
        $results["{$table}.{$column}"] = 'ERROR: ' . $e->getMessage();
    }
}

// Helper function to add index if not exists
function ensureIndex($pdo, $table, $indexName, $columns, &$results) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND INDEX_NAME = ?");
        $stmt->execute([$table, $indexName]);
        if ((int)$stmt->fetchColumn() === 0) {
            $pdo->exec("ALTER TABLE `{$table}` ADD INDEX `{$indexName}` ({$columns})");
            $results["index:{$table}.{$indexName}"] = 'ADDED';
        } else {
            $results["index:{$table}.{$indexName}"] = 'ALREADY_EXISTS';
        }
    } catch (\\Throwable $e) {
        $results["index:{$table}.{$indexName}"] = 'ERROR: ' . $e->getMessage();
    }
}

// 1. PRODUCTS TABLE
ensureColumn($pdo, 'products', 'customer_sale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `customer_price`', $results);
ensureColumn($pdo, 'products', 'sale_price', 'DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `customer_sale_price`', $results);

// 2. PRODUCT_VARIANTS TABLE
ensureColumn($pdo, 'product_variants', 'reseller_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `price`', $results);
ensureColumn($pdo, 'product_variants', 'retailer_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `reseller_price`', $results);
ensureColumn($pdo, 'product_variants', 'retail_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `retailer_price`', $results);
ensureColumn($pdo, 'product_variants', 'wholesale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `retail_price`', $results);
ensureColumn($pdo, 'product_variants', 'reseller_sale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `wholesale_price`', $results);
ensureColumn($pdo, 'product_variants', 'retailer_sale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `reseller_sale_price`', $results);
ensureColumn($pdo, 'product_variants', 'retail_sale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `retailer_sale_price`', $results);
ensureColumn($pdo, 'product_variants', 'wholesale_sale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `retail_sale_price`', $results);
ensureColumn($pdo, 'product_variants', 'customer_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `wholesale_sale_price`', $results);
ensureColumn($pdo, 'product_variants', 'customer_sale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `customer_price`', $results);
ensureColumn($pdo, 'product_variants', 'full_set_retailer_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `customer_sale_price`', $results);
ensureColumn($pdo, 'product_variants', 'full_set_wholesale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_retailer_price`', $results);
ensureColumn($pdo, 'product_variants', 'full_set_retailer_sale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_wholesale_price`', $results);
ensureColumn($pdo, 'product_variants', 'full_set_wholesale_sale_price', 'DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_retailer_sale_price`', $results);
ensureColumn($pdo, 'product_variants', 'selling_type', "ENUM('single_piece','full_set') NOT NULL DEFAULT 'single_piece' AFTER `full_set_wholesale_sale_price`", $results);

// Indexes
ensureIndex($pdo, 'product_variants', 'idx_variant_selling_type', '`selling_type`', $results);
ensureIndex($pdo, 'product_variants', 'idx_variant_product_selling', '`product_id`, `selling_type`', $results);

echo json_encode($results, JSON_PRETTY_PRINT);
"""

print("1. Uploading master price schema patch script to HarmitEthnic...")
ftp = ftplib.FTP()
ftp.connect(FTP_HOST, 21, timeout=30)
ftp.login(FTP_USER, FTP_PASS)
ftp.makepasv = lambda: ftplib.parse229(ftp.sendcmd('EPSV'), ftp.sock.getpeername())
ftp.cwd('/public_html')

ftp.storbinary('STOR db_patch_master_prices.php', io.BytesIO(PATCH_PHP.encode('utf-8')))
ftp.quit()

print("2. Executing master price schema patch on live server...")
ctx = ssl._create_unverified_context()
req = urllib.request.Request('https://harmitethnic.com/db_patch_master_prices.php', headers={'User-Agent': 'Mozilla/5.0'})
try:
    with urllib.request.urlopen(req, context=ctx, timeout=30) as resp:
        res = resp.read().decode('utf-8')
        print("Response from server:")
        print(res)
except Exception as e:
    print(f"Failed to execute patch: {e}")

print("\n3. Cleaning up temporary patch script...")
ftp = ftplib.FTP()
ftp.connect(FTP_HOST, 21, timeout=30)
ftp.login(FTP_USER, FTP_PASS)
ftp.makepasv = lambda: ftplib.parse229(ftp.sendcmd('EPSV'), ftp.sock.getpeername())
ftp.cwd('/public_html')
try:
    ftp.delete('db_patch_master_prices.php')
    print("Patch script removed successfully.")
except Exception as e:
    print(f"Could not delete: {e}")
ftp.quit()
