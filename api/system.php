<?php
declare(strict_types=1);

/**
 * api/system.php — DT Brand's System Admin REST Endpoint
 * Section 36 — Enterprise System Governance
 *
 * Bridges the SystemManager service to the Admin UI via JSON API.
 * All state-mutating calls require super_admin role + CSRF + audit trail.
 */

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/_guard.php';
dt_api_require_admin('access system governance');

require_once __DIR__ . '/../src/SystemManager.php';

use DTBrand\SystemManager;

/* ── Parse request ───────────────────────────────────────── */
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$action = '';

if ($method === 'GET') {
    $action = trim((string)($_GET['action'] ?? ''));
} else {
    // Accept application/json or form-encoded POST
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (str_contains($contentType, 'application/json')) {
        $body   = (string)file_get_contents('php://input');
        $parsed = json_decode($body, true);
        if (!is_array($parsed)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid JSON body.']);
            exit;
        }
        $_POST = array_merge($_POST, $parsed);
    }
    $action = trim((string)($_POST['action'] ?? $_POST['section'] ?? ''));
}

$sm = SystemManager::getInstance();

/* ══════════════════════════════════════════════════════════
   READ-ONLY ACTIONS (GET)
══════════════════════════════════════════════════════════ */
if ($method === 'GET') {
    switch ($action) {

        // ── 8-Pillar health check ────────────────────────
        case 'health':
            $result = $sm->runHealthChecks();
            echo json_encode(['success' => true, 'pillars' => $result['pillars'], 'overall' => $result['overall']]);
            break;

        // ── Environment info ─────────────────────────────
        case 'environment':
            echo json_encode(['success' => true, 'environment' => $sm->getEnvironmentInfo()]);
            break;

        // ── System settings ──────────────────────────────
        case 'settings':
            $section = trim((string)($_GET['section'] ?? ''));
            echo json_encode(['success' => true, 'settings' => $sm->getSettings($section ?: null)]);
            break;

        // ── System logs tail ─────────────────────────────
        case 'logs_tail':
            $level  = trim((string)($_GET['level'] ?? ''));
            $limit  = min(200, max(10, (int)($_GET['limit'] ?? 100)));
            echo json_encode(['success' => true, 'logs' => $sm->getSystemLogs($level ?: null, $limit)]);
            break;

        // ── Cron jobs list ───────────────────────────────
        case 'cron_list':
            echo json_encode(['success' => true, 'jobs' => $sm->getCronJobs()]);
            break;

        // ── Feature flags list ───────────────────────────
        case 'feature_flags':
            echo json_encode(['success' => true, 'flags' => $sm->getFeatureFlags()]);
            break;

        // ── Storage usage ────────────────────────────────
        case 'storage':
            echo json_encode(['success' => true, 'storage' => $sm->getStorageInfo()]);
            break;

        // ── Migration list ───────────────────────────────
        case 'migrations':
            echo json_encode(['success' => true, 'migrations' => $sm->getMigrationHistory()]);
            break;

        // ── Cache stats ──────────────────────────────────
        case 'cache_stats':
            echo json_encode(['success' => true, 'cache' => $sm->getCacheStats()]);
            break;

        // ── Maintenance mode status ───────────────────────
        case 'maintenance_status':
            echo json_encode(['success' => true, 'maintenance' => $sm->getMaintenanceStatus()]);
            break;

        // ── Backup list ───────────────────────────────────
        case 'backup_list':
            echo json_encode(['success' => true, 'backups' => $sm->getBackupHistory()]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown GET action: ' . htmlspecialchars($action)]);
            break;
    }
    exit;
}

/* ══════════════════════════════════════════════════════════
   WRITE ACTIONS (POST) — CSRF validated inside SystemManager
══════════════════════════════════════════════════════════ */
if ($method === 'POST') {
    $csrfToken = trim((string)($_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ''));

    switch ($action) {

        // ── General Settings Save ─────────────────────────
        case 'general':
        case 'mail':
        case 'seo':
        case 'b2b':
        case 'payments':
        case 'security':
        case 'notifications_settings':
            $settings = $_POST;
            unset($settings['action'], $settings['section'], $settings['_csrf']);
            $ok = $sm->saveSettings($action, $settings, $csrfToken);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Settings saved successfully.' : 'Failed to save settings. Check CSRF or permissions.',
            ]);
            break;

        // ── Feature Flag Toggle ───────────────────────────
        case 'feature_flag_toggle':
            $key     = trim((string)($_POST['key'] ?? ''));
            $enabled = (bool)($_POST['enabled'] ?? false);
            if ($key === '') {
                echo json_encode(['success' => false, 'message' => 'Feature flag key is required.']);
                break;
            }
            $ok = $sm->setFeatureFlag($key, $enabled, $csrfToken);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Flag "' . htmlspecialchars($key) . '" ' . ($enabled ? 'enabled' : 'disabled') . '.' : 'Flag update failed.',
            ]);
            break;

        // ── Manual Cron Run ───────────────────────────────
        case 'cron_run':
            $job = trim((string)($_POST['job'] ?? ''));
            if ($job === '') {
                echo json_encode(['success' => false, 'message' => 'Cron job name required.']);
                break;
            }
            $result = $sm->runCronJob($job, $csrfToken);
            echo json_encode([
                'success' => $result['success'],
                'message' => $result['message'] ?? 'Cron job dispatched.',
            ]);
            break;

        // ── Cron Toggle Enable/Disable ────────────────────
        case 'cron_toggle':
            $job     = trim((string)($_POST['job'] ?? ''));
            $enabled = (bool)($_POST['enabled'] ?? false);
            $ok = $sm->setCronEnabled($job, $enabled, $csrfToken);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Cron "' . htmlspecialchars($job) . '" ' . ($enabled ? 'enabled' : 'paused') . '.' : 'Update failed.',
            ]);
            break;

        // ── Cache Purge ───────────────────────────────────
        case 'cache_purge':
            $type = trim((string)($_POST['type'] ?? 'all'));
            $result = $sm->purgeCache($type, $csrfToken);
            echo json_encode([
                'success' => $result['success'],
                'message' => $result['message'] ?? 'Cache purged.',
            ]);
            break;

        // ── Maintenance Mode Toggle ───────────────────────
        case 'maintenance_toggle':
            $enable = (bool)($_POST['enable'] ?? false);
            // Dangerous operation — requires re-auth password
            $password = trim((string)($_POST['password'] ?? ''));
            $verify = $sm->verifyDangerousOperation($password, 'maintenance_toggle', $csrfToken);
            if (!$verify['allowed']) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => $verify['reason'] ?? 'Permission denied.']);
                break;
            }
            $ok = $sm->setMaintenanceMode($enable);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Maintenance mode ' . ($enable ? 'ENABLED' : 'DISABLED') . ' successfully.' : 'Operation failed.',
            ]);
            break;

        // ── Run Backup ────────────────────────────────────
        case 'backup_run':
            $ok = $sm->triggerBackup($csrfToken);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Database backup initiated successfully.' : 'Backup failed to start.',
            ]);
            break;

        // ── Delete Backup ─────────────────────────────────
        case 'backup_delete':
            $file     = trim((string)($_POST['file'] ?? ''));
            $password = trim((string)($_POST['password'] ?? ''));
            $verify = $sm->verifyDangerousOperation($password, 'backup_delete', $csrfToken);
            if (!$verify['allowed']) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => $verify['reason']]);
                break;
            }
            $ok = $sm->deleteBackup($file);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Backup deleted.' : 'Delete failed — file not found.',
            ]);
            break;

        // ── Flush System Logs ─────────────────────────────
        case 'logs_flush':
            $password = trim((string)($_POST['password'] ?? ''));
            $level    = trim((string)($_POST['level'] ?? ''));
            $verify = $sm->verifyDangerousOperation($password, 'logs_flush', $csrfToken);
            if (!$verify['allowed']) {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => $verify['reason']]);
                break;
            }
            $ok = $sm->flushSystemLogs($level ?: null);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'System logs flushed.' : 'Flush failed.',
            ]);
            break;

        // ── DB Optimize ───────────────────────────────────
        case 'db_optimize':
            $ok = $sm->optimizeDatabase($csrfToken);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Database tables optimized and defragmented.' : 'Optimization failed.',
            ]);
            break;

        // ── Save Cron Schedule ────────────────────────────
        case 'cron_save':
            $job      = trim((string)($_POST['job'] ?? ''));
            $schedule = trim((string)($_POST['schedule'] ?? ''));
            if ($job === '' || $schedule === '') {
                echo json_encode(['success' => false, 'message' => 'Job name and schedule are required.']);
                break;
            }
            $ok = $sm->saveCronSchedule($job, $schedule, $csrfToken);
            echo json_encode([
                'success' => $ok,
                'message' => $ok ? 'Cron schedule saved.' : 'Save failed.',
            ]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown POST action: ' . htmlspecialchars($action)]);
            break;
    }
    exit;
}

/* ── Method Not Allowed ──────────────────────────────────── */
http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
