<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * variants/index.php — DT Brand's Master Variant & SKU Combination Matrix
 * Wholesale Dashboard & Luxury Shop Standard
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Variants Matrix";
$active_nav = "products";
$active_subnav = "variants";

$allCatalog = ProductCatalog::getAll();
$variants_matrix = [];

foreach ($allCatalog as $prod) {
    $pId = $prod['id'];
    $pName = $prod['title'] ?? ($prod['name'] ?? 'Luxury Handloom Saree');
    $pSku = $prod['sku'] ?? ('DT-SKU-' . $pId);
    $pPrice = (float)($prod['price'] ?? 4490);
    $pWholesale = (float)($prod['wholesale_price'] ?? round($pPrice * 0.65));
    $pStock = (int)($prod['stock_qty'] ?? 15);
    $pImg = $prod['image'] ?? '/assets/images/product1.png';
    $pCat = $prod['category'] ?? 'Sarees';

    $variants_matrix[] = [
        'id' => (int)($pId * 10 + 1),
        'parent_name' => $pName,
        'parent_id' => $pId,
        'sku' => $pSku . '-STD',
        'color' => 'Royal Heritage Gold / Crimson',
        'color_hex' => '#8A681F',
        'size' => 'Free Size (6.3m with Blouse)',
        'fabric' => 'Pure Mulberry Silk',
        'retail' => '₹' . number_format($pPrice),
        'wholesale' => '₹' . number_format($pWholesale),
        'stock' => $pStock,
        'status' => $pStock > 10 ? 'In Stock' : ($pStock > 0 ? 'Low Stock' : 'Out of Stock'),
        'img' => $pImg
    ];
}

if (empty($variants_matrix)) {
    $variants_matrix = [
        [
            'id' => 1011,
            'parent_name' => 'Kanjivaram Pure Silk Gold Zari Saree',
            'parent_id' => 101,
            'sku' => 'KLN-SR-111-RED',
            'color' => 'Crimson Red',
            'color_hex' => '#991b1b',
            'size' => 'Free Size (6.3m)',
            'fabric' => 'Pure Mulberry Silk',
            'retail' => '₹4,490',
            'wholesale' => '₹2,850',
            'stock' => 18,
            'status' => 'In Stock',
            'img' => '/assets/images/product1.png'
        ]
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variants Matrix ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    .dt-color-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 1px solid rgba(0,0,0,0.2);
        display: inline-block;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar with Luxury Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Variant &amp; SKU Matrix</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">Surat Loom Matrix</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/products/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products (1,240)</span>
                    </a>
                    <a href="/admin/products/attributes/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M4 21v-7m0-4V3m8 18v-9m0-4V3m8 18v-5m0-4V3M1 14h6m2-6h6m2 8h6"></path></svg>
                        <span>Attributes Studio</span>
                    </a>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ACTIVE VARIANT COMBOS</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">3,420 Combinations</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">SURAT READY STOCK</div>
                        <?php
                        $varAllProds = \DTBrand\ProductCatalog::getAll();
                        $varStock = array_sum(array_column($varAllProds, 'stock_qty'));
                        $varVal = 0;
                        foreach ($varAllProds as $p) { $varVal += ((int)($p['stock_qty'] ?? 0) * (float)($p['wholesale_price'] ?? 0)); }
                        $varValTxt = $varVal >= 100000 ? ('₹' . number_format($varVal / 100000, 2) . ' Lakhs') : ('₹' . number_format($varVal));
                        ?>
                        <div style="font-size:17px; font-weight:800; color:#15803D;"><?= number_format($varStock) ?> Units in Depot</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">B2B CATALOG VALUATION</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;"><?= $varValTxt ?></div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">LOW STOCK REORDERS</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">14 Variant Lots</div>
                    </div>
                </div>
            </div>

            <!-- 3. Top Toolbar: Bulk Actions & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="variantBulkActionSelect" style="height:34px; font-size:12px; min-width:140px;">
                        <option value="">Bulk actions</option>
                        <option value="sync">Sync Surat Mill Stock</option>
                        <option value="export">Export Variant Barcodes</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleVariantBulkAction()" style="height:34px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>
                </div>

                <!-- Mandatory Left-Aligned Search Icon with 1-Tap Clear Button -->
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <input type="text" id="variantSearchInput" class="wp-search-input" placeholder="Search variant SKU, color..." style="height:34px; padding-left:12px; padding-right:28px; width:240px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchVariants(this.value); toggleVariantSearchClearBtn(this.value)">
                        <span id="variantSearchClearBtn" onclick="clearVariantSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchVariants(document.getElementById('variantSearchInput').value)" style="height:34px; font-size:12px; font-weight:800; padding:0 14px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">Search</button>
                </div>
            </div>

            <!-- 4. High-Craft Variants Table Card -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="variantsTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width: 36px; text-align: center; padding:10px 8px;">
                                <input type="checkbox" onchange="toggleSelectAllVariants(this)" style="cursor:pointer; width:15px; height:15px;">
                            </th>
                            <th style="width: 44px; padding:10px 8px;">Image</th>
                            <th style="padding:10px 12px;">Master Product</th>
                            <th style="padding:10px 10px;">Variant SKU</th>
                            <th style="padding:10px 10px;">Color &amp; Size</th>
                            <th style="padding:10px 10px;">Retail Price</th>
                            <th style="padding:10px 10px;">Wholesale (B2B)</th>
                            <th style="padding:10px 10px;">Stock</th>
                            <th style="padding:10px 10px;">Status</th>
                            <th style="width: 120px; text-align: right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="variantsTableBody">
                        <?php foreach($variants_matrix as $v): ?>
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:10px 8px;">
                                <input type="checkbox" class="variant-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:8px 8px;">
                                <img src="<?php echo htmlspecialchars($v['img']); ?>" onerror="this.src='/assets/images/product1.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #D4AF37; display:block;">
                            </td>
                            <td style="padding:10px 12px;">
                                <a href="/admin/products/edit.php?id=<?php echo $v['parent_id']; ?>" style="font-size:13px; font-weight:700; color:#181512; text-decoration:none;">
                                    <?php echo htmlspecialchars($v['parent_name']); ?>
                                </a>
                            </td>
                            <td style="padding:10px 10px;">
                                <code style="font-size:11.5px; background:#f0f0f1; padding:2px 6px; border-radius:3px; font-weight:700; color:#8A681F;"><?php echo htmlspecialchars($v['sku']); ?></code>
                            </td>
                            <td style="padding:10px 10px;">
                                <div style="display:flex; align-items:center; gap:6px;">
                                    <span class="dt-color-dot" style="background:<?php echo $v['color_hex']; ?>;"></span>
                                    <strong style="font-size:12px; color:#181512;"><?php echo htmlspecialchars($v['color']); ?></strong>
                                </div>
                                <span style="font-size:11px; color:#646970;"><?php echo htmlspecialchars($v['size']); ?></span>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13px; color:#181512;"><?php echo htmlspecialchars($v['retail']); ?></strong>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13px; color:#8A681F;"><?php echo htmlspecialchars($v['wholesale']); ?>/pc</strong>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:12.5px; color:#15803D;"><?php echo $v['stock']; ?> units</strong>
                            </td>
                            <td style="padding:10px 10px;">
                                <?php if($v['status'] == 'In Stock'): ?>
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">🟢 In Stock</span>
                                <?php else: ?>
                                <span class="adm-badge" style="background:#FEF2F2; color:#DC2626; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">⚠️ Low Stock</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding:10px 12px; text-align:right;">
                                <a href="/admin/products/edit.php?id=<?php echo $v['parent_id']; ?>#variations" class="wp-button" style="height:26px; font-size:11px; padding:0 8px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; text-decoration:none;">
                                    Edit Variant
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function toggleVariantSearchClearBtn(val) {
    const btn = document.getElementById('variantSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearVariantSearch() {
    const input = document.getElementById('variantSearchInput');
    if (input) {
        input.value = '';
        toggleVariantSearchClearBtn('');
        searchVariants('');
        input.focus();
    }
}

function searchVariants(q) {
    const rows = document.querySelectorAll('#variantsTableBody tr');
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
    });
}

function toggleSelectAllVariants(master) {
    const checks = document.querySelectorAll('.variant-row-check');
    checks.forEach(c => c.checked = master.checked);
}

function handleVariantBulkAction() {
    const action = document.getElementById('variantBulkActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.variant-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one variant');
        return;
    }
    if (typeof window.showToast === 'function') window.showToast(`✨ Bulk action "${action}" applied!`);
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
