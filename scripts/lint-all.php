<?php
/**
 * scripts/lint-all.php — Full Workspace PHP Syntax Linter
 */
$root = realpath(__DIR__ . '/..');
$errors = [];
$count = 0;

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
);

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') continue;
    $path = $file->getRealPath();
    if (strpos($path, 'vendor') !== false || strpos($path, 'node_modules') !== false || strpos($path, 'scratch') !== false) {
        continue;
    }
    $count++;
    static $resolvedPhp = null;
    if ($resolvedPhp === null) {
        if (defined('PHP_BINARY') && PHP_BINARY && @file_exists(PHP_BINARY)) {
            $resolvedPhp = PHP_BINARY;
        } elseif (DIRECTORY_SEPARATOR === '/') {
            $resolvedPhp = 'php';
        } else {
            $resolvedPhp = file_exists('C:\\xampp\\php\\php.exe') ? 'C:\\xampp\\php\\php.exe' : 'php';
        }
    }
    exec('"' . $resolvedPhp . '" -l ' . escapeshellarg($path), $output, $returnVar);
    if ($returnVar !== 0) {
        $errors[] = [
            'file' => str_replace($root . DIRECTORY_SEPARATOR, '', $path),
            'error' => implode("\n", $output)
        ];
    }
}

echo "=================================================================\n";
echo "DT Brand's PHP Syntax Lint Report\n";
echo "=================================================================\n";
echo "Scanned PHP files: " . $count . "\n";
echo "Syntax Errors:     " . count($errors) . "\n";
echo "=================================================================\n";

if (empty($errors)) {
    echo "\nSUCCESS: All {$count} PHP files passed syntax validation with 0 errors!\n";
    exit(0);
} else {
    echo "\nFAILED: The following syntax errors were detected:\n\n";
    foreach ($errors as $i => $err) {
        echo "[" . ($i + 1) . "] " . $err['file'] . "\n";
        echo "    " . trim($err['error']) . "\n\n";
    }
    exit(1);
}
