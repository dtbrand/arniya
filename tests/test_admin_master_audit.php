<?php
/**
 * tests/test_admin_master_audit.php
 *
 * CLI guard for admin sidebar links, admin API endpoint references, duplicate
 * sidebar options, and core responsive layout signals.
 */
declare(strict_types=1);

require_once __DIR__ . '/../scripts/admin-master-audit.php';

$result = dt_admin_master_audit(dirname(__DIR__));

echo "\n======================================================================\n";
echo "  DT ADMIN MASTER STATIC AUDIT\n";
echo "======================================================================\n\n";
echo "Admin files scanned: {$result['admin_files_scanned']}\n";
echo "API files scanned: {$result['api_files_scanned']}\n";
echo "CSS files scanned: {$result['css_files_scanned']}\n";
echo "Admin URLs seen: {$result['admin_urls_seen']}\n";
echo "API URLs seen: {$result['api_urls_seen']}\n";
echo "Sidebar options seen: {$result['sidebar_options_seen']}\n";
echo "Missing admin links: " . count($result['missing_admin_links']) . "\n";
echo "Missing API references: " . count($result['missing_api_references']) . "\n";
echo "Missing expected API files: " . count($result['missing_expected_api_files']) . "\n";
echo "Missing responsive CSS signals: " . count($result['missing_responsive_css_signals']) . "\n";
echo "Duplicate sidebar options: " . count($result['duplicate_sidebar_options']) . "\n";
echo "Duplicate file groups: " . count($result['duplicate_file_groups']) . "\n\n";

foreach (['missing_admin_links', 'missing_api_references', 'missing_expected_api_files', 'missing_responsive_css_signals'] as $key) {
    foreach ($result[$key] as $finding) {
        echo "[FAIL] {$key}: " . (is_array($finding) ? json_encode($finding, JSON_UNESCAPED_SLASHES) : $finding) . "\n";
    }
}

if ($result['critical_count'] > 0) {
    exit(1);
}

echo "[PASS] Admin route, API mapping, and responsive layout audit passed.\n";
exit(0);
