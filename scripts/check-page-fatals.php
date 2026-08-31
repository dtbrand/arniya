<?php
/**
 * scripts/check-page-fatals.php — CLI smoke test for admin pages
 * Executes each admin PHP page in a separate php process and reports fatals
 * (missing require_once / class-not-found) like the live 500 on
 * /admin/customers/active.php.
 */

declare(strict_types=1);

$root = dirname(__DIR__);
chdir($root);

$dirs = [
    'admin/customers', 'admin/products', 'admin/catalogue', 'admin/orders',
    'admin/payments', 'admin/reports', 'admin/marketing', 'admin/media',
    'admin/settings', 'admin/shipping', 'admin/system', 'admin/users',
    'admin/whatsapp', 'admin/inventory', 'admin/notifications',
    'admin/dashboard', 'admin/cms', 'admin/pricing', 'admin/reviews',
];

$runner = $root . '/scripts/_page-runner.php';
$failures = [];
$ok = 0;

foreach ($dirs as $dir) {
    foreach (glob($root . '/' . $dir . '/*.php') ?: [] as $page) {
        $base = basename($page);
        if ($base[0] === '_') {
            continue; // shared guards are includes, not pages
        }
        $cmd = 'php -d display_errors=1 -d error_reporting=E_ALL '
            . escapeshellarg($runner) . ' '
            . escapeshellarg($root) . ' '
            . escapeshellarg($page) . ' 2>&1';
        exec($cmd, $out, $code);
        if ($code !== 0) {
            $failures[] = [$dir . '/' . $base, implode(' | ', array_slice($out, 0, 3))];
        } else {
            $ok++;
        }
        $out = [];
    }
}

echo "OK: $ok pages\n";
if ($failures) {
    echo "FAILURES: " . count($failures) . "\n";
    foreach ($failures as [$page, $err]) {
        echo "  x $page\n      $err\n";
    }
    exit(1);
}
echo "All pages render without fatals.\n";