<?php
namespace DTBrand;

use PDO;
use Exception;

/**
 * PaymentManager — Unified Enterprise Payment Processing & Audit Engine
 * Supports: Instant UPI Deep Linking & Dynamic QR Studio, Razorpay PG, Cashfree PG, COD & WhatsApp Pay
 * DT Brand's & Jai Hanuman Tex
 */
class PaymentManager
{
    private static ?array $cachedGateways = null;

    /**
     * Get all configured gateways from DB with default fallbacks
     */
    public static function getAllGateways(bool $onlyActive = false): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return self::getDefaultGateways($onlyActive);
        }

        try {
            $sql = "SELECT * FROM `payment_gateways` " . ($onlyActive ? "WHERE `is_active` = 1 " : "") . "ORDER BY `sort_order` ASC, `id` ASC";
            $stmt = $db->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($rows)) {
                return self::getDefaultGateways($onlyActive);
            }

            $gateways = [];
            foreach ($rows as $r) {
                $config = json_decode($r['config_json'] ?? '{}', true) ?: [];
                $gateways[$r['gateway_key']] = [
                    'id'             => (int)$r['id'],
                    'gateway_key'    => $r['gateway_key'],
                    'name'           => $r['name'],
                    'description'    => $r['description'],
                    'is_active'      => (bool)$r['is_active'],
                    'is_test_mode'   => (bool)$r['is_test_mode'],
                    'is_recommended' => (bool)$r['is_recommended'],
                    'sort_order'     => (int)$r['sort_order'],
                    'config'         => $config,
                    'updated_at'     => $r['updated_at'] ?? date('Y-m-d H:i:s')
                ];
            }
            return $gateways;
        } catch (\Throwable $e) {
            error_log("PaymentManager::getAllGateways error: " . $e->getMessage());
            return self::getDefaultGateways($onlyActive);
        }
    }

    /**
     * Get single gateway by key
     */
    public static function getGateway(string $key): ?array
    {
        $all = self::getAllGateways(false);
        return $all[$key] ?? null;
    }

    /**
     * Get safe public configuration payload for Storefront Checkout
     */
    public static function getPublicConfig(): array
    {
        $gateways = self::getAllGateways(true);
        $publicList = [];

        foreach ($gateways as $k => $g) {
            $cfg = $g['config'] ?? [];
            $safeCfg = [];

            switch ($k) {
                case 'direct_upi':
                    $safeCfg = [
                        'upi_vpa'       => $cfg['upi_vpa'] ?? '917046363528@okaxis',
                        'upi_name'      => $cfg['upi_name'] ?? "DT Brand's & Jai Hanuman Tex",
                        'backup_vpa'    => $cfg['backup_vpa'] ?? 'dtbrands@icici',
                        'mcc'           => $cfg['mcc'] ?? '5691',
                        'auto_open_app' => !empty($cfg['auto_open_app']),
                        'dynamic_qr'    => !empty($cfg['dynamic_qr']),
                        'require_utr'   => !empty($cfg['require_utr'])
                    ];
                    break;
                case 'razorpay':
                    $safeCfg = [
                        'key_id'       => $cfg['key_id'] ?? (getenv('RAZORPAY_KEY_ID') ?: ''),
                        'is_test'      => !empty($g['is_test_mode']),
                        'theme_color'  => $cfg['theme_color'] ?? '#8A681F',
                        'auto_capture' => !empty($cfg['auto_capture'])
                    ];
                    break;
                case 'cashfree':
                    $safeCfg = [
                        'app_id'      => $cfg['app_id'] ?? '',
                        'is_test'     => !empty($g['is_test_mode']),
                        'theme_color' => $cfg['theme_color'] ?? '#8A681F'
                    ];
                    break;
                case 'cod':
                    $safeCfg = [
                        'handling_fee'    => (float)($cfg['handling_fee'] ?? 0),
                        'min_order'       => (float)($cfg['min_order'] ?? 299),
                        'max_order'       => (float)($cfg['max_order'] ?? 25000),
                        'verify_otp'      => !empty($cfg['verify_otp']),
                        'partial_deposit' => (float)($cfg['partial_deposit'] ?? 0)
                    ];
                    break;
                case 'whatsapp_pay':
                    $safeCfg = [
                        'phone'         => $cfg['phone'] ?? '917046363528',
                        'auto_upi_link' => !empty($cfg['auto_upi_link']),
                        'welcome_msg'   => $cfg['welcome_msg'] ?? "Namaste! I would like to place an order from DT Brand's."
                    ];
                    break;
            }

            $publicList[$k] = [
                'gateway_key'    => $k,
                'name'           => $g['name'],
                'description'    => $g['description'],
                'is_recommended' => $g['is_recommended'],
                'sort_order'     => $g['sort_order'],
                'config'         => $safeCfg
            ];
        }

        return $publicList;
    }

    /**
     * Generate Instant Direct UPI Deep Link & QR string
     */
    public static function generateUpiPayload(string $orderNumber, float $amount, string $customerName = ''): array
    {
        $upiGate = self::getGateway('direct_upi');
        $cfg = $upiGate['config'] ?? [];

        $vpa = trim((string)($cfg['upi_vpa'] ?? '917046363528@okaxis'));
        $payeeName = trim((string)($cfg['upi_name'] ?? 'DT Brands Jai Hanuman Tex'));
        $mcc = trim((string)($cfg['mcc'] ?? '5691'));
        $note = "Order " . $orderNumber . ($customerName ? " - " . substr($customerName, 0, 15) : "");
        $amtFormatted = number_format($amount, 2, '.', '');

        // Standard NPCI UPI URI Specification
        $params = [
            'pa' => $vpa,
            'pn' => $payeeName,
            'mc' => $mcc,
            'tr' => $orderNumber,
            'tn' => $note,
            'am' => $amtFormatted,
            'cu' => 'INR'
        ];

        $upiUri = "upi://pay?" . http_build_query($params);

        // Dedicated app deep links
        $gpayUri = "gpay://upi/pay?" . http_build_query($params);
        $phonepeUri = "phonepe://pay?" . http_build_query($params);
        $paytmUri = "paytmmp://pay?" . http_build_query($params);
        $credUri = "cred://upi/pay?" . http_build_query($params);
        $bhimUri = "bhim://pay?" . http_build_query($params);

        return [
            'order_number'    => $orderNumber,
            'amount'          => $amount,
            'amount_fmt'      => '₹' . number_format($amount, 2),
            'upi_vpa'         => $vpa,
            'payee_name'      => $payeeName,
            'upi_uri'         => $upiUri,
            'qr_data'         => $upiUri,
            'app_links'       => [
                'generic' => $upiUri,
                'gpay'    => $gpayUri,
                'phonepe' => $phonepeUri,
                'paytm'   => $paytmUri,
                'cred'    => $credUri,
                'bhim'    => $bhimUri
            ]
        ];
    }

    /**
     * Create Razorpay Standard Order
     */
    public static function createRazorpayOrder(string $orderNumber, float $amount, string $customerEmail = '', string $customerPhone = ''): array
    {
        $rzpGate = self::getGateway('razorpay');
        $cfg = $rzpGate['config'] ?? [];

        $keyId = trim((string)($cfg['key_id'] ?? (getenv('RAZORPAY_KEY_ID') ?: '')));
        $keySecret = trim((string)($cfg['key_secret'] ?? (getenv('RAZORPAY_KEY_SECRET') ?: '')));

        if (empty($keyId) || empty($keySecret)) {
            return [
                'success' => false,
                'error'   => 'Razorpay API credentials not configured.'
            ];
        }

        $amountInPaise = (int)round($amount * 100);
        $payload = [
            'amount'          => $amountInPaise,
            'currency'        => 'INR',
            'receipt'         => $orderNumber,
            'payment_capture' => !empty($cfg['auto_capture']) ? 1 : 1,
            'notes'           => [
                'order_number' => $orderNumber,
                'store'        => "DT Brand's & Jai Hanuman Tex"
            ]
        ];

        $ch = curl_init('https://api.razorpay.com/v1/orders');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_USERPWD        => $keyId . ':' . $keySecret,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 15
        ]);

        $res = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode((string)$res, true) ?: [];

        if ($httpCode >= 200 && $httpCode < 300 && !empty($json['id'])) {
            return [
                'success'          => true,
                'gateway_order_id' => $json['id'],
                'amount_paise'     => $json['amount'],
                'currency'         => $json['currency'],
                'key_id'           => $keyId
            ];
        }

        return [
            'success' => false,
            'error'   => $json['error']['description'] ?? 'Failed to initialize Razorpay order.'
        ];
    }

    /**
     * Verify Razorpay payment signature
     */
    public static function verifyRazorpaySignature(string $orderId, string $paymentId, string $signature): bool
    {
        $rzpGate = self::getGateway('razorpay');
        $cfg = $rzpGate['config'] ?? [];
        $keySecret = trim((string)($cfg['key_secret'] ?? (getenv('RAZORPAY_KEY_SECRET') ?: '')));

        if (empty($keySecret)) {
            return false;
        }

        $expected = hash_hmac('sha256', $orderId . '|' . $paymentId, $keySecret);
        return hash_equals($expected, $signature);
    }

    /**
     * Create Cashfree Order
     */
    public static function createCashfreeOrder(string $orderNumber, float $amount, string $customerPhone, string $customerName = 'Customer', string $customerEmail = 'customer@dtbrands.com'): array
    {
        $cfGate = self::getGateway('cashfree');
        $cfg = $cfGate['config'] ?? [];

        $appId = trim((string)($cfg['app_id'] ?? ''));
        $secretKey = trim((string)($cfg['secret_key'] ?? ''));
        $isTest = !empty($cfGate['is_test_mode']);

        if (empty($appId) || empty($secretKey)) {
            return [
                'success' => false,
                'error'   => 'Cashfree API credentials not configured.'
            ];
        }

        $baseUrl = $isTest ? 'https://sandbox.cashfree.com/pg' : 'https://api.cashfree.com/pg';
        $payload = [
            'order_id'       => $orderNumber . '_' . time(),
            'order_amount'   => (float)number_format($amount, 2, '.', ''),
            'order_currency' => 'INR',
            'customer_details' => [
                'customer_id'    => 'CUST_' . preg_replace('/[^0-9]/', '', $customerPhone ?: '0000000000'),
                'customer_name'  => $customerName ?: 'Customer',
                'customer_phone' => preg_replace('/[^0-9]/', '', $customerPhone ?: '9999999999'),
                'customer_email' => $customerEmail ?: 'guest@jaihanumantex.in'
            ],
            'order_meta' => [
                'return_url' => 'https://jaihanumantex.in/checkout.php?status=success&order_id={order_id}'
            ]
        ];

        $ch = curl_init($baseUrl . '/orders');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'x-client-id: ' . $appId,
                'x-client-secret: ' . $secretKey,
                'x-api-version: 2023-08-01'
            ],
            CURLOPT_TIMEOUT        => 15
        ]);

        $res = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $json = json_decode((string)$res, true) ?: [];

        if ($httpCode >= 200 && $httpCode < 300 && !empty($json['payment_session_id'])) {
            return [
                'success'            => true,
                'payment_session_id' => $json['payment_session_id'],
                'cf_order_id'        => $json['order_id'] ?? '',
                'environment'        => $isTest ? 'sandbox' : 'production'
            ];
        }

        return [
            'success' => false,
            'error'   => $json['message'] ?? 'Failed to initialize Cashfree payment session.'
        ];
    }

    /**
     * Record payment transaction in audit log
     */
    public static function recordTransaction(array $data): int
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return 1;
        }

        try {
            $stmt = $db->prepare("
                INSERT INTO `payment_transactions` (
                    `order_id`, `order_number`, `customer_id`, `customer_name`, `customer_phone`,
                    `gateway`, `payment_method`, `amount`, `currency`, `status`,
                    `gateway_order_id`, `gateway_payment_id`, `gateway_signature`,
                    `utr_reference`, `webhook_payload`, `notes`
                ) VALUES (
                    :order_id, :order_number, :customer_id, :customer_name, :customer_phone,
                    :gateway, :payment_method, :amount, :currency, :status,
                    :gateway_order_id, :gateway_payment_id, :gateway_signature,
                    :utr_reference, :webhook_payload, :notes
                )
            ");

            $stmt->execute([
                ':order_id'           => $data['order_id'] ?? null,
                ':order_number'       => $data['order_number'] ?? 'ORD-0',
                ':customer_id'        => $data['customer_id'] ?? null,
                ':customer_name'      => $data['customer_name'] ?? null,
                ':customer_phone'     => $data['customer_phone'] ?? null,
                ':gateway'            => $data['gateway'] ?? 'direct_upi',
                ':payment_method'     => $data['payment_method'] ?? 'upi',
                ':amount'             => (float)($data['amount'] ?? 0.00),
                ':currency'           => $data['currency'] ?? 'INR',
                ':status'             => $data['status'] ?? 'pending',
                ':gateway_order_id'   => $data['gateway_order_id'] ?? null,
                ':gateway_payment_id' => $data['gateway_payment_id'] ?? null,
                ':gateway_signature'  => $data['gateway_signature'] ?? null,
                ':utr_reference'      => $data['utr_reference'] ?? null,
                ':webhook_payload'    => isset($data['webhook_payload']) ? (is_array($data['webhook_payload']) ? json_encode($data['webhook_payload']) : (string)$data['webhook_payload']) : null,
                ':notes'              => $data['notes'] ?? null
            ]);

            return (int)$db->lastInsertId();
        } catch (\Throwable $e) {
            error_log("PaymentManager::recordTransaction error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Mark Order as Paid & Decrement Stock in Database (Audit Safeguard)
     */
    public static function markOrderPaidAndAdjustStock(string $orderNumber, string $gateway, string $paymentRef = '', array $extraData = []): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return true;
        }

        try {
            // 1. Update Order Table
            $stmtOrder = $db->prepare("
                UPDATE `orders` 
                SET `payment_status` = 'paid', 
                    `payment_gateway` = :gateway, 
                    `gateway_payment_id` = :pid,
                    `updated_at` = NOW()
                WHERE `order_number` = :ord
            ");
            $stmtOrder->execute([
                ':gateway' => $gateway,
                ':pid'     => $paymentRef,
                ':ord'     => $orderNumber
            ]);

            // 2. Fetch order items to decrement inventory stock safely
            $stmtItems = $db->prepare("
                SELECT `product_id`, `quantity` 
                FROM `order_items` 
                WHERE `order_id` = (SELECT `id` FROM `orders` WHERE `order_number` = :ord LIMIT 1)
            ");
            $stmtItems->execute([':ord' => $orderNumber]);
            $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($items)) {
                $stmtDec = $db->prepare("
                    UPDATE `products` 
                    SET `stock` = GREATEST(0, `stock` - :qty)
                    WHERE `id` = :pid
                ");
                foreach ($items as $item) {
                    $pid = (int)($item['product_id'] ?? 0);
                    $qty = (int)($item['quantity'] ?? 1);
                    if ($pid > 0 && $qty > 0) {
                        $stmtDec->execute([':qty' => $qty, ':pid' => $pid]);
                    }
                }
            }

            return true;
        } catch (\Throwable $e) {
            error_log("PaymentManager::markOrderPaidAndAdjustStock error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Save/Update Payment Gateway Settings from Admin Console
     */
    public static function saveGatewayConfig(string $gatewayKey, array $data): bool
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return false;
        }

        try {
            $existing = self::getGateway($gatewayKey);
            $name = $data['name'] ?? ($existing['name'] ?? ucfirst($gatewayKey));
            $desc = $data['description'] ?? ($existing['description'] ?? '');
            $isActive = isset($data['is_active']) ? (int)$data['is_active'] : (int)($existing['is_active'] ?? 1);
            $isTest = isset($data['is_test_mode']) ? (int)$data['is_test_mode'] : (int)($existing['is_test_mode'] ?? 0);
            $isRec = isset($data['is_recommended']) ? (int)$data['is_recommended'] : (int)($existing['is_recommended'] ?? 0);
            $sortOrder = isset($data['sort_order']) ? (int)$data['sort_order'] : (int)($existing['sort_order'] ?? 0);
            $config = $data['config'] ?? ($existing['config'] ?? []);

            $stmt = $db->prepare("
                INSERT INTO `payment_gateways` (
                    `gateway_key`, `name`, `description`, `is_active`, `is_test_mode`, `is_recommended`, `config_json`, `sort_order`
                ) VALUES (
                    :key, :name, :desc, :active, :test, :rec, :cfg, :sort
                ) ON DUPLICATE KEY UPDATE
                    `name` = VALUES(`name`),
                    `description` = VALUES(`description`),
                    `is_active` = VALUES(`is_active`),
                    `is_test_mode` = VALUES(`is_test_mode`),
                    `is_recommended` = VALUES(`is_recommended`),
                    `config_json` = VALUES(`config_json`),
                    `sort_order` = VALUES(`sort_order`)
            ");

            return $stmt->execute([
                ':key'    => $gatewayKey,
                ':name'   => $name,
                ':desc'   => $desc,
                ':active' => $isActive,
                ':test'   => $isTest,
                ':rec'    => $isRec,
                ':cfg'    => json_encode($config),
                ':sort'   => $sortOrder
            ]);
        } catch (\Throwable $e) {
            error_log("PaymentManager::saveGatewayConfig error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Fallback default gateways when database is unavailable
     */
    private static function getDefaultGateways(bool $onlyActive = false): array
    {
        $list = [
            'direct_upi' => [
                'id'             => 1,
                'gateway_key'    => 'direct_upi',
                'name'           => 'Instant UPI / Dynamic QR (0% Fee)',
                'description'    => 'Direct 1-Click App Auto-Open (Google Pay, PhonePe, Paytm, BHIM, CRED) & Dynamic Desktop QR',
                'is_active'      => true,
                'is_test_mode'   => false,
                'is_recommended' => true,
                'sort_order'     => 1,
                'config'         => [
                    'upi_vpa'       => '917046363528@okaxis',
                    'upi_name'      => "DT Brand's & Jai Hanuman Tex",
                    'backup_vpa'    => 'dtbrands@icici',
                    'mcc'           => '5691',
                    'auto_open_app' => true,
                    'dynamic_qr'    => true,
                    'require_utr'   => true
                ]
            ],
            'razorpay' => [
                'id'             => 2,
                'gateway_key'    => 'razorpay',
                'name'           => 'Razorpay Online Payments',
                'description'    => 'Cards, Net Banking (50+ Banks), UPI, Wallets, PayLater & EMI',
                'is_active'      => true,
                'is_test_mode'   => false,
                'is_recommended' => false,
                'sort_order'     => 2,
                'config'         => [
                    'key_id'         => getenv('RAZORPAY_KEY_ID') ?: '',
                    'key_secret'     => getenv('RAZORPAY_KEY_SECRET') ?: '',
                    'webhook_secret' => getenv('RAZORPAY_WEBHOOK_SECRET') ?: '',
                    'auto_capture'   => true,
                    'theme_color'    => '#8A681F'
                ]
            ],
            'cashfree' => [
                'id'             => 3,
                'gateway_key'    => 'cashfree',
                'name'           => 'Cashfree Payment Gateway',
                'description'    => 'Fast checkout via Cashfree PG, Instant UPI Intent & Netbanking',
                'is_active'      => true,
                'is_test_mode'   => false,
                'is_recommended' => false,
                'sort_order'     => 3,
                'config'         => [
                    'app_id'         => '',
                    'secret_key'     => '',
                    'webhook_secret' => '',
                    'theme_color'    => '#8A681F'
                ]
            ],
            'cod' => [
                'id'             => 4,
                'gateway_key'    => 'cod',
                'name'           => 'Cash on Delivery (COD)',
                'description'    => 'Doorstep cash payment upon delivery with flexible order limits',
                'is_active'      => true,
                'is_test_mode'   => false,
                'is_recommended' => false,
                'sort_order'     => 4,
                'config'         => [
                    'handling_fee'    => 0,
                    'min_order'       => 299,
                    'max_order'       => 25000,
                    'verify_otp'      => false,
                    'partial_deposit' => 0
                ]
            ],
            'whatsapp_pay' => [
                'id'             => 5,
                'gateway_key'    => 'whatsapp_pay',
                'name'           => 'Direct WhatsApp Order & Pay',
                'description'    => '1-Click WhatsApp Concierge order with embedded instant payment link',
                'is_active'      => true,
                'is_test_mode'   => false,
                'is_recommended' => false,
                'sort_order'     => 5,
                'config'         => [
                    'phone'         => '917046363528',
                    'auto_upi_link' => true,
                    'welcome_msg'   => "Namaste! I would like to place an order from DT Brand's."
                ]
            ]
        ];

        return $list;
    }
}
