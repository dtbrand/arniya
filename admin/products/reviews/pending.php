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
    <title>Pending Reviews ‹ DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Pending Reviews Moderation</span><span class="adm-badge rose"><?php echo count($pending); ?> Pending</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/admin/products/reviews/" class="adm-btn-secondary">← All Reviews</a>
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
                                <td><?= (int)($pr['rating'] ?? 5) ?> ★</td>
                                <td>"<?= htmlspecialchars(mb_substr((string)($pr['review_text'] ?? ''), 0, 120)) ?>"</td>
                                <td style="display:flex; gap:6px;">
                                    <button class="adm-btn-primary adm-btn-sm" onclick="moderatePending(<?= $pid ?>, 'approve')">Approve</button>
                                    <button class="adm-btn-secondary adm-btn-sm" onclick="moderatePending(<?= $pid ?>, 'reject')">Reject</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
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
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Action failed'));
                return;
            }
            const row = document.getElementById('pending-row-' + id);
            if (row) row.remove();
            if (typeof window.showToast === 'function') window.showToast('✓ Review ' + action + 'd');
        })
        .catch(() => {
            if (typeof window.showToast === 'function') window.showToast('⚠️ Could not reach the server');
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>