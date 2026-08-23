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
    $productId = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 1);
    $marginPercent = max(5, min(50, (float)($_POST['margin_percent'] ?? $_GET['margin_percent'] ?? 15.0)));
    $product = ProductCatalog::getById($productId) ?? ProductCatalog::getAll()[0];

    $resellerBase = $product['reseller_price'];
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
            'smart_share_url' => "https://jaihanumantex.in/Frontend/Single-Product/singleproduct.php?id={$product['id']}&ref=reseller_vip"
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

echo json_encode(['success' => true, 'message' => 'Reseller API operational']);
exit;
