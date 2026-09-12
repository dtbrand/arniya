<?php
/**
 * api/wishlist.php — Customer Wishlist REST & AJAX API
 * Master Specification V2: Section 45 (Wishlist Audit, IDOR Protection & CSRF Guard)
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/WishlistManager.php';
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\ProductCatalog;
use DTBrand\WishlistManager;
use DTBrand\Auth;

try {
    Auth::initSession();

    if (!isset($_SESSION['wishlist_items']) || !is_array($_SESSION['wishlist_items'])) {
        $_SESSION['wishlist_items'] = [];
    }

    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true);
    $data = is_array($jsonData) ? $jsonData : $_POST;
    if (empty($data) && !empty($_GET)) {
        $data = $_GET;
    }

    $action = trim((string)($data['action'] ?? ($_GET['action'] ?? 'view')));
    $productId = (int)($data['product_id'] ?? ($_GET['product_id'] ?? 0));
    $variantId = !empty($data['variant_id']) ? (int)$data['variant_id'] : (!empty($_GET['variant_id']) ? (int)$_GET['variant_id'] : null);

    $currentUser = Auth::getCurrentUser();
    $isAdmin = Auth::isAdminLoggedIn();
    $authUserId = (int)($currentUser['id'] ?? 0);

    // ── IDOR GUARD (Section 45: A user must never access another user's wishlist by changing an ID) ──
    $requestedCustomerId = isset($data['customer_id']) ? (int)$data['customer_id'] : (isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : $authUserId);

    if (!WishlistManager::validateAccess($requestedCustomerId, $currentUser, $isAdmin)) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'error'   => 'IDOR Violation: Access denied to another customer\'s wishlist.',
            'message' => 'Security Error: You are not authorized to access or modify this customer wishlist.'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $effectiveCustomerId = $isAdmin ? $requestedCustomerId : $authUserId;

    // ── CSRF GUARD FOR MUTATING ACTIONS ──
    $writeActions = ['add', 'remove', 'toggle', 'clear'];
    if (in_array($action, $writeActions, true)) {
        $submittedCsrf = $data['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? null);
        if (!empty($_SESSION['csrf_token']) && !WishlistManager::validateCsrf($submittedCsrf)) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'error'   => 'CSRF Verification Failed',
                'message' => 'Security Token Expired or Invalid. Please refresh the page and try again.'
            ], JSON_PRETTY_PRINT);
            exit;
        }
    }

    $status = 'view';
    $result = null;

    if ($action === 'toggle' && $productId > 0) {
        $result = WishlistManager::toggleItem($effectiveCustomerId, $productId, $variantId, $_SESSION['wishlist_items']);
        $status = $result['status'] ?? 'toggled';

        // Synchronize session array
        if ($status === 'removed') {
            $_SESSION['wishlist_items'] = array_values(array_diff($_SESSION['wishlist_items'], [$productId]));
        } else {
            if (!in_array($productId, $_SESSION['wishlist_items'], true)) {
                $_SESSION['wishlist_items'][] = $productId;
            }
        }
    } elseif ($action === 'add' && $productId > 0) {
        $result = WishlistManager::addItem($effectiveCustomerId, $productId, $variantId);
        $status = 'added';
        if (!in_array($productId, $_SESSION['wishlist_items'], true)) {
            $_SESSION['wishlist_items'][] = $productId;
        }
    } elseif ($action === 'remove' && $productId > 0) {
        $result = WishlistManager::removeItem($effectiveCustomerId, $productId, $variantId);
        $status = 'removed';
        $_SESSION['wishlist_items'] = array_values(array_diff($_SESSION['wishlist_items'], [$productId]));
    } elseif ($action === 'clear') {
        WishlistManager::clearWishlist($effectiveCustomerId);
        $_SESSION['wishlist_items'] = [];
        $status = 'cleared';
    }

    // Role resolution for authoritative price rendering
    $userRole = 'guest';
    if ($isAdmin) {
        $userRole = 'admin';
    } elseif ($currentUser) {
        $userRole = strtolower(trim((string)($currentUser['type'] ?? ($currentUser['role'] ?? 'customer'))));
    }
    if ($userRole === 'wholesaler') { $userRole = 'wholesale'; }
    if ($userRole === '' || $userRole === 'retail') { $userRole = 'customer'; }

    $items = WishlistManager::getWishlist($effectiveCustomerId, $userRole, $_SESSION['wishlist_items']);

    echo json_encode([
        'success'     => true,
        'status'      => $status,
        'count'       => count($items),
        'customer_id' => $effectiveCustomerId,
        'user_role'   => $userRole,
        'items'       => $items,
        'operation'   => $result
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ]);
}
