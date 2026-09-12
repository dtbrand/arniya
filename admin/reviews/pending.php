<?php
/* DT admin access guard (auto-inserted) */
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

/**
 * pending.php - DT Brand's Admin Pending Review Moderation Queue
 * Section 30 (Reviews Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ReviewManager.php';

use DTBrand\Database;
use DTBrand\ReviewManager;

$page_title = "Pending Review Moderation Queue";
$active_nav = "reviews";
$active_subnav = "pending";

$pendingReviews = ReviewManager::getReviews(['status' => 'pending', 'limit' => 100]);
$pendingCount = count($pendingReviews);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Review Moderation Queue - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-star-fill { fill: #D4AF37; stroke: #8A681F; }
        .dt-star-empty { fill: #E2E8F0; stroke: #CBD5E1; }
        .dt-batch-toolbar { display: flex; align-items: center; justify-content: space-between; background: #FAF5E8; border: 1px solid #D4AF37; padding: 10px 16px; border-radius: 8px; margin-bottom: 16px; }
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
                        <span>Pending Review Moderation Queue</span>
                        <span class="adm-badge gold" style="font-size:0.75rem;"><?= $pendingCount ?> Awaiting Verification</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Audit and verify customer testimonials and rating stars before displaying publicly on storefront PDPs.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reviews/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Reviews Hub</span>
                    </a>
                    <a href="/admin/reviews/approved.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <span>Published Reviews</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>

            <!-- Batch Action Toolbar -->
            <?php if ($pendingCount > 0): ?>
                <div class="dt-batch-toolbar">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <input type="checkbox" id="selectAllReviews" style="width:16px; height:16px; cursor:pointer;" onchange="toggleSelectAll(this.checked)">
                        <label for="selectAllReviews" style="font-weight:700; font-size:13px; color:#181512; cursor:pointer;">Select All Pending (<span id="selectedCount">0</span> selected)</label>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="executeBatchAction('batch_approve')">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Batch Approve &amp; Publish</span>
                        </button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA; background:#FEF2F2;" onclick="executeBatchAction('batch_reject')">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            <span>Batch Reject</span>
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Pending Reviews Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title">
                        <span style="display:inline-flex; align-items:center; gap:6px;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Awaiting Moderator Verification</span>
                        </span>
                    </h3>
                    <span class="adm-badge" style="background:#FEF3C7; color:#B45309; border:1px solid #FCD34D; font-weight:700; font-size:11.5px;">
                        Pending Approval
                    </span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th style="width:36px;"></th>
                                <th>Buyer &amp; City</th>
                                <th>Product / SKU</th>
                                <th>Rating Stars</th>
                                <th>Customer Feedback Note</th>
                                <th style="text-align:right;">Moderation Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($pendingCount === 0): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:40px; color:#64748B;">
                                        <div style="font-weight:700; font-size:14px; color:#15803D; margin-bottom:4px;">No Pending Reviews in Queue</div>
                                        <div style="font-size:12px;">All customer reviews have been audited and verified.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($pendingReviews as $r): ?>
                                <?php
                                $rId = (int)$r['id'];
                                $isVerified = !empty($r['verified_buyer']);
                                ?>
                                <tr id="reviewRow_<?= $rId ?>">
                                    <td>
                                        <input type="checkbox" class="review-checkbox" value="<?= $rId ?>" onchange="updateSelectedCount()" style="width:16px; height:16px; cursor:pointer;">
                                    </td>
                                    <td>
                                        <div style="font-weight:700; color:#181512; display:flex; align-items:center; gap:4px;">
                                            <span><?= htmlspecialchars($r['customer_name'] ?? 'Customer') ?></span>
                                            <?php if ($isVerified): ?>
                                                <span title="Verified Handloom Buyer" style="display:inline-flex; align-items:center; color:#15803D;">
                                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">
                                            <?= htmlspecialchars($r['city'] ?? 'India') ?> &bull; <?= date('d M Y, h:i A', strtotime($r['created_at'] ?? 'now')) ?>
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
                                        <?php $rTitle = $r['review_title'] ?? ($r['title'] ?? ''); if ($rTitle !== ''): ?>
                                            <div style="font-weight:700; font-size:12px; color:#181512; margin-bottom:2px;"><?= htmlspecialchars($rTitle) ?></div>
                                        <?php endif; ?>
                                        <div style="font-size:12px; color:#334155; line-height:1.4;">
                                            &ldquo;<?= htmlspecialchars($r['review_text'] ?? ($r['comment'] ?? '')) ?>&rdquo;
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display:inline-flex; align-items:center; gap:2px;">
                                            <?php for ($si = 1; $si <= 5; $si++): ?>
                                                <svg width="12" height="12" viewBox="0 0 24 24" class="<?= $si <= (int)($r['rating'] ?? 5) ? 'dt-star-fill' : 'dt-star-empty' ?>" stroke-width="1.2">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg>
                                            <?php endfor; ?>
                                            <span style="font-weight:800; font-size:11px; color:#181512; margin-left:3px;">(<?= (int)($r['rating'] ?? 5) ?>.0)</span>
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="moderateReview(<?= $rId ?>, 'approve')">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span>Approve &amp; Publish</span>
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA; background:#FEF2F2; display:inline-flex; align-items:center; gap:4px;" onclick="moderateReview(<?= $rId ?>, 'reject')">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                <span>Reject</span>
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

function toggleSelectAll(checked) {
    document.querySelectorAll('.review-checkbox').forEach(cb => cb.checked = checked);
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
    document.getElementById('selectedCount').innerText = checkedBoxes.length;
}

function moderateReview(id, action, reason = '') {
    const params = new URLSearchParams();
    params.append('action', action);
    params.append('id', id);
    if (reason) params.append('reason', reason);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.success) {
                toast('Could not update review: ' + ((data && data.message) ? data.message : 'Please try again.'));
                return;
            }
            const r = document.getElementById('reviewRow_' + id);
            if (r) r.remove();
            toast(action === 'approve' ? 'Review approved and published to live storefront!' : 'Review rejected.');
            updateSelectedCount();
        })
        .catch(() => {
            toast('Network error — the review was not updated. Please try again.');
        });
}

function executeBatchAction(action) {
    const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
    if (checkedBoxes.length === 0) {
        toast('Please select at least one review.');
        return;
    }

    const ids = Array.from(checkedBoxes).map(cb => parseInt(cb.value, 10));
    const verb = action === 'batch_approve' ? 'approve and publish' : 'reject';
    if (!confirm(`Are you sure you want to ${verb} ${ids.length} selected review(s)?`)) {
        return;
    }

    fetch('/api/reviews.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: action, ids: ids })
    })
    .then(res => res.json())
    .then(data => {
        if (!data || !data.success) {
            toast('Batch action failed: ' + ((data && data.message) ? data.message : 'Please try again.'));
            return;
        }
        ids.forEach(id => {
            const r = document.getElementById('reviewRow_' + id);
            if (r) r.remove();
        });
        toast(data.message || 'Batch action completed successfully.');
        updateSelectedCount();
    })
    .catch(() => {
        toast('Network error during batch action.');
    });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
