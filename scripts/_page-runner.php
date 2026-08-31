<?php
/**
 * scripts/_page-runner.php — executes one admin page in a controlled CLI context.
 * Usage: php _page-runner.php <root> <page.php>
 */

[$_, $root, $page] = array_pad($argv, 3, '');
if (!is_file($page)) {
    fwrite(STDERR, "no such page: $page\n");
    exit(3);
}
chdir($root);
$_SERVER['DOCUMENT_ROOT'] = $root;
$_SERVER['REQUEST_URI'] = '/' . ltrim(str_replace('\\', '/', substr($page, strlen($root))), '/');
$_SERVER['SCRIPT_NAME'] = $_SERVER['REQUEST_URI'];
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET = [];
$_POST = [];

ob_start();
try {
    include $page;
} catch (Throwable $e) {
    ob_end_clean();
    fwrite(STDERR, 'FATAL: ' . $e->getMessage() . ' @ ' . $e->getFile() . ':' . $e->getLine());
    exit(1);
}
$html = ob_get_clean();
if (strlen($html) < 50) {
    fwrite(STDERR, 'EMPTY OUTPUT (' . strlen($html) . ' bytes)');
    exit(2);
}
echo 'OK ' . strlen($html) . ' bytes';