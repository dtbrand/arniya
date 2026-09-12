<?php
/* DT admin access guard (auto-inserted) */
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

/**
 * rejected.php - DT Brand's Admin Rejected & Flagged Customer Feedback
 * Section 30 (Reviews Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ReviewManager.php';

use DTBrand\Database;
use DTBrand\ReviewManager;

$page_title = "Rejected & Flagged Customer Feedback";
$active_nav = "reviews";
$active_subnav = "rejected";

$subFilter = trim($_GET['tab'] ?? 'all');
$filterStatuses = ['rejected', 'flagged'];
if ($subFilter === 'rejected') {
    $filterStatuses = ['rejected'];
} elseif ($subFilter === 'flagged') {
    $filterStatuses = ['flagged'];
}

$rejectedReviews = ReviewManager::getReviews(['status' => $filterStatuses, 'limit' => 100]);
$totalCount = count($rejectedReviews);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected &amp; Flagged Reviews - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-star-fill { fill: #D4AF37; stroke: #8A681F; }
        .dt-star-empty { fill: #E2E8F0; stroke: #CBD5E1; }
        .dt-pill-tabs { display: flex; gap: 8px; margin-bottom: 16px; }
        .dt-pill-tab { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-decoration: none; border: 1px solid #CBD5E1; color: #475569; background: #FFF; transition: all 0.15s; }
        .dt-pill-tab.active { background: #181512; color: #FAF5E8; border-color: #181512; }
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
                        <span>Rejected &amp; Flagged Feedback Console</span>
                        <span class="adm-badge danger" style="font-size:0.75rem;"><?= $totalCount ?> Filtered Records</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manage blocked spam, promotional links, offensive submissions, and feedback held for concierge resolution.</p>
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

            <!-- Tab Pills -->
            <div class="dt-pill-tabs">
                <a href="/admin/reviews/rejected.php?tab=all" class="dt-pill-tab <?= $subFilter === 'all' ? 'active' : '' ?>">All Filtered (<?= $totalCount ?>)</a>
                <a href="/admin/reviews/rejected.php?tab=flagged" class="dt-pill-tab <?= $subFilter === 'flagged' ? 'active' : '' ?>">Flagged for Support</a>
                <a href="/admin/reviews/rejected.php?tab=rejected" class="dt-pill-tab <?= $subFilter === 'rejected' ? 'active' : '' ?>">Rejected / Spam</a>
            </div>

            <!-- Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title">
                        <span style="display:inline-flex; align-items:center; gap:6px;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                            <span>Filtered Feedback Ledger</span>
                        </span>
                    </h3>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Submitter &amp; Date</th>
                                <th>Product / SKU</th>
                                <th>Rating Stars</th>
                                <th>Review Snippet &amp; Reason Note</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($totalCount === 0): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:36px; color:#64748B;">
                                        <div style="font-weight:700; font-size:14px; margin-bottom:4px;">No Rejected or Flagged Reviews Found</div>
                                        <div style="font-size:12px;">All customer reviews in the system are currently either approved or pending.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($rejectedReviews as $r): ?>
                                <?php
                                $rId = (int)$r['id'];
                                $isFlagged = ($r['status'] ?? '') === 'flagged';
                                $reasonNote = $r['flag_reason'] ?? ($r['moderation_notes'] ?? 'Filtered by moderation rule');
                                ?>
                                <tr id="rejRow_<?= $rId ?>">
                                    <td>
                                        <div style="font-weight:700; color:#181512;"><?= htmlspecialchars($r['customer_name'] ?? 'Submitter') ?></div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">
                                            <?= htmlspecialchars($r['city'] ?? 'Unknown') ?> &bull; <?= date('d M Y, h:i A', strtotime($r['created_at'] ?? 'now')) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight:600; color:#1F2937; font-size:12.5px;">
                                            <?= htmlspecialchars($r['product_title'] ?? ('Product #' . (int)($r['product_id'] ?? 1))) ?>
                                        </div>
                                        <span class="adm-badge gold" style="font-weight:700; font-size:10.5px; margin-top:3px;">
                                            SKU: <?= htmlspecialchars($r['product_sku'] ?? ('PROD-' . (int)($r['product_id'] ?? 1))) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:inline-flex; align-items:center; gap:2px;">
                                            <?php for ($si = 1; $si <= 5; $si++): ?>
                                                <svg width="12" height="12" viewBox="0 0 24 24" class="<?= $si <= (int)($r['rating'] ?? 1) ? 'dt-star-fill' : 'dt-star-empty' ?>" stroke-width="1.2">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg>
                                            <?php endfor; ?>
                                            <span style="font-weight:800; font-size:11px; color:#181512; margin-left:3px;">(<?= (int)($r['rating'] ?? 1) ?>.0)</span>
                                        </div>
                                    </td>
                                    <td style="max-width:340px;">
                                        <div style="font-size:12px; color:#334155; line-height:1.4;">
                                            &ldquo;<?= htmlspecialchars(mb_strimwidth($r['review_text'] ?? ($r['comment'] ?? ''), 0, 120, '...')) ?>&rdquo;
                                        </div>
                                        <div style="margin-top:6px; background:<?= $isFlagged ? '#FEF3C7' : '#FEF2F2' ?>; border-left:3px solid <?= $isFlagged ? '#D97706' : '#DC2626' ?>; padding:4px 8px; border-radius:3px; font-size:11px; color:<?= $isFlagged ? '#92400E' : '#991B1B' ?>;">
                                            <strong>Reason:</strong> <?= htmlspecialchars($reasonNote) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="adm-badge <?= $isFlagged ? 'warning' : 'danger' ?>">
                                            <?= $isFlagged ? 'Flagged Ticket' : 'Rejected' ?>
                                        </span>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="moderateAction(<?= $rId ?>, 'approve')" title="Approve and Publish to Storefront">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span>Restore</span>
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="moderateAction(<?= $rId ?>, 'unpublish')" title="Move to Pending Queue">
                                                <span>To Pending</span>
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA; background:#FEF2F2;" onclick="moderateAction(<?= $rId ?>, 'delete')" title="Permanent Delete">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </button>
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

<script>
function toast(m, type) {
    if (typeof window.showToast === 'function') window.showToast(m, type);
    else console.warn(m);
}

function moderateAction(id, action) {
    if (action === 'delete' && !confirm('Are you sure you want to permanently purge this entry from the database?')) return;

    const params = new URLSearchParams();
    params.append('action', action);
    params.append('id', id);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.success) {
                toast('Could not update review: ' + ((data && data.message) ? data.message : 'Please try again.'));
                return;
            }
            const r = document.getElementById('rejRow_' + id);
            if (r) r.remove();
            toast(data.message || 'Action completed successfully.');
        })
        .catch(() => {
            toast('Network error.');
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
