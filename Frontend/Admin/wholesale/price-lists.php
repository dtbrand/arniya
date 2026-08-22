<?php
/**
 * price-lists.php — DT Brand's & Jai Hanuman Tex
 * Custom Catalog Price Lists Manager
 */
$page_title = "Wholesale Price Lists";
$active_nav = "wholesalers";
$active_subnav = "pricing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Lists - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale-price-list.css?v=<?php echo time(); ?>">
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
                            <span>Custom Wholesale Price Lists</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Create and assign targeted seasonal catalog price lists and custom SKU markdowns.</p>
                    </div>
                </div>

                <?php include __DIR__ . '/components/wholesale-price-list.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══ CREATE PRICE LIST MODAL ══ -->
<div id="dtCreatePriceListModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:460px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <h3 style="font-size:1.1rem; font-weight:900; color:#181512; margin:0 0 10px 0;">Create Custom Price List</h3>
        <form onsubmit="submitCreatePriceList(event)" style="display:flex; flex-direction:column; gap:12px;">
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Price List Name</label>
                <input type="text" id="newPriceListName" placeholder="e.g. Wedding Silk Season Special 2026" required style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; padding:0 10px; box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Target Wholesale Tier</label>
                <select class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                    <option>Platinum Wholesale (35%)</option>
                    <option>Gold Distributor (28%)</option>
                    <option>Silver Bulk Partner (20%)</option>
                </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:6px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtCreatePriceListModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Create &amp; Assign SKUs</button>
            </div>
        </form>
    </div>
</div>

<script src="/Frontend/Admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/wholesale/assets/js/wholesale-price-list.js?v=<?php echo time(); ?>"></script>
</body>
</html>
