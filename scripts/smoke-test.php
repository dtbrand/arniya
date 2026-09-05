<?php
/**
 * smoke-test.php — Post-Deployment Automated Smoke Test Suite
 * DT Brand's & Jai Hanuman Tex — Modern Clean URLs
 */

$baseUrl = getenv('BASE_URL') ?: 'https://jaihanumantex.in';

// Discover active sample product ID
$sampleProductId = 13;
if (file_exists(__DIR__ . '/../src/ProductCatalog.php')) {
    require_once __DIR__ . '/../src/ProductCatalog.php';
    try {
        $allProducts = \DTBrand\ProductCatalog::getAll();
        if (!empty($allProducts[0]['id'])) {
            $sampleProductId = (int)$allProducts[0]['id'];
        }
    } catch (\Throwable $e) {
        $sampleProductId = 13;
    }
}

$tests = [
    'Homepage Rendering' => [
        'url' => "{$baseUrl}/",
        'expect_code' => 200,
        'must_contain' => ['html', 'DT Brand']
    ],
    'Shop Product Grid' => [
        'url' => "{$baseUrl}/shop",
        'expect_code' => 200,
        'must_contain' => ['html', 'Saree']
    ],
    'Single Product Saree Showcase' => [
        'url' => "{$baseUrl}/product/{$sampleProductId}",
        'expect_code' => 200,
        'must_contain' => ['html', 'WhatsApp']
    ],
    'Wholesale B2B Portal' => [
        'url' => "{$baseUrl}/wholesale",
        'expect_code' => 200,
        'must_contain' => ['html', 'Wholesale']
    ],
    'Retailer B2B Portal' => [
        'url' => "{$baseUrl}/retailer",
        'expect_code' => 200,
        'must_contain' => ['html', 'Retailer']
    ],
    'Reseller B2B Portal' => [
        'url' => "{$baseUrl}/reseller",
        'expect_code' => 200,
        'must_contain' => ['html', 'Reseller']
    ],
    'Shopping Cart' => [
        'url' => "{$baseUrl}/cart",
        'expect_code' => 200,
        'must_contain' => ['html', 'Cart']
    ],
    'Checkout Gateway' => [
        'url' => "{$baseUrl}/checkout",
        'expect_code' => 200,
        'must_contain' => ['html']
    ],
    'Admin Login Console' => [
        'url' => "{$baseUrl}/admin/login",
        'expect_code' => 200,
        'must_contain' => ['password', 'Admin']
    ],
    'System Health Endpoint' => [
        'url' => "{$baseUrl}/health.php",
        'expect_code' => 200,
        'must_contain' => ['"status": "healthy"']
    ],
];

echo "=== Running DT Brand's Post-Deployment Smoke Tests ===\n";
$passed = 0;
$failed = 0;

foreach ($tests as $name => $spec) {
    $ch = curl_init($spec['url']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 25);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (SmokeTester)');
    
    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlErr = curl_error($ch);
    curl_close($ch);

    $missing = [];
    if (isset($spec['must_contain'])) {
        foreach ($spec['must_contain'] as $str) {
            if ($body === false || stripos($body, $str) === false) {
                $missing[] = $str;
            }
        }
    }

    if ($status === $spec['expect_code'] && empty($missing)) {
        echo " [PASS] {$name} (HTTP {$status})\n";
        $passed++;
    } else {
        $detail = $curlErr ? "Curl error: {$curlErr}" : (empty($missing) ? "Unexpected HTTP status {$status}" : "Missing content: " . implode(', ', $missing));
        echo " [FAIL] {$name} (HTTP {$status} - {$detail})\n";
        $failed++;
    }
}

echo "------------------------------------------------------\n";
echo "Total: " . count($tests) . " | Passed: {$passed} | Failed: {$failed}\n";

if ($failed > 0) {
    echo "DEPLOYMENT BLOCKED: Smoke tests encountered failures.\n";
    exit(1);
}

echo "SMOKE TESTS PASSED: Safe to route production traffic.\n";
exit(0);
