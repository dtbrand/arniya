<?php
/**
 * scripts/check-includes.php — Comprehensive PHP Include & Require Target Validator
 * DT Brand's & Jai Hanuman Tex — CI/CD Quality Control Standard
 */

declare(strict_types=1);

$rootDir = dirname(__DIR__);
$exclude = ['vendor', 'node_modules', '.git', '.system_generated', 'scratch', 'backups', '.phpunit.cache', '.uix'];

$errors = [];
$totalFiles = 0;
$totalIncludes = 0;

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootDir, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

$pattern = '/(?:require_once|require|include_once|include)\s*\(?\s*(__DIR__\s*\.\s*)?[\'"]([^\'"]+)[\'"]/';

foreach ($iterator as $item) {
    if (!$item->isFile() || $item->getExtension() !== 'php') {
        continue;
    }

    $filePath = $item->getPathname();
    $skip = false;
    foreach ($exclude as $ex) {
        if (str_contains($filePath, DIRECTORY_SEPARATOR . $ex . DIRECTORY_SEPARATOR)) {
            $skip = true;
            break;
        }
    }
    if ($skip) {
        continue;
    }

    $totalFiles++;
    $relPath = ltrim(substr($filePath, strlen($rootDir)), DIRECTORY_SEPARATOR);
    $content = file_get_contents($filePath);
    if ($content === false) {
        continue;
    }

    $lines = explode("\n", $content);
    foreach ($lines as $lineIdx => $line) {
        if (preg_match_all($pattern, $line, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $totalIncludes++;
                $hasDir = !empty($match[1]);
                $incPath = $match[2];

                if ($hasDir) {
                    $targetPath = dirname($filePath) . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $incPath);
                } else {
                    $targetPath = $rootDir . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, ltrim($incPath, '/\\'));
                }

                if (!file_exists($targetPath)) {
                    $errors[] = [
                        'file' => $relPath,
                        'line' => $lineIdx + 1,
                        'statement' => trim($match[0]),
                        'target' => $incPath,
                        'reason' => 'Target file does not exist'
                    ];
                }
            }
        }
    }
}

echo "=================================================================\n";
echo "DT Brand's Include Target Verification Report\n";
echo "=================================================================\n";
echo "Scanned PHP files:    {$totalFiles}\n";
echo "Evaluated includes:   {$totalIncludes}\n";
echo "Broken targets:       " . count($errors) . "\n";
echo "=================================================================\n\n";

if (!empty($errors)) {
    echo "FAILED: The following broken include statements were detected:\n\n";
    foreach ($errors as $i => $err) {
        $num = $i + 1;
        echo "[{$num}] {$err['file']}:{$err['line']}\n";
        echo "    Statement: {$err['statement']}\n";
        echo "    Target:    {$err['target']}\n";
        echo "    Reason:    {$err['reason']}\n\n";
    }
    exit(1);
}

echo "SUCCESS: All include and require targets exist!\n";
exit(0);
