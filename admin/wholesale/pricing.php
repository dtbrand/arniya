<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * pricing.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Multi-Tier Pricing & Category Margins (100% Dynamic)
 */
$page_title = "Wholesale Pricing & Margins";
$active_nav = "wholesalers";
$active_subnav = "pricing";

require_once __DIR__ . '/components/wholesale-data.php';

$whl_id = isset($_GET['id']) ? $_GET['id'] : null;
$wholesale = $whl_id ? getWholesalePartner($whl_id) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $wholesale ? htmlspecialchars($wholesale['id'] . ' Pricing - ' . $wholesale['name']) : 'Wholesale Pricing'; ?> - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale-pricing.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-wholesale-container">
                <!-- Top Breadcrumb & Return Nav -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="/admin/wholesale/index.php" class="dt-btn dt-btn-pale dt-btn-sm">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>All Wholesalers</span>
                        </a>
                        <?php if ($wholesale): ?>
                            <a href="/admin/wholesale/view.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>Back to <?php echo htmlspecialchars($wholesale['id']); ?> Dossier</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ($wholesale): ?>
                        <div style="display:flex; gap:8px;">
                            <a href="/admin/wholesale/orders.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                                <span>View Orders</span>
                            </a>
                            <a href="/admin/wholesale/credit.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-gold dt-btn-sm">
                                <span>Credit Hub</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span><?php echo $wholesale ? htmlspecialchars($wholesale['name']) . ' — Pricing & Margins' : 'Wholesale Tier Pricing & Category Margins'; ?></span>
                            <?php if ($wholesale): ?>
                                <span class="dt-status-pill-clean <?php echo $wholesale['tier_badge']; ?>"><?php echo $wholesale['tier_short']; ?></span>
                            <?php endif; ?>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">
                            <?php echo $wholesale ? 'Category-level margin discounts, minimum lot sizing, and dynamic wholesale pricing for ' . htmlspecialchars($wholesale['legal_name']) . '.' : 'Manage category-level margin discounts, minimum lot sizing, and dynamic wholesale price calculations.'; ?>
                        </p>
                    </div>
                </div>

                <?php include __DIR__ . '/components/wholesale-pricing.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══ EDIT CATEGORY MARGIN MODAL ══ -->
<div id="dtEditCategoryMarginModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:440px; padding:22px; box-shadow:0 20px 50px rgba(0,0,0,0.4); position:relative;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px;">
            <div>
                <h3 style="font-size:1.15rem; font-weight:900; color:#181512; margin:0 0 3px 0;">Edit Category Wholesale Margin</h3>
                <p id="editMarginCatName" style="font-size:0.82rem; color:#8A681F; font-weight:800; margin:0;">Category Name</p>
            </div>
            <button type="button" class="dt-drawer-close" onclick="closeWholesaleModal('dtEditCategoryMarginModal')">✕</button>
        </div>
        <input type="hidden" id="editMarginRowId">
        <form onsubmit="submitCategoryMarginEdit(event)" style="display:flex; flex-direction:column; gap:14px;">
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Wholesale Margin Discount (%)</label>
                <input type="number" id="editCategoryMarginInput" class="dt-wholesale-input" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Minimum Order Lot (MOQ in pcs)</label>
                <input type="number" id="editCategoryMoqInput" class="dt-wholesale-input" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtEditCategoryMarginModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Update Margin</button>
            </div>
        </form>
    </div>
</div>

<!-- ══ ADD NEW CATEGORY RULE MODAL ══ -->
<div id="dtAddCategoryMarginModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:460px; padding:22px; box-shadow:0 20px 50px rgba(0,0,0,0.4); position:relative;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px;">
            <div>
                <h3 style="font-size:1.15rem; font-weight:900; color:#181512; margin:0 0 3px 0;">Add Fabric Margin Rule</h3>
                <p style="font-size:0.78rem; color:#78716C; margin:0;">Configure dynamic wholesale discount and MOQ for a new catalog category.</p>
            </div>
            <button type="button" class="dt-drawer-close" onclick="closeWholesaleModal('dtAddCategoryMarginModal')">✕</button>
        </div>
        <form onsubmit="submitAddCategoryRule(event)" style="display:flex; flex-direction:column; gap:14px;">
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Fabric / Category Name</label>
                <input type="text" id="addCategoryNameInput" class="dt-wholesale-input" placeholder="e.g. Chanderi Jacquard Silk" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.85rem; font-weight:700; padding:0 12px; box-sizing:border-box;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div>
                    <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Discount Margin (%)</label>
                    <input type="number" id="addCategoryMarginInput" class="dt-wholesale-input" value="32" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Min Lot (MOQ)</label>
                    <input type="number" id="addCategoryMoqInput" class="dt-wholesale-input" value="20" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
                </div>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Sample Retail MRP (₹)</label>
                <input type="number" id="addCategoryMrpInput" class="dt-wholesale-input" value="2400" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtAddCategoryMarginModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Save Category Rule</span>
                </button>
            </div>
        </form>
    </div>
</div>


<script src="/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-pricing.js?v=<?php echo time(); ?>"></script>
</body>
</html>
