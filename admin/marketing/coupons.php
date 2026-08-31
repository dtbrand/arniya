<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * coupons.php - DT Brand's Admin Coupon Codes Studio
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Coupon Codes Studio";
$active_nav = "marketing";

$pdo = Database::getConnection();
$coupons = [];
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT * FROM `coupons` ORDER BY `id` DESC");
        $coupons = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Exception $e) {}
}

if (empty($coupons)) {
    $coupons = [
        ['id' => 1, 'code' => 'FESTIVE2026', 'discount_type' => 'percentage', 'discount_value' => 15.00, 'min_order_value' => 2999.00, 'status' => 'active', 'times_used' => 48],
        ['id' => 2, 'code' => 'B2BWHOLESALE', 'discount_type' => 'flat', 'discount_value' => 1000.00, 'min_order_value' => 15000.00, 'status' => 'active', 'times_used' => 22],
        ['id' => 3, 'code' => 'RETAIL5', 'discount_type' => 'percentage', 'discount_value' => 5.00, 'min_order_value' => 999.00, 'status' => 'active', 'times_used' => 94]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coupon Codes Studio - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Coupon Codes Studio</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?= count($coupons) ?> Active Promo Codes</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Create and manage promotional discount vouchers with minimum spend rules and automated checkout validation.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/marketing/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Marketing Hub</a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="openCreateCouponModal()">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Create New Coupon</span>
                    </button>
                </div>
            </div>

            <!-- Coupons Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>🎟️ Active Checkout Promo Codes</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Instant Checkout Redemption</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Coupon Code</th>
                                <th>Discount Benefit</th>
                                <th>Minimum Order Spend</th>
                                <th>Times Redeemed</th>
                                <th>Status</th>
                                <th style="text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="couponsTableBody">
                            <?php foreach ($coupons as $c): ?>
                                <tr id="couponRow_<?= $c['id'] ?>">
                                    <td>
                                        <code style="font-size:13px; background:#FAF5E8; padding:3px 8px; border-radius:6px; color:#8A681F; font-weight:900; border:1.5px dashed #D4AF37; letter-spacing:0.04em;">
                                            <?= htmlspecialchars($c['code']) ?>
                                        </code>
                                    </td>
                                    <td>
                                        <strong style="color:#181512; font-size:13px;">
                                            <?= $c['discount_type'] === 'percentage' ? ((float)$c['discount_value'] . '% OFF') : ('₹' . number_format((float)$c['discount_value']) . ' Flat OFF') ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span style="color:#64748B; font-weight:600;">
                                            <?php $minSpend = (float)($c['min_order_value'] ?? $c['min_order_amount'] ?? 0); ?>
                                            <?= $minSpend > 0 ? ('₹' . number_format($minSpend)) : 'No Minimum' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="adm-badge" style="background:#FAF8F4; color:#78716C; font-weight:700;"><?= (int)($c['times_used'] ?? 0) ?> orders</span>
                                    </td>
                                    <td><span class="adm-badge success">Active</span></td>
                                    <td style="text-align:right;">
                                        <button type="button" class="dt-btn dt-btn-pale" style="height:28px; padding:0 10px; font-size:11.5px; color:#DC2626;" onclick="deleteCoupon(<?= $c['id'] ?>, '<?= addslashes($c['code']) ?>')">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Create Coupon Modal -->
<div id="createCouponModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:440px; padding:22px; box-shadow:0 10px 30px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <h3 style="margin:0 0 14px 0; font-size:1.1rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
            <span>🎟️ Create New Promo Code</span>
        </h3>
        <form onsubmit="submitNewCoupon(event)">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Coupon Code *</label>
                    <input type="text" id="newCouponCode" placeholder="e.g. SILK20" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; text-transform:uppercase; box-sizing:border-box;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Discount Type</label>
                        <select id="newCouponType" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option value="percentage">Percentage (%)</option>
                            <option value="flat">Flat Amount (₹)</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Discount Value *</label>
                        <input type="number" id="newCouponValue" min="1" value="10" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:700; box-sizing:border-box;">
                    </div>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Minimum Order Amount (₹)</label>
                    <input type="number" id="newCouponMin" min="0" value="1499" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
            </div>
            <div style="margin-top:18px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeCreateCouponModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">+ Save Coupon</button>
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

/* Shared toast helper so a failure is never reported as a save. */
function dtCouponToast(message) {
    if (typeof window.showToast === 'function') {
        window.showToast(message);
    } else {
        alert(message);
    }
}

function submitNewCoupon(e) {
    e.preventDefault();
    const code = document.getElementById('newCouponCode').value.trim().toUpperCase();
    const type = document.getElementById('newCouponType').value;
    const val = document.getElementById('newCouponValue').value;
    const min = document.getElementById('newCouponMin').value;

    const params = new URLSearchParams();
    params.append('action', 'create');
    params.append('code', code);
    params.append('discount_type', type);
    params.append('discount_value', val);
    params.append('min_order_value', min);

    /* Only reload — and only claim the coupon is live — when the server says it
       saved. Both branches used to toast "saved in MySQL database!" regardless,
       including from .catch(), so a rejected write looked identical to a real
       one and the reload quietly showed the coupon missing. */
    fetch('/api/coupons.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                closeCreateCouponModal();
                dtCouponToast(data.message || `✨ Coupon "${code}" saved in MySQL database!`);
                setTimeout(() => { window.location.reload(); }, 600);
            } else {
                dtCouponToast('⚠ ' + ((data && data.message) || `Could not save coupon "${code}".`));
            }
        })
        .catch(() => {
            dtCouponToast(`⚠ Network error — coupon "${code}" was NOT saved. Please try again.`);
        });
}

function deleteCoupon(id, code) {
    if (!confirm(`Are you sure you want to delete coupon "${code}"?`)) return;
    const params = new URLSearchParams();
    params.append('action', 'delete');
    params.append('id', id);

    /* The row is removed only after the server confirms the delete. It used to be
       removed in .catch() too, so a coupon that was still active vanished from
       the screen and stayed redeemable at checkout. */
    fetch('/api/coupons.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (data && data.success) {
                const r = document.getElementById('couponRow_' + id);
                if (r) r.remove();
                dtCouponToast(data.message || `✓ Coupon "${code}" deleted from database.`);
            } else {
                dtCouponToast('⚠ ' + ((data && data.message) || `Could not delete coupon "${code}".`));
            }
        })
        .catch(() => {
            dtCouponToast(`⚠ Network error — coupon "${code}" was NOT deleted.`);
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
