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
 * view.php — Comprehensive Payment Details & Webhook Inspector
 * Section 28 (Payment Admin)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$page_title = "Payment Details & Audit Record";
$active_nav = "payments";
$active_subnav = "index";

$pdo = Database::getConnection();

$txId = (int)($_GET['id'] ?? 0);
$orderNum = trim((string)($_GET['order_number'] ?? ''));

$tx = null;
$order = null;
$webhooks = [];

if ($pdo !== null && !Database::isMockMode()) {
    try {
        if ($txId > 0) {
            $stmt = $pdo->prepare("SELECT * FROM `payment_transactions` WHERE `id` = :id LIMIT 1");
            $stmt->execute([':id' => $txId]);
            $tx = $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif (!empty($orderNum)) {
            $stmt = $pdo->prepare("SELECT * FROM `payment_transactions` WHERE `order_number` = :ord ORDER BY `id` DESC LIMIT 1");
            $stmt->execute([':ord' => $orderNum]);
            $tx = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if ($tx) {
            $ordStmt = $pdo->prepare("SELECT * FROM `orders` WHERE `order_number` = :ord LIMIT 1");
            $ordStmt->execute([':ord' => $tx['order_number']]);
            $order = $ordStmt->fetch(PDO::FETCH_ASSOC);

            // Fetch recorded webhooks for this order
            $whStmt = $pdo->prepare("SELECT * FROM `payment_webhooks` WHERE `payload_json` LIKE :ordSearch ORDER BY `id` DESC LIMIT 10");
            $whStmt->execute([':ordSearch' => '%' . $tx['order_number'] . '%']);
            $webhooks = $whStmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (\Throwable $e) {
        error_log("Payment view error: " . $e->getMessage());
    }
}

$rupeeSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        .dt-detail-card {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        }
        .dt-detail-card h3 {
            font-family: var(--adm-font-serif, 'Cinzel', serif);
            font-size: 1.05rem;
            font-weight: 800;
            color: #111827;
            margin: 0 0 16px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            border-bottom: 1px solid #F1F5F9;
        }
        .dt-detail-row {
            display: flex;
            justify-content: space-between;
            padding: 9px 0;
            border-bottom: 1px dashed #F1F5F9;
            font-size: 0.85rem;
        }
        .dt-detail-row:last-child { border-bottom: none; }
        .dt-detail-label { color: #64748B; font-weight: 500; }
        .dt-detail-val { color: #111827; font-weight: 700; text-align: right; }
        .dt-raw-box {
            background: #0F172A;
            color: #38BDF8;
            padding: 16px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 0.8rem;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-all;
            max-height: 380px;
            overflow-y: auto;
        }
    </style>
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
                        <span>Payment Details #<?= $tx ? $tx['id'] : '—' ?></span>
                        <?php if ($tx): ?>
                            <?php 
                            $statusBadge = 'gray';
                            if ($tx['status'] === 'captured') $statusBadge = 'success';
                            elseif ($tx['status'] === 'pending') $statusBadge = 'amber';
                            elseif ($tx['status'] === 'failed') $statusBadge = 'danger';
                            elseif ($tx['status'] === 'refunded') $statusBadge = 'danger';
                            ?>
                            <span class="adm-badge <?= $statusBadge ?>"><?= strtoupper(htmlspecialchars($tx['status'])) ?></span>
                        <?php endif; ?>
                    </h1>
                    <p class="adm-page-subtitle">Order Reference: <strong><?= htmlspecialchars($tx['order_number'] ?? 'Not found') ?></strong></p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/payments/" class="dt-btn dt-btn-pale" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; padding:6px 14px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Ledger</span>
                    </a>
                    <?php if ($tx): ?>
                        <a href="/admin/orders/view.php?order_number=<?= urlencode($tx['order_number']) ?>" class="dt-btn dt-btn-gold" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:800; padding:6px 14px;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            <span>View Order</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!$tx): ?>
                <div class="adm-card" style="padding:40px; text-align:center; color:#64748B;">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.5" style="margin-bottom:12px;"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    <h3>Transaction Record Not Found</h3>
                    <p>The requested transaction ID or order reference does not exist in the database.</p>
                    <a href="/admin/payments/" class="dt-btn dt-btn-gold" style="text-decoration:none; display:inline-block; margin-top:10px;">Return to Payments Ledger</a>
                </div>
            <?php else: ?>

                <!-- Details Grid -->
                <div class="dt-detail-grid">
                    
                    <!-- 1. Transaction Summary -->
                    <div class="dt-detail-card">
                        <h3>
                            <span>Financial Summary</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path><line x1="12" y1="6" x2="12" y2="8"></line><line x1="12" y1="16" x2="12" y2="18"></line></svg>
                        </h3>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Transaction ID</span>
                            <span class="dt-detail-val">#<?= $tx['id'] ?></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Order Number</span>
                            <span class="dt-detail-val"><strong><?= htmlspecialchars($tx['order_number']) ?></strong></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Captured Amount</span>
                            <span class="dt-detail-val" style="font-size:1.1rem; color:#15803D;"><strong><?= $rupeeSvg ?> <?= number_format((float)$tx['amount'], 2) ?></strong></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Currency</span>
                            <span class="dt-detail-val"><?= htmlspecialchars($tx['currency'] ?? 'INR') ?></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Gateway Method</span>
                            <span class="dt-detail-val"><span class="adm-badge gold"><?= strtoupper(htmlspecialchars($tx['gateway'])) ?></span></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Captured Timestamp</span>
                            <span class="dt-detail-val"><?= date('d M Y, h:i:s A', strtotime($tx['created_at'])) ?></span>
                        </div>
                    </div>

                    <!-- 2. Gateway Reference & Security -->
                    <div class="dt-detail-card">
                        <h3>
                            <span>Gateway Identifiers</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </h3>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Gateway Order ID</span>
                            <span class="dt-detail-val"><code><?= htmlspecialchars($tx['gateway_order_id'] ?: 'N/A') ?></code></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Gateway Payment ID</span>
                            <span class="dt-detail-val"><code><?= htmlspecialchars($tx['gateway_payment_id'] ?: 'N/A') ?></code></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Bank UTR Reference</span>
                            <span class="dt-detail-val">
                                <?php if (!empty($tx['utr_reference'])): ?>
                                    <code style="background:#FAF5E8; color:#8A681F; font-weight:800; padding:2px 8px; border-radius:4px;"><?= htmlspecialchars($tx['utr_reference']) ?></code>
                                <?php else: ?>
                                    <span style="color:#94A3B8;">None</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Gateway Event ID</span>
                            <span class="dt-detail-val"><code><?= htmlspecialchars($tx['gateway_event_id'] ?? 'N/A') ?></code></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">HMAC Signature</span>
                            <span class="dt-detail-val"><span class="adm-badge <?= !empty($tx['gateway_signature']) ? 'success' : 'gray' ?>"><?= !empty($tx['gateway_signature']) ? 'VERIFIED' : 'NOT_APPLICABLE' ?></span></span>
                        </div>
                    </div>

                    <!-- 3. Idempotency & Stock Decrement Audit -->
                    <div class="dt-detail-card">
                        <h3>
                            <span>Idempotency &amp; Stock Audit</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </h3>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Storefront Order Status</span>
                            <span class="dt-detail-val">
                                <?php if ($order): ?>
                                    <span class="adm-badge <?= ($order['payment_status'] ?? '') === 'paid' ? 'success' : 'amber' ?>">
                                        <?= strtoupper(htmlspecialchars($order['payment_status'] ?? 'pending')) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color:#94A3B8;">Order record missing</span>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Stock Decrement Guard</span>
                            <span class="dt-detail-val">
                                <?php 
                                $isReserved = ($order && strpos((string)$order['notes'], '[stock_reserved]') !== false);
                                ?>
                                <span class="adm-badge <?= $isReserved ? 'success' : 'amber' ?>">
                                    <?= $isReserved ? 'SINGLE DECREMENT SECURED' : 'PENDING OR MANUAL' ?>
                                </span>
                            </span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Replay Safe Status</span>
                            <span class="dt-detail-val"><span class="adm-badge success">IDEMPOTENT</span></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Customer Name</span>
                            <span class="dt-detail-val"><?= htmlspecialchars($tx['customer_name'] ?? ($order['customer_name'] ?? 'Customer')) ?></span>
                        </div>
                        <div class="dt-detail-row">
                            <span class="dt-detail-label">Customer Phone</span>
                            <span class="dt-detail-val"><?= htmlspecialchars($tx['customer_phone'] ?? ($order['customer_phone'] ?? 'N/A')) ?></span>
                        </div>
                    </div>

                </div>

                <!-- Webhook Payload Audit -->
                <div class="adm-card" style="margin-bottom:24px; padding:20px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                        <h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; margin:0; display:flex; align-items:center; gap:8px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                            <span>Raw Webhook &amp; Payload Log</span>
                        </h3>
                        <span class="adm-badge gold">Audit Trail</span>
                    </div>

                    <?php if (!empty($tx['webhook_payload'])): ?>
                        <?php 
                        $decoded = json_decode($tx['webhook_payload'], true);
                        $formattedJson = $decoded ? json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : $tx['webhook_payload'];
                        ?>
                        <div class="dt-raw-box"><?= htmlspecialchars($formattedJson) ?></div>
                    <?php else: ?>
                        <div style="padding:20px; text-align:center; color:#64748B; background:#F8FAFC; border-radius:8px;">
                            No raw webhook payload stored for this direct or manual transaction.
                        </div>
                    <?php endif; ?>
                </div>

            <?php endif; ?>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
