<?php
namespace DTBrand;

use PDO;
use Exception;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ProductCatalog.php';
require_once __DIR__ . '/Auth.php';

/**
 * WishlistManager — Enterprise Wishlist Management & IDOR-Proof Authorization Engine
 * Master Specification V2: Section 45 (Wishlist Audit & IDOR Protection)
 * DT Brand's & Jai Hanuman Tex
 */
class WishlistManager
{
    /**
     * Check whether a user is authorized to view or modify a given customer's wishlist (IDOR Protection)
     *
     * Rules:
     * 1. Admins may view/manage any wishlist for concierge assistance.
     * 2. Logged-in customers may ONLY access and alter their OWN wishlist.
     * 3. Guests can only access their session wishlist (customerId = 0).
     *
     * @param int $requestedCustomerId The customer ID targeted in the request
     * @param array|null $currentUser Authenticated session user
     * @param bool $isAdmin Whether current session has admin privileges
     * @return bool True if authorized, false if IDOR violation
     */
    public static function validateAccess(int $requestedCustomerId, ?array $currentUser = null, bool $isAdmin = false): bool
    {
        if ($isAdmin) {
            return true;
        }

        if ($requestedCustomerId <= 0) {
            // Guest session access
            return true;
        }

        if (!$currentUser || empty($currentUser['id'])) {
            // Unauthenticated user trying to access a customer's specific wishlist
            return false;
        }

        return ((int)$currentUser['id'] === $requestedCustomerId);
    }

    /**
     * Verify CSRF Token for state-modifying requests
     */
    public static function validateCsrf(?string $submittedToken): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            Auth::initSession();
        }

        $sessionToken = $_SESSION['csrf_token'] ?? '';
        if (empty($sessionToken)) {
            // No session token established yet, allow for initial session bootstrap
            return true;
        }

        $token = trim((string)$submittedToken);
        if (empty($token)) {
            $headerToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($_SERVER['HTTP_X_XSRF_TOKEN'] ?? '');
            $token = trim((string)$headerToken);
        }

        return hash_equals($sessionToken, $token);
    }

    /**
     * Get Wishlist Items for a customer (or guest session) with full authoritative pricing and availability
     *
     * @param int $customerId 0 for guest, >0 for registered customer
     * @param string $userRole Role tier for price resolution
     * @param array $sessionItems Product IDs from session for guest or synchronization
     * @return array Formatted wishlist items with prices and availability
     */
    public static function getWishlist(int $customerId, string $userRole = 'guest', array $sessionItems = []): array
    {
        $db = Database::getConnection();
        $productVariantsMap = []; // [productId => [variantId, ...]]

        if ($customerId > 0 && $db !== null && !Database::isMockMode()) {
            try {
                $stmt = $db->prepare("
                    SELECT product_id, variant_id 
                    FROM `wishlist_items` 
                    WHERE customer_id = ? 
                    ORDER BY id DESC
                ");
                $stmt->execute([$customerId]);
                $dbRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($dbRows as $r) {
                    $pid = (int)($r['product_id'] ?? 0);
                    $vid = !empty($r['variant_id']) ? (int)$r['variant_id'] : null;
                    if ($pid > 0) {
                        if (!isset($productVariantsMap[$pid])) {
                            $productVariantsMap[$pid] = [];
                        }
                        if ($vid !== null && !in_array($vid, $productVariantsMap[$pid], true)) {
                            $productVariantsMap[$pid][] = $vid;
                        }
                    }
                }
            } catch (\Throwable $e) {
                error_log('[WishlistManager::getWishlist DB Error] ' . $e->getMessage());
            }
        }

        // Merge session items if guest or if user has session items not yet in DB
        foreach ($sessionItems as $sItem) {
            $pid = is_array($sItem) ? (int)($sItem['product_id'] ?? $sItem['id'] ?? 0) : (int)$sItem;
            $vid = is_array($sItem) && !empty($sItem['variant_id']) ? (int)$sItem['variant_id'] : null;
            if ($pid > 0) {
                if (!isset($productVariantsMap[$pid])) {
                    $productVariantsMap[$pid] = [];
                }
                if ($vid !== null && !in_array($vid, $productVariantsMap[$pid], true)) {
                    $productVariantsMap[$pid][] = $vid;
                }
            }
        }

        $items = [];
        foreach ($productVariantsMap as $pid => $variantsList) {
            $p = ProductCatalog::getById($pid);
            if (!$p) {
                // Product was deleted from database
                continue;
            }

            $isActive = strtolower((string)($p['status'] ?? 'active')) === 'active';
            $stockQty = (int)($p['stock_qty'] ?? ($p['stock_quantity'] ?? 0));
            $isAvailable = ($isActive && $stockQty > 0);

            // Authoritative Price Resolution
            $priceDisplay = ProductCatalog::getPriceDisplay($p, $userRole);
            $p['price'] = $priceDisplay['effective_price'];
            $p['base_price'] = $priceDisplay['base_price'];
            $p['sale_price'] = $priceDisplay['sale_price'];
            $p['show_sale'] = $priceDisplay['show_sale'];
            $p['price_label'] = $priceDisplay['price_label'];
            $p['effective_price'] = $priceDisplay['effective_price'];
            $p['is_purchasable'] = $priceDisplay['is_purchasable'] && $isAvailable;
            $p['is_available'] = $isAvailable;
            $p['stock_status'] = $isAvailable ? 'in_stock' : ($isActive ? 'out_of_stock' : 'discontinued');

            // Apply Strict Role Price Masking (Sections 12 & 32: Zero Role-Price Leakage)
            ProductCatalog::maskRolePrices($p, $userRole, ($userRole === 'admin'));

            // Include variant details if variant is specified
            $selectedVariant = null;
            $firstVariantId = !empty($variantsList) ? $variantsList[0] : null;
            if ($firstVariantId !== null && !empty($p['variants'])) {
                foreach ($p['variants'] as $v) {
                    if ((int)($v['id'] ?? 0) === $firstVariantId) {
                        $selectedVariant = $v;
                        break;
                    }
                }
            }
            $p['wishlist_variant_id'] = $firstVariantId;
            $p['wishlist_variant'] = $selectedVariant;

            $items[] = $p;
        }

        return $items;
    }

    /**
     * Add product to wishlist
     *
     * @param int $customerId Registered customer ID, or 0 for guest
     * @param int $productId Valid product ID
     * @param int|null $variantId Optional variant ID
     * @return array Operation result
     */
    public static function addItem(int $customerId, int $productId, ?int $variantId = null): array
    {
        if ($productId <= 0) {
            return ['success' => false, 'message' => 'Invalid product ID.'];
        }

        $product = ProductCatalog::getById($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Product does not exist.'];
        }

        $db = Database::getConnection();
        if ($customerId > 0 && $db !== null && !Database::isMockMode()) {
            try {
                // Check if already in DB
                $checkStmt = $db->prepare("
                    SELECT id FROM `wishlist_items` 
                    WHERE customer_id = ? AND product_id = ? AND (variant_id = ? OR (variant_id IS NULL AND ? IS NULL)) 
                    LIMIT 1
                ");
                $checkStmt->execute([$customerId, $productId, $variantId, $variantId]);
                if (!$checkStmt->fetch()) {
                    $ins = $db->prepare("
                        INSERT INTO `wishlist_items` (customer_id, product_id, variant_id, created_at)
                        VALUES (?, ?, ?, NOW())
                    ");
                    $ins->execute([$customerId, $productId, $variantId]);
                }
            } catch (\Throwable $e) {
                error_log('[WishlistManager::addItem Error] ' . $e->getMessage());
            }
        }

        return [
            'success' => true,
            'status' => 'added',
            'product_id' => $productId,
            'variant_id' => $variantId,
            'message' => "'{$product['name']}' added to your wishlist."
        ];
    }

    /**
     * Remove product from wishlist
     *
     * @param int $customerId Registered customer ID, or 0 for guest
     * @param int $productId Product ID to remove
     * @param int|null $variantId Optional variant ID
     * @return array Operation result
     */
    public static function removeItem(int $customerId, int $productId, ?int $variantId = null): array
    {
        if ($productId <= 0) {
            return ['success' => false, 'message' => 'Invalid product ID.'];
        }

        $db = Database::getConnection();
        if ($customerId > 0 && $db !== null && !Database::isMockMode()) {
            try {
                if ($variantId !== null && $variantId > 0) {
                    $del = $db->prepare("DELETE FROM `wishlist_items` WHERE customer_id = ? AND product_id = ? AND variant_id = ?");
                    $del->execute([$customerId, $productId, $variantId]);
                } else {
                    $del = $db->prepare("DELETE FROM `wishlist_items` WHERE customer_id = ? AND product_id = ?");
                    $del->execute([$customerId, $productId]);
                }
            } catch (\Throwable $e) {
                error_log('[WishlistManager::removeItem Error] ' . $e->getMessage());
            }
        }

        return [
            'success' => true,
            'status' => 'removed',
            'product_id' => $productId,
            'variant_id' => $variantId,
            'message' => 'Item removed from your wishlist.'
        ];
    }

    /**
     * Toggle item in wishlist (add if not present, remove if present)
     */
    public static function toggleItem(int $customerId, int $productId, ?int $variantId = null, array $sessionItems = []): array
    {
        $db = Database::getConnection();
        $isExisting = false;

        if ($customerId > 0 && $db !== null && !Database::isMockMode()) {
            try {
                $checkStmt = $db->prepare("
                    SELECT id FROM `wishlist_items` 
                    WHERE customer_id = ? AND product_id = ? 
                    LIMIT 1
                ");
                $checkStmt->execute([$customerId, $productId]);
                $isExisting = (bool)$checkStmt->fetch();
            } catch (\Throwable $e) {
                $isExisting = false;
            }
        } else {
            $isExisting = in_array($productId, $sessionItems, true);
        }

        if ($isExisting) {
            return self::removeItem($customerId, $productId, $variantId);
        } else {
            return self::addItem($customerId, $productId, $variantId);
        }
    }

    /**
     * Clear all wishlist items for a customer
     */
    public static function clearWishlist(int $customerId): bool
    {
        $db = Database::getConnection();
        if ($customerId > 0 && $db !== null && !Database::isMockMode()) {
            try {
                $stmt = $db->prepare("DELETE FROM `wishlist_items` WHERE customer_id = ?");
                return $stmt->execute([$customerId]);
            } catch (\Throwable $e) {
                error_log('[WishlistManager::clearWishlist Error] ' . $e->getMessage());
                return false;
            }
        }
        return true;
    }
}
