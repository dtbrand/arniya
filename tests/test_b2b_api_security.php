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

// 8. Test unauthenticated my_orders with injected phone on orders.php
$res = testApiEndpoint(__DIR__ . '/../api/orders.php', 'GET', ['action' => 'my_orders', 'phone' => '9876543210']);
assert($res !== null && $res['success'] === false, "orders my_orders must fail for unauthenticated phone lookup");
echo "✅ PASS: Unauthenticated orders.php my_orders with phone blocked.\n";

// 9. Test unauthenticated get_profile with injected phone across all 3 portals
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'GET', ['action' => 'get_profile', 'phone' => '9876543210']);
assert($res !== null && $res['success'] === false, "retailer get_profile must fail for unauthenticated phone lookup");
echo "✅ PASS: Unauthenticated retailer get_profile with phone blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/wholesale.php', 'GET', ['action' => 'get_profile', 'phone' => '9876543210']);
assert($res !== null && $res['success'] === false, "wholesale get_profile must fail for unauthenticated phone lookup");
echo "✅ PASS: Unauthenticated wholesale get_profile with phone blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/reseller.php', 'GET', ['action' => 'get_profile', 'phone' => '9876543210']);
assert($res !== null && $res['success'] === false, "reseller get_profile must fail for unauthenticated phone lookup");
echo "✅ PASS: Unauthenticated reseller get_profile with phone blocked.\n";

// 10. Test unauthenticated get_addresses with injected phone across all 3 portals
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'GET', ['action' => 'get_addresses', 'phone' => '9876543210']);
assert($res !== null && $res['success'] === false, "retailer get_addresses must fail for unauthenticated phone lookup");
echo "✅ PASS: Unauthenticated retailer get_addresses with phone blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/wholesale.php', 'GET', ['action' => 'get_addresses', 'phone' => '9876543210']);
assert($res !== null && $res['success'] === false, "wholesale get_addresses must fail for unauthenticated phone lookup");
echo "✅ PASS: Unauthenticated wholesale get_addresses with phone blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/reseller.php', 'GET', ['action' => 'get_addresses', 'phone' => '9876543210']);
assert($res !== null && $res['success'] === false, "reseller get_addresses must fail for unauthenticated phone lookup");
echo "✅ PASS: Unauthenticated reseller get_addresses with phone blocked.\n";

// 11. Test unauthenticated set_default_shipping with arbitrary user_id tampering
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'POST', ['action' => 'set_default_shipping', 'user_id' => 9999, 'address_id' => 1]);
assert($res !== null && $res['success'] === false, "retailer set_default_shipping must fail for unauthenticated user");
echo "✅ PASS: Unauthenticated retailer set_default_shipping blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/wholesale.php', 'POST', ['action' => 'set_default_shipping', 'user_id' => 9999, 'address_id' => 1]);
assert($res !== null && $res['success'] === false, "wholesale set_default_shipping must fail for unauthenticated user");
echo "✅ PASS: Unauthenticated wholesale set_default_shipping blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/reseller.php', 'POST', ['action' => 'set_default_shipping', 'user_id' => 9999, 'address_id' => 1]);
assert($res !== null && $res['success'] === false, "reseller set_default_shipping must fail for unauthenticated user");
echo "✅ PASS: Unauthenticated reseller set_default_shipping blocked.\n";

// 12. Test unauthenticated delete_address with arbitrary user_id tampering
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'POST', ['action' => 'delete_address', 'user_id' => 9999, 'address_id' => 1]);
assert($res !== null && $res['success'] === false, "retailer delete_address must fail for unauthenticated user");
echo "✅ PASS: Unauthenticated retailer delete_address blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/wholesale.php', 'POST', ['action' => 'delete_address', 'user_id' => 9999, 'address_id' => 1]);
assert($res !== null && $res['success'] === false, "wholesale delete_address must fail for unauthenticated user");
echo "✅ PASS: Unauthenticated wholesale delete_address blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/reseller.php', 'POST', ['action' => 'delete_address', 'user_id' => 9999, 'address_id' => 1]);
assert($res !== null && $res['success'] === false, "reseller delete_address must fail for unauthenticated user");
echo "✅ PASS: Unauthenticated reseller delete_address blocked.\n";

// 13. Test retailer check_status returns only public verification status (no private PII dump)
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'GET', ['action' => 'check_status', 'phone' => '917046363528']);
assert($res !== null && $res['success'] === true && !isset($res['customer']), "retailer check_status must not leak customer record");
echo "✅ PASS: Retailer check_status does not leak full customer record.\n";

// 14. Test unauthenticated get_order_details with arbitrary order_id tampering
$res = testApiEndpoint(__DIR__ . '/../api/retailer.php', 'GET', ['action' => 'get_order_details', 'order_id' => '1']);
assert($res !== null && $res['success'] === false, "retailer get_order_details must fail for unauthenticated user without matching phone");
echo "✅ PASS: Unauthenticated retailer get_order_details blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/wholesale.php', 'GET', ['action' => 'get_order_details', 'order_id' => '1']);
assert($res !== null && $res['success'] === false, "wholesale get_order_details must fail for unauthenticated user without matching phone");
echo "✅ PASS: Unauthenticated wholesale get_order_details blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/reseller.php', 'GET', ['action' => 'get_order_details', 'order_id' => '1']);
assert($res !== null && $res['success'] === false, "reseller get_order_details must fail for unauthenticated user without matching phone");
echo "✅ PASS: Unauthenticated reseller get_order_details blocked.\n";

// 15. Test unauthenticated auth.php session endpoint correctly reports admin_authenticated = false
$res = testApiEndpoint(__DIR__ . '/../api/auth.php', 'GET', ['action' => 'session']);
assert($res !== null && isset($res['admin_authenticated']) && $res['admin_authenticated'] === false, "auth session must report admin_authenticated=false for unauthenticated request");
echo "✅ PASS: Unauthenticated auth session correctly reports admin_authenticated=false.\n";

// 16. Test unauthenticated auth.php profile endpoint blocks access
$res = testApiEndpoint(__DIR__ . '/../api/auth.php', 'GET', ['action' => 'profile']);
assert($res !== null && $res['success'] === false, "auth profile must fail for unauthenticated request");
echo "✅ PASS: Unauthenticated auth profile access blocked.\n";

// 17. Test unauthenticated customer_addresses.php blocked
$res = testApiEndpoint(__DIR__ . '/../api/customer_addresses.php', 'GET', ['customer_id' => 1]);
assert($res !== null && $res['success'] === false, "customer_addresses GET must fail for unauthenticated request");
echo "✅ PASS: Unauthenticated customer_addresses GET blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/customer_addresses.php', 'POST', ['action' => 'save', 'customer_id' => 1]);
assert($res !== null && $res['success'] === false, "customer_addresses POST must fail for unauthenticated request");
echo "✅ PASS: Unauthenticated customer_addresses POST blocked.\n";

// 18. Test unauthenticated customer_notes.php blocked
$res = testApiEndpoint(__DIR__ . '/../api/customer_notes.php', 'GET', ['customer_id' => 1]);
assert($res !== null && $res['success'] === false, "customer_notes GET must fail for unauthenticated request");
echo "✅ PASS: Unauthenticated customer_notes GET blocked.\n";

$res = testApiEndpoint(__DIR__ . '/../api/customer_notes.php', 'POST', ['action' => 'add_note', 'customer_id' => 1]);
assert($res !== null && $res['success'] === false, "customer_notes POST must fail for unauthenticated request");
echo "✅ PASS: Unauthenticated customer_notes POST blocked.\n";

echo "═══════════════════════════════════════════════════════════\n";
echo "100% PASS: All B2B & Orders IDOR, PII leaks, and unauthenticated attacks blocked!\n";
echo "═══════════════════════════════════════════════════════════\n";

