<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * discounts.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Discounts & Seasonal Rebates
 */
$page_title = "Wholesale Discounts & Rebates";
$active_nav = "wholesalers";
$active_subnav = "pricing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Discounts - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-wholesale-container">
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">
                            <span>Wholesale Discounts &amp; Seasonal Rebates</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage pre-booking promotions, instant payment cash discounts, and volume kickbacks.</p>
                    </div>
                </div>

                <?php include __DIR__ . '/components/wholesale-discount.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══ CREATE DISCOUNT MODAL ══ -->
<div id="dtCreateDiscountModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:460px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <h3 style="font-size:1.1rem; font-weight:900; color:#181512; margin:0 0 10px 0;">Create Wholesale Discount Rule</h3>
        <form onsubmit="submitCreateDiscount(event)" style="display:flex; flex-direction:column; gap:12px;">
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Promotion / Campaign Name</label>
                <input type="text" id="newDiscountName" placeholder="e.g. Navratri 2026 Saree Booster" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; padding:0 10px; box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Discount Type</label>
                <select class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                    <option>Percentage Off Base Wholesale</option>
                    <option>Volume Kickback Rebate</option>
                    <option>Instant Payment Cash Discount</option>
                </select>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Discount Value (%)</label>
                <input type="number" step="0.5" value="5.0" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.85rem; font-weight:800; padding:0 10px; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:6px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtCreateDiscountModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Create Rule</button>
            </div>
        </form>
    </div>
</div>

<script src="/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-discounts.js?v=<?php echo time(); ?>"></script>
</body>
</html>
