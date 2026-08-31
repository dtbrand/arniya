<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * edit.php — Edit Category
 * DT Brand's & Jai Hanuman Tex
 *
 * What this page used to do:
 *   - $cat_id defaulted to 1, so /categories/edit.php with no id silently opened
 *     and offered to overwrite whichever category happened to be first.
 *   - The description textarea hardcoded "Pure Mulberry & Kanjivaram Bridal
 *     Silks with 24K Gold Zari Weaves direct from Surat factory central looms."
 *     for every category, and saving pushed that sentence into the database.
 *   - The thumbnail was always /assets/images/product1.png, and picking a file
 *     only set a FileReader data: URL on the <img>, which handleSaveCategory()
 *     then posted as `image` — categories.image is VARCHAR(255), so the value
 *     was truncated and the photo silently disappeared.
 *   - "+ Choose Banner" only toasted 'Banner upload modal opened'.
 *   - Parent Category, Display Type, HSN Code and the two SEO boxes have no
 *     columns in `categories`; they were dropped server-side while the page
 *     reported everything saved. autoGenerateCatSeo() invented the copy.
 *   - The B2B panel read "420 SKUs / Rs 18.40 Lakhs / 3,200 Units Ready / +36%
 *     Profit" for every category, and "View Products in Category (420)" linked
 *     to a hardcoded ?cat=silk-sarees.
 *   - A stray </div> after the Parent Category group broke the two-column grid.
 *
 * Everything below is either a real column or a real count. Saving and deleting
 * are handled by assets/js/categories.js, which posts to /api/categories.php.
 */
require_once __DIR__ . '/../../../src/Database.php';
require_once __DIR__ . '/../../../src/ProductCatalog.php';
use DTBrand\Database;
use DTBrand\ProductCatalog;

$page_title = "Edit Category";
$active_nav = "products";
$active_subnav = "categories";

$cat_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = null;
$dbDown = false;

if ($cat_id > 0) {
    $db = Database::getConnection();
    if ($db === null || Database::isMockMode()) {
        $dbDown = true;
    } else {
        try {
            $stmt = $db->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
            $stmt->execute([$cat_id]);
            $category = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        } catch (\Exception $e) {
            $dbDown = true;
        }
    }
}

// No silent fallback to category #1: a bad or missing id is reported as such.
if (!$category) {
    http_response_code($dbDown ? 503 : 404);
    $ceMsg = $dbDown
        ? 'The database is not reachable, so this category could not be loaded.'
        : ($cat_id > 0
            ? 'Category #' . $cat_id . ' does not exist. It may already have been deleted.'
            : 'No category id was given, so there is nothing to edit.');
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Category not found</title>';
    echo '<link rel="stylesheet" href="/admin/assets/css/admin.css"></head><body>';
    echo '<div style="max-width:560px;margin:80px auto;padding:28px;border:1.5px solid #D4AF37;border-radius:10px;font-family:system-ui,sans-serif;">';
    echo '<h1 style="font-size:20px;margin:0 0 10px;">Category not found</h1>';
    echo '<p style="color:#646970;">' . htmlspecialchars($ceMsg) . '</p>';
    echo '<p><a href="/admin/products/categories/">Back to product categories</a></p>';
    echo '</div></body></html>';
    exit;
}

$catName   = (string)($category['name'] ?? '');
$catSlug   = (string)($category['slug'] ?? '');
$catDesc   = (string)($category['description'] ?? '');
$catStatus = strtolower(trim((string)($category['status'] ?? 'active')));
if (!in_array($catStatus, ['active', 'inactive'], true)) { $catStatus = 'active'; }
$catOrder  = (int)($category['display_order'] ?? 0);
$catCreated = (string)($category['created_at'] ?? '');

// The seeded categories.image / banner_image DEFAULTs point at files that do not
// exist in this docroot, so they are treated as "no image set" rather than shown
// as a broken thumbnail.
$ceClean = static function ($v): string {
    $v = trim((string)$v);
    if ($v === '' || preg_match('#(category-sarees|hero-banner|product1)\.png$#i', $v)) { return ''; }
    if (stripos($v, 'data:') === 0) { return ''; }
    return $v;
};
$catImg = $ceClean($category['image'] ?? '');
$catBanner = $ceClean($category['banner_image'] ?? '');

// The real number, counted from products. categories.products_count is seeded
// with numbers like 840 and no write path maintains it.
$catCount = ProductCatalog::categoryProductCount($cat_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category &lsaquo; <?php echo htmlspecialchars($catName); ?> &lsaquo; DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-edit-grid { display:grid; grid-template-columns:1fr 340px; gap:18px; align-items:start; }
    @media (max-width:1024px) { .dt-edit-grid { grid-template-columns:1fr; } }
    .dt-card { background:#fff; border:1.5px solid rgba(212,175,55,0.4); border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-bottom:18px; }
    .dt-card-header { background:radial-gradient(ellipse at 20% 50%, rgba(212,175,55,0.35) 0%, transparent 60%), linear-gradient(135deg,#261C0E 0%,#3A2C12 40%,#2A2010 75%,#18120A 100%); padding:12px 16px; color:#fff; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37; }
    .dt-card-body { padding:16px; }
    .dt-form-group { margin-bottom:14px; }
    .dt-form-group label { display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px; }
    .dt-form-input, .dt-form-select, .dt-form-textarea { width:100%; height:34px; padding:0 10px; font-size:12.5px; color:#181512; background:#fff; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box; outline:none; transition:all .15s ease; }
    .dt-form-textarea { height:80px; padding:8px 10px; resize:vertical; }
    .dt-form-input:focus, .dt-form-select:focus, .dt-form-textarea:focus { border-color:#8A681F; box-shadow:0 0 0 1px #8A681F, 0 0 8px rgba(212,175,55,0.25); }
    .dt-kpi-item { display:flex; justify-content:space-between; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f1f5f9; font-size:12px; }
    .dt-kpi-item:last-child { border-bottom:none; }
    .dt-hint { color:#646970; font-size:11px; margin-top:3px; display:block; }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding:16px 20px;">
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Edit Category</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px;">ID: #<?php echo (int)$cat_id; ?></span>
                    <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; font-size:11px;"><?php echo htmlspecialchars($catName); ?></span>
                    <span class="adm-badge" style="background:<?php echo $catCount > 0 ? '#DCFCE7' : '#F3F4F6'; ?>; color:<?php echo $catCount > 0 ? '#15803D' : '#646970'; ?>; font-weight:700; font-size:11px;"><?php echo $catCount . ' product' . ($catCount === 1 ? '' : 's'); ?></span>
                </div>
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/products/categories/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; font-size:12px; font-weight:600; text-decoration:none;">Product Categories</a>
                    <a href="/shop?category=<?php echo urlencode($catSlug); ?>" target="_blank" rel="noopener" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; font-size:12px; font-weight:600; text-decoration:none;">View on Shop</a>
                    <button type="button" class="wp-button primary" data-dt-cat-save onclick="saveCategory()" style="background:linear-gradient(135deg,#B8860B 0%,#D4AF37 50%,#E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; box-shadow:0 2px 8px rgba(212,175,55,0.35);">Save &amp; Update Category</button>
                </div>
            </div>

            <input type="hidden" id="catMode" value="update">
            <input type="hidden" id="catId" value="<?php echo (int)$cat_id; ?>">

            <div class="dt-edit-grid">
                <div>
                    <div class="dt-card">
                        <div class="dt-card-header">
                            <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Category Details</h3>
                        </div>
                        <div class="dt-card-body">
                            <div class="dt-form-group">
                                <label for="catName">Category Name <span style="color:#b32d2e;">*</span></label>
                                <input type="text" id="catName" class="dt-form-input" value="<?php echo htmlspecialchars($catName); ?>" autocomplete="off">
                                <small class="dt-hint">Renaming also re-labels the <?php echo $catCount; ?> product(s) filed under this category.</small>
                            </div>
                            <div class="dt-form-group">
                                <label for="catSlug">URL Slug</label>
                                <input type="text" id="catSlug" class="dt-form-input" value="<?php echo htmlspecialchars($catSlug); ?>" autocomplete="off">
                                <div style="margin-top:4px; font-size:11px; color:#8A681F;">
                                    <strong>Shop URL:</strong> <code>https://jaihanumantex.in/shop?category=<span id="catSlugLive"><?php echo htmlspecialchars($catSlug); ?></span></code>
                                </div>
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                                <div class="dt-form-group">
                                    <label for="catStatus">Status</label>
                                    <select id="catStatus" class="dt-form-select">
                                        <option value="active" <?php echo $catStatus === 'active' ? 'selected' : ''; ?>>Active &mdash; shown in the shop</option>
                                        <option value="inactive" <?php echo $catStatus === 'inactive' ? 'selected' : ''; ?>>Inactive &mdash; hidden from the shop</option>
                                    </select>
                                </div>
                                <div class="dt-form-group">
                                    <label for="catOrder">Display Order</label>
                                    <input type="number" id="catOrder" class="dt-form-input" min="0" step="1" value="<?php echo (int)$catOrder; ?>">
                                    <small class="dt-hint">Lower numbers come first.</small>
                                </div>
                            </div>
                            <div class="dt-form-group" style="margin-bottom:0;">
                                <label for="catDesc">Category Description</label>
                                <textarea id="catDesc" class="dt-form-textarea" rows="4" placeholder="Shown on the shop catalogue header for this category."><?php echo htmlspecialchars($catDesc); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="dt-card">
                        <div class="dt-card-header">
                            <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Category Photos</h3>
                        </div>
                        <div class="dt-card-body">
                            <p style="color:#646970; font-size:12px; margin:0 0 14px;">Each file is uploaded to the server the moment you pick it, and the stored path is what gets saved. The preview only changes once the upload succeeds.</p>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                                <div>
                                    <label style="font-size:12px; font-weight:700; display:block; margin-bottom:6px;" for="catImageFile">Thumbnail</label>
                                    <img id="catImagePreview" src="<?php echo htmlspecialchars($catImg); ?>" alt="" style="<?php echo $catImg === '' ? 'display:none;' : ''; ?>width:100px; height:100px; object-fit:cover; border-radius:6px; border:1.5px solid #D4AF37; margin-bottom:8px;">
                                    <input type="file" id="catImageFile" accept="image/jpeg,image/png,image/webp,image/gif" style="font-size:12px;">
                                    <input type="hidden" id="catImage" value="<?php echo htmlspecialchars($catImg); ?>">
                                    <small id="catImagePreviewNote" class="dt-hint" style="word-break:break-all;"><?php echo $catImg !== '' ? htmlspecialchars($catImg) : 'No thumbnail set.'; ?></small>
                                </div>
                                <div>
                                    <label style="font-size:12px; font-weight:700; display:block; margin-bottom:6px;" for="catBannerFile">Hero Banner</label>
                                    <img id="catBannerPreview" src="<?php echo htmlspecialchars($catBanner); ?>" alt="" style="<?php echo $catBanner === '' ? 'display:none;' : ''; ?>width:100%; max-width:240px; border-radius:6px; border:1.5px solid #D4AF37; margin-bottom:8px;">
                                    <input type="file" id="catBannerFile" accept="image/jpeg,image/png,image/webp,image/gif" style="font-size:12px;">
                                    <input type="hidden" id="catBanner" value="<?php echo htmlspecialchars($catBanner); ?>">
                                    <small id="catBannerPreviewNote" class="dt-hint" style="word-break:break-all;"><?php echo $catBanner !== '' ? htmlspecialchars($catBanner) : 'No banner set. Recommended 1200 x 400 px.'; ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="dt-card">
                        <div class="dt-card-header">
                            <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">This Category</h3>
                        </div>
                        <div class="dt-card-body" style="padding:12px 16px;">
                            <div class="dt-kpi-item">
                                <span style="color:#646970;">Products filed here</span>
                                <strong style="color:#181512; font-size:13px;"><?php echo $catCount; ?></strong>
                            </div>
                            <div class="dt-kpi-item">
                                <span style="color:#646970;">Status</span>
                                <strong style="color:<?php echo $catStatus === 'active' ? '#15803D' : '#646970'; ?>; font-size:13px;"><?php echo ucfirst($catStatus); ?></strong>
                            </div>
                            <div class="dt-kpi-item">
                                <span style="color:#646970;">Display order</span>
                                <strong style="color:#181512; font-size:13px;"><?php echo (int)$catOrder; ?></strong>
                            </div>
                            <div class="dt-kpi-item">
                                <span style="color:#646970;">Created</span>
                                <strong style="color:#181512; font-size:13px;"><?php echo $catCreated !== '' ? htmlspecialchars(date('d M Y', strtotime($catCreated))) : 'Not recorded'; ?></strong>
                            </div>
                            <p style="color:#646970; font-size:11px; margin:10px 0 0;">Stock value and resale margin are not stored per category, so they are not shown here. This panel used to read 420 SKUs / &#8377;18.40 Lakhs / 3,200 Units / +36% for every category.</p>
                        </div>
                    </div>

                    <div class="dt-card">
                        <div class="dt-card-header">
                            <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Actions</h3>
                        </div>
                        <div class="dt-card-body">
                            <button type="button" class="wp-button primary" data-dt-cat-save onclick="saveCategory()" style="width:100%; height:36px; background:linear-gradient(135deg,#B8860B 0%,#D4AF37 50%,#E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; margin-bottom:8px;">Save Changes</button>
                            <a href="/admin/products/" class="wp-button" style="width:100%; height:32px; display:inline-flex; align-items:center; justify-content:center; text-decoration:none; margin-bottom:8px; font-size:12px;">Open the product list</a>
                            <button type="button" class="wp-button" style="width:100%; height:30px; justify-content:center; color:#b32d2e; border-color:#fca5a5; font-size:11.5px;" onclick="dtCatDelete(<?php echo (int)$cat_id; ?>)">Delete Category</button>
                            <?php if ($catCount > 0): ?>
                                <small class="dt-hint">Deletion is refused while <?php echo $catCount; ?> product(s) are still filed here. Move them to another category first.</small>
                            <?php else: ?>
                                <small class="dt-hint">No products are filed here, so this category can be deleted.</small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="dt-card">
                        <div class="dt-card-header">
                            <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Not Stored</h3>
                        </div>
                        <div class="dt-card-body" style="font-size:12px; color:#646970;">
                            <p style="margin:0 0 8px;">A category row holds only its name, URL, description, two photos, its order and its status.</p>
                            <p style="margin:0;">Parent category, display type, an HSN/GST class and separate SEO meta text have no columns, so those boxes were removed rather than left looking saved. HSN and GST are handled at order level (5% GST), and the shop page title is built from the category name.</p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/products/assets/js/categories.js?v=<?php echo time(); ?>"></script>
</body>
</html>

