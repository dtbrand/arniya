<?php
/**
 * api/cart.php — Server-Side Cart Calculation & Lot Validation API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';
require_once __DIR__ . '/src/PricingCalculator.php';

use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;

try {
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: $_POST;

    $items = $data['items'] ?? [];
    $userType = $data['user_type'] ?? 'retail';
    $couponCode = trim($data['coupon'] ?? '');

    $validatedItems = [];
    $subtotal = 0.0;
    $totalQty = 0;

    foreach ($items as $item) {
        $pid = (int)($item['id'] ?? 0);
        $qty = max(1, (int)($item['qty'] ?? ($item['quantity'] ?? 1)));
        $lotType = $item['lot_type'] ?? 'single';

        $p = ProductCatalog::getById($pid);
        if (!$p) continue;

        $unitPrice = (float)$p['price'];
        if ($userType === 'wholesale') {
            $unitPrice = (float)$p['wholesale_price'];
        } elseif ($userType === 'reseller') {
            $unitPrice = (float)$p['reseller_price'];
        }

        // Tier multipliers
        if ($lotType === 'half_set') {
            $qty = max($qty, (int)($p['moq_lots']['half_set'] ?? 4));
        } elseif ($lotType === 'full_set') {
            $qty = max($qty, (int)($p['moq_lots']['full_set'] ?? 8));
        } elseif ($lotType === 'master_bale') {
            $qty = max($qty, (int)($p['moq_lots']['master_bale'] ?? 24));
        }

        $itemTotal = round($unitPrice * $qty, 2);
        $subtotal += $itemTotal;
        $totalQty += $qty;

        $validatedItems[] = [
            'id' => $p['id'],
            'name' => $p['name'],
            'sku' => $p['sku'],
            'image' => $p['image'],
            'color' => $item['color'] ?? ($p['colors'][0] ?? $p['color']),
            'size' => $item['size'] ?? ($p['size'][0] ?? 'Free Size'),
            'lot_type' => $lotType,
            'qty' => $qty,
            'unit_price' => $unitPrice,
            'total_price' => $itemTotal
        ];
    }

    $discount = 0.0;
    if ($couponCode === 'FESTIVE25') {
        $discount = round($subtotal * 0.25, 2);
    } elseif ($couponCode === 'FIRST10') {
        $discount = round($subtotal * 0.10, 2);
    }

    $shipping = ($subtotal > 2999 || $subtotal === 0.0) ? 0.0 : 150.0;
    $calc = PricingCalculator::calculateOrderTotal($subtotal, $discount, $shipping, 5.0);

    echo json_encode([
        'success' => true,
        'user_type' => $userType,
        'item_count' => count($validatedItems),
        'total_qty' => $totalQty,
        'items' => $validatedItems,
        'pricing' => $calc,
        'free_shipping' => ($subtotal > 2999)
    ], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
