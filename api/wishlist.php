<?php
/**
 * api/wishlist.php — Customer Wishlist REST & AJAX API
 * DT Brand's & Jai Hanuman Tex
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\ProductCatalog;
use DTBrand\Auth;

if (!isset($_SESSION['wishlist_items'])) {
    $_SESSION['wishlist_items'] = [];
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'view';
$productId = (int)($_POST['product_id'] ?? $_GET['product_id'] ?? 0);

if ($action === 'toggle' && $productId > 0) {
    if (in_array($productId, $_SESSION['wishlist_items'])) {
        $_SESSION['wishlist_items'] = array_values(array_diff($_SESSION['wishlist_items'], [$productId]));
        $status = 'removed';
    } else {
        $_SESSION['wishlist_items'][] = $productId;
        $status = 'added';
    }
} elseif ($action === 'add' && $productId > 0) {
    if (!in_array($productId, $_SESSION['wishlist_items'])) {
        $_SESSION['wishlist_items'][] = $productId;
    }
    $status = 'added';
} elseif ($action === 'remove' && $productId > 0) {
    $_SESSION['wishlist_items'] = array_values(array_diff($_SESSION['wishlist_items'], [$productId]));
    $status = 'removed';
} else {
    $status = 'view';
}

// Get current user role for price resolution
$currentUser = Auth::getCurrentUser();
$userRole = 'guest';
if (Auth::isAdminLoggedIn()) {
    $userRole = 'admin';
} elseif ($currentUser) {
    $userRole = strtolower(trim((string)($currentUser['type'] ?? ($currentUser['role'] ?? 'customer'))));
}
if ($userRole === 'wholesaler') { $userRole = 'wholesale'; }
if ($userRole === '' || $userRole === 'retail') { $userRole = 'customer'; }

$items = [];
foreach ($_SESSION['wishlist_items'] as $id) {
    $p = ProductCatalog::getById($id);
    if ($p) {
        // Apply role-based price resolution
        $priceDisplay = ProductCatalog::getPriceDisplay($p, $userRole);
        $p['price'] = $priceDisplay['effective_price'];
        $p['base_price'] = $priceDisplay['base_price'];
        $p['sale_price'] = $priceDisplay['sale_price'];
        $p['show_sale'] = $priceDisplay['show_sale'];
        $p['price_label'] = $priceDisplay['price_label'];
        $p['effective_price'] = $priceDisplay['effective_price'];
        $p['is_purchasable'] = $priceDisplay['is_purchasable'];
        
        // Hide trade prices from non-trade roles
        $isTradeRole = in_array($userRole, ['admin', 'wholesale', 'retailer'], true);
        if (!$isTradeRole) {
            $p['wholesale_price'] = null;
            $p['reseller_price'] = null;
            $p['customer_price'] = null;
            $p['customer_sale_price'] = null;
            $p['trade_price'] = $p['price'];
        } else {
            $p['trade_price'] = $p['price'];
        }
        
        $items[] = $p;
    }
}

echo json_encode([
    'success' => true,
    'status' => $status,
    'count' => count($items),
    'items' => $items
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
