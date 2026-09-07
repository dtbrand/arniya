<?php
/**
 * scripts/build-deploy-zip.php — Build Production Deployment ZIP
 * DT Brand's & Jai Hanuman Tex
 * 
 * Creates a clean, production-ready ZIP package for Hostinger deployment.
 * Includes all source code, migrations, install.php, and assets.
 * Excludes dev files, tests, node_modules, vendor, backups, etc.
 * 
 * Usage: php scripts/build-deploy-zip.php
 * Output: Desktop/DT_Brand_Deploy_YYYYMMDD_HHMMSS.zip
 */

declare(strict_types=1);

$basePath = dirname(__DIR__);
$timestamp = date('Ymd_His');
$deployName = "DT_Brand_Deploy_{$timestamp}";
$zipPath = "C:/Users/sai/Desktop/{$deployName}.zip";

echo "═══════════════════════════════════════════════════════════════\n";
echo " DT BRAND'S DEPLOYMENT ZIP BUILDER\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "Source: {$basePath}\n";
echo "Output: {$zipPath}\n\n";

// ─── Cleanup any existing ZIP ───
if (file_exists($zipPath)) {
    unlink($zipPath);
    echo "Removed existing ZIP.\n";
}

// ─── Initialize ZipArchive ───
$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die("Failed to create ZIP archive.\n");
}

echo "Creating ZIP archive...\n";

// ─── Files/Directories to INCLUDE ───
$includeDirs = [
    'admin',
    'api',
    'assets',
    'config',
    'database',
    'includes',
    'src',
    'Shared',
    'storage',
    'public',
];

$rootFiles = [
    'index.php',
    'about-us.php',
    'account.php',
    'cart.php',
    'checkout.php',
    'contact.php',
    'health.php',
    'install.php',           // NEW: Production installer
    'logout.php',
    'privacy.php',
    'product.php',
    'reseller.php',
    'retailer.php',
    'shipping.php',
    'shop.php',
    'terms.php',
    'wholesale.php',
    'wishlist.php',
    '.env.example',
    '.htaccess',
    'README.md',
    'composer.json',
    'composer.lock',
];

// ─── Files/Directories to EXCLUDE ───
$excludeDirs = [
    'node_modules',
    'vendor',
    '.git',
    'backups',
    'scratch',
    'logs',
    'test-results',
    '.vscode',
    '.uix',
    '.agents',
    '.github',
];

$excludeFiles = [
    'README.md',           // dev docs inside subdirs
    'phpstan.neon',
    'phpunit.xml',
    'eslint.config.js',
    '.stylelintrc.json',
    '.prettierrc',
    '.prettierignore',
    '.hintrc',
    '.shellcheckrc',
    'commitlint.config.js',
    'release-please-config.json',
    'renovate.json',
    'lighthouserc.js',
    '.release-please-manifest.json',
    '.hadolint.yaml',
    '.browserslistrc',
    '.editorconfig',
    '.gitignore',
    'CSP_CONFIG.md',
    'DT_BRAND_MASTER_DESIGN_SYSTEM.md',
    'GEMINI.md',
    'MASTER_ARCHITECTURE_AUDIT.md',
    'DT_Brand_Deployment_*.zip',
    'image.png',
    'AGENTS.md',
];

$excludeExtensions = ['log', 'tmp', 'cache', 'bak', 'orig', 'map'];

$count = 0;
$bytes = 0;
$skipped = 0;

// ─── Helper: Should skip file? ───
function shouldSkip(string $relPath, string $baseName): bool {
    global $excludeFiles, $excludeExtensions;
    
    // Check excluded files (exact match or wildcard)
    foreach ($excludeFiles as $pattern) {
        if ($pattern === $baseName) return true;
        if (str_ends_with($pattern, '*') && str_starts_with($baseName, rtrim($pattern, '*'))) return true;
        if (str_starts_with($pattern, '*') && str_ends_with($baseName, ltrim($pattern, '*'))) return true;
    }
    
    // Check excluded extensions
    $ext = strtolower(pathinfo($baseName, PATHINFO_EXTENSION));
    if (in_array($ext, $excludeExtensions, true)) return true;
    
    return false;
}

// ─── Process directories ───
foreach ($includeDirs as $dir) {
    $from = $basePath . '/' . $dir;
    if (!is_dir($from)) {
        echo "  ⚠ Directory not found: {$dir}\n";
        continue;
    }
    
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($it as $file) {
        /** @var SplFileInfo $file */
        if (!$file->isFile()) continue;
        
        $rel = $dir . '/' . str_replace('\\', '/', substr($file->getPathname(), strlen($from) + 1));
        $base = basename($rel);
        $parent = dirname($rel);
        
        // Skip dev docs inside module subfolders
        if ($base === 'README.md' && $parent !== $dir) continue;
        
        // Skip excluded directories
        $pathParts = explode('/', $rel);
        $skipDir = false;
        foreach ($pathParts as $part) {
            if (in_array($part, $excludeDirs, true)) {
                $skipDir = true;
                break;
            }
        }
        if ($skipDir) {
            $skipped++;
            continue;
        }
        
        if (shouldSkip($rel, $base)) {
            $skipped++;
            continue;
        }
        
        $target = $rel;
        $zip->addFile($file->getPathname(), $target);
        $count++;
        $bytes += $file->getSize();
    }
}

// ─── Root-level files ───
foreach ($rootFiles as $name) {
    $from = $basePath . '/' . $name;
    if (is_file($from)) {
        if (shouldSkip($name, $name)) {
            $skipped++;
            continue;
        }
        $zip->addFile($from, $name);
        $count++;
        $bytes += filesize($from);
    } else {
        echo "  ⚠ Root file not found: {$name}\n";
    }
}

// ─── Create writable runtime directories with .gitkeep ───
$writableDirs = [
    'storage/logs',
    'assets/images/uploads',
];
foreach ($writableDirs as $w) {
    $zip->addEmptyDir($w);
    $zip->addFromString($w . '/.gitkeep', '');
    $count += 2;
}

// ─── Finalize ───
$zip->close();

$sizeMB = round($bytes / 1048576, 2);

echo "\n═══════════════════════════════════════════════════════════════\n";
echo " BUILD COMPLETE\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "Files included: {$count}\n";
echo "Files skipped:  {$skipped}\n";
echo "Total size:     {$sizeMB} MB\n";
echo "Output:         {$zipPath}\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

echo "DEPLOYMENT CHECKLIST:\n";
echo "  1. Upload {$deployName}.zip to Hostinger public_html\n";
echo "  2. Extract ZIP in public_html\n";
echo "  3. Ensure storage/ and assets/images/uploads/ are writable (755)\n";
echo "  4. Visit https://yourdomain.com/install.php\n";
echo "  5. Complete the 5-step installation wizard\n";
echo "  6. DELETE install.php after successful installation\n";
echo "  7. Configure SSL certificate\n";
echo "  8. Set up Razorpay/Cashfree webhooks\n";
echo "  9. Test all checkout flows\n";
echo "\n";
echo "ZIP READY FOR DEPLOYMENT ✓\n";