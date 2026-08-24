<?php
/**
 * api/wholesale.php — Wholesale Bulk Lot Volume & Credit Inquiry API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/PricingCalculator.php';

use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;

$action = $_POST['action'] ?? $_GET['action'] ?? 'calculate_lot';

if ($action === 'calculate_lot') {
    $productId = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 1);
    $lotType = $_POST['lot_type'] ?? $_GET['lot_type'] ?? 'half_set'; // single, half_set, full_set, master_bale
    $product = ProductCatalog::getById($productId) ?? ProductCatalog::getAll()[0];

    $qty = match($lotType) {
        'single' => 1,
        'half_set' => 4,
        'full_set' => 8,
        'master_bale' => 24,
        default => 4
    };

    $lotDiscountPercent = match($lotType) {
        'single' => 0.0,
        'half_set' => 30.0,
        'full_set' => 40.0,
        'master_bale' => 48.0,
        default => 30.0
    };

    $unitWholesalePrice = PricingCalculator::calculateWholesalePrice($product['mrp'], $lotDiscountPercent);
    $subtotal = $unitWholesalePrice * $qty;
    $orderCalc = PricingCalculator::calculateOrderTotal($subtotal, 0.0, 0.0, 5.0);

    echo json_encode([
        'success' => true,
        'lot_type' => $lotType,
        'pieces' => $qty,
        'product' => [
            'id' => $product['id'],
            'title' => $product['title'],
            'mrp' => $product['mrp'],
            'lot_discount_percent' => $lotDiscountPercent,
            'unit_wholesale_price' => $unitWholesalePrice,
            'lot_subtotal' => $orderCalc['subtotal'],
            'gst_amount' => $orderCalc['gst'],
            'lot_grand_total' => $orderCalc['grand_total']
        ]
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

echo json_encode(['success' => true, 'message' => 'Wholesale API operational']);
exit;
