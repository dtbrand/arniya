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

// 1. Create customer_notes table if not exists
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `customer_notes` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `customer_id` INT NOT NULL,
        `author_id` INT NULL,
        `author_name` VARCHAR(150) NOT NULL DEFAULT 'Admin',
        `note_text` TEXT NOT NULL,
        `is_important` TINYINT(1) NOT NULL DEFAULT 0,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX `idx_customer_id` (`customer_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    $results['customer_notes_table'] = 'OK';
} catch (\\Throwable $e) {
    $results['customer_notes_table'] = 'ERROR: ' . $e->getMessage();
}

// 2. Ensure values_json exists in product_attributes
try {
    $cols = $pdo->query("SHOW COLUMNS FROM `product_attributes` LIKE 'values_json'")->fetchAll(\\PDO::FETCH_ASSOC);
    if (empty($cols)) {
        $pdo->exec("ALTER TABLE `product_attributes` ADD COLUMN `values_json` TEXT NULL AFTER `type`");
        $results['product_attributes_values_json'] = 'ADDED';
    } else {
        $results['product_attributes_values_json'] = 'ALREADY_EXISTS';
    }
} catch (\\Throwable $e) {
    $results['product_attributes_values_json'] = 'ERROR: ' . $e->getMessage();
}

// 3. Seed product_brands if empty
try {
    $brandCount = (int)$pdo->query("SELECT COUNT(*) FROM `product_brands`")->fetchColumn();
    if ($brandCount === 0) {
        $brands = [
            ["DT Brand's Master Heritage", 'dt-brands', 'Official primary flagship textile label of DT Brand\\'s & Jai Hanuman Tex.', '', 'Primary Flagship', 'active'],
            ["Jai Hanuman Tex", 'jai-hanuman-tex', 'Surat wholesale manufacturing and central handloom distribution brand.', '', 'Primary Flagship', 'active'],
            ["Arniya Silk Mills", 'arniya-silk', 'Premium banarasi, kanchipuram and mulberry silk weaves.', '', 'Premium Weaves', 'active'],
            ["Surat Heritage Brocades", 'surat-heritage', 'Traditional zari handlooms, tested metallic borders, and wedding trousseau.', '', 'Handloom Classics', 'active']
        ];
        $stmt = $pdo->prepare("INSERT INTO `product_brands` (`name`, `slug`, `description`, `logo_url`, `tier`, `status`) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($brands as $b) {
            $stmt->execute($b);
        }
        $results['product_brands_seeded'] = count($brands);
    } else {
        $results['product_brands_seeded'] = "SKIPPED_EXISTING_{$brandCount}";
    }
} catch (\\Throwable $e) {
    $results['product_brands_seeded'] = 'ERROR: ' . $e->getMessage();
}

// 4. Seed product_attributes if empty
try {
    $attrCount = (int)$pdo->query("SELECT COUNT(*) FROM `product_attributes`")->fetchColumn();
    if ($attrCount === 0) {
        $colorTerms = json_encode([
            ["name" => "Crimson Red", "hex" => "#991B1B"],
            ["name" => "Peacock Blue", "hex" => "#0284C7"],
            ["name" => "Emerald Green", "hex" => "#059669"],
            ["name" => "Royal Purple", "hex" => "#7C3AED"],
            ["name" => "Mustard Gold", "hex" => "#D97706"],
            ["name" => "Rani Pink", "hex" => "#DB2777"],
            ["name" => "Wine Burgundy", "hex" => "#831843"],
            ["name" => "Maroon", "hex" => "#800000"]
        ], JSON_UNESCAPED_UNICODE);

        $sizeTerms = json_encode([
            ["name" => "Free Size (6.3m)", "hex" => null],
            ["name" => "Standard (5.5m)", "hex" => null],
            ["name" => "Plus Size (7.0m)", "hex" => null]
        ], JSON_UNESCAPED_UNICODE);

        $blouseTerms = json_encode([
            ["name" => "Unstitched Blouse Piece (0.8m)", "hex" => null],
            ["name" => "Stitched Blouse (Ready Made)", "hex" => null],
            ["name" => "Heavy Embroidered / Maggam Work", "hex" => null],
            ["name" => "Running Contrast Blouse", "hex" => null],
            ["name" => "Without Blouse Piece", "hex" => null]
        ], JSON_UNESCAPED_UNICODE);

        $zariTerms = json_encode([
            ["name" => "Pure Silver Tested Zari", "hex" => null],
            ["name" => "Half Fine Zari", "hex" => null],
            ["name" => "Imitation / Tissue Zari", "hex" => null],
            ["name" => "Copper Zari", "hex" => null],
            ["name" => "Antique Gold Zari", "hex" => null]
        ], JSON_UNESCAPED_UNICODE);

        $attrs = [
            ["Color Variations", "color", "Color Swatch", $colorTerms, "active"],
            ["Saree Length & Sizing", "size", "Text Badge / Pill", $sizeTerms, "active"],
            ["Blouse Piece Options", "blouse-piece", "Select Dropdown", $blouseTerms, "active"],
            ["Zari Type", "zari-type", "Text Badge / Pill", $zariTerms, "active"]
        ];

        $stmt = $pdo->prepare("INSERT INTO `product_attributes` (`name`, `slug`, `type`, `values_json`, `status`) VALUES (?, ?, ?, ?, ?)");
        foreach ($attrs as $a) {
            $stmt->execute($a);
        }
        $results['product_attributes_seeded'] = count($attrs);
    } else {
        $results['product_attributes_seeded'] = "SKIPPED_EXISTING_{$attrCount}";
    }
} catch (\\Throwable $e) {
    $results['product_attributes_seeded'] = 'ERROR: ' . $e->getMessage();
}

echo json_encode($results, JSON_PRETTY_PRINT);
"""

print("1. Uploading schema patch script to HarmitEthnic...")
ftp = ftplib.FTP(FTP_HOST)
ftp.login(FTP_USER, FTP_PASS)
ftp.cwd('/public_html')

import io
ftp.storbinary('STOR db_patch_temp.php', io.BytesIO(PATCH_PHP.encode('utf-8')))
ftp.quit()

print("2. Executing schema patch on live server...")
ctx = ssl._create_unverified_context()
req = urllib.request.Request('https://harmitethnic.com/db_patch_temp.php', headers={'User-Agent': 'Mozilla/5.0'})
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
    ftp.delete('db_patch_temp.php')
    print("Patch script removed successfully.")
except Exception as e:
    print(f"Could not delete: {e}")
ftp.quit()
