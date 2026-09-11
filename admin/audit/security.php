<?php
/**
 * security.php — Security & Access Control Audit Ledger
 * DT Brand's & Jai Hanuman Tex
 * Section 35: Central Enterprise Audit Log Admin
 */

$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) {
    require_once $__dtg;
}

require_once __DIR__ . '/../../src/AuditManager.php';

use DTBrand\AuditManager;

$auditManager = AuditManager::getInstance();

$page_title = "Security & Access Audit";
$active_nav = "audit";
$current_subnav = "security";

$search = trim((string)($_GET['search'] ?? ''));
$status = trim((string)($_GET['status'] ?? ''));
$page   = max(1, (int)($_GET['page'] ?? 1));
$limit  = 25;

// Fetch logs and filter to security & access domains
$res = $auditManager->getLogs([
    'search' => $search,
    'status' => $status,
    'limit'  => 500,
]);

$all = $res['items'];
$securityLogs = array_values(array_filter($all, function ($item) {
    return in_array($item['entity_type'] ?? '', ['auth', 'role', 'permission', 'security'], true);
}));

$total = count($securityLogs);
$pages = (int)ceil($total / $limit);
$logs = array_slice($securityLogs, ($page - 1) * $limit, $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security &amp; Access Audit - DT Brand's Admin</title>
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

            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Security &amp; Access Control Audit</span>
                        <span class="adm-badge gold"><?php echo $total; ?> Security Events</span>
                    </h1>
                    <p class="adm-page-subtitle">Granular audit trail of staff authentications, role assignments, permission matrix updates, and active interventions.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px;">
                    <a href="/admin/audit/index.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Audit Logs</span>
                    </a>
                </div>
            </div>

            <!-- Quick Filter Bar -->
            <div class="audit-filter-bar">
                <form method="GET" action="/admin/audit/security.php" style="display:flex; gap:12px; align-items:end; flex-wrap:wrap;">
                    <div class="audit-form-group" style="flex:1; min-width:240px;">
                        <label for="search">Filter Security Events</label>
                        <input type="text" name="search" id="search" class="audit-input dt-input-field" placeholder="Search staff name, IP, identity, or reason..." value="<?php echo htmlspecialchars($search, ENT_QUOTES, 'UTF-8'); ?>">
                    </div>

                    <div class="audit-form-group" style="width:160px;">
                        <label for="status">Severity / Status</label>
                        <select name="status" id="status" class="audit-input dt-input-field">
                            <option value="">All</option>
                            <option value="success" <?php echo $status === 'success' ? 'selected' : ''; ?>>Success</option>
                            <option value="warning" <?php echo $status === 'warning' ? 'selected' : ''; ?>>Warning</option>
                            <option value="failure" <?php echo $status === 'failure' ? 'selected' : ''; ?>>Failure</option>
                        </select>
                    </div>

                    <button type="submit" class="dt-btn-gold">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Filter</span>
                    </button>
                    <a href="/admin/audit/security.php" class="dt-btn-pale">Reset</a>
                </form>
            </div>

            <!-- Table Card -->
            <div class="audit-table-card">
                <div class="audit-table-responsive">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Actor</th>
                                <th>Event Type</th>
                                <th>Action</th>
                                <th>Target Entity</th>
                                <th>Details / Reason</th>
                                <th>Client IP</th>
                                <th>State Diff</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                                <tr>
                                    <td colspan="9" style="text-align:center; padding: 40px; color: #64748B;">No security events found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td style="white-space:nowrap; font-size:0.75rem; color:#64748B;">
                                            <?php echo htmlspecialchars((string)($log['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <td>
                                            <div style="font-weight:700; color:#111827;"><?php echo htmlspecialchars((string)($log['user_name'] ?? 'system'), ENT_QUOTES, 'UTF-8'); ?></div>
                                            <div style="font-size:0.7rem; color:#8A681F; font-weight:600;"><?php echo htmlspecialchars((string)($log['actor_role'] ?? 'admin'), ENT_QUOTES, 'UTF-8'); ?></div>
                                        </td>
                                        <td>
                                            <span class="cat-badge <?php echo htmlspecialchars((string)($log['entity_type'] ?? 'security'), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars(ucfirst((string)($log['entity_type'] ?? 'security')), ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                        <td><code><?php echo htmlspecialchars((string)($log['action'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></code></td>
                                        <td><strong><?php echo htmlspecialchars((string)($log['entity_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                        <td style="max-width:280px;">
                                            <div style="font-size:0.78rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?php echo htmlspecialchars((string)($log['details'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars((string)($log['details'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?>
                                            </div>
                                        </td>
                                        <td><code><?php echo htmlspecialchars((string)($log['ip_address'] ?? '—'), ENT_QUOTES, 'UTF-8'); ?></code></td>
                                        <td>
                                            <button type="button" class="dt-btn-pale" style="height:28px; padding:0 8px; font-size:0.72rem;" onclick="window.inspectAuditDiff(<?php echo (int)$log['id']; ?>)">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                                <span>Diff</span>
                                            </button>
                                        </td>
                                        <td>
                                            <span class="status-pill <?php echo htmlspecialchars((string)($log['status'] ?? 'success'), ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars(ucfirst((string)($log['status'] ?? 'success')), ENT_QUOTES, 'UTF-8'); ?>
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
    </div>
</div>

<!-- Modal -->
<div class="audit-modal-backdrop" id="auditDiffModal" onclick="if(event.target===this) window.closeAuditModal();">
    <div class="audit-modal-window">
        <div class="audit-modal-header">
            <div>
                <h3 class="audit-modal-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                    <span>Security Forensic State Diff</span>
                </h3>
                <div id="auditDiffModalSub" style="font-size: 0.76rem; color: #64748B; margin-top: 2px;"></div>
            </div>
            <button type="button" class="dt-btn-pale" style="height:30px; padding:0 8px;" onclick="window.closeAuditModal();">&times;</button>
        </div>
        <div class="audit-modal-body" id="auditDiffModalBody"></div>
        <div class="audit-modal-footer">
            <button type="button" class="dt-btn-pale" onclick="window.closeAuditModal();">Close</button>
        </div>
    </div>
</div>

<script src="/admin/audit/audit.js?v=<?php echo time(); ?>"></script>
</body>
</html>
