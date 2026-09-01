<?php
/* DT admin access guard (auto-inserted) */ 
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; 
if (is_file($__dtg)) require_once $__dtg;

/**
 * successful.php - DT Brand's Admin Settled & Verified Collections
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$page_title = "Settled Payments & Verified Collections";
$active_nav = "payments";
$active_subnav = "successful";

$pdo = Database::getConnection();
$settledTransactions = [];
$totalSettledAmount = 0.0;

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("
            SELECT * FROM `payment_transactions` 
            WHERE `status` = 'captured' 
            ORDER BY `id` DESC 
            LIMIT 100
        ");
        $settledTransactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($settledTransactions as $t) {
            $totalSettledAmount += (float)$t['amount'];
        }
    } catch (\Throwable $e) {}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settled Payments Ledger - DT Brand's Admin</title>
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
                        <span>Settled Payments Ledger</span>
                        <span class="adm-badge success">₹<?= number_format($totalSettledAmount, 2) ?> Verified</span>
                    </h1>
                    <p class="adm-page-subtitle">All 100% captured and verified transactions across Instant UPI, Cards, NetBanking, and COD.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/payments/" class="adm-btn-secondary">← Back to Payments Suite</a>
                    <a href="/admin/payments/pending.php" class="adm-btn-secondary">Pending Queue</a>
                </div>
            </div>

            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; margin:0;">Verified Collections Log</h3></div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Tx ID</th>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Gateway</th>
                                <th>Amount</th>
                                <th>Reference / Payment ID</th>
                                <th>Date &amp; Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($settledTransactions)): ?>
                                <?php foreach ($settledTransactions as $tx): ?>
                                    <tr>
                                        <td>#<?= $tx['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($tx['order_number']) ?></strong></td>
                                        <td><?= htmlspecialchars($tx['customer_name'] ?? 'Guest Customer') ?></td>
                                        <td>
                                            <span class="adm-badge gold">
                                                <?= strtoupper(htmlspecialchars($tx['gateway'])) ?>
                                            </span>
                                        </td>
                                        <td><strong style="color:#15803D;">₹<?= number_format((float)$tx['amount'], 2) ?></strong></td>
                                        <td>
                                            <code style="font-size:0.75rem; color:#475569;"><?= htmlspecialchars($tx['utr_reference'] ?: ($tx['gateway_payment_id'] ?: 'CAPTURED_AUTO')) ?></code>
                                        </td>
                                        <td style="font-size:0.75rem; color:#64748B;"><?= date('d M Y, h:i A', strtotime($tx['created_at'])) ?></td>
                                        <td><span class="adm-badge success">✓ Settled</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:35px; color:#64748B;">
                                        ✨ No settled transactions in database yet.
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
