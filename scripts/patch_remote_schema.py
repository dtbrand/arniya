import urllib.request
import ftplib
import json
import ssl
import time

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

// 1. Ensure kyc_status exists in customers
try {
    $cols = $pdo->query("SHOW COLUMNS FROM `customers` LIKE 'kyc_status'")->fetchAll(\\PDO::FETCH_ASSOC);
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `customers` ADD COLUMN `kyc_status` ENUM('unverified', 'pending', 'verified', 'rejected') DEFAULT 'unverified' AFTER `pan`");
        $results['customers_kyc_status'] = 'ADDED';
    } else {
        $results['customers_kyc_status'] = 'ALREADY_EXISTS';
    }
} catch (\\Throwable $e) {
    $results['customers_kyc_status'] = 'ERROR: ' . $e->getMessage();
}

// 2. Ensure updated_at exists in orders
try {
    $cols = $pdo->query("SHOW COLUMNS FROM `orders` LIKE 'updated_at'")->fetchAll(\\PDO::FETCH_ASSOC);
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `orders` ADD COLUMN `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`");
        $results['orders_updated_at'] = 'ADDED';
    } else {
        $results['orders_updated_at'] = 'ALREADY_EXISTS';
    }
} catch (\\Throwable $e) {
    $results['orders_updated_at'] = 'ERROR: ' . $e->getMessage();
}

// 3. Check order_items columns
try {
    $cols = $pdo->query("SHOW COLUMNS FROM `order_items`")->fetchAll(\\PDO::FETCH_ASSOC);
    $results['order_items_columns'] = array_column($cols, 'Field');
} catch (\\Throwable $e) {
    $results['order_items_columns'] = 'ERROR: ' . $e->getMessage();
}

// 4. Check order_status_history table
try {
    $cols = $pdo->query("SHOW COLUMNS FROM `order_status_history`")->fetchAll(\\PDO::FETCH_ASSOC);
    $results['order_status_history_columns'] = array_column($cols, 'Field');
} catch (\\Throwable $e) {
    $results['order_status_history_columns'] = 'ERROR: ' . $e->getMessage();
}

echo json_encode($results, JSON_PRETTY_PRINT);
"""

print("1. Uploading schema patch script to HarmitEthnic...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd('/public_html')

import io
ftp.storbinary('STOR db_patch_temp2.php', io.BytesIO(PATCH_PHP.encode('utf-8')))
ftp.quit()

print("2. Executing schema patch on live server...")
ctx = ssl._create_unverified_context()
req = urllib.request.Request('https://harmitethnic.com/db_patch_temp2.php', headers={'User-Agent': 'Mozilla/5.0'})
try:
    with urllib.request.urlopen(req, context=ctx, timeout=30) as resp:
        res = resp.read().decode('utf-8')
        print("Response from server:")
        print(res)
except Exception as e:
    print(f"Failed to execute patch: {e}")

print("\n3. Cleaning up temporary patch script...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd('/public_html')
try:
    ftp.delete('db_patch_temp2.php')
    print("Patch script removed successfully.")
except Exception as e:
    print(f"Could not delete: {e}")
ftp.quit()
