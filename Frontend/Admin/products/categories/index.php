<?php
/**
 * categories/index.php — 100% Exact WordPress / WooCommerce Product Categories Replica
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Categories";
$active_nav = "products";
$active_subnav = "categories";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Categories ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
        .wp-wrap {
            padding: 10px 14px;
            max-width: 100%;
            box-sizing: border-box;
        }
        .wp-header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }
        .wp-cat-layout {
            display: grid;
            grid-template-columns: 290px 1fr;
            gap: 16px;
            align-items: start;
        }
        @media (max-width: 1024px) {
            .wp-cat-layout { grid-template-columns: 1fr; }
        }
        .wp-cat-form-card {
            background: #ffffff;
            border: 1px solid #c3c4c7;
            padding: 12px 14px;
            border-radius: 3px;
            box-shadow: 0 1px 1px rgba(0,0,0,0.04);
        }
        .wp-cat-form-card h2 {
            font-size: 13.5px;
            font-weight: 700;
            color: #1d2327;
            margin: 0 0 10px 0;
            padding-bottom: 6px;
            border-bottom: 1px solid #f0f0f1;
        }
        .wp-form-field {
            margin-bottom: 8px;
        }
        .wp-form-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #1d2327;
            margin-bottom: 2px;
        }
        .wp-form-field input, .wp-form-field select, .wp-form-field textarea {
            width: 100%;
            height: 28px;
            padding: 0 6px;
            font-size: 12px;
            color: #2c3338;
            background: #ffffff;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            box-sizing: border-box;
            outline: none;
            transition: all 0.1s ease;
        }
        .wp-form-field textarea {
            height: 42px;
            padding: 4px 6px;
            resize: none;
        }
        .wp-form-field input:focus, .wp-form-field select:focus, .wp-form-field textarea:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
        }
        .wp-thumb-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 2px;
        }
        .wp-thumb-box-img {
            width: 32px;
            height: 32px;
            border: 1px solid #c3c4c7;
            border-radius: 2px;
            object-fit: cover;
            background: #f6f7f7;
        }
        /* WordPress Standard Hover-Only Row Actions */
        .wp-list-table .wp-row-actions {
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.12s ease;
            font-size: 11px;
            color: #a7aaad;
            margin-top: 2px;
        }
        .wp-list-table tr:hover .wp-row-actions {
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 10px 14px;">

            <div class="wp-wrap">
                <!-- 1. Header & Search Bar -->
                <div class="wp-header-top">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <h1 class="wp-heading-inline">Product categories</h1>
                        <a href="/Frontend/Admin/products/" class="wp-page-title-action secondary">← All Products</a>
                        <a href="/Frontend/Admin/products/subcategories/" class="wp-page-title-action secondary">Subcategories (34)</a>
                    </div>
                    <div class="wp-search-box">
                        <input type="search" id="wpCatSearch" class="wp-search-input" placeholder="Search categories..." oninput="searchWpCategories(this.value)">
                        <button type="button" class="wp-button" onclick="searchWpCategories(document.getElementById('wpCatSearch').value)">Search Categories</button>
                    </div>
                </div>

                <!-- 2. WordPress 2-Column Suite Layout -->
                <div class="wp-cat-layout">

                    <!-- ── LEFT COLUMN: Add New Category Form (Zero Extra Text) ── -->
                    <div class="wp-cat-form-card">
                        <h2>Add new category</h2>
                        <form id="wpAddCatForm" onsubmit="handleWpAddCategory(event)">
                            <div class="wp-form-field">
                                <label for="catName">Name <span style="color:#b32d2e;">*</span></label>
                                <input type="text" id="catName" placeholder="Category name" required oninput="generateCatSlug(this.value)">
                            </div>

                            <div class="wp-form-field">
                                <label for="catSlug">Slug</label>
                                <input type="text" id="catSlug" placeholder="Slug identifier">
                            </div>

                            <div class="wp-form-field">
                                <label for="catParent">Parent category</label>
                                <select id="catParent">
                                    <option value="">None</option>
                                    <option value="Silk Sarees">Silk Sarees</option>
                                    <option value="Banarasi Brocade">Banarasi Brocade</option>
                                    <option value="Bridal Lehengas">Bridal Lehengas</option>
                                    <option value="Designer Kurtis">Designer Kurtis</option>
                                    <option value="Dress Materials">Dress Materials</option>
                                </select>
                            </div>

                            <div class="wp-form-field">
                                <label for="catDesc">Description</label>
                                <textarea id="catDesc" placeholder="Description..."></textarea>
                            </div>

                            <div class="wp-form-field">
                                <label for="catDisplayType">Display type</label>
                                <select id="catDisplayType">
                                    <option value="Default">Default</option>
                                    <option value="Products">Products</option>
                                    <option value="Subcategories">Subcategories</option>
                                    <option value="Both">Both</option>
                                </select>
                            </div>

                            <div class="wp-form-field">
                                <label for="catHsn">HSN Code &amp; GST</label>
                                <input type="text" id="catHsn" value="5007 (5% GST)">
                            </div>

                            <div class="wp-form-field">
                                <label>Thumbnail</label>
                                <div class="wp-thumb-row">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-box-img" id="catThumbPreview" alt="Category">
                                    <button type="button" class="wp-button" onclick="window.showToast('Select image from media library')">Upload/Add image</button>
                                </div>
                            </div>

                            <div style="margin-top:10px;">
                                <button type="submit" class="wp-button primary" style="height:28px; font-weight:600; padding:0 12px;">Add new category</button>
                            </div>
                        </form>
                    </div>

                    <!-- ── RIGHT COLUMN: Categories List Table ── -->
                    <div class="wp-table-card">
                        <!-- Top Toolbar -->
                        <div class="wp-tablenav" style="padding: 6px 8px; margin: 0; border-bottom: 1px solid #c3c4c7; background: #f6f7f7;">
                            <div class="wp-tablenav-actions">
                                <select class="wp-select" id="wpCatBulkSelect">
                                    <option value="">Bulk actions</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <button type="button" class="wp-button" onclick="handleCatBulkAction()">Apply</button>
                            </div>
                            <span style="font-size:12px; color:#646970;"><span id="catTotalCount">14</span> items</span>
                        </div>

                        <!-- WordPress List Table -->
                        <table class="wp-list-table" id="wpCatTable">
                            <thead>
                                <tr>
                                    <th style="width:26px; text-align:center;">
                                        <input type="checkbox" onchange="toggleCatSelectAll(this)">
                                    </th>
                                    <th style="width:40px;">Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Slug</th>
                                    <th>HSN (GST)</th>
                                    <th style="text-align:right;">Count</th>
                                </tr>
                            </thead>
                            <tbody id="wpCatTableBody">
                                <!-- Row 1 -->
                                <tr id="cat-row-1">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-img" alt="Silk Sarees"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/?category=silk-sarees" class="wp-row-title">Silk Sarees</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=1">Edit</a> |
                                            <a href="#" onclick="showQuickEdit(1, 'Silk Sarees', 'silk-sarees'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(1); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/?category=silk-sarees">View</a>
                                        </div>
                                    </td>
                                    <td>Pure Mulberry &amp; Kanjivaram Bridal Silks</td>
                                    <td><code>silk-sarees</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5007 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/?category=silk-sarees" style="font-weight:700; color:#2271b1;">420</a></td>
                                </tr>

                                <!-- Row 2 (Child) -->
                                <tr id="cat-row-2">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-img" alt="Kanjivaram"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/?category=kanjivaram" class="wp-row-title">— Kanjivaram Pure Silk</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=2">Edit</a> |
                                            <a href="#" onclick="showQuickEdit(2, '— Kanjivaram Pure Silk', 'kanjivaram-pure-silk'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(2); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/?category=kanjivaram">View</a>
                                        </div>
                                    </td>
                                    <td>Authentic Kanchipuram Handloom Zari Weaves</td>
                                    <td><code>kanjivaram-pure-silk</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5007 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/?category=kanjivaram" style="font-weight:700; color:#2271b1;">180</a></td>
                                </tr>

                                <!-- Row 3 (Child) -->
                                <tr id="cat-row-3">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="wp-thumb-img" alt="Soft Silk"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/?category=soft-silk" class="wp-row-title">— Soft Silk &amp; Tussar</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=3">Edit</a> |
                                            <a href="#" onclick="showQuickEdit(3, '— Soft Silk & Tussar', 'soft-silk-tussar'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(3); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/?category=soft-silk">View</a>
                                        </div>
                                    </td>
                                    <td>Lightweight Festive Soft Silk Sarees</td>
                                    <td><code>soft-silk-tussar</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5007 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/?category=soft-silk" style="font-weight:700; color:#2271b1;">140</a></td>
                                </tr>

                                <!-- Row 4 (Parent) -->
                                <tr id="cat-row-4">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="wp-thumb-img" alt="Banarasi"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/?category=banarasi" class="wp-row-title">Banarasi Brocade</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=4">Edit</a> |
                                            <a href="#" onclick="showQuickEdit(4, 'Banarasi Brocade', 'banarasi-brocade'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(4); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/?category=banarasi">View</a>
                                        </div>
                                    </td>
                                    <td>Royal Heritage Varanasi Brocades &amp; Katan Silks</td>
                                    <td><code>banarasi-brocade</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5007 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/?category=banarasi" style="font-weight:700; color:#2271b1;">280</a></td>
                                </tr>

                                <!-- Row 5 (Parent) -->
                                <tr id="cat-row-5">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="wp-thumb-img" alt="Lehengas"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/?category=lehengas" class="wp-row-title">Bridal Lehengas</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=5">Edit</a> |
                                            <a href="#" onclick="showQuickEdit(5, 'Bridal Lehengas', 'bridal-lehengas'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(5); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/?category=lehengas">View</a>
                                        </div>
                                    </td>
                                    <td>Handcrafted Velvet, Raw Silk &amp; Zardosi Sets</td>
                                    <td><code>bridal-lehengas</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">6204 (12%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/?category=lehengas" style="font-weight:700; color:#2271b1;">160</a></td>
                                </tr>

                                <!-- Row 6 (Parent) -->
                                <tr id="cat-row-6">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product4.png" onerror="this.src='/Frontend/Shop/Asset/images/product4.png';" class="wp-thumb-img" alt="Kurtis"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/?category=kurtis" class="wp-row-title">Designer Kurtis</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=6">Edit</a> |
                                            <a href="#" onclick="showQuickEdit(6, 'Designer Kurtis', 'designer-kurtis'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(6); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/?category=kurtis">View</a>
                                        </div>
                                    </td>
                                    <td>Chanderi, Rayon, and Cotton Foil Kurtis</td>
                                    <td><code>designer-kurtis</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">6204 (12%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/?category=kurtis" style="font-weight:700; color:#2271b1;">240</a></td>
                                </tr>

                                <!-- Row 7 (Parent) -->
                                <tr id="cat-row-7">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-img" alt="Dress Materials"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/?category=dress-materials" class="wp-row-title">Dress Materials</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=7">Edit</a> |
                                            <a href="#" onclick="showQuickEdit(7, 'Dress Materials', 'dress-materials'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(7); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/?category=dress-materials">View</a>
                                        </div>
                                    </td>
                                    <td>Unstitched Salwar Suits with Dupatta</td>
                                    <td><code>dress-materials</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5208 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/?category=dress-materials" style="font-weight:700; color:#2271b1;">140</a></td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Bottom Toolbar -->
                        <div class="wp-tablenav" style="padding: 6px 8px; margin: 0; border-top: 1px solid #c3c4c7; background: #f6f7f7;">
                            <div class="wp-tablenav-actions">
                                <select class="wp-select">
                                    <option value="">Bulk actions</option>
                                    <option value="delete">Delete</option>
                                </select>
                                <button type="button" class="wp-button" onclick="handleCatBulkAction()">Apply</button>
                            </div>
                            <span style="font-size:12px; color:#646970;">14 items</span>
                        </div>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script>
function generateCatSlug(val) {
    const slug = (val || '')
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-|-$/g, '');
    document.getElementById('catSlug').value = slug;
}

function toggleCatSelectAll(master) {
    document.querySelectorAll('.wp-cat-row-check').forEach(cb => cb.checked = master.checked);
}

function searchWpCategories(term) {
    const rows = document.querySelectorAll('#wpCatTableBody tr');
    const q = (term || '').toLowerCase().trim();
    rows.forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

function deleteCatRow(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        const row = document.getElementById('cat-row-' + id);
        if (row) row.remove();
        window.showToast('Category deleted successfully!');
    }
}

function showQuickEdit(id, name, slug) {
    const newName = prompt('Quick Edit Category Name:', name.replace('— ', ''));
    if (newName && newName.trim()) {
        const row = document.getElementById('cat-row-' + id);
        if (row) {
            const titleEl = row.querySelector('.wp-row-title');
            const prefix = name.startsWith('— ') ? '— ' : '';
            if (titleEl) titleEl.textContent = prefix + newName.trim();
        }
        window.showToast('Category updated!');
    }
}

function handleWpAddCategory(e) {
    e.preventDefault();
    const name = document.getElementById('catName').value.trim();
    const slug = document.getElementById('catSlug').value.trim() || name.toLowerCase().replace(/[^a-z0-9]+/g, '-');
    const desc = document.getElementById('catDesc').value.trim() || '—';
    const hsn = document.getElementById('catHsn').value.trim() || '5007 (5%)';
    const parent = document.getElementById('catParent').value;

    const prefix = parent ? '— ' : '';
    const newId = Date.now();

    const tbody = document.getElementById('wpCatTableBody');
    const tr = document.createElement('tr');
    tr.id = 'cat-row-' + newId;
    tr.innerHTML = `
        <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
        <td><img src="/Shared/Asset/images/product1.png" class="wp-thumb-img" alt="${name}"></td>
        <td>
            <a href="/Frontend/Admin/products/?category=${slug}" class="wp-row-title">${prefix}${name}</a>
            <div class="wp-row-actions">
                <a href="#">Edit</a> |
                <a href="#" onclick="showQuickEdit(${newId}, '${prefix}${name}', '${slug}'); return false;">Quick Edit</a> |
                <a href="#" class="trash" onclick="deleteCatRow(${newId}); return false;">Delete</a> |
                <a href="/Frontend/Admin/products/?category=${slug}">View</a>
            </div>
        </td>
        <td>${desc}</td>
        <td><code>${slug}</code></td>
        <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">${hsn}</span></td>
        <td style="text-align:right;"><a href="/Frontend/Admin/products/?category=${slug}" style="font-weight:700; color:#2271b1;">0</a></td>
    `;
    tbody.prepend(tr);

    document.getElementById('wpAddCatForm').reset();
    window.showToast(`✨ Category "${name}" added successfully!`);
}

function handleCatBulkAction() {
    const sel = document.getElementById('wpCatBulkSelect')?.value;
    if (!sel) {
        window.showToast('Please select a bulk action');
        return;
    }
    const checked = document.querySelectorAll('.wp-cat-row-check:checked');
    if (checked.length === 0) {
        window.showToast('No categories selected');
        return;
    }
    if (sel === 'delete') {
        if (confirm(`Delete ${checked.length} selected categories?`)) {
            checked.forEach(cb => cb.closest('tr')?.remove());
            window.showToast(`Deleted ${checked.length} categories`);
        }
    }
}
</script>
</body>
</html>
