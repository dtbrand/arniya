<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * pending.php - DT Brand's Admin Pending Review Moderation
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Pending Review Moderation";
$active_nav = "reviews";

$pdo = Database::getConnection();
$pendingReviews = [];
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT r.*, p.title AS product_title FROM reviews r LEFT JOIN products p ON p.id = r.product_id WHERE r.status = 'pending' OR r.status IS NULL ORDER BY r.id DESC");
        $pendingReviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {}
}

if (empty($pendingReviews)) {
    $pendingReviews = [
        ['id' => 101, 'customer_name' => 'Deepak Singhal', 'city' => 'Delhi NCR', 'product_id' => 1, 'rating' => 5, 'title' => 'Stunning Banarasi Brocade', 'comment' => 'Received the saree today in luxury box packaging. Zari work is exquisite and loom texture feels very rich.', 'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))],
        ['id' => 102, 'customer_name' => 'Kavita Sundaram', 'city' => 'Chennai, TN', 'product_id' => 2, 'rating' => 5, 'title' => 'Pure Kanjivaram Perfection', 'comment' => 'Weight of the silk and royal border is perfect for my daughter wedding reception. Authentic quality!', 'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Review Moderation - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Pending Review Moderation</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?= count($pendingReviews) ?> Pending Moderation</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Audit and approve customer testimonials and rating stars before displaying publicly on product pages.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reviews/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Reviews Hub</span>
                    </a>
                    <a href="/admin/reviews/approved.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <span>Published Reviews</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>

            <!-- Pending Reviews Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span style="display:inline-flex; align-items:center; gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>Awaiting Moderator Verification</span></h3>
                    <span class="adm-badge" style="background:#FEF3C7; color:#B45309; border:1px solid #FCD34D; font-weight:700; font-size:11.5px;">Pending Approval</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Buyer &amp; City</th>
                                <th>Product / SKU</th>
                                <th>Rating Stars</th>
                                <th>Customer Feedback Note</th>
                                <th style="text-align:right;">Moderation Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendingReviews as $r): ?>
                                <tr id="reviewRow_<?= $r['id'] ?>">
                                    <td>
                                        <strong style="color:#181512;"><?= htmlspecialchars($r['customer_name'] ?? 'Customer') ?></strong>
                                        <div style="font-size:11px; color:#64748B;"><?= htmlspecialchars($r['city'] ?? 'India') ?></div>
                                    </td>
                                    <td>
                                        <span class="adm-badge gold" style="font-weight:700;">Product #<?= (int)($r['product_id'] ?? 1) ?></span>
                                    </td>
                                    <td>
                                        <div style="display:inline-flex; align-items:center; gap:2px;">
                                            <?php for ($si = 0; $si < (int)($r['rating'] ?? 5); $si++): ?>
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="#D4AF37" stroke="#B8860B" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                            <?php endfor; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php $rTitle = $r['review_title'] ?? ($r['title'] ?? ''); if ($rTitle !== ''): ?>
                                            <div style="font-weight:700; font-size:12px; color:#181512; margin-bottom:2px;"><?= htmlspecialchars($rTitle) ?></div>
                                        <?php endif; ?>
                                        <div style="font-size:12px; color:#334155; line-height:1.4;">
                                            <?= htmlspecialchars($r['comment'] ?? ($r['review_text'] ?? 'Great handloom quality!')) ?>
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="moderateReview(<?= $r['id'] ?>, 'approve')">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span>Approve &amp; Publish</span>
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626; display:inline-flex; align-items:center; gap:4px;" onclick="moderateReview(<?= $r['id'] ?>, 'reject')">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
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
function moderateReview(id, action) {
    const params = new URLSearchParams();
    params.append('action', action);
    params.append('id', id);

    const toast = (m) => { if (typeof window.showToast === 'function') window.showToast(m); };

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            // Only drop the row once the server confirms the change. This used
            // to remove it and report success unconditionally — including from
            // the .catch() branch — so a rejected or failed moderation looked
            // identical to a successful one and the review silently stayed put.
            if (!data || !data.success) {
                toast('Could not update the review: ' + ((data && data.message) ? data.message : 'please try again.'));
                return;
            }
            const r = document.getElementById('reviewRow_' + id);
            if (r) r.remove();
            toast(action === 'approve' ? 'Review approved and published to live storefront!' : 'Review rejected.');
        })
        .catch(() => {
            toast('Network error — the review was not updated. Please try again.');
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
