<?php
/**
 * scripts/package-artifact.php — Build the production ZIP
 * DT Brand's & Jai Hanuman Tex
 *
 * Produces dist/dtbrand-production-YYYYMMDD-HHMM.zip containing exactly the
 * deployable tree: application files, install.php, README, .env.example and
 * composer.lock (so `composer install --no-dev` rebuilds dependencies on the
 * server).
 *
 * Excluded: tests, scripts, node_modules, .git, .github, backups, scratch,
 * storage/logs contents, .env (secrets never travel), DT Brand/, DT Brand New/,
 * AI/ working notes, docs/.
 *
 * Packaging engine: 7z CLI when available, otherwise a PHP file manifest
 * consumed by PowerShell Compress-Archive (Windows dev boxes without the
 * zip extension).
 */

declare(strict_types=1);

$root = dirname(__DIR__);
$distDir = $root . '/dist';
if (!is_dir($distDir)) {
    mkdir($distDir, 0775, true);
}

$stamp = date('Ymd-Hi');
$zipPath = $distDir . "/dtbrand-production-{$stamp}.zip";

$excludeDirs = [
    '.git', '.github', '.uix', '.vscode', '.idea', '.antigravity',
    'node_modules', 'vendor', 'tests', 'scripts', 'backups', 'scratch',
    'dist', 'storage/logs', 'DT Brand', 'DT Brand New', 'AI', 'docs',
    '.phpunit.cache', 'build',
];
$excludeFiles = [
    '.env', 'composer.phar', 'phpstan.neon',
    'phpunit.xml', '.php-cs-fixer.cache',
    '.php-cs-fixer.php', 'commitlint.config.js', 'eslint.config.js',
    'lighthouserc.js', 'playwright.config.js', '.prettierignore',
    'renovate.json', 'release-please-config.json', '.release-please-manifest.json',
    '.prettierrc', '.stylelintrc.json', '.hadolint.yaml',
    '.hintrc', '.shellcheckrc', '.browserslistrc', '.editorconfig',
    'cspell.json', 'package.json', 'package-lock.json',
    'DT_BRAND_MASTER_DESIGN_SYSTEM.md', 'GEMINI.md',
    'MASTER_ARCHITECTURE_AUDIT.md', 'CONTRIBUTING.md',
    'image.png',
];
$excludeExt = ['cache', 'log', 'tmp'];

$iter = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
    RecursiveIteratorIterator::LEAVES_ONLY
);

$files = [];
$totalBytes = 0;
foreach ($iter as $file) {
    /** @var SplFileInfo $file */
    if (!$file->isFile()) {
        continue;
    }
    $path = $file->getPathname();
    $rel = ltrim(str_replace('\\', '/', substr($path, strlen($root))), '/');

    $skip = false;
    foreach ($excludeDirs as $dir) {
        if (str_starts_with($rel, $dir . '/') || $rel === $dir) {
            $skip = true;
            break;
        }
    }
    if ($skip) {
        continue;
    }
    $base = basename($rel);
    if (in_array($base, $excludeFiles, true)) {
        continue;
    }
    $ext = strtolower(pathinfo($base, PATHINFO_EXTENSION));
    if (in_array($ext, $excludeExt, true)) {
        continue;
    }

    $files[] = $path;
    $totalBytes += $file->getSize();
}

// Ensure the must-ship files are present even if a dotfile filter skipped
// them. Compare on realpath so mixed separators cannot dodge the check.
$mustShip = ['composer.lock', '.env.example', 'README.md', 'install.php', '.htaccess'];
$have = [];
foreach ($files as $f) {
    $have[str_replace('\\', '/', strtolower(realpath($f) ?: $f))] = true;
}
foreach ($mustShip as $must) {
    $p = $root . '/' . $must;
    $key = str_replace('\\', '/', strtolower(realpath($p) ?: $p));
    if (is_file($p) && !isset($have[$key])) {
        $files[] = $p;
        $have[$key] = true;
        $totalBytes += filesize($p);
    }
}

if (extension_loaded('zip')) {
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        fwrite(STDERR, "Cannot create {$zipPath}\n");
        exit(1);
    }
    foreach ($files as $path) {
        $rel = ltrim(str_replace('\\', '/', substr($path, strlen($root))), '/');
        $zip->addFile($path, $rel);
    }
    $zip->close();
} elseif (shell_exec('where 7z 2>nul') !== null || is_executable('/c/Users/sai/scoop/shims/7z')) {
    // 7-Zip CLI: read the manifest as a list file. Absolute paths with -spf2
    // keep the drive-relative nesting stable.
    $manifest = $distDir . '/package-manifest.txt';
    file_put_contents($manifest, implode("\n", $files));
    $listArg = str_replace('/', '\\', $manifest);
    $zipArg = str_replace('/', '\\', $zipPath);
    $cmd = "7z a -tzip -y \"{$zipArg}\" @\"{$listArg}\" -spf2 2>&1";
    exec($cmd, $out, $ret);
    if ($ret !== 0 || !file_exists($zipPath)) {
        // Keep the manifest around for diagnosis, and show the tail.
        fwrite(STDERR, "7z packaging failed (exit {$ret}). Manifest kept at {$manifest}\n");
        fwrite(STDERR, implode("\n", array_slice($out, -15)) . "\n");
        exit(1);
    }
    unlink($manifest);
} else {
    // Fallback: hand the manifest to PowerShell Compress-Archive.
    $manifest = $distDir . '/package-manifest.txt';
    file_put_contents($manifest, implode("\n", array_map(
        static fn(string $p): string => str_replace('/', '\\', $p),
        $files
    )));
    $ps = "Get-Content -LiteralPath '{$manifest}' | Compress-Archive -DestinationPath '" .
          str_replace('/', '\\', $zipPath) . "' -Force";
    exec('powershell.exe -NoProfile -Command ' . escapeshellarg($ps), $out, $ret);
    unlink($manifest);
    if ($ret !== 0) {
        fwrite(STDERR, "PowerShell Compress-Archive failed (exit {$ret})\n");
        exit(1);
    }
}

printf(
    "Packaged %d files (%.2f MB source) into %s (%.2f MB)\n",
    count($files),
    $totalBytes / 1048576,
    $zipPath,
    filesize($zipPath) / 1048576
);
