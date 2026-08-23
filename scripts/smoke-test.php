<?php
/**
 * smoke-test.php — Post-Deployment Automated Smoke Test Suite
 * DT Brand's & Jai Hanuman Tex
 */

$baseUrl = getenv('BASE_URL') ?: 'https://jaihanumantex.in';

$tests = [
    'Homepage Rendering' => [
        'url' => "{$baseUrl}/Frontend/Home/home.php",
        'expect_code' => 200,
        'must_contain' => ['html', 'DT Brand']
    ],
    'Shop Product Grid' => [
        'url' => "{$baseUrl}/Frontend/Shop/shop.php",
        'expect_code' => 200,
        'must_contain' => ['html', 'Saree']
    ],
    'Single Product Saree Showcase' => [
        'url' => "{$baseUrl}/Frontend/Single-Product/singleproduct.php",
        'expect_code' => 200,
        'must_contain' => ['html', 'WhatsApp']
    ],
    'Admin Login Console' => [
        'url' => "{$baseUrl}/Frontend/Admin/adminlogin.php",
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 12);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $hasContent = true;
    if (isset($spec['must_contain'])) {
        foreach ($spec['must_contain'] as $str) {
            if (stripos($body, $str) === false) {
                $hasContent = false;
                break;
            }
        }
    }

    if ($status === $spec['expect_code'] && $hasContent) {
        echo " [PASS] {$name} (HTTP {$status})\n";
        $passed++;
    } else {
        echo " [FAIL] {$name} (HTTP {$status})\n";
        $failed++;
    }
}

echo "------------------------------------------------------\n";
echo "Total: " . count($tests) . " | Passed: {$passed} | Failed: {$failed}\n";

if ($failed > 0) {
    echo "DEPLOYMENT BLOCKED: Smoke tests encountered failures.\n";
    exit(1);
} else {
    echo "SMOKE TESTS PASSED: Safe to route production traffic.\n";
    exit(0);
}
