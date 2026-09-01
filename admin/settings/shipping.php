<?php
require_once __DIR__ . '/_shared.php';
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * shipping.php — Shipping & Fulfilment Settings
 * DT Brand's & Jai Hanuman Tex
 *
 * Was one readonly fake input ("Ring Road Textile Market, Surat - 395002")
 * and a toast-only Save. Now reads/writes the `settings` table through
 * api/settings.php — these keys back the shipping quote logic (free-shipping
 * threshold, flat rates per channel) that api/shipping.php consults.
 */
require_once __DIR__ . '/_shared.php';

$page_title = "Shipping & Fulfilment Settings";
$active_nav = "settings";
$dtKeys = ['warehouse_address', 'warehouse_city', 'warehouse_state', 'warehouse_pincode',
           'free_shipping_threshold', 'flat_shipping_retail', 'flat_shipping_trade',
           'default_courier'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping &amp; Fulfilment Settings - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php
require_once __DIR__ . '/_shared.php'; echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php
require_once __DIR__ . '/_shared.php'; include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php
require_once __DIR__ . '/_shared.php'; include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Shipping &amp; Fulfilment Settings</span>
                        <span class="adm-badge gold">Logistics</span>
                    </h1>
                    <p class="adm-page-subtitle">Dispatch origin and shipping charges applied at checkout.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/settings/" class="adm-btn-secondary">← Back to Settings Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Dispatch Origin</span></h3>
                    <?php
require_once __DIR__ . '/_shared.php'; echo dt_set_save_button(); ?>
                </div>
                <div class="adm-form-grid">
                    <div class="adm-form-group full" style="grid-column:1/-1;">
                        <label class="adm-form-label">Warehouse Depot Address *</label>
                        <input type="text" class="adm-form-input" id="dtSet-warehouse_address" required value="<?= htmlspecialchars(dt_set('warehouse_address', 'Ring Road Textile Market, Surat')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">City</label>
                        <input type="text" class="adm-form-input" id="dtSet-warehouse_city" value="<?= htmlspecialchars(dt_set('warehouse_city', 'Surat')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">State</label>
                        <input type="text" class="adm-form-input" id="dtSet-warehouse_state" value="<?= htmlspecialchars(dt_set('warehouse_state', 'Gujarat')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">PIN Code</label>
                        <input type="text" class="adm-form-input" id="dtSet-warehouse_pincode" maxlength="6" value="<?= htmlspecialchars(dt_set('warehouse_pincode', '395002')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Default Courier (printed on dispatch notices)</label>
                        <input type="text" class="adm-form-input" id="dtSet-default_courier" value="<?= htmlspecialchars(dt_set('default_courier', 'Delhivery Express')) ?>">
                    </div>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Shipping Charges</span></h3>
                    <span style="font-size:11px; color:#94A3B8;">Applied by /api/shipping.php</span>
                </div>
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Free Shipping Above (₹, 0 = never)</label>
                        <input type="number" min="0" class="adm-form-input" id="dtSet-free_shipping_threshold" value="<?= htmlspecialchars(dt_set('free_shipping_threshold', '0')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Flat Rate — Retail (₹)</label>
                        <input type="number" min="0" class="adm-form-input" id="dtSet-flat_shipping_retail" value="<?= htmlspecialchars(dt_set('flat_shipping_retail', '150')) ?>">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Flat Rate — Trade / B2B (₹)</label>
                        <input type="number" min="0" class="adm-form-input" id="dtSet-flat_shipping_trade" value="<?= htmlspecialchars(dt_set('flat_shipping_trade', '250')) ?>">
                    </div>
                </div>
            </div>

        </main>
        <?php
require_once __DIR__ . '/_shared.php'; include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<?php
require_once __DIR__ . '/_shared.php'; echo dt_set_save_script($dtKeys); ?>
<script src="/admin/assets/js/admin.js?v=<?php
require_once __DIR__ . '/_shared.php'; echo time(); ?>"></script>
</body>
</html>