<?php
/**
 * test_whatsapp_suite.php — WhatsApp CRM Suite Verification Test
 * DT Brand's & Jai Hanuman Tex
 */

$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/NotificationManager.php';
require_once __DIR__ . '/../src/CustomerManager.php';
require_once __DIR__ . '/../src/AuditManager.php';

use DTBrand\Database;
use DTBrand\NotificationManager;
use DTBrand\CustomerManager;
use DTBrand\AuditManager;

Database::setPdo(null, true);

$passed = 0;
$failed = 0;
$errors = [];

function assertWaTest($name, $condition, $failMsg = '') {
    global $passed, $failed, $errors;
    if ($condition) {
        $passed++;
        echo "  [PASS] {$name}\n";
    } else {
        $failed++;
        $errors[] = "{$name}: {$failMsg}";
        echo "  [FAIL] {$name} - {$failMsg}\n";
    }
}

echo "================================================================================\n";
echo "TESTING WHATSAPP CRM SUITE\n";
echo "================================================================================\n";

// 1. Check all essential WhatsApp suite files exist
$waFiles = [
    'admin/whatsapp/index.php',
    'admin/whatsapp/broadcast.php',
    'admin/whatsapp/leads.php',
    'admin/whatsapp/templates.php',
    'admin/whatsapp/whatsapp.css',
    'admin/whatsapp/whatsapp.js',
    'api/whatsapp.php',
    'api/whatsapp/audience.php',
    'api/whatsapp/index.php'
];

foreach ($waFiles as $f) {
    assertWaTest("File exists: {$f}", file_exists(__DIR__ . '/../' . $f));
}

// 2. Test api/whatsapp.php - Helper function to execute action in subprocess
function callWaApi(array $params, string $method = 'GET'): array {
    $descriptor = [
        0 => ["pipe", "r"],
        1 => ["pipe", "w"],
        2 => ["pipe", "w"]
    ];
    $cmd = 'php ' . escapeshellarg(__DIR__ . '/run_wa_action.php');
    $process = proc_open($cmd, $descriptor, $pipes);
    if (!is_resource($process)) return [];

    fwrite($pipes[0], json_encode(['method' => $method, 'params' => $params]));
    fclose($pipes[0]);

    $output = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($process);

    return json_decode($output, true) ?: [];
}


// Test Action: get_info
$info = callWaApi(['action' => 'get_info']);
assertWaTest("API get_info returns success", ($info['success'] ?? false) === true);
assertWaTest("API get_info returns master WhatsApp number 917046363528", ($info['whatsapp_number'] ?? '') === '917046363528');

// Test Action: generate_link
$linkRes = callWaApi([
    'action' => 'generate_link',
    'type' => 'wholesale_lot',
    'product_name' => 'Kanjivaram Silk',
    'product_sku' => 'SKU-KJ-101',
    'price' => 25000
], 'POST');
assertWaTest("API generate_link returns success", ($linkRes['success'] ?? false) === true);
assertWaTest("API generate_link returns valid WhatsApp deep link", strpos($linkRes['whatsapp_link'] ?? '', 'https://api.whatsapp.com/send?phone=917046363528') === 0);

// Test Action: broadcast
$bcastRes = callWaApi([
    'action' => 'broadcast',
    'audience' => 'wholesale',
    'message' => 'Festive silk drop'
], 'POST');
assertWaTest("API broadcast returns success", ($bcastRes['success'] ?? false) === true);
assertWaTest("API broadcast returns queued status", ($bcastRes['status'] ?? '') === 'queued');
assertWaTest("API broadcast returns recipients count", ($bcastRes['recipients_count'] ?? 0) > 0);

// Test Action: test_ping
$pingRes = callWaApi(['action' => 'test_ping']);
assertWaTest("API test_ping returns success", ($pingRes['success'] ?? false) === true);
assertWaTest("API test_ping returns operational status", ($pingRes['status'] ?? '') === 'operational');
assertWaTest("API test_ping returns latency_ms", ($pingRes['latency_ms'] ?? 0) > 0);

// Test Action: get_templates
$tplRes = callWaApi(['action' => 'get_templates']);
assertWaTest("API get_templates returns success", ($tplRes['success'] ?? false) === true);
assertWaTest("API get_templates returns pre-approved templates", count($tplRes['templates'] ?? []) >= 3);

// Test Action: leads_list
$leadsRes = callWaApi(['action' => 'leads_list']);
assertWaTest("API leads_list returns success", ($leadsRes['success'] ?? false) === true);
assertWaTest("API leads_list returns contacts array", count($leadsRes['leads'] ?? []) > 0);

// Test Action: send_message
$sendRes = callWaApi([
    'action' => 'send_message',
    'phone' => '9820112345',
    'name' => 'Priya Sharma',
    'message' => 'Test message'
], 'POST');
assertWaTest("API send_message returns success", ($sendRes['success'] ?? false) === true);
assertWaTest("API send_message returns clean phone with 91 prefix", ($sendRes['recipient'] ?? '') === '919820112345');

// 3. Zero Raw Browser Dialog Guarantee
$rawConfirmFound = false;
$rawAlertFound = false;
foreach ($waFiles as $f) {
    if (!str_ends_with($f, '.php') && !str_ends_with($f, '.js')) continue;
    $content = file_get_contents(__DIR__ . '/../' . $f);
    if (preg_match('/(?<![a-zA-Z0-9_])confirm\s*\(/', $content)) {
        $rawConfirmFound = true;
    }
    if (preg_match('/(?<![a-zA-Z0-9_])alert\s*\(/', $content)) {
        $rawAlertFound = true;
    }
}
assertWaTest("WhatsApp suite has zero raw confirm() dialogs", !$rawConfirmFound);
assertWaTest("WhatsApp suite has zero raw alert() dialogs", !$rawAlertFound);

// 4. Sidebar Consolidation Check
$sidebar = file_get_contents(__DIR__ . '/../admin/includes/adminsidebar.php');
assertWaTest("Sidebar includes WhatsApp CRM master menu", strpos($sidebar, 'id="navItem-whatsapp"') !== false);
assertWaTest("Sidebar includes Broadcast Studio subitem", strpos($sidebar, '/admin/whatsapp/broadcast.php') !== false);
assertWaTest("Sidebar includes Lead Pipeline subitem", strpos($sidebar, '/admin/whatsapp/leads.php') !== false);
assertWaTest("Sidebar includes Message Templates subitem", strpos($sidebar, '/admin/whatsapp/templates.php') !== false);
assertWaTest("Sidebar includes Meta Cloud API Gateway subitem", strpos($sidebar, '/admin/whatsapp/templates.php?tab=gateway') !== false);

echo "\n================================================================================\n";
echo "WHATSAPP SUITE SUMMARY: {$passed} PASSED, {$failed} FAILED\n";
echo "================================================================================\n";

if ($failed > 0) {
    echo "Failures:\n";
    foreach ($errors as $e) echo "  - {$e}\n";
    exit(1);
} else {
    echo "ALL WHATSAPP SUITE TESTS PASSED (100% SUCCESS)!\n";
    exit(0);
}
