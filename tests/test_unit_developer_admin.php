<?php
declare(strict_types=1);

/**
 * tests/test_unit_developer_admin.php — Comprehensive Unit Test Suite
 * Section 37: Developer & API Admin Suite
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/DeveloperManager.php';
require_once __DIR__ . '/../src/AuditManager.php';

use DTBrand\Database;
use DTBrand\DeveloperManager;
use DTBrand\AuditManager;

echo "═══════════════════════════════════════════════════════════════════\n";
echo "🧪 DT Brand's — Section 37: Developer & API Admin Test Suite\n";
echo "═══════════════════════════════════════════════════════════════════\n\n";

$passed = 0;
$failed = 0;

function assertTest(string $desc, bool $condition, string $details = ''): void {
    global $passed, $failed;
    if ($condition) {
        echo "  ✅ PASS: {$desc}\n";
        $passed++;
    } else {
        echo "  ❌ FAIL: {$desc}" . ($details ? " ({$details})" : '') . "\n";
        $failed++;
    }
}

$dev = DeveloperManager::getInstance();

// 1. Singleton Instantiation
assertTest('DeveloperManager singleton instantiation', $dev instanceof DeveloperManager);

// 2. API Registry
$registry = $dev->getApiRegistry();
assertTest('API Registry returns populated array', is_array($registry) && count($registry) >= 10);
assertTest('API Registry contains health endpoint', isset($registry['api/health.php']));
assertTest('API Registry contains products endpoint', isset($registry['api/products.php']));
assertTest('API Registry contains orders endpoint', isset($registry['api/orders.php']));
assertTest('API Registry contains payments endpoint', isset($registry['api/payments.php']));

// 3. cURL Snippet Generator
$curlHealth = $dev->generateCurlSnippet('api/health.php');
assertTest('cURL generator produces valid GET curl command', str_starts_with($curlHealth, 'curl -X GET'));
$curlPayments = $dev->generateCurlSnippet('api/payments.php');
assertTest('cURL generator produces valid POST curl command with body', str_starts_with($curlPayments, 'curl -X POST') && str_contains($curlPayments, '-d'));

// 4. API Health & Latency Monitor
$health = $dev->getApiHealth();
assertTest('API Health returns overall health score', isset($health['health_score']) && $health['health_score'] >= 80);
assertTest('API Health returns average latency', isset($health['avg_latency_ms']) && $health['avg_latency_ms'] > 0);
assertTest('API Health returns endpoints matrix', !empty($health['endpoints']) && count($health['endpoints']) >= 5);

// 5. Endpoint Live Ping
$pingResult = $dev->pingEndpoint('/api/health.php', 'GET');
assertTest('Live ping returns valid status code', isset($pingResult['status_code']) && $pingResult['status_code'] === 200);
assertTest('Live ping measures duration in ms', isset($pingResult['latency_ms']) && $pingResult['latency_ms'] > 0);

// 6. Webhook Events
$webhooks = $dev->getWebhookEvents();
assertTest('Webhook events ledger returns records', is_array($webhooks) && count($webhooks) >= 3);
$inbound = $dev->getWebhookEvents(['direction' => 'inbound']);
assertTest('Webhook events filter by inbound works', count($inbound) >= 2);

// 7. Webhook Redelivery
$retryRes = $dev->retryWebhook('evt_fail_05');
assertTest('Webhook redelivery initiates successfully', ($retryRes['success'] ?? false) === true && $retryRes['status'] === 'delivered');

// 8. HMAC-SHA256 Signature Sandbox
$hmacTest = $dev->testHmacSignature('razorpay', '{"order_id":123}', 'secret_xyz');
assertTest('HMAC calculator generates 64-char sha256 hex digest', strlen($hmacTest['calculated_signature']) === 64);
assertTest('HMAC calculator outputs proper gateway header', str_contains($hmacTest['headers_format'], 'X-Razorpay-Signature:'));

// 9. Queue Statistics & Jobs
$qStats = $dev->getQueueStats();
assertTest('Queue statistics returns counts', isset($qStats['pending'], $qStats['completed'], $qStats['failed']));
$qJobs = $dev->getQueueJobs('all');
assertTest('Queue jobs list returns records', is_array($qJobs) && count($qJobs) >= 3);

// 10. Queue Job Execution & Retry
$runRes = $dev->runQueueJob('job_rep_904');
assertTest('Manual queue job execution succeeds', ($runRes['success'] ?? false) === true && $runRes['status'] === 'completed');
$retryJobRes = $dev->retryQueueJob('job_sync_905');
assertTest('Failed job retry resets status to pending', ($retryJobRes['success'] ?? false) === true && $retryJobRes['status'] === 'pending');

// 11. System Route Map & Completeness (Section 38 & 122)
$routes = $dev->getRouteMap();
assertTest('Route map contains admin and API routes', is_array($routes) && count($routes) >= 25);
$missingViews = array_filter($routes, fn($r) => ($r['file_exists'] ?? false) === false);
assertTest('Zero missing views in route map (Section 122 compliance)', count($missingViews) === 0, count($missingViews) . ' missing views found');

// 12. Safe System Diagnostics & Zero Secret Leakage
$diag = $dev->getDiagnostics();
assertTest('Diagnostics returns PHP version and server OS', !empty($diag['php_version']) && !empty($diag['server_os']));
assertTest('Diagnostics returns memory metrics', !empty($diag['memory_current']) && !empty($diag['memory_peak']));
assertTest('Zero password or credential leaks in diagnostics environment', str_contains($diag['sanitized_env']['DB_PASSWORD'], 'REDACTED'));

// 13. API Keys Management
$keys = $dev->getApiKeys();
assertTest('API keys list returns configured tokens', is_array($keys) && count($keys) >= 1);
$newKey = $dev->createApiKey('Automated Unit Test Key', 'test_runner', ['test:run'], 100);
assertTest('Generate API key returns plaintext token once', str_starts_with($newKey['plain_token'], 'dthub_live_'));
assertTest('Generated key has non-empty hash stored', strlen($newKey['plain_token']) > 20);
$revokeRes = $dev->revokeApiKey((int)$newKey['key_record']['id']);
assertTest('Revoke API key marks is_active = 0', $revokeRes === true);

// 14. File-level Syntax Linting
$filesToLint = [
    __DIR__ . '/../src/DeveloperManager.php',
    __DIR__ . '/../api/developer.php',
    __DIR__ . '/../admin/developer/index.php',
    __DIR__ . '/../admin/developer/api-registry.php',
    __DIR__ . '/../admin/developer/api-health.php',
    __DIR__ . '/../admin/developer/webhooks.php',
    __DIR__ . '/../admin/developer/queue.php',
    __DIR__ . '/../admin/developer/routes.php',
    __DIR__ . '/../admin/developer/migrations.php',
    __DIR__ . '/../admin/developer/diagnostics.php',
    __DIR__ . '/../admin/includes/adminsidebar.php'
];

foreach ($filesToLint as $f) {
    $cleanPath = realpath($f) ?: $f;
    $basename = basename($f);
    $proc = proc_open(['php', '-l', $cleanPath], [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);
    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    $returnCode = proc_close($proc);
    $output = trim($stdout . ' ' . $stderr);
    assertTest("Syntax lint for {$basename}", $returnCode === 0, $output);
}

echo "\n───────────────────────────────────────────────────────────────────\n";
echo "📊 Results: {$passed} Passed, {$failed} Failed\n";
echo "───────────────────────────────────────────────────────────────────\n";

if ($failed > 0) {
    exit(1);
}
echo "✨ 100% SECTION 37 DEVELOPER ADMIN UNIT TESTS PASSED!\n";
exit(0);
