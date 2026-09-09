<?php
/**
 * api/cart.php — Server-Side Cart Calculation & Lot Validation API
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
require_once __DIR__ . '/../src/DiscountEngine.php';
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;
use DTBrand\DiscountEngine;
use DTBrand\Database;
use DTBrand\Auth;

try {
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: $_POST;

    $items = $data['items'] ?? ($data['cart'] ?? []);

    // Session-Authoritative Role Resolution (Section 14 & 33: Never trust client-submitted role)
    Auth::initSession();
    $currentUser = Auth::getCurrentUser() ?? ($_SESSION['user'] ?? null);
    $rawUserType = strtolower(trim((string)($data['user_type'] ?? '')));
    if (!empty($_SESSION['admin_logged_in'])) {
        $userType = in_array($rawUserType, ['wholesale', 'retailer', 'reseller', 'customer'], true) ? $rawUserType : 'wholesale';
    } elseif (!empty($currentUser['id'])) {
        $uid = (int)$currentUser['id'];
        $db = Database::getConnection();
        $verifiedType = 'customer';
        if ($db) {
            try {
                $uStmt = $db->prepare("SELECT type, status FROM customers WHERE id = ? LIMIT 1");
                $uStmt->execute([$uid]);
                $uRow = $uStmt->fetch(\PDO::FETCH_ASSOC);
                if ($uRow && ($uRow['status'] ?? '') === 'active') {
                    $verifiedType = strtolower(trim((string)$uRow['type']));
                }
            } catch (\Throwable $e) {}
        }
        if ($verifiedType === 'wholesaler') { $verifiedType = 'wholesale'; }
        if ($verifiedType === 'retail') { $verifiedType = 'customer'; }
        $userType = in_array($verifiedType, ['wholesale', 'retailer', 'reseller'], true) ? $verifiedType : 'customer';
    } else {
        $userType = 'guest';
    }
    $isTradeUser = in_array($userType, ['wholesale', 'retailer'], true);
    $couponCode = trim($data['coupon'] ?? '');

    $validatedItems = [];
    $subtotal = 0.0;
    $totalQty = 0;

    foreach ($items as $item) {
        $pid = (int)($item['id'] ?? ($item['product_id'] ?? 0));
        $qty = max(1, (int)($item['qty'] ?? ($item['quantity'] ?? 1)));
        $lotType = $item['lot_type'] ?? 'single';

        $p = ProductCatalog::getById($pid);
        if (!$p) continue;

        $pSellingType = trim((string)($p['selling_type'] ?? 'single_piece')) ?: 'single_piece';
        $isFullSet = ($pSellingType === 'full_set' || $lotType === 'full_set');

        $saleDisc = (float)($p['sale_discount'] ?? ($p['sale_price'] ?? 0));

        if ($isFullSet) {
            // Full Set Role Security: Strictly Wholesaler or Retailer only (Section 11 & 18)
            if (!$isTradeUser) {
                http_response_code(403);
                echo json_encode([
                    'success' => false,
                    'message' => "Full Set product '{$p['name']}' is exclusively available to verified Retailer and Wholesaler trade accounts."
                ], JSON_PRETTY_PRINT);
                exit;
            }

            // Use ProductCatalog::resolvePrice for correct price
            $unitPrice = ProductCatalog::resolvePrice($p, $userType);
            $variants = $p['full_set_variants'] ?? $p['variants'] ?? [];
            $fullSetPieces = max(1, count($variants));
            $itemTotal = round($unitPrice * $fullSetPieces * $qty, 2);
            $totalPhysicalPieces = $fullSetPieces * $qty;

            $subtotal += $itemTotal;
            $totalQty += $totalPhysicalPieces;

            $validatedItems[] = [
                'id' => $p['id'],
                'product_id' => $p['id'],
                'variant_id' => null,
                'product_type' => 'full_set',
                'selling_type' => 'full_set',
                'name' => $p['name'],
                'sku' => $p['sku'],
                'image' => $p['image'],
                'lot_type' => 'full_set',
                'full_set_pieces' => $fullSetPieces,
                'color' => 'All Configured Colors (' . count($p['colors']) . ')',
                'size' => 'All Configured Sizes (' . count($p['sizes']) . ')',
                'qty' => $qty,
                'quantity' => $qty,
                'pieces_count' => $totalPhysicalPieces,
                'unit_price' => $unitPrice,
                'set_price' => round($unitPrice * $fullSetPieces, 2),
                'subtotal' => $itemTotal,
                'total_price' => $itemTotal
            ];
        } else {
            // Single Piece Role Pricing - Use ProductCatalog::resolvePrice
            $unitPrice = ProductCatalog::resolvePrice($p, $userType);

            // Wholesaler MCQ Validation for Single Piece (Section 6, 17, 33)
            if ($userType === 'wholesale') {
                $mcqResult = ProductCatalog::calculateWholesalerMcq($p);
                $requiredMcq = (int)($mcqResult['mcq'] ?? 0);
                $colorsCount = (int)($mcqResult['color_count'] ?? 0);
                $sizesCount = (int)($mcqResult['size_count'] ?? 0);
                if ($requiredMcq > 0) {
                    if ($qty < $requiredMcq || ($qty % $requiredMcq !== 0)) {
                        http_response_code(400);
                        echo json_encode([
                            'success' => false,
                            'message' => "Wholesale MCQ for '{$p['name']}' requires ordering in full lot multiples of {$requiredMcq} pieces ({$colorsCount} Colours × {$sizesCount} Sizes), but {$qty} requested."
                        ], JSON_PRETTY_PRINT);
                        exit;
                    }
                }
            }

            $itemTotal = round($unitPrice * $qty, 2);
            $subtotal += $itemTotal;
            $totalQty += $qty;

            $chosenColor = trim((string)($item['color'] ?? ($p['colors'][0] ?? $p['color'] ?? '')));
            $chosenSize = trim((string)($item['size'] ?? ($p['size'][0] ?? 'Free Size')));
            $reqVarId = !empty($item['variant_id']) ? (int)$item['variant_id'] : 0;

            // Resolve exact variant from DB variants array
            $matchedVariant = null;
            $variants = $p['variants'] ?? [];
            if ($reqVarId > 0) {
                foreach ($variants as $v) {
                    if ((int)($v['id'] ?? 0) === $reqVarId) {
                        $matchedVariant = $v;
                        break;
                    }
                }
            }
            if (!$matchedVariant && ($chosenColor !== '' || $chosenSize !== '')) {
                foreach ($variants as $v) {
                    if (strcasecmp($v['color'], $chosenColor) === 0 && strcasecmp($v['size'], $chosenSize) === 0) {
                        $matchedVariant = $v;
                        break;
                    }
                }
            }

            $varId = $matchedVariant ? (int)($matchedVariant['id'] ?? 0) : ($reqVarId > 0 ? $reqVarId : null);
            $itemSku = ($matchedVariant && !empty($matchedVariant['sku'])) ? $matchedVariant['sku'] : $p['sku'];
            $itemColor = $matchedVariant ? $matchedVariant['color'] : $chosenColor;
            $itemSize = $matchedVariant ? $matchedVariant['size'] : $chosenSize;

            $validatedItems[] = [
                'id' => $p['id'],
                'product_id' => $p['id'],
                'variant_id' => $varId,
                'product_type' => 'single_piece',
                'selling_type' => 'single_piece',
                'name' => $p['name'],
                'sku' => $itemSku,
                'image' => $p['image'],
                'color' => $itemColor,
                'size' => $itemSize,
                'lot_type' => 'single',
                'qty' => $qty,
                'quantity' => $qty,
                'pieces_count' => $qty,
                'unit_price' => $unitPrice,
                'subtotal' => $itemTotal,
                'total_price' => $itemTotal
            ];
        }
    }

    $discount = 0.0;
    $couponResult = ['valid' => false, 'discount' => 0.0, 'message' => ''];
    if (!empty($couponCode)) {
        $couponResult = DiscountEngine::applyCoupon($couponCode, $subtotal, null, $userType);
        if ($couponResult['valid']) {
            $discount = (float)$couponResult['discount'];
        }
    }

    // Freight came from two different hardcoded thresholds: the charge was
    // waived above 999 while the free_shipping flag reported above 2999, and
    // config/shipping.php — the file that actually documents the rule — was
    // read by nobody. One source now, so the cart, the checkout summary and the
    // "free shipping" notice cannot disagree.
    $shipCfgFile = __DIR__ . '/../config/shipping.php';
    $shipCfg = is_file($shipCfgFile) ? require $shipCfgFile : [];
    if (!is_array($shipCfg)) { $shipCfg = []; }
    $shipRate = max(0.0, (float)($shipCfg['standard_rate'] ?? 150.0));
    $shipFreeAt = max(0.0, (float)($shipCfg['free_shipping_threshold'] ?? 0.0));
    $qualifiesFree = ($shipFreeAt > 0 && $subtotal >= $shipFreeAt);
    $shipping = ($subtotal <= 0.0 || $qualifiesFree) ? 0.0 : $shipRate;
    $calc = PricingCalculator::calculateOrderTotal($subtotal, $discount, $shipping, 5.0);


    echo json_encode([
        'success' => true,
        'user_type' => $userType,
        'item_count' => count($validatedItems),
        'total_qty' => $totalQty,
        'items' => $validatedItems,
        'cart' => $validatedItems,
        'pricing' => $calc,
        'free_shipping' => $qualifiesFree,
        'free_shipping_threshold' => $shipFreeAt,
        'shipping_rate' => $shipRate
    ], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
