<?php
/**
 * api/products/export.php — Real product CSV export
 * DT Brand's & Jai Hanuman Tex
 *
 * Backs admin/products/exports/index.php. The Export Studio used to toast
 * "Generating export…" and deliver nothing. This streams a genuine CSV built
 * from the live products table — the same columns the importer accepts, so
 * an export round-trips through the import wizard unchanged.
 *
 * Scopes: all | wholesale | inventory
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../_guard.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

dt_api_require_admin('export products');

$scope = strtolower(trim((string)($_GET['scope'] ?? 'all')));

$products = ProductCatalog::getAll(true); // exports include drafts for the owner
if ($scope === 'wholesale') {
    $products = array_values(array_filter($products, static function (array $p): bool {
        return (float)($p['wholesale_price'] ?? 0) > 0;
    }));
} elseif ($scope === 'inventory') {
    $products = array_values(array_filter($products, static function (array $p): bool {
        return (int)($p['stock_qty'] ?? 0) <= 20; // low/no stock focus
    }));
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="dtbrand-' . $scope . '-export-' . date('Ymd-Hi') . '.csv"');
header('Pragma: no-cache');

$out = fopen('php://output', 'w');
fwrite($out, "\xEF\xBB\xBF"); // BOM so Excel opens UTF-8 correctly
fputcsv($out, [
    'title', 'sku', 'category', 'retail_price', 'mrp', 'wholesale_price',
    'reseller_price', 'stock_qty', 'fabric', 'occasion', 'description', 'status',
]);

foreach ($products as $p) {
    fputcsv($out, [
        (string)($p['title'] ?? ''),
        (string)($p['sku'] ?? ''),
        (string)($p['category'] ?? ''),
        (string)($p['retail_price'] ?? ''),
        (string)($p['mrp'] ?? ''),
        (string)($p['wholesale_price'] ?? ''),
        (string)($p['reseller_price'] ?? ''),
        (string)($p['stock_qty'] ?? ''),
        (string)($p['fabric'] ?? ''),
        (string)($p['occasion'] ?? ''),
        (string)($p['description'] ?? ''),
        (string)($p['status'] ?? ''),
    ]);
}
fclose($out);