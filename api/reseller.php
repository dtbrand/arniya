<?php
/**
 * api/reseller.php — Reseller Margin Sharing & Smart Share Link API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/ProductCatalog.php';
use DTBrand\ProductCatalog;

$action = $_POST['action'] ?? $_GET['action'] ?? 'calculate';

if ($action === 'calculate') {
    $productId = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 0);
    $marginPercent = max(5, min(50, (float)($_POST['margin_percent'] ?? $_GET['margin_percent'] ?? 15.0)));

    // Defaulted to product 1 and, for an unknown id, returned the first product in
    // the catalogue as though it were the one asked for.
    if ($productId <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'product_id is required.'], JSON_PRETTY_PRINT);
        exit;
    }
    $product = ProductCatalog::getById($productId);
    if (!$product) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Product not found.'], JSON_PRETTY_PRINT);
        exit;
    }

    $resellerBase = (float)($product['reseller_price'] ?? 0);
    if ($resellerBase <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'No reseller price is set for this product yet.'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $marginAmount = round($resellerBase * ($marginPercent / 100), 2);
    $finalSellingPrice = $resellerBase + $marginAmount;

    echo json_encode([
        'success' => true,
        'product' => [
            'id' => $product['id'],
            'title' => $product['title'],
            'reseller_base_price' => $resellerBase,
            'margin_percent' => $marginPercent,
            'reseller_profit' => $marginAmount,
            'final_customer_price' => $finalSellingPrice,
            'smart_share_url' => "https://jaihanumantex.in/product.php?id={$product['id']}&ref=reseller_vip"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

echo json_encode(['success' => true, 'message' => 'Reseller API operational']);
exit;
