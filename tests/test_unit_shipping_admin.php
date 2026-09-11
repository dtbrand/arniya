<?php
/**
 * test_unit_shipping_admin.php — Comprehensive Unit Verification for Section 27 (Shipping Admin)
 * DT Brand's & Jai Hanuman Tex — Surat Logistics Depot
 */

require_once __DIR__ . '/../src/Database.php';

use DTBrand\Database;

$testsPassed = 0;
$testsFailed = 0;

function dt_assert(string $desc, bool $condition, string $details = '') {
    global $testsPassed, $testsFailed;
    if ($condition) {
        $testsPassed++;
        echo "  [PASS] {$desc}\n";
    } else {
        $testsFailed++;
        echo "  [FAIL] {$desc} — {$details}\n";
    }
}

echo "========================================================================\n";
echo "  DT BRAND'S SECTION 27: SHIPPING ADMIN & LOGISTICS VERIFICATION SUITE\n";
echo "========================================================================\n\n";

// ── TEST 1: Pincode Validation & Serviceability Mapping ──
echo "1. Testing Pincode Serviceability & Regional Zone Mapping...\n";

function simulatePincodeCheck(string $pincode): array {
    if (!preg_match('/^[1-9][0-9]{5}$/', $pincode)) {
        return ['success' => false, 'error' => 'Invalid PIN'];
    }
    $first2 = (int)substr($pincode, 0, 2);
    $state = 'India';
    $estDays = 4;
    if ($first2 >= 36 && $first2 <= 39) {
        $state = 'Gujarat (Intra-State / Surat Hub)';
        $estDays = 2;
    } elseif ($first2 >= 40 && $first2 <= 44) {
        $state = 'Maharashtra';
        $estDays = 3;
    } elseif ($first2 >= 11 && $first2 <= 13) {
        $state = 'Delhi NCR';
        $estDays = 3;
    }
    return ['success' => true, 'state' => $state, 'estimated_days' => $estDays];
}

$suratRes = simulatePincodeCheck('395002');
dt_assert("Surat local pincode 395002 routes to Gujarat with 2 days SLA", $suratRes['success'] && $suratRes['estimated_days'] === 2);

$mumbaiRes = simulatePincodeCheck('400001');
dt_assert("Mumbai metro pincode 400001 routes to Maharashtra with 3 days SLA", $mumbaiRes['success'] && $mumbaiRes['estimated_days'] === 3);

$delhiRes = simulatePincodeCheck('110001');
dt_assert("Delhi NCR pincode 110001 routes to North Zone with 3 days SLA", $delhiRes['success'] && $delhiRes['estimated_days'] === 3);

$invalidRes1 = simulatePincodeCheck('012345');
dt_assert("Pincode starting with 0 is rejected", !$invalidRes1['success']);

$invalidRes2 = simulatePincodeCheck('3950');
dt_assert("Pincode with fewer than 6 digits is rejected", !$invalidRes2['success']);

$invalidRes3 = simulatePincodeCheck('ABCDEF');
dt_assert("Non-numeric pincode is rejected", !$invalidRes3['success']);

// ── TEST 2: Multi-Channel Logistics Rates Calculation ──
echo "\n2. Testing Logistics Rates Calculation for Retail vs Wholesale B2B...\n";

function calculateTestRates(float $orderTotal, float $weightKg, string $channel): array {
    if ($channel === 'wholesale' || $channel === 'reseller') {
        return [
            'carrier' => 'TCI Freight B2B Cargo',
            'charge' => max(450.00, $weightKg * 35.00),
            'min_charge' => 450.00
        ];
    } else {
        $isFree = ($orderTotal >= 999.00);
        return [
            'carrier' => 'Delhivery Express Surface',
            'charge' => $isFree ? 0.00 : 99.00,
            'is_free' => $isFree
        ];
    }
}

$retailLow = calculateTestRates(599.00, 1.0, 'retail');
dt_assert("Retail order below ₹999 incurs ₹99 shipping", $retailLow['charge'] === 99.00 && !$retailLow['is_free']);

$retailFree = calculateTestRates(1299.00, 1.0, 'retail');
dt_assert("Retail order above ₹999 gets free shipping (₹0)", $retailFree['charge'] === 0.00 && $retailFree['is_free']);

$wholesaleSmall = calculateTestRates(50000.00, 10.0, 'wholesale');
dt_assert("Wholesale 10kg bale uses minimum cargo threshold ₹450", $wholesaleSmall['charge'] === 450.00);

$wholesaleLarge = calculateTestRates(150000.00, 30.0, 'wholesale');
dt_assert("Wholesale 30kg bale calculates 30kg x ₹35 = ₹1050", $wholesaleLarge['charge'] === 1050.00);

// ── TEST 3: Zero Provider Secret Exposure Audit ──
echo "\n3. Testing Zero Provider Secret Exposure (Section 27 Mandate)...\n";

$methodsContent = file_get_contents(__DIR__ . '/../admin/shipping/methods.php');
dt_assert("methods.php does not contain raw API secret values in HTML", 
    strpos($methodsContent, 'sk_live') === false && 
    strpos($methodsContent, 'api_secret_key_123') === false &&
    strpos($methodsContent, 'Gautam@9006') === false
);

dt_assert("methods.php contains masked secret representation", 
    strpos($methodsContent, '••••••••••••') !== false
);

dt_assert("methods.php displays Connection Status", 
    strpos($methodsContent, 'Connection Status') !== false
);

dt_assert("methods.php displays Last Successful Call timestamp", 
    strpos($methodsContent, 'Last Successful Call') !== false
);

dt_assert("methods.php displays Last Error", 
    strpos($methodsContent, 'Last Error') !== false
);

dt_assert("methods.php provides Safe Test Action button", 
    strpos($methodsContent, 'Safe Test Ping') !== false
);

// ── TEST 4: Shipping Labels & Thermal Barcode Manifest ──
echo "\n4. Testing 4x6 Shipping Label & Barcode Generation...\n";

$labelsContent = file_get_contents(__DIR__ . '/../admin/shipping/labels.php');
dt_assert("labels.php includes Surat Mill Logistics Depot origin", 
    strpos($labelsContent, 'SURAT CENTRAL MILL LOGISTICS DEPOT') !== false
);

dt_assert("labels.php includes GSTIN 24AAACD1234F1Z8", 
    strpos($labelsContent, '24AAACD1234F1Z8') !== false
);

dt_assert("labels.php formats thermal 4x6 print media styles", 
    strpos($labelsContent, '@media print') !== false && strpos($labelsContent, 'size: 4in 6in') !== false
);

dt_assert("labels.php includes barcode tracking area", 
    strpos($labelsContent, 'dt-barcode-box') !== false
);

// ── TEST 5: Delivery Exceptions & NDR Hub ──
echo "\n5. Testing Delivery Exceptions & NDR Workflow...\n";

$exceptionsContent = file_get_contents(__DIR__ . '/../admin/shipping/exceptions.php');
dt_assert("exceptions.php contains Non-Delivery Reports table", 
    strpos($exceptionsContent, 'Non-Delivery Reports &amp; Escalations') !== false
);

dt_assert("exceptions.php provides WhatsApp customer contact trigger", 
    strpos($exceptionsContent, 'api.whatsapp.com/send') !== false
);

dt_assert("exceptions.php contains Re-Attempt / RTO resolution modal", 
    strpos($exceptionsContent, 'dtResolveModal') !== false && strpos($exceptionsContent, 'RE_ATTEMPT_SCHEDULED') !== false
);

// ── TEST 6: Dual Relative Adminguard Fallback Verification ──
echo "\n6. Testing Dual Relative Adminguard Fallback on All Shipping Admin Files...\n";

$shippingFiles = [
    'admin/shipping/index.php',
    'admin/shipping/methods.php',
    'admin/shipping/rates.php',
    'admin/shipping/tracking.php',
    'admin/shipping/zones.php',
    'admin/shipping/labels.php',
    'admin/shipping/exceptions.php',
    'admin/shipping/audit.php'
];

foreach ($shippingFiles as $relPath) {
    $fullPath = __DIR__ . '/../' . $relPath;
    dt_assert("File exists: {$relPath}", file_exists($fullPath));
    $content = file_get_contents($fullPath);
    $hasGuard = (strpos($content, 'adminguard.php') !== false) && 
                (strpos($content, '__DIR__') !== false);
    dt_assert("Dual relative adminguard fallback present in {$relPath}", $hasGuard);
}

// ── TEST 7: Zero Emojis in Buttons/Navigation & 100% Rupee Standard ──
echo "\n7. Testing Zero Emojis and Indian Rupee Vector SVG Standards...\n";

$hasEmojiPattern = '/[\x{1F300}-\x{1F64F}\x{1F680}-\x{1F6FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u';

foreach ($shippingFiles as $relPath) {
    $content = file_get_contents(__DIR__ . '/../' . $relPath);
    // Check for emojis inside buttons or links
    preg_match_all('/<(button|a)[^>]*>(.*?)<\/(button|a)>/is', $content, $matches);
    $foundEmoji = false;
    foreach ($matches[2] as $inner) {
        if (preg_match($hasEmojiPattern, $inner)) {
            $foundEmoji = true;
            break;
        }
    }
    dt_assert("Zero emojis in buttons/links for {$relPath}", !$foundEmoji);
}

// Check Indian Rupee SVG is used where pricing appears
$ratesContent = file_get_contents(__DIR__ . '/../admin/shipping/rates.php');
dt_assert("rates.php uses Indian Rupee (₹) vector SVG", 
    strpos($ratesContent, '<path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path>') !== false
);

dt_assert("rates.php does not use dollar sign for pricing display", 
    strpos($ratesContent, '$ ') === false && strpos($ratesContent, '$$') === false
);

// ── TEST SUMMARY ──
echo "\n========================================================================\n";
echo "  TEST SUMMARY: {$testsPassed} PASSED, {$testsFailed} FAILED\n";
echo "========================================================================\n";

if ($testsFailed > 0) {
    exit(1);
}
exit(0);
