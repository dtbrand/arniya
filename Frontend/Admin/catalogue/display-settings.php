<?php
/**
 * display-settings.php — Storefront Display Settings & Visual Architecture Studio
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */
$page_title = "Display Settings";
$active_nav = "catalogue";
$active_subnav = "display";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storefront Display Settings ‹ DT Brand's Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/display-settings.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <!-- Page Header Toolbar -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Storefront Display Settings</h1>
                        <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:2px 8px;">Visual Architecture</span>
                    </div>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Customize grid densities, image aspect ratios, wholesale badges, and sidebar filters across the shop.</p>
                </div>
                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="resetDisplayDefaults()" style="height:32px; padding:0 12px; font-size:11.5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                        <span>Reset Defaults</span>
                    </button>
                    <a href="/Frontend/Shop/shop.php" target="_blank" class="dt-btn-action-sm pale-gold" style="height:32px; padding:0 12px; font-size:11.5px; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        <span>View Live Shop</span>
                    </a>
                    <button type="button" class="dt-btn-action-sm gold" onclick="saveDisplaySettings()" style="height:32px; padding:0 14px; font-size:11.5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Save Display Settings</span>
                    </button>
                </div>
            </div>

            <!-- Display Settings Main Panel Component -->
            <?php include_once __DIR__ . '/components/display-settings-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/catalogue/assets/js/display-settings.js?v=<?php echo time(); ?>"></script>
</body>
</html>
