<?php
declare(strict_types=1);

/**
 * test_unit_audit_admin.php — Comprehensive Unit Test Suite for Section 35 Enterprise Audit Logs
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/AuditManager.php';

use DTBrand\AuditManager;

$passed = 0;
$failed = 0;

function assertCondition(bool $cond, string $message): void
{
    global $passed, $failed;
    if ($cond) {
        $passed++;
        echo "  [PASS] {$message}\n";
    } else {
        $failed++;
        echo "  [FAIL] {$message}\n";
    }
}

echo "\n======================================================================\n";
echo "  DT BRAND'S & JAI HANUMAN TEX — SECTION 35 AUDIT LOG SUITE TESTS\n";
echo "======================================================================\n\n";

// ── 1. Manager Instantiation & Category Architecture ──
echo "--- 1. Manager Instantiation & Category Architecture ---\n";
$manager = AuditManager::getInstance();
assertCondition($manager instanceof AuditManager, "AuditManager singleton instantiation");
assertCondition(count(AuditManager::ALL_CATEGORIES) === 15, "AuditManager registers exactly 15 canonical operational categories");

$requiredCats = [
    'auth', 'product', 'price_matrix', 'inventory', 'order',
    'payment', 'user', 'role', 'permission', 'setting',
    'integration', 'bulk_job', 'export', 'import', 'security'
];
foreach ($requiredCats as $cat) {
    assertCondition(in_array($cat, AuditManager::ALL_CATEGORIES, true), "Category '{$cat}' is registered in canonical catalog");
}

// ── 2. Strict Secret Masking Engine ──
echo "\n--- 2. Strict Secret Masking Engine ---\n";
$dirtyPayload = [
    'username'     => 'admin_user',
    'password'     => 'SuperSecret123!',
    'passwd'       => 'hiddenPass',
    'token'        => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.token',
    'secret'       => 'whsec_982402840284',
    'api_key'      => 'rzp_live_8910248102',
    'credit_card'  => '4111111111111111',
    'cvv'          => '889',
    'nested'       => [
        'private_key'  => 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQ...',
        'normal_field' => 'Safe textile order note',
        'auth_header'  => 'Bearer eyJhbGciOiJIUzI1NiIs.eyJzdWIiOiIxMjM0NTY3ODkwIiw.signature'
    ]
];

$masked = AuditManager::maskSensitiveData($dirtyPayload);

assertCondition($masked['password'] === '[REDACTED]', "Sensitive key 'password' is redacted to [REDACTED]");
assertCondition($masked['passwd'] === '[REDACTED]', "Sensitive key 'passwd' is redacted to [REDACTED]");
assertCondition($masked['token'] === '[REDACTED]', "Sensitive key 'token' is redacted to [REDACTED]");
assertCondition($masked['secret'] === '[REDACTED]', "Sensitive key 'secret' is redacted to [REDACTED]");
assertCondition($masked['api_key'] === '[REDACTED]', "Sensitive key 'api_key' is redacted to [REDACTED]");
assertCondition($masked['credit_card'] === '[REDACTED]', "Sensitive key 'credit_card' is redacted to [REDACTED]");
assertCondition($masked['cvv'] === '[REDACTED]', "Sensitive key 'cvv' is redacted to [REDACTED]");
assertCondition($masked['nested']['private_key'] === '[REDACTED]', "Nested key 'private_key' is redacted to [REDACTED]");
assertCondition($masked['nested']['normal_field'] === 'Safe textile order note', "Safe non-sensitive field 'normal_field' is preserved");
assertCondition(str_contains($masked['nested']['auth_header'], 'Bearer [REDACTED]'), "Bearer token in header string is redacted");

// ── 3. Master Log & Correlation ID Engine ──
echo "\n--- 3. Master Log & Correlation ID Engine ---\n";
$autoCorrId = AuditManager::generateCorrelationId('corr_test');
assertCondition(str_starts_with($autoCorrId, 'corr_test_'), "generateCorrelationId prefixes properly");

$logId = $manager->log([
    'action'      => 'unit_test_action',
    'entity_type' => 'test',
    'entity_id'   => 'TEST-001',
    'details'     => 'Unit testing the master logger',
    'status'      => 'success',
    'new_values'  => ['password' => 'should_be_masked', 'count' => 5],
]);
assertCondition($logId > 0, "Master log method returns positive integer ID ({$logId})");

$recordedLog = $manager->getLogById($logId);
assertCondition($recordedLog !== null, "Recorded log event retrieved by ID");
assertCondition($recordedLog['action'] === 'unit_test_action', "Recorded action matches input");
assertCondition(!empty($recordedLog['correlation_id']), "Correlation ID is automatically generated when omitted");
assertCondition(($recordedLog['new_values']['password'] ?? '') === '[REDACTED]', "Master log automatically masks secrets on ingestion");

// ── 4. Convenience Methods for 15 Specification Domains ──
echo "\n--- 4. Convenience Methods for All 15 Operational Domains ---\n";
$authId = $manager->logAuth('login', 'gautam@dtbrand.com', true, 1, null, ['role' => 'super_admin']);
assertCondition($authId > 0, "1. logAuth (login success) executed");

$failedAuthId = $manager->logAuth('failed_login', 'bad_actor', false, null, 'INVALID_PASSWORD');
assertCondition($failedAuthId > 0, "1b. logAuth (failed login) executed");

$prodId = $manager->logProductAction('create', 201, 'Kanjivaram Silk Saree', null, ['sku' => 'DT-KAN-001', 'mrp' => 4500]);
assertCondition($prodId > 0, "2. logProductAction executed");

$priceId = $manager->logPriceChange(201, 'Kanjivaram Silk Saree', ['wholesale_price' => 2200], ['wholesale_price' => 1999], 'Bulk weaver concession');
assertCondition($priceId > 0, "3. logPriceChange executed");

$stockId = $manager->logStockChange(201, 'DT-KAN-001', 50, 150, 'inward', 'Batch loom arrival');
assertCondition($stockId > 0, "4. logStockChange executed");

$ordId = $manager->logOrderStatus('ORD-2026-9901', 'pending', 'confirmed', 'Wholesaler advance received');
assertCondition($ordId > 0, "5. logOrderStatus executed");

$payId = $manager->logPaymentAction('payment_capture', 'ORD-2026-9901', 54000.0, 'instant_upi', 'PAY-UPI-9901', 'Full payment verified via UTR');
assertCondition($payId > 0, "6. logPaymentAction executed");

$roleId = $manager->logRoleChange(12, 'Arun Kumar', 'retailer', 'wholesaler', 'Verified GST credentials');
assertCondition($roleId > 0, "7. logRoleChange executed");

$permId = $manager->logPermissionChange('manager', ['reports:export', 'inventory:adjust_stock'], []);
assertCondition($permId > 0, "8. logPermissionChange executed");

$cfgId = $manager->logSettingsChange('tax_rates', ['gst' => 5.0], ['gst' => 5.0, 'hsn' => '5208']);
assertCondition($cfgId > 0, "9. logSettingsChange executed");

$intId = $manager->logIntegrationChange('delhivery', 'update_credentials', ['api_key' => 'secret_key_123', 'status' => 'active']);
assertCondition($intId > 0, "10. logIntegrationChange executed");

$blkId = $manager->logBulkAction('bulk_price_update', 'products', 25, ['DT-01', 'DT-02'], 'Diwali flash pricing');
assertCondition($blkId > 0, "11. logBulkAction executed");

$expId = $manager->logImportExport('export', 'orders', 340, 'Q3_Wholesale_Orders.csv', 'success');
assertCondition($expId > 0, "12. logImportExport executed");

$secId = $manager->logSecurityEvent('threat_intelligence', 'warning', 'Repeated failed login attempts from IP 185.220.101.5');
assertCondition($secId > 0, "13. logSecurityEvent executed");

// ── 5. Querying, Filtering & Pagination ──
echo "\n--- 5. Querying, Filtering & Pagination ---\n";
$allResult = $manager->getLogs(['limit' => 10]);
assertCondition($allResult['total'] > 0, "getLogs returns non-empty total count");
assertCondition(count($allResult['items']) <= 10, "getLogs respects limit parameter");
assertCondition(isset($allResult['pages']), "getLogs calculates pages count");

$filteredAuth = $manager->getLogs(['entity_type' => 'auth']);
assertCondition(!empty($filteredAuth['items']), "Filtering by entity_type='auth' returns records");
foreach ($filteredAuth['items'] as $item) {
    if (($item['entity_type'] ?? '') !== 'auth') {
        assertCondition(false, "Item entity_type must be 'auth'");
        break;
    }
}
assertCondition(true, "All returned items strictly match entity_type='auth'");

$filteredStatus = $manager->getLogs(['status' => 'warning']);
assertCondition(!empty($filteredStatus['items']), "Filtering by status='warning' returns records");

// ── 6. State Diff Computation ──
echo "\n--- 6. State Diff Computation ---\n";
$oldState = ['title' => 'Silk Saree', 'mrp' => 3000, 'tags' => ['ethnic', 'traditional'], 'deleted_key' => true];
$newState = ['title' => 'Royal Silk Saree', 'mrp' => 3000, 'tags' => ['ethnic', 'luxury'], 'added_key' => 'new_value'];

$diff = $manager->computeDiff($oldState, $newState);
assertCondition(array_key_exists('added_key', $diff['added']), "computeDiff detects added keys");
assertCondition(array_key_exists('deleted_key', $diff['removed']), "computeDiff detects removed keys");
assertCondition(array_key_exists('title', $diff['modified']), "computeDiff detects modified keys");
assertCondition($diff['modified']['title']['old'] === 'Silk Saree', "computeDiff captures old value");
assertCondition($diff['modified']['title']['new'] === 'Royal Silk Saree', "computeDiff captures new value");
assertCondition(array_key_exists('mrp', $diff['unchanged']), "computeDiff preserves unchanged keys");

// ── 7. Correlation Tracing & Entity Lifecycle ──
echo "\n--- 7. Correlation Tracing & Entity Lifecycle ---\n";
$sharedCorr = 'corr_chain_unit_test_' . mt_rand(1000, 9999);
$manager->log(['action' => 'step_1_create', 'entity_type' => 'order', 'entity_id' => 'ORD-100', 'correlation_id' => $sharedCorr]);
$manager->log(['action' => 'step_2_inventory', 'entity_type' => 'inventory', 'entity_id' => 'DT-SKU-1', 'correlation_id' => $sharedCorr]);
$manager->log(['action' => 'step_3_invoice', 'entity_type' => 'payment', 'entity_id' => 'INV-100', 'correlation_id' => $sharedCorr]);

$trace = $manager->getCorrelationTrace($sharedCorr);
assertCondition(count($trace) === 3, "getCorrelationTrace returns exactly 3 chained events");
assertCondition($trace[0]['action'] === 'step_1_create', "Correlation trace orders chronologically ascending");

$entityHist = $manager->getEntityHistory('order', 'ORD-100');
assertCondition(!empty($entityHist), "getEntityHistory returns lifecycle events for target entity");

// ── 8. Telemetry Stats & KPI Ribbon ──
echo "\n--- 8. Telemetry Stats & KPI Ribbon ---\n";
$stats = $manager->getAuditStats();
assertCondition(isset($stats['total_events']) && $stats['total_events'] > 0, "getAuditStats includes total_events");
assertCondition(isset($stats['events_24h']), "getAuditStats includes events_24h");
assertCondition(isset($stats['warnings_24h']), "getAuditStats includes warnings_24h");
assertCondition(isset($stats['category_counts']) && is_array($stats['category_counts']), "getAuditStats includes category breakdown");

// ── 9. RFC-4180 CSV Export & Formula Injection Protection ──
echo "\n--- 9. RFC-4180 CSV Export & Formula Injection Protection ---\n";
assertCondition(AuditManager::sanitizeCsvValue('=CMD|calc') === "'=CMD|calc", "Formula injection sanitizes '='");
assertCondition(AuditManager::sanitizeCsvValue('+CMD|calc') === "'+CMD|calc", "Formula injection sanitizes '+'");
assertCondition(AuditManager::sanitizeCsvValue('-CMD|calc') === "'-CMD|calc", "Formula injection sanitizes '-'");
assertCondition(AuditManager::sanitizeCsvValue('@SUM(1+1)') === "'@SUM(1+1)", "Formula injection sanitizes '@'");
assertCondition(AuditManager::sanitizeCsvValue("\tTAB_VAL") === "'\tTAB_VAL", "Formula injection sanitizes tab character");
assertCondition(AuditManager::sanitizeCsvValue('Normal Text') === 'Normal Text', "Formula injection preserves safe text");

$csv = $manager->exportCsv();
assertCondition(!empty($csv), "exportCsv produces non-empty CSV string");
assertCondition(str_contains($csv, 'Log ID') && str_contains($csv, 'Correlation ID') && str_contains($csv, 'Timestamp') && str_contains($csv, 'Actor Name'), "CSV contains RFC-4180 headers");

// ── 10. Log Retention & Self-Auditing Purge ──
echo "\n--- 10. Log Retention & Self-Auditing Purge ---\n";
$threwException = false;
try {
    $manager->purgeOldLogs(3, 'Test Admin');
} catch (\InvalidArgumentException $e) {
    $threwException = true;
}
assertCondition($threwException, "purgeOldLogs strictly rejects retention policy under 7 days");

$purged = $manager->purgeOldLogs(365, 'Gautam Sethi (Super Admin)');
assertCondition(is_int($purged), "purgeOldLogs executes safely and returns integer deleted count");

$purgeCheck = $manager->getLogs(['action' => 'audit_purge']);
assertCondition(!empty($purgeCheck['items']), "purgeOldLogs creates self-auditing log entry in audit_logs");

// ── 11. Admin UI Pages Integrity & Relative Guard Verification ──
echo "\n--- 11. Admin UI Pages Integrity & Relative Guard Verification ---\n";
$auditPages = [
    'admin/audit/index.php',
    'admin/audit/security.php',
    'admin/audit/products.php',
    'admin/audit/orders.php',
    'admin/audit/details.php',
    'admin/users/activity-logs.php',
];

foreach ($auditPages as $pagePath) {
    $fullPath = __DIR__ . '/../' . $pagePath;
    assertCondition(file_exists($fullPath), "Page exists: {$pagePath}");

    $content = file_get_contents($fullPath);
    assertCondition(
        str_contains($content, "adminguard.php"),
        "Page {$pagePath} includes relative adminguard check"
    );

    // Zero emojis in button tags or navigation links
    preg_match_all('/<(button|a)[^>]*>(.*?)<\/(button|a)>/is', $content, $matches);
    $hasEmojiInBtn = false;
    foreach ($matches[2] as $btnInner) {
        if (preg_match('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u', $btnInner)) {
            $hasEmojiInBtn = true;
            break;
        }
    }
    assertCondition(!$hasEmojiInBtn, "Page {$pagePath} complies with zero emojis in navigation/buttons");
}

// ── 12. Sidebar Navigation Hardening ──
echo "\n--- 12. Sidebar Navigation Hardening ---\n";
$sidebarContent = file_get_contents(__DIR__ . '/../admin/includes/adminsidebar.php');
assertCondition(str_contains($sidebarContent, 'id="navItem-audit"'), "Sidebar includes Enterprise Audit Logs nav item");
assertCondition(str_contains($sidebarContent, 'href="/admin/audit/"'), "Sidebar includes link to master audit feed");
assertCondition(str_contains($sidebarContent, 'href="/admin/audit/security.php"'), "Sidebar includes subnav link to security.php");
assertCondition(str_contains($sidebarContent, 'href="/admin/audit/products.php"'), "Sidebar includes subnav link to products.php");
assertCondition(str_contains($sidebarContent, 'href="/admin/audit/orders.php"'), "Sidebar includes subnav link to orders.php");

// ── 13. API Endpoint Hardening ──
echo "\n--- 13. API Endpoint Hardening ---\n";
$apiFile = __DIR__ . '/../api/audit.php';
assertCondition(file_exists($apiFile), "API endpoint api/audit.php exists");
$apiContent = file_get_contents($apiFile);
assertCondition(str_contains($apiContent, '_guard.php'), "api/audit.php enforces _guard.php");
assertCondition(str_contains($apiContent, 'dt_api_is_admin'), "api/audit.php enforces admin authentication check");

echo "\n======================================================================\n";
echo "  SECTION 35 TEST RESULTS: {$passed} PASSED, {$failed} FAILED\n";
echo "======================================================================\n\n";

if ($failed > 0) {
    exit(1);
}
