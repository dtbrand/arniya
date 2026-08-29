<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * Featured Products — DT Brand's Master Wholesale Suite
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Featured Products";
$active_nav = "products";
$active_subnav = "featured";

/*
 * This page shipped a hardcoded five-product array - ids 101/204/305/408/512,
 * SKUs KLN-SR-111 / BNR-SR-204 / BRD-LH-902, barcodes 8901234500111 onward,
 * brands "DT Signature" / "Arniya Heritage" / "DT Couture", MRPs, wholesale
 * prices, MOQs, stock counts, 5.0 ratings and 128 review counts. None of it is
 * in the database, and the products table has no barcode or brand column at
 * all, so the Barcode and Brand columns described fields that do not exist.
 * Every figure below comes from the catalogue and from order_items.
 */
require_once __DIR__ . '/../../../src/Database.php';
require_once __DIR__ . '/../../../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$allProducts = ProductCatalog::getAll(true);

/* Units actually sold per product, so "best sellers" means what it says. */
$soldByProduct = [];
$dbCur = Database::getConnection();
if ($dbCur !== null && !Database::isMockMode()) {
    try {
        $stCur = $dbCur->query("SELECT product_id, COALESCE(SUM(quantity), 0) AS n FROM order_items GROUP BY product_id");
        foreach ($stCur->fetchAll(\PDO::FETCH_ASSOC) as $rCur) {
            $soldByProduct[(int)$rCur['product_id']] = (int)$rCur['n'];
        }
    } catch (\Exception $e) {}
}

$collectionNote = '';
if ($active_subnav === 'best-sellers') {
    $rows = array_values(array_filter($allProducts, static function ($p) use ($soldByProduct) {
        return ($soldByProduct[(int)$p['id']] ?? 0) > 0;
    }));
    usort($rows, static function ($a, $b) use ($soldByProduct) {
        return ($soldByProduct[(int)$b['id']] ?? 0) <=> ($soldByProduct[(int)$a['id']] ?? 0);
    });
    $collectionNote = 'Ranked by units actually sold, counted from order_items. A product with no sales yet is not listed.';
} elseif ($active_subnav === 'new-arrivals') {
    $rows = $allProducts;
    usort($rows, static function ($a, $b) { return (int)$b['id'] <=> (int)$a['id']; });
    $collectionNote = 'Newest first, in the order products were added to the catalogue.';
} else {
    $rows = array_values(array_filter($allProducts, static function ($p) {
        return !empty($p['is_featured']);
    }));
    $collectionNote = 'Products whose "Featured" switch is on in the product form.';
}

$curMoney = static function ($v): string {
    $n = (float)$v;
    return $n > 0 ? '₹' . number_format($n) : 'not set';
};

$curated_products = [];
$listUnits = 0;
$listValue = 0.0;
$listSold  = 0;
$marginSum = 0.0;
$marginN   = 0;
foreach ($rows as $p) {
    $pid = (int)$p['id'];
    $stk = max(0, (int)($p['stock_qty'] ?? 0));
    $ws  = (float)($p['wholesale_price'] ?? 0);
    $rt  = (float)($p['retail_price'] ?? 0);
    $sold = $soldByProduct[$pid] ?? 0;

    $listUnits += $stk;
    $listValue += $stk * $ws;
    $listSold  += $sold;
    if ($rt > 0 && $ws > 0 && $rt > $ws) {
        $marginSum += (($rt - $ws) / $rt) * 100;
        $marginN++;
    }

    $curated_products[] = [
        'id'        => $pid,
        'title'     => (string)($p['name'] ?? ($p['title'] ?? '')),
        'sku'       => (string)($p['sku'] ?? ''),
        'category'  => (string)($p['category'] ?? ''),
        'fabric'    => (string)($p['fabric'] ?? ''),
        'mrp'       => $curMoney($p['mrp'] ?? 0),
        'retail'    => $curMoney($rt),
        'wholesale' => $curMoney($ws),
        'moq'       => ((int)($p['moq'] ?? 0)) > 0 ? (int)$p['moq'] . ' pcs' : 'not set',
        'stock'     => $stk,
        'sold'      => $sold,
        'img'       => (string)($p['image'] ?? ProductCatalog::NO_IMAGE),
        'has_photo' => !empty($p['has_photo']),
        'status'    => (string)($p['status'] ?? '')
    ];
}
$avgMargin = $marginN > 0 ? round($marginSum / $marginN, 1) : null;

/* Category options are the categories these products are actually filed under. */
$curCategories = [];
foreach ($curated_products as $cp) {
    if ($cp['category'] !== '') { $curCategories[$cp['category']] = true; }
}
$curCategories = array_keys($curCategories);
sort($curCategories);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Featured Products ‹ DT Brand's Admin</title>
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
    .dt-view-toggle-btn {
        background: #fff;
        border: 1px solid #c3c4c7;
        color: #50575e;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }
    .dt-view-toggle-btn.active {
        background: #FAF5E8;
        border-color: #D4AF37;
        color: #8A681F;
        font-weight: 700;
    }
    .dt-action-pill {
        height: 28px;
        padding: 0 8px;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .dt-action-pill:hover {
        transform: translateY(-1px);
    }
    .dt-ws-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }
    .dt-ws-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .dt-ws-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 6px 18px rgba(212,175,55,0.18);
        transform: translateY(-2px);
    }
    .dt-ws-card-img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        background: #f8fafc;
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
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Featured Products</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">★ Featured Collection</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/products/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products (<?php echo number_format(count($allProducts)); ?>)</span>
                    </a>

                    <!-- Dual View Mode Switcher -->
                    <div style="display:flex; align-items:center; border:1px solid #c3c4c7; border-radius:4px; overflow:hidden;">
                        <button type="button" class="dt-view-toggle-btn active" id="btnViewTable" onclick="switchProductView('table')">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            <span>Table</span>
                        </button>
                        <button type="button" class="dt-view-toggle-btn" id="btnViewGrid" onclick="switchProductView('grid')">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span>Wholesale Grid</span>
                        </button>
                    </div>

                    <a href="/admin/products/add.php" class="wp-button primary" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35); text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Product</span>
                    </a>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">FEATURED B2B DESIGNS</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;"><?php echo number_format(count($curated_products)); ?> <?php echo count($curated_products) === 1 ? 'product' : 'products'; ?></div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">STOCK VALUE AT TRADE PRICE</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;"><?php echo $listValue > 0 ? '₹' . number_format($listValue) : 'nothing priced yet'; ?></div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">UNITS IN STOCK (THIS LIST)</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;"><?php echo number_format($listUnits); ?> pcs</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">AVERAGE RESALE MARGIN</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;"><?php echo $avgMargin !== null ? '+' . $avgMargin . '% on ' . $marginN . ' priced ' . ($marginN === 1 ? 'product' : 'products') : 'no pair of prices set'; ?></div>
                    </div>
                </div>
            </div>

            <p style="font-size:12px; color:#646970; margin:0 0 12px 0;"><?php echo htmlspecialchars($collectionNote); ?></p>

            <!-- 3. Top Toolbar: Bulk Actions & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="curatedBulkActionSelect" style="height:34px; font-size:12px; min-width:140px;">
                        <option value="">Bulk actions</option>
                        <option value="featured">Keep in List</option>
                        <option value="export">Export Wholesale CSV</option>
                        <option value="remove">Remove Selected</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleCuratedBulkAction()" style="height:34px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>

                    <select class="wp-select" id="categoryFilter" onchange="filterCuratedByCategory(this.value)" style="height:34px; font-size:12px; min-width:150px;">
                        <option value="">All Categories</option>
                        <?php foreach ($curCategories as $cc): ?>
                        <option value="<?php echo htmlspecialchars($cc); ?>"><?php echo htmlspecialchars($cc); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select class="wp-select" id="stockFilter" onchange="filterCuratedByStock(this.value)" style="height:34px; font-size:12px; min-width:140px;">
                        <option value="">All Stock Status</option>
                        <option value="in stock">In stock</option>
                        <option value="low stock">Low stock</option>
                        <option value="out of stock">Out of stock</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <input type="text" id="curatedSearchInput" class="wp-search-input" placeholder="Search SKU, saree name, brand..." style="height:34px; padding-left:12px; padding-right:28px; width:230px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchCuratedProducts(this.value); toggleCuratedSearchClearBtn(this.value)">
                        <span id="curatedSearchClearBtn" onclick="clearCuratedSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchCuratedProducts(document.getElementById('curatedSearchInput').value)" style="height:34px; font-size:12px; font-weight:800; padding:0 14px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">Search</button>
                </div>
            </div>

            <!-- 4A. Table View -->
            <div id="curatedTableView" class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="curatedTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width: 36px; text-align: center; padding:10px 8px;">
                                <input type="checkbox" onchange="toggleSelectAllCurated(this)" style="cursor:pointer; width:15px; height:15px;">
                            </th>
                            <th style="width: 50px; padding:10px 8px;">Image</th>
                            <th style="padding:10px 12px;">Product Name &amp; SKU</th>
                            <th style="padding:10px 10px;">Category</th>
                            <th style="padding:10px 10px;">Fabric</th>
                            <th style="padding:10px 10px;">Pricing &amp; MRP</th>
                            <th style="padding:10px 10px;">Wholesale (B2B)</th>
                            <th style="padding:10px 10px;">Stock</th>
                            <th style="width: 170px; text-align: right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="curatedTableBody">
                        <?php if (empty($curated_products)): ?>
                        <tr>
                            <td colspan="9" style="padding:28px 12px; text-align:center; color:#646970; font-size:13px;">
                                No product qualifies for this list yet.
                                <a href="/admin/products/" style="color:#2271b1;">Open the catalogue</a> to add one.
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php foreach($curated_products as $p): ?>
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:10px 8px;">
                                <input type="checkbox" class="curated-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:8px 8px;">
                                <img src="<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" title="<?php echo $p['has_photo'] ? '' : 'No photo uploaded for this product'; ?>" style="width:44px; height:44px; object-fit:<?php echo $p['has_photo'] ? 'cover' : 'contain'; ?>; background:#f8fafc; border-radius:4px; border:1px solid #D4AF37; display:block;">
                            </td>
                            <td style="padding:10px 12px;">
                                <strong style="font-size:13px; color:#181512; display:block; margin-bottom:3px;"><?php echo htmlspecialchars($p['title']); ?></strong>
                                <span style="font-size:11.5px; color:#646970;">
                                    <?php if ($p['sku'] !== ''): ?>
                                    SKU: <span class="adm-badge gold" style="font-size:10px; font-weight:700; padding:1px 5px;"><?php echo htmlspecialchars($p['sku']); ?></span>
                                    <?php else: ?>
                                    <span style="color:#8c8f94;">No SKU set</span>
                                    <?php endif; ?>
                                    <?php if ($p['sold'] > 0): ?>
                                    <span style="color:#c3c4c7; margin:0 4px;">•</span>
                                    Sold: <?php echo number_format($p['sold']); ?> pcs
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td style="padding:10px 10px; font-size:12.5px; font-weight:600; color:#181512;">
                                <?php echo $p['category'] !== '' ? htmlspecialchars($p['category']) : '<span style="color:#8c8f94; font-weight:400;">Uncategorised</span>'; ?>
                            </td>
                            <td style="padding:10px 10px;">
                                <?php if ($p['fabric'] !== ''): ?>
                                <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:11px; font-weight:700; padding:2px 7px;">
                                    <?php echo htmlspecialchars($p['fabric']); ?>
                                </span>
                                <?php else: ?>
                                <span style="color:#8c8f94; font-size:12px;">—</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13.5px; color:#181512;"><?php echo htmlspecialchars($p['retail']); ?></strong>
                                <?php if ($p['mrp'] !== 'not set'): ?>
                                <del style="font-size:11px; color:#8c8f94; margin-left:3px;"><?php echo htmlspecialchars($p['mrp']); ?></del>
                                <?php endif; ?>
                            </td>
                            <td style="padding:10px 10px;">
                                <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:4px; padding:3px 6px; display:inline-block;">
                                    <strong style="color:#8A681F; font-size:12.5px;"><?php echo htmlspecialchars($p['wholesale']); ?><?php echo $p['wholesale'] !== 'not set' ? '/pc' : ''; ?></strong>
                                    <span style="font-size:10px; color:#15803D; font-weight:700; display:block;">MOQ: <?php echo htmlspecialchars($p['moq']); ?></span>
                                </div>
                            </td>
                            <td style="padding:10px 10px;">
                                <?php
                                $curStatusText = [
                                    'in_stock'     => 'In stock',
                                    'low_stock'    => 'Low stock',
                                    'out_of_stock' => 'Out of stock',
                                    'draft'        => 'Draft'
                                ][$p['status']] ?? ($p['status'] !== '' ? $p['status'] : 'Unknown');
                                $curStatusOk = in_array($p['status'], ['in_stock', 'low_stock'], true);
                                ?>
                                <span class="adm-badge" style="background:<?php echo $curStatusOk ? '#DCFCE7' : '#FEF2F2'; ?>; color:<?php echo $curStatusOk ? '#15803D' : '#DC2626'; ?>; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;"><?php echo number_format($p['stock']); ?> pcs</span>
                                <span style="display:block; font-size:10.5px; color:#646970; margin-top:3px;"><?php echo htmlspecialchars($curStatusText); ?></span>
                            </td>
                            <td style="padding:10px 12px; text-align:right;">
                                <div style="display:flex; gap:4px; justify-content:flex-end;">
                                    <a href="/admin/products/edit.php?id=<?php echo $p['id']; ?>" class="dt-action-pill" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;" title="Edit Product">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Edit</span>
                                    </a>
                                    <a href="/product.php?id=<?php echo $p['id']; ?>" target="_blank" class="dt-action-pill" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;" title="View on Shop">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        <span>View</span>
                                    </a>
                                    <button type="button" class="dt-action-pill" onclick="window.shareProductWhatsApp(<?php echo $p['id']; ?>)" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D;" title="WhatsApp Inquiry">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- 4B. Wholesale Desktop Grid Cards View (Toggled) -->
            <div id="curatedGridView" class="dt-ws-grid" style="display:none;">
                <?php if (empty($curated_products)): ?>
                <div style="grid-column:1 / -1; padding:28px 12px; text-align:center; color:#646970; font-size:13px; background:#fff; border:1px solid #c3c4c7; border-radius:6px;">
                    No product qualifies for this list yet.
                </div>
                <?php endif; ?>
                <?php foreach($curated_products as $p): ?>
                <div class="dt-ws-card">
                    <img src="<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>" class="dt-ws-card-img" style="object-fit:<?php echo $p['has_photo'] ? 'cover' : 'contain'; ?>;">
                    <div style="padding:12px; display:flex; flex-direction:column; justify-content:space-between; flex:1;">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                                <span class="adm-badge gold" style="font-size:10px; font-weight:800;"><?php echo $p['sku'] !== '' ? htmlspecialchars($p['sku']) : 'No SKU'; ?></span>
                                <?php if ($p['fabric'] !== ''): ?><span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:10px; font-weight:700;"><?php echo htmlspecialchars($p['fabric']); ?></span><?php endif; ?>
                            </div>
                            <strong style="font-size:13px; color:#181512; display:block; margin-bottom:6px;"><?php echo htmlspecialchars($p['title']); ?></strong>
                            
                            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:6px; padding:6px 8px; margin-bottom:8px;">
                                <div style="display:flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <strong style="font-size:14px; color:#8A681F;"><?php echo htmlspecialchars($p['wholesale']); ?><?php echo $p['wholesale'] !== 'not set' ? '/pc' : ''; ?></strong>
                                        <span style="font-size:10px; color:#15803D; font-weight:700; display:block;">MOQ: <?php echo htmlspecialchars($p['moq']); ?></span>
                                    </div>
                                    <div style="text-align:right;">
                                        <span style="font-size:12px; color:#181512; font-weight:700;"><?php echo htmlspecialchars($p['retail']); ?></span>
                                        <?php if ($p['mrp'] !== 'not set'): ?>
                                        <del style="font-size:10.5px; color:#8c8f94; display:block;"><?php echo htmlspecialchars($p['mrp']); ?></del>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex; gap:6px; justify-content:space-between; padding-top:8px; border-top:1px solid #f1f5f9;">
                            <a href="/admin/products/edit.php?id=<?php echo $p['id']; ?>" class="dt-action-pill" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; flex:1; justify-content:center;">Edit</a>
                            <a href="/product.php?id=<?php echo $p['id']; ?>" target="_blank" class="dt-action-pill" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; flex:1; justify-content:center;">View</a>
                            <button type="button" class="dt-action-pill" onclick="window.shareProductWhatsApp(<?php echo $p['id']; ?>)" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; padding:0 8px;">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#15803D" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function switchProductView(mode) {
    const tbl = document.getElementById('curatedTableView');
    const grd = document.getElementById('curatedGridView');
    const btnTbl = document.getElementById('btnViewTable');
    const btnGrd = document.getElementById('btnViewGrid');

    if (mode === 'grid') {
        tbl.style.display = 'none';
        grd.style.display = 'grid';
        btnGrd.classList.add('active');
        btnTbl.classList.remove('active');
        if (typeof window.showToast === 'function') window.showToast('🔲 Wholesale Grid View Activated');
    } else {
        grd.style.display = 'none';
        tbl.style.display = 'block';
        btnTbl.classList.add('active');
        btnGrd.classList.remove('active');
        if (typeof window.showToast === 'function') window.showToast('📋 Table List View Activated');
    }
}

function toggleCuratedSearchClearBtn(val) {
    const btn = document.getElementById('curatedSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearCuratedSearch() {
    const input = document.getElementById('curatedSearchInput');
    if (input) {
        input.value = '';
        toggleCuratedSearchClearBtn('');
        searchCuratedProducts('');
        input.focus();
    }
}

function searchCuratedProducts(q) {
    const rows = document.querySelectorAll('#curatedTableBody tr');
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
    });
}

function filterCuratedByCategory(cat) {
    const rows = document.querySelectorAll('#curatedTableBody tr');
    rows.forEach(r => {
        if (!cat) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(cat.toLowerCase()) ? '' : 'none';
        }
    });
}

function filterCuratedByStock(stk) {
    const rows = document.querySelectorAll('#curatedTableBody tr');
    rows.forEach(r => {
        if (!stk) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(stk.toLowerCase()) ? '' : 'none';
        }
    });
}

function toggleSelectAllCurated(master) {
    const checks = document.querySelectorAll('.curated-row-check');
    checks.forEach(c => c.checked = master.checked);
}

function handleCuratedBulkAction() {
    const action = document.getElementById('curatedBulkActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.curated-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one product');
        return;
    }
    /* This used to toast "Bulk action applied to N products!" while doing
       nothing at all - no request was sent, no flag changed, no CSV was
       produced. Until the endpoint exists it has to say so. */
    if (typeof window.showToast === 'function') {
        window.showToast(`Bulk "${action}" is not wired up yet - ${selected.length} selected, nothing changed. Use Edit on a row.`);
    }
}

/* A local window.shareProductWhatsApp stub stood here. It only raised a toast
   claiming a WhatsApp link had been generated and shared nothing; the real one
   in /admin/Asset/js/admin.js (loaded just below) fetches the product and
   opens WhatsApp. */
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
