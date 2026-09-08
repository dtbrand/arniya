<?php
/* DT admin access guard (auto-inserted) */ 
$__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; 
if (is_file($__dtg)) require_once $__dtg;

/**
 * pending.php - DT Brand's Admin Pending Payments & UTR Verification
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$page_title = "Pending Payments & UTR Verification";
$active_nav = "payments";
$active_subnav = "pending";

$pdo = Database::getConnection();
$pendingTransactions = [];

// Handle 1-Click Approval
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'approve_utr') {
    $txId = (int)($_POST['tx_id'] ?? 0);
    $orderNum = trim((string)($_POST['order_number'] ?? ''));
    $utrRef = trim((string)($_POST['utr_ref'] ?? ''));

    if ($pdo && $txId > 0 && !empty($orderNum)) {
        try {
            // 1. Update Transaction
            $stmt1 = $pdo->prepare("UPDATE `payment_transactions` SET `status` = 'captured', `notes` = 'Manually approved by admin', `updated_at` = NOW() WHERE `id` = :id");
            $stmt1->execute([':id' => $txId]);

            // 2. Mark order paid & adjust inventory stock
            PaymentManager::markOrderPaidAndAdjustStock($orderNum, 'direct_upi', $utrRef ?: 'APPROVED_BY_ADMIN');

            $successMsg = "Order #{$orderNum} has been verified, marked as Paid, and inventory stock decremented!";
        } catch (\Throwable $e) {
            $errorMsg = "Error approving payment: " . $e->getMessage();
        }
    }
}

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("
            SELECT * FROM `payment_transactions` 
            WHERE `status` IN ('pending', 'authorized') 
            ORDER BY `id` DESC 
            LIMIT 50
        ");
        $pendingTransactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {}
}

$rupeeSvg = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Payments &amp; UTR Verification - DT Brand's Admin</title>
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
                        <span>Pending Payments &amp; UTR Verification</span>
                        <span class="adm-badge gold"><?= count($pendingTransactions) ?> Pending</span>
                    </h1>
                    <p class="adm-page-subtitle">Verify customer-submitted 12-digit UPI UTR references, NEFT Bank Wire, and pending online gateways.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/payments/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Payments Ledger</span>
                    </a>
                    <a href="/admin/settings/payment.php" class="dt-btn dt-btn-gold" style="text-decoration:none; height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Gateway Settings</span>
                    </a>
                </div>
            </div>

            <?php if (!empty($successMsg)): ?>
                <div style="background:#E8F5E9; border:1px solid #15803D; color:#15803D; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-weight:700; display:flex; align-items:center; gap:8px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span><?= htmlspecialchars($successMsg) ?></span>
                </div>
            <?php endif; ?>

            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; margin:0;">Pending UTR &amp; Gateway Audit Queue</h3></div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Tx ID</th>
                                <th>Order Number</th>
                                <th>Customer</th>
                                <th>Gateway</th>
                                <th>Amount</th>
                                <th>UTR / Reference</th>
                                <th>Date &amp; Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pendingTransactions)): ?>
                                <?php foreach ($pendingTransactions as $tx): ?>
                                    <tr>
                                        <td>#<?= $tx['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($tx['order_number']) ?></strong></td>
                                        <td>
                                            <?= htmlspecialchars($tx['customer_name'] ?? 'Guest') ?><br>
                                            <span style="font-size:0.75rem; color:#64748B;"><?= htmlspecialchars($tx['customer_phone'] ?? '') ?></span>
                                        </td>
                                        <td>
                                            <span class="adm-badge <?= $tx['gateway'] === 'direct_upi' ? 'gold' : 'blue' ?>">
                                                <?= strtoupper(htmlspecialchars($tx['gateway'])) ?>
                                            </span>
                                        </td>
                                        <td><strong style="color:#8A681F;"><?= $rupeeSvg ?> <?= number_format((float)$tx['amount'], 2) ?></strong></td>
                                        <td>
                                            <?php if (!empty($tx['utr_reference'])): ?>
                                                <code style="background:#FAF5E8; padding:3px 8px; border-radius:4px; font-weight:800; color:#8A681F;"><?= htmlspecialchars($tx['utr_reference']) ?></code>
                                            <?php else: ?>
                                                <span style="color:#94A3B8; font-size:0.75rem;">Awaiting UTR</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-size:0.75rem; color:#64748B;"><?= date('d M Y, h:i A', strtotime($tx['created_at'])) ?></td>
                                        <td>
                                            <form method="POST" style="margin:0;" onsubmit="return confirm('Confirm approval for Order #<?= htmlspecialchars($tx['order_number']) ?>?');">
                                                <input type="hidden" name="action" value="approve_utr">
                                                <input type="hidden" name="tx_id" value="<?= $tx['id'] ?>">
                                                <input type="hidden" name="order_number" value="<?= htmlspecialchars($tx['order_number']) ?>">
                                                <input type="hidden" name="utr_ref" value="<?= htmlspecialchars($tx['utr_reference'] ?? '') ?>">
                                                <button type="submit" class="dt-btn dt-btn-gold dt-btn-sm" style="padding:4px 10px; font-size:0.75rem; display:inline-flex; align-items:center; gap:5px;">
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                    <span>Approve &amp; Mark Paid</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:35px; color:#64748B;">
                                        All payments verified! Zero pending items in queue.
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
