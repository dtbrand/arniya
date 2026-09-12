<?php
namespace DTBrand;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ProductCatalog.php';
require_once __DIR__ . '/PricingCalculator.php';
require_once __DIR__ . '/DiscountEngine.php';
require_once __DIR__ . '/Money.php';
require_once __DIR__ . '/Auth.php';

/**
 * CartManager — Authoritative Server-Side Cart Audit & Calculation Engine
 * Master Specification V2: Section 44 (Cart Audit)
 * 
 * Rules:
 * 1. Cart is NEVER the authoritative financial source — every price, discount, tax, and total is recomputed server-side.
 * 2. Stale, drafted, deleted or out-of-stock products are rejected with clear error reports.
 * 3. Disabled variants or requested quantities exceeding available inventory are flagged.
 * 4. Full Set products are strictly restricted to verified Retailer and Wholesaler accounts.
 * 5. Wholesaler Single Piece orders MUST strictly adhere to MCQ (Available Colors × Available Sizes).
 * 6. All monetary calculations are performed in integer paise using Money to prevent floating-point drift.
 *
 * DT Brand's & Jai Hanuman Tex
 */
class CartManager
{
    /**
     * Authoritatively validate and recalculate a cart bag
     *
     * @param array $rawItems Raw items submitted by the browser
     * @param string $userRole Session-authoritative user role
     * @param string|null $couponCode Optional coupon code
     * @param float $gstRate Applicable GST rate (default 5.0%)
     * @return array Authoritative cart payload with validated items and exact financial breakdown
     */
    public static function validateAndRecalculateCart(
        array $rawItems,
        string $userRole = 'guest',
        ?string $couponCode = null,
        float $gstRate = 5.0
    ): array {
        // Normalize user role
        $role = strtolower(trim($userRole));
        if ($role === 'wholesaler') { $role = 'wholesale'; }
        if ($role === 'retail' || $role === '') { $role = 'customer'; }
        $isTradeUser = in_array($role, ['wholesale', 'retailer'], true);

        $validatedItems = [];
        $errors = [];
        $warnings = [];
        $subtotalMoney = Money::zero();
        $totalPhysicalPieces = 0;
        $allValid = true;

        foreach ($rawItems as $index => $item) {
            $pid = (int)($item['id'] ?? ($item['product_id'] ?? 0));
            $requestedQty = max(1, (int)($item['qty'] ?? ($item['quantity'] ?? 1)));
            $lotType = strtolower(trim((string)($item['lot_type'] ?? 'single')));

            if ($pid <= 0) {
                $errors[] = "Line item #" . ($index + 1) . ": Invalid or missing product ID.";
                $allValid = false;
                continue;
            }

            // 1. Look up live product from database
            $p = ProductCatalog::getById($pid);
            if (!$p) {
                $errors[] = "Product ID #{$pid} is no longer available in the catalogue.";
                $allValid = false;
                continue;
            }

            // 2. Check product status (stale / draft / inactive / deleted handling)
            $productStatus = strtolower((string)($p['status'] ?? 'active'));
            if ($productStatus !== 'active') {
                $errors[] = "'{$p['name']}' is currently unavailable ({$productStatus}). Please remove it from your cart.";
                $allValid = false;
                continue;
            }

            // 3. Check live product inventory stock
            $productStock = (int)($p['stock_qty'] ?? ($p['stock_quantity'] ?? 0));
            if ($productStock <= 0) {
                $errors[] = "'{$p['name']}' is currently out of stock.";
                $allValid = false;
                continue;
            }

            $pSellingType = trim((string)($p['selling_type'] ?? 'single_piece')) ?: 'single_piece';
            $isFullSet = ($pSellingType === 'full_set' || $lotType === 'full_set');

            if ($isFullSet) {
                // 4. Full Set Role Security: Strictly Wholesaler or Retailer only
                if (!$isTradeUser) {
                    $errors[] = "Full Set product '{$p['name']}' is exclusively available to verified Retailer and Wholesaler trade accounts.";
                    $allValid = false;
                    continue;
                }

                // Authoritative Unit Price for Full Set
                $unitPrice = ProductCatalog::resolvePrice($p, $role);
                $variants = $p['full_set_variants'] ?? $p['variants'] ?? [];
                $fullSetPieces = max(1, count($variants));
                $physicalQty = $fullSetPieces * $requestedQty;

                // Check physical stock for full set
                if ($physicalQty > $productStock) {
                    $errors[] = "Requested {$requestedQty} Full Set(s) ({$physicalQty} pieces) for '{$p['name']}', but only {$productStock} pieces are available in stock.";
                    $allValid = false;
                    continue;
                }

                $setPriceMoney = Money::fromFloat($unitPrice)->multiply($fullSetPieces);
                $lineTotalMoney = $setPriceMoney->multiply($requestedQty);
                $subtotalMoney = $subtotalMoney->add($lineTotalMoney);
                $totalPhysicalPieces += $physicalQty;

                $validatedItems[] = [
                    'id'                  => $p['id'],
                    'product_id'          => $p['id'],
                    'variant_id'          => null,
                    'product_type'        => 'full_set',
                    'selling_type'        => 'full_set',
                    'name'                => $p['name'],
                    'sku'                 => $p['sku'],
                    'image'               => $p['image'],
                    'lot_type'            => 'full_set',
                    'full_set_pieces'     => $fullSetPieces,
                    'color'               => 'All Configured Colors (' . count($p['colors']) . ')',
                    'size'                => 'All Configured Sizes (' . count($p['sizes']) . ')',
                    'qty'                 => $requestedQty,
                    'quantity'            => $requestedQty,
                    'pieces_count'        => $physicalQty,
                    'unit_price'          => $unitPrice,
                    'set_price'           => $setPriceMoney->toFloat(),
                    'subtotal'            => $lineTotalMoney->toFloat(),
                    'total_price'         => $lineTotalMoney->toFloat(),
                    'is_valid'            => true,
                    'in_stock'            => true,
                    'stock_available'     => $productStock,
                    'error'               => null
                ];
            } else {
                // 5. Single Piece Role Pricing
                $unitPrice = ProductCatalog::resolvePrice($p, $role);

                // 6. Wholesaler MCQ Validation for Single Piece
                if ($role === 'wholesale') {
                    $mcqResult = ProductCatalog::calculateWholesalerMcq($p);
                    $requiredMcq = (int)($mcqResult['mcq'] ?? 0);
                    $colorsCount = (int)($mcqResult['color_count'] ?? 0);
                    $sizesCount = (int)($mcqResult['size_count'] ?? 0);

                    if ($requiredMcq > 0) {
                        if ($requestedQty < $requiredMcq || ($requestedQty % $requiredMcq !== 0)) {
                            $errors[] = "Wholesale MCQ for '{$p['name']}' requires ordering in full lot multiples of {$requiredMcq} pieces ({$colorsCount} Colours × {$sizesCount} Sizes), but {$requestedQty} requested.";
                            $allValid = false;
                            continue;
                        }
                    }
                }

                // 7. Variant Validation & Stock Check
                $chosenColor = trim((string)($item['color'] ?? ($p['colors'][0] ?? $p['color'] ?? '')));
                $chosenSize  = trim((string)($item['size'] ?? ($p['size'][0] ?? 'Free Size')));
                $reqVarId    = !empty($item['variant_id']) ? (int)$item['variant_id'] : 0;

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
                        if (strcasecmp((string)($v['color'] ?? ''), $chosenColor) === 0 && strcasecmp((string)($v['size'] ?? ''), $chosenSize) === 0) {
                            $matchedVariant = $v;
                            break;
                        }
                    }
                }

                // Check disabled variant status if variant was matched
                if ($matchedVariant) {
                    $vStatus = strtolower((string)($matchedVariant['status'] ?? 'active'));
                    if ($vStatus !== 'active') {
                        $errors[] = "Selected variant ({$chosenColor} / {$chosenSize}) for '{$p['name']}' is disabled or unavailable.";
                        $allValid = false;
                        continue;
                    }
                    $vStock = isset($matchedVariant['stock_qty']) ? (int)$matchedVariant['stock_qty'] : $productStock;
                    if ($vStock <= 0) {
                        $errors[] = "Selected variant ({$chosenColor} / {$chosenSize}) for '{$p['name']}' is out of stock.";
                        $allValid = false;
                        continue;
                    }
                    if ($requestedQty > $vStock) {
                        $errors[] = "Requested {$requestedQty} of '{$p['name']}' ({$chosenColor} / {$chosenSize}), but only {$vStock} available.";
                        $allValid = false;
                        continue;
                    }
                } else {
                    // Check general product stock
                    if ($requestedQty > $productStock) {
                        $errors[] = "Requested {$requestedQty} of '{$p['name']}', but only {$productStock} available in stock.";
                        $allValid = false;
                        continue;
                    }
                }

                $varId = $matchedVariant ? (int)($matchedVariant['id'] ?? 0) : ($reqVarId > 0 ? $reqVarId : null);
                $itemSku = ($matchedVariant && !empty($matchedVariant['sku'])) ? $matchedVariant['sku'] : $p['sku'];
                $itemColor = $matchedVariant ? ($matchedVariant['color'] ?? $chosenColor) : $chosenColor;
                $itemSize = $matchedVariant ? ($matchedVariant['size'] ?? $chosenSize) : $chosenSize;

                $lineTotalMoney = Money::fromFloat($unitPrice)->multiply($requestedQty);
                $subtotalMoney = $subtotalMoney->add($lineTotalMoney);
                $totalPhysicalPieces += $requestedQty;

                $validatedItems[] = [
                    'id'              => $p['id'],
                    'product_id'      => $p['id'],
                    'variant_id'      => $varId,
                    'product_type'    => 'single_piece',
                    'selling_type'    => 'single_piece',
                    'name'            => $p['name'],
                    'sku'             => $itemSku,
                    'image'           => $p['image'],
                    'color'           => $itemColor,
                    'size'            => $itemSize,
                    'lot_type'        => 'single',
                    'qty'             => $requestedQty,
                    'quantity'        => $requestedQty,
                    'pieces_count'    => $requestedQty,
                    'unit_price'      => $unitPrice,
                    'subtotal'        => $lineTotalMoney->toFloat(),
                    'total_price'     => $lineTotalMoney->toFloat(),
                    'is_valid'        => true,
                    'in_stock'        => true,
                    'stock_available' => $productStock,
                    'error'           => null
                ];
            }
        }

        // 8. Server-Side Authoritative Coupon Discount Calculation
        $discountMoney = Money::zero();
        $couponMessage = '';
        $couponValid = false;

        $cleanCoupon = strtoupper(trim((string)$couponCode));
        if ($cleanCoupon !== '' && $subtotalMoney->toPaise() > 0) {
            $couponResult = DiscountEngine::applyCoupon($cleanCoupon, $subtotalMoney->toFloat(), null, $role);
            if (!empty($couponResult['valid'])) {
                $discountMoney = Money::fromFloat((float)($couponResult['discount'] ?? 0.0));
                $couponValid = true;
                $couponMessage = $couponResult['message'] ?? 'Coupon applied successfully.';
            } else {
                $couponMessage = $couponResult['message'] ?? 'Invalid coupon code.';
                $warnings[] = $couponMessage;
            }
        }

        // 9. Shipping Freight Calculation (from config/shipping.php)
        $shipCfgFile = dirname(__DIR__) . '/config/shipping.php';
        $shipCfg = is_file($shipCfgFile) ? require $shipCfgFile : [];
        if (!is_array($shipCfg)) { $shipCfg = []; }

        $shipRate = max(0.0, (float)($shipCfg['standard_rate'] ?? 150.0));
        $shipFreeAt = max(0.0, (float)($shipCfg['free_shipping_threshold'] ?? 0.0));
        $qualifiesFree = ($shipFreeAt > 0 && $subtotalMoney->toFloat() >= $shipFreeAt);
        $shippingRate = ($subtotalMoney->toPaise() <= 0 || $qualifiesFree) ? 0.0 : $shipRate;
        $shippingMoney = Money::fromFloat($shippingRate);

        // 10. Grand Total Calculation via PricingCalculator / Money
        $pricing = PricingCalculator::calculateOrderTotal(
            $subtotalMoney->toFloat(),
            $discountMoney->toFloat(),
            $shippingMoney->toFloat(),
            $gstRate
        );

        return [
            'success'                 => $allValid && empty($errors),
            'user_role'               => $role,
            'is_trade_user'           => $isTradeUser,
            'item_count'              => count($validatedItems),
            'total_physical_pieces'   => $totalPhysicalPieces,
            'items'                   => $validatedItems,
            'cart'                    => $validatedItems,
            'pricing'                 => $pricing,
            'subtotal'                => $subtotalMoney->toFloat(),
            'discount'                => $discountMoney->toFloat(),
            'shipping'                => $shippingMoney->toFloat(),
            'gst_rate'                => $gstRate,
            'gst_amount'              => (float)($pricing['gst_amount'] ?? 0.0),
            'grand_total'             => (float)($pricing['grand_total'] ?? $subtotalMoney->toFloat()),
            'coupon_info'             => [
                'code'    => $cleanCoupon,
                'valid'   => $couponValid,
                'message' => $couponMessage,
                'amount'  => $discountMoney->toFloat()
            ],
            'shipping_info'           => [
                'standard_rate' => $shipRate,
                'free_at'       => $shipFreeAt,
                'is_free'       => $qualifiesFree
            ],
            'errors'                  => $errors,
            'warnings'                => $warnings
        ];
    }
}
