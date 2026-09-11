<?php
/* DT admin access guard (auto-inserted) */
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) require_once $__dtg;

/**
 * approved.php - DT Brand's Admin Approved Customer Reviews & Live Testimonials
 * Section 30 (Reviews Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ReviewManager.php';

use DTBrand\Database;
use DTBrand\ReviewManager;

$page_title = "Approved Customer Reviews & Testimonials";
$active_nav = "reviews";
$active_subnav = "approved";

$approvedReviews = ReviewManager::getReviews(['status' => 'approved', 'limit' => 100]);
$approvedCount = count($approvedReviews);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Customer Reviews - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-star-fill { fill: #D4AF37; stroke: #8A681F; }
        .dt-star-empty { fill: #E2E8F0; stroke: #CBD5E1; }
        .dt-reply-bubble { background: #FAF5E8; border-left: 3px solid #8A681F; padding: 8px 12px; border-radius: 4px; margin-top: 8px; }
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
                        <span>Approved Customer Reviews &amp; Testimonials</span>
                        <span class="adm-badge gold" style="font-size:0.75rem;"><?= $approvedCount ?> Published Testimonials</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Live customer feedback displayed publicly across product pages, category galleries, and checkout social proof banners.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reviews/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Reviews Hub</span>
                    </a>
                    <a href="/admin/reviews/pending.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <span>Pending Queue</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>

            <!-- Approved Reviews Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title">
                        <span style="display:inline-flex; align-items:center; gap:6px;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="#D4AF37" stroke="#8A681F" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>Published Storefront Testimonials</span>
                        </span>
                    </h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">
                        <span class="dt-pulse-dot" style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#15803D; margin-right:4px;"></span>
                        Displayed on Live PDP
                    </span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Verified Buyer</th>
                                <th>Product / SKU</th>
                                <th>Rating Stars</th>
                                <th>Published Testimonial &amp; Brand Reply</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($approvedCount === 0): ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:36px; color:#64748B;">
                                        <div style="font-weight:700; font-size:14px; margin-bottom:4px;">No Approved Reviews Found</div>
                                        <div style="font-size:12px;">Approve reviews in the Pending Queue to publish them here.</div>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php foreach ($approvedReviews as $r): ?>
                                <?php
                                $rId = (int)$r['id'];
                                $isVerified = !empty($r['verified_buyer']);
                                $hasReply = !empty($r['store_reply']);
                                ?>
                                <tr id="appReviewRow_<?= $rId ?>">
                                    <td>
                                        <div style="font-weight:700; color:#181512; display:flex; align-items:center; gap:4px;">
                                            <span><?= htmlspecialchars($r['customer_name'] ?? 'Customer') ?></span>
                                            <?php if ($isVerified): ?>
                                                <span title="Verified Handloom Buyer" style="display:inline-flex; align-items:center; color:#15803D;">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">
                                            <?= htmlspecialchars($r['city'] ?? 'India') ?> &bull; <?= date('d M Y', strtotime($r['created_at'] ?? 'now')) ?>
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
                                                <svg width="12" height="12" viewBox="0 0 24 24" class="<?= $si <= (int)($r['rating'] ?? 5) ? 'dt-star-fill' : 'dt-star-empty' ?>" stroke-width="1.2">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg>
                                            <?php endfor; ?>
                                            <span style="font-weight:800; font-size:11px; color:#181512; margin-left:3px;">(<?= (int)($r['rating'] ?? 5) ?>.0)</span>
                                        </div>
                                    </td>
                                    <td style="max-width:340px;">
                                        <?php $rTitle = $r['review_title'] ?? ($r['title'] ?? ''); if ($rTitle !== ''): ?>
                                            <div style="font-weight:700; font-size:12px; color:#181512; margin-bottom:2px;"><?= htmlspecialchars($rTitle) ?></div>
                                        <?php endif; ?>
                                        <div style="font-size:12px; color:#334155; line-height:1.4;">
                                            &ldquo;<?= htmlspecialchars($r['review_text'] ?? ($r['comment'] ?? '')) ?>&rdquo;
                                        </div>

                                        <!-- Store Reply Bubble -->
                                        <?php if ($hasReply): ?>
                                            <div class="dt-reply-bubble" id="replyBox_<?= $rId ?>">
                                                <div style="font-size:11px; font-weight:700; color:#8A681F; margin-bottom:2px; display:flex; justify-content:space-between;">
                                                    <span>Official DT Brand's Reply:</span>
                                                    <span style="color:#64748B; font-weight:400;"><?= htmlspecialchars($r['store_replied_by'] ?? 'Admin') ?></span>
                                                </div>
                                                <div style="font-size:11.5px; color:#5A4210; line-height:1.4;">
                                                    <?= htmlspecialchars($r['store_reply']) ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div id="replyBox_<?= $rId ?>" style="margin-top:6px;">
                                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="font-size:10.5px; padding:2px 8px; height:24px;" onclick="promptReply(<?= $rId ?>)">
                                                    <span>+ Add Store Reply</span>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="adm-badge success">Live on PDP</span></td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="promptReply(<?= $rId ?>)">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                                <span><?= $hasReply ? 'Edit Reply' : 'Reply' ?></span>
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="unpublishReview(<?= $rId ?>)">
                                                <span>Unpublish</span>
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; border-color:#FECACA; background:#FEF2F2;" onclick="deleteReview(<?= $rId ?>)">
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
function toast(m) {
    if (typeof window.showToast === 'function') window.showToast(m);
    else alert(m);
}

function promptReply(id) {
    const reply = prompt('Enter official store reply to display publicly under this customer review:');
    if (reply === null || reply.trim() === '') return;

    const params = new URLSearchParams();
    params.append('action', 'reply');
    params.append('id', id);
    params.append('reply', reply.trim());

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.success) {
                toast('Could not save store reply: ' + ((data && data.message) ? data.message : 'Please try again.'));
                return;
            }
            toast('Official store reply published successfully!');
            setTimeout(() => location.reload(), 600);
        })
        .catch(() => {
            toast('Network error — reply not saved.');
        });
}

function unpublishReview(id) {
    if (!confirm('Unpublish this review from the storefront and move back to the moderation queue?')) return;

    const params = new URLSearchParams();
    params.append('action', 'unpublish');
    params.append('id', id);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.success) {
                toast('Could not unpublish review: ' + ((data && data.message) ? data.message : 'Please try again.'));
                return;
            }
            const r = document.getElementById('appReviewRow_' + id);
            if (r) r.remove();
            toast('Review unpublished and returned to pending queue.');
        })
        .catch(() => {
            toast('Network error during unpublish.');
        });
}

function deleteReview(id) {
    if (!confirm('Are you sure you want to permanently delete this customer review?')) return;

    const params = new URLSearchParams();
    params.append('action', 'delete');
    params.append('id', id);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (!data || !data.success) {
                toast('Could not delete review: ' + ((data && data.message) ? data.message : 'Please try again.'));
                return;
            }
            const r = document.getElementById('appReviewRow_' + id);
            if (r) r.remove();
            toast('Review permanently deleted.');
        })
        .catch(() => {
            toast('Network error during deletion.');
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
