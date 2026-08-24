<?php
/**
 * subcategories/index.php — DT Brand's Master Subcategories Hierarchy
 * Wholesale Dashboard & Luxury Shop Standard
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Subcategories Hierarchy";
$active_nav = "products";
$active_subnav = "subcategories";

$subcategories_list = [
    [
        'id' => 1,
        'name' => 'Kanjivaram Silk',
        'slug' => 'kanjivaram-silk',
        'parent' => 'Silk Sarees',
        'parent_id' => 1,
        'skus' => '142 SKUs',
        'valuation' => '₹8.40 Lakhs',
        'status' => 'Active',
        'img' => '/Frontend/Shop/Asset/images/product1.png'
    ],
    [
        'id' => 2,
        'name' => 'Paithani Zari Weaves',
        'slug' => 'paithani-zari',
        'parent' => 'Silk Sarees',
        'parent_id' => 1,
        'skus' => '98 SKUs',
        'valuation' => '₹5.60 Lakhs',
        'status' => 'Active',
        'img' => '/Frontend/Shop/Asset/images/product4.png'
    ],
    [
        'id' => 3,
        'name' => 'Zardosi Bridal Lehengas',
        'slug' => 'zardosi-bridal',
        'parent' => 'Bridal Lehengas',
        'parent_id' => 3,
        'skus' => '84 SKUs',
        'valuation' => '₹12.20 Lakhs',
        'status' => 'Active',
        'img' => '/Frontend/Shop/Asset/images/product3.png'
    ],
    [
        'id' => 4,
        'name' => 'Katan Silk Brocades',
        'slug' => 'katan-silk-brocades',
        'parent' => 'Banarasi Brocade',
        'parent_id' => 2,
        'skus' => '116 SKUs',
        'valuation' => '₹7.10 Lakhs',
        'status' => 'Active',
        'img' => '/Frontend/Shop/Asset/images/product2.png'
    ],
    [
        'id' => 5,
        'name' => 'Handloom Chanderi Cotton',
        'slug' => 'handloom-chanderi',
        'parent' => 'Cotton & Handloom',
        'parent_id' => 4,
        'skus' => '64 SKUs',
        'valuation' => '₹2.80 Lakhs',
        'status' => 'Active',
        'img' => '/Frontend/Shop/Asset/images/product5.png'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategories Hierarchy ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
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
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Subcategories Hierarchy</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">34 Subcategories</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/DT%20Brand/admin/products/categories/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Parent Categories (16)</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddSubcategoryModal()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Subcategory</span>
                    </button>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ACTIVE SUBCATEGORIES</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">34 Curated Taxonomies</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ASSIGNED CATALOG SKUS</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">1,240 Products</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">B2B CATALOG VALUATION</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">₹48.60 Lakhs</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">PARENT HIERARCHY</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">100% Taxonomized</div>
                    </div>
                </div>
            </div>

            <!-- 3. Top Toolbar: Bulk Actions & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="subcatBulkActionSelect" style="height:34px; font-size:12px; min-width:140px;">
                        <option value="">Bulk actions</option>
                        <option value="active">Mark as Active</option>
                        <option value="delete">Move to Trash</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleSubcatBulkAction()" style="height:34px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>

                    <select class="wp-select" id="parentFilter" onchange="filterSubcatByParent(this.value)" style="height:34px; font-size:12px; min-width:160px;">
                        <option value="">All Parent Categories</option>
                        <option value="Silk Sarees">Silk Sarees</option>
                        <option value="Banarasi">Banarasi Brocade</option>
                        <option value="Bridal">Bridal Lehengas</option>
                        <option value="Cotton">Cotton &amp; Handloom</option>
                    </select>
                </div>

                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <input type="text" id="subcatSearchInput" class="wp-search-input" placeholder="Search subcategory, parent..." style="height:34px; padding-left:12px; padding-right:28px; width:230px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchSubcats(this.value); toggleSubcatSearchClearBtn(this.value)">
                        <span id="subcatSearchClearBtn" onclick="clearSubcatSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchSubcats(document.getElementById('subcatSearchInput').value)" style="height:34px; font-size:12px; font-weight:800; padding:0 14px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">Search</button>
                </div>
            </div>

            <!-- 4. High-Craft Subcategories Table Card -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="subcategoriesTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width: 36px; text-align: center; padding:10px 8px;">
                                <input type="checkbox" onchange="toggleSelectAllSubcats(this)" style="cursor:pointer; width:15px; height:15px;">
                            </th>
                            <th style="width: 44px; padding:10px 8px;">Thumb</th>
                            <th style="padding:10px 12px;">Subcategory &amp; Slug</th>
                            <th style="padding:10px 10px;">Parent Category</th>
                            <th style="padding:10px 10px;">Active SKUs</th>
                            <th style="padding:10px 10px;">B2B Valuation</th>
                            <th style="padding:10px 10px;">Status</th>
                            <th style="width: 150px; text-align: right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subcategoriesTableBody">
                        <?php foreach($subcategories_list as $sub): ?>
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:12px 8px;">
                                <input type="checkbox" class="subcat-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:8px 8px;">
                                <img src="<?php echo htmlspecialchars($sub['img']); ?>" onerror="this.src='/Shared/Asset/images/product1.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #D4AF37; display:block;">
                            </td>
                            <td style="padding:12px 12px;">
                                <strong style="font-size:13.5px; color:#181512; display:block; margin-bottom:2px;"><?php echo htmlspecialchars($sub['name']); ?></strong>
                                <code style="font-size:11px; color:#646970; background:#f0f0f1; padding:1px 5px; border-radius:3px;"><?php echo htmlspecialchars($sub['slug']); ?></code>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:11px; font-weight:700;">
                                    <?php echo htmlspecialchars($sub['parent']); ?>
                                </span>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:3px 8px; border-radius:10px;">
                                    <?php echo htmlspecialchars($sub['skus']); ?>
                                </span>
                            </td>
                            <td style="padding:12px 10px;">
                                <strong style="color:#181512; font-size:13px;"><?php echo htmlspecialchars($sub['valuation']); ?></strong>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">🟢 Active</span>
                            </td>
                            <td style="padding:12px 12px; text-align:right;">
                                <div style="display:flex; gap:5px; justify-content:flex-end;">
                                    <button type="button" class="dt-action-pill" onclick="openEditSubcatModal(<?php echo $sub['id']; ?>, '<?php echo htmlspecialchars($sub['name']); ?>', '<?php echo htmlspecialchars($sub['parent']); ?>')" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Edit</span>
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

<script>
function toggleSubcatSearchClearBtn(val) {
    const btn = document.getElementById('subcatSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearSubcatSearch() {
    const input = document.getElementById('subcatSearchInput');
    if (input) {
        input.value = '';
        toggleSubcatSearchClearBtn('');
        searchSubcats('');
        input.focus();
    }
}

function searchSubcats(q) {
    const rows = document.querySelectorAll('#subcategoriesTableBody tr');
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
    });
}

function filterSubcatByParent(parent) {
    const rows = document.querySelectorAll('#subcategoriesTableBody tr');
    rows.forEach(r => {
        if (!parent) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(parent.toLowerCase()) ? '' : 'none';
        }
    });
}

function toggleSelectAllSubcats(master) {
    const checks = document.querySelectorAll('.subcat-row-check');
    checks.forEach(c => c.checked = master.checked);
}

function openAddSubcategoryModal() {
    if (typeof window.showToast === 'function') window.showToast('✨ Add Subcategory studio opened!');
}

function openEditSubcatModal(id, name, parent) {
    if (typeof window.showToast === 'function') window.showToast(`✨ Edit Subcategory "${name}" opened!`);
}

function handleSubcatBulkAction() {
    const action = document.getElementById('subcatBulkActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.subcat-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one subcategory');
        return;
    }
    if (typeof window.showToast === 'function') window.showToast(`✨ Bulk action "${action}" applied!`);
}
</script>
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
