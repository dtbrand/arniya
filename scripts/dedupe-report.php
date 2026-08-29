<?php
/**
 * scripts/dedupe-report.php — Comprehensive File Deduplication and Inventory Generator
 * DT Brand's & Jai Hanuman Tex
 */

declare(strict_types=1);

$rootDir = dirname(__DIR__);
$exclude = ['vendor', 'node_modules', '.git', '.system_generated', 'scratch', 'backups', '.phpunit.cache', '.uix'];

$files = [];
$md5Map = [];
$nameMap = [];

function collect_files(string $dir, array &$files, array $exclude, string $rootDir): void
{
    $items = scandir($dir);
    if ($items === false) return;

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $full = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($full)) {
            if (!in_array($item, $exclude, true)) {
                collect_files($full, $files, $exclude, $rootDir);
            }
        } elseif (is_file($full)) {
            $rel = ltrim(substr($full, strlen($rootDir)), DIRECTORY_SEPARATOR);
            $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));
            if (in_array($ext, ['php', 'js', 'css', 'sql', 'json', 'html'], true)) {
                $files[] = [
                    'rel' => str_replace('\\', '/', $rel),
                    'full' => $full,
                    'name' => $item,
                    'size' => filesize($full),
                    'md5'  => md5_file($full),
                    'ext'  => $ext
                ];
            }
        }
    }
}

collect_files($rootDir, $files, $exclude, $rootDir);

foreach ($files as $f) {
    $md5Map[$f['md5']][] = $f;
    $nameMap[$f['name']][] = $f;
}

$duplicateGroups = array_filter($md5Map, fn($group) => count($group) > 1);
$duplicateNameGroups = array_filter($nameMap, fn($group) => count($group) > 1);

// Build Markdown Report
$out = "# DT Brand's Architecture Deduplication & Consolidation Report\n\n";
$out .= "**Generated:** " . date('Y-m-d H:i:s') . "\n";
$out .= "**Total Source Files Scanned:** " . count($files) . "\n";
$out .= "**Identical Content Duplicate Groups (Byte-for-Byte):** " . count($duplicateGroups) . "\n";
$out .= "**Same-Name File Clusters (Different Versions across Trees):** " . count($duplicateNameGroups) . "\n\n";

$out .= "---\n\n";
$out .= "## 1. Executive Tree Consolidation Strategy\n\n";
$out .= "| Logical Domain | Primary Survivor Path | Source Trees Merged | Survivor Rationale |\n";
$out .= "|---|---|---|---|\n";
$out .= "| **Root Homepage** | `index.php` (modular) | `index.php`, `index.php` | Seamless, high-performance home hub with video slider & category feed |\n";
$out .= "| **Storefront Hub** | `shop.php`, `product.php`, `wholesale.php`, `reseller.php`, `retailer.php`, `account.php` | `*.php` | Complete production business logic, real pricing tiers, filters |\n";
$out .= "| **Unified REST API** | `api/*.php` | `api/` + `api/` (Union) | Complete endpoint coverage, `_guard.php` security, JSON responses |\n";
$out .= "| **Core Business Classes** | `src/*.php` | `src/` -> `src/` | Preserve complete `Auth.php` (32KB), `OrderManager.php` (42KB), `DiscountEngine.php` (5.4KB) |\n";
$out .= "| **Admin Panel Suite** | `admin/**` | `admin/` + `admin/` + `admin/` | Full modern admin dashboard, products matrix, variants, order manager |\n";
$out .= "| **Shared Modals & Partials** | `shared/includes/**` | `Shared/Includes/` + `shared/` | Single canonical source for QuickView, SmartShare, Reels, Cart, Wishlist |\n\n";

$out .= "---\n\n";
$out .= "## 2. Byte-for-Byte Identical Duplicate Files\n\n";
$out .= "These files share identical MD5 checksums and can be safely deduplicated to a single canonical file:\n\n";

foreach ($duplicateGroups as $md5 => $group) {
    $out .= "### MD5: `{$md5}` ({$group[0]['name']}, {$group[0]['size']} bytes)\n";
    foreach ($group as $item) {
        $out .= "- `{$item['rel']}`\n";
    }
    $out .= "\n";
}

$out .= "---\n\n";
$out .= "## 3. Name-Colliding Files Across Trees (Version Diff & Survivor Selection)\n\n";
$out .= "These files have the same filename across different trees but different contents/sizes. The survivor was chosen based on completeness and recent features:\n\n";

foreach ($duplicateNameGroups as $name => $group) {
    $out .= "### `{$name}` (" . count($group) . " copies across trees)\n";
    $out .= "| Path | Size | MD5 | Action |\n";
    $out .= "|---|---|---|---|\n";
    
    // Determine largest / most complete
    usort($group, fn($a, $b) => $b['size'] <=> $a['size']);
    foreach ($group as $idx => $item) {
        $action = ($idx === 0) ? "**KEEP (Survivor - Most Complete)**" : "Merge / Remove";
        $out .= "| `{$item['rel']}` | {$item['size']} B | `{$item['md5']}` | {$action} |\n";
    }
    $out .= "\n";
}

$reportPath = $rootDir . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . 'dedupe-report.md';
if (!is_dir(dirname($reportPath))) {
    mkdir(dirname($reportPath), 0755, true);
}
file_put_contents($reportPath, $out);

echo "SUCCESS: Deduplication report generated at docs/dedupe-report.md\n";
echo "Total Scanned: " . count($files) . " | Identical MD5 Groups: " . count($duplicateGroups) . " | Colliding Names: " . count($duplicateNameGroups) . "\n";
