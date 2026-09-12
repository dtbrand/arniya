<?php
declare(strict_types=1);

/**
 * api/developer.php — Developer & API Administration Suite REST API
 * DT Brand's & Jai Hanuman Tex
 *
 * Section 37: Developer / API Admin Endpoint
 * Actions: telemetry, api_list, api_ping, curl_snippet, webhooks, webhook_retry,
 * hmac_test, queue, queue_run, queue_retry, routes, migrations, diagnostics,
 * api_keys, api_key_create, api_key_revoke.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');

require_once __DIR__ . '/../src/DeveloperManager.php';
require_once __DIR__ . '/../src/AuditManager.php';

use DTBrand\DeveloperManager;
use DTBrand\AuditManager;

// Admin authentication gate
$isAdmin = !empty($_SESSION['admin_logged_in']) || !empty($_SESSION['admin_user']) || !empty($_SESSION['user_id']);
if (!$isAdmin) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized: Administrator authentication required.'], JSON_UNESCAPED_SLASHES);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$action = $_GET['action'] ?? $_POST['action'] ?? 'telemetry';

// Enforce CSRF check for state-mutating actions
$mutatingActions = ['webhook_retry', 'queue_run', 'queue_retry', 'api_key_create', 'api_key_revoke'];
if (in_array($action, $mutatingActions, true)) {
    $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';
    if (empty($token) || !hash_equals($sessionToken, $token)) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Forbidden: Invalid or expired CSRF token.'], JSON_UNESCAPED_SLASHES);
        exit;
    }
}

$devManager = DeveloperManager::getInstance();

try {
    switch ($action) {
        case 'telemetry':
            $registry = $devManager->getApiRegistry();
            $health = $devManager->getApiHealth();
            $queueStats = $devManager->getQueueStats();
            $webhooks = $devManager->getWebhookEvents();
            $routes = $devManager->getRouteMap();

            echo json_encode([
                'status' => 'success',
                'action' => 'telemetry',
                'data' => [
                    'total_apis' => count($registry),
                    'health_score' => $health['health_score'],
                    'avg_latency_ms' => $health['avg_latency_ms'],
                    'uptime_percent' => $health['uptime_percent'],
                    'total_webhooks' => count($webhooks),
                    'queue_pending' => $queueStats['pending'] ?? 0,
                    'queue_completed' => $queueStats['completed'] ?? 0,
                    'queue_failed' => $queueStats['failed'] ?? 0,
                    'total_routes' => count($routes),
                    'php_version' => PHP_VERSION,
                    'timestamp' => date('Y-m-d H:i:s')
                ]
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'api_list':
            $registry = $devManager->getApiRegistry();
            echo json_encode([
                'status' => 'success',
                'action' => 'api_list',
                'count' => count($registry),
                'apis' => array_values($registry)
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'api_ping':
            $endpoint = (string)($_POST['endpoint'] ?? $_GET['endpoint'] ?? '/api/health.php');
            $pingMethod = (string)($_POST['method'] ?? $_GET['method'] ?? 'GET');
            $result = $devManager->pingEndpoint($endpoint, strtoupper($pingMethod));

            echo json_encode([
                'status' => 'success',
                'action' => 'api_ping',
                'ping' => $result
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'curl_snippet':
            $endpointKey = (string)($_GET['endpoint'] ?? '/api/health.php');
            $snippet = $devManager->generateCurlSnippet($endpointKey);

            echo json_encode([
                'status' => 'success',
                'endpoint' => $endpointKey,
                'curl' => $snippet
            ], JSON_UNESCAPED_SLASHES);
            break;

        case 'health':
            $health = $devManager->getApiHealth();
            echo json_encode([
                'status' => 'success',
                'action' => 'health',
                'data' => $health
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'webhooks':
            $filter = [
                'status' => $_GET['status'] ?? 'all',
                'gateway' => $_GET['gateway'] ?? 'all',
                'direction' => $_GET['direction'] ?? 'all'
            ];
            $events = $devManager->getWebhookEvents($filter);

            echo json_encode([
                'status' => 'success',
                'action' => 'webhooks',
                'count' => count($events),
                'events' => $events
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'webhook_retry':
            $eventId = (string)($_POST['event_id'] ?? '');
            if (empty($eventId)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Missing event_id parameter.'], JSON_UNESCAPED_SLASHES);
                exit;
            }

            $res = $devManager->retryWebhook($eventId);
            AuditManager::log('developer', 'webhook_retry', ['event_id' => $eventId, 'status' => 'success']);

            echo json_encode([
                'status' => 'success',
                'message' => "Webhook {$eventId} redelivery initiated.",
                'data' => $res
            ], JSON_UNESCAPED_SLASHES);
            break;

        case 'hmac_test':
            $gateway = (string)($_POST['gateway'] ?? 'razorpay');
            $payload = (string)($_POST['payload'] ?? '{}');
            $secret = (string)($_POST['secret'] ?? 'test_secret_123');

            $hmac = $devManager->testHmacSignature($gateway, $payload, $secret);
            echo json_encode([
                'status' => 'success',
                'data' => $hmac
            ], JSON_UNESCAPED_SLASHES);
            break;

        case 'queue':
            $queueStatus = (string)($_GET['status'] ?? 'all');
            $limit = (int)($_GET['limit'] ?? 50);
            $stats = $devManager->getQueueStats();
            $jobs = $devManager->getQueueJobs($queueStatus, $limit);

            echo json_encode([
                'status' => 'success',
                'action' => 'queue',
                'stats' => $stats,
                'jobs' => $jobs
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'queue_run':
            $jobId = (string)($_POST['job_id'] ?? '');
            if (!empty($jobId)) {
                $res = $devManager->runQueueJob($jobId);
                AuditManager::log('developer', 'queue_job_run', ['job_id' => $jobId]);
                $msg = "Queue job {$jobId} processed successfully.";
            } else {
                $res = $devManager->runAllPendingJobs();
                AuditManager::log('developer', 'queue_run_all', ['processed' => $res['processed_count']]);
                $msg = "Processed {$res['processed_count']} pending queue job(s).";
            }

            echo json_encode([
                'status' => 'success',
                'message' => $msg,
                'result' => $res
            ], JSON_UNESCAPED_SLASHES);
            break;

        case 'queue_retry':
            $jobId = (string)($_POST['job_id'] ?? '');
            if (empty($jobId)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Missing job_id parameter.'], JSON_UNESCAPED_SLASHES);
                exit;
            }

            $res = $devManager->retryQueueJob($jobId);
            AuditManager::log('developer', 'queue_job_retry', ['job_id' => $jobId]);

            echo json_encode([
                'status' => 'success',
                'message' => "Job {$jobId} marked for immediate retry.",
                'result' => $res
            ], JSON_UNESCAPED_SLASHES);
            break;

        case 'routes':
            $routes = $devManager->getRouteMap();
            echo json_encode([
                'status' => 'success',
                'action' => 'routes',
                'total_routes' => count($routes),
                'routes' => $routes
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'diagnostics':
            $diag = $devManager->getDiagnostics();
            echo json_encode([
                'status' => 'success',
                'action' => 'diagnostics',
                'diagnostics' => $diag
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'api_keys':
            $keys = $devManager->getApiKeys();
            echo json_encode([
                'status' => 'success',
                'action' => 'api_keys',
                'keys' => $keys
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'api_key_create':
            $name = trim((string)($_POST['name'] ?? 'Production API Key'));
            $role = (string)($_POST['role'] ?? 'read_only');
            $scopes = isset($_POST['scopes']) ? (array)$_POST['scopes'] : ['catalog:read'];
            $rateLimit = (int)($_POST['rate_limit'] ?? 120);

            $newKey = $devManager->createApiKey($name, $role, $scopes, $rateLimit, (int)($_SESSION['user_id'] ?? 1));
            AuditManager::log('developer', 'api_key_created', ['key_prefix' => $newKey['key_record']['key_prefix']]);

            echo json_encode([
                'status' => 'success',
                'message' => 'API Key created successfully.',
                'data' => $newKey
            ], JSON_UNESCAPED_SLASHES);
            break;

        case 'api_key_revoke':
            $keyId = (int)($_POST['id'] ?? 0);
            if ($keyId <= 0) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Missing or invalid key ID.'], JSON_UNESCAPED_SLASHES);
                exit;
            }

            $devManager->revokeApiKey($keyId);
            AuditManager::log('developer', 'api_key_revoked', ['key_id' => $keyId]);

            echo json_encode([
                'status' => 'success',
                'message' => "API Key ID {$keyId} revoked successfully."
            ], JSON_UNESCAPED_SLASHES);
            break;

        default:
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => "Unknown action: '{$action}'."
            ], JSON_UNESCAPED_SLASHES);
            break;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Internal server error: ' . $e->getMessage()
    ], JSON_UNESCAPED_SLASHES);
}
