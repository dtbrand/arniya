<?php
/* DT admin access guard (auto-inserted) */
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) {
    require_once $__dtg;
}

/**
 * activity-logs.php — Security Audit & Activity Trail
 * DT Brand's & Jai Hanuman Tex
 * Section 35: Central Enterprise Audit Log Admin
 */
require_once __DIR__ . '/../../src/AuditManager.php';

use DTBrand\AuditManager;

$page_title = "Security Audit & Activity Trail";
$active_nav = "users";

$auditManager = AuditManager::getInstance();
$result = $auditManager->getLogs(['limit' => 100]);
$events = $result['items'];
$logsUnavailable = empty($events);

function dt_log_action_label(string $action, string $entityType, string $entityId): string
{
    $human = ucfirst(str_replace(['_', '-'], ' ', $action));
    return $human . ' — ' . ucfirst(str_replace('_', ' ', $entityType)) . ' #' . $entityId;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Audit &amp; Activity Trail - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/audit/audit.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">

            <!-- Banner pointing to new Master Audit Console -->
            <div style="background: linear-gradient(135deg, #FAF5E8 0%, #F5ECCE 100%); border: 1.5px solid #D4AF37; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: var(--dt-gold-gradient); display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(184,134,11,0.3);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 0.95rem; color: #111827;">Master Enterprise Audit Console Now Available</div>
                        <div style="font-size: 0.78rem; color: #705114; font-weight: 500;">Access multi-category filtering, forensic JSON state diffs, request correlation chains, and RFC-4180 CSV exports.</div>
                    </div>
                </div>
                <a href="/admin/audit/" class="dt-btn-gold">
                    <span>Open Master Audit Console</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>

            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Security Audit &amp; Activity Trail</span>
                        <span class="adm-badge gold"><?php echo count($events); ?> Events</span>
                    </h1>
                    <p class="adm-page-subtitle">Recorded administrative actions and real staff sign-in activity, newest first.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px;">
                    <a href="/admin/users/" class="adm-btn-secondary dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-right:4px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Users Suite</span>
                    </a>
                </div>
            </div>

            <div class="adm-table-card">
                <div class="adm-table-toolbar" style="display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid #E2E8F0;">
                    <div><h3 style="font-size:1.05rem; font-weight:800; margin:0;">Staff Activity Stream</h3></div>
                    <div style="font-size:0.75rem; color:#64748B;">Reading from central <code>audit_logs</code> repository</div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Admin User</th>
                                <th>Category</th>
                                <th>Action Performed</th>
                                <th>Details / Target</th>
                                <th>Client IP</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($logsUnavailable): ?>
                                <tr><td colspan="7" style="padding:20px; text-align:center; color:#64748B;">No activity recorded yet. Central audit events appear here automatically.</td></tr>
                            <?php else: ?>
                                <?php foreach ($events as $e): ?>
                                <tr>
                                    <td style="white-space:nowrap; font-size:0.78rem; color:#64748B;"><?php echo htmlspecialchars(date('d M Y, h:i A', strtotime((string)$e['created_at']))); ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars((string)($e['user_name'] ?? 'system')); ?></strong>
                                        <div style="font-size:0.7rem; color:#8A681F; font-weight:600;"><?php echo htmlspecialchars((string)($e['actor_role'] ?? 'admin')); ?></div>
                                    </td>
                                    <td>
                                        <span class="cat-badge <?php echo htmlspecialchars((string)($e['entity_type'] ?? 'system')); ?>">
                                            <?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', (string)($e['entity_type'] ?? 'system')))); ?>
                                        </span>
                                    </td>
                                    <td><code><?php echo htmlspecialchars((string)($e['action'] ?? '')); ?></code></td>
                                    <td style="max-width:280px;">
                                        <div style="font-size:0.78rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?php echo htmlspecialchars((string)($e['details'] ?? '')); ?>">
                                            <?php echo htmlspecialchars((string)($e['details'] ?? dt_log_action_label((string)($e['action'] ?? ''), (string)($e['entity_type'] ?? ''), (string)($e['entity_id'] ?? '')))); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                            $ip = (string)($e['ip_address'] ?? ''); 
                                            echo $ip !== '' ? '<code>' . htmlspecialchars($ip) . '</code>' : '<span style="color:#94A3B8;">—</span>'; 
                                        ?>
                                    </td>
                                    <td>
                                        <span class="status-pill <?php echo htmlspecialchars((string)($e['status'] ?? 'success')); ?>">
                                            <?php echo htmlspecialchars(ucfirst((string)($e['status'] ?? 'success'))); ?>
                                        </span>
                                    </td>
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