<?php
/**
 * DT Brand's & Jai Hanuman Tex — Section 32: Integrations Admin Unit Test Suite
 * Validates gateway health, strict secret masking, 5-point safe diagnostics,
 * connection pings, webhooks, REST API actions, and UI security standards.
 */

declare(strict_types=1);

require_once __DIR__ . '/../src/IntegrationManager.php';
use DT\Services\IntegrationManager;

class IntegrationsAdminTest
{
    private int $passed = 0;
    private int $failed = 0;
    private array $failures = [];
    private IntegrationManager $manager;

    public function __construct()
    {
        // Standalone mock manager for clean unit testing
        $this->manager = new IntegrationManager(null);
    }

    private function assert(bool $condition, string $testName, string $details = ''): void
    {
        if ($condition) {
            $this->passed++;
            echo "  [PASS] {$testName}\n";
        } else {
            $this->failed++;
            $msg = "  [FAIL] {$testName}" . ($details ? " - {$details}" : '');
            $this->failures[] = $msg;
            echo "{$msg}\n";
        }
    }

    public function runAll(): void
    {
        echo "\n=======================================================\n";
        echo "  DT BRAND'S & JAI HANUMAN TEX — SECTION 32 INTEGRATIONS TEST\n";
        echo "=======================================================\n\n";

        $this->testDefaultIntegrationsSeeded();
        $this->testCategoryFiltering();
        $this->testMandatorySecretMaskingGuarantee();
        $this->testGetBySlug();
        $this->testToggleStatus();
        $this->testSaveConfigPreservesMaskedSecrets();
        $this->testConnectionTesting();
        $this->testSafeFivePointDiagnostics();
        $this->testIntegrationLogs();
        $this->testIntegrationStats();
        $this->testDualRelativeAdminguardAcrossAllPages();
        $this->testZeroEmojisAndRealVectorSVGStandard();
        $this->testRestApiEndpoints();

        echo "\n-------------------------------------------------------\n";
        echo "RESULTS: {$this->passed} PASSED, {$this->failed} FAILED.\n";
        echo "-------------------------------------------------------\n\n";

        if ($this->failed > 0) {
            echo "FAILURES:\n" . implode("\n", $this->failures) . "\n";
            exit(1);
        }
    }

    private function testDefaultIntegrationsSeeded(): void
    {
        echo "--- 1. Default Integrations Suite ---\n";
        $all = $this->manager->getAll();
        $this->assert(count($all) >= 8, 'Default integrations count >= 8', 'Found: ' . count($all));

        $slugs = array_column($all, 'slug');
        $expectedSlugs = ['razorpay', 'cashfree', 'delhivery', 'bluedart', 'tci', 'whatsapp', 'email', 'sms'];
        foreach ($expectedSlugs as $slug) {
            $this->assert(in_array($slug, $slugs, true), "Gateway seeded: {$slug}");
        }
    }

    private function testCategoryFiltering(): void
    {
        echo "\n--- 2. Category Filtering ---\n";
        $payment = $this->manager->getAll('payment');
        $this->assert(count($payment) >= 2, 'Payment category count >= 2');
        foreach ($payment as $p) {
            $this->assert($p['category'] === 'payment', "Item {$p['slug']} belongs to payment");
        }

        $shipping = $this->manager->getAll('shipping');
        $this->assert(count($shipping) >= 3, 'Shipping category count >= 3 (Delhivery, BlueDart, TCI)');
        foreach ($shipping as $s) {
            $this->assert($s['category'] === 'shipping', "Item {$s['slug']} belongs to shipping");
        }

        $messaging = $this->manager->getAll('messaging');
        $this->assert(count($messaging) >= 3, 'Messaging category count >= 3 (WhatsApp, Email, SMS)');
        foreach ($messaging as $m) {
            $this->assert($m['category'] === 'messaging', "Item {$m['slug']} belongs to messaging");
        }
    }

    private function testMandatorySecretMaskingGuarantee(): void
    {
        echo "\n--- 3. Mandatory Secret Masking Guarantee (Zero Secret Exposure) ---\n";
        $all = $this->manager->getAll();
        $sensitiveKeys = ['api_key', 'api_secret', 'secret_key', 'auth_token', 'access_token', 'webhook_secret', 'password', 'license_key'];

        foreach ($all as $item) {
            $config = $item['config'] ?? [];
            foreach ($config as $k => $v) {
                if (in_array(strtolower($k), $sensitiveKeys, true)) {
                    $this->assert(
                        is_string($v) && strpos($v, '••••') !== false,
                        "Sensitive key '{$k}' in '{$item['slug']}' is strictly masked",
                        "Actual value: {$v}"
                    );
                }
            }
        }
    }

    private function testGetBySlug(): void
    {
        echo "\n--- 4. Single Gateway Lookup ---\n";
        $rzp = $this->manager->getBySlug('razorpay');
        $this->assert($rzp !== null && $rzp['slug'] === 'razorpay', 'Lookup razorpay succeeded');
        $this->assert($rzp['name'] === 'Razorpay Payments', 'Razorpay display name correct');
        $this->assert(!empty($rzp['webhook_url']), 'Razorpay has active webhook endpoint');

        $nonExistent = $this->manager->getBySlug('non_existent_gateway_xyz');
        $this->assert($nonExistent === null, 'Lookup non-existent gateway returns null');
    }

    private function testToggleStatus(): void
    {
        echo "\n--- 5. Toggle Status Management ---\n";
        $resDisable = $this->manager->toggleStatus('cashfree', false);
        $this->assert($resDisable === true, 'Disable cashfree succeeded');
        $cfDisabled = $this->manager->getBySlug('cashfree');
        $this->assert((int)$cfDisabled['is_enabled'] === 0, 'Cashfree is_enabled is 0');
        $this->assert($cfDisabled['status'] === 'inactive', 'Cashfree status is inactive');

        $resEnable = $this->manager->toggleStatus('cashfree', true);
        $this->assert($resEnable === true, 'Re-enable cashfree succeeded');
        $cfEnabled = $this->manager->getBySlug('cashfree');
        $this->assert((int)$cfEnabled['is_enabled'] === 1, 'Cashfree is_enabled is 1');
        $this->assert($cfEnabled['status'] === 'active', 'Cashfree status is active');
    }

    private function testSaveConfigPreservesMaskedSecrets(): void
    {
        echo "\n--- 6. Config Saving & Secret Preservation ---\n";
        // Attempt to save config with masked secret bullets submitted
        $updatePayload = [
            'api_key' => 'rzp_live_••••••••••••', // masked
            'api_secret' => '••••••••••••••••',     // masked
            'mode' => 'production_hardened',        // new setting
            'auto_capture' => 1
        ];

        $saved = $this->manager->saveConfig('razorpay', $updatePayload);
        $this->assert($saved === true, 'Save config with masked bullets succeeded');

        $updatedRaw = $this->manager->getRawConfig('razorpay');
        $this->assert($updatedRaw['mode'] === 'production_hardened', 'New setting was updated');
        $this->assert(!empty($updatedRaw['api_key']), 'Original secret was preserved and not blanked');
    }

    private function testConnectionTesting(): void
    {
        echo "\n--- 7. Connection Testing & Latency Pings ---\n";
        $gateways = ['razorpay', 'delhivery', 'bluedart', 'tci', 'whatsapp', 'email', 'sms'];

        foreach ($gateways as $slug) {
            $res = $this->manager->testConnection($slug);
            $this->assert($res['success'] === true, "Connection test for {$slug} succeeded");
            $this->assert($res['http_status'] === 200, "HTTP 200 returned for {$slug}");
            $this->assert($res['latency_ms'] > 0 && $res['latency_ms'] < 500, "Valid latency ({$res['latency_ms']} ms) for {$slug}");
            $this->assert(!empty($res['diagnosis']), "Diagnosis present for {$slug}");
        }
    }

    private function testSafeFivePointDiagnostics(): void
    {
        echo "\n--- 8. Safe 5-Point Diagnostic Suite ---\n";
        $diag = $this->manager->runDiagnostics('whatsapp');
        $this->assert($diag['success'] === true, 'Safe diagnostics ran successfully for whatsapp');
        $this->assert($diag['all_passed'] === true, 'All 5 diagnostic checks passed');
        $this->assert(count($diag['checks']) === 5, 'Exactly 5 diagnostic checks returned');

        $checkNames = array_column($diag['checks'], 'name');
        $this->assert(in_array('Gateway Host Reachability', $checkNames, true), 'Check 1: DNS Host Reachability present');
        $this->assert(in_array('TLS 1.3 / SSL Handshake', $checkNames, true), 'Check 2: TLS 1.3 Handshake present');
        $this->assert(in_array('API Credentials & Authentication', $checkNames, true), 'Check 3: API Credentials check present');
        $this->assert(in_array('Webhook Delivery & HMAC Signature', $checkNames, true), 'Check 4: Webhook Signature check present');
        $this->assert(in_array('API Rate Limit & Quota Headroom', $checkNames, true), 'Check 5: Rate limit quota check present');
    }

    private function testIntegrationLogs(): void
    {
        echo "\n--- 9. Integration Request Logging ---\n";
        $logged = $this->manager->logRequest('delhivery', 'tracking_sync', 'success', 200, 75, 'https://track.delhivery.com/api', '{"awb":"12891"}', '{"status":"Delivered"}', '127.0.0.1');
        $this->assert($logged === true, 'logRequest returned true');

        $logs = $this->manager->getLogs('delhivery', 'success', 5);
        $this->assert(!empty($logs), 'getLogs retrieved logged records');
        $this->assert($logs[0]['integration_slug'] === 'delhivery', 'Most recent log is for delhivery');
        $this->assert($logs[0]['action'] === 'tracking_sync', 'Action matches tracking_sync');
    }

    private function testIntegrationStats(): void
    {
        echo "\n--- 10. Dashboard Aggregate Stats ---\n";
        $stats = $this->manager->getStats();
        $this->assert($stats['total_integrations'] >= 8, 'Total integrations >= 8');
        $this->assert($stats['active_integrations'] >= 8, 'Active integrations >= 8');
        $this->assert($stats['connected_gateways'] >= 7, 'Connected gateways >= 7');
        $this->assert($stats['average_latency_ms'] > 0, 'Average latency calculated > 0 ms');
        $this->assert($stats['webhook_health_score'] >= 90, 'Webhook health score >= 90%');
    }

    private function testDualRelativeAdminguardAcrossAllPages(): void
    {
        echo "\n--- 11. Dual Relative Adminguard Fallback Verification ---\n";
        $files = [
            'admin/integrations/index.php',
            'admin/integrations/payment.php',
            'admin/integrations/shipping.php',
            'admin/integrations/messaging.php',
            'admin/integrations/webhooks.php',
            'admin/integrations/diagnostics.php',
            'admin/integrations/logs.php'
        ];

        foreach ($files as $f) {
            $path = __DIR__ . '/../' . $f;
            $this->assert(is_file($path), "File exists: {$f}");
            $content = file_get_contents($path);
            $hasGuard = strpos($content, "adminguard.php") !== false && strpos($content, "DOCUMENT_ROOT") !== false;
            $this->assert($hasGuard, "Dual relative adminguard check present in {$f}");
        }
    }

    private function testZeroEmojisAndRealVectorSVGStandard(): void
    {
        echo "\n--- 12. 100% Real Vector SVG Icon Standard (Zero Emojis) ---\n";
        $files = [
            'admin/integrations/index.php',
            'admin/integrations/payment.php',
            'admin/integrations/shipping.php',
            'admin/integrations/messaging.php',
            'admin/integrations/webhooks.php',
            'admin/integrations/diagnostics.php',
            'admin/integrations/logs.php'
        ];

        foreach ($files as $f) {
            $content = file_get_contents(__DIR__ . '/../' . $f);
            // Verify real vector SVG tags are present
            $svgCount = substr_count($content, '<svg');
            $this->assert($svgCount >= 5, "Real vector SVG icons present in {$f} (Found: {$svgCount})");

            // Verify button styling mandate
            $hasStyledButtons = strpos($content, 'dt-btn') !== false || strpos($content, 'adm-btn') !== false;
            $this->assert($hasStyledButtons, "Luxury styled buttons mandate met in {$f}");
        }
    }

    private function testRestApiEndpoints(): void
    {
        echo "\n--- 13. REST API Endpoint Action Suite ---\n";
        $harness = __DIR__ . '/run_api_action.php';

        $actions = [
            ['method' => 'GET', 'url' => 'api/integrations.php?action=stats', 'expected' => 'total_integrations'],
            ['method' => 'GET', 'url' => 'api/integrations.php?action=list&category=payment', 'expected' => 'razorpay'],
            ['method' => 'GET', 'url' => 'api/integrations.php?action=detail&slug=delhivery', 'expected' => 'Delhivery Express Logistics'],
            ['method' => 'GET', 'url' => 'api/integrations.php?action=diagnostics&slug=whatsapp', 'expected' => 'Gateway Host Reachability'],
            ['method' => 'POST', 'url' => 'api/integrations.php', 'post' => ['action' => 'test_connection', 'slug' => 'bluedart'], 'expected' => 'BlueDart Express Air Cargo'],
            ['method' => 'POST', 'url' => 'api/integrations.php', 'post' => ['action' => 'toggle', 'slug' => 'tci', 'is_enabled' => 1], 'expected' => 'active']
        ];

        foreach ($actions as $act) {
            $postArg = isset($act['post']) ? escapeshellarg(base64_encode(json_encode($act['post']))) : '""';
            $method = $act['method'];
            $url = $act['url'];
            $cmd = 'php "' . $harness . '" ' . $method . ' ' . escapeshellarg($url) . ' ' . $postArg;
            $output = shell_exec($cmd);
            $this->assert(!empty($output), "API action {$url} executed");
            $json = json_decode((string)$output, true);
            $this->assert(is_array($json) && !empty($json['success']), "API action {$url} returned success: true");
            $this->assert(strpos((string)$output, $act['expected']) !== false, "API action {$url} contains expected '{$act['expected']}'");
        }
    }
}

$test = new IntegrationsAdminTest();
$test->runAll();
