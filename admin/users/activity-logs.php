<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * activity-logs.php — Security Audit & Activity Trail
 * DT Brand's & Jai Hanuman Tex
 *
 * Previously one hardcoded row ("Gautam Sethi updated Price Matrix from
 * 147.93.99.134") — an event that never happened and was recorded nowhere.
 * This page now reads the real `audit_logs` table (newest first). Staff
 * sign-ins are derived from the users table's real last_login column, so the
 * trail is honest even before other modules start writing audit rows.
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Security Audit & Activity Trail";
$active_nav = "users";

$events = [];
$logsUnavailable = false;

$pdoLog = Database::getConnection();
if ($pdoLog === null || Database::isMockMode()) {
    $logsUnavailable = true;
} else {
    try {
        $events = Database::query(
            'SELECT user_name, action, entity_type, entity_id, ip_address, created_at
             FROM audit_logs
             ORDER BY created_at DESC, id DESC
             LIMIT 100'
        );
    } catch (\Throwable $e) {
        $events = [];
    }

    // Real sign-in events from the users table (no per-login IP is stored in
    // this schema, so the column stays blank rather than inventing one).
    try {
        foreach (Database::query(
            "SELECT name, role, last_login FROM users WHERE last_login IS NOT NULL ORDER BY last_login DESC LIMIT 25"
        ) as $s) {
            $events[] = [
                'user_name'   => $s['name'] . ' (' . ucfirst((string)$s['role']) . ')',
                'action'      => 'signed_in',
                'entity_type' => 'session',
                'entity_id'   => 'admin login',
                'ip_address'  => null,
                'created_at'  => $s['last_login'],
            ];
        }
        usort($events, static function ($a, $b) {
            return strcmp((string)$b['created_at'], (string)$a['created_at']);
        });
        $events = array_slice($events, 0, 100);
    } catch (\Throwable $e) {
        // keep whatever audit rows loaded
    }
}

function dt_log_action_label(string $action, string $entityType, string $entityId): string
{
    $human = ucfirst(str_replace(['_', '-'], ' ', $action));
    return $human . ' — ' . ucfirst($entityType) . ' #' . $entityId;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Audit & Activity Trail - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Security Audit &amp; Activity Trail</span>
                        <span class="adm-badge gold"><?php echo count($events); ?> Events</span>
                    </h1>
                    <p class="adm-page-subtitle">Recorded admin actions and real sign-in activity, newest first.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/users/" class="adm-btn-secondary">← Back to Users Suite</a>
                </div>
            </div>

            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-size:1.05rem; font-weight:800;">Activity</h3></div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Admin</th>
                                <th>Action Performed</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($logsUnavailable): ?>
                                <tr><td colspan="4" style="padding:20px; text-align:center; color:#64748B;">The database is unreachable, so no activity can be shown.</td></tr>
                            <?php elseif (empty($events)): ?>
                                <tr><td colspan="4" style="padding:20px; text-align:center; color:#64748B;">No activity recorded yet. Admin sign-ins appear here automatically.</td></tr>
                            <?php else: ?>
                                <?php foreach ($events as $e): ?>
                                <tr>
                                    <td><?= htmlspecialchars(date('d M Y, h:i A', strtotime((string)$e['created_at']))) ?></td>
                                    <td><strong><?= htmlspecialchars((string)($e['user_name'] ?? 'system')) ?></strong></td>
                                    <td><?= htmlspecialchars(dt_log_action_label((string)($e['action'] ?? ''), (string)($e['entity_type'] ?? ''), (string)($e['entity_id'] ?? ''))) ?></td>
                                    <td><?php $ip = (string)($e['ip_address'] ?? ''); echo $ip !== '' ? '<code>' . htmlspecialchars($ip) . '</code>' : '<span style="color:#94A3B8;">—</span>'; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>