<?php
require_once __DIR__ . '/../src/Database.php';
use DTBrand\Database;
Database::setPdo(null, true);

// Test 1: get_info
$_SERVER['REQUEST_METHOD'] = 'GET';
$_REQUEST = ['action' => 'get_info'];
ob_start();
require __DIR__ . '/../api/whatsapp.php';
$resp1 = json_decode(ob_get_clean(), true);
echo "get_info success: " . ($resp1['success'] ? 'YES' : 'NO') . "\n";
echo "whatsapp number: " . ($resp1['whatsapp_number'] ?? '') . "\n";

// Test 2: generate_link
$_SERVER['REQUEST_METHOD'] = 'POST';
$_REQUEST = ['action' => 'generate_link', 'type' => 'wholesale_lot', 'product_name' => 'Kanjivaram Silk', 'product_sku' => 'SKU-KJ-101'];
ob_start();
require __DIR__ . '/../api/whatsapp.php';
$resp2 = json_decode(ob_get_clean(), true);
echo "generate_link success: " . ($resp2['success'] ? 'YES' : 'NO') . "\n";
echo "link generated: " . (!empty($resp2['whatsapp_link']) ? 'YES' : 'NO') . "\n";

// Test 3: broadcast
$_SERVER['REQUEST_METHOD'] = 'POST';
$_REQUEST = ['action' => 'broadcast', 'audience' => 'wholesale', 'message' => 'Test broadcast'];
ob_start();
require __DIR__ . '/../api/whatsapp.php';
$resp3 = json_decode(ob_get_clean(), true);
echo "broadcast success: " . ($resp3['success'] ? 'YES' : 'NO') . "\n";
echo "recipients: " . ($resp3['recipients_count'] ?? 0) . "\n";

// Test 4: test_ping
$_SERVER['REQUEST_METHOD'] = 'GET';
$_REQUEST = ['action' => 'test_ping'];
ob_start();
require __DIR__ . '/../api/whatsapp.php';
$resp4 = json_decode(ob_get_clean(), true);
echo "test_ping success: " . ($resp4['success'] ? 'YES' : 'NO') . "\n";
echo "latency: " . ($resp4['latency_ms'] ?? 0) . "ms\n";

// Test 5: get_templates
$_SERVER['REQUEST_METHOD'] = 'GET';
$_REQUEST = ['action' => 'get_templates'];
ob_start();
require __DIR__ . '/../api/whatsapp.php';
$resp5 = json_decode(ob_get_clean(), true);
echo "get_templates success: " . ($resp5['success'] ? 'YES' : 'NO') . "\n";
echo "template count: " . ($resp5['count'] ?? 0) . "\n";

// Test 6: leads_list
$_SERVER['REQUEST_METHOD'] = 'GET';
$_REQUEST = ['action' => 'leads_list'];
ob_start();
require __DIR__ . '/../api/whatsapp.php';
$resp6 = json_decode(ob_get_clean(), true);
echo "leads_list success: " . ($resp6['success'] ? 'YES' : 'NO') . "\n";
echo "lead count: " . ($resp6['count'] ?? 0) . "\n";
