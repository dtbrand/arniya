<?php
/**
 * scripts/build-deploy-folder.php — Build the "DT Brand New" deployable folder
 * DT Brand's & Jai Hanuman Tex
 *
 * Assembles a clean production tree (no dev configs, no scratch, no tests,
 * no node_modules/vendor, no legacy backups/docs) under
 * Desktop/DT Brand New/ so it can be zipped and extracted straight into
 * public_html on Hostinger.
 */

declare(strict_types=1);

$src  = dirname(__DIR__);
$dest = 'C:/Users/sai/Desktop/DT Brand New';

// ── Wipe any previous build ──
if (is_dir($dest)) {
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dest, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($it as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }
    rmdir($dest);
}
mkdir($dest, 0775, true);

// ── What ships ──
$copyDirs = [
    'admin', 'api', 'assets', 'config', 'database',
    'includes', 'src', 'Shared', 'storage', 'public',
];
$rootPhp = [
    'about-us.php', 'account.php', 'admin.php', 'adminlogin.php',
    'cart.php', 'checkout.php', 'contact.php', 'health.php',
    'index.php', 'install.php', 'logout.php', 'privacy.php',
    'product.php', 'reseller.php', 'retailer.php', 'shipping.php',
    'shop.php', 'terms.php', 'wholesale.php', 'wishlist.php',
];
$rootFiles = [
    '.env.example', '.htaccess', 'README.md', 'composer.json', 'composer.lock',
];
$skipBasenames = [
    '.htaccess', // handled separately where meaningful (assets/images/uploads guard is created at runtime)
];

$count = 0;
$bytes = 0;

// Directories, recursively, minus dev junk inside them.
$skipDirNames = ['node_modules', '.git', 'backups', 'scratch', 'logs'];
$skipFileInDir = ['README.md']; // dev docs inside admin/* subfolders

foreach ($copyDirs as $dir) {
    $from = $src . '/' . $dir;
    if (!is_dir($from)) {
        continue;
    }
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    foreach ($it as $file) {
        /** @var SplFileInfo $file */
        if (!$file->isFile()) {
            continue;
        }
        $rel  = $dir . '/' . str_replace('\\', '/', substr($file->getPathname(), strlen($from) + 1));
        $base = basename($rel);
        $parent = dirname($rel);
        if (in_array($base, $skipFileInDir, true) && $parent !== $dir) {
            continue; // drop dev READMEs inside module subfolders
        }
        $ext = strtolower(pathinfo($base, PATHINFO_EXTENSION));
        if (in_array($ext, ['log', 'tmp', 'cache'], true)) {
            continue;
        }
        $target = $dest . '/' . $rel;
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0775, true);
        }
        copy($file->getPathname(), $target);
        $count++;
        $bytes += $file->getSize();
    }
}

// Root-level pages and files.
foreach (array_merge($rootPhp, $rootFiles) as $name) {
    $from = $src . '/' . $name;
    if (is_file($from)) {
        copy($from, $dest . '/' . $name);
        $count++;
        $bytes += filesize($from);
    }
}

// Writable runtime dirs the app expects.
foreach ([ 'storage/logs', 'assets/images/uploads' ] as $w) {
    $p = $dest . '/' . $w;
    if (!is_dir($p)) {
        mkdir($p, 0775, true);
    }
    // Keep the folder in the zip with a guard file.
    file_put_contents($p . '/.gitkeep', '');
    $count++;
}

printf(
    "Built %s — %d files, %.2f MB\n",
    $dest,
    $count,
    $bytes / 1048576
);
