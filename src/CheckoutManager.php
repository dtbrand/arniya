<?php
namespace DTBrand;

use PDO;
use Exception;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ProductCatalog.php';
require_once __DIR__ . '/PricingCalculator.php';
require_once __DIR__ . '/DiscountEngine.php';
require_once __DIR__ . '/CartManager.php';
require_once __DIR__ . '/OrderManager.php';
require_once __DIR__ . '/PaymentManager.php';
require_once __DIR__ . '/Money.php';
require_once __DIR__ . '/Auth.php';

/**
 * CheckoutManager — Authoritative 14-Step Enterprise Checkout Pipeline
 * Master Specification V2: Section 46 (Checkout Audit)
 * 
 * The 14-Step Flow:
 *  1. Cart Validation
 *  2. Login / Guest Eligibility
 *  3. Address & Contact Validation
 *  4. Product Validation (Active & Catalog Integrity)
 *  5. Variant Validation (Active Variant & Variant Inventory)
 *  6. Role Validation (Session-Authoritative Resolution)
 *  7. Product Type Validation (Single Piece vs Full Set)
 *  8. Price Recalculation (Authoritative Role-Based Price Engine)
 *  9. Discount Validation (Coupon Engine Verification)
 * 10. Shipping Calculation (Authoritative Freight Engine)
 * 11. Total Calculation (Money-Engine Integer Arithmetic)
 * 12. Order Creation (Idempotent & Transactional DB Recording)
 * 13. Payment Initiation (Gateway Intent / Dynamic QR / PG Payload)
 * 14. Confirmation & Order Summary Payload
 *
 * DT Brand's & Jai Hanuman Tex
 */
class CheckoutManager
{
    /**
     * Authoritatively process an incoming checkout submission through the 14-step pipeline
     *
     * @param array $payload Incoming checkout request data
     * @param string|null $idempotencyKey Optional idempotency key for deduplication
     * @return array Standardized checkout result payload
     */
    public static function processCheckout(array $payload, ?string $idempotencyKey = null): array
    {
        Auth::initSession();

        // ── STEP 1: CART EXTRACTION & BASIC INTEGRITY ──
        $rawItems = $payload['items'] ?? ($payload['cart'] ?? []);
        if (is_string($rawItems)) {
            $rawItems = json_decode($rawItems, true) ?: [];
        }
        if (!is_array($rawItems) || empty($rawItems)) {
            return [
                'success' => false,
                'step'    => 1,
                'error'   => 'Cart is empty. Please add products to your bag before proceeding to checkout.'
            ];
        }

        // ── STEP 2: SESSION-AUTHORITATIVE ROLE & ELIGIBILITY ──
        $currentUser = Auth::getCurrentUser();
        $isAdmin = Auth::isAdminLoggedIn();
        $rawRole = strtolower(trim((string)($payload['channel'] ?? ($payload['user_type'] ?? ''))));

        $resolvedRole = 'guest';
        if ($isAdmin) {
            $resolvedRole = in_array($rawRole, ['wholesale', 'retailer', 'reseller', 'customer'], true) ? $rawRole : 'wholesale';
        } elseif (!empty($currentUser['id'])) {
            $db = Database::getConnection();
            $dbRole = 'customer';
            if ($db && !Database::isMockMode()) {
                try {
                    $uStmt = $db->prepare("SELECT type, status FROM customers WHERE id = ? LIMIT 1");
                    $uStmt->execute([(int)$currentUser['id']]);
                    $uRow = $uStmt->fetch(PDO::FETCH_ASSOC);
                    if ($uRow && ($uRow['status'] ?? '') === 'active') {
                        $dbRole = strtolower(trim((string)$uRow['type']));
                    }
                } catch (\Throwable $e) {}
            }
            if ($dbRole === 'wholesaler') { $dbRole = 'wholesale'; }
            if ($dbRole === 'retail' || $dbRole === '') { $dbRole = 'customer'; }
            $resolvedRole = in_array($dbRole, ['wholesale', 'retailer', 'reseller'], true) ? $dbRole : 'customer';
        }

        $isTradeUser = in_array($resolvedRole, ['wholesale', 'retailer'], true);

        // ── STEP 3: ADDRESS & CONTACT VALIDATION ──
        $addressValidation = self::validateShippingAddress($payload);
        if (!$addressValidation['valid']) {
            return [
                'success' => false,
                'step'    => 3,
                'error'   => $addressValidation['message'],
                'field'   => $addressValidation['field'] ?? null
            ];
        }
        $validAddress = $addressValidation['data'];

        // ── STEP 4 to 8: CART VALIDATION, PRODUCT/VARIANT CHECKS & PRICE RECALCULATION ──
        $couponCode = trim((string)($payload['coupon'] ?? ($payload['coupon_code'] ?? '')));
        $gstRate = isset($payload['gst_rate']) ? (float)$payload['gst_rate'] : 5.0;

        $cartAudit = CartManager::validateAndRecalculateCart($rawItems, $resolvedRole, $couponCode, $gstRate);

        if (!$cartAudit['success'] || !empty($cartAudit['errors'])) {
            return [
                'success' => false,
                'step'    => 4,
                'error'   => implode(' ', $cartAudit['errors']),
                'errors'  => $cartAudit['errors']
            ];
        }

        $validatedItems = $cartAudit['items'];
        if (empty($validatedItems)) {
            return [
                'success' => false,
                'step'    => 4,
                'error'   => 'No valid purchasable items found in your checkout bag.'
            ];
        }

        // ── STEP 9 to 11: FINANCIALS (DISCOUNT, SHIPPING & TOTALS) ──
        $subtotal = $cartAudit['subtotal'];
        $discount = $cartAudit['discount'];
        $shipping = $cartAudit['shipping'];
        $grandTotal = $cartAudit['grand_total'];
        $gstAmount = $cartAudit['gst_amount'];

        // ── STEP 12: TRANSACTIONAL ORDER CREATION & IDEMPOTENCY ──
        $cleanIdempotencyKey = !empty($idempotencyKey) ? trim((string)$idempotencyKey) : trim((string)($payload['idempotency_key'] ?? ''));
        if (empty($cleanIdempotencyKey)) {
            $hdrKey = $_SERVER['HTTP_IDEMPOTENCY_KEY'] ?? ($_SERVER['HTTP_X_IDEMPOTENCY_KEY'] ?? '');
            $cleanIdempotencyKey = trim((string)$hdrKey);
        }

        $paymentMethod = trim((string)($payload['payment_method'] ?? 'direct_upi'));
        $paymentStatus = in_array($paymentMethod, ['cod']) ? 'pending' : 'pending';

        $orderPayload = [
            'idempotency_key'    => $cleanIdempotencyKey ?: null,
            'customer_id'        => !empty($currentUser['id']) ? (int)$currentUser['id'] : 0,
            'customer_name'      => $validAddress['customer_name'],
            'customer_phone'     => $validAddress['customer_phone'],
            'customer_email'     => $validAddress['customer_email'],
            'shipping_address'   => $validAddress['full_address'],
            'shipping_city'      => $validAddress['shipping_city'],
            'shipping_state'     => $validAddress['shipping_state'],
            'shipping_pincode'   => $validAddress['shipping_pincode'],
            'channel'            => $resolvedRole,
            'is_trade_order'     => $isTradeUser,
            'items'              => $validatedItems,
            'subtotal'           => $subtotal,
            'discount'           => $discount,
            'coupon_code'        => $couponCode,
            'shipping'           => $shipping,
            'gst_rate'           => $gstRate,
            'gst_amount'         => $gstAmount,
            'total_amount'       => $grandTotal,
            'payment_method'     => $paymentMethod,
            'payment_status'     => $paymentStatus,
            'fulfillment_status' => 'processing'
        ];

        $orderResult = OrderManager::createOrder($orderPayload);
        if (empty($orderResult['success'])) {
            return [
                'success' => false,
                'step'    => 12,
                'error'   => $orderResult['message'] ?? 'Failed to record order transaction in database.',
                'db_error'=> $orderResult['db_error'] ?? null
            ];
        }

        $orderNumber = $orderResult['order_number'];
        $orderId = $orderResult['id'];

        // ── STEP 13: PAYMENT INITIATION ──
        $paymentPayload = null;
        if ($paymentMethod === 'direct_upi') {
            $paymentPayload = PaymentManager::generateUpiPayload($orderNumber, $grandTotal, $validAddress['customer_name']);
        } elseif ($paymentMethod === 'razorpay') {
            $rzpRes = PaymentManager::createRazorpayOrder($orderNumber, $grandTotal, $validAddress['customer_email'], $validAddress['customer_phone']);
            if ($rzpRes['success']) {
                $paymentPayload = $rzpRes;
            }
        } elseif ($paymentMethod === 'cashfree') {
            $cfRes = PaymentManager::createCashfreeOrder($orderNumber, $grandTotal, $validAddress['customer_phone'], $validAddress['customer_name'], $validAddress['customer_email']);
            if ($cfRes['success']) {
                $paymentPayload = $cfRes;
            }
        }

        // ── STEP 14: CONFIRMATION & STRUCTURED RETURN ──
        return [
            'success'            => true,
            'step'               => 14,
            'order_id'           => $orderId,
            'order_number'       => $orderNumber,
            'customer_name'      => $validAddress['customer_name'],
            'customer_phone'     => $validAddress['customer_phone'],
            'customer_email'     => $validAddress['customer_email'],
            'shipping_address'   => $validAddress['full_address'],
            'channel'            => $resolvedRole,
            'payment_method'     => $paymentMethod,
            'payment_status'     => $paymentStatus,
            'items_count'        => count($validatedItems),
            'total_pieces'       => $cartAudit['total_physical_pieces'],
            'pricing'            => $cartAudit['pricing'],
            'subtotal'           => $subtotal,
            'discount'           => $discount,
            'shipping'           => $shipping,
            'gst_amount'         => $gstAmount,
            'grand_total'        => $grandTotal,
            'payment_payload'    => $paymentPayload,
            'idempotency_key'    => $cleanIdempotencyKey ?: null,
            'reused_session'     => !empty($orderResult['reused']),
            'message'            => 'Order verified and securely placed through the 14-step checkout pipeline.'
        ];
    }

    /**
     * Validate and normalize customer delivery address and contact information
     */
    public static function validateShippingAddress(array $payload): array
    {
        $name = trim((string)($payload['customer_name'] ?? ($payload['name'] ?? '')));
        if (mb_strlen($name) < 2) {
            return ['valid' => false, 'message' => 'Please provide a valid recipient name (minimum 2 characters).', 'field' => 'customer_name'];
        }

        $phone = trim((string)($payload['customer_phone'] ?? ($payload['phone'] ?? '')));
        $cleanPhone = preg_replace('/[^\d]/', '', $phone);
        if (strlen($cleanPhone) < 10) {
            return ['valid' => false, 'message' => 'Please enter a valid 10-digit mobile number for order updates and tracking.', 'field' => 'customer_phone'];
        }
        $normalizedPhone = substr($cleanPhone, -10);

        $email = trim((string)($payload['customer_email'] ?? ($payload['email'] ?? '')));
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['valid' => false, 'message' => 'Please enter a valid email address or leave it blank.', 'field' => 'customer_email'];
        }

        $address = trim((string)($payload['shipping_address'] ?? ($payload['address'] ?? '')));
        if (mb_strlen($address) < 5) {
            return ['valid' => false, 'message' => 'Please enter your complete street address (flat, building, area).', 'field' => 'shipping_address'];
        }

        $city = trim((string)($payload['shipping_city'] ?? ($payload['city'] ?? '')));
        if (mb_strlen($city) < 2) {
            return ['valid' => false, 'message' => 'Please enter your city / town name.', 'field' => 'shipping_city'];
        }

        $state = trim((string)($payload['shipping_state'] ?? ($payload['state'] ?? '')));
        if (mb_strlen($state) < 2) {
            return ['valid' => false, 'message' => 'Please select or enter your state.', 'field' => 'shipping_state'];
        }

        $pincode = trim((string)($payload['shipping_pincode'] ?? ($payload['pincode'] ?? '')));
        $cleanPin = preg_replace('/[^\d]/', '', $pincode);
        if (!preg_match('/^[1-9][0-9]{5}$/', $cleanPin)) {
            return ['valid' => false, 'message' => 'Please enter a valid 6-digit Indian Postal PIN Code.', 'field' => 'shipping_pincode'];
        }

        $fullAddress = "{$address}, {$city}, {$state} - {$cleanPin}";

        return [
            'valid' => true,
            'data'  => [
                'customer_name'    => $name,
                'customer_phone'   => $normalizedPhone,
                'customer_email'   => $email,
                'shipping_address' => $address,
                'shipping_city'    => $city,
                'shipping_state'   => $state,
                'shipping_pincode' => $cleanPin,
                'full_address'     => $fullAddress
            ]
        ];
    }
}
