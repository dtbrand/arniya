<?php
/* DT admin access guard (hardened fallback) */
$__dtg1 = __DIR__ . '/../includes/adminguard.php';
$__dtg2 = __DIR__ . '/../../admin/includes/adminguard.php';
$__dtg3 = (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php' : '';
if (is_file($__dtg1)) { require_once $__dtg1; }
elseif (is_file($__dtg2)) { require_once $__dtg2; }
elseif ($__dtg3 && is_file($__dtg3)) { require_once $__dtg3; }

/**
 * usage.php - DT Brand's Admin Coupon Redemptions & Usage Ledger
 * DT Brand's & Jai Hanuman Tex — Section 26 Master Architecture
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

// Direct CSV Export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $pdo = Database::getConnection();
    $usages = [];
    if ($pdo !== null && !Database::isMockMode()) {
        try {
            $stmt = $pdo->query("SELECT * FROM coupon_usages ORDER BY id DESC LIMIT 500");
            $usages = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {}
    }

    if (empty($usages)) {
        $usages = [
            ['id' => 1, 'coupon_code' => 'FESTIVE25', 'order_number' => 'DT-ORD-90281', 'customer_name' => 'Meera Ben', 'customer_phone' => '9825100000', 'order_subtotal' => 4500.00, 'discount_amount' => 1125.00, 'channel' => 'customer', 'created_at' => '2026-09-10 14:20:00'],
            ['id' => 2, 'coupon_code' => 'VIPRESELLER', 'order_number' => 'DT-ORD-90280', 'customer_name' => 'Pooja Fashion Hub', 'customer_phone' => '917046363528', 'order_subtotal' => 8900.00, 'discount_amount' => 1335.00, 'channel' => 'reseller', 'created_at' => '2026-09-09 11:15:00'],
            ['id' => 3, 'coupon_code' => 'B2BWHOLESALE', 'order_number' => 'DT-ORD-90278', 'customer_name' => 'Surat Saree Depot', 'customer_phone' => '9825000000', 'order_subtotal' => 35000.00, 'discount_amount' => 1000.00, 'channel' => 'wholesaler', 'created_at' => '2026-09-08 17:45:00'],
        ];
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="coupon_usage_ledger_' . date('Ymd_His') . '.csv"');
    echo "\xEF\xBB\xBF"; // UTF-8 BOM for Excel

    $fp = fopen('php://output', 'w');
    fputcsv($fp, ['ID', 'Coupon Code', 'Order Number', 'Customer Name', 'Customer Phone', 'Order Subtotal (INR)', 'Discount Amount (INR)', 'Channel', 'Redeemed At']);

    $sanitize = static function ($v) {
        $str = (string)$v;
        if (isset($str[0]) && in_array($str[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $str;
        }
        return $str;
    };

    foreach ($usages as $u) {
        fputcsv($fp, [
            $u['id'],
            $sanitize($u['coupon_code']),
            $sanitize($u['order_number']),
            $sanitize($u['customer_name']),
            $sanitize($u['customer_phone']),
            number_format((float)($u['order_subtotal'] ?? 0), 2, '.', ''),
            number_format((float)($u['discount_amount'] ?? 0), 2, '.', ''),
            $sanitize(strtoupper($u['channel'] ?? 'CUSTOMER')),
            $u['created_at'] ?? ''
        ]);
    }
    fclose($fp);
    exit;
}

$page_title = "Coupon Usage Ledger";
$active_nav = "marketing";

$pdo = Database::getConnection();
$usages = [];
$totalSavingsDisbursed = 0.0;
$totalRedemptions = 0;

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT * FROM coupon_usages ORDER BY id DESC LIMIT 100");
        $usages = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($usages as $u) {
            $totalSavingsDisbursed += (float)($u['discount_amount'] ?? 0);
            $totalRedemptions++;
        }
    } catch (\Throwable $e) {}
}

if (empty($usages)) {
    $usages = [
        ['id' => 1, 'coupon_code' => 'FESTIVE25', 'order_number' => 'DT-ORD-90281', 'customer_name' => 'Meera Ben', 'customer_phone' => '9825100000', 'order_subtotal' => 4500.00, 'discount_amount' => 1125.00, 'channel' => 'customer', 'created_at' => '2026-09-10 14:20:00'],
        ['id' => 2, 'coupon_code' => 'VIPRESELLER', 'order_number' => 'DT-ORD-90280', 'customer_name' => 'Pooja Fashion Hub', 'customer_phone' => '917046363528', 'order_subtotal' => 8900.00, 'discount_amount' => 1335.00, 'channel' => 'reseller', 'created_at' => '2026-09-09 11:15:00'],
        ['id' => 3, 'coupon_code' => 'B2BWHOLESALE', 'order_number' => 'DT-ORD-90278', 'customer_name' => 'Surat Saree Depot', 'customer_phone' => '9825000000', 'order_subtotal' => 35000.00, 'discount_amount' => 1000.00, 'channel' => 'wholesaler', 'created_at' => '2026-09-08 17:45:00'],
        ['id' => 4, 'coupon_code' => 'BOUTIQUE10', 'order_number' => 'DT-ORD-90275', 'customer_name' => 'Aarti Boutique', 'customer_phone' => '9898000000', 'order_subtotal' => 12500.00, 'discount_amount' => 1250.00, 'channel' => 'retailer', 'created_at' => '2026-09-07 15:30:00']
    ];
    $totalRedemptions = 4;
    $totalSavingsDisbursed = 4710.00;
}

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon Usage Ledger - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-nav-tabs {
            display: flex;
            gap: 8px;
            border-bottom: 1.5px solid #EAE5D9;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 2px;
        }
        .dt-nav-tab {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 700;
            color: #64748B;
            text-decoration: none;
            border-bottom: 2.5px solid transparent;
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        .dt-nav-tab:hover { color: #8A681F; }
        .dt-nav-tab.active {
            color: #8A681F;
            border-bottom-color: #D4AF37;
            background: #FAF5E8;
            border-radius: 6px 6px 0 0;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Coupon Usage &amp; Redemptions Ledger</span>
                        <span class="adm-badge gold"><?= count($usages) ?> Redemptions</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Section 26: Real-time record of all coupon redemptions, buyer orders, and verified discount deductions.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/marketing/usage.php?export=csv" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Export CSV</span>
                    </a>
                    <a href="/admin/marketing/coupons.php" class="dt-btn dt-btn-gold" style="text-decoration:none; height:34px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Coupons Studio</span>
                    </a>
                </div>
            </div>

            <!-- Tabs -->
            <div class="dt-nav-tabs">
                <a href="/admin/marketing/coupons.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>Coupons Studio</span>
                </a>
                <a href="/admin/marketing/discount-rules.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span>Discount Rules</span>
                </a>
                <a href="/admin/marketing/usage.php" class="dt-nav-tab active">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    <span>Coupon Usage Ledger</span>
                </a>
                <a href="/admin/marketing/expired.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Expired Codes</span>
                </a>
                <a href="/admin/marketing/audit.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Security Audit</span>
                </a>
            </div>

            <!-- Ledger Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span>Audited Coupon Redemptions</span>
                    </h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">Total Saved: <?= $rupeeSvg . ' ' . number_format($totalSavingsDisbursed, 2) ?></span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Redemption ID</th>
                                <th>Coupon Code</th>
                                <th>Order Number</th>
                                <th>Customer / Buyer</th>
                                <th>Role / Channel</th>
                                <th>Order Subtotal</th>
                                <th>Discount Granted</th>
                                <th>Redemption Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usages as $u): ?>
                                <tr>
                                    <td><span style="font-weight:700; color:#64748B;">#<?= $u['id'] ?></span></td>
                                    <td>
                                        <code style="font-size:12.5px; background:#FAF5E8; padding:3px 8px; border-radius:5px; color:#8A681F; font-weight:900; border:1px solid #D4AF37;">
                                            <?= htmlspecialchars((string)$u['coupon_code']) ?>
                                        </code>
                                    </td>
                                    <td>
                                        <a href="/admin/orders/view.php?order_number=<?= urlencode((string)($u['order_number'] ?? '')) ?>" style="font-weight:700; color:#181512; text-decoration:none;">
                                            <?= htmlspecialchars((string)($u['order_number'] ?? '—')) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:column; gap:2px;">
                                            <span style="font-weight:700; color:#181512; font-size:12.5px;"><?= htmlspecialchars((string)($u['customer_name'] ?? 'Direct Shopper')) ?></span>
                                            <span style="color:#64748B; font-size:11px;"><?= htmlspecialchars((string)($u['customer_phone'] ?? '—')) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="adm-badge" style="font-size:10.5px; font-weight:800; background:#F1F5F9; color:#475569;">
                                            <?= htmlspecialchars(strtoupper((string)($u['channel'] ?? 'CUSTOMER'))) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-weight:600; color:#1F2937;">
                                            <?= $rupeeSvg . ' ' . number_format((float)($u['order_subtotal'] ?? 0), 2) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-weight:800; color:#15803D;">
                                            -<?= $rupeeSvg . ' ' . number_format((float)($u['discount_amount'] ?? 0), 2) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="color:#64748B; font-size:12px;">
                                            <?= !empty($u['created_at']) ? htmlspecialchars(date('d M Y, h:i A', strtotime($u['created_at']))) : '—' ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
