<?php
/**
 * index.php — DT Brand's Products Management Suite (WordPress / WooCommerce Style)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Products";
$active_nav = "products";
$active_subnav = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products ‹ DT Brand's Admin — WordPress Style</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. WordPress Classic Page Header -->
            <div class="wp-heading-wrap">
                <h1 class="wp-heading-inline">Products</h1>
                <a href="/Frontend/Admin/products/add.php" class="wp-page-title-action gold">+ Add New</a>
                <a href="/Frontend/Admin/products/imports/" class="wp-page-title-action secondary">Import</a>
                <a href="/Frontend/Admin/products/exports/" class="wp-page-title-action secondary" onclick="window.exportCurrentTable('dt_products_catalog'); return false;">Export</a>
                <a href="/Frontend/Admin/products/categories/" class="wp-page-title-action secondary">Categories (16)</a>
                <a href="/Frontend/Admin/products/attributes/" class="wp-page-title-action secondary">Attributes</a>
            </div>

            <!-- 2. WordPress Status Views List (.subsubsub) -->
            <ul class="wp-subsubsub">
                <li><a href="#" class="current" onclick="filterWpProducts(''); return false;">All <span class="count">(1,240)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Active'); return false;">Published <span class="count">(1,185)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Draft'); return false;">Draft <span class="count">(14)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Low Stock'); return false;">Low stock <span class="count">(14)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Out of Stock'); return false;">Out of stock <span class="count">(41)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Featured'); return false;">Featured <span class="count">(48)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Best Seller'); return false;">Best Sellers <span class="count">(32)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('New Arrival'); return false;">New Arrivals <span class="count">(64)</span></a></li>
            </ul>

            <!-- 3. WordPress Top Toolbar (.tablenav .top) -->
            <div class="wp-tablenav">
                <div class="wp-tablenav-actions">
                    <select class="wp-select" id="wpBulkActionSelect">
                        <option value="">Bulk actions</option>
                        <option value="edit">Edit</option>
                        <option value="featured">Mark as featured</option>
                        <option value="unfeatured">Remove from featured</option>
                        <option value="trash">Move to Trash</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleWpBulkAction()">Apply</button>

                    <select class="wp-select" id="wpCategoryFilter" onchange="filterWpCategory(this.value)">
                        <option value="">Select a category</option>
                        <option value="Silk Sarees">Silk Sarees (420)</option>
                        <option value="Banarasi">Banarasi Brocade (280)</option>
                        <option value="Bridal Lehengas">Bridal Lehengas (160)</option>
                        <option value="Designer Kurtis">Designer Kurtis (240)</option>
                        <option value="Dress Materials">Dress Materials (140)</option>
                    </select>

                    <select class="wp-select" id="wpStockFilter" onchange="filterWpStock(this.value)">
                        <option value="">Filter by stock status</option>
                        <option value="In Stock">In stock</option>
                        <option value="Low Stock">Low stock</option>
                        <option value="Out of Stock">Out of stock</option>
                        <option value="Backorder">On backorder</option>
                    </select>

                    <select class="wp-select" id="wpBrandFilter" onchange="filterWpBrand(this.value)">
                        <option value="">Filter by brand</option>
                        <option value="DT Signature">DT Signature (680)</option>
                        <option value="Arniya Heritage">Arniya Heritage (420)</option>
                        <option value="DT Couture">DT Couture (140)</option>
                    </select>

                    <button type="button" class="wp-button" onclick="applyWpFilters()">Filter</button>
                </div>

                <div class="wp-search-box">
                    <input type="search" id="wpSearchInput" class="wp-search-input" placeholder="Search products, SKUs..." oninput="searchWpProducts(this.value)">
                    <button type="button" class="wp-button" onclick="searchWpProducts(document.getElementById('wpSearchInput').value)">Search Products</button>
                </div>
            </div>

            <!-- 4. WordPress / WooCommerce Products List Table -->
            <div class="wp-table-card">
                <table class="wp-list-table" id="wpProductsTable">
                    <thead>
                        <tr>
                            <th style="width: 32px; text-align: center;">
                                <input type="checkbox" onchange="toggleWpSelectAll(this)">
                            </th>
                            <th style="width: 50px;">Image</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Categories</th>
                            <th>Brand</th>
                            <th>Rating</th>
                            <th style="text-align: center;">★</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="wpProductsTableBody">
                        <!-- Row 1 -->
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="wp-row-check">
                            </td>
                            <td>
                                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-img" alt="Saree">
                            </td>
                            <td>
                                <a href="/Frontend/Admin/products/edit.php?id=101" class="wp-row-title">Kanjivaram Pure Silk Gold Zari Saree</a>
                                <div class="wp-row-actions">
                                    <a href="/Frontend/Admin/products/edit.php?id=101">Edit</a> |
                                    <a href="/Frontend/Admin/products/duplicate.php?id=101">Duplicate</a> |
                                    <a href="/Frontend/Admin/products/view.php?id=101">View</a> |
                                    <a href="#" onclick="window.shareProductWhatsApp(101); return false;" style="color:#15803D;">WhatsApp</a> |
                                    <a href="#" class="trash" onclick="window.showToast('Moved to Trash'); return false;">Trash</a>
                                </div>
                            </td>
                            <td><code>KLN-SR-111</code></td>
                            <td><span class="wp-stock-in">In stock (45)</span></td>
                            <td>
                                <strong>₹4,490</strong><br>
                                <small style="color:#8A681F;">Wholesale: ₹2,850</small>
                            </td>
                            <td><a href="/Frontend/Admin/products/categories/view.php?id=1">Silk Sarees</a></td>
                            <td><strong>DT Signature</strong></td>
                            <td><span style="color:#dba617; font-weight:700;">5.0 ★</span> (128)</td>
                            <td style="text-align: center;">
                                <button type="button" class="wp-star-btn active" title="Toggle Featured" onclick="this.classList.toggle('active')">★</button>
                            </td>
                            <td>
                                Published<br>
                                <small style="color:#646970;">2026/08/20</small>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="wp-row-check">
                            </td>
                            <td>
                                <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="wp-thumb-img" alt="Saree">
                            </td>
                            <td>
                                <a href="/Frontend/Admin/products/edit.php?id=102" class="wp-row-title">Banarasi Royal Brocade Weave Saree</a>
                                <div class="wp-row-actions">
                                    <a href="/Frontend/Admin/products/edit.php?id=102">Edit</a> |
                                    <a href="/Frontend/Admin/products/duplicate.php?id=102">Duplicate</a> |
                                    <a href="/Frontend/Admin/products/view.php?id=102">View</a> |
                                    <a href="#" onclick="window.shareProductWhatsApp(102); return false;" style="color:#15803D;">WhatsApp</a> |
                                    <a href="#" class="trash" onclick="window.showToast('Moved to Trash'); return false;">Trash</a>
                                </div>
                            </td>
                            <td><code>BNR-SR-204</code></td>
                            <td><span class="wp-stock-in">In stock (28)</span></td>
                            <td>
                                <strong>₹4,990</strong><br>
                                <small style="color:#8A681F;">Wholesale: ₹3,200</small>
                            </td>
                            <td><a href="/Frontend/Admin/products/categories/view.php?id=2">Banarasi Brocade</a></td>
                            <td><strong>Arniya Heritage</strong></td>
                            <td><span style="color:#dba617; font-weight:700;">4.9 ★</span> (94)</td>
                            <td style="text-align: center;">
                                <button type="button" class="wp-star-btn active" title="Toggle Featured" onclick="this.classList.toggle('active')">★</button>
                            </td>
                            <td>
                                Published<br>
                                <small style="color:#646970;">2026/08/19</small>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="wp-row-check">
                            </td>
                            <td>
                                <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="wp-thumb-img" alt="Lehenga">
                            </td>
                            <td>
                                <a href="/Frontend/Admin/products/edit.php?id=103" class="wp-row-title">Crimson Bridal Handcrafted Zardosi Lehenga</a>
                                <div class="wp-row-actions">
                                    <a href="/Frontend/Admin/products/edit.php?id=103">Edit</a> |
                                    <a href="/Frontend/Admin/products/duplicate.php?id=103">Duplicate</a> |
                                    <a href="/Frontend/Admin/products/view.php?id=103">View</a> |
                                    <a href="#" onclick="window.shareProductWhatsApp(103); return false;" style="color:#15803D;">WhatsApp</a> |
                                    <a href="#" class="trash" onclick="window.showToast('Moved to Trash'); return false;">Trash</a>
                                </div>
                            </td>
                            <td><code>BRD-LH-902</code></td>
                            <td><span class="wp-stock-low">Low stock (4)</span></td>
                            <td>
                                <strong>₹16,490</strong><br>
                                <small style="color:#8A681F;">Wholesale: ₹11,500</small>
                            </td>
                            <td><a href="/Frontend/Admin/products/categories/view.php?id=3">Bridal Lehengas</a></td>
                            <td><strong>DT Couture</strong></td>
                            <td><span style="color:#dba617; font-weight:700;">5.0 ★</span> (42)</td>
                            <td style="text-align: center;">
                                <button type="button" class="wp-star-btn" title="Toggle Featured" onclick="this.classList.toggle('active')">★</button>
                            </td>
                            <td>
                                Published<br>
                                <small style="color:#646970;">2026/08/18</small>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="wp-row-check">
                            </td>
                            <td>
                                <img src="/Shared/Asset/images/product4.png" onerror="this.src='/Frontend/Shop/Asset/images/product4.png';" class="wp-thumb-img" alt="Kurti">
                            </td>
                            <td>
                                <a href="/Frontend/Admin/products/edit.php?id=104" class="wp-row-title">Chanderi Foil Printed Festive Kurti Set</a>
                                <div class="wp-row-actions">
                                    <a href="/Frontend/Admin/products/edit.php?id=104">Edit</a> |
                                    <a href="/Frontend/Admin/products/duplicate.php?id=104">Duplicate</a> |
                                    <a href="/Frontend/Admin/products/view.php?id=104">View</a> |
                                    <a href="#" onclick="window.shareProductWhatsApp(104); return false;" style="color:#15803D;">WhatsApp</a> |
                                    <a href="#" class="trash" onclick="window.showToast('Moved to Trash'); return false;">Trash</a>
                                </div>
                            </td>
                            <td><code>KRT-CH-401</code></td>
                            <td><span class="wp-stock-in">In stock (62)</span></td>
                            <td>
                                <strong>₹2,290</strong><br>
                                <small style="color:#8A681F;">Wholesale: ₹1,450</small>
                            </td>
                            <td><a href="/Frontend/Admin/products/categories/view.php?id=4">Designer Kurtis</a></td>
                            <td><strong>DT Signature</strong></td>
                            <td><span style="color:#dba617; font-weight:700;">4.8 ★</span> (68)</td>
                            <td style="text-align: center;">
                                <button type="button" class="wp-star-btn active" title="Toggle Featured" onclick="this.classList.toggle('active')">★</button>
                            </td>
                            <td>
                                Published<br>
                                <small style="color:#646970;">2026/08/17</small>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- 5. WordPress Bottom Tablenav Pagination -->
                <div class="wp-tablenav-bottom">
                    <div class="wp-tablenav-actions">
                        <select class="wp-select">
                            <option value="">Bulk actions</option>
                            <option value="edit">Edit</option>
                            <option value="trash">Move to Trash</option>
                        </select>
                        <button type="button" class="wp-button" onclick="handleWpBulkAction()">Apply</button>
                    </div>

                    <div style="display:flex; align-items:center; gap:12px;">
                        <span>1,240 items</span>
                        <div class="wp-pagination-links">
                            <span class="wp-tablenav-pages-navspan" style="opacity:0.5;">«</span>
                            <span class="wp-tablenav-pages-navspan" style="opacity:0.5;">‹</span>
                            <span class="wp-page-number current">1</span>
                            <a href="#" class="wp-page-number">2</a>
                            <a href="#" class="wp-page-number">3</a>
                            <span style="padding:0 2px;">…</span>
                            <a href="#" class="wp-page-number">50</a>
                            <a href="#" class="wp-page-number">›</a>
                            <a href="#" class="wp-page-number">»</a>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script>
function toggleWpSelectAll(master) {
    document.querySelectorAll('.wp-row-check').forEach(cb => cb.checked = master.checked);
}

function filterWpProducts(status) {
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    document.querySelectorAll('.wp-subsubsub a').forEach(a => a.classList.remove('current'));
    if (event && event.target) event.target.classList.add('current');

    rows.forEach(r => {
        if (!status) {
            r.style.display = '';
        } else {
            r.style.display = r.textContent.toLowerCase().includes(status.toLowerCase()) ? '' : 'none';
        }
    });
    window.showToast('Filtering products: ' + (status || 'All'));
}

function searchWpProducts(q) {
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
}

function applyWpFilters() {
    const cat = document.getElementById('wpCategoryFilter')?.value || '';
    const stock = document.getElementById('wpStockFilter')?.value || '';
    const brand = document.getElementById('wpBrandFilter')?.value || '';
    
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    rows.forEach(r => {
        const text = r.textContent;
        const matchCat = !cat || text.includes(cat);
        const matchStock = !stock || text.includes(stock);
        const matchBrand = !brand || text.includes(brand);
        r.style.display = (matchCat && matchStock && matchBrand) ? '' : 'none';
    });
    window.showToast('Filters applied!');
}

function handleWpBulkAction() {
    const sel = document.getElementById('wpBulkActionSelect')?.value;
    if (!sel) {
        window.showToast('Please select a bulk action');
        return;
    }
    const checked = document.querySelectorAll('.wp-row-check:checked').length;
    if (checked === 0) {
        window.showToast('No products selected');
        return;
    }
    window.showToast(`Applied ${sel} to ${checked} selected products`);
}
</script>
</body>
</html>
