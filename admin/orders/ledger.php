<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * ledger.php — Printable B2B Customer Account & Financial Ledger Statement
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/OrderManager.php';

use DTBrand\Database;
use DTBrand\OrderManager;

$order_id = isset($_GET['id']) ? trim($_GET['id']) : '';
$auto_print = isset($_GET['print']) && $_GET['print'] === '1';

$rawOrder = null;
if (!empty($order_id)) {
    $rawOrder = OrderManager::getOrderDetails($order_id);
}

if (!$rawOrder) {
    $recentOrders = OrderManager::getAll();
    if (!empty($recentOrders[0]['id'])) {
        $rawOrder = OrderManager::getOrderDetails($recentOrders[0]['id']);
    }
}

$db = Database::getConnection();
$customer_name = 'Customer Account';
$phone = '+91 70463 63528';
$email = '—';
$address = 'Surat Central Textile Depot, Ring Road, Surat, Gujarat - 395002';
$gstin = '24AAECJ1928K1Z5';
$account_tier = 'Verified Wholesale Account';
$credit_limit = '5,00,000 (Net 15 Days)';

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-1.5px; margin-right:2px;" aria-hidden="true"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
$rupeeSvgSm = '<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-1px; margin-right:1px;" aria-hidden="true"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';

$transactions = [];
$totalDebit = 0.0;
$totalCredit = 0.0;

if ($rawOrder) {
    $customer_name = $rawOrder['customer_name'] ?? 'Direct Customer';
    $phone = !empty($rawOrder['customer_phone']) ? $rawOrder['customer_phone'] : '+91 70463 63528';
    $address = !empty($rawOrder['shipping_address']) ? $rawOrder['shipping_address'] : $address;

    $custOrders = [];
    if ($db !== null && !Database::isMockMode()) {
        try {
            $cQuery = "SELECT * FROM orders WHERE (customer_id = ? AND customer_id > 0) OR customer_phone = ? OR customer_name = ? ORDER BY id ASC";
            $stmt = $db->prepare($cQuery);
            $stmt->execute([(int)($rawOrder['customer_id'] ?? 0), $phone, $customer_name]);
            $custOrders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            $custOrders = [$rawOrder];
        }
    }
    if (empty($custOrders)) {
        $custOrders = [$rawOrder];
    }

    $runningBalance = 0.0;
    foreach ($custOrders as $co) {
        $ordNum = $co['order_number'] ?? ('DTB-' . str_pad($co['id'], 6, '0', STR_PAD_LEFT));
        $ordDate = !empty($co['created_at']) ? date('d-M-Y', strtotime($co['created_at'])) : date('d-M-Y');
        $amt = (float)($co['total_amount'] ?? 0);
        
        // 1. Order Debit
        $runningBalance += $amt;
        $totalDebit += $amt;
        $transactions[] = [
            'date' => $ordDate,
            'ref' => $ordNum,
            'desc' => 'Consignment Order Invoice #' . $ordNum,
            'debit' => $amt,
            'credit' => null,
            'balance' => $runningBalance,
            'status' => 'Billed',
            'status_color' => '#B45309'
        ];

        // 2. If Paid, Credit
        if (strtolower($co['payment_status'] ?? '') === 'paid') {
            $runningBalance -= $amt;
            $totalCredit += $amt;
            $payRef = 'TXN-' . str_pad($co['id'], 6, '0', STR_PAD_LEFT);
            $transactions[] = [
                'date' => $ordDate,
                'ref' => $payRef,
                'desc' => 'Settlement via ' . ($co['payment_method'] ?? 'Online / UPI'),
                'debit' => null,
                'credit' => $amt,
                'balance' => $runningBalance,
                'status' => 'PAID',
                'status_color' => '#15803D'
            ];
        }
    }
}
$outstandingBalance = $totalDebit - $totalCredit;

$page_title = "Financial Ledger — " . $customer_name;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> — DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/documents.css?v=<?php echo time(); ?>">
    <style>
        .dt-ledger-doc {
            max-width: 860px;
            margin: 0 auto;
            background: #FFFFFF;
            border: 1.5px solid #8A681F;
            border-radius: 8px;
            padding: 28px 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #181512;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .dt-rupee-svg {
            display: inline-block;
            vertical-align: middle;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.4;
        }
        @media print {
            body {
                background: #FFFFFF !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            body * {
                visibility: hidden;
            }
            .dt-ledger-doc, .dt-ledger-doc * {
                visibility: visible;
            }
            .dt-ledger-doc {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                max-width: 100% !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
            }
            .dt-doc-actions-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body style="background:#F1F5F9; padding:24px 0;">

<!-- Actions Bar -->
<div class="dt-doc-actions-bar" style="max-width:860px; margin:0 auto 16px auto; display:flex; justify-content:space-between; align-items:center;">
    <a href="/admin/orders/" class="dt-btn dt-btn-pale">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        <span>Back to Orders</span>
    </a>
    <div style="display:flex; gap:8px;">
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_DOCS.exportLedgerExcel()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export Excel</span>
        </button>
        <button type="button" class="dt-btn dt-btn-gold" onclick="window.print()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            <span>Print Statement</span>
        </button>
    </div>
</div>

<!-- Ledger Document Container -->
<div class="dt-doc-container dt-ledger-doc">
    
    <!-- Letterhead Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:14px; margin-bottom:16px;">
        <div style="display:flex; align-items:center; gap:16px;">
            <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/assets/images/logo.png';" alt="DT Brand's Logo" style="height:54px; width:auto; max-width:180px; object-fit:contain; display:block; flex-shrink:0;">
            <div>
                <h1 style="margin:0; font-size:20px; font-weight:800; color:#181512; letter-spacing:-0.02em; line-height:1.2;">DT BRAND'S &amp; JAI HANUMAN TEX</h1>
                <div style="font-size:11px; color:#64748B; margin-top:3px; line-height:1.35;">
                    Surat Central Textile Depot, Ring Road, Surat, Gujarat - 395002<br>
                    GSTIN: <strong>24AAECJ1928K1Z5</strong> • Silk Mark Certified Wholesale Handlooms
                </div>
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:16px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.5px;">ACCOUNT LEDGER</div>
            <div style="font-size:11px; color:#64748B; margin-top:2px;">Statement Period: <strong>FY <?= date('Y') ?>-<?= date('y', strtotime('+1 year')) ?></strong></div>
            <div style="font-size:11px; color:#64748B;">Date: <strong><?php echo date('d M Y'); ?></strong></div>
        </div>
    </div>

    <!-- Customer Overview Box -->
    <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px 16px; margin-bottom:16px; display:grid; grid-template-columns:1fr 1fr; gap:12px; font-size:11.5px; line-height:1.5;">
        <div>
            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:3px;">Account Holder:</div>
            <strong style="font-size:14px; color:#181512;"><?php echo htmlspecialchars($customer_name); ?></strong><br>
            <span style="color:#475569;"><?php echo htmlspecialchars($address); ?></span><br>
            <strong>GSTIN:</strong> <?php echo htmlspecialchars($gstin); ?> | <strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?>
        </div>
        <div style="border-left:1px dashed #D4AF37; padding-left:16px;">
            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:3px;">Wholesale Terms:</div>
            <strong>Account Tier:</strong> <?php echo htmlspecialchars($account_tier); ?><br>
            <strong>Credit Limit:</strong> <?= $rupeeSvg ?><?php echo htmlspecialchars($credit_limit); ?><br>
            <strong>Ledger Balance:</strong> <strong style="color:<?= $outstandingBalance <= 0 ? '#15803D' : '#B45309' ?>; display:inline-flex; align-items:center;"><?= $rupeeSvg ?><?= number_format($outstandingBalance, 2) ?>&nbsp;(<?= $outstandingBalance <= 0 ? 'All Invoices Settled' : 'Payment Due' ?>)</strong>
        </div>
    </div>

    <!-- 4 Metrics Ribbon -->
    <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:10px; margin-bottom:16px;">
        <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:8px 12px;">
            <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Lifetime Business</div>
            <div style="font-size:15px; font-weight:800; color:#181512; margin-top:2px; display:inline-flex; align-items:center;"><?= $rupeeSvg ?><?= number_format($totalDebit, 2) ?></div>
            <div style="font-size:9.5px; color:#64748B;"><?= count($transactions) ?> Entries Recorded</div>
        </div>
        <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:8px 12px;">
            <div style="font-size:9.5px; font-weight:800; color:#15803D; text-transform:uppercase;">Total Settled</div>
            <div style="font-size:15px; font-weight:800; color:#15803D; margin-top:2px; display:inline-flex; align-items:center;"><?= $rupeeSvg ?><?= number_format($totalCredit, 2) ?></div>
            <div style="font-size:9.5px; color:#16A34A; font-weight:700;"><?= $totalDebit > 0 ? round(($totalCredit / $totalDebit) * 100, 1) . '% Cleared' : '100% Cleared' ?></div>
        </div>
        <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:8px 12px;">
            <div style="font-size:9.5px; font-weight:800; color:#64748B; text-transform:uppercase;">Current Balance</div>
            <div style="font-size:15px; font-weight:800; color:#181512; margin-top:2px; display:inline-flex; align-items:center;"><?= $rupeeSvg ?><?= number_format($outstandingBalance, 2) ?></div>
            <div style="font-size:9.5px; color:<?= $outstandingBalance <= 0 ? '#15803D' : '#B45309' ?>; font-weight:700;"><?= $outstandingBalance <= 0 ? 'All Cleared' : 'Pending' ?></div>
        </div>
        <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:8px 12px;">
            <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Credit Facility</div>
            <div style="font-size:15px; font-weight:800; color:#8A681F; margin-top:2px; display:inline-flex; align-items:center;"><?= $rupeeSvg ?>5,00,000</div>
            <div style="font-size:9.5px; color:#64748B;">Net 15 Days Term</div>
        </div>
    </div>

    <!-- Transaction Table -->
    <table style="width:100%; border-collapse:collapse; font-size:11.5px; margin-bottom:16px;">
        <thead>
            <tr style="background:#181512; color:#FAF5E8;">
                <th style="padding:8px 10px; text-align:left; font-size:10px; text-transform:uppercase;">Date</th>
                <th style="padding:8px 10px; text-align:left; font-size:10px; text-transform:uppercase;">Reference ID</th>
                <th style="padding:8px 10px; text-align:left; font-size:10px; text-transform:uppercase;">Transaction Description</th>
                <th style="padding:8px 10px; text-align:right; font-size:10px; text-transform:uppercase;">Debit (<?= $rupeeSvgSm ?>)</th>
                <th style="padding:8px 10px; text-align:right; font-size:10px; text-transform:uppercase;">Credit (<?= $rupeeSvgSm ?>)</th>
                <th style="padding:8px 10px; text-align:right; font-size:10px; text-transform:uppercase;">Balance (<?= $rupeeSvgSm ?>)</th>
                <th style="padding:8px 10px; text-align:center; font-size:10px; text-transform:uppercase;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($transactions)): ?>
            <tr>
                <td colspan="7" style="text-align:center; padding:20px; color:#64748B;">No ledger transactions recorded for this account.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($transactions as $t): ?>
            <tr style="border-bottom:1px solid #E2E8F0;">
                <td style="padding:7px 10px;"><?= htmlspecialchars($t['date']) ?></td>
                <td style="padding:7px 10px; font-weight:800; color:#8A681F;"><?= htmlspecialchars($t['ref']) ?></td>
                <td style="padding:7px 10px;"><?= htmlspecialchars($t['desc']) ?></td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;"><?= $t['debit'] !== null ? number_format($t['debit'], 2) : '—' ?></td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;"><?= $t['credit'] !== null ? number_format($t['credit'], 2) : '—' ?></td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;"><?= number_format($t['balance'], 2) ?></td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:<?= $t['status_color'] ?>;"><?= htmlspecialchars($t['status']) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr style="background:#FAF5E8; font-weight:800; border-top:2px solid #8A681F; border-bottom:2px solid #8A681F;">
                <td colspan="3" style="padding:10px; text-align:right; color:#181512; text-transform:uppercase;">RECONCILED TOTALS:</td>
                <td style="padding:10px; text-align:right; color:#181512;"><span style="display:inline-flex; align-items:center; justify-content:flex-end;"><?= $rupeeSvg ?><?= number_format($totalDebit, 2) ?></span></td>
                <td style="padding:10px; text-align:right; color:#15803D;"><span style="display:inline-flex; align-items:center; justify-content:flex-end;"><?= $rupeeSvg ?><?= number_format($totalCredit, 2) ?></span></td>
                <td style="padding:10px; text-align:right; color:<?= $outstandingBalance <= 0 ? '#15803D' : '#B45309' ?>;"><span style="display:inline-flex; align-items:center; justify-content:flex-end;"><?= $rupeeSvg ?><?= number_format($outstandingBalance, 2) ?></span></td>
                <td style="padding:10px; text-align:center; color:<?= $outstandingBalance <= 0 ? '#15803D' : '#B45309' ?>;"><?= $outstandingBalance <= 0 ? 'ALL CLEAR' : 'DUE' ?></td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer Stamp -->
    <div style="display:flex; justify-content:space-between; align-items:flex-end; border-top:1px solid #E2DFD7; padding-top:14px; font-size:10.5px; color:#64748B;">
        <div>
            This is a computer-generated B2B accounting statement from DT Brand's &amp; Jai Hanuman Tex Surat Central Depot.<br>
            Direct Inquiries: accounts@jaihanumantex.in | Central Helpline: +91 70463 63528
        </div>
        <div style="text-align:right; font-weight:700; color:#181512;">
            Authorized Accounting Signatory<br>
            <span style="font-weight:400; font-size:9.5px; color:#8A681F;">Surat Central Depot Dock HQ</span>
        </div>
    </div>

</div>

<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/order-view.js?v=<?php echo time(); ?>"></script>
<?php if ($auto_print): ?>
<script>
window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        window.print();
    }, 400);
});
</script>
<?php endif; ?>
</body>
</html>
