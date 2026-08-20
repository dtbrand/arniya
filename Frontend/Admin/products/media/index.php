<?php
/**
 * media/index.php — DT Brand's Master Product Media & CDN Asset Studio
 * Wholesale Dashboard & Luxury Shop Standard (4, 6, 7, 8 Column & List Density Modes)
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
    ],
    [
        'id' => 9,
        'filename' => 'patola-double-ikkat-gujarat-heritage.webp',
        'title' => 'Patan Patola Double Ikkat Silk Masterpiece',
        'category' => 'Patola Silk',
        'type' => 'Product Photo',
        'sku' => 'PTL-IKT-901',
        'size' => '320 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product1.png',
        'date' => '12 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/patola-double-ikkat.webp'
    ],
    [
        'id' => 10,
        'filename' => 'bandhani-gharchola-bridal-red-silk.webp',
        'title' => 'Jaipur Bandhani Gharchola Zari Checked Saree',
        'category' => 'Bandhani Craft',
        'type' => 'Model Shoot',
        'sku' => 'BDH-GHR-902',
        'size' => '275 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product2.png',
        'date' => '11 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/bandhani-gharchola.webp'
    ],
    [
        'id' => 11,
        'filename' => 'surat-pure-crepe-digital-foil-print.webp',
        'title' => 'Surat Pure Crepe Digital Foil Weave Saree',
        'category' => 'Crepe Silk',
        'type' => 'Product Photo',
        'sku' => 'CRP-FOL-903',
        'size' => '220 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product3.png',
        'date' => '10 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/crepe-digital-foil.webp'
    ],
    [
        'id' => 12,
        'filename' => 'uppada-jamdani-fine-cotton-pastel.webp',
        'title' => 'Uppada Jamdani Fine Handwoven Silk Saree',
        'category' => 'Uppada Silk',
        'type' => 'Fabric Zoom 10x',
        'sku' => 'UPD-JMD-904',
        'size' => '185 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product4.png',
        'date' => '09 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/uppada-jamdani.webp'
    ],
    [
        'id' => 13,
        'filename' => 'gadwal-silk-contrast-zari-kaddi.webp',
        'title' => 'Gadwal Handloom Silk Contrast Kaddi Border',
        'category' => 'Gadwal Silk',
        'type' => 'Product Photo',
        'sku' => 'GDW-SLK-905',
        'size' => '260 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product5.png',
        'date' => '08 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/gadwal-silk.webp'
    ],
    [
        'id' => 14,
        'filename' => 'mysore-crepe-silk-solid-gold-embossed.webp',
        'title' => 'Mysore Crepe Silk Gold Zari Embossed Saree',
        'category' => 'Mysore Silk',
        'type' => 'Model Shoot',
        'sku' => 'MYS-CRP-906',
        'size' => '240 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product6.png',
        'date' => '07 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/mysore-crepe.webp'
    ],
    [
        'id' => 15,
        'filename' => 'pochampally-ikkat-geometric-weave.webp',
        'title' => 'Pochampally Handloom Ikkat Geometric Weave',
        'category' => 'Pochampally Ikkat',
        'type' => 'Fabric Zoom 10x',
        'sku' => 'PCH-IKT-907',
        'size' => '215 KB',
        'dim' => '1600 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product7.png',
        'date' => '06 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/pochampally-ikkat.webp'
    ],
    [
        'id' => 16,
        'filename' => 'surat-central-mill-depot-lot-dispatch.webp',
        'title' => 'Surat Central Depot Master Lot Ready Dispatch',
        'category' => 'Surat Depot Lots',
        'type' => 'Product Photo',
        'sku' => 'SRT-LOT-908',
        'size' => '350 KB',
        'dim' => '2000 × 2000',
        'format' => 'WEBP',
        'img' => '/Frontend/Shop/Asset/images/product8.png',
        'date' => '05 Aug 2026',
        'cdn_url' => 'https://cdn.jaihanumantex.in/media/products/surat-depot-lot.webp'
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
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    
    /* ── DENSITY GRID MODES (4, 6, 7, 8 Columns) ── */
    .dt-media-gallery-grid {
        display: grid;
        gap: 12px;
        transition: all 0.2s ease;
    }
    .dt-media-gallery-grid.grid-cols-4 {
        grid-template-columns: repeat(4, 1fr);
    }
    .dt-media-gallery-grid.grid-cols-6 {
        grid-template-columns: repeat(6, 1fr);
    }
    .dt-media-gallery-grid.grid-cols-7 {
        grid-template-columns: repeat(7, 1fr);
    }
    .dt-media-gallery-grid.grid-cols-8 {
        grid-template-columns: repeat(8, 1fr);
    }
    
    @media (max-width: 1400px) {
        .dt-media-gallery-grid.grid-cols-8 { grid-template-columns: repeat(6, 1fr); }
        .dt-media-gallery-grid.grid-cols-7 { grid-template-columns: repeat(5, 1fr); }
    }
    @media (max-width: 1100px) {
        .dt-media-gallery-grid.grid-cols-8,
        .dt-media-gallery-grid.grid-cols-7,
        .dt-media-gallery-grid.grid-cols-6 { grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width: 768px) {
        .dt-media-gallery-grid.grid-cols-8,
        .dt-media-gallery-grid.grid-cols-7,
        .dt-media-gallery-grid.grid-cols-6,
        .dt-media-gallery-grid.grid-cols-4 { grid-template-columns: repeat(2, 1fr); }
    }

    .dt-media-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .dt-media-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 14px rgba(212,175,55,0.2);
        transform: translateY(-2px);
    }
    .dt-media-card-img-wrap {
        width: 100%;
        height: 140px;
        background: #FDFBF7;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .grid-cols-6 .dt-media-card-img-wrap { height: 120px; }
    .grid-cols-7 .dt-media-card-img-wrap { height: 105px; }
    .grid-cols-8 .dt-media-card-img-wrap { height: 95px; }

    .dt-media-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .dt-media-card:hover .dt-media-card-img {
        transform: scale(1.06);
    }
    .dt-media-badge-format {
        position: absolute;
        top: 5px;
        left: 5px;
        background: rgba(24,21,18,0.85);
        color: #D4AF37;
        font-size: 9px;
        font-weight: 800;
        padding: 2px 5px;
        border-radius: 3px;
        backdrop-filter: blur(4px);
    }
    .dt-media-badge-size {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255,255,255,0.92);
        color: #15803D;
        font-size: 9.5px;
        font-weight: 800;
        padding: 2px 5px;
        border-radius: 3px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .dt-media-card-content {
        padding: 8px 10px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .dt-media-actions-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 6px;
        border-top: 1px solid #f1f5f9;
        margin-top: 6px;
    }
    .dt-media-btn-pill {
        height: 24px;
        padding: 0 6px;
        font-size: 10.5px;
        font-weight: 700;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: all 0.15s ease;
    }
    .dt-media-btn-pill:hover {
        transform: translateY(-1px);
    }
    
    /* Active Density Switcher Button */
    .dt-density-btn {
        height: 32px;
        padding: 0 10px;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: 4px;
        border: 1px solid #c3c4c7;
        background: #ffffff;
        color: #181512;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
    }
    .dt-density-btn.active {
        background: #FAF5E8;
        border-color: #D4AF37;
        color: #8A681F;
        font-weight: 800;
        box-shadow: 0 1px 4px rgba(212,175,55,0.2);
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px;">

            <!-- 1. Header Toolbar with Gold Master Actions & Density Switcher -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:21px; font-weight:800; color:#181512; margin:0;">Product Media Library</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">480 Assets</span>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px;">🟢 CDN Ready</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    
                    <!-- Density Mode Buttons (4, 6, 7, 8 Columns) -->
                    <div style="display:inline-flex; border-radius:6px; background:#fff; border:1px solid #c3c4c7; padding:2px; gap:2px;">
                        <button type="button" class="dt-density-btn active" id="btn-cols-4" onclick="setGridDensity(4)" title="4 Columns Standard">4</button>
                        <button type="button" class="dt-density-btn" id="btn-cols-6" onclick="setGridDensity(6)" title="6 Columns Medium">6</button>
                        <button type="button" class="dt-density-btn" id="btn-cols-7" onclick="setGridDensity(7)" title="7 Columns High Density">7</button>
                        <button type="button" class="dt-density-btn" id="btn-cols-8" onclick="setGridDensity(8)" title="8 Columns Maximum Density">8</button>
                        <button type="button" class="dt-density-btn" id="btn-cols-list" onclick="setGridDensity('list')" title="List Table View" style="padding:0 8px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            <span>List</span>
                        </button>
                    </div>

                    <a href="/Frontend/Admin/products/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openUploadModal()" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Upload</span>
                    </button>
                </div>
            </div>

            <!-- 2. B2B Wholesale CDN KPI Metrics Ribbon -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:10px; margin-bottom:12px;">
                <div class="dt-kpi-card">
                    <div style="width:32px; height:32px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#646970; font-weight:700;">MEDIA ASSETS</div>
                        <div style="font-size:15px; font-weight:800; color:#181512;">480 High-Res</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:32px; height:32px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#646970; font-weight:700;">ASSIGNED SKUS</div>
                        <div style="font-size:15px; font-weight:800; color:#15803D;">1,240 Products</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:32px; height:32px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#646970; font-weight:700;">WEBP OPTIMIZED</div>
                        <div style="font-size:15px; font-weight:800; color:#1D4ED8;">84% Saved (1.8 GB)</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:32px; height:32px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:10px; color:#646970; font-weight:700;">SURAT CDN STORAGE</div>
                        <div style="font-size:15px; font-weight:800; color:#B45309;">2.4 GB / 50 GB</div>
                    </div>
                </div>
            </div>

            <!-- 3. Top Toolbar: Bulk Actions & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <select class="wp-select" id="mediaBulkActionSelect" style="height:32px; font-size:12px; min-width:130px;">
                        <option value="">Bulk actions</option>
                        <option value="optimize">Optimize to WebP</option>
                        <option value="download">Download ZIP</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleMediaBulkAction()" style="height:32px; font-size:11.5px; font-weight:700; padding:0 10px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>

                    <select class="wp-select" id="mediaTypeFilter" onchange="filterMediaByType(this.value)" style="height:32px; font-size:12px; min-width:130px;">
                        <option value="">All Media Types</option>
                        <option value="Product Photo">Product Photos</option>
                        <option value="Model Shoot">Model Shoots</option>
                        <option value="Fabric Zoom">Fabric Zoom 10x</option>
                    </select>

                    <select class="wp-select" id="mediaCategoryFilter" onchange="filterMediaByCategory(this.value)" style="height:32px; font-size:12px; min-width:140px;">
                        <option value="">All Categories</option>
                        <option value="Kanjivaram">Kanjivaram Silk</option>
                        <option value="Banarasi">Banarasi Brocade</option>
                        <option value="Bridal">Bridal Luxury</option>
                        <option value="Paithani">Paithani Silk</option>
                    </select>
                </div>

                <!-- Mandatory Left-Aligned Search Icon with 1-Tap Clear Button -->
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2" style="position:absolute; left:10px; pointer-events:none;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="mediaSearchInput" class="wp-search-input" placeholder="Search SKU, filename..." style="height:32px; padding-left:32px; padding-right:26px; width:210px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchMedia(this.value); toggleMediaSearchClearBtn(this.value)">
                        <span id="mediaSearchClearBtn" onclick="clearMediaSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:12px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchMedia(document.getElementById('mediaSearchInput').value)" style="height:32px; font-size:12px; font-weight:800; padding:0 12px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; border:1px solid #8A681F;">Search</button>
                </div>
            </div>

            <!-- 4. High-Craft Product Media Grid (Configurable 4, 6, 7, 8 Cols) -->
            <div class="dt-media-gallery-grid grid-cols-4" id="mediaGridContainer">
                <?php foreach($media_assets as $asset): ?>
                <div class="dt-media-card" data-category="<?php echo htmlspecialchars($asset['category']); ?>" data-type="<?php echo htmlspecialchars($asset['type']); ?>" data-title="<?php echo htmlspecialchars($asset['title'] . ' ' . $asset['filename'] . ' ' . $asset['sku']); ?>">
                    <div class="dt-media-card-img-wrap">
                        <img src="<?php echo htmlspecialchars($asset['img']); ?>" alt="<?php echo htmlspecialchars($asset['title']); ?>" class="dt-media-card-img" onerror="this.src='/Shared/Asset/images/product1.png';">
                        <span class="dt-media-badge-format"><?php echo htmlspecialchars($asset['format']); ?></span>
                        <span class="dt-media-badge-size"><?php echo htmlspecialchars($asset['size']); ?></span>
                    </div>
                    <div class="dt-media-card-content">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:3px;">
                                <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:9.5px; font-weight:800; padding:1px 5px;"><?php echo htmlspecialchars($asset['sku']); ?></span>
                                <span style="font-size:10px; color:#646970;"><?php echo htmlspecialchars($asset['dim']); ?></span>
                            </div>
                            <strong style="font-size:11.5px; color:#181512; display:block; line-height:1.25; margin-bottom:2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo htmlspecialchars($asset['title']); ?></strong>
                            <span style="font-size:10px; color:#8c8f94; font-family:monospace; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?php echo htmlspecialchars($asset['filename']); ?></span>
                        </div>
                        
                        <div class="dt-media-actions-bar">
                            <button type="button" class="dt-media-btn-pill" onclick="openLightbox('<?php echo htmlspecialchars($asset['img']); ?>', '<?php echo htmlspecialchars($asset['title']); ?>', '<?php echo htmlspecialchars($asset['sku']); ?>', '<?php echo htmlspecialchars($asset['dim']); ?>', '<?php echo htmlspecialchars($asset['size']); ?>', '<?php echo htmlspecialchars($asset['cdn_url']); ?>')" style="background:#EFF6FF; border-color:#93C5FD; color:#1D4ED8;">
                                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <span>View</span>
                            </button>
                            <button type="button" class="dt-media-btn-pill" onclick="copyCdnUrl('<?php echo htmlspecialchars($asset['cdn_url']); ?>')" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;">
                                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                <span>Copy</span>
                            </button>
                            <button type="button" class="dt-media-btn-pill" onclick="deleteMediaCard(this, '<?php echo htmlspecialchars($asset['title']); ?>')" style="background:#FEF2F2; border-color:#FECACA; color:#DC2626;">
                                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- 5. List Table View (Hidden by default, toggled via Density Switcher) -->
            <div id="mediaListContainer" style="display:none; background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width:36px; text-align:center; padding:8px;"><input type="checkbox"></th>
                            <th style="width:50px; padding:8px;">Thumb</th>
                            <th style="padding:8px 10px;">File Name &amp; Title</th>
                            <th style="padding:8px 10px;">Linked SKU</th>
                            <th style="padding:8px 10px;">Category</th>
                            <th style="padding:8px 10px;">Dimensions</th>
                            <th style="padding:8px 10px;">Size</th>
                            <th style="padding:8px 10px;">Format</th>
                            <th style="width:130px; text-align:right; padding:8px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($media_assets as $asset): ?>
                        <tr style="border-bottom:1px solid #f0f0f1;">
                            <td style="text-align:center; padding:8px;"><input type="checkbox"></td>
                            <td style="padding:6px 8px;">
                                <img src="<?php echo htmlspecialchars($asset['img']); ?>" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #D4AF37;">
                            </td>
                            <td style="padding:8px 10px;">
                                <strong style="font-size:12.5px; color:#181512; display:block;"><?php echo htmlspecialchars($asset['title']); ?></strong>
                                <span style="font-size:11px; color:#646970; font-family:monospace;"><?php echo htmlspecialchars($asset['filename']); ?></span>
                            </td>
                            <td style="padding:8px 10px;">
                                <span class="adm-badge gold" style="font-size:10px; font-weight:700;"><?php echo htmlspecialchars($asset['sku']); ?></span>
                            </td>
                            <td style="padding:8px 10px; font-size:12px; color:#181512;"><?php echo htmlspecialchars($asset['category']); ?></td>
                            <td style="padding:8px 10px; font-size:11.5px; color:#646970;"><?php echo htmlspecialchars($asset['dim']); ?></td>
                            <td style="padding:8px 10px; font-size:11.5px; color:#15803D; font-weight:700;"><?php echo htmlspecialchars($asset['size']); ?></td>
                            <td style="padding:8px 10px;"><span class="adm-badge" style="background:#181512; color:#D4AF37; font-size:9.5px; font-weight:800;"><?php echo htmlspecialchars($asset['format']); ?></span></td>
                            <td style="padding:8px 12px; text-align:right;">
                                <div style="display:flex; gap:4px; justify-content:flex-end;">
                                    <button type="button" class="dt-media-btn-pill" onclick="openLightbox('<?php echo htmlspecialchars($asset['img']); ?>', '<?php echo htmlspecialchars($asset['title']); ?>', '<?php echo htmlspecialchars($asset['sku']); ?>', '<?php echo htmlspecialchars($asset['dim']); ?>', '<?php echo htmlspecialchars($asset['size']); ?>', '<?php echo htmlspecialchars($asset['cdn_url']); ?>')" style="background:#EFF6FF; border-color:#93C5FD; color:#1D4ED8;">View</button>
                                    <button type="button" class="dt-media-btn-pill" onclick="copyCdnUrl('<?php echo htmlspecialchars($asset['cdn_url']); ?>')" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;">Copy</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: DRAG & DROP MEDIA UPLOADER                        -->
<!-- ======================================================== -->
<div id="uploadMediaModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:540px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#D4AF37" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <h3 style="margin:0; font-size:15px; font-weight:800; color:#FAF5E8;">B2B Bulk Media Uploader &amp; CDN Optimizer</h3>
            </div>
            <button type="button" onclick="closeUploadModal()" style="background:none; border:none; color:#FAF5E8; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:20px;">
            <div id="dragDropZone" style="border:2px dashed #D4AF37; background:#FAF5E8; border-radius:8px; padding:26px 18px; text-align:center; cursor:pointer;" onclick="document.getElementById('realMediaFileInput').click()">
                <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="#8A681F" stroke-width="2" style="margin-bottom:8px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <strong style="display:block; font-size:14px; color:#181512; margin-bottom:3px;">Drag and drop product images here</strong>
                <span style="font-size:12px; color:#646970;">or <span style="color:#8A681F; text-decoration:underline; font-weight:700;">browse files from your device</span></span>
                <small style="display:block; margin-top:6px; color:#8c8f94; font-size:10.5px;">Auto-converts to WebP 1600px with 10x Swatch Crop.</small>
            </div>
            <input type="file" id="realMediaFileInput" style="display:none;" multiple accept="image/*" onchange="handleNewMediaFiles(this)">
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeUploadModal()" style="height:32px; font-size:11.5px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="document.getElementById('realMediaFileInput').click()" style="height:32px; font-size:11.5px; font-weight:800; padding:0 16px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; border:1px solid #8A681F; display:inline-flex; align-items:center; gap:6px;">
                <span>Select &amp; Upload Files</span>
            </button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: IMAGE LIGHTBOX & METADATA PREVIEW                 -->
<!-- ======================================================== -->
<div id="mediaLightboxModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.85); backdrop-filter:blur(8px); z-index:99999999; align-items:center; justify-content:center;" onclick="closeLightbox()">
    <div style="background:#fff; width:90%; max-width:800px; border-radius:10px; overflow:hidden; display:grid; grid-template-columns:1fr 280px; box-shadow:0 25px 50px rgba(0,0,0,0.5); border:2px solid #D4AF37;" onclick="event.stopPropagation();">
        <div style="background:#181512; display:flex; align-items:center; justify-content:center; padding:16px; min-height:360px;">
            <img id="lightboxImg" src="" style="max-width:100%; max-height:440px; object-fit:contain; border-radius:4px;">
        </div>
        <div style="padding:18px; display:flex; flex-direction:column; justify-content:space-between; background:#ffffff;">
            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <span class="adm-badge gold" id="lightboxSku">SKU</span>
                    <button type="button" onclick="closeLightbox()" style="background:none; border:none; font-size:20px; cursor:pointer; color:#646970;">&times;</button>
                </div>
                <h3 id="lightboxTitle" style="margin:0 0 8px 0; font-size:14px; font-weight:800; color:#181512; line-height:1.3;">Title</h3>
                <div style="font-size:11.5px; color:#646970; margin-bottom:4px;">Dimensions: <strong id="lightboxDim" style="color:#181512;">1600 × 2000</strong></div>
                <div style="font-size:11.5px; color:#646970; margin-bottom:12px;">File Size: <strong id="lightboxSize" style="color:#15803D;">245 KB</strong></div>
                <div style="margin-bottom:12px;">
                    <label style="font-size:11px; font-weight:700; color:#181512; display:block; margin-bottom:3px;">CDN Direct URL</label>
                    <input type="text" id="lightboxCdnUrl" readonly style="width:100%; height:30px; font-size:10.5px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px; background:#f6f7f7; color:#646970;">
                </div>
            </div>
            <div>
                <button type="button" class="wp-button" onclick="copyCdnUrl(document.getElementById('lightboxCdnUrl').value)" style="width:100%; height:32px; justify-content:center; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; margin-bottom:6px; display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    <span>Copy CDN Link</span>
                </button>
                <button type="button" class="wp-button primary" onclick="closeLightbox()" style="width:100%; height:32px; justify-content:center; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F;">
                    Done
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function setGridDensity(cols) {
    const grid = document.getElementById('mediaGridContainer');
    const list = document.getElementById('mediaListContainer');
    const btns = document.querySelectorAll('.dt-density-btn');

    btns.forEach(b => b.classList.remove('active'));

    if (cols === 'list') {
        grid.style.display = 'none';
        list.style.display = 'block';
        document.getElementById('btn-cols-list').classList.add('active');
        if (typeof window.showToast === 'function') window.showToast('📋 List Table View Activated');
    } else {
        list.style.display = 'none';
        grid.style.display = 'grid';
        grid.className = `dt-media-gallery-grid grid-cols-${cols}`;
        document.getElementById(`btn-cols-${cols}`).classList.add('active');
        if (typeof window.showToast === 'function') window.showToast(`🔲 Density: ${cols} Columns Per Row`);
    }
}

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
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
