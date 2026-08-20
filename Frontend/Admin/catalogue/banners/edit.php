<?php
/**
 * banners/edit.php — Edit Banner
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Banner";
$active_nav = "catalogue";
$active_subnav = "banners";
$banner_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Banner ‹ DT Brand's Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/categories.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Edit Banner: Kanjivaram Festive Header</h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Update image assets, redirect destinations, and active campaign timings.</p>
                </div>
            </div>

            <form onsubmit="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Banner updated live!'); return false;" class="dt-form-grid">
                <div>
                    <div class="dt-form-card">
                        <h4 class="dt-form-card-title">Banner Information</h4>
                        <div class="dt-form-group">
                            <label class="dt-form-label">Banner Title <span style="color:#DC2626;">*</span></label>
                            <input type="text" class="dt-form-input" value="Kanjivaram Festive Header" required>
                        </div>
                        <div class="dt-form-group">
                            <label class="dt-form-label">Target Link URL</label>
                            <input type="text" class="dt-form-input" value="/shop/silk-sarees">
                        </div>
                        <div class="dt-form-group">
                            <label class="dt-form-label">CTA Button Text</label>
                            <input type="text" class="dt-form-input" value="Explore Wholesale Lot">
                        </div>
                    </div>

                    <div class="dt-form-card">
                        <h4 class="dt-form-card-title">Media Uploads</h4>
                        <div class="dt-form-group">
                            <label class="dt-form-label">Desktop Image (1920x600 px)</label>
                            <div class="dt-upload-zone" onclick="document.getElementById('bDeskUp').click()">
                                <img id="bDeskPreview" src="/Frontend/Shop/Asset/images/product1.png" style="width:100%; height:80px; object-fit:cover; border-radius:4px; margin-bottom:8px;">
                                <input type="file" id="bDeskUp" style="display:none;" onchange="window.DT_CATALOGUE.previewImage(this, 'bDeskPreview')">
                                <span style="font-size:11px; font-weight:700; color:#8A681F;">Click to Change Desktop Banner</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="dt-form-card">
                        <h4 class="dt-form-card-title">Placement &amp; Status</h4>
                        <div class="dt-form-group">
                            <label class="dt-form-label">Banner Position</label>
                            <select class="dt-form-select">
                                <option selected>Homepage Main Hero</option>
                                <option>Category Top Header</option>
                                <option>Mid-Page Promotional Ribbon</option>
                            </select>
                        </div>
                        <div style="display:flex; flex-direction:column; gap:8px; margin-top:14px;">
                            <button type="submit" class="dt-btn-action-sm gold" style="height:34px; justify-content:center; font-size:12px;">Update Banner</button>
                            <a href="/Frontend/Admin/catalogue/banners/" class="dt-btn-action-sm pale-gold" style="height:32px; justify-content:center; font-size:11.5px; text-decoration:none;">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
</body>
</html>
