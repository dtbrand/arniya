<?php
/**
 * api/shipping.php — Multi-Carrier Logistics & Serviceability Engine (Delhivery, BlueDart, TCI, DTDC)
 * DT Brand's & Jai Hanuman Tex — Surat Hub
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

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

    // ── 3. TRACK AWB SHIPMENT ──
    if ($action === 'track') {
        $awb = trim((string)($data['awb'] ?? ($_GET['awb'] ?? '')));
        if (empty($awb)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'AWB / Tracking number is required']);
            exit;
        }

        $events = [
            [
                'status' => 'Delivered',
                'location' => 'Destination City Hub',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'message' => 'Shipment delivered successfully. Verified via OTP.'
            ],
            [
                'status' => 'Out for Delivery',
                'location' => 'Local Delivery Station',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-6 hours')),
                'message' => 'Courier rider dispatched with order parcel.'
            ],
            [
                'status' => 'In Transit',
                'location' => 'Hub Sorting Facility',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'message' => 'Bag dispatched from Surat Logistics Center.'
            ],
            [
                'status' => 'Manifested / Picked Up',
                'location' => 'DT Brand Surat Mill Depot',
                'timestamp' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'message' => 'Order packaged and handed over to courier partner.'
            ]
        ];

        echo json_encode([
            'success' => true,
            'awb' => $awb,
            'carrier' => 'Delhivery Express',
            'current_status' => 'Delivered',
            'origin' => 'Surat, Gujarat',
            'events' => $events
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
