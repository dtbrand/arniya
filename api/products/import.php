<?php
/**
 * api/products/import.php — Real CSV bulk product import
 * DT Brand's & Jai Hanuman Tex
 *
 * Backs admin/products/imports/index.php. The wizard used to be pure theatre:
 * a hardcoded 250-row "validation" with an "Execute Import Now" button that
 * only fired a toast and advanced to a fake success screen. This endpoint
 * parses the actually-uploaded CSV and inserts every valid row through
 * ProductCatalog::create — the same write path as the single product form.
 *
 * CSV columns (header row required, case-insensitive):
 *   title* (or name), sku, category (name), retail_price* (or price),
 *   mrp, wholesale_price, reseller_price, stock_qty, fabric, occasion,
 *   description, status
 * * = required. Rows missing a required column are skipped and reported.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../_guard.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

dt_api_require_admin('import products');

if (empty($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'] ?? '')) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No CSV file received. Choose a file first.']);
    exit;
}

$upload = $_FILES['file'];
if ($upload['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Upload error code ' . $upload['error'] . '.']);
    exit;
}

// CSV only. A .xlsx would need a parser library the host does not have, so
// the wizard offers a downloadable CSV template instead.
$originalName = strtolower((string)$upload['name']);
$mime = '';
if (function_exists('mime_content_type')) {
    $mime = (string)mime_content_type($upload['tmp_name']);
}
if (!str_ends_with($originalName, '.csv') && !in_array($mime, ['text/plain', 'text/csv', 'application/csv', 'application/vnd.ms-excel'], true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Only .csv files are supported. Download the template, fill it in, and re-upload.']);
    exit;
}

$handle = fopen($upload['tmp_name'], 'r');
if ($handle === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not read the uploaded file.']);
    exit;
}

// ── Parse header row ──
$header = fgetcsv($handle);
if ($header === false || count($header) === 0) {
    fclose($handle);
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'The file is empty or missing a header row.']);
    exit;
}
$map = [];
foreach ($header as $i => $col) {
    $key = strtolower(trim((string)$col));
    $map[$key] = $i;
}
$pick = static function (array $row, array $names) use ($map): string {
    foreach ($names as $n) {
        if (isset($map[$n]) && isset($row[$map[$n]])) {
            return trim((string)$row[$map[$n]]);
        }
    }
    return '';
};

$pdo = Database::getConnection();
if ($pdo === null || Database::isMockMode()) {
    fclose($handle);
    http_response_code(503);
    echo json_encode(['success' => false, 'message' => 'Database unreachable — nothing was imported.']);
    exit;
}

$totalRows = 0;
$imported = 0;
$failed = 0;
$errors = [];
$seenSkus = [];

while (($row = fgetcsv($handle)) !== false) {
    if ($row === [null] || (count($row) === 1 && trim((string)$row[0]) === '')) {
        continue; // blank line
    }
    $totalRows++;

    $title = $pick($row, ['title', 'name', 'product_title', 'product name']);
    $priceRaw = $pick($row, ['retail_price', 'price', 'selling_price']);
    $skuIn = $pick($row, ['sku', 'sku_code']);

    if ($title === '' || (float)$priceRaw <= 0) {
        $failed++;
        $errors[] = 'Row ' . $totalRows . ': missing title or price — skipped.';
        continue;
    }
    if ($skuIn !== '' && isset($seenSkus[strtoupper($skuIn)])) {
        $failed++;
        $errors[] = 'Row ' . $totalRows . ': duplicate SKU "' . $skuIn . '" inside this file — skipped.';
        continue;
    }

    $payload = [
        'title'           => $title,
        'sku'             => $skuIn,
        'category'        => $pick($row, ['category', 'category_name']),
        'retail_price'    => (float)$priceRaw,
        'mrp'             => (float)($pick($row, ['mrp', 'retail_mrp']) ?: 0),
        'wholesale_price' => (float)($pick($row, ['wholesale_price', 'wholesale_rate']) ?: 0),
        'reseller_price'  => (float)($pick($row, ['reseller_price']) ?: 0),
        'stock_qty'       => (int)($pick($row, ['stock_qty', 'stock', 'qty']) ?: 0),
        'fabric'          => $pick($row, ['fabric']),
        'occasion'        => $pick($row, ['occasion']),
        'description'     => $pick($row, ['description', 'details']),
        'status'          => $pick($row, ['status']) ?: 'in_stock',
    ];

    $res = ProductCatalog::create($payload);
    if (!empty($res['success'])) {
        $imported++;
        if ($skuIn !== '') {
            $seenSkus[strtoupper($skuIn)] = true;
        }
        ProductCatalog::invalidateCache();
    } else {
        $failed++;
        $errors[] = 'Row ' . $totalRows . ' ("' . mb_substr($title, 0, 40) . '"): ' . (string)($res['message'] ?? 'rejected');
    }
}
fclose($handle);

// Cap the error list so a 5,000-row bad file cannot blow the response up.
$errors = array_slice($errors, 0, 50);

echo json_encode([
    'success' => true,
    'total_rows' => $totalRows,
    'imported' => $imported,
    'failed' => $failed,
    'errors' => $errors,
    'message' => $imported . ' of ' . $totalRows . ' rows imported.'
        . ($failed > 0 ? ' ' . $failed . ' row(s) need attention.' : ''),
], JSON_PRETTY_PRINT);