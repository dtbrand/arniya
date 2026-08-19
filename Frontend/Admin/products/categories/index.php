<?php
/**
 * categories/index.php — Next-Level WordPress / WooCommerce Product Categories Suite
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
            margin-bottom: 12px;
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
            padding: 14px;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }
        .wp-cat-form-card h2 {
            font-size: 13.5px;
            font-weight: 700;
            color: #1d2327;
            margin: 0 0 10px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #f0f0f1;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .wp-form-field {
            margin-bottom: 9px;
        }
        .wp-form-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #1d2327;
            margin-bottom: 3px;
        }
        .wp-form-field input, .wp-form-field select, .wp-form-field textarea {
            width: 100%;
            height: 28px;
            padding: 0 8px;
            font-size: 12px;
            color: #2c3338;
            background: #ffffff;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            box-sizing: border-box;
            outline: none;
            transition: all 0.12s ease;
        }
        .wp-form-field textarea {
            height: 44px;
            padding: 5px 8px;
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
            margin-top: 3px;
        }
        .wp-thumb-box-img {
            width: 34px !important;
            height: 34px !important;
            max-width: 34px !important;
            max-height: 34px !important;
            border: 1px solid #c3c4c7 !important;
            border-radius: 3px !important;
            object-fit: cover !important;
            background: #f6f7f7;
            flex-shrink: 0;
        }

        /* ── SEARCH BOX WITH LEFT MAGNIFYING ICON & 1-TAP CLEAR ── */
        .wp-search-container {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .wp-search-left-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 13px;
            height: 13px;
            color: #8A681F;
            pointer-events: none;
        }
        .wp-search-input-styled {
            height: 28px;
            padding: 0 24px 0 30px !important;
            font-size: 12px;
            color: #2c3338;
            background: #ffffff;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            outline: none;
            width: 180px;
            box-sizing: border-box;
        }
        .wp-search-input-styled:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
            width: 210px;
        }
        .wp-search-clear-btn {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8c8f94;
            cursor: pointer;
            padding: 0;
            font-size: 12px;
            line-height: 1;
            display: none;
        }
        .wp-search-clear-btn:hover {
            color: #b32d2e;
        }

        /* ── WORDPRESS ROW ACTIONS ── */
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

        /* ── CLASSIC INLINE QUICK EDIT DRAWER ── */
        tr.inline-edit-row {
            background: #f0f6fc !important;
        }
        tr.inline-edit-row td {
            padding: 10px 12px !important;
            border-top: 1px solid #2271b1 !important;
            border-bottom: 1px solid #2271b1 !important;
        }
        .inline-edit-col {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .inline-edit-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .inline-edit-group label {
            font-size: 12px;
            font-weight: 700;
            color: #1d2327;
        }
        .inline-edit-group input {
            height: 26px;
            padding: 0 8px;
            font-size: 12px;
            border: 1px solid #8c8f94;
            border-radius: 3px;
            outline: none;
            width: 170px;
        }
        .inline-edit-group input:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
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
                <!-- 1. Header & Left-Icon Search Bar -->
                <div class="wp-header-top">
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <h1 class="wp-heading-inline">Product categories</h1>
                        <a href="/Frontend/Admin/products/" class="wp-page-title-action secondary">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>All Products</span>
                        </a>
                        <a href="/Frontend/Admin/products/brands/" class="wp-page-title-action secondary">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><circle cx="7.5" cy="7.5" r="1.5"></circle></svg>
                            <span>Brands (4)</span>
                        </a>
                        <a href="/Frontend/Admin/products/attributes/" class="wp-page-title-action secondary">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path></svg>
                            <span>Attributes</span>
                        </a>
                    </div>
                    
                    <div class="wp-search-box">
                        <div class="wp-search-container">
                            <svg class="wp-search-left-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="search" id="wpCatSearch" class="wp-search-input-styled" placeholder="Search categories..." oninput="handleCatSearch(this.value)">
                            <button type="button" id="wpCatSearchClear" class="wp-search-clear-btn" onclick="clearCatSearch()">✕</button>
                        </div>
                        <button type="button" class="wp-button" onclick="handleCatSearch(document.getElementById('wpCatSearch').value)">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <span>Search Categories</span>
                        </button>
                    </div>
                </div>

                <!-- 2. WordPress 2-Column Suite Layout -->
                <div class="wp-cat-layout">

                    <!-- ── LEFT COLUMN: Add New Category Form ── -->
                    <div class="wp-cat-form-card">
                        <h2>
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" style="color:#8A681F;"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add new category</span>
                        </h2>
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
                                    <input type="file" id="catFileInput" style="display:none;" accept="image/*" onchange="previewCatThumb(this)">
                                    <button type="button" class="wp-button" onclick="document.getElementById('catFileInput').click()">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                        <span>Upload/Add image</span>
                                    </button>
                                </div>
                            </div>

                            <div style="margin-top:10px;">
                                <button type="submit" class="wp-button primary" style="height:28px; font-weight:600; padding:0 12px;">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>Add new category</span>
                                </button>
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
                                <button type="button" class="wp-button" onclick="handleCatBulkAction()">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span>Apply</span>
                                </button>
                            </div>
                            <span style="font-size:12px; color:#646970;"><span id="catTotalCount">14</span> items</span>
                        </div>

                        <!-- WordPress List Table -->
                        <table class="wp-list-table" id="wpCatTable">
                            <thead>
                                <tr>
                                    <th style="width:26px; text-align:center;"><input type="checkbox" onchange="toggleCatSelectAll(this)"></th>
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
                                        <a href="/Frontend/Admin/products/categories/view.php?id=1" class="wp-row-title">Silk Sarees</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=1">Edit</a> |
                                            <a href="#" onclick="toggleWpQuickEdit(1, 'Silk Sarees', 'silk-sarees'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(1); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/categories/view.php?id=1">View</a>
                                        </div>
                                    </td>
                                    <td>Pure Mulberry &amp; Kanjivaram Bridal Silks</td>
                                    <td><code>silk-sarees</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5007 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/categories/view.php?id=1" style="font-weight:700; color:#2271b1;">420</a></td>
                                </tr>

                                <!-- Row 2 (Child) -->
                                <tr id="cat-row-2">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-img" alt="Kanjivaram"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/categories/view.php?id=2" class="wp-row-title">— Kanjivaram Pure Silk</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=2">Edit</a> |
                                            <a href="#" onclick="toggleWpQuickEdit(2, '— Kanjivaram Pure Silk', 'kanjivaram-pure-silk'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(2); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/categories/view.php?id=2">View</a>
                                        </div>
                                    </td>
                                    <td>Authentic Kanchipuram Handloom Zari Weaves</td>
                                    <td><code>kanjivaram-pure-silk</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5007 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/categories/view.php?id=2" style="font-weight:700; color:#2271b1;">180</a></td>
                                </tr>

                                <!-- Row 3 (Child) -->
                                <tr id="cat-row-3">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="wp-thumb-img" alt="Soft Silk"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/categories/view.php?id=3" class="wp-row-title">— Soft Silk &amp; Tussar</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=3">Edit</a> |
                                            <a href="#" onclick="toggleWpQuickEdit(3, '— Soft Silk & Tussar', 'soft-silk-tussar'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(3); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/categories/view.php?id=3">View</a>
                                        </div>
                                    </td>
                                    <td>Lightweight Festive Soft Silk Sarees</td>
                                    <td><code>soft-silk-tussar</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5007 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/categories/view.php?id=3" style="font-weight:700; color:#2271b1;">140</a></td>
                                </tr>

                                <!-- Row 4 -->
                                <tr id="cat-row-4">
                                    <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
                                    <td><img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="wp-thumb-img" alt="Banarasi"></td>
                                    <td>
                                        <a href="/Frontend/Admin/products/categories/view.php?id=4" class="wp-row-title">Banarasi Brocade</a>
                                        <div class="wp-row-actions">
                                            <a href="/Frontend/Admin/products/categories/edit.php?id=4">Edit</a> |
                                            <a href="#" onclick="toggleWpQuickEdit(4, 'Banarasi Brocade', 'banarasi-brocade'); return false;">Quick Edit</a> |
                                            <a href="#" class="trash" onclick="deleteCatRow(4); return false;">Delete</a> |
                                            <a href="/Frontend/Admin/products/categories/view.php?id=4">View</a>
                                        </div>
                                    </td>
                                    <td>Royal Heritage Varanasi Brocades &amp; Katan Silks</td>
                                    <td><code>banarasi-brocade</code></td>
                                    <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">5007 (5%)</span></td>
                                    <td style="text-align:right;"><a href="/Frontend/Admin/products/categories/view.php?id=4" style="font-weight:700; color:#2271b1;">280</a></td>
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
                                <button type="button" class="wp-button" onclick="handleCatBulkAction()">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span>Apply</span>
                                </button>
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

function previewCatThumb(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('catThumbPreview').src = e.target.result;
            window.showToast('✨ Thumbnail preview updated!');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleCatSelectAll(master) {
    document.querySelectorAll('.wp-cat-row-check').forEach(cb => cb.checked = master.checked);
}

function handleCatSearch(val) {
    const clearBtn = document.getElementById('wpCatSearchClear');
    if (clearBtn) clearBtn.style.display = val ? 'block' : 'none';
    
    const rows = document.querySelectorAll('#wpCatTableBody tr:not(.inline-edit-row)');
    const q = (val || '').toLowerCase().trim();
    rows.forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

function clearCatSearch() {
    const input = document.getElementById('wpCatSearch');
    if (input) {
        input.value = '';
        handleCatSearch('');
    }
}

function deleteCatRow(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        const row = document.getElementById('cat-row-' + id);
        if (row) row.remove();
        const editRow = document.getElementById('qe-row-' + id);
        if (editRow) editRow.remove();
        window.showToast('Category deleted successfully!');
    }
}

/* Classic WordPress Inline Quick Edit Drawer Row */
function toggleWpQuickEdit(id, name, slug) {
    const targetRow = document.getElementById('cat-row-' + id);
    if (!targetRow) return;

    let existingQe = document.getElementById('qe-row-' + id);
    if (existingQe) {
        existingQe.remove();
        return;
    }

    const cleanName = name.replace('— ', '');
    const prefix = name.startsWith('— ') ? '— ' : '';

    const qeRow = document.createElement('tr');
    qeRow.id = 'qe-row-' + id;
    qeRow.className = 'inline-edit-row';
    qeRow.innerHTML = `
        <td colspan="7">
            <div class="inline-edit-col">
                <span style="font-size:12px; font-weight:700; color:#2271b1;">QUICK EDIT:</span>
                <div class="inline-edit-group">
                    <label>Name:</label>
                    <input type="text" id="qe-input-name-${id}" value="${cleanName}">
                </div>
                <div class="inline-edit-group">
                    <label>Slug:</label>
                    <input type="text" id="qe-input-slug-${id}" value="${slug}">
                </div>
                <div style="display:flex; gap:4px; margin-left:auto;">
                    <button type="button" class="wp-button" onclick="document.getElementById('qe-row-${id}').remove()">Cancel</button>
                    <button type="button" class="wp-button primary" onclick="saveWpQuickEdit(${id}, '${prefix}')">Update Category</button>
                </div>
            </div>
        </td>
    `;
    targetRow.after(qeRow);
}

function saveWpQuickEdit(id, prefix) {
    const newName = document.getElementById('qe-input-name-' + id)?.value.trim();
    const newSlug = document.getElementById('qe-input-slug-' + id)?.value.trim();

    if (!newName) {
        window.showToast('Category name cannot be empty');
        return;
    }

    const targetRow = document.getElementById('cat-row-' + id);
    if (targetRow) {
        const titleEl = targetRow.querySelector('.wp-row-title');
        const slugEl = targetRow.querySelector('code');
        if (titleEl) titleEl.textContent = prefix + newName;
        if (slugEl) slugEl.textContent = newSlug;
    }

    document.getElementById('qe-row-' + id)?.remove();
    window.showToast('✨ Category updated via Quick Edit!');
}

function handleWpAddCategory(e) {
    e.preventDefault();
    const name = document.getElementById('catName').value.trim();
    const slug = document.getElementById('catSlug').value.trim() || name.toLowerCase().replace(/[^a-z0-9]+/g, '-');
    const desc = document.getElementById('catDesc').value.trim() || '—';
    const hsn = document.getElementById('catHsn').value.trim() || '5007 (5%)';
    const parent = document.getElementById('catParent').value;
    const thumbSrc = document.getElementById('catThumbPreview')?.src || '/Shared/Asset/images/product1.png';

    const prefix = parent ? '— ' : '';
    const newId = Date.now();

    const tbody = document.getElementById('wpCatTableBody');
    const tr = document.createElement('tr');
    tr.id = 'cat-row-' + newId;
    tr.innerHTML = `
        <td style="text-align:center;"><input type="checkbox" class="wp-cat-row-check"></td>
        <td><img src="${thumbSrc}" class="wp-thumb-img" alt="${name}"></td>
        <td>
            <a href="/Frontend/Admin/products/categories/view.php?id=${newId}" class="wp-row-title">${prefix}${name}</a>
            <div class="wp-row-actions">
                <a href="/Frontend/Admin/products/categories/edit.php?id=${newId}">Edit</a> |
                <a href="#" onclick="toggleWpQuickEdit(${newId}, '${prefix}${name}', '${slug}'); return false;">Quick Edit</a> |
                <a href="#" class="trash" onclick="deleteCatRow(${newId}); return false;">Delete</a> |
                <a href="/Frontend/Admin/products/categories/view.php?id=${newId}">View</a>
            </div>
        </td>
        <td>${desc}</td>
        <td><code>${slug}</code></td>
        <td><span style="background:#FAF5E8; color:#8A681F; font-weight:700; padding:1px 5px; border-radius:3px;">${hsn}</span></td>
        <td style="text-align:right;"><a href="/Frontend/Admin/products/categories/view.php?id=${newId}" style="font-weight:700; color:#2271b1;">0</a></td>
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
