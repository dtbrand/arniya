<?php
/**
 * scripts/lint-all.php — Fast Full Workspace PHP Syntax Linter
 * DT Brand's & Jai Hanuman Tex
 */
declare(strict_types=1);

$root = realpath(__DIR__ . '/..') ?: dirname(__DIR__);
$excluded = [
    '.git',
    'node_modules',
    'vendor',
    'scratch',
    '.gemini',
    '.agents',
    'playwright-report',
    'test-results',
    'dist',
    '.system_generated',
    '.phpunit.cache',
    'storage'
];

/**
 * Recursively find all PHP files without traversing excluded directories
 */
function findPhpFiles(string $dir, array $excluded): array {
    $files = [];
    $items = @scandir($dir);
    if ($items === false) {
        return $files;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        if (in_array($item, $excluded, true)) {
            continue;
        }

        $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($fullPath)) {
            $files = array_merge($files, findPhpFiles($fullPath, $excluded));
        } elseif (substr($item, -4) === '.php') {
            $files[] = $fullPath;
        }
    }

    return $files;
}

$resolvedPhp = null;
if (defined('PHP_BINARY') && PHP_BINARY && @file_exists(PHP_BINARY)) {
    $resolvedPhp = PHP_BINARY;
} elseif (DIRECTORY_SEPARATOR === '/') {
    $resolvedPhp = 'php';
} else {
    $resolvedPhp = file_exists('C:\\xampp\\php\\php.exe') ? 'C:\\xampp\\php\\php.exe' : 'php';
}

$phpFiles = findPhpFiles($root, $excluded);
$count = count($phpFiles);
$errors = [];

foreach ($phpFiles as $path) {
    $output = [];
    $returnVar = 0;
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
