#!/usr/bin/env python3
"""
patch_remote_subcat_columns.py — Ensure subcategory columns in products table
DT Brand's & Jai Hanuman Tex
"""
import urllib.request
import ftplib
import json
import ssl
import time
import io

FTP_HOST = '147.93.99.134'
FTP_PASS = 'Gautam@9006'

SERVERS = [
    {
        'name': 'HarmitEthnic',
        'user': 'u602484543.harmitethnic.com',
        'url': 'https://harmitethnic.com/db_patch_subcat.php'
    },
    {
        'name': 'JaiHanumanTex',
        'user': 'u602484543.jaihanumantex.in',
        'url': 'https://jaihanumantex.in/db_patch_subcat.php'
    }
]

PATCH_PHP = """<?php
require_once __DIR__ . '/src/Database.php';
use DTBrand\\Database;

$pdo = Database::getConnection();
if (!$pdo || Database::isMockMode()) {
    echo json_encode(['error' => 'No live DB connection']);
    exit;
}

$results = [];

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

// 1. Add subcategory columns to products table
ensureColumn($pdo, 'products', 'subcategory_id', 'INT NULL DEFAULT NULL AFTER `category_name`', $results);
ensureColumn($pdo, 'products', 'subcategory', 'VARCHAR(100) NULL DEFAULT NULL AFTER `subcategory_id`', $results);
ensureIndex($pdo, 'products', 'idx_products_subcategory', '`subcategory_id`', $results);

// 2. Return subcategories count
try {
    $count = (int)$pdo->query("SELECT COUNT(*) FROM `subcategories`")->fetchColumn();
    $results['subcategories_count'] = $count;
} catch (\\Throwable $e) {
    $results['subcategories_count'] = 'ERROR: ' . $e->getMessage();
}

echo json_encode($results, JSON_PRETTY_PRINT);
"""

ctx = ssl._create_unverified_context()

for s in SERVERS:
    print(f"=== Patching {s['name']} ===")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=30)
    ftp.login(s['user'], FTP_PASS)
    ftp.cwd('/public_html')
    ftp.storbinary('STOR db_patch_subcat.php', io.BytesIO(PATCH_PHP.encode('utf-8')))
    ftp.quit()

    try:
        req = urllib.request.Request(s['url'], headers={'User-Agent': 'Mozilla/5.0'})
        with urllib.request.urlopen(req, context=ctx, timeout=30) as resp:
            print("Response:", resp.read().decode('utf-8'))
    except Exception as e:
        print("Error executing patch:", e)

    # Clean up
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=30)
    ftp.login(s['user'], FTP_PASS)
    ftp.cwd('/public_html')
    try:
        ftp.delete('db_patch_subcat.php')
        print("Cleaned up db_patch_subcat.php")
    except Exception as e:
        pass
    ftp.quit()

print("Done.")
