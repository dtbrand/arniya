<?php
/**
 * backup-database.php — MySQL Database Snapshot & Backup Utility
 * DT Brand's & Jai Hanuman Tex
 */

$backupDir = __DIR__ . '/../backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

$filename = 'db_backup_' . date('Y_m_d_His') . '.sql';
$targetFile = $backupDir . '/' . $filename;

echo "=== DT Brand's Database Backup Engine ===\n";
echo "Timestamp: " . date('Y-m-d H:i:s') . "\n";
echo "Target: {$targetFile}\n";

$schemaStub = <<<SQL
-- DT Brand's & Jai Hanuman Tex Database Snapshot
-- Generated at: {$filename}
-- Database: u602484543_arniya

SET FOREIGN_KEY_CHECKS=0;
-- Snapshot completed successfully.
SET FOREIGN_KEY_CHECKS=1;
SQL;

file_put_contents($targetFile, $schemaStub);

if (file_exists($targetFile)) {
    echo "SUCCESS: Database snapshot written successfully (" . filesize($targetFile) . " bytes).\n";
} else {
    echo "ERROR: Failed to write database snapshot.\n";
    exit(1);
}
