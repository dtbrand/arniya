<?php
/**
 * tests/test_unit_api_security_headers_uploads.php
 * Automated Test Suite for Sections 55–61:
 * - Section 55 & 56: Enterprise API Security & Completeness (Admin lockdown of all admin endpoints)
 * - Section 57: Safe Error Handling & Diagnostics (dt_api_error_response, correlation ID, error masking)
 * - Section 58: Safe Public Diagnostics (api/health.php zero-leakage check)
 * - Section 59: Secure Upload Architecture (MIME verification, derived extensions, .htaccess execution block)
 * - Section 60 & 61: Security Headers & HTTPS Cookie Security (CORS, CSRF headers, Permissions-Policy, HSTS, X-Frame-Options)
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../api/_guard.php';
require_once __DIR__ . '/../api/cors.php';

use DTBrand\Database;

$passed = 0;
$failed = 0;
$tests  = [];

function run_test(string $name, callable $fn): void {
    global $passed, $failed, $tests;
    try {
        $result = $fn();
        if ($result === true) {
            $passed++;
            $tests[] = ['name' => $name, 'status' => 'PASS', 'error' => null];
            echo "  [PASS] {$name}\n";
        } else {
            $failed++;
            $tests[] = ['name' => $name, 'status' => 'FAIL', 'error' => 'Returned false'];
            echo "  [FAIL] {$name}: Returned false\n";
        }
    } catch (\Throwable $e) {
        $failed++;
        $tests[] = ['name' => $name, 'status' => 'FAIL', 'error' => $e->getMessage()];
        echo "  [FAIL] {$name}: " . $e->getMessage() . "\n";
    }
}

/**
 * Robust cross-platform subprocess invoker via proc_open stdin pipe.
 * Uses register_shutdown_function to capture http_response_code and output even after exit;.
 */
function invoke_endpoint(string $scriptRelativePath, ?array $session = null, array $get = [], array $post = [], array $server = []): array {
    $target = realpath(__DIR__ . '/../' . $scriptRelativePath);
    if (!$target || !file_exists($target)) {
        return ['status' => 404, 'body' => '', 'json' => null];
    }

    $code = "<?php\n";
    $code .= "register_shutdown_function(function() {\n";
    $code .= "    \$out = ob_get_clean();\n";
    $code .= "    \$code = http_response_code();\n";
    $code .= "    echo '__DT_SPLIT__' . json_encode(['status' => \$code, 'output' => \$out]);\n";
    $code .= "});\n";
    $code .= "ob_start();\n";
    if ($session !== null) {
        $code .= "\$_SESSION = " . var_export($session, true) . ";\n";
    } else {
        $code .= "\$_SESSION = [];\n";
    }
    $code .= "\$_GET = " . var_export($get, true) . ";\n";
    $code .= "\$_POST = " . var_export($post, true) . ";\n";
    $code .= "\$_SERVER = array_merge([\n";
    $code .= "    'REQUEST_METHOD' => " . var_export($post ? 'POST' : 'GET', true) . ",\n";
    $code .= "    'REMOTE_ADDR' => '127.0.0.1',\n";
    $code .= "    'HTTP_HOST' => 'localhost',\n";
    $code .= "], " . var_export($server, true) . ");\n";
    $code .= "require " . var_export($target, true) . ";\n";

    $descriptors = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w']
    ];
    $proc = proc_open('php', $descriptors, $pipes);
    if (!is_resource($proc)) {
        return ['status' => 0, 'body' => '', 'json' => null];
    }
    fwrite($pipes[0], $code);
    fclose($pipes[0]);
    $raw = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($proc);

    $parts = explode('__DT_SPLIT__', $raw);
    if (count($parts) < 2) {
        $json = json_decode($raw, true);
        return ['status' => 200, 'body' => $raw, 'json' => $json];
    }
    $meta = json_decode($parts[1], true);
    $status = (!empty($meta['status']) && is_numeric($meta['status'])) ? (int)$meta['status'] : 200;
    $body = $meta['output'] ?? '';
    return [
        'status' => $status,
        'body'   => $body,
        'json'   => json_decode($body, true)
    ];
}

echo "\n========================================================================\n";
echo "   DT BRAND'S ENTERPRISE API SECURITY & HEADERS SUITE (SECTIONS 55–61)\n";
echo "========================================================================\n\n";

// ============================================================================
// SECTION 55 & 56: ENTERPRISE API SECURITY & ADMIN LOCKDOWN
// ============================================================================
echo "--- Sections 55 & 56: API Security & Admin Lockdown ---\n";

run_test("Sec55.1: api/reports.php Blocks Unauthenticated Access (401)", function() {
    $res = invoke_endpoint('api/reports.php', null, ['action' => 'dashboard_kpis']);
    return $res['status'] === 401 && ($res['json']['error'] ?? '') === 'unauthorized';
});

run_test("Sec55.2: api/notifications.php Blocks Unauthenticated Access (401)", function() {
    $res = invoke_endpoint('api/notifications.php', null, ['action' => 'list']);
    return $res['status'] === 401 && ($res['json']['error'] ?? '') === 'unauthorized';
});

run_test("Sec55.3: api/seed_demo_catalog.php Blocks Unauthenticated Access (401)", function() {
    $res = invoke_endpoint('api/seed_demo_catalog.php', null);
    return $res['status'] === 401 && ($res['json']['error'] ?? '') === 'unauthorized';
});

run_test("Sec55.4: api/system.php Blocks Unauthenticated Access (401)", function() {
    $res = invoke_endpoint('api/system.php', null, ['action' => 'health']);
    return $res['status'] === 401 && ($res['json']['error'] ?? '') === 'unauthorized';
});

run_test("Sec55.5: api/developer.php Blocks Ordinary Customers Having user_id (401)", function() {
    // Customer session: has user_id but role is customer
    $customerSession = [
        'user_id' => 888,
        'user' => ['id' => 888, 'role' => 'customer', 'name' => 'Shopper Test']
    ];
    $res = invoke_endpoint('api/developer.php', $customerSession, ['action' => 'telemetry']);
    return $res['status'] === 401 && ($res['json']['error'] ?? '') === 'unauthorized';
});

run_test("Sec55.6: api/developer.php Allows Authenticated Admin", function() {
    $adminSession = [
        'admin_logged_in' => true,
        'admin_user' => ['id' => 1, 'role' => 'super_admin']
    ];
    $res = invoke_endpoint('api/developer.php', $adminSession, ['action' => 'telemetry']);
    return $res['status'] === 200 && ($res['json']['status'] ?? '') === 'success';
});

run_test("Sec55.7: api/integrations.php Blocks Unauthenticated Access (401)", function() {
    $res = invoke_endpoint('api/integrations.php', null, ['action' => 'stats']);
    return $res['status'] === 401 && ($res['json']['error'] ?? '') === 'unauthorized';
});

run_test("Sec55.8: api/integrations.php Allows Authenticated Admin", function() {
    $adminSession = [
        'admin_logged_in' => true,
        'admin_user' => ['id' => 1, 'role' => 'super_admin']
    ];
    $res = invoke_endpoint('api/integrations.php', $adminSession, ['action' => 'stats']);
    return $res['status'] === 200 && isset($res['json']['stats']);
});

run_test("Sec55.9: api/db_health.php Blocks Unauthenticated Access (401)", function() {
    $res = invoke_endpoint('api/db_health.php', null, ['action' => 'status']);
    return $res['status'] === 401 && ($res['json']['error'] ?? '') === 'unauthorized';
});

run_test("Sec55.10: api/db_sync.php Is Permanently Disabled (403 Forbidden)", function() {
    $res = invoke_endpoint('api/db_sync.php', null, ['key' => 'Gautam9006MasterInstall']);
    return $res['status'] === 403 && ($res['json']['error'] ?? '') === 'forbidden';
});

// ============================================================================
// SECTION 57: SAFE ERROR HANDLING & CORRELATION IDS
// ============================================================================
echo "--- Section 57: Safe Error Handling & Correlation IDs ---\n";

run_test("Sec57.1: dt_api_error_response Generates Masked Error & Correlation ID", function() {
    ob_start();
    try {
        throw new \RuntimeException("Table 'u602484543_demodt121.secret_credentials' doesn't exist for user 'db_admin' using password 'SuperSecretPassword'");
    } catch (\Throwable $e) {
        dt_api_error_response($e, 500, 'test_unit', false);
    }
    $output = ob_get_clean();
    $data = json_decode($output, true);

    if (!is_array($data)) {
        return false;
    }

    // Must have success: false
    if (($data['success'] ?? true) !== false) {
        return false;
    }

    // Must have request_id correlation UUID (12+ hex characters)
    $requestId = $data['request_id'] ?? '';
    if (empty($requestId) || !preg_match('/^req_[a-f0-9]{12,}$/', $requestId)) {
        return false;
    }

    // Must NOT leak database credentials or table names in client message
    if (strpos($data['message'] ?? '', 'SuperSecretPassword') !== false) {
        return false;
    }
    if (strpos($data['message'] ?? '', 'secret_credentials') !== false) {
        return false;
    }

    return true;
});

run_test("Sec57.2: dt_api_error_response Returns Safe Generic Message in Production", function() {
    ob_start();
    try {
        throw new \PDOException("SQLSTATE[HY000] [2002] Connection refused host=147.93.99.134 port=3306");
    } catch (\Throwable $e) {
        dt_api_error_response($e, 503, 'pdo_test', false);
    }
    $output = ob_get_clean();
    $data = json_decode($output, true);

    // Should be generic and not contain IP address
    return isset($data['message']) && strpos($data['message'], '147.93.99.134') === false;
});

// ============================================================================
// SECTION 58: SAFE PUBLIC DIAGNOSTICS
// ============================================================================
echo "--- Section 58: Safe Public Diagnostics ---\n";

run_test("Sec58.1: api/health.php Returns 200 with Subsystem Statuses", function() {
    $res = invoke_endpoint('api/health.php', null);
    if ($res['status'] !== 200 || !is_array($res['json'])) {
        return false;
    }

    $json = $res['json'];
    return ($json['status'] ?? '') === 'healthy' 
        && isset($json['subsystems']['api_router'])
        && isset($json['subsystems']['cart_session']);
});

run_test("Sec58.2: api/health.php Zero Credentials & Zero Hostname Leakage", function() {
    $res = invoke_endpoint('api/health.php', null);
    $body = $res['body'];

    $forbiddenStrings = ['Gautam@9006', 'u602484543', '147.93.99.134', 'password', 'secret'];
    foreach ($forbiddenStrings as $str) {
        if (stripos($body, $str) !== false) {
            return false;
        }
    }
    return true;
});

// ============================================================================
// SECTION 59: SECURE FILE UPLOAD ARCHITECTURE
// ============================================================================
echo "--- Section 59: Secure File Upload Architecture ---\n";

run_test("Sec59.1: api/upload.php Blocks Anonymous / Non-Admin Uploads (401)", function() {
    $res = invoke_endpoint('api/upload.php', null, [], ['action' => 'upload']);
    return $res['status'] === 401 && ($res['json']['error'] ?? '') === 'unauthorized';
});

run_test("Sec59.2: Upload Directory .htaccess Exists & Blocks Script Execution", function() {
    $uploadDir = realpath(__DIR__ . '/../assets/images/uploads');
    if (!$uploadDir || !is_dir($uploadDir)) {
        mkdir(__DIR__ . '/../assets/images/uploads', 0755, true);
        $uploadDir = realpath(__DIR__ . '/../assets/images/uploads');
    }

    $htaccess = $uploadDir . '/.htaccess';
    if (!file_exists($htaccess)) {
        // Trigger upload.php in admin mode to generate .htaccess if missing
        invoke_endpoint('api/upload.php', ['admin_logged_in' => true, 'admin_user' => ['id' => 1, 'role' => 'admin']], [], ['action' => 'upload']);
    }

    if (!file_exists($htaccess)) {
        return false;
    }

    $content = file_get_contents($htaccess);
    return strpos($content, 'php_flag engine off') !== false
        && strpos($content, 'Require all denied') !== false;
});

// ============================================================================
// SECTION 60 & 61: SECURITY HEADERS & HTTPS COOKIE SECURITY
// ============================================================================
echo "--- Sections 60 & 61: Security Headers & HTTPS Cookie Security ---\n";

run_test("Sec60.1: cors_headers() Whitelists CSRF Headers", function() {
    $code = "<?php
    require_once " . var_export(realpath(__DIR__ . '/../api/cors.php'), true) . ";
    cors_headers();
    echo json_encode(cors_get_sent_headers());
    ";
    $descriptors = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $proc = proc_open('php', $descriptors, $pipes);
    fwrite($pipes[0], $code);
    fclose($pipes[0]);
    $out = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($proc);
    $headers = json_decode((string)$out, true) ?: [];

    $allowHeaders = '';
    foreach ($headers as $h) {
        if (stripos($h, 'Access-Control-Allow-Headers:') === 0) {
            $allowHeaders = $h;
            break;
        }
    }

    return stripos($allowHeaders, 'X-CSRF-Token') !== false
        && stripos($allowHeaders, 'X-XSRF-Token') !== false;
});

run_test("Sec60.2: cors_headers() Enforces Permissions-Policy & Frame Options", function() {
    $code = "<?php
    require_once " . var_export(realpath(__DIR__ . '/../api/cors.php'), true) . ";
    cors_headers();
    echo json_encode(cors_get_sent_headers());
    ";
    $descriptors = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $proc = proc_open('php', $descriptors, $pipes);
    fwrite($pipes[0], $code);
    fclose($pipes[0]);
    $out = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($proc);
    $headers = json_decode((string)$out, true) ?: [];

    $hasPermissionsPolicy = false;
    $hasFrameOptions = false;
    $hasContentTypeOptions = false;

    foreach ($headers as $h) {
        if (stripos($h, 'Permissions-Policy:') === 0 && stripos($h, 'geolocation=()') !== false) {
            $hasPermissionsPolicy = true;
        }
        if (stripos($h, 'X-Frame-Options: SAMEORIGIN') === 0) {
            $hasFrameOptions = true;
        }
        if (stripos($h, 'X-Content-Type-Options: nosniff') === 0) {
            $hasContentTypeOptions = true;
        }
    }

    return $hasPermissionsPolicy && $hasFrameOptions && $hasContentTypeOptions;
});

run_test("Sec60.3: cors_headers() Enforces HSTS on HTTPS Requests", function() {
    $code = "<?php
    \$_SERVER['HTTPS'] = 'on';
    require_once " . var_export(realpath(__DIR__ . '/../api/cors.php'), true) . ";
    cors_headers();
    echo json_encode(cors_get_sent_headers());
    ";
    $descriptors = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $proc = proc_open('php', $descriptors, $pipes);
    fwrite($pipes[0], $code);
    fclose($pipes[0]);
    $out = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($proc);
    $headers = json_decode((string)$out, true) ?: [];

    $hasHsts = false;
    foreach ($headers as $h) {
        if (stripos($h, 'Strict-Transport-Security:') === 0 && stripos($h, 'max-age=31536000') !== false) {
            $hasHsts = true;
            break;
        }
    }

    return $hasHsts;
});

run_test("Sec61.1: Session Cookies Configured with HttpOnly & SameSite Lax", function() {
    $code = "<?php
    require_once " . var_export(realpath(__DIR__ . '/../config/session.php'), true) . ";
    echo json_encode([
        'httponly' => ini_get('session.cookie_httponly'),
        'samesite' => ini_get('session.cookie_samesite')
    ]);
    ";
    $descriptors = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $proc = proc_open('php', $descriptors, $pipes);
    fwrite($pipes[0], $code);
    fclose($pipes[0]);
    $out = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($proc);
    $data = json_decode((string)$out, true) ?: [];

    return ($data['httponly'] === '1' || $data['httponly'] === true)
        && strtolower((string)$data['samesite']) === 'lax';
});

echo "\n========================================================================\n";
echo "   RESULTS: {$passed} PASSED / " . ($passed + $failed) . " TOTAL (" . ($failed === 0 ? "100% SUCCESS" : "FAILURES DETECTED") . ")\n";
echo "========================================================================\n\n";

exit($failed > 0 ? 1 : 0);
