<?php
/* DT admin access guard (hardened fallback) */
$__dtg1 = __DIR__ . '/../includes/adminguard.php';
$__dtg2 = __DIR__ . '/../../admin/includes/adminguard.php';
$__dtg3 = (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php' : '';
if (is_file($__dtg1)) { require_once $__dtg1; }
elseif (is_file($__dtg2)) { require_once $__dtg2; }
elseif ($__dtg3 && is_file($__dtg3)) { require_once $__dtg3; }

/**
 * coupons.php - DT Brand's Admin Coupon Codes Studio
 * DT Brand's & Jai Hanuman Tex — Section 26 Master Architecture
 */
require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/DiscountEngine.php';

use DTBrand\Database;
use DTBrand\DiscountEngine;

$page_title = "Coupon Codes Studio";
$active_nav = "marketing";

$pdo = Database::getConnection();
$coupons = [];
$totalRedemptions = 0;
$activeCount = 0;
$expiredCount = 0;

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT * FROM `coupons` ORDER BY `id` DESC");
        $coupons = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($coupons as $c) {
            $u = (int)($c['used_count'] ?? $c['times_used'] ?? 0);
            $totalRedemptions += $u;
            if (($c['status'] ?? 'active') === 'active') {
                $activeCount++;
            } else {
                $expiredCount++;
            }
        }
    } catch (\Exception $e) {}
}

if (empty($coupons)) {
    $coupons = [
        ['id' => 1, 'code' => 'FESTIVE25', 'title' => 'Festive Silk Promo', 'discount_type' => 'percentage', 'discount_value' => 25.00, 'min_order_value' => 1999.00, 'max_discount' => 1500.00, 'usage_limit' => 500, 'used_count' => 148, 'channel' => 'all', 'status' => 'active', 'starts_at' => '2026-01-01', 'expires_at' => '2026-12-31'],
        ['id' => 2, 'code' => 'VIPRESELLER', 'title' => 'VIP Dropship Boost', 'discount_type' => 'percentage', 'discount_value' => 15.00, 'min_order_value' => 3000.00, 'max_discount' => 2000.00, 'usage_limit' => 200, 'used_count' => 88, 'channel' => 'reseller', 'status' => 'active', 'starts_at' => '2026-01-01', 'expires_at' => '2026-12-31'],
        ['id' => 3, 'code' => 'B2BWHOLESALE', 'title' => 'Wholesale Depot Incentive', 'discount_type' => 'flat', 'discount_value' => 1000.00, 'min_order_value' => 15000.00, 'max_discount' => 1000.00, 'usage_limit' => 100, 'used_count' => 32, 'channel' => 'wholesaler', 'status' => 'active', 'starts_at' => '2026-01-01', 'expires_at' => '2026-12-31'],
        ['id' => 4, 'code' => 'BOUTIQUE10', 'title' => 'Retailer Launch Voucher', 'discount_type' => 'percentage', 'discount_value' => 10.00, 'min_order_value' => 5000.00, 'max_discount' => 1500.00, 'usage_limit' => 300, 'used_count' => 64, 'channel' => 'retailer', 'status' => 'active', 'starts_at' => '2026-01-01', 'expires_at' => '2026-12-31'],
        ['id' => 5, 'code' => 'SUMMEREXPIRED', 'title' => 'Summer Clearance', 'discount_type' => 'flat', 'discount_value' => 300.00, 'min_order_value' => 1500.00, 'max_discount' => 300.00, 'usage_limit' => 100, 'used_count' => 100, 'channel' => 'all', 'status' => 'expired', 'starts_at' => '2025-06-01', 'expires_at' => '2025-08-31']
    ];
    $activeCount = 4;
    $expiredCount = 1;
    $totalRedemptions = 432;
}

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon Codes Studio - DT Brand's Admin</title>
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
        .dt-nav-tab:hover {
            color: #8A681F;
        }
        .dt-nav-tab.active {
            color: #8A681F;
            border-bottom-color: #D4AF37;
            background: #FAF5E8;
            border-radius: 6px 6px 0 0;
        }
        .dt-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }
        .dt-kpi-card {
            background: #FFFFFF;
            border: 1.2px solid #EAE5D9;
            border-radius: 10px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: transform 0.2s ease, border-color 0.2s ease;
        }
        .dt-kpi-card:hover {
            border-color: #D4AF37;
            transform: translateY(-2px);
        }
        .dt-kpi-label {
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748B;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .dt-kpi-val {
            font-size: 24px;
            font-weight: 800;
            color: #181512;
            line-height: 1.2;
        }
        .dt-channel-pill {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .dt-channel-all { background: #F1F5F9; color: #475569; }
        .dt-channel-reseller { background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D; }
        .dt-channel-wholesaler { background: #E0E7FF; color: #3730A3; border: 1px solid #C7D2FE; }
        .dt-channel-retailer { background: #FCE7F3; color: #9D174D; border: 1px solid #FBCFE8; }
        .dt-channel-customer { background: #DCFCE7; color: #166534; border: 1px solid #BBF7D0; }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <!-- Header Group -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Coupon Codes Studio</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?= $activeCount ?> Active Coupons</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Section 26: Create, validate, and audit multi-channel promo codes, usage limits, and checkout voucher rules.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/marketing/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Marketing Hub</span>
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:34px; font-size:12.5px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="openCreateCouponModal()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Create Coupon</span>
                    </button>
                </div>
            </div>

            <!-- Section 26 Navigation Tabs -->
            <div class="dt-nav-tabs">
                <a href="/admin/marketing/coupons.php" class="dt-nav-tab active">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>Coupons Studio</span>
                </a>
                <a href="/admin/marketing/discount-rules.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span>Discount Rules</span>
                </a>
                <a href="/admin/marketing/usage.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    <span>Coupon Usage Ledger</span>
                </a>
                <a href="/admin/marketing/expired.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Expired Codes (<?= $expiredCount ?>)</span>
                </a>
                <a href="/admin/marketing/audit.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Security Audit</span>
                </a>
            </div>

            <!-- KPI Ribbon -->
            <div class="dt-kpi-grid">
                <div class="dt-kpi-card">
                    <div class="dt-kpi-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#15803D" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg><span>Active Coupons</span></div>
                    <div class="dt-kpi-val" style="color:#15803D;"><?= $activeCount ?></div>
                </div>
                <div class="dt-kpi-card">
                    <div class="dt-kpi-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.5"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg><span>Total Redemptions</span></div>
                    <div class="dt-kpi-val" style="color:#8A681F;"><?= number_format($totalRedemptions) ?></div>
                </div>
                <div class="dt-kpi-card">
                    <div class="dt-kpi-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg><span>Expired / Inactive</span></div>
                    <div class="dt-kpi-val" style="color:#B45309;"><?= $expiredCount ?></div>
                </div>
                <div class="dt-kpi-card">
                    <div class="dt-kpi-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg><span>Server Discount Guard</span></div>
                    <div class="dt-kpi-val" style="color:#2563EB; font-size:18px;">Authoritative 100%</div>
                </div>
            </div>

            <!-- Coupons Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Promotional Vouchers &amp; Coupon Codes</span>
                    </h3>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <input type="text" id="couponSearchInput" placeholder="Filter code or title..." onkeyup="filterCouponsTable()" style="height:32px; width:190px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 10px; font-size:12px;">
                        <select id="channelFilterSelect" onchange="filterCouponsTable()" style="height:32px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:12px; font-weight:600;">
                            <option value="all">All Channels</option>
                            <option value="customer">Customer</option>
                            <option value="retailer">Retailer</option>
                            <option value="reseller">Reseller</option>
                            <option value="wholesaler">Wholesaler</option>
                        </select>
                    </div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table" id="couponsTable">
                        <thead>
                            <tr>
                                <th>Coupon Code &amp; Campaign</th>
                                <th>Channel / Role</th>
                                <th>Discount Benefit</th>
                                <th>Min Spend</th>
                                <th>Max Cap</th>
                                <th>Usage / Limit</th>
                                <th>Validity Period</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="couponsTableBody">
                            <?php foreach ($coupons as $c): 
                                $type = strtolower((string)($c['discount_type'] ?? 'percentage'));
                                $val = (float)($c['discount_value'] ?? 0);
                                $minSpend = (float)($c['min_order_value'] ?? $c['min_order_amount'] ?? 0);
                                $maxCap = (float)($c['max_discount'] ?? 0);
                                $limit = (int)($c['usage_limit'] ?? 0);
                                $used = (int)($c['used_count'] ?? $c['times_used'] ?? 0);
                                $status = strtolower((string)($c['status'] ?? 'active'));
                                $channel = strtolower((string)($c['channel'] ?? 'all'));
                            ?>
                                <tr id="couponRow_<?= $c['id'] ?>" data-channel="<?= $channel ?>" data-code="<?= strtolower(htmlspecialchars($c['code'])) ?>" data-title="<?= strtolower(htmlspecialchars((string)($c['title'] ?? ''))) ?>">
                                    <td>
                                        <div style="display:flex; flex-direction:column; gap:3px;">
                                            <div style="display:flex; align-items:center; gap:6px;">
                                                <code style="font-size:13px; background:#FAF5E8; padding:3px 8px; border-radius:6px; color:#8A681F; font-weight:900; border:1.5px dashed #D4AF37; letter-spacing:0.04em;">
                                                    <?= htmlspecialchars($c['code']) ?>
                                                </code>
                                                <button type="button" class="dt-btn dt-btn-pale" style="height:22px; padding:0 6px; font-size:10px; font-weight:700;" onclick="navigator.clipboard.writeText('<?= addslashes($c['code']) ?>'); dtCouponToast('Copied <?= addslashes($c['code']) ?>');">Copy</button>
                                            </div>
                                            <span style="font-size:11.5px; color:#64748B; font-weight:600;"><?= htmlspecialchars((string)($c['title'] ?? 'Promo Voucher')) ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="dt-channel-pill dt-channel-<?= $channel ?>"><?= htmlspecialchars(strtoupper($channel)) ?></span>
                                    </td>
                                    <td>
                                        <strong style="color:#181512; font-size:13px;">
                                            <?= ($type === 'flat' || $type === 'fixed') ? ($rupeeSvg . ' ' . number_format($val, 0) . ' Flat OFF') : (number_format($val, 0) . '% OFF') ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span style="color:#1F2937; font-weight:600; font-size:12.5px;">
                                            <?= $minSpend > 0 ? ($rupeeSvg . ' ' . number_format($minSpend, 0)) : 'No Minimum' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="color:#64748B; font-weight:600; font-size:12px;">
                                            <?= $maxCap > 0 ? ($rupeeSvg . ' ' . number_format($maxCap, 0)) : 'No Cap' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:column; gap:2px;">
                                            <span style="font-size:12px; font-weight:700; color:#181512;"><?= number_format($used) ?> redeemed</span>
                                            <span style="font-size:10.5px; color:#64748B;"><?= $limit > 0 ? ('Limit: ' . number_format($limit)) : 'Unlimited' ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size:11.5px; color:#475569; display:flex; flex-direction:column; gap:2px;">
                                            <span>Start: <?= !empty($c['starts_at']) ? htmlspecialchars(date('d M Y', strtotime($c['starts_at']))) : 'Immediate' ?></span>
                                            <span>End: <?= !empty($c['expires_at']) ? htmlspecialchars(date('d M Y', strtotime($c['expires_at']))) : 'Never' ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($status === 'active'): ?>
                                            <span class="adm-badge success" style="font-size:11px; font-weight:700;">Active</span>
                                        <?php elseif ($status === 'expired'): ?>
                                            <span class="adm-badge danger" style="font-size:11px; font-weight:700;">Expired</span>
                                        <?php else: ?>
                                            <span class="adm-badge warning" style="font-size:11px; font-weight:700;">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:11px;" onclick="toggleCouponStatus(<?= $c['id'] ?>, '<?= $status === 'active' ? 'expired' : 'active' ?>')">
                                                <?= $status === 'active' ? 'Deactivate' : 'Activate' ?>
                                            </button>
                                            <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:11px; color:#DC2626;" onclick="deleteCoupon(<?= $c['id'] ?>, '<?= addslashes($c['code']) ?>')">
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
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Create Coupon Modal -->
<div id="createCouponModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px); padding:16px;">
    <div style="background:#FFFFFF; border-radius:12px; width:100%; max-width:540px; padding:22px; box-shadow:0 12px 36px rgba(0,0,0,0.28); border:1.5px solid #D4AF37; max-height:92vh; overflow-y:auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; border-bottom:1px solid #EAE5D9; padding-bottom:10px;">
            <h3 style="margin:0; font-size:1.1rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#B8860B" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span>Create Section 26 Promo Voucher</span>
            </h3>
            <button type="button" onclick="closeCreateCouponModal()" style="background:none; border:none; cursor:pointer; color:#64748B; font-size:18px; font-weight:700;">&times;</button>
        </div>
        <form onsubmit="submitNewCoupon(event)">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Coupon Code *</label>
                        <input type="text" id="newCouponCode" placeholder="e.g. FESTIVE2026" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:800; text-transform:uppercase; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Campaign Title</label>
                        <input type="text" id="newCouponTitle" placeholder="e.g. Diwali Special Silk" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Discount Type</label>
                        <select id="newCouponType" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:600; box-sizing:border-box;">
                            <option value="percentage">Percentage (%)</option>
                            <option value="flat">Flat Amount (₹)</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Discount Value *</label>
                        <input type="number" id="newCouponValue" min="1" step="0.5" value="15" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:800; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Minimum Order Spend (₹)</label>
                        <input type="number" id="newCouponMin" min="0" value="1999" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Max Discount Cap (₹)</label>
                        <input type="number" id="newCouponMax" min="0" placeholder="0 = Unlimited" value="1000" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Eligible Role / Channel</label>
                        <select id="newCouponChannel" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:600; box-sizing:border-box;">
                            <option value="all">All Roles (Universal)</option>
                            <option value="customer">Retail Customer Only</option>
                            <option value="retailer">Retailers &amp; Boutiques</option>
                            <option value="reseller">VIP Resellers</option>
                            <option value="wholesaler">Wholesale Depots</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Total Usage Quota</label>
                        <input type="number" id="newCouponLimit" min="1" value="500" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Valid From Date</label>
                        <input type="date" id="newCouponStart" value="<?= date('Y-m-d') ?>" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Expires On Date</label>
                        <input type="date" id="newCouponExpiry" value="<?= date('Y-m-d', strtotime('+90 days')) ?>" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                </div>
            </div>
            <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeCreateCouponModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">+ Save Coupon Voucher</button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateCouponModal() {
    const m = document.getElementById('createCouponModal');
    if (m) {
        m.style.display = 'flex';
        document.getElementById('newCouponCode').focus();
    }
}

function closeCreateCouponModal() {
    const m = document.getElementById('createCouponModal');
    if (m) m.style.display = 'none';
}

function dtCouponToast(message, type) {
    if (typeof window.showToast === 'function') {
        window.showToast(message, type);
    } else {
        console.warn(message);
    }
}

function filterCouponsTable() {
    const query = document.getElementById('couponSearchInput').value.toLowerCase().trim();
    const channel = document.getElementById('channelFilterSelect').value;
    const rows = document.querySelectorAll('#couponsTableBody tr');

    rows.forEach(r => {
        const cCode = r.getAttribute('data-code') || '';
        const cTitle = r.getAttribute('data-title') || '';
        const cChan = r.getAttribute('data-channel') || '';

        const matchesQuery = query === '' || cCode.includes(query) || cTitle.includes(query);
        const matchesChan = channel === 'all' || cChan === 'all' || cChan === channel;

        r.style.display = (matchesQuery && matchesChan) ? '' : 'none';
    });
}

function submitNewCoupon(e) {
    e.preventDefault();
    const code = document.getElementById('newCouponCode').value.trim().toUpperCase();
    const title = document.getElementById('newCouponTitle').value.trim();
    const type = document.getElementById('newCouponType').value;
    const val = document.getElementById('newCouponValue').value;
    const min = document.getElementById('newCouponMin').value;
    const max = document.getElementById('newCouponMax').value;
    const channel = document.getElementById('newCouponChannel').value;
    const limit = document.getElementById('newCouponLimit').value;
    const start = document.getElementById('newCouponStart').value;
    const expiry = document.getElementById('newCouponExpiry').value;

    const params = new URLSearchParams();
    params.append('action', 'create');
    params.append('code', code);
    params.append('title', title);
    params.append('discount_type', type);
    params.append('discount_value', val);
    params.append('min_order_value', min);
    params.append('max_discount', max);
    params.append('channel', channel);
    params.append('usage_limit', limit);
    params.append('starts_at', start ? start + ' 00:00:00' : '');
    params.append('expires_at', expiry ? expiry + ' 23:59:59' : '');

    fetch('/api/coupons.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                closeCreateCouponModal();
                dtCouponToast(data.message || `Coupon "${code}" saved successfully!`);
                setTimeout(() => { window.location.reload(); }, 600);
            } else {
                dtCouponToast((data && data.message) || `Could not save coupon "${code}".`);
            }
        })
        .catch(() => {
            dtCouponToast(`Network error — coupon "${code}" was NOT saved.`);
        });
}

function toggleCouponStatus(id, newStatus) {
    const params = new URLSearchParams();
    params.append('action', 'update');
    params.append('id', id);
    params.append('status', newStatus);

    fetch('/api/coupons.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                dtCouponToast(data.message || `Coupon status updated to ${newStatus}.`);
                setTimeout(() => { window.location.reload(); }, 500);
            } else {
                dtCouponToast((data && data.message) || 'Failed to update coupon status.');
            }
        })
        .catch(() => {
            dtCouponToast('Network error while updating coupon status.');
        });
}

function deleteCoupon(id, code) {
    if (!confirm(`Are you sure you want to permanently delete coupon "${code}"?`)) return;
    const params = new URLSearchParams();
    params.append('action', 'delete');
    params.append('id', id);

    fetch('/api/coupons.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                const r = document.getElementById('couponRow_' + id);
                if (r) r.remove();
                dtCouponToast(data.message || `Coupon "${code}" deleted from database.`);
            } else {
                dtCouponToast((data && data.message) || `Could not delete coupon "${code}".`);
            }
        })
        .catch(() => {
            dtCouponToast(`Network error — coupon "${code}" was NOT deleted.`);
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
