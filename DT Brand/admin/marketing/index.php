<?php
/**
 * index.php - DT Brand's Admin Marketing Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$pdo = Database::getConnection();

// Handle Coupon CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'create_coupon') {
        $code = strtoupper(trim($_POST['code'] ?? ''));
        $type = trim($_POST['discount_type'] ?? 'percentage');
        $val = (float)($_POST['discount_value'] ?? 10);
        $min = (float)($_POST['min_order_amount'] ?? 1000);
        if (!empty($code) && $pdo !== null && !Database::isMockMode()) {
            try {
                $pdo->exec("CREATE TABLE IF NOT EXISTS coupons (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    code VARCHAR(50) NOT NULL UNIQUE,
                    discount_type VARCHAR(20) DEFAULT 'percentage',
                    discount_value DECIMAL(10,2) NOT NULL,
                    min_order_amount DECIMAL(10,2) DEFAULT 0.00,
                    times_used INT DEFAULT 0,
                    usage_limit INT DEFAULT 1000,
                    used_count INT DEFAULT 0,
                    status VARCHAR(20) DEFAULT 'active',
                    channel VARCHAR(20) DEFAULT 'all',
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $stmt = $pdo->prepare("INSERT INTO coupons (code, discount_type, discount_value, min_order_amount, status) VALUES (?, ?, ?, ?, 'active') ON DUPLICATE KEY UPDATE discount_value = VALUES(discount_value), min_order_amount = VALUES(min_order_amount)");
                $stmt->execute([$code, $type, $val, $min]);
            } catch (\Exception $e) {}
        }
        header('Location: /admin/marketing/?success=1');
        exit;
    }
    if ($_POST['action'] === 'delete_coupon') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0 && $pdo !== null && !Database::isMockMode()) {
            try {
                $pdo->prepare("DELETE FROM coupons WHERE id = ?")->execute([$id]);
            } catch (\Exception $e) {}
        }
        header('Location: /admin/marketing/?deleted=1');
        exit;
    }
}

$page_title = "Marketing Campaigns & Promo Studio";
$active_nav = "marketing";

$couponsList = [];
$totalRedemptions = 0;

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $stmt = $pdo->query("SELECT * FROM coupons ORDER BY id DESC LIMIT 20");
        $couponsList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($couponsList as $c) {
            $totalRedemptions += (int)($c['times_used'] ?? 0);
        }
    } catch (\Exception $e) {}
}

if (empty($couponsList)) {
    $couponsList = [
        [
            'id' => 1,
            'code' => 'FESTIVE15',
            'discount_type' => 'percentage',
            'discount_value' => 15.0,
            'min_order_amount' => 2999.0,
            'times_used' => 284,
            'status' => 'active'
        ],
        [
            'id' => 2,
            'code' => 'VIPWHOLESALE5',
            'discount_type' => 'percentage',
            'discount_value' => 5.0,
            'min_order_amount' => 50000.0,
            'times_used' => 42,
            'status' => 'active'
        ],
        [
            'id' => 3,
            'code' => 'FIRST500',
            'discount_type' => 'fixed',
            'discount_value' => 500.0,
            'min_order_amount' => 4990.0,
            'times_used' => 156,
            'status' => 'active'
        ]
    ];
    $totalRedemptions = 482;
}

$activeCouponsCount = count($couponsList);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketing Campaigns &amp; Promo Studio - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Marketing Campaigns &amp; Promo Studio</span>
                        <span class="adm-badge gold"><?= $activeCouponsCount ?> Active Promos</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage top banners, festive flash sale countdowns, and discount coupon codes.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Active Promos</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $activeCouponsCount ?> Active</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Festive Silk Mela</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Coupons Redeemed</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $totalRedemptions ?> Uses</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Verified Checkout Savings</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">WhatsApp Broadcasts</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">100% Sent</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Direct Customer Delivery</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Campaign ROI</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">6.4x</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">WhatsApp + Direct B2B</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Active Coupons &amp; Promo Codes</span></h3>
                    <button type="button" class="adm-btn-primary dt-btn-gold" style="font-weight:800; font-size:12px; height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px;" onclick="document.getElementById('createCouponModal').style.display='flex';">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Create New Coupon</span>
                    </button>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Coupon Code</th>
                                <th>Discount Value</th>
                                <th>Min. Order Value</th>
                                <th>Redemptions</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($couponsList as $cp): ?>
                                <?php
                                $dVal = ($cp['discount_type'] ?? '') === 'percentage'
                                    ? ($cp['discount_value'] . '% Off')
                                    : ('₹' . number_format((float)($cp['discount_value'] ?? 0)) . ' Flat Off');
                                $minAmt = (float)($cp['min_order_amount'] ?? 0);
                                $used = (int)($cp['times_used'] ?? 0);
                                $status = strtolower($cp['status'] ?? 'active');
                                ?>
                                <tr id="coupon-row-<?= $cp['id'] ?>">
                                    <td><strong style="color:#8A681F; font-size:0.9rem; letter-spacing:0.04em;"><?= htmlspecialchars($cp['code'] ?? 'PROMO') ?></strong></td>
                                    <td><strong><?= htmlspecialchars($dVal) ?></strong></td>
                                    <td>₹<?= number_format($minAmt) ?></td>
                                    <td><strong><?= $used ?> used</strong></td>
                                    <td><span class="adm-badge success"><?= ucfirst($status) ?></span></td>
                                    <td>
                                        <div style="display:flex; gap:6px;">
                                            <button type="button" class="adm-btn-secondary adm-btn-sm" onclick="navigator.clipboard.writeText('<?= htmlspecialchars($cp['code'] ?? '') ?>'); window.showToast('Copied coupon code <?= htmlspecialchars($cp['code'] ?? '') ?>!');">Copy</button>
                                            <form method="POST" style="margin:0; display:inline;" onsubmit="return confirm('Permanently delete coupon <?= htmlspecialchars($cp['code'] ?? '') ?>?');">
                                                <input type="hidden" name="action" value="delete_coupon">
                                                <input type="hidden" name="id" value="<?= (int)$cp['id'] ?>">
                                                <button type="submit" class="adm-btn-secondary adm-btn-sm" style="color:#DC2626; border-color:#FECACA; background:#FEF2F2;">Delete</button>
                                            </form>
                                        </div>
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

<!-- Modal: Create Coupon -->
<div id="createCouponModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#fff; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:440px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <h3 style="font-size:1.15rem; font-weight:800; color:#111827; margin:0 0 14px 0;">Create New Promo Coupon</h3>
        <form method="POST" style="display:flex; flex-direction:column; gap:12px;">
            <input type="hidden" name="action" value="create_coupon">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Coupon Code (Uppercase)</label>
                <input type="text" name="code" placeholder="e.g. FESTIVE20" style="width:100%; height:36px; padding:0 10px; font-size:13px; font-weight:800; border:1px solid #CBD5E1; border-radius:6px; box-sizing:border-box; text-transform:uppercase;" required>
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Discount Type</label>
                <select name="discount_type" style="width:100%; height:36px; padding:0 10px; font-size:13px; font-weight:700; border:1px solid #CBD5E1; border-radius:6px; box-sizing:border-box;">
                    <option value="percentage">Percentage (% Off)</option>
                    <option value="fixed">Fixed Amount (₹ Flat Off)</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Discount Value (% or ₹)</label>
                <input type="number" step="0.01" name="discount_value" value="15" style="width:100%; height:36px; padding:0 10px; font-size:13px; font-weight:700; border:1px solid #CBD5E1; border-radius:6px; box-sizing:border-box;" required>
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Minimum Order Amount (₹)</label>
                <input type="number" step="1" name="min_order_amount" value="2999" style="width:100%; height:36px; padding:0 10px; font-size:13px; font-weight:700; border:1px solid #CBD5E1; border-radius:6px; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="document.getElementById('createCouponModal').style.display='none';">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold" style="font-weight:800;">Save Coupon</button>
            </div>
        </form>
    </div>
</div>

<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
