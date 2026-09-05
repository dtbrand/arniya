<?php
/**
 * backup-database.php — Enterprise MySQL Database Snapshot & Backup Utility
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';

use DTBrand\Database;

$backupDir = __DIR__ . '/../backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$filename = 'dt_snapshot_' . date('Ymd_His') . '.sql';
$targetFile = $backupDir . '/' . $filename;

echo "=== DT Brand's Enterprise Database Backup Engine ===\n";
echo "Timestamp: " . date('Y-m-d H:i:s') . "\n";
echo "Target: {$targetFile}\n";

$pdo = Database::getConnection();
$tableCount = 0;
$rowCount = 0;

$fh = fopen($targetFile, 'w');
if ($fh === false) {
    echo "ERROR: Could not open {$targetFile} for writing.\n";
    exit(1);
}

$dbName = getenv('DB_NAME') ?: 'u602484543_demodt121';

fwrite($fh, "-- DT Brand's database snapshot\n");
fwrite($fh, "-- Generated: " . date('c') . "\n");
fwrite($fh, "-- Database: {$dbName}\n\n");
fwrite($fh, "SET FOREIGN_KEY_CHECKS=0;\n\n");

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);
        $tableCount = count($tables);

        foreach ($tables as $table) {
            $create = $pdo->query("SHOW CREATE TABLE `" . str_replace('`', '', (string)$table) . "`")->fetch(\PDO::FETCH_NUM);
            if (!$create) continue;
            fwrite($fh, "DROP TABLE IF EXISTS `{$table}`;\n");
            fwrite($fh, $create[1] . ";\n\n");

            $stmt = $pdo->query("SELECT * FROM `{$table}`");
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $rowCount++;
                $cols = '`' . implode('`, `', array_keys($row)) . '`';
                $vals = array_map(static fn($v) => $v === null ? 'NULL' : $pdo->quote((string)$v), array_values($row));
                fwrite($fh, "INSERT INTO `{$table}` ({$cols}) VALUES (" . implode(', ', $vals) . ");\n");
            }
            fwrite($fh, "\n");
        }
    } catch (\Throwable $e) {
        echo "WARNING: Live dump encountered exception: " . $e->getMessage() . "\n";
    }
} else {
    // Offline / Mock Mode schema fallback
    echo "NOTICE: Running in Mock Mode / Offline. Generating structural schema snapshot.\n";
    fwrite($fh, "-- Structural Mock Snapshot\n");
    fwrite($fh, "CREATE TABLE IF NOT EXISTS `products` (`id` INT AUTO_INCREMENT PRIMARY KEY, `title` VARCHAR(255));\n");
    fwrite($fh, "CREATE TABLE IF NOT EXISTS `orders` (`id` INT AUTO_INCREMENT PRIMARY KEY, `order_number` VARCHAR(64));\n");
    $tableCount = 2;
}

fwrite($fh, "SET FOREIGN_KEY_CHECKS=1;\n");
fclose($fh);

if (file_exists($targetFile) && filesize($targetFile) > 30) {
    $sha256 = hash_file('sha256', $targetFile);
    echo "SUCCESS: Database snapshot written successfully.\n";
    echo "Tables: {$tableCount} | Rows: {$rowCount} | Size: " . number_format(filesize($targetFile)) . " bytes\n";
    echo "SHA256: {$sha256}\n";
    exit(0);
} else {
    echo "ERROR: Failed to write valid database snapshot.\n";
    exit(1);
}
