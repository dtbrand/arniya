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
    $productId = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 0);
    $lotType = $_POST['lot_type'] ?? $_GET['lot_type'] ?? 'half_set'; // single, half_set, full_set, master_bale

    // This used to default to product 1 and, when the id did not exist, quote
    // ProductCatalog::getAll()[0] - a different saree - under the requested id,
    // then crash with "Undefined array key 0" on an empty catalogue.
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

    // Real lot sizes from the moq_* columns. The old code assumed 1/4/8/24 pieces
    // and applied an invented 0/30/40/48 percent discount to the MRP, so it quoted
    // a wholesale rate the business never set.
    $lotKeys = ['single' => 'single', 'half_set' => 'half_set', 'full_set' => 'full_set', 'master_bale' => 'master_bale'];
    if (!isset($lotKeys[$lotType])) {
        $lotType = 'half_set';
    }
    $qty = (int)($product['moq_lots'][$lotType] ?? 0);
    if ($qty <= 0) {
        echo json_encode([
            'success' => false,
            'lot_type' => $lotType,
            'message' => 'No lot size is recorded for this product, so the lot total cannot be calculated.'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $unitWholesalePrice = (float)($product['wholesale_price'] ?? 0);
    if ($unitWholesalePrice <= 0) {
        echo json_encode([
            'success' => false,
            'lot_type' => $lotType,
            'pieces' => $qty,
            'message' => 'This product has no wholesale rate yet. Please ask for a quotation.'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $mrp = (float)($product['mrp'] ?? 0);
    $subtotal = $unitWholesalePrice * $qty;
    $orderCalc = PricingCalculator::calculateOrderTotal($subtotal, 0.0, 0.0, 5.0);

    echo json_encode([
        'success' => true,
        'lot_type' => $lotType,
        'pieces' => $qty,
        'product' => [
            'id' => $product['id'],
            'title' => $product['title'],
            'mrp' => $mrp,
            // Derived from the two stored prices, not from an assumed tier ladder.
            'lot_discount_percent' => $mrp > 0 ? round((($mrp - $unitWholesalePrice) / $mrp) * 100, 2) : null,
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
