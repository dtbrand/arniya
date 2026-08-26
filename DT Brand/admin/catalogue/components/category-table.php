<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * category-table.php — Category Table Component
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$categoriesList = ProductCatalog::getCategoriesWithDetails();
$allProducts = ProductCatalog::getAll();
$totalCatCount = count($categoriesList);
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
            <span>Primary Categories (<?= $totalCatCount ?> Nodes)</span>
        </h3>
        <div style="display:flex; gap:6px; align-items:center;">
            <a href="/admin/catalogue/categories/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Add Category</span>
            </a>
            <a href="/admin/catalogue/categories/reorder.php" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="7 11 12 6 17 11"></polyline><polyline points="17 13 12 18 7 13"></polyline></svg>
                <span>Reorder</span>
            </a>
        </div>
    </div>

    <div class="dt-cat-table-wrap">
        <table class="dt-cat-table" id="catListTable">
            <thead>
                <tr>
                    <th style="width:30px; text-align:center;"><input type="checkbox" onchange="window.DT_CATALOGUE.toggleSelectAll(this, 'cat-row-chk')" style="cursor:pointer;"></th>
                    <th style="width:50px;">Image</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Subcategories</th>
                    <th>Products</th>
                    <th>Featured</th>
                    <th>Display Style</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoriesList as $idx => $cat): ?>
                    <?php
                    $catId = $cat['id'] ?? ($idx + 1);
                    $catName = $cat['name'] ?? 'Category';
                    $catSlug = $cat['slug'] ?? strtolower(str_replace(' ', '-', $catName));
                    $catImg = !empty($cat['image']) ? $cat['image'] : ('/assets/images/product' . (($idx % 6) + 1) . '.png');
                    
                    // Count real products matching this category
                    $matchingProds = count(array_filter($allProducts, function($p) use ($catName) {
                        return strtolower($p['category'] ?? '') === strtolower($catName);
                    }));
                    $skuDisplay = $matchingProds > 0 ? "{$matchingProds} SKUs" : "0 SKUs";
                    ?>
                    <tr id="cat-row-<?= $catId ?>" data-status="active">
                        <td style="text-align:center;"><input type="checkbox" class="cat-row-chk" value="<?= $catId ?>"></td>
                        <td><img src="<?= htmlspecialchars($catImg) ?>" onerror="this.src='/assets/images/product1.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #e2e8f0;"></td>
                        <td>
                            <a href="/admin/catalogue/categories/view.php?id=<?= $catId ?>" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;"><?= htmlspecialchars($catName) ?></a>
                            <div style="font-size:11px; color:#64748b; margin-top:2px;">Surat Central Depot Master Line</div>
                        </td>
                        <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;"><?= htmlspecialchars($catSlug) ?></code></td>
                        <td><span class="dt-badge blue">Direct Root</span></td>
                        <td><strong><?= $skuDisplay ?></strong></td>
                        <td><button type="button" class="wp-star-btn active" onclick="window.DT_CATEGORIES.toggleFeatured(this, <?= $catId ?>, '<?= addslashes($catName) ?>')">★</button></td>
                        <td><span class="dt-badge gold">Banner + Grid</span></td>
                        <td><span class="dt-badge green">Active</span></td>
                        <td style="text-align:right;">
                            <div style="display:inline-flex; gap:4px;">
                                <a href="/admin/catalogue/categories/view.php?id=<?= $catId ?>" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                                <a href="/admin/catalogue/categories/edit.php?id=<?= $catId ?>" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                                <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('cat-row-<?= $catId ?>', '<?= addslashes($catName) ?>')" style="height:24px; padding:0 6px;">✕</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Table Footer with Real Statistics -->
    <div class="dt-cat-card-footer" style="padding:10px 14px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; border-top:1px solid #e2e8f0; font-size:11.5px; color:#64748b;">
        <div>Showing <strong><?= $totalCatCount ?></strong> of <strong><?= $totalCatCount ?></strong> Primary Taxonomy Nodes</div>
        <div style="display:flex; gap:8px;">
            <a href="/admin/catalogue/hierarchy.php" class="dt-btn-action-sm pale-gold" style="height:26px; padding:0 10px; font-size:11px;">Open Tree Hierarchy</a>
            <a href="/admin/catalogue/collections.php" class="dt-btn-action-sm gold" style="height:26px; padding:0 10px; font-size:11px;">View Collections</a>
        </div>
    </div>
</div>
