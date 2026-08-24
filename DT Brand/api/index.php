<?php
/**
 * api/index.php — Master API Directory & Gateway
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'platform' => "DT Brand's & Jai Hanuman Tex — Luxury Ethnic API",
    'version' => '1.0.0',
    'status' => 'operational',
    'endpoints' => [
        'health' => '/api/health.php',
        'products' => '/api/products/index.php',
        'categories' => '/api/categories/index.php',
        'cart' => '/api/cart/index.php',
        'wishlist' => '/api/wishlist/index.php',
        'orders' => '/api/orders/index.php',
        'customers' => '/api/customers/index.php',
        'reseller' => '/api/reseller/index.php',
        'retailer' => '/api/retailer/index.php',
        'wholesale' => '/api/wholesale/index.php',
        'payments' => '/api/payments/index.php',
        'shipping' => '/api/shipping/index.php',
        'media' => '/api/media/index.php',
        'notifications' => '/api/notifications/index.php',
        'whatsapp' => '/api/whatsapp/index.php'
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
