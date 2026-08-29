<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * banners/edit.php — Edit Banner with Multi-Size & Mobile Engine
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Banner";
$active_nav = "catalogue";
$active_subnav = "banners";
$banner_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$banners_db = [
    1 => [
        'title' => 'Surat Heritage Silk Festival 2026',
        'subtitle' => 'Direct Surat Factory Wholesale Rates • Certified Silk Mark',
        'cta' => 'Explore Wholesale Catalogues',
        'link' => '/shop/silk-sarees',
        'desk_ratio' => '16-5',
        'mobile_ratio' => '1080-520',
        'slot' => 'Homepage Main Top Hero Slider',
        'visibility' => 'All Devices (Responsive Auto-Switch)',
        'priority' => 1,
        'status' => 'Active (Visible Live)',
        'desk_img' => '/assets/images/product1.png',
        'mobile_img' => '/assets/images/product2.png'
    ],
    2 => [
        'title' => 'Bridal Season Grandeur Spotlight',
        'subtitle' => 'Heavy Velvet Zardosi & Hand Embroidered Lehengas',
        'cta' => 'View Bridal Assortment',
        'link' => '/shop/bridal-lehengas',
        'desk_ratio' => '16-5',
        'mobile_ratio' => '1080-520',
        'slot' => 'Category Page Header Banner',
        'visibility' => 'All Devices (Responsive Auto-Switch)',
        'priority' => 2,
        'status' => 'Active (Visible Live)',
        'desk_img' => '/assets/images/product6.png',
        'mobile_img' => '/assets/images/product6.png'
    ]
];

$banner = isset($banners_db[$banner_id]) ? $banners_db[$banner_id] : $banners_db[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Banner: <?php echo htmlspecialchars($banner['title']); ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/banners.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Edit Banner: <?php echo htmlspecialchars($banner['title']); ?></h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Update desktop &amp; mobile banner assets, aspect ratios, and device targeting rules.</p>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/admin/catalogue/banners/" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 12px; font-size:11.5px; text-decoration:none;">Back to Banners</a>
                </div>
            </div>

            <form onsubmit="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Banner changes saved live!'); return false;" class="dt-form-grid">
                <!-- Left 2-Col Main Form -->
                <div>
                    <!-- 1. Banner Content & Headlines -->
                    <div class="dt-form-card">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; padding-bottom:8px; border-bottom:1px solid #f1f5f9;">
                            <h4 class="dt-form-card-title" style="margin:0; padding:0; border:none;">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <span>Banner Content &amp; Headlines</span>
                            </h4>
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_CATALOGUE.generateAiBannerCopy()" style="height:24px; padding:0 8px; font-size:10.5px;" title="AI Generate Catchy Headlines and CTA">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>AI Generate Copy</span>
                            </button>
                        </div>

                        <div class="dt-form-group">
                            <label class="dt-form-label" for="bannerTitle">Banner Title / Main Heading <span style="color:#DC2626;">*</span></label>
                            <input type="text" id="bannerTitle" class="dt-form-input" required value="<?php echo htmlspecialchars($banner['title']); ?>" placeholder="e.g. Surat Heritage Silk Festival 2026">
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                            <div class="dt-form-group">
                                <label class="dt-form-label" for="bannerSubtitle">Sub-Heading / Tagline</label>
                                <input type="text" id="bannerSubtitle" class="dt-form-input" value="<?php echo htmlspecialchars($banner['subtitle']); ?>" placeholder="e.g. Direct Surat Factory Wholesale Rates">
                            </div>
                            <div class="dt-form-group">
                                <label class="dt-form-label" for="bannerCta">Call to Action (CTA) Button</label>
                                <input type="text" id="bannerCta" class="dt-form-input" value="<?php echo htmlspecialchars($banner['cta']); ?>" placeholder="e.g. Explore Wholesale Catalogues">
                            </div>
                        </div>

                        <div class="dt-form-group">
                            <label class="dt-form-label" for="bannerLink">Destination Target URL</label>
                            <input type="text" id="bannerLink" class="dt-form-input" value="<?php echo htmlspecialchars($banner['link']); ?>" placeholder="e.g. /shop/silk-sarees">
                        </div>
                    </div>

                    <!-- 2. Dual Media Assets: Desktop + Mobile Uploaders -->
                    <div class="dt-form-card">
                        <h4 class="dt-form-card-title">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            <span>Desktop &amp; Mobile Responsive Media Uploads</span>
                        </h4>

                        <!-- Desktop Banner Frame -->
                        <div style="margin-bottom:16px; padding-bottom:14px; border-bottom:1px solid #f1f5f9;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                <label class="dt-form-label" style="margin:0;">🖥️ Desktop Banner Asset</label>
                                <span class="dt-size-pill desktop">Recommended: 1920 × 600 px (16:5)</span>
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:8px;">
                                <div class="dt-form-group" style="margin-bottom:0;">
                                    <label class="dt-form-label" style="font-size:10.5px; color:#64748b;">Desktop Aspect Ratio</label>
                                    <select class="dt-form-select" id="deskRatioSelect" onchange="window.DT_CATALOGUE.updateBannerRatio('desk', this.value)">
                                        <option value="16-5" <?php echo $banner['desk_ratio'] === '16-5' ? 'selected' : ''; ?>>1920 × 600 px (16:5 — Wide Hero Slider)</option>
                                        <option value="4-1" <?php echo $banner['desk_ratio'] === '4-1' ? 'selected' : ''; ?>>1920 × 450 px (4:1 — Category Top Strip)</option>
                                        <option value="12-5" <?php echo $banner['desk_ratio'] === '12-5' ? 'selected' : ''; ?>>1200 × 500 px (12:5 — Content Section)</option>
                                        <option value="1-1" <?php echo $banner['desk_ratio'] === '1-1' ? 'selected' : ''; ?>>1080 × 1080 px (1:1 — Square Grid Card)</option>
                                    </select>
                                </div>
                                <div class="dt-form-group" style="margin-bottom:0;">
                                    <label class="dt-form-label" style="font-size:10.5px; color:#64748b;">Desktop Text Alignment</label>
                                    <select class="dt-form-select">
                                        <option value="left" selected>Left Aligned Content</option>
                                        <option value="center">Center Aligned Content</option>
                                        <option value="right">Right Aligned Content</option>
                                    </select>
                                </div>
                            </div>
                            <div class="dt-upload-zone" onclick="document.getElementById('deskBannerUpload').click()" style="padding:12px;">
                                <img id="deskBannerPreview" src="<?php echo htmlspecialchars($banner['desk_img']); ?>" style="width:100%; height:90px; object-fit:cover; border-radius:4px; margin-bottom:6px; border:1px solid #e2e8f0;">
                                <input type="file" id="deskBannerUpload" style="display:none;" onchange="window.DT_CATALOGUE.previewImage(this, 'deskBannerPreview')">
                                <span style="font-size:11px; font-weight:700; color:#8A681F;">Click to Change Desktop Banner Image</span>
                            </div>
                        </div>

                        <!-- Mobile Banner Frame -->
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                <label class="dt-form-label" style="margin:0;">📱 Mobile Smartphone Banner Asset</label>
                                <span class="dt-size-pill mobile" id="mobileSizeTag">Selected: 1080 × 520 px (2:1)</span>
                            </div>
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:8px;">
                                <div class="dt-form-group" style="margin-bottom:0;">
                                    <label class="dt-form-label" style="font-size:10.5px; color:#64748b;">Mobile Aspect Ratio</label>
                                    <select class="dt-form-select" id="mobileRatioSelect" onchange="window.DT_CATALOGUE.updateBannerRatio('mobile', this.value)">
                                        <option value="1080-520" <?php echo $banner['mobile_ratio'] === '1080-520' ? 'selected' : ''; ?>>1080 × 520 px (2:1 — Meesho &amp; Flipkart App Style)</option>
                                        <option value="1080-600" <?php echo $banner['mobile_ratio'] === '1080-600' ? 'selected' : ''; ?>>1080 × 600 px (16:9 — Standard Mobile Landscape)</option>
                                        <option value="4-5" <?php echo $banner['mobile_ratio'] === '4-5' ? 'selected' : ''; ?>>1080 × 1350 px (4:5 — High-Impact Phone Hero)</option>
                                        <option value="1-1" <?php echo $banner['mobile_ratio'] === '1-1' ? 'selected' : ''; ?>>1080 × 1080 px (1:1 — Clean Square Carousel)</option>
                                        <option value="9-16" <?php echo $banner['mobile_ratio'] === '9-16' ? 'selected' : ''; ?>>1080 × 1920 px (9:16 — Full Screen Mobile Story)</option>
                                        <option value="2-1" <?php echo $banner['mobile_ratio'] === '2-1' ? 'selected' : ''; ?>>750 × 320 px (2.3:1 — Compact Mobile Header Strip)</option>
                                    </select>
                                </div>
                                <div class="dt-form-group" style="margin-bottom:0;">
                                    <label class="dt-form-label" style="font-size:10.5px; color:#64748b;">Mobile Behavior</label>
                                    <select class="dt-form-select">
                                        <option value="custom" selected>Use Dedicated Mobile Image</option>
                                        <option value="autocrop">Auto-Center Crop from Desktop</option>
                                    </select>
                                </div>
                            </div>
                            <div class="dt-upload-zone" onclick="document.getElementById('mobileBannerUpload').click()" style="padding:12px;">
                                <img id="mobileBannerPreview" src="<?php echo htmlspecialchars($banner['mobile_img']); ?>" style="width:100%; max-width:240px; height:110px; object-fit:cover; border-radius:6px; margin:0 auto 6px auto; display:block; border:1px solid #e2e8f0;">
                                <input type="file" id="mobileBannerUpload" style="display:none;" onchange="window.DT_CATALOGUE.previewImage(this, 'mobileBannerPreview')">
                                <span style="font-size:11px; font-weight:700; color:#8A681F;">Click to Change Dedicated Mobile Banner Image</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right 1-Col Sidebar Configuration & Live Preview -->
                <div>
                    <!-- Publish & Placement Settings -->
                    <div class="dt-form-card">
                        <h4 class="dt-form-card-title">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                            <span>Display Slot &amp; Targeting</span>
                        </h4>

                        <div class="dt-form-group">
                            <label class="dt-form-label">Banner Slot Position</label>
                            <select class="dt-form-select">
                                <option <?php echo $banner['slot'] === 'Homepage Main Top Hero Slider' ? 'selected' : ''; ?>>Homepage Main Top Hero Slider</option>
                                <option <?php echo $banner['slot'] === 'Category Page Header Banner' ? 'selected' : ''; ?>>Category Page Header Banner</option>
                                <option <?php echo $banner['slot'] === 'Collection Spotlight Banner' ? 'selected' : ''; ?>>Collection Spotlight Banner</option>
                                <option>Cart &amp; Checkout Top Offer Strip</option>
                                <option>WhatsApp Catalog Promo Card</option>
                                <option>Bottom Footer Promotional Ribbon</option>
                            </select>
                        </div>

                        <div class="dt-form-group">
                            <label class="dt-form-label">Device Visibility</label>
                            <select class="dt-form-select">
                                <option <?php echo $banner['visibility'] === 'All Devices (Responsive Auto-Switch)' ? 'selected' : ''; ?>>All Devices (Responsive Auto-Switch)</option>
                                <option <?php echo $banner['visibility'] === 'Desktop & Tablet Only' ? 'selected' : ''; ?>>Desktop &amp; Tablet Only</option>
                                <option <?php echo $banner['visibility'] === 'Mobile Only (Smartphones)' ? 'selected' : ''; ?>>Mobile Only (Smartphones)</option>
                            </select>
                        </div>

                        <div class="dt-form-group">
                            <label class="dt-form-label">Sort Priority Order</label>
                            <input type="number" class="dt-form-input" value="<?php echo htmlspecialchars($banner['priority']); ?>" min="1" max="99">
                        </div>

                        <div class="dt-form-group">
                            <label class="dt-form-label">Status</label>
                            <select class="dt-form-select">
                                <option selected>Active (Visible Live)</option>
                                <option>Scheduled</option>
                                <option>Draft / Hidden</option>
                            </select>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:8px; margin-top:16px;">
                            <button type="submit" class="dt-btn-action-sm gold" style="height:36px; justify-content:center; font-size:12px; font-weight:800;">Save Changes</button>
                            <a href="/admin/catalogue/banners/" class="dt-btn-action-sm pale-gold" style="height:32px; justify-content:center; font-size:11.5px; text-decoration:none;">Cancel</a>
                        </div>
                    </div>

                    <!-- Live Device Preview Simulator -->
                    <div class="dt-form-card">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <h4 class="dt-form-card-title" style="margin:0; padding:0; border:none;">Live Preview</h4>
                            <div class="dt-device-switcher">
                                <button type="button" class="dt-device-btn" id="btnPrevDesk" onclick="window.DT_CATALOGUE.switchDevicePreview('desk')">🖥️ Desk</button>
                                <button type="button" class="dt-device-btn active" id="btnPrevMob" onclick="window.DT_CATALOGUE.switchDevicePreview('mob')">📱 Mobile</button>
                            </div>
                        </div>

                        <!-- Desktop View Container -->
                        <div id="prevBoxDesk" style="display:none; width:100%; border:1px solid #e2e8f0; border-radius:6px; overflow:hidden; background:#181512;">
                            <img src="<?php echo htmlspecialchars($banner['desk_img']); ?>" id="liveDeskImg" style="width:100%; height:90px; object-fit:cover; display:block;">
                        </div>

                        <!-- Authentic Mobile Phone View Container -->
                        <div id="prevBoxMob" style="padding:6px 0;">
                            <div class="dt-mobile-phone-device">
                                <div class="dt-mobile-phone-notch"></div>
                                <div class="dt-mobile-app-header">
                                    <span>👑 DT BRAND'S</span>
                                    <span style="font-size:8px; background:#D4AF37; color:#181512; padding:1px 4px; border-radius:3px;">SURAT B2B</span>
                                </div>
                                <div class="dt-mobile-banner-slot" id="mobBannerSlot">
                                    <img src="<?php echo htmlspecialchars($banner['mobile_img']); ?>" id="liveMobImg" alt="Mobile Banner">
                                </div>
                                <div class="dt-mobile-banner-dots">
                                    <span class="dt-mobile-dot active"></span>
                                    <span class="dt-mobile-dot"></span>
                                    <span class="dt-mobile-dot"></span>
                                </div>
                                <div class="dt-mobile-mini-body">
                                    <div style="font-size:9px; font-weight:800; color:#181512; margin-bottom:4px;">🔥 SURAT READY STOCK LOTS</div>
                                    <div class="dt-mobile-mini-grid">
                                        <div class="dt-mobile-mini-card">
                                            <img src="/assets/images/product1.png">
                                            <div style="font-size:8px; font-weight:700; color:#15803D;">₹2,850 <small style="color:#64748b;">(Wholesale)</small></div>
                                        </div>
                                        <div class="dt-mobile-mini-card">
                                            <img src="/assets/images/product3.png">
                                            <div style="font-size:8px; font-weight:700; color:#15803D;">₹3,200 <small style="color:#64748b;">(Wholesale)</small></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
</body>
</html>
