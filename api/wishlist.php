<?php
/**
 * api/wishlist.php — Customer Wishlist REST & AJAX API
 * DT Brand's & Jai Hanuman Tex
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/ProductCatalog.php';
use DTBrand\ProductCatalog;

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

$items = [];
foreach ($_SESSION['wishlist_items'] as $id) {
    $p = ProductCatalog::getById($id);
    if ($p) {
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
