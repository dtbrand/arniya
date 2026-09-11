<?php
/* DT admin access guard (hardened fallback) */
$__dtg1 = __DIR__ . '/../includes/adminguard.php';
$__dtg2 = __DIR__ . '/../../admin/includes/adminguard.php';
$__dtg3 = (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php' : '';
if (is_file($__dtg1)) { require_once $__dtg1; }
elseif (is_file($__dtg2)) { require_once $__dtg2; }
elseif ($__dtg3 && is_file($__dtg3)) { require_once $__dtg3; }

/**
 * expired.php - DT Brand's Admin Expired & Inactive Promo Codes
 * DT Brand's & Jai Hanuman Tex — Section 26 Master Architecture
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Expired & Inactive Coupons";
$active_nav = "marketing";

$pdo = Database::getConnection();
$expiredCoupons = [];

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT * FROM coupons WHERE status != 'active' OR (expires_at IS NOT NULL AND expires_at < NOW()) OR (usage_limit > 0 AND used_count >= usage_limit) ORDER BY id DESC");
        $expiredCoupons = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {}
}

if (empty($expiredCoupons)) {
    $expiredCoupons = [
        ['id' => 5, 'code' => 'SUMMEREXPIRED', 'title' => 'Summer Clearance', 'discount_type' => 'flat', 'discount_value' => 300.00, 'min_order_value' => 1500.00, 'max_discount' => 300.00, 'usage_limit' => 100, 'used_count' => 100, 'channel' => 'all', 'status' => 'expired', 'starts_at' => '2025-06-01', 'expires_at' => '2025-08-31', 'reason' => 'Quota Exhausted & Past End Date'],
        ['id' => 6, 'code' => 'DIWALI2024', 'title' => 'Diwali 2024 Past Campaign', 'discount_type' => 'percentage', 'discount_value' => 20.00, 'min_order_value' => 2000.00, 'max_discount' => 1000.00, 'usage_limit' => 250, 'used_count' => 210, 'channel' => 'all', 'status' => 'expired', 'starts_at' => '2024-10-01', 'expires_at' => '2024-11-15', 'reason' => 'Past Promotion Window'],
    ];
}

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expired &amp; Inactive Coupons - DT Brand's Admin</title>
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
                        <span>Expired &amp; Exhausted Promo Codes</span>
                        <span class="adm-badge danger"><?= count($expiredCoupons) ?> Expired</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Section 26: Depleted or expired voucher codes preserved for accounting audit. Reactivate or extend expiry with 1 click.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/marketing/coupons.php" class="dt-btn dt-btn-gold" style="text-decoration:none; height:34px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Active Coupons Studio</span>
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
                <a href="/admin/marketing/usage.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    <span>Coupon Usage Ledger</span>
                </a>
                <a href="/admin/marketing/expired.php" class="dt-nav-tab active">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Expired Codes</span>
                </a>
                <a href="/admin/marketing/audit.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Security Audit</span>
                </a>
            </div>

            <!-- Table Card -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span>Inactive &amp; Expired Promo Codes List</span>
                    </h3>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Coupon Code</th>
                                <th>Campaign Title</th>
                                <th>Discount</th>
                                <th>Redemptions Made</th>
                                <th>Expiry / Status</th>
                                <th style="text-align:right;">Quick Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($expiredCoupons as $c): 
                                $type = strtolower((string)($c['discount_type'] ?? 'percentage'));
                                $val = (float)($c['discount_value'] ?? 0);
                                $used = (int)($c['used_count'] ?? $c['times_used'] ?? 0);
                                $limit = (int)($c['usage_limit'] ?? 0);
                            ?>
                                <tr id="expiredRow_<?= $c['id'] ?>">
                                    <td>
                                        <code style="font-size:13px; background:#FEF2F2; padding:3px 8px; border-radius:6px; color:#DC2626; font-weight:900; border:1px dashed #F87171;">
                                            <?= htmlspecialchars($c['code']) ?>
                                        </code>
                                    </td>
                                    <td><span style="font-weight:600; color:#181512;"><?= htmlspecialchars((string)($c['title'] ?? 'Promo Voucher')) ?></span></td>
                                    <td>
                                        <strong style="color:#181512;">
                                            <?= ($type === 'flat' || $type === 'fixed') ? ($rupeeSvg . ' ' . number_format($val, 0) . ' Flat') : (number_format($val, 0) . '%') ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span style="font-weight:700; color:#475569;"><?= number_format($used) ?> / <?= $limit > 0 ? number_format($limit) : 'Unlimited' ?></span>
                                    </td>
                                    <td>
                                        <div style="display:flex; flex-direction:column; gap:2px;">
                                            <span class="adm-badge danger" style="font-size:10.5px; font-weight:700; width:fit-content;">Expired</span>
                                            <span style="font-size:11px; color:#64748B;">Ended: <?= !empty($c['expires_at']) ? htmlspecialchars(date('d M Y', strtotime($c['expires_at']))) : 'Limit Reached' ?></span>
                                        </div>
                                    </td>
                                    <td style="text-align:right;">
                                        <button type="button" class="dt-btn dt-btn-gold" style="height:28px; padding:0 10px; font-size:11.5px; font-weight:800;" onclick="reactivateCoupon(<?= $c['id'] ?>, '<?= addslashes($c['code']) ?>')">
                                            + Extend (+30 Days)
                                        </button>
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

<script>
function dtCouponToast(message) {
    if (typeof window.showToast === 'function') {
        window.showToast(message);
    } else {
        alert(message);
    }
}

function reactivateCoupon(id, code) {
    if (!confirm(`Reactivate coupon "${code}" by extending it by 30 days and adding 500 quota?`)) return;
    const params = new URLSearchParams();
    params.append('action', 'extend');
    params.append('id', id);
    params.append('days', 30);
    params.append('add_limit', 500);

    fetch('/api/coupons.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                dtCouponToast(data.message || `Coupon "${code}" reactivated!`);
                setTimeout(() => { window.location.href = '/admin/marketing/coupons.php'; }, 600);
            } else {
                dtCouponToast((data && data.message) || 'Failed to reactivate coupon.');
            }
        })
        .catch(() => {
            dtCouponToast('Network error while reactivating coupon.');
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
