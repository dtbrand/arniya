<?php
/* DT admin access guard (auto-inserted with dual relative fallback) */
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = __DIR__ . '/../includes/adminguard.php';
    if (!is_file($__dtg)) {
        $__dtg = dirname(__DIR__, 2) . '/admin/includes/adminguard.php';
    }
}
if (is_file($__dtg)) require_once $__dtg;

/**
 * refunds.php - DT Brand's Admin Refund Requests & Ledger
 * Section 28 (Payment Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$page_title = "Refund Requests & Ledger";
$active_nav = "payments";
$active_subnav = "refunds";

$pdo = Database::getConnection();
$refundsList = [];

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("
            SELECT * FROM `payment_transactions` 
            WHERE `status` = 'refunded' 
            ORDER BY `id` DESC 
            LIMIT 50
        ");
        $refundsList = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {}
}

$rupeeSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Requests &amp; Ledger — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Refund Requests &amp; Ledger</span>
                        <span class="adm-badge gold"><?= count($refundsList) ?> Refunds</span>
                    </h1>
                    <p class="adm-page-subtitle">Audit log of processed refunds, customer returns, and gateway chargebacks.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/payments/" class="dt-btn dt-btn-pale" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Transactions Ledger</span>
                    </a>
                    <a href="/admin/payments/reconciliation.php" class="dt-btn dt-btn-pale" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        <span>Reconciliation</span>
                    </a>
                </div>
            </div>

            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; margin:0;">Processed Refunds Log</h3></div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Tx ID</th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Gateway Ref</th>
                                <th>Refund Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($refundsList)): ?>
                                <?php foreach ($refundsList as $r): ?>
                                    <tr>
                                        <td>#<?= $r['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($r['order_number']) ?></strong></td>
                                        <td><?= htmlspecialchars($r['customer_name'] ?? 'Customer') ?></td>
                                        <td><strong style="color:#DC2626;"><?= $rupeeSvg ?> <?= number_format((float)$r['amount'], 2) ?></strong></td>
                                        <td><code><?= htmlspecialchars($r['gateway_payment_id'] ?: 'RF_DIRECT') ?></code></td>
                                        <td style="font-size:0.75rem; color:#64748B;"><?= date('d M Y', strtotime($r['created_at'])) ?></td>
                                        <td><span class="adm-badge danger">Refunded</span></td>
                                        <td>
                                            <a href="/admin/payments/view.php?id=<?= $r['id'] ?>" class="dt-btn dt-btn-pale dt-btn-sm" style="text-decoration:none; display:inline-flex; align-items:center; gap:4px; padding:3px 8px; font-size:0.72rem; font-weight:700;">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>Inspect</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:35px; color:#64748B;">
                                        Zero refund requests or chargebacks logged in ledger.
                                    </td>
                                </tr>
                            <?php endif; ?>
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
