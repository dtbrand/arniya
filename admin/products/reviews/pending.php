<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reviews/pending.php — Reviews Awaiting Moderation
 * DT Brand's & Jai Hanuman Tex
 *
 * Previously a single invented row ("Pooja Varma, Chanderi Silk Festive
 * Saree") with an Approve button that only raised a toast. Now reads the
 * live pending queue and wires approve/reject to /api/reviews.php.
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$page_title = "Pending Reviews";
$active_nav = "products";
$active_subnav = "reviews";

$pending = [];
$pdoPend = Database::getConnection();
if ($pdoPend !== null && !Database::isMockMode()) {
    try {
        $pending = Database::query(
            "SELECT r.*, p.title AS product_title, p.sku AS product_sku
             FROM reviews r
             LEFT JOIN products p ON r.product_id = p.id
             WHERE r.status = 'pending'
             ORDER BY r.id DESC
             LIMIT 100"
        );
    } catch (\Throwable $e) {
        $pending = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Reviews — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Pending Reviews Moderation</span><span class="adm-badge rose"><?php echo count($pending); ?> Pending</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/admin/products/reviews/" class="adm-btn-secondary"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-right:4px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>All Reviews</a>
                </div>
            </div>
            <div class="adm-table-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead><tr><th>Customer</th><th>Product</th><th>Rating</th><th>Feedback</th><th>Action</th></tr></thead>
                        <tbody>
                        <?php if (empty($pending)): ?>
                            <tr><td colspan="5" style="padding:20px; text-align:center; color:#64748B;">The moderation queue is empty. Every submitted review has been processed.</td></tr>
                        <?php else: ?>
                            <?php foreach ($pending as $pr): $pid = (int)$pr['id']; ?>
                            <tr id="pending-row-<?= $pid ?>">
                                <td><strong><?= htmlspecialchars((string)($pr['customer_name'] ?? 'Customer')) ?></strong></td>
                                <td><?= htmlspecialchars((string)($pr['product_title'] ?? ('Product #' . ($pr['product_id'] ?? '—')))) ?><code style="display:block; font-size:10px; color:#8A681F;"><?= htmlspecialchars((string)($pr['product_sku'] ?? '')) ?></code></td>
                                <td><span style="display:inline-flex; align-items:center; gap:3px; color:#D4AF37; font-weight:800;"><?= (int)($pr['rating'] ?? 5) ?> <svg width="12" height="12" viewBox="0 0 24 24" fill="#D4AF37" stroke="#8A681F" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></span></td>
                                <td>"<?= htmlspecialchars(mb_substr((string)($pr['review_text'] ?? ''), 0, 120)) ?>"</td>
                                <td style="display:flex; gap:6px;">
                                    <button class="dt-btn dt-btn-gold adm-btn-sm" onclick="moderatePending(<?= $pid ?>, 'approve')" style="display:inline-flex; align-items:center; gap:4px;"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg><span>Approve</span></button>
                                    <button class="dt-btn dt-btn-pale adm-btn-sm" onclick="moderatePending(<?= $pid ?>, 'reject')" style="display:inline-flex; align-items:center; gap:4px; color:#DC2626;"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg><span>Reject</span></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function moderatePending(id, action) {
    const params = new URLSearchParams();
    params.append('action', action);
    params.append('id', id);
    fetch('/api/reviews.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast(data.message || 'Action failed');
                return;
            }
            const row = document.getElementById('pending-row-' + id);
            if (row) row.remove();
            if (typeof window.showToast === 'function') window.showToast('Review ' + action + 'd');
        })
        .catch(() => {
            if (typeof window.showToast === 'function') window.showToast('Could not reach the server');
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>