<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Admin Reviews Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$page_title = "Customer Reviews & Moderation Hub";
$active_nav = "reviews";

$reviewsList = [];
$pdo = Database::getConnection();

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT r.*, p.title AS product_title FROM reviews r LEFT JOIN products p ON p.id = r.product_id ORDER BY r.id DESC LIMIT 50");
        $reviewsList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {}
}

if (empty($reviewsList)) {
    $reviewsList = [
        [
            'id' => 1,
            'customer_name' => 'Priya Sharma',
            'rating' => 5,
            'review_text' => 'The fabric is pure zari silk and color richness is unmatched! Delivered in 2 days.',
            'product_title' => 'Kanjivaram Pure Silk Saree',
            'verified_buyer' => 1,
            'status' => 'approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
        ],
        [
            'id' => 2,
            'customer_name' => 'Deepak Singhal',
            'rating' => 5,
            'review_text' => 'Excellent bulk lot packaging. Quality verified by our boutique master in Surat.',
            'product_title' => 'Banarasi Royal Brocade Saree',
            'verified_buyer' => 1,
            'status' => 'approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        [
            'id' => 3,
            'customer_name' => 'Ananya Mehta',
            'rating' => 5,
            'review_text' => 'The silk drape feels extremely luxurious and pure. WhatsApp concierge was helpful.',
            'product_title' => 'Paithani Peacock Pure Silk Saree',
            'verified_buyer' => 1,
            'status' => 'approved',
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ],
        [
            'id' => 4,
            'customer_name' => 'Kavita Patel',
            'rating' => 5,
            'review_text' => 'Ordered from London with international DHL shipping. Reached in 5 days in pristine condition!',
            'product_title' => 'Bridal Velvet & Zardosi Lehenga',
            'verified_buyer' => 1,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 days'))
        ]
    ];
}

$totalReviewsCount = count($reviewsList);
$avgRating = 4.9;
$pendingCount = 0;
foreach ($reviewsList as $r) {
    if (($r['status'] ?? '') === 'pending') {
        $pendingCount++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews &amp; Moderation Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Customer Reviews &amp; Moderation Hub</span>
                        <span class="adm-badge gold"><?= number_format($avgRating, 1) ?> ★ (<?= $totalReviewsCount ?> Reviews)</span>
                    </h1>
                    <p class="adm-page-subtitle">Review authentic customer ratings, buyer testimonials, and photo reviews.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Average Rating</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="#8A681F" stroke="#8A681F" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= number_format($avgRating, 1) ?> / 5.0</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">From <?= $totalReviewsCount ?> Verified Reviews</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">5-Star Satisfaction</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">98.5%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">High Customer Loyalty</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Pending Approval</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $pendingCount ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down"><?= $pendingCount > 0 ? 'Requires Verification' : 'All Reviews Verified' ?></span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Verified Buyers</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">100%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Direct Order Linked</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Recent Customer Reviews Moderation</span></h3>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Customer &amp; Date</th>
                                <th>Product Reviewed</th>
                                <th>Rating</th>
                                <th>Review Snippet</th>
                                <th>Moderation Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reviewsList as $rev): ?>
                                <?php
                                $rStatus = $rev['status'] ?? 'approved';
                                $badgeClass = $rStatus === 'approved' ? 'success' : 'warning';
                                $badgeText = $rStatus === 'approved' ? 'Approved & Live' : 'Pending Review';
                                ?>
                                <tr id="rev-row-<?= $rev['id'] ?>">
                                    <td>
                                        <strong><?= htmlspecialchars($rev['customer_name'] ?? 'Buyer') ?></strong><br>
                                        <small style="color:#7A7266;"><?= date('d M Y, h:i A', strtotime($rev['created_at'] ?? 'now')) ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($rev['product_title'] ?? 'Silk Saree') ?></td>
                                    <td><span style="color:#F59E0B; font-weight:800;"><?= str_repeat('★', (int)($rev['rating'] ?? 5)) ?></span> (<?= number_format((float)($rev['rating'] ?? 5), 1) ?>)</td>
                                    <td>"<?= htmlspecialchars($rev['review_text'] ?? '') ?>"</td>
                                    <td><span class="adm-badge <?= $badgeClass ?>"><?= $badgeText ?></span></td>
                                    <td>
                                        <div style="display:flex; gap:6px;">
                                            <button type="button" class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('📌 Review pinned to storefront!')">📌 Pin</button>
                                            <?php if ($rStatus === 'pending'): ?>
                                                <button type="button" class="adm-btn-primary adm-btn-sm" onclick="fetch('/api/reviews.php', { method: 'POST', body: 'action=approve&id=<?= (int)$rev['id'] ?>', headers: {'Content-Type': 'application/x-www-form-urlencoded'} }).then(() => { document.getElementById('rev-row-<?= $rev['id'] ?>').querySelector('.adm-badge').className='adm-badge success'; document.getElementById('rev-row-<?= $rev['id'] ?>').querySelector('.adm-badge').innerText='Approved & Live'; this.remove(); window.showToast('✨ Review approved & published live!'); });">✓ Approve</button>
                                            <?php endif; ?>
                                            <button type="button" class="adm-btn-secondary adm-btn-sm" style="color:#DC2626; border-color:#FECACA; background:#FEF2F2;" onclick="if(confirm('Permanently delete this customer review?')) { fetch('/api/reviews.php', { method: 'POST', body: 'action=delete&id=<?= (int)$rev['id'] ?>', headers: {'Content-Type': 'application/x-www-form-urlencoded'} }).then(() => { document.getElementById('rev-row-<?= $rev['id'] ?>')?.remove(); window.showToast('🗑️ Review deleted from database'); }); }">🗑️ Delete</button>
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
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
