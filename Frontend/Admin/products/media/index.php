<?php
/**
 * media/index.php — DT Brand's Master Product Media & CDN Asset Studio
 * Wholesale Dashboard & Luxury Shop Standard
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Media Library";
$active_nav = "products";
$active_subnav = "media";

$media_assets = [
    [
        'id' => 1,
        'filename' => 'kanjivaram-heritage-gold-pure-silk.webp',
        'title' => 'Kanjivaram Heritage Pure Silk Saree',
        'category' => 'Kanjivaram Silk',
        'type' => 'Product Photo',
        'sku' => 'KJV-GLD-101',
        'size' => '245 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product1.png',
        'date' => '20 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/kanjivaram-heritage-gold.webp'
    ],
    [
        'id' => 2,
        'filename' => 'banarasi-royal-maroon-zari-brocade.webp',
        'title' => 'Royal Banarasi Katan Silk Brocade',
        'category' => 'Banarasi Brocade',
        'type' => 'Model Shoot',
        'sku' => 'BNR-MRN-204',
        'size' => '312 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product2.png',
        'date' => '19 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/banarasi-royal-maroon.webp'
    ],
    [
        'id' => 3,
        'filename' => 'bridal-zardosi-lehenga-choli-crimson.webp',
        'title' => 'Handcrafted Bridal Zardosi Velvet Lehenga',
        'category' => 'Bridal Luxury',
        'type' => 'Model Shoot',
        'sku' => 'BDL-LHG-305',
        'size' => '420 KB',
        'dim' => '1800 × 2400',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product3.png',
        'date' => '18 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/bridal-zardosi-crimson.webp'
    ],
    [
        'id' => 4,
        'filename' => 'paithani-silk-emerald-peacock-pallu.webp',
        'title' => 'Authentic Yeola Paithani Silk Peacock Pallu',
        'category' => 'Paithani Silk',
        'type' => 'Fabric Zoom 10x',
        'sku' => 'PTH-EMR-408',
        'size' => '198 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product4.png',
        'date' => '17 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/paithani-peacock-pallu.webp'
    ],
    [
        'id' => 5,
        'filename' => 'chanderi-cotton-silk-pastel-mint.webp',
        'title' => 'Chanderi Handloom Cotton Silk Saree',
        'category' => 'Chanderi Handloom',
        'type' => 'Product Photo',
        'sku' => 'CHD-MNT-512',
        'size' => '165 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product5.png',
        'date' => '16 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/chanderi-cotton-mint.webp'
    ],
    [
        'id' => 6,
        'filename' => 'surat-jacquard-weaving-close-texture.webp',
        'title' => 'Surat Jacquard Gold Zari Weave Swatch',
        'category' => 'Fabric Swatches',
        'type' => 'Fabric Zoom 10x',
        'sku' => 'SWT-ZRI-001',
        'size' => '280 KB',
        'dim' => '2000 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product6.png',
        'date' => '15 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/surat-jacquard-texture.webp'
    ],
    [
        'id' => 7,
        'filename' => 'tussar-georgette-printed-floral-saree.webp',
        'title' => 'Tussar Georgette Botanical Floral Print',
        'category' => 'Georgette Silk',
        'type' => 'Product Photo',
        'sku' => 'TSR-FLR-709',
        'size' => '210 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product7.png',
        'date' => '14 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/tussar-georgette-floral.webp'
    ],
    [
        'id' => 8,
        'filename' => 'organza-tissue-silk-rose-gold-zari.webp',
        'title' => 'Organza Tissue Silk Sheer Festive Saree',
        'category' => 'Organza Tissue',
        'type' => 'Model Shoot',
        'sku' => 'ORG-RSG-814',
        'size' => '195 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product8.png',
        'date' => '13 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/organza-rose-gold.webp'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Media Library ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
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
    .dt-media-gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
    }
    .dt-media-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .dt-media-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 6px 18px rgba(212,175,55,0.2);
        transform: translateY(-2px);
    }
    .dt-media-card-img-wrap {
        width: 100%;
        height: 200px;
        background: #FDFBF7;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .dt-media-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .dt-media-card:hover .dt-media-card-img {
        transform: scale(1.05);
    }
    .dt-media-badge-format {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(24,21,18,0.85);
        color: #D4AF37;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 6px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }
    .dt-media-badge-size {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(255,255,255,0.92);
        color: #15803D;
        font-size: 10.5px;
        font-weight: 800;
        padding: 3px 6px;
        border-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    .dt-media-card-content {
        padding: 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .dt-media-actions-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 10px;
        border-top: 1px solid #f1f5f9;
        margin-top: 10px;
    }
    .dt-media-btn-pill {
        height: 26px;
        padding: 0 8px;
        font-size: 11px;
        font-weight: 700;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.15s ease;
    }
    .dt-media-btn-pill:hover {
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

            <!-- 1. Header Toolbar with Gold Master Actions -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Product Media Library</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">480 High-Res Assets</span>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px;">🟢 CDN Live</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/Frontend/Admin/products/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Products</span>
                    </a>
                    <button type="button" class="wp-button" onclick="optimizeAllMedia()" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#1D4ED8" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Auto WebP Optimize</span>
                    </button>
                    <button type="button" class="wp-button primary" onclick="openUploadModal()" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 16px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Upload Media</span>
                    </button>
                </div>
            </div>

            <!-- 2. B2B Wholesale CDN KPI Metrics Ribbon -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:14px;">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">TOTAL MEDIA ASSETS</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">480 High-Res</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">LINKED CATALOG SKUS</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">1,240 Products</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">WEBP OPTIMIZATION</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">84% Saved (1.8 GB)</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">SURAT CDN STORAGE</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">2.4 GB / 50 GB</div>
                    </div>
                </div>
            </div>

            <!-- 3. Top Toolbar: Bulk Actions & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="mediaBulkActionSelect" style="height:34px; font-size:12px; min-width:140px;">
                        <option value="">Bulk actions</option>
                        <option value="optimize">Optimize to WebP</option>
                        <option value="download">Download ZIP</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleMediaBulkAction()" style="height:34px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>

                    <select class="wp-select" id="mediaTypeFilter" onchange="filterMediaByType(this.value)" style="height:34px; font-size:12px; min-width:150px;">
                        <option value="">All Media Types</option>
                        <option value="Product Photo">Product Photos</option>
                        <option value="Model Shoot">Model Shoots</option>
                        <option value="Fabric Zoom">Fabric Zoom 10x</option>
                    </select>

                    <select class="wp-select" id="mediaCategoryFilter" onchange="filterMediaByCategory(this.value)" style="height:34px; font-size:12px; min-width:160px;">
                        <option value="">All Categories</option>
                        <option value="Kanjivaram Silk">Kanjivaram Silk</option>
                        <option value="Banarasi Brocade">Banarasi Brocade</option>
                        <option value="Bridal Luxury">Bridal Luxury</option>
                        <option value="Paithani Silk">Paithani Silk</option>
                    </select>
                </div>

                <!-- Mandatory Left-Aligned Search Icon with 1-Tap Clear Button -->
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2" style="position:absolute; left:12px; pointer-events:none;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="mediaSearchInput" class="wp-search-input" placeholder="Search filename, SKU, category..." style="height:34px; padding-left:36px; padding-right:28px; width:240px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchMedia(this.value); toggleMediaSearchClearBtn(this.value)">
                        <span id="mediaSearchClearBtn" onclick="clearMediaSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchMedia(document.getElementById('mediaSearchInput').value)" style="height:34px; font-size:12px; font-weight:800; padding:0 14px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; border:1px solid #8A681F;">Search</button>
                </div>
            </div>

            <!-- 4. High-Craft Product Media Grid -->
            <div class="dt-media-gallery-grid" id="mediaGridContainer">
                <?php foreach($media_assets as $asset): ?>
                <div class="dt-media-card" data-category="<?php echo htmlspecialchars($asset['category']); ?>" data-type="<?php echo htmlspecialchars($asset['type']); ?>" data-title="<?php echo htmlspecialchars($asset['title'] . ' ' . $asset['filename'] . ' ' . $asset['sku']); ?>">
                    <div class="dt-media-card-img-wrap">
                        <img src="<?php echo htmlspecialchars($asset['img']); ?>" alt="<?php echo htmlspecialchars($asset['title']); ?>" class="dt-media-card-img" onerror="this.src='/Shared/Asset/images/product1.png';">
                        <span class="dt-media-badge-format"><?php echo htmlspecialchars($asset['format']); ?></span>
                        <span class="dt-media-badge-size"><?php echo htmlspecialchars($asset['size']); ?></span>
                    </div>
                    <div class="dt-media-card-content">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                                <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:10px; font-weight:700; padding:1px 6px;"><?php echo htmlspecialchars($asset['sku']); ?></span>
                                <span style="font-size:11px; color:#646970;"><?php echo htmlspecialchars($asset['dim']); ?></span>
                            </div>
                            <strong style="font-size:12.5px; color:#181512; display:block; line-height:1.3; margin-bottom:4px;"><?php echo htmlspecialchars($asset['title']); ?></strong>
                            <span style="font-size:11px; color:#8c8f94; font-family:monospace; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo htmlspecialchars($asset['filename']); ?></span>
                        </div>
                        
                        <div class="dt-media-actions-bar">
                            <button type="button" class="dt-media-btn-pill" onclick="openLightbox('<?php echo htmlspecialchars($asset['img']); ?>', '<?php echo htmlspecialchars($asset['title']); ?>', '<?php echo htmlspecialchars($asset['sku']); ?>', '<?php echo htmlspecialchars($asset['dim']); ?>', '<?php echo htmlspecialchars($asset['size']); ?>', '<?php echo htmlspecialchars($asset['cdn_url']); ?>')" style="background:#EFF6FF; border-color:#93C5FD; color:#1D4ED8;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <span>Preview</span>
                            </button>
                            <button type="button" class="dt-media-btn-pill" onclick="copyCdnUrl('<?php echo htmlspecialchars($asset['cdn_url']); ?>')" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                <span>Copy CDN</span>
                            </button>
                            <button type="button" class="dt-media-btn-pill" onclick="deleteMediaCard(this, '<?php echo htmlspecialchars($asset['title']); ?>')" style="background:#FEF2F2; border-color:#FECACA; color:#DC2626;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: DRAG & DROP MEDIA UPLOADER                        -->
<!-- ======================================================== -->
<div id="uploadMediaModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:560px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#D4AF37" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <h3 style="margin:0; font-size:15px; font-weight:800; color:#FAF5E8;">B2B Bulk Media Uploader &amp; CDN Optimizer</h3>
            </div>
            <button type="button" onclick="closeUploadModal()" style="background:none; border:none; color:#FAF5E8; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:20px;">
            <div id="dragDropZone" style="border:2px dashed #D4AF37; background:#FAF5E8; border-radius:8px; padding:30px 20px; text-align:center; cursor:pointer; transition:all 0.2s ease;" onclick="document.getElementById('realMediaFileInput').click()">
                <svg viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#8A681F" stroke-width="2" style="margin-bottom:10px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <strong style="display:block; font-size:14px; color:#181512; margin-bottom:4px;">Drag and drop product images here</strong>
                <span style="font-size:12px; color:#646970;">or <span style="color:#8A681F; text-decoration:underline; font-weight:700;">browse files from your device</span></span>
                <small style="display:block; margin-top:8px; color:#8c8f94; font-size:11px;">Supported: WEBP, PNG, JPG, TIFF (Max 25MB each). Auto-converts to WebP 1600px.</small>
            </div>
            <input type="file" id="realMediaFileInput" style="display:none;" multiple accept="image/*" onchange="handleNewMediaFiles(this)">

            <div style="margin-top:16px;">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;">
                    <label style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#181512; cursor:pointer;">
                        <input type="checkbox" checked style="accent-color:#8A681F;">
                        <span>Auto-compress to WebP (Saves 80%+ Bandwidth)</span>
                    </label>
                </div>
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <label style="display:flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#181512; cursor:pointer;">
                        <input type="checkbox" checked style="accent-color:#8A681F;">
                        <span>Auto-generate 10x Fabric Zoom Crop</span>
                    </label>
                </div>
            </div>
        </div>
        <div style="background:#f6f7f7; padding:14px 20px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeUploadModal()" style="height:34px; font-size:12px; font-weight:700; padding:0 14px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="document.getElementById('realMediaFileInput').click()" style="height:34px; font-size:12px; font-weight:800; padding:0 18px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; border:1px solid #8A681F; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <span>Select &amp; Upload Files</span>
            </button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: IMAGE LIGHTBOX & METADATA PREVIEW                 -->
<!-- ======================================================== -->
<div id="mediaLightboxModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.85); backdrop-filter:blur(8px); z-index:99999999; align-items:center; justify-content:center;" onclick="closeLightbox()">
    <div style="background:#fff; width:90%; max-width:840px; border-radius:10px; overflow:hidden; display:grid; grid-template-columns:1fr 300px; box-shadow:0 25px 50px rgba(0,0,0,0.5); border:2px solid #D4AF37;" onclick="event.stopPropagation();">
        <div style="background:#181512; display:flex; align-items:center; justify-content:center; padding:20px; min-height:400px;">
            <img id="lightboxImg" src="" style="max-width:100%; max-height:480px; object-fit:contain; border-radius:4px; box-shadow:0 4px 20px rgba(0,0,0,0.6);">
        </div>
        <div style="padding:20px; display:flex; flex-direction:column; justify-content:space-between; background:#ffffff;">
            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <span class="adm-badge gold" id="lightboxSku">SKU</span>
                    <button type="button" onclick="closeLightbox()" style="background:none; border:none; font-size:20px; cursor:pointer; color:#646970;">&times;</button>
                </div>
                <h3 id="lightboxTitle" style="margin:0 0 10px 0; font-size:15px; font-weight:800; color:#181512; line-height:1.3;">Title</h3>
                <div style="font-size:12px; color:#646970; margin-bottom:6px;">Dimensions: <strong id="lightboxDim" style="color:#181512;">1600 × 2000</strong></div>
                <div style="font-size:12px; color:#646970; margin-bottom:14px;">File Size: <strong id="lightboxSize" style="color:#15803D;">245 KB</strong></div>
                <div style="margin-bottom:14px;">
                    <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:4px;">CDN Direct URL</label>
                    <input type="text" id="lightboxCdnUrl" readonly style="width:100%; height:32px; font-size:11px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px; background:#f6f7f7; color:#646970;">
                </div>
            </div>
            <div>
                <button type="button" class="wp-button" onclick="copyCdnUrl(document.getElementById('lightboxCdnUrl').value)" style="width:100%; height:34px; justify-content:center; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    <span>Copy CDN Link</span>
                </button>
                <button type="button" class="wp-button primary" onclick="closeLightbox()" style="width:100%; height:34px; justify-content:center; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F;">
                    Done
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function toggleMediaSearchClearBtn(val) {
    const btn = document.getElementById('mediaSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearMediaSearch() {
    const input = document.getElementById('mediaSearchInput');
    if (input) {
        input.value = '';
        toggleMediaSearchClearBtn('');
        searchMedia('');
        input.focus();
    }
}

function searchMedia(q) {
    const cards = document.querySelectorAll('.dt-media-card');
    const term = (q || '').toLowerCase().trim();
    cards.forEach(c => {
        const title = (c.getAttribute('data-title') || '').toLowerCase();
        c.style.display = title.includes(term) ? '' : 'none';
    });
}

function filterMediaByType(type) {
    const cards = document.querySelectorAll('.dt-media-card');
    cards.forEach(c => {
        if (!type) {
            c.style.display = '';
        } else {
            const cardType = c.getAttribute('data-type') || '';
            c.style.display = cardType.includes(type) ? '' : 'none';
        }
    });
}

function filterMediaByCategory(cat) {
    const cards = document.querySelectorAll('.dt-media-card');
    cards.forEach(c => {
        if (!cat) {
            c.style.display = '';
        } else {
            const cardCat = c.getAttribute('data-category') || '';
            c.style.display = cardCat.includes(cat) ? '' : 'none';
        }
    });
}

function openUploadModal() {
    const m = document.getElementById('uploadMediaModal');
    if (m) m.style.display = 'flex';
}

function closeUploadModal() {
    const m = document.getElementById('uploadMediaModal');
    if (m) m.style.display = 'none';
}

function handleNewMediaFiles(input) {
    if (input.files && input.files.length > 0) {
        closeUploadModal();
        if (typeof window.showToast === 'function') {
            window.showToast(`✨ ${input.files.length} high-res images uploaded & converted to WebP!`);
        }
    }
}

function optimizeAllMedia() {
    if (typeof window.showToast === 'function') {
        window.showToast('⚡ WebP optimization engine completed: 480 assets synchronized with Surat CDN!');
    }
}

function handleMediaBulkAction() {
    const action = document.getElementById('mediaBulkActionSelect')?.value;
    if (!action) return;
    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Bulk action "${action}" executed on media assets!`);
    }
}

function copyCdnUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        if (typeof window.showToast === 'function') window.showToast('📋 CDN URL copied to clipboard!');
    });
}

function deleteMediaCard(btn, title) {
    if (confirm(`Move "${title}" to media trash?`)) {
        const card = btn.closest('.dt-media-card');
        if (card) card.remove();
        if (typeof window.showToast === 'function') window.showToast('🗑️ Asset moved to trash');
    }
}

function openLightbox(img, title, sku, dim, size, cdn) {
    document.getElementById('lightboxImg').src = img;
    document.getElementById('lightboxTitle').textContent = title;
    document.getElementById('lightboxSku').textContent = sku;
    document.getElementById('lightboxDim').textContent = dim;
    document.getElementById('lightboxSize').textContent = size;
    document.getElementById('lightboxCdnUrl').value = cdn;
    const m = document.getElementById('mediaLightboxModal');
    if (m) m.style.display = 'flex';
}

function closeLightbox() {
    const m = document.getElementById('mediaLightboxModal');
    if (m) m.style.display = 'none';
}
</script>
</body>
</html>
