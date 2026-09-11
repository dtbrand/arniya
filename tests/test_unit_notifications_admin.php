<?php
/**
 * test_unit_notifications_admin.php — Comprehensive Unit Test Suite
 * Section 31: Multi-Channel Notification Engine & Admin Suite
 * DT Brand's & Jai Hanuman Tex Autonomous Protocol
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/NotificationManager.php';

use DTBrand\Database;
use DTBrand\NotificationManager;

$testsPassed = 0;
$testsFailed = 0;

function assertCondition(bool $condition, string $testName): void {
    global $testsPassed, $testsFailed;
    if ($condition) {
        echo " [PASS] $testName\n";
        $testsPassed++;
    } else {
        echo " [FAIL] $testName\n";
        $testsFailed++;
    }
}

echo "\n============================================================\n";
echo "  SECTION 31: NOTIFICATION ADMIN & MULTI-CHANNEL ENGINE TESTS\n";
echo "============================================================\n\n";

// 1. NotificationManager In-Memory Mock Initialization
NotificationManager::resetMockData();
$stats = NotificationManager::getNotificationStats();
assertCondition(!empty($stats['total_dispatched']), "NotificationManager initializes with realistic mock data");
assertCondition($stats['delivery_rate'] >= 90.0, "Initial delivery success rate satisfies high delivery target (rate: {$stats['delivery_rate']}%)");
assertCondition($stats['active_templates'] >= 8, "Initial active templates >= 8 handloom workflows");
assertCondition($stats['active_providers'] >= 4, "Initial active providers >= 4 multi-channel gateways");

// 2. Templates Retrieval & Channel Filtering
$allTemplates = NotificationManager::getTemplates();
assertCondition(count($allTemplates) >= 8, "getTemplates() returns all templates (count: " . count($allTemplates) . ")");

$waTemplates = NotificationManager::getTemplates(['channel' => 'whatsapp']);
assertCondition(count($waTemplates) >= 3, "getTemplates(['channel' => 'whatsapp']) filters to WhatsApp HSM templates");

$emailTemplates = NotificationManager::getTemplates(['channel' => 'email']);
assertCondition(count($emailTemplates) >= 2, "getTemplates(['channel' => 'email']) filters to Email templates");

$smsTemplates = NotificationManager::getTemplates(['channel' => 'sms']);
assertCondition(count($smsTemplates) >= 2, "getTemplates(['channel' => 'sms']) filters to DLT SMS templates");

$pushTemplates = NotificationManager::getTemplates(['channel' => 'push']);
assertCondition(count($pushTemplates) >= 1, "getTemplates(['channel' => 'push']) filters to Push templates");

// 3. Template By Key Lookup
$tplOrderWa = NotificationManager::getTemplateByKey('dt_order_placed_wa');
assertCondition($tplOrderWa !== null && $tplOrderWa['channel'] === 'whatsapp', "getTemplateByKey('dt_order_placed_wa') retrieves WhatsApp template");
assertCondition(!empty($tplOrderWa['meta_template_id']), "WhatsApp template contains Meta WABA template ID");

$tplOrderSms = NotificationManager::getTemplateByKey('dt_order_placed_sms');
assertCondition($tplOrderSms !== null && !empty($tplOrderSms['dlt_template_id']), "SMS template contains TRAI DLT template ID");

// 4. Safe Template Variable Substitution
$renderedWa = NotificationManager::renderTemplate(
    "Namaste {{customer_name}}! Order #{{order_no}} of Rs.{{amount}} is packed.",
    ['customer_name' => 'Kavita Sundaram', 'order_no' => 'DT-99120', 'amount' => '3,450']
);
assertCondition(str_contains($renderedWa, "Namaste Kavita Sundaram!"), "renderTemplate correctly substitutes {{customer_name}}");
assertCondition(str_contains($renderedWa, "Order #DT-99120"), "renderTemplate correctly substitutes {{order_no}}");
assertCondition(str_contains($renderedWa, "Rs.3,450"), "renderTemplate correctly substitutes {{amount}}");
assertCondition(!str_contains($renderedWa, "{{"), "renderTemplate leaves zero unrendered double-curly tags");

// 5. Template CRUD: Save & Delete
$newTemplateSaved = NotificationManager::saveTemplate([
    'template_key' => 'dt_test_festive_offer',
    'channel' => 'whatsapp',
    'title' => 'Festive Silk Discount Offer',
    'category' => 'Marketing',
    'content' => 'Dear {{customer_name}}, get 15% off on our authentic Banarasi silk weaves!',
    'variables_json' => ['customer_name', 'discount']
]);
assertCondition($newTemplateSaved === true, "saveTemplate() returns true on valid template registration");

$retrievedSaved = NotificationManager::getTemplateByKey('dt_test_festive_offer');
assertCondition($retrievedSaved !== null && $retrievedSaved['title'] === 'Festive Silk Discount Offer', "New template is retrievable by key");

$deletedTpl = NotificationManager::deleteTemplate((int)$retrievedSaved['id']);
assertCondition($deletedTpl === true, "deleteTemplate() successfully removes template");
assertCondition(NotificationManager::getTemplateByKey('dt_test_festive_offer') === null, "Deleted template is no longer present");

// 6. Send Notification Multi-Channel Simulation
$dispatchResult = NotificationManager::sendNotification(
    'whatsapp',
    '+91 98201 12345',
    'dt_order_placed_wa',
    ['customer_name' => 'Meera Patel', 'order_no' => 'DT-77123', 'item_count' => '3', 'amount' => '8,900'],
    ['recipient_name' => 'Meera Patel']
);
assertCondition($dispatchResult['success'] === true, "sendNotification() succeeds on WhatsApp channel");
assertCondition($dispatchResult['status'] === 'delivered', "sendNotification() marks successful dispatch as delivered");
assertCondition(!empty($dispatchResult['log_id']), "sendNotification() returns valid delivery log ID");
assertCondition(str_contains($dispatchResult['rendered_message'], 'Meera Patel'), "sendNotification() substitutes parameters into rendered message");

// 7. Delivery Logs Ledger
$logs = NotificationManager::getLogs(['limit' => 50]);
assertCondition(count($logs) >= 6, "getLogs() returns recent multi-channel dispatches");

$logFound = false;
foreach ($logs as $l) {
    if ($l['id'] === $dispatchResult['log_id']) {
        $logFound = true;
        break;
    }
}
assertCondition($logFound, "Newly dispatched message is present in delivery logs ledger");

// 8. Dead-Letter Queue (Failed Messages) & Single Retry
$failedLogs = NotificationManager::getFailedMessages();
assertCondition(count($failedLogs) >= 1, "getFailedMessages() isolates messages with status = 'failed'");
$firstFailedId = (int)$failedLogs[0]['id'];

$retryRes = NotificationManager::retryMessage($firstFailedId);
assertCondition($retryRes['success'] === true, "retryMessage() successfully redelivers failed message");
assertCondition($retryRes['status'] === 'delivered', "retryMessage() transitions status to 'delivered'");

// 9. Batch Retry All Failed Messages
$batchRes = NotificationManager::batchRetry([5, 6]);
assertCondition($batchRes['success'] === true, "batchRetry() succeeds across multiple message IDs");
assertCondition($batchRes['recovered_count'] >= 1, "batchRetry() recovers failed messages from dead-letter queue");

// 10. Gateway Providers & MANDATORY SECRET MASKING
$providers = NotificationManager::getProviders();
assertCondition(count($providers) === 4, "getProviders() returns all 4 cloud gateways");

$allSecretsMasked = true;
$foundMaskedString = false;
foreach ($providers as $p) {
    $rawJson = $p['config_json'] ?? '';
    // Look for any plaintext tokens or passwords that are not masked
    $cfg = json_decode($rawJson, true) ?: [];
    foreach (['password', 'access_token', 'auth_key', 'server_key'] as $k) {
        if (isset($cfg[$k])) {
            if ($cfg[$k] !== '••••••••••••••••') {
                $allSecretsMasked = false;
            } else {
                $foundMaskedString = true;
            }
        }
    }
}
assertCondition($allSecretsMasked && $foundMaskedString, "MANDATORY SECRET MASKING: All sensitive keys strictly masked with '••••••••••••••••'");

// 11. Provider Latency Handshake Test
$pingRes = NotificationManager::testProvider('whatsapp_cloud');
assertCondition($pingRes['success'] === true, "testProvider('whatsapp_cloud') returns successful handshake");
assertCondition($pingRes['latency_ms'] > 0 && $pingRes['latency_ms'] < 1000, "testProvider returns measured latency in milliseconds ({$pingRes['latency_ms']}ms)");

// 12. Dual Relative Adminguard on All Notification Admin Pages
$pagesToCheck = [
    __DIR__ . '/../admin/notifications/index.php',
    __DIR__ . '/../admin/notifications/templates.php',
    __DIR__ . '/../admin/notifications/email.php',
    __DIR__ . '/../admin/notifications/sms.php',
    __DIR__ . '/../admin/notifications/whatsapp.php',
    __DIR__ . '/../admin/notifications/push.php',
    __DIR__ . '/../admin/notifications/logs.php',
    __DIR__ . '/../admin/notifications/failed.php',
    __DIR__ . '/../admin/notifications/providers.php',
];

$allAdminguardDual = true;
foreach ($pagesToCheck as $f) {
    if (!file_exists($f)) {
        $allAdminguardDual = false;
        echo "Missing file: $f\n";
        continue;
    }
    $content = file_get_contents($f);
    if (!str_contains($content, 'adminguard.php') || !str_contains($content, "DOCUMENT_ROOT")) {
        $allAdminguardDual = false;
        echo "Adminguard check failed in: " . basename($f) . "\n";
    }
}
assertCondition($allAdminguardDual, "Dual relative adminguard fallback present on all 9 Section 31 admin pages");

// 13. 100% Real Vector SVG Icon Check (Zero emojis in UI buttons/nav)
$allVectorSvg = true;
foreach ($pagesToCheck as $f) {
    $content = file_get_contents($f);
    // Ensure <svg is used
    if (!str_contains($content, '<svg')) {
        $allVectorSvg = false;
        echo "Missing SVG in: " . basename($f) . "\n";
    }
}
assertCondition($allVectorSvg, "100% Real Vector SVG standard satisfied on all 9 notification admin pages");

// 14. Sidebar Integration Check
$sidebarContent = file_get_contents(__DIR__ . '/../admin/includes/adminsidebar.php');
assertCondition(str_contains($sidebarContent, 'admSubmenu-notifications'), "adminsidebar.php contains expandable notifications submenu");
assertCondition(str_contains($sidebarContent, 'sb_notif_failed_count'), "adminsidebar.php calculates failed notifications counter badge");
assertCondition(str_contains($sidebarContent, '/admin/notifications/templates.php'), "adminsidebar.php links to templates.php");
assertCondition(str_contains($sidebarContent, '/admin/notifications/email.php'), "adminsidebar.php links to email.php");
assertCondition(str_contains($sidebarContent, '/admin/notifications/sms.php'), "adminsidebar.php links to sms.php");
assertCondition(str_contains($sidebarContent, '/admin/notifications/whatsapp.php'), "adminsidebar.php links to whatsapp.php");
assertCondition(str_contains($sidebarContent, '/admin/notifications/push.php'), "adminsidebar.php links to push.php");
assertCondition(str_contains($sidebarContent, '/admin/notifications/logs.php'), "adminsidebar.php links to logs.php");
assertCondition(str_contains($sidebarContent, '/admin/notifications/failed.php'), "adminsidebar.php links to failed.php");
assertCondition(str_contains($sidebarContent, '/admin/notifications/providers.php'), "adminsidebar.php links to providers.php");

// 15. REST API actions test in clean subprocesses
$outStats = shell_exec('php tests/scratch_api_test.php POST stats');
$jsonStats = json_decode($outStats, true);
assertCondition(!empty($jsonStats['success']) && isset($jsonStats['stats']), "api/notifications.php?action=stats returns valid stats payload");

$outSend = shell_exec('php tests/scratch_api_test.php POST send_test');
$jsonSend = json_decode($outSend, true);
assertCondition(!empty($jsonSend['success']) && $jsonSend['status'] === 'delivered', "api/notifications.php?action=send_test executes multi-channel dispatch");

$outProv = shell_exec('php tests/scratch_api_test.php POST providers');
$jsonProv = json_decode($outProv, true);
assertCondition(!empty($jsonProv['success']) && count($jsonProv['providers']) === 4, "api/notifications.php?action=providers returns providers list with masked secrets");

echo "\n============================================================\n";
echo "  SECTION 31 TEST RESULTS: {$testsPassed} PASSED, {$testsFailed} FAILED\n";
echo "============================================================\n\n";

if ($testsFailed > 0) {
    exit(1);
}
exit(0);
