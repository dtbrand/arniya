<?php
/**
 * rotate-logs.php — Automated Log Rotation & Storage Management Utility
 * DT Brand's & Jai Hanuman Tex
 */

$logDir = __DIR__ . '/../logs';
$maxAgeDays = 14;

if (!is_dir($logDir)) {
    echo "No logs directory found to rotate.\n";
    exit(0);
}

echo "=== DT Brand's Log Rotation Engine ===\n";
echo "Retention Policy: {$maxAgeDays} Days\n";

$now = time();
$files = glob($logDir . '/*.log');
$deleted = 0;

foreach ($files as $file) {
    if (is_file($file)) {
        $ageDays = ($now - filemtime($file)) / (60 * 60 * 24);
        if ($ageDays > $maxAgeDays) {
            unlink($file);
            echo "Deleted expired log: " . basename($file) . " (Age: " . round($ageDays, 1) . " days)\n";
            $deleted++;
        }
    }
}

echo "Log rotation completed. Expired logs removed: {$deleted}\n";
