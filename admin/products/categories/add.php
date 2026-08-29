<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * Add Category — DT Brand's & Jai Hanuman Tex
 *
 * This page used to be a picture of a form. There was no <form>, none of the
 * five inputs had an id or a name, and the Save button's entire behaviour was
 * onclick="window.showToast('Category created successfully!')" — so a category
 * typed here was never sent anywhere, and the admin was told it had been
 * created.
 *
 * It also offered an "HSN Tax Slab" select (5007 / 6204 / 5208) and a "Parent
 * Taxonomy" select (None / Silk Sarees / Kurtis & Sets). `categories` has no
 * hsn column and no parent_id column, and those two option lists were typed by
 * hand rather than read from anywhere, so both are gone.
 *
 * Every field below maps to a real column: name, slug, description, image,
 * banner_image, display_order, status. Saving is handled by
 * assets/js/categories.js -> window.saveCategory(), which posts to
 * /api/categories.php and only reports success when the server says so.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/Database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/ProductCatalog.php';

$page_title = "Add Category";
$active_nav = "products";

// Next free position, so the new category does not silently land at 0.
$catNextOrder = 0;
foreach (\DTBrand\ProductCatalog::getCategoriesWithDetails(false) as $c) {
    $catNextOrder = max($catNextOrder, (int)($c['display_order'] ?? 0));
}
$catNextOrder++;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/categories.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Add New Category</span></h1>
                    <p>Name it, give it a photo, and it appears in the shop filters and in the product form.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/admin/products/categories/" class="adm-btn-secondary">Cancel</a>
                    <button type="button" class="adm-btn-primary" data-dt-cat-save onclick="saveCategory()">Save Category</button>
                </div>
            </div>

            <input type="hidden" id="catMode" value="create">
            <input type="hidden" id="catId" value="0">

            <div class="adm-card">
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="catName">Category Name *</label>
                        <input type="text" id="catName" class="adm-form-input" placeholder="e.g. Bandhani Sarees" autocomplete="off">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="catSlug">URL Slug</label>
                        <input type="text" id="catSlug" class="adm-form-input" placeholder="bandhani-sarees" autocomplete="off">
                        <small style="color:#8a8a8a;">jaihanumantex.in/shop.php?category=<b id="catSlugLive">...</b> — left blank, it is built from the name.</small>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="catStatus">Status</label>
                        <select id="catStatus" class="adm-form-select">
                            <option value="active" selected>Active — shown in the shop</option>
                            <option value="inactive">Inactive — hidden from the shop</option>
                        </select>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="catOrder">Display Order</label>
                        <input type="number" id="catOrder" class="adm-form-input" min="0" step="1" value="<?php echo (int)$catNextOrder; ?>">
                        <small style="color:#8a8a8a;">Lower numbers come first in the shop filter list.</small>
                    </div>
                    <div class="adm-form-group full">
                        <label class="adm-form-label" for="catDesc">Category Description</label>
                        <textarea id="catDesc" class="adm-form-textarea" rows="3" placeholder="Shown on the shop catalogue header for this category."></textarea>
                    </div>
                </div>
            </div>

            <div class="adm-card">
                <h3 style="font-family:'Cinzel',serif;margin:0 0 4px;">Category Photos</h3>
                <p style="color:#8a8a8a;margin:0 0 18px;font-size:13px;">Each file is uploaded to the server as soon as you pick it, and the stored path is what gets saved. The preview only changes once the upload succeeds.</p>
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="catImageFile">Thumbnail</label>
                        <img id="catImagePreview" src="" alt="" style="display:none;max-width:180px;border-radius:10px;margin-bottom:10px;">
                        <input type="file" id="catImageFile" class="adm-form-input" accept="image/jpeg,image/png,image/webp,image/gif">
                        <input type="hidden" id="catImage" value="">
                        <small id="catImagePreviewNote" style="color:#8a8a8a;word-break:break-all;">No thumbnail uploaded yet.</small>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label" for="catBannerFile">Banner</label>
                        <img id="catBannerPreview" src="" alt="" style="display:none;max-width:260px;border-radius:10px;margin-bottom:10px;">
                        <input type="file" id="catBannerFile" class="adm-form-input" accept="image/jpeg,image/png,image/webp,image/gif">
                        <input type="hidden" id="catBanner" value="">
                        <small id="catBannerPreviewNote" style="color:#8a8a8a;word-break:break-all;">No banner uploaded yet.</small>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/products/assets/js/categories.js?v=<?php echo time(); ?>"></script>
</body>
</html>
