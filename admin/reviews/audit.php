<?php
/* DT admin access guard (auto-inserted) */
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

/**
 * audit.php - DT Brand's Review Moderation Audit Trail & Compliance Ledger
 * Section 30 (Reviews Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ReviewManager.php';

use DTBrand\Database;
use DTBrand\ReviewManager;

$page_title = "Review Moderation Audit Ledger";
$active_nav = "reviews";
$active_subnav = "audit";

$actionFilter = trim($_GET['action'] ?? 'all');
$auditLogs = ReviewManager::getAuditLogs(100);

if ($actionFilter !== 'all' && $actionFilter !== '') {
    $auditLogs = array_filter($auditLogs, fn($l) => ($l['action'] ?? '') === $actionFilter);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Moderation Audit Ledger - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-filter-pills { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
        .dt-filter-pill { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; border: 1px solid #CBD5E1; color: #475569; background: #FFF; transition: all 0.15s; }
        .dt-filter-pill.active { background: #8A681F; color: #FAF5E8; border-color: #8A681F; }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Review Moderation Audit Ledger</span>
                        <span class="adm-badge gold" style="font-size:0.75rem;"><?= count($auditLogs) ?> Audit Events</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Chronological compliance ledger tracking moderator approvals, rejections, store replies, deletions, and IP records.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reviews/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Reviews Hub</span>
                    </a>
                    <a href="/admin/reviews/pending.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <span>Pending Queue</span>
                    </a>
                </div>
            </div>

            <!-- Filter Pills -->
            <div class="dt-filter-pills">
                <a href="/admin/reviews/audit.php?action=all" class="dt-filter-pill <?= $actionFilter === 'all' ? 'active' : '' ?>">All Actions</a>
                <a href="/admin/reviews/audit.php?action=approved" class="dt-filter-pill <?= $actionFilter === 'approved' ? 'active' : '' ?>">Approved Events</a>
                <a href="/admin/reviews/audit.php?action=replied" class="dt-filter-pill <?= $actionFilter === 'replied' ? 'active' : '' ?>">Store Replies</a>
                <a href="/admin/reviews/audit.php?action=rejected" class="dt-filter-pill <?= $actionFilter === 'rejected' ? 'active' : '' ?>">Rejections</a>
                <a href="/admin/reviews/audit.php?action=flagged" class="dt-filter-pill <?= $actionFilter === 'flagged' ? 'active' : '' ?>">Flagged Tickets</a>
                <a href="/admin/reviews/audit.php?action=deleted" class="dt-filter-pill <?= $actionFilter === 'deleted' ? 'active' : '' ?>">Deletions</a>
            </div>

            <!-- Audit Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title">
                        <span style="display:inline-flex; align-items:center; gap:6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            <span>Security &amp; Moderation Ledger</span>
                        </span>
                    </h3>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Review ID &amp; Target</th>
                                <th>Moderation Action</th>
                                <th>Moderated By</th>
                                <th>Action Details &amp; Payload</th>
                                <th>Client IP / User Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($auditLogs)): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:36px; color:#64748B;">
                                        <div style="font-weight:700; font-size:14px; margin-bottom:4px;">No Audit Events Found</div>
                                        <div style="font-size:12px;">Moderation actions taken on reviews will be automatically tracked here.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($auditLogs as $log): ?>
                                <?php
                                $act = $log['action'] ?? 'action';
                                $actBadge = 'gold';
                                if ($act === 'approved') $actBadge = 'success';
                                elseif ($act === 'rejected' || $act === 'deleted') $actBadge = 'danger';
                                elseif ($act === 'flagged') $actBadge = 'warning';
                                ?>
                                <tr>
                                    <td>
                                        <div style="font-weight:700; color:#181512; font-size:12px;">
                                            <?= date('d M Y', strtotime($log['created_at'] ?? 'now')) ?>
                                        </div>
                                        <div style="font-size:11px; color:#64748B;">
                                            <?= date('h:i:s A', strtotime($log['created_at'] ?? 'now')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight:700; color:#181512; font-size:12.5px;">
                                            Review #<?= (int)($log['review_id'] ?? 0) ?>
                                        </div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">
                                            <?= htmlspecialchars($log['customer_name'] ?? 'Buyer') ?> &bull; <?= htmlspecialchars(mb_strimwidth($log['product_title'] ?? 'Product', 0, 24, '...')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="adm-badge <?= $actBadge ?>" style="text-transform:uppercase; font-size:10.5px; font-weight:800;">
                                            <?= htmlspecialchars($act) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight:700; color:#181512; font-size:12px;">
                                            <?= htmlspecialchars($log['performed_by'] ?? 'admin') ?>
                                        </div>
                                        <div style="font-size:10.5px; color:#8A681F; font-weight:600;">Verified Staff</div>
                                    </td>
                                    <td style="max-width:320px;">
                                        <div style="font-size:12px; color:#334155; line-height:1.4;">
                                            <?= htmlspecialchars($log['details'] ?? 'No extra details') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-family:monospace; font-size:11.5px; color:#181512;">
                                            <?= htmlspecialchars($log['ip_address'] ?? '127.0.0.1') ?>
                                        </div>
                                        <div style="font-size:10.5px; color:#64748B; margin-top:2px;">
                                            <?= htmlspecialchars(mb_strimwidth($log['user_agent'] ?? 'Console', 0, 30, '...')) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
