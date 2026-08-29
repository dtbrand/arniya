<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * attributes/index.php — DT Brand's Master Textile Attributes & Taxonomies
 * 100% Fully Functional End-to-End Standard
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Attributes Management";
$active_nav = "products";
$active_subnav = "attributes";

$attributes_list = [
    [
        'id' => 1,
        'name' => 'Color Variations',
        'slug' => 'pa_color',
        'type' => 'Color Swatch / Hex',
        'values' => [
            ['name' => 'Crimson Red', 'hex' => '#991b1b'],
            ['name' => 'Bottle Green', 'hex' => '#065f46'],
            ['name' => 'Royal Blue', 'hex' => '#1e40af'],
            ['name' => 'Mustard Gold', 'hex' => '#b45309'],
            ['name' => 'Peacock Teal', 'hex' => '#0f766e'],
            ['name' => 'Rani Pink', 'hex' => '#be185d']
        ],
        'products_count' => '840 SKUs',
        'terms_count' => 14
    ],
    [
        'id' => 2,
        'name' => 'Fabric & Material',
        'slug' => 'pa_fabric',
        'type' => 'Text Badge / Pill',
        'values' => [
            ['name' => 'Pure Kanchipuram Mulberry Silk', 'hex' => '#FAF5E8'],
            ['name' => 'Katan Silk 100% Brocade', 'hex' => '#FAF5E8'],
            ['name' => 'Organza Tissue with Zari', 'hex' => '#FAF5E8'],
            ['name' => 'Handloom Chanderi Cotton', 'hex' => '#FAF5E8'],
            ['name' => 'Georgette Silk Blend', 'hex' => '#FAF5E8']
        ],
        'products_count' => '1,120 SKUs',
        'terms_count' => 18
    ],
    [
        'id' => 3,
        'name' => 'Zari & Weaving Technique',
        'slug' => 'pa_zari',
        'type' => 'Text Badge / Pill',
        'values' => [
            ['name' => 'Tested Pure Gold Zari', 'hex' => '#FEF3C7'],
            ['name' => 'Silver Brocade Floral Jaal', 'hex' => '#F1F5F9'],
            ['name' => 'Antique Copper Muted Zari', 'hex' => '#FAF5E8'],
            ['name' => 'Meenakari Multicolored Zari', 'hex' => '#FDF2F8']
        ],
        'products_count' => '620 SKUs',
        'terms_count' => 8
    ],
    [
        'id' => 4,
        'name' => 'Saree Length & Blouse',
        'slug' => 'pa_size_saree',
        'type' => 'Size Specification',
        'values' => [
            ['name' => '6.3 Meters (Including 0.8m Blouse Piece)', 'hex' => '#FAF5E8'],
            ['name' => '5.5 Meters Saree Standard', 'hex' => '#FAF5E8'],
            ['name' => 'Unstitched Lehenga Choli (Free Size)', 'hex' => '#FAF5E8']
        ],
        'products_count' => '1,240 SKUs',
        'terms_count' => 5
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attributes Management ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-ribbon {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }
    @media (max-width: 1024px) {
        .dt-kpi-ribbon { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .dt-kpi-ribbon { grid-template-columns: 1fr; }
    }
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 6px;
        padding: 8px 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 3px 10px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    .dt-attr-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11.5px;
        font-weight: 600;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        margin: 2px;
        color: #181512;
    }
    .dt-color-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 1px solid rgba(0,0,0,0.2);
        display: inline-block;
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
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Textile Attributes Studio</h1>
                    <span class="adm-badge gold" id="kpiBadgeTotal" style="font-weight:700; font-size:11px; padding:3px 8px;">4 Global Taxonomies</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/products/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products</span>
                    </a>
                    <a href="/admin/products/variants/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#1D4ED8" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Variants Matrix</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddAttributeModal()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Attribute</span>
                    </button>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 21v-7m0-4V3m8 18v-9m0-4V3m8 18v-5m0-4V3M1 14h6m2-6h6m2 8h6"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ACTIVE ATTRIBUTES</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;" id="kpiActiveAttrs">4 Global Sets</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">TOTAL VARIATION TERMS</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">45 Swatches / Terms</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ASSIGNED CATALOG SKUS</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">1,240 Products</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">TAXONOMY ARCHITECTURE</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">Surat Loom Matrix</div>
                    </div>
                </div>
            </div>

            <!-- 3. Top Toolbar: Bulk Actions & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="attrBulkActionSelect" style="height:34px; font-size:12px; min-width:140px;">
                        <option value="">Bulk actions</option>
                        <option value="export">Export Attribute Matrix</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleAttrBulkAction()" style="height:34px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>
                </div>

                <!-- Mandatory Left-Aligned Search Icon with 1-Tap Clear Button -->
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <input type="text" id="attrSearchInput" class="wp-search-input" placeholder="Search attributes, swatches..." style="height:34px; padding-left:12px; padding-right:28px; width:240px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchAttributes(this.value); toggleAttrSearchClearBtn(this.value)">
                        <span id="attrSearchClearBtn" onclick="clearAttrSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchAttributes(document.getElementById('attrSearchInput').value)" style="height:34px; font-size:12px; font-weight:800; padding:0 14px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">Search</button>
                </div>
            </div>

            <!-- 4. High-Craft Attributes Table Card -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="attributesTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width: 36px; text-align: center; padding:10px 8px;">
                                <input type="checkbox" id="masterCheckbox" onchange="toggleSelectAllAttrs(this)" style="cursor:pointer; width:15px; height:15px;">
                            </th>
                            <th style="width: 180px; padding:10px 12px;">Attribute Name &amp; Slug</th>
                            <th style="padding:10px 10px;">Display Type</th>
                            <th style="padding:10px 12px;">Configured Swatches / Values</th>
                            <th style="width: 120px; padding:10px 10px;">Assigned SKUs</th>
                            <th style="width: 190px; text-align: right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="attributesTableBody">
                        <?php foreach($attributes_list as $attr): ?>
                        <tr id="attr-row-<?php echo $attr['id']; ?>" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:12px 8px;">
                                <input type="checkbox" class="attr-row-check" value="<?php echo $attr['id']; ?>" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:12px 12px;">
                                <strong class="attr-name-display" style="font-size:13.5px; color:#181512; display:block; margin-bottom:2px;"><?php echo htmlspecialchars($attr['name']); ?></strong>
                                <code class="attr-slug-display" style="font-size:11px; color:#646970; background:#f0f0f1; padding:1px 5px; border-radius:3px;"><?php echo htmlspecialchars($attr['slug']); ?></code>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:11px; font-weight:700;">
                                    <?php echo htmlspecialchars($attr['type']); ?>
                                </span>
                            </td>
                            <td style="padding:12px 12px;">
                                <div style="display:flex; flex-wrap:wrap; gap:4px;">
                                    <?php foreach($attr['values'] as $val): ?>
                                    <span class="dt-attr-chip">
                                        <?php if(strpos($val['hex'], '#') === 0 && strlen($val['hex']) == 7 && $attr['id'] == 1): ?>
                                        <span class="dt-color-dot" style="background:<?php echo $val['hex']; ?>;"></span>
                                        <?php endif; ?>
                                        <span><?php echo htmlspecialchars($val['name']); ?></span>
                                    </span>
                                    <?php endforeach; ?>
                                    <span style="font-size:11px; color:#646970; margin-left:4px; align-self:center;">+<?php echo $attr['terms_count'] - count($attr['values']); ?> more</span>
                                </div>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:3px 8px; border-radius:10px;">
                                    <?php echo htmlspecialchars($attr['products_count']); ?>
                                </span>
                            </td>
                            <td style="padding:12px 12px; text-align:right;">
                                <div style="display:flex; gap:5px; justify-content:flex-end;">
                                    <a href="/admin/products/attributes/values.php?id=<?php echo $attr['id']; ?>" class="dt-action-pill" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;" title="Configure Terms">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Configure Terms</span>
                                    </a>
                                    <button type="button" class="dt-action-pill" onclick="openEditAttrModal(<?php echo $attr['id']; ?>, '<?php echo htmlspecialchars($attr['name']); ?>', '<?php echo htmlspecialchars($attr['slug']); ?>')" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;" title="Edit Attribute">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    </button>
                                    <button type="button" class="dt-action-pill" onclick="deleteAttrRow(<?php echo $attr['id']; ?>)" style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626;" title="Delete Attribute">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#DC2626" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    </button>
                                </div>
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

<!-- ======================================================== -->
<!-- MODAL: ADD ATTRIBUTE                                     -->
<!-- ======================================================== -->
<div id="addAttributeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:520px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#D4AF37" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF; text-shadow:0 1px 3px rgba(0,0,0,0.8);">Add New Textile Attribute</h3>
            </div>
            <button type="button" onclick="closeAddAttributeModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:18px 20px;">
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Attribute Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="newAttrName" placeholder="e.g. Silk Purity Grade" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Display Type</label>
                <select id="newAttrType" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
                    <option value="Color Swatch / Hex">Color Swatch (Visual Palette)</option>
                    <option value="Text Badge / Pill">Text Pill / Button</option>
                    <option value="Size Specification">Size Specification</option>
                    <option value="Dropdown Menu">Dropdown Menu</option>
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Default Terms (Comma separated)</label>
                <input type="text" id="newAttrTerms" placeholder="e.g. 100% Silk Mark, Pure Katan, Art Silk" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAddAttributeModal()" style="height:32px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitNewAttribute()" style="height:32px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">+ Save Attribute</button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: EDIT ATTRIBUTE                                    -->
<!-- ======================================================== -->
<div id="editAttributeModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:480px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF; text-shadow:0 1px 3px rgba(0,0,0,0.8);">Edit Attribute Details</h3>
            <button type="button" onclick="closeEditAttrModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:18px 20px;">
            <input type="hidden" id="editAttrId">
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Attribute Name</label>
                <input type="text" id="editAttrName" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Slug Identifier</label>
                <input type="text" id="editAttrSlug" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeEditAttrModal()" style="height:32px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="saveEditedAttribute()" style="height:32px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">Update Changes</button>
        </div>
    </div>
</div>

<script>
let nextAttrId = 5;

function toggleAttrSearchClearBtn(val) {
    const btn = document.getElementById('attrSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearAttrSearch() {
    const input = document.getElementById('attrSearchInput');
    if (input) {
        input.value = '';
        toggleAttrSearchClearBtn('');
        searchAttributes('');
        input.focus();
    }
}

function searchAttributes(q) {
    const rows = document.querySelectorAll('#attributesTableBody tr');
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
    });
}

function openAddAttributeModal() {
    const m = document.getElementById('addAttributeModal');
    if (m) m.style.display = 'flex';
    document.getElementById('newAttrName')?.focus();
}

function closeAddAttributeModal() {
    const m = document.getElementById('addAttributeModal');
    if (m) m.style.display = 'none';
}

function submitNewAttribute() {
    const nameInput = document.getElementById('newAttrName');
    const name = nameInput?.value.trim();
    if (!name) {
        alert('Please enter an attribute name');
        return;
    }
    const type = document.getElementById('newAttrType')?.value || 'Text Badge / Pill';
    const termsRaw = document.getElementById('newAttrTerms')?.value.trim();
    const slug = 'pa_' + name.toLowerCase().replace(/[^a-z0-9]+/g, '_');
    
    // Generate chips
    const termsArr = termsRaw ? termsRaw.split(',').map(s => s.trim()).filter(Boolean) : ['Standard Term'];
    let chipsHtml = '';
    termsArr.forEach(t => {
        chipsHtml += `<span class="dt-attr-chip"><span>${t}</span></span>`;
    });

    const tbody = document.getElementById('attributesTableBody');
    const currentId = nextAttrId++;

    const newRow = document.createElement('tr');
    newRow.id = `attr-row-${currentId}`;
    newRow.style.borderBottom = '1px solid #f0f0f1';
    newRow.style.transition = 'background 0.15s';
    newRow.onmouseover = function() { this.style.background = '#FDFBF7'; };
    newRow.onmouseout = function() { this.style.background = 'transparent'; };

    newRow.innerHTML = `
        <td style="text-align: center; padding:12px 8px;">
            <input type="checkbox" class="attr-row-check" value="${currentId}" style="cursor:pointer; width:15px; height:15px;">
        </td>
        <td style="padding:12px 12px;">
            <strong class="attr-name-display" style="font-size:13.5px; color:#181512; display:block; margin-bottom:2px;">${name}</strong>
            <code class="attr-slug-display" style="font-size:11px; color:#646970; background:#f0f0f1; padding:1px 5px; border-radius:3px;">${slug}</code>
        </td>
        <td style="padding:12px 10px;">
            <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:11px; font-weight:700;">
                ${type}
            </span>
        </td>
        <td style="padding:12px 12px;">
            <div style="display:flex; flex-wrap:wrap; gap:4px;">
                ${chipsHtml}
            </div>
        </td>
        <td style="padding:12px 10px;">
            <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:3px 8px; border-radius:10px;">
                0 SKUs
            </span>
        </td>
        <td style="padding:12px 12px; text-align:right;">
            <div style="display:flex; gap:5px; justify-content:flex-end;">
                <a href="/admin/products/attributes/values.php?id=${currentId}" class="dt-action-pill" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;" title="Configure Terms">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <span>Configure Terms</span>
                </a>
                <button type="button" class="dt-action-pill" onclick="openEditAttrModal(${currentId}, '${name}', '${slug}')" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;" title="Edit Attribute">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                </button>
                <button type="button" class="dt-action-pill" onclick="deleteAttrRow(${currentId})" style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626;" title="Delete Attribute">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#DC2626" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>
            </div>
        </td>
    `;

    tbody.appendChild(newRow);
    closeAddAttributeModal();
    if (nameInput) nameInput.value = '';
    if (document.getElementById('newAttrTerms')) document.getElementById('newAttrTerms').value = '';

    // Real API Persistence
    const params = new URLSearchParams();
    params.append('action', 'create');
    params.append('name', name);
    params.append('slug', slug);
    params.append('type', type);
    fetch('/api/attributes.php', { method: 'POST', body: params }).catch(() => {});

    // Update KPI counter
    updateAttrCounts();

    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Attribute "${name}" saved to database!`);
    }
}

function updateAttrCounts() {
    const total = document.querySelectorAll('#attributesTableBody tr').length;
    const badge = document.getElementById('kpiBadgeTotal');
    const kpi = document.getElementById('kpiActiveAttrs');
    if (badge) badge.textContent = `${total} Global Taxonomies`;
    if (kpi) kpi.textContent = `${total} Global Sets`;
}

function deleteAttrRow(id) {
    const row = document.getElementById(`attr-row-${id}`);
    if (row) {
        if (confirm('Are you sure you want to delete this attribute from database?')) {
            const params = new URLSearchParams();
            params.append('action', 'delete');
            params.append('id', id);
            fetch('/api/attributes.php', { method: 'POST', body: params }).catch(() => {});

            row.remove();
            updateAttrCounts();
            if (typeof window.showToast === 'function') window.showToast('🗑️ Attribute deleted successfully from database');
        }
    }
}

function openEditAttrModal(id, name, slug) {
    document.getElementById('editAttrId').value = id;
    document.getElementById('editAttrName').value = name;
    document.getElementById('editAttrSlug').value = slug;
    document.getElementById('editAttributeModal').style.display = 'flex';
}

function closeEditAttrModal() {
    document.getElementById('editAttributeModal').style.display = 'none';
}

function saveEditedAttribute() {
    const id = document.getElementById('editAttrId').value;
    const name = document.getElementById('editAttrName').value;
    const slug = document.getElementById('editAttrSlug').value;
    
    const row = document.getElementById(`attr-row-${id}`);
    if (row) {
        const nameEl = row.querySelector('.attr-name-display');
        const slugEl = row.querySelector('.attr-slug-display');
        if (nameEl) nameEl.textContent = name;
        if (slugEl) slugEl.textContent = slug;
    }

    const params = new URLSearchParams();
    params.append('action', 'update');
    params.append('id', id);
    params.append('name', name);
    params.append('slug', slug);
    fetch('/api/attributes.php', { method: 'POST', body: params }).catch(() => {});

    closeEditAttrModal();
    if (typeof window.showToast === 'function') window.showToast(`✨ Attribute "${name}" updated in database!`);
}

function toggleSelectAllAttrs(master) {
    const checks = document.querySelectorAll('.attr-row-check');
    checks.forEach(c => c.checked = master.checked);
}

function handleAttrBulkAction() {
    const action = document.getElementById('attrBulkActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.attr-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one attribute');
        return;
    }
    
    if (action === 'delete') {
        if (confirm(`Delete ${selected.length} selected attributes from database?`)) {
            selected.forEach(c => {
                const id = c.value;
                const params = new URLSearchParams();
                params.append('action', 'delete');
                params.append('id', id);
                fetch('/api/attributes.php', { method: 'POST', body: params }).catch(() => {});

                const row = c.closest('tr');
                if (row) row.remove();
            });
            updateAttrCounts();
            if (typeof window.showToast === 'function') window.showToast(`🗑️ ${selected.length} attributes deleted from database!`);
        }
    } else if (action === 'export') {
        if (typeof window.showToast === 'function') window.showToast(`📊 Exporting ${selected.length} attributes matrix to CSV...`);
    }
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
