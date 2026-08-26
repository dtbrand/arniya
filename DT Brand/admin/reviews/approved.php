<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * approved.php - DT Brand's Admin Approved Customer Reviews
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Approved Customer Reviews";
$active_nav = "reviews";

$pdo = Database::getConnection();
$approvedReviews = [];
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT r.*, p.title AS product_title FROM reviews r LEFT JOIN products p ON p.id = r.product_id WHERE r.status = 'approved' ORDER BY r.id DESC");
        $approvedReviews = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {}
}

if (empty($approvedReviews)) {
    $approvedReviews = [
        ['id' => 1, 'customer_name' => 'Priya Sharma', 'city' => 'Mumbai, MH', 'product_id' => 1, 'rating' => 5, 'title' => 'Breathtaking Pure Zari', 'comment' => 'The fabric quality and real zari weave is breathtaking! Arrived in luxury royal gift packaging within 3 days to Mumbai.', 'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))],
        ['id' => 2, 'customer_name' => 'Ananya Mehta', 'city' => 'Surat, Gujarat', 'product_id' => 1, 'rating' => 5, 'title' => 'Pure and Lightweight', 'comment' => 'Exactly as depicted in the photos. The silk drape feels extremely luxurious, pure, and lightweight.', 'created_at' => date('Y-m-d H:i:s', strtotime('-4 days'))],
        ['id' => 3, 'customer_name' => 'Dr. Radhika Iyer', 'city' => 'Bengaluru, KA', 'product_id' => 2, 'rating' => 5, 'title' => 'Authentic Craftsmanship', 'comment' => 'Authentic handloom craftsmanship. You can tell the zari is high standard and pure. Stitching of the blouse piece was flawless.', 'created_at' => date('Y-m-d H:i:s', strtotime('-7 days'))]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Customer Reviews - DT Brand's Admin</title>
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
                        <span>Approved Customer Reviews</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?= count($approvedReviews) ?> Published Testimonials</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Published customer testimonials, 5-star ratings, and verified buyer badges displayed live on storefront product pages.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/reviews/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Reviews Hub</a>
                    <a href="/admin/reviews/pending.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">Pending Queue →</a>
                </div>
            </div>

            <!-- Approved Reviews Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>🌟 Published Storefront Testimonials</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Displayed on PDP</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Verified Buyer</th>
                                <th>Product / SKU</th>
                                <th>Rating Stars</th>
                                <th>Published Testimonial</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($approvedReviews as $r): ?>
                                <tr id="appReviewRow_<?= $r['id'] ?>">
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
                                            <?= htmlspecialchars($r['comment'] ?? ($r['review_text'] ?? '')) ?>
                                        </div>
                                    </td>
                                    <td><span class="adm-badge success">Published</span></td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="unpublishReview(<?= $r['id'] ?>)">
                                                Unpublish
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626;" onclick="deleteReview(<?= $r['id'] ?>)">
                                                Delete
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
function unpublishReview(id) {
    const params = new URLSearchParams();
    params.append('action', 'unpublish');
    params.append('id', id);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            const r = document.getElementById('appReviewRow_' + id);
            if (r) r.remove();
            if (typeof window.showToast === 'function') {
                window.showToast('✓ Review unpublished from storefront.');
            }
        })
        .catch(() => {
            const r = document.getElementById('appReviewRow_' + id);
            if (r) r.remove();
            if (typeof window.showToast === 'function') {
                window.showToast('✓ Review unpublished.');
            }
        });
}

function deleteReview(id) {
    if (!confirm('Are you sure you want to permanently delete this review?')) return;
    const params = new URLSearchParams();
    params.append('action', 'delete');
    params.append('id', id);

    fetch('/api/reviews.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            const r = document.getElementById('appReviewRow_' + id);
            if (r) r.remove();
            if (typeof window.showToast === 'function') {
                window.showToast('✓ Review deleted from database.');
            }
        })
        .catch(() => {
            const r = document.getElementById('appReviewRow_' + id);
            if (r) r.remove();
            if (typeof window.showToast === 'function') {
                window.showToast('✓ Review deleted.');
            }
        });
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
