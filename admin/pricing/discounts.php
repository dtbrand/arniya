<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * discounts.php — Coupon / Promo Code Manager
 * DT Brand's & Jai Hanuman Tex
 *
 * Was a hardcoded "FESTIVE15" row and an "+ Add Promo Code" button that only
 * toasted. Coupons are a real table (`coupons`) with a real validation path
 * (DiscountEngine reads it; api/coupons.php and OrderManager both honour it),
 * so this page lists the live rows and add/toggle run through
 * api/coupons.php — the same endpoint the storefront coupon preview uses.
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Volume Incentives & Promo Codes";
$active_nav = "pricing";

$coupons = [];
$pdoDc = Database::getConnection();
if ($pdoDc !== null && !Database::isMockMode()) {
    try {
        $coupons = Database::query('SELECT * FROM coupons ORDER BY id ASC');
    } catch (\Throwable $e) {
        $coupons = [];
    }
}
$amSuper = strtolower((string)($_SESSION['admin_user']['role'] ?? '')) === 'super_admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volume Incentives &amp; Promo Codes - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
    .dt-u-input { width:100%; height:34px; padding:0 10px; font-size:12.5px; color:#181512; background:#fff; border:1px solid #c3c4c7; border-radius:5px; box-sizing:border-box; outline:none; }
    .dt-u-input:focus { border-color:#D4AF37 !important; box-shadow:0 0 0 3px rgba(212,175,55,0.18); }
    .dt-c-modal { display:none; position:fixed; inset:0; background:rgba(15,23,42,0.75); z-index:9999999; align-items:center; justify-content:center; backdrop-filter:blur(4px); }
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
                        <span>Volume Incentives &amp; Promo Codes</span>
                        <span class="adm-badge gold"><?= count($coupons) ?> Codes</span>
                    </h1>
                    <p class="adm-page-subtitle">Live coupon rows — validated at checkout by DiscountEngine against the coupons table.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/pricing/" class="adm-btn-secondary">← Pricing Suite</a>
                    <?php if ($amSuper): ?>
                    <button class="adm-btn-primary" onclick="openCouponModal()">+ Add Promo Code</button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="adm-table-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Discount</th>
                                <th>Min Spend</th>
                                <th>Max Discount</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($coupons)): ?>
                                <tr><td colspan="6" style="padding:22px; text-align:center; color:#64748B;">No coupons on file. Add one to run a promotion.</td></tr>
                            <?php else: ?>
                                <?php foreach ($coupons as $cp): $cid = (int)$cp['id']; ?>
                                <tr id="coupon-row-<?= $cid ?>">
                                    <td><code style="background:#FAF5E8; padding:3px 8px; border-radius:6px; color:#8A681F; font-weight:800;"><?= htmlspecialchars((string)$cp['code']) ?></code></td>
                                    <td>
                                        <?= strtolower((string)($cp['discount_type'] ?? '')) === 'flat'
                                            ? '₹' . number_format((float)$cp['discount_value']) . ' off'
                                            : number_format((float)$cp['discount_value'], 0) . '% off' ?>
                                    </td>
                                    <td>₹<?= number_format((float)($cp['min_order_value'] ?? 0)) ?></td>
                                    <td><?= (float)($cp['max_discount'] ?? 0) > 0 ? ('₹' . number_format((float)$cp['max_discount'])) : '—' ?></td>
                                    <td><span class="adm-badge <?= ($cp['status'] ?? '') === 'active' ? 'success' : '' ?>"><?= htmlspecialchars(ucfirst((string)($cp['status'] ?? 'active'))) ?></span></td>
                                    <td style="text-align:right;">
                                        <?php if ($amSuper): ?>
                                        <button class="adm-btn-secondary adm-btn-sm" onclick="toggleCoupon(<?= $cid ?>, '<?= htmlspecialchars((string)($cp['status'] ?? 'active')) ?>', this)">
                                            <?= (($cp['status'] ?? '') === 'active') ? 'Deactivate' : 'Activate' ?>
                                        </button>
                                        <?php else: ?>
                                        <span style="font-size:11px; color:#94A3B8;">Super Admin only</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Add coupon modal -->
<div id="dtCouponModal" class="dt-c-modal">
    <div style="background:#fff; width:95%; max-width:460px; border-radius:10px; border:2px solid #D4AF37; overflow:hidden;">
        <div style="background:linear-gradient(135deg,#261C0E,#3A2C12 45%,#18120A); padding:14px 18px; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#fff;">Add Promo Code</h3>
        </div>
        <div style="padding:18px 20px; display:flex; flex-direction:column; gap:12px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; margin-bottom:4px;">Code *</label>
                <input type="text" id="cpCode" class="dt-u-input" placeholder="e.g. FESTIVE25" style="text-transform:uppercase;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; margin-bottom:4px;">Type</label>
                    <select id="cpType" class="dt-u-input">
                        <option value="percentage">Percentage (%)</option>
                        <option value="flat">Flat ₹</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; margin-bottom:4px;">Value *</label>
                    <input type="number" min="1" id="cpValue" class="dt-u-input">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; margin-bottom:4px;">Min Order ₹</label>
                    <input type="number" min="0" id="cpMin" class="dt-u-input" value="0">
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; margin-bottom:4px;">Max Discount ₹ (0 = none)</label>
                    <input type="number" min="0" id="cpMax" class="dt-u-input" value="0">
                </div>
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:8px;">
            <button class="adm-btn-secondary" onclick="closeCouponModal()">Cancel</button>
            <button class="adm-btn-primary" onclick="submitCoupon()">Save Coupon</button>
        </div>
    </div>
</div>

<script>
function openCouponModal() { document.getElementById('dtCouponModal').style.display = 'flex'; }
function closeCouponModal() { document.getElementById('dtCouponModal').style.display = 'none'; }
function showToastSafe(m) { if (typeof window.showToast === 'function') window.showToast(m); else alert(m); }

function submitCoupon() {
    var code = document.getElementById('cpCode').value.trim().toUpperCase();
    var value = parseFloat(document.getElementById('cpValue').value);
    if (!code || !(value > 0)) { showToastSafe('⚠️ Code and a positive value are required'); return; }
    var params = new URLSearchParams();
    params.append('action', 'create');
    params.append('code', code);
    params.append('discount_type', document.getElementById('cpType').value);
    params.append('discount_value', value);
    params.append('min_order_value', document.getElementById('cpMin').value || 0);
    params.append('max_discount', document.getElementById('cpMax').value || 0);
    fetch('/api/coupons.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d && d.success === false) { showToastSafe('⚠️ ' + (d.message || 'Save failed')); return; }
            window.location.reload();
        })
        .catch(function () { showToastSafe('⚠️ Could not reach the server'); });
}

function toggleCoupon(id, current, btn) {
    var next = current === 'active' ? 'expired' : 'active';
    var params = new URLSearchParams();
    params.append('action', 'update');
    params.append('id', id);
    params.append('status', next);
    fetch('/api/coupons.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d && d.success === false) { showToastSafe('⚠️ ' + (d.message || 'Update failed')); return; }
            window.location.reload();
        })
        .catch(function () { showToastSafe('⚠️ Could not reach the server'); });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>