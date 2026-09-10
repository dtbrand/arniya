<?php
/**
 * Test B2B API Security: Verify IDOR prevention across retailer.php, wholesale.php, reseller.php
 */

function testApiEndpoint($file, $method, $requestData) {
    $cmd = 'php -r ' . escapeshellarg('
        $_SERVER["REQUEST_METHOD"] = "' . $method . '";
        $_SERVER["HTTP_ORIGIN"] = "https://jaihanumantex.in";
        $_REQUEST = ' . var_export($requestData, true) . ';
        $_POST = $_REQUEST;
        $_GET = $_REQUEST;
        require "' . str_replace('\\', '/', $file) . '";
    ');
    exec($cmd, $output, $code);
    $jsonStr = implode("\n", $output);
    $data = json_decode($jsonStr, true);
    return $data;
}

echo "=== TESTING B2B API AUTHORIZATION & IDOR DEFENSES ===\n";

// 1. Test unauthenticated retailer update_profile
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'POST', [
    'action' => 'update_profile',
    'user_id' => 9999,
    'name' => 'Attacker Tampered'
]);
assert($res !== null && $res['success'] === false, "Unauthenticated retailer update_profile must fail");
echo "✅ PASS: Unauthenticated retailer update_profile blocked.\n";

// 2. Test unauthenticated wholesale update_profile
$res = testApiEndpoint(__DIR__ . '/../api/wholesale.php', 'POST', [
    'action' => 'update_profile',
    'user_id' => 9999,
    'name' => 'Attacker Tampered'
]);
assert($res !== null && $res['success'] === false, "Unauthenticated wholesale update_profile must fail");
echo "✅ PASS: Unauthenticated wholesale update_profile blocked.\n";

// 3. Test unauthenticated reseller update_profile
$res = testApiEndpoint(__DIR__ . '/../api/reseller.php', 'POST', [
    'action' => 'update_profile',
    'user_id' => 9999,
    'name' => 'Attacker Tampered'
]);
assert($res !== null && $res['success'] === false, "Unauthenticated reseller update_profile must fail");
echo "✅ PASS: Unauthenticated reseller update_profile blocked.\n";

// 4. Test unauthenticated retailer get_orders with injected phone
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'GET', [
    'action' => 'get_orders',
    'phone' => '9876543210'
]);
assert($res !== null && $res['success'] === true && $res['count'] === 0, "Unauthenticated get_orders with phone must return 0 orders");
echo "✅ PASS: Unauthenticated retailer get_orders returns 0 orders for injected phone.\n";

// 5. Test unauthenticated wholesale get_orders with injected phone
$res = testApiEndpoint(__DIR__ . '/../api/wholesale.php', 'GET', [
    'action' => 'get_orders',
    'phone' => '9876543210'
]);
assert($res !== null && $res['success'] === true && $res['count'] === 0, "Unauthenticated wholesale get_orders with phone must return 0 orders");
echo "✅ PASS: Unauthenticated wholesale get_orders returns 0 orders for injected phone.\n";

// 6. Test unauthenticated reseller get_orders with injected phone
$res = testApiEndpoint(__DIR__ . '/../api/reseller.php', 'GET', [
    'action' => 'get_orders',
    'phone' => '9876543210'
]);
assert($res !== null && $res['success'] === true && $res['count'] === 0, "Unauthenticated reseller get_orders with phone must return 0 orders");
echo "✅ PASS: Unauthenticated reseller get_orders returns 0 orders for injected phone.\n";

// 7. Test unauthenticated get_dashboard for retailer, wholesale, and reseller
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'GET', ['action' => 'get_dashboard']);
assert($res !== null && $res['success'] === true && $res['is_logged_in'] === false, "retailer get_dashboard must return success=true, is_logged_in=false");
echo "✅ PASS: Unauthenticated retailer get_dashboard returns success=true, is_logged_in=false.\n";

$res = testApiEndpoint(__DIR__ . '/../api/wholesale.php', 'GET', ['action' => 'get_dashboard']);
assert($res !== null && $res['success'] === true && $res['is_logged_in'] === false, "wholesale get_dashboard must return success=true, is_logged_in=false");
echo "✅ PASS: Unauthenticated wholesale get_dashboard returns success=true, is_logged_in=false.\n";

$res = testApiEndpoint(__DIR__ . '/../api/reseller.php', 'GET', ['action' => 'get_dashboard']);
assert($res !== null && $res['success'] === true && $res['is_logged_in'] === false, "reseller get_dashboard must return success=true, is_logged_in=false");
echo "✅ PASS: Unauthenticated reseller get_dashboard returns success=true, is_logged_in=false.\n";

echo "═══════════════════════════════════════════════════════════\n";
echo "100% PASS: All B2B IDOR and unauthenticated attacks blocked!\n";
echo "═══════════════════════════════════════════════════════════\n";
