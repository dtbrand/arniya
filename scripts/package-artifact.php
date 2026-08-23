<?php
/**
 * package-artifact.php — Reproducible Build & Release Artifact Packager
 * DT Brand's & Jai Hanuman Tex
 */

$version = '1.0.0';
$timestamp = date('Ymd_His');
$buildDir = __DIR__ . '/../build';
$distZip = $buildDir . "/dtbrand-v{$version}-{$timestamp}.zip";

if (!is_dir($buildDir)) {
    mkdir($buildDir, 0755, true);
}

echo "=== Packaging DT Brand's Production Build Artifact ===\n";
echo "Version: {$version}\n";
echo "Target: {$distZip}\n";

$cmd = "tar.exe -a -c -f \"{$distZip}\" --exclude=\"*.mp4\" --exclude=\"node_modules\" --exclude=\"vendor\" --exclude=\"backups\" --exclude=\"build\" --exclude=\"scratch\" Frontend Shared src database docs .htaccess index.php admin.php adminlogin.php health.php";
exec($cmd, $output, $ret);

if ($ret === 0 && file_exists($distZip)) {
    $sizeMb = round(filesize($distZip) / (1024 * 1024), 2);
    echo "SUCCESS: Created build artifact ({$sizeMb} MB) at {$distZip}\n";
    exit(0);
} else {
    echo "ERROR: Failed to create package artifact via tar.\n";
    exit(1);
}
