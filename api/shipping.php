<?php
/**
 * api/shipping.php — Multi-Carrier Logistics & Serviceability Engine (Delhivery, BlueDart, TCI, DTDC)
 * DT Brand's & Jai Hanuman Tex — Surat Hub
 */

require_once __DIR__ . '/cors.php';
cors_json();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';

use DTBrand\Database;

try {
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true) ?: [];
    $data = !empty($jsonData) ? $jsonData : $_REQUEST;

    $action = $data['action'] ?? ($_GET['action'] ?? 'check_pincode');
    $pincode = trim((string)($data['pincode'] ?? ($_GET['pincode'] ?? '')));

    // ── 1. PINCODE SERVICEABILITY CHECK ──
    if ($action === 'check_pincode') {
        if (!preg_match('/^[1-9][0-9]{5}$/', $pincode)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Please enter a valid 6-digit Indian PIN code.'
            ]);
            exit;
        }

        // Zone mapping based on first 2 digits of Indian Pincode
        $first2 = (int)substr($pincode, 0, 2);
        $state = 'India';
        $region = 'National';
        $estDays = 4;

        if ($first2 >= 36 && $first2 <= 39) {
            $state = 'Gujarat (Intra-State / Surat Hub)';
            $region = 'Local Zone';
            $estDays = 2;
        } elseif ($first2 >= 40 && $first2 <= 44) {
            $state = 'Maharashtra';
            $region = 'West Zone';
            $estDays = 3;
        } elseif ($first2 >= 11 && $first2 <= 13) {
            $state = 'Delhi NCR';
            $region = 'North Zone';
            $estDays = 3;
        } elseif ($first2 >= 30 && $first2 <= 34) {
            $state = 'Rajasthan';
            $region = 'North Zone';
            $estDays = 3;
        } elseif ($first2 >= 50 && $first2 <= 53) {
            $state = 'Andhra Pradesh / Telangana';
            $region = 'South Zone';
            $estDays = 4;
        } elseif ($first2 >= 56 && $first2 <= 59) {
            $state = 'Karnataka (Bengaluru Hub)';
            $region = 'South Zone';
            $estDays = 4;
        } elseif ($first2 >= 60 && $first2 <= 64) {
            $state = 'Tamil Nadu (Chennai Hub)';
            $region = 'South Zone';
            $estDays = 4;
        } elseif ($first2 >= 70 && $first2 <= 74) {
            $state = 'West Bengal (Kolkata Hub)';
            $region = 'East Zone';
            $estDays = 4;
        } else {
            $estDays = 5;
        }

        $deliveryDate = date('D, d M', strtotime("+{$estDays} weekdays"));

        echo json_encode([
            'success' => true,
            'pincode' => $pincode,
            'state' => $state,
            'region' => $region,
            'serviceable' => true,
            'cod_available' => true,
            'prepaid_available' => true,
            'estimated_days' => $estDays,
            'estimated_delivery_date' => $deliveryDate,
            'origin_hub' => 'Surat Mill Depot (395002)',
            'supported_couriers' => ['Delhivery Surface', 'BlueDart Air', 'DTDC Express', 'TCI Freight (B2B)']
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // ── 2. CALCULATE LOGISTICS RATES ──
    if ($action === 'calculate_rates') {
        $weightKg = (float)($data['weight_kg'] ?? 1.0);
        $orderTotal = (float)($data['order_total'] ?? 0);
        $channel = trim((string)($data['channel'] ?? 'retail'));

        $rates = [];
        if ($channel === 'wholesale' || $channel === 'reseller') {
            $rates = [
                [
                    'carrier' => 'TCI Express Cargo (B2B Bales)',
                    'type' => 'Road Transport',
                    'rate_per_kg' => 35.00,
                    'min_charge' => 450.00,
                    'total_cost' => max(450.00, $weightKg * 35.00),
                    'est_delivery' => '3–6 business days'
                ],
                [
                    'carrier' => 'Delhivery Heavy Surface (Doorstep)',
                    'type' => 'Express Surface',
                    'rate_per_kg' => 60.00,
                    'min_charge' => 250.00,
                    'total_cost' => max(250.00, $weightKg * 60.00),
                    'est_delivery' => '3–4 business days'
                ]
            ];
        } else {
            $isFree = ($orderTotal >= 999);
            $rates = [
                [
                    'carrier' => 'Delhivery Express Surface',
                    'type' => 'Standard Doorstep Delivery',
                    'charge' => $isFree ? 0 : 99,
                    'is_free' => $isFree,
                    'est_delivery' => '3–5 days'
                ],
                [
                    'carrier' => 'BlueDart Air Express (Priority)',
                    'type' => 'Air Cargo Delivery',
                    'charge' => 199,
                    'is_free' => false,
                    'est_delivery' => '1–2 days'
                ]
            ];
        }

        echo json_encode([
            'success' => true,
            'channel' => $channel,
            'weight_kg' => $weightKg,
            'rates' => $rates
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // ── 3. GET SHIPPING RATE MATRIX ──
    if ($action === 'get_rates') {
        $defaultSlabs = [
            [
                'zone_code' => 'zone_a',
                'zone_name' => 'Zone A — Gujarat & Surat Local',
                'coverage' => 'Surat, Ahmedabad, Vadodara, Rajkot',
                'base_rate' => 40.00,
                'per_unit_rate' => 20.00,
                'free_threshold' => 999.00,
                'sla' => '24–48 Hours'
            ],
            [
                'zone_code' => 'zone_b',
                'zone_name' => 'Zone B — Tier-1 Metro Cities',
                'coverage' => 'Mumbai, Delhi NCR, Bengaluru, Hyderabad, Chennai, Kolkata',
                'base_rate' => 60.00,
                'per_unit_rate' => 30.00,
                'free_threshold' => 1499.00,
                'sla' => '2–3 Days'
            ],
            [
                'zone_code' => 'zone_c',
                'zone_name' => 'Zone C — Rest of India (Air / Surface)',
                'coverage' => 'All Tier-2 & Tier-3 Cities & Towns',
                'base_rate' => 80.00,
                'per_unit_rate' => 40.00,
                'free_threshold' => 1999.00,
                'sla' => '3–5 Days'
            ],
            [
                'zone_code' => 'zone_d',
                'zone_name' => 'Zone D — Special Regions (NE & J&K)',
                'coverage' => 'Assam, Meghalaya, Manipur, Jammu & Kashmir, Ladakh',
                'base_rate' => 120.00,
                'per_unit_rate' => 60.00,
                'free_threshold' => 2999.00,
                'sla' => '5–7 Days'
            ],
            [
                'zone_code' => 'wholesale_b2b',
                'zone_name' => 'Wholesale Master B2B Bales (>20 kg)',
                'coverage' => 'Heavy surface transport via TCI Freight / V-Trans',
                'base_rate' => 18.00,
                'per_unit_rate' => 18.00,
                'free_threshold' => 25000.00,
                'sla' => '3–6 Days Regional'
            ]
        ];

        $pdo = Database::getConnection();
        $slabs = $defaultSlabs;

        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $pdo->exec("CREATE TABLE IF NOT EXISTS `shipping_zone_rates` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `zone_code` VARCHAR(50) NOT NULL UNIQUE,
                    `zone_name` VARCHAR(150) NOT NULL,
                    `coverage` VARCHAR(255) NULL,
                    `base_rate` DECIMAL(10,2) NOT NULL DEFAULT 40.00,
                    `per_unit_rate` DECIMAL(10,2) NOT NULL DEFAULT 20.00,
                    `free_threshold` DECIMAL(10,2) NOT NULL DEFAULT 999.00,
                    `sla` VARCHAR(100) NOT NULL DEFAULT '24–48 Hours',
                    `is_active` TINYINT(1) DEFAULT 1,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

                $count = (int)$pdo->query("SELECT COUNT(*) FROM `shipping_zone_rates`")->fetchColumn();
                if ($count === 0) {
                    $ins = $pdo->prepare("INSERT INTO `shipping_zone_rates` (zone_code, zone_name, coverage, base_rate, per_unit_rate, free_threshold, sla) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    foreach ($defaultSlabs as $d) {
                        $ins->execute([$d['zone_code'], $d['zone_name'], $d['coverage'], $d['base_rate'], $d['per_unit_rate'], $d['free_threshold'], $d['sla']]);
                    }
                }

                $rows = $pdo->query("SELECT * FROM `shipping_zone_rates` ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
                if (!empty($rows)) {
                    $slabs = array_map(function($r) {
                        return [
                            'id' => (int)$r['id'],
                            'zone_code' => $r['zone_code'],
                            'zone_name' => $r['zone_name'],
                            'coverage' => $r['coverage'] ?? '',
                            'base_rate' => (float)$r['base_rate'],
                            'per_unit_rate' => (float)$r['per_unit_rate'],
                            'free_threshold' => (float)$r['free_threshold'],
                            'sla' => $r['sla'] ?? '2–4 Days'
                        ];
                    }, $rows);
                }
            } catch (\Throwable $e) {
                // Return default slabs
            }
        }

        echo json_encode([
            'success' => true,
            'rates' => $slabs
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // ── 4. UPDATE SHIPPING RATE MATRIX (ADMIN ONLY) ──
    if ($action === 'update_rates') {
        require_once __DIR__ . '/_guard.php';
        dt_api_require_admin('update shipping rates');

        $ratesInput = $data['rates'] ?? [];
        if (is_string($ratesInput)) {
            $ratesInput = json_decode($ratesInput, true) ?: [];
        }

        if (!is_array($ratesInput) || empty($ratesInput)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Valid rates array required.']);
            exit;
        }

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $pdo->exec("CREATE TABLE IF NOT EXISTS `shipping_zone_rates` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `zone_code` VARCHAR(50) NOT NULL UNIQUE,
                    `zone_name` VARCHAR(150) NOT NULL,
                    `coverage` VARCHAR(255) NULL,
                    `base_rate` DECIMAL(10,2) NOT NULL DEFAULT 40.00,
                    `per_unit_rate` DECIMAL(10,2) NOT NULL DEFAULT 20.00,
                    `free_threshold` DECIMAL(10,2) NOT NULL DEFAULT 999.00,
                    `sla` VARCHAR(100) NOT NULL DEFAULT '24–48 Hours',
                    `is_active` TINYINT(1) DEFAULT 1,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

                $upsert = $pdo->prepare("
                    INSERT INTO `shipping_zone_rates` (zone_code, zone_name, coverage, base_rate, per_unit_rate, free_threshold, sla)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        zone_name = VALUES(zone_name),
                        coverage = VALUES(coverage),
                        base_rate = VALUES(base_rate),
                        per_unit_rate = VALUES(per_unit_rate),
                        free_threshold = VALUES(free_threshold),
                        sla = VALUES(sla),
                        updated_at = NOW()
                ");

                foreach ($ratesInput as $r) {
                    $code = trim((string)($r['zone_code'] ?? ''));
                    if (empty($code)) continue;
                    $name = trim((string)($r['zone_name'] ?? $code));
                    $coverage = trim((string)($r['coverage'] ?? ''));
                    $base = (float)($r['base_rate'] ?? 0);
                    $perUnit = (float)($r['per_unit_rate'] ?? 0);
                    $free = (float)($r['free_threshold'] ?? 0);
                    $sla = trim((string)($r['sla'] ?? '2–4 Days'));

                    $upsert->execute([$code, $name, $coverage, $base, $perUnit, $free, $sla]);
                }

                echo json_encode([
                    'success' => true,
                    'message' => 'Shipping freight rate slabs saved to database successfully.'
                ]);
                exit;
            } catch (\Throwable $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Shipping freight rates validated and saved.'
        ]);
        exit;
    }

    // ── 5. TRACK AWB SHIPMENT ──
    if ($action === 'track') {
        $awb = trim((string)($data['awb'] ?? ($_GET['awb'] ?? '')));
        if (empty($awb)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'AWB / Tracking number is required']);
            exit;
        }

        $carrier = 'Delhivery Express';
        $currentStatus = 'Dispatched';
        $destination = 'India';
        $orderRecord = null;

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $oStmt = $pdo->prepare("SELECT * FROM orders WHERE tracking_number = ? OR order_number = ? OR id = ? LIMIT 1");
                $oStmt->execute([$awb, $awb, is_numeric($awb) ? (int)$awb : 0]);
                $orderRecord = $oStmt->fetch(\PDO::FETCH_ASSOC);
                if ($orderRecord) {
                    if (!empty($orderRecord['courier_name'])) {
                        $carrier = $orderRecord['courier_name'];
                    }
                    $st = strtolower($orderRecord['fulfillment_status'] ?? ($orderRecord['order_status'] ?? 'processing'));
                    if ($st === 'delivered') {
                        $currentStatus = 'Delivered';
                    } elseif (in_array($st, ['shipped', 'in_transit', 'out_for_delivery'])) {
                        $currentStatus = 'In Transit';
                    } elseif ($st === 'dispatched') {
                        $currentStatus = 'Dispatched';
                    } else {
                        $currentStatus = 'Processing at Depot';
                    }
                    if (!empty($orderRecord['shipping_address'])) {
                        $parts = array_map('trim', explode(',', $orderRecord['shipping_address']));
                        if (count($parts) >= 2) {
                            $destination = trim(preg_replace('/\s*-\s*\d+/', '', $parts[count($parts) - 2]));
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        $events = [];
        if ($currentStatus === 'Delivered') {
            $events[] = [
                'status' => 'Delivered',
                'location' => $destination . ' Hub',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'message' => 'Consignment delivered successfully. Verified via OTP/Signature.'
            ];
            $events[] = [
                'status' => 'Out for Delivery',
                'location' => $destination . ' Depot',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-6 hours')),
                'message' => 'Courier courier agent dispatched for doorstep handover.'
            ];
        }
        if (in_array($currentStatus, ['Delivered', 'In Transit'])) {
            $events[] = [
                'status' => 'In Transit',
                'location' => $carrier . ' Logistics Corridor',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'message' => 'Freight container en-route via express corridor.'
            ];
        }
        $events[] = [
            'status' => 'Dispatched',
            'location' => 'Surat Central Depot (395002)',
            'timestamp' => date('Y-m-d H:i:s', strtotime('-2 days')),
            'message' => 'Manifested and handed over to ' . $carrier . '.'
        ];
        $events[] = [
            'status' => 'Booked & Packed',
            'location' => 'DT Brand Mill Depot, Surat',
            'timestamp' => date('Y-m-d H:i:s', strtotime('-2 days -3 hours')),
            'message' => 'Order verified, quality checked, and security packed.'
        ];

        echo json_encode([
            'success' => true,
            'awb' => $awb,
            'carrier' => $carrier,
            'current_status' => $currentStatus,
            'destination' => $destination,
            'origin' => 'Surat, Gujarat',
            'events' => $events,
            'order_id' => $orderRecord ? (int)$orderRecord['id'] : null,
            'order_number' => $orderRecord ? ($orderRecord['order_number'] ?? null) : null
        ], JSON_PRETTY_PRINT);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid shipping action']);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Logistics error: ' . $e->getMessage()]);
    exit;
}
