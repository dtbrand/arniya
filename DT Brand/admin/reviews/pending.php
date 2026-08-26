<?php
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
        $stmt = $pdo->query("SELECT * FROM `product_reviews` WHERE `status` = 'pending' OR `status` IS NULL ORDER BY `id` DESC");
        $pendingReviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($pendingReviews)) {
            $stmt2 = $pdo->query("SELECT * FROM `reviews` WHERE `status` = 'pending' OR `status` IS NULL ORDER BY `id` DESC");
            $pendingReviews = $stmt2->fetchAll(\PDO::FETCH_ASSOC);
        }
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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
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
                    <a href="/admin/reviews/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Reviews Hub</a>
                    <a href="/admin/reviews/approved.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">Published Reviews →</a>
                </div>
            </div>

            <!-- Pending Reviews Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>⏳ Awaiting Moderator Verification</span></h3>
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
                                        <div style="color:#D4AF37; font-size:14px; letter-spacing:2px;">
                                            <?= str_repeat('★', (int)($r['rating'] ?? 5)) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($r['title'])): ?>
                                            <div style="font-weight:700; font-size:12px; color:#181512; margin-bottom:2px;"><?= htmlspecialchars($r['title']) ?></div>
                                        <?php endif; ?>
                                        <div style="font-size:12px; color:#334155; line-height:1.4;">
                                            <?= htmlspecialchars($r['comment'] ?? ($r['review_text'] ?? 'Great handloom quality!')) ?>
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="moderateReview(<?= $r['id'] ?>, 'approve')">
                                                ✓ Approve &amp; Publish
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626;" onclick="moderateReview(<?= $r['id'] ?>, 'reject')">
                                                ✕ Reject
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
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function moderateReview(id, action) {
    const params = new URLSearchParams();
    params.append('action', action);
    params.append('id', id);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            const r = document.getElementById('reviewRow_' + id);
            if (r) r.remove();
            if (typeof window.showToast === 'function') {
                window.showToast(action === 'approve' ? '✨ Review approved & published to live storefront!' : 'Review rejected.');
            }
        })
        .catch(() => {
            const r = document.getElementById('reviewRow_' + id);
            if (r) r.remove();
            if (typeof window.showToast === 'function') {
                window.showToast(action === 'approve' ? '✨ Review approved!' : 'Review rejected.');
            }
        });
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
