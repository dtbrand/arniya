<?php
/**
 * display-settings.php — Catalogue Display Grid & Multi-Portal Storefront Engine
 * DT Brand's & Jai Hanuman Tex
 */
$real_products = [
    [
        'id'       => 1,
        'sku'      => 'KLN-SR-101',
        'name'     => 'Kanjivaram Silk Saree',
        'category' => 'Sarees',
        'price'    => 2850,
        'old_price'=> 4999,
        'discount' => 43,
        'tier_4'   => '₹2,600',
        'tier_12'  => '₹2,400',
        'resale_profit' => '₹2,149',
        'margin'   => '+43%',
        'image'    => '/Frontend/Shop/Asset/images/product1.png',
        'badge'    => 'Heritage',
        'rating'   => 5.0,
        'reviews'  => 128,
        'color'    => 'Royal Blue',
        'colors'   => ['Royal Blue', 'Deep Maroon', 'Peacock Green'],
        'size'     => ['Free Size', 'Unstitched Blouse'],
        'fabric'   => 'Pure Silk Mark',
        'moq'      => '4 Pieces Bundle',
        'depot_stock' => '420 Pcs Ready',
        'in_stock' => true
    ],
    [
        'id'       => 2,
        'sku'      => 'BRL-LH-201',
        'name'     => 'Bridal Zardosi Velvet Lehenga',
        'category' => 'Lehengas',
        'price'    => 11500,
        'old_price'=> 18999,
        'discount' => 39,
        'tier_4'   => '₹10,800',
        'tier_12'  => '₹9,900',
        'resale_profit' => '₹7,499',
        'margin'   => '+39%',
        'image'    => '/Frontend/Shop/Asset/images/product6.png',
        'badge'    => 'Bridal',
        'rating'   => 5.0,
        'reviews'  => 84,
        'color'    => 'Deep Maroon',
        'colors'   => ['Deep Maroon', 'Ruby Red', 'Wine Velvet'],
        'size'     => ['Semi-Stitched (Up to 44")'],
        'fabric'   => 'Micro Velvet & Zardosi',
        'moq'      => '2 Sets (Boutique Special)',
        'depot_stock' => '85 Sets Ready',
        'in_stock' => true
    ],
    [
        'id'       => 3,
        'sku'      => 'BNS-SR-102',
        'name'     => 'Banarasi Brocade Saree',
        'category' => 'Sarees',
        'price'    => 3200,
        'old_price'=> 5500,
        'discount' => 41,
        'tier_4'   => '₹2,950',
        'tier_12'  => '₹2,700',
        'resale_profit' => '₹2,300',
        'margin'   => '+41%',
        'image'    => '/Frontend/Shop/Asset/images/product2.png',
        'badge'    => 'Best Seller',
        'rating'   => 4.7,
        'reviews'  => 96,
        'color'    => 'Crimson Red',
        'colors'   => ['Crimson Red', 'Golden Zari', 'Wine'],
        'size'     => ['Free Size'],
        'fabric'   => 'Kadhwa Brocade Weave',
        'moq'      => '4 Pieces Bundle',
        'depot_stock' => '240 Pcs Ready',
        'in_stock' => true
    ],
    [
        'id'       => 4,
        'sku'      => 'KRT-AN-301',
        'name'     => 'Anarkali Festive Kurti Set',
        'category' => 'Kurtis',
        'price'    => 1650,
        'old_price'=> 2999,
        'discount' => 45,
        'tier_4'   => '₹1,500',
        'tier_12'  => '₹1,380',
        'resale_profit' => '₹1,349',
        'margin'   => '+45%',
        'image'    => '/Frontend/Shop/Asset/images/product4.png',
        'badge'    => 'New',
        'rating'   => 4.8,
        'reviews'  => 112,
        'color'    => 'Blush Peach',
        'colors'   => ['Blush Peach', 'Rose Pink', 'Teal'],
        'size'     => ['S', 'M', 'L', 'XL', 'XXL'],
        'fabric'   => 'Georgette Silk',
        'moq'      => '6 Sets Pack',
        'depot_stock' => '310 Sets Ready',
        'in_stock' => true
    ],
    [
        'id'       => 5,
        'sku'      => 'DRS-MD-401',
        'name'     => 'Pure Modal Silk Suit Material',
        'category' => 'Suits',
        'price'    => 1420,
        'old_price'=> 2499,
        'discount' => 43,
        'tier_4'   => '₹1,280',
        'tier_12'  => '₹1,150',
        'resale_profit' => '₹1,079',
        'margin'   => '+43%',
        'image'    => '/Frontend/Shop/Asset/images/product5.png',
        'badge'    => 'New',
        'rating'   => 4.6,
        'reviews'  => 68,
        'color'    => 'Emerald Green',
        'colors'   => ['Emerald Green', 'Mint', 'Olive'],
        'size'     => ['Unstitched 3-Piece Set'],
        'fabric'   => 'Modal Silk Handloom',
        'moq'      => '8 Sets Pack',
        'depot_stock' => '180 Sets Ready',
        'in_stock' => true
    ],
    [
        'id'       => 6,
        'sku'      => 'DPT-BD-501',
        'name'     => 'Bandhani Festive Heritage Saree',
        'category' => 'Sarees',
        'price'    => 890,
        'old_price'=> 1599,
        'discount' => 44,
        'tier_4'   => '₹780',
        'tier_12'  => '₹690',
        'resale_profit' => '₹709',
        'margin'   => '+44%',
        'image'    => '/Frontend/Shop/Asset/images/product3.png',
        'badge'    => 'Trending',
        'rating'   => 4.9,
        'reviews'  => 145,
        'color'    => 'Yellow Ochre',
        'colors'   => ['Yellow Ochre', 'Golden Yellow', 'Emerald'],
        'size'     => ['Free Size', 'L', 'XL'],
        'fabric'   => 'Pure Silk Bandhani',
        'moq'      => '10 Pcs Bundle',
        'depot_stock' => '520 Pcs Ready',
        'in_stock' => true
    ],
    [
        'id'       => 7,
        'sku'      => 'CHD-SR-103',
        'name'     => 'Chanderi Zari Festive Saree',
        'category' => 'Sarees',
        'price'    => 2150,
        'old_price'=> 3800,
        'discount' => 43,
        'tier_4'   => '₹1,950',
        'tier_12'  => '₹1,800',
        'resale_profit' => '₹1,650',
        'margin'   => '+43%',
        'image'    => '/Frontend/Shop/Asset/images/product7.png',
        'badge'    => 'Heritage',
        'rating'   => 4.7,
        'reviews'  => 52,
        'color'    => 'Mustard Gold',
        'colors'   => ['Mustard Gold', 'Rust Orange', 'Sage'],
        'size'     => ['Free Size'],
        'fabric'   => 'Handloom Chanderi',
        'moq'      => '4 Pieces Bundle',
        'depot_stock' => '190 Pcs Ready',
        'in_stock' => true
    ],
    [
        'id'       => 8,
        'sku'      => 'JAC-SR-108',
        'name'     => 'Surat Heritage Jacquard Saree',
        'category' => 'Sarees',
        'price'    => 3750,
        'old_price'=> 6200,
        'discount' => 40,
        'tier_4'   => '₹3,400',
        'tier_12'  => '₹3,100',
        'resale_profit' => '₹2,450',
        'margin'   => '+40%',
        'image'    => '/Frontend/Shop/Asset/images/product8.png',
        'badge'    => 'Trending',
        'rating'   => 4.8,
        'reviews'  => 78,
        'color'    => 'Ivory Cream',
        'colors'   => ['Ivory Cream', 'Pearl White', 'Champagne'],
        'size'     => ['Free Size'],
        'fabric'   => 'Jacquard Brocade',
        'moq'      => '4 Pieces Bundle',
        'depot_stock' => '150 Pcs Ready',
        'in_stock' => true
    ]
];
?>
<div class="dt-cat-card">
    <!-- Header Ribbon with Presets & Master Expand/Collapse Buttons -->
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Catalogue Storefront Display &amp; User-Wise Placement Engine</span>
        </h3>
        <div style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_DISPLAY.expandAll()" style="height:28px; padding:0 8px; font-size:11px;" title="Expand All Sections">➕ Expand All</button>
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_DISPLAY.collapseAll()" style="height:28px; padding:0 8px; font-size:11px;" title="Collapse All Sections">➖ Collapse All</button>
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_DISPLAY.applyPreset('b2b')" style="height:28px; padding:0 10px; font-size:11px;">⚡ Surat B2B Wholesale</button>
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_DISPLAY.applyPreset('boutique')" style="height:28px; padding:0 10px; font-size:11px;">✨ Luxury Boutique</button>
            <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Display settings saved live!')" style="height:28px; padding:0 12px; font-size:11px;">Save Display Settings</button>
        </div>
    </div>

    <div style="padding:16px;">
        
        <!-- ════ STEP 1: USER-WISE TARGET AUDIENCE PROFILES ════ -->
        <div class="dt-accordion-header active" onclick="window.DT_DISPLAY.toggleSection('sec-body-1', this)">
            <div style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:800; color:#181512;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>Step 1: Target Audience Profiles (User-Wise)</span>
                <span class="dt-badge gold" style="font-size:9.5px;">4 Active Profiles</span>
            </div>
            <span class="dt-collapse-pill"><span class="dt-collapse-sign">−</span> <span class="dt-collapse-text">Collapse</span></span>
        </div>
            
        <div class="dt-accordion-body" id="sec-body-1">
            <div class="dt-user-card-grid">
                <!-- 1. Retail Customer (B2C) -->
                <div class="dt-user-card-item active" id="user-customer" onclick="window.DT_DISPLAY.setUserType('customer')">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2px;">
                        <div style="display:flex; align-items:center; gap:6px; font-weight:800; font-size:12px; color:#181512;">
                            <span style="font-size:15px;">🛍️</span> <span>Retail Customer (B2C)</span>
                        </div>
                        <span class="user-active-tag" id="tag-customer" style="font-size:9px; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:1px 6px; border-radius:10px; white-space:nowrap;">Active</span>
                    </div>
                    <div style="font-size:10px; color:#64748b; line-height:1.3;">Individual Sarees • Silk Mark Badges • Consumer MRP Discounts</div>
                </div>

                <!-- 2. WhatsApp Reseller -->
                <div class="dt-user-card-item" id="user-reseller" onclick="window.DT_DISPLAY.setUserType('reseller')">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2px;">
                        <div style="display:flex; align-items:center; gap:6px; font-weight:800; font-size:12px; color:#1D4ED8;">
                            <span style="font-size:15px;">💬</span> <span>WhatsApp Reseller</span>
                        </div>
                        <span class="user-active-tag" id="tag-reseller" style="display:none; font-size:9px; font-weight:800; color:#1D4ED8; background:#EFF6FF; border:1px solid #93C5FD; padding:1px 6px; border-radius:10px; white-space:nowrap;">Active</span>
                    </div>
                    <div style="font-size:10px; color:#64748b; line-height:1.3;">Profit Margins (+₹2,149/Pc) • Zero Stock • 1-Click WhatsApp Share</div>
                </div>

                <!-- 3. Retailer / Boutique -->
                <div class="dt-user-card-item" id="user-retailer" onclick="window.DT_DISPLAY.setUserType('retailer')">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2px;">
                        <div style="display:flex; align-items:center; gap:6px; font-weight:800; font-size:12px; color:#8A681F;">
                            <span style="font-size:15px;">🏪</span> <span>Retailer / Boutique</span>
                        </div>
                        <span class="user-active-tag" id="tag-retailer" style="display:none; font-size:9px; font-weight:800; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:1px 6px; border-radius:10px; white-space:nowrap;">Active</span>
                    </div>
                    <div style="font-size:10px; color:#64748b; line-height:1.3;">Curated 2–4 Pc Bundles • Boutique Assortment • GST Invoice Included</div>
                </div>

                <!-- 4. Wholesale B2B Buyer -->
                <div class="dt-user-card-item" id="user-wholesaler" onclick="window.DT_DISPLAY.setUserType('wholesaler')">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2px;">
                        <div style="display:flex; align-items:center; gap:6px; font-weight:800; font-size:12px; color:#7C2D12;">
                            <span style="font-size:15px;">🏢</span> <span>Wholesale B2B Buyer</span>
                        </div>
                        <span class="user-active-tag" id="tag-wholesaler" style="display:none; font-size:9px; font-weight:800; color:#7C2D12; background:#FEF2F2; border:1px solid #FECACA; padding:1px 6px; border-radius:10px; white-space:nowrap;">Active</span>
                    </div>
                    <div style="font-size:10px; color:#64748b; line-height:1.3;">Tiered Bulk Lots (12+ Pcs) • Surat Depot Ready Stock • Master PO</div>
                </div>
            </div>
        </div>

        <!-- ════ STEP 2: STOREFRONT PAGE PLACEMENT SUB-TABS ════ -->
        <div class="dt-accordion-header active" onclick="window.DT_DISPLAY.toggleSection('sec-body-2', this)">
            <div style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:800; color:#181512;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                <span>Step 2: Storefront Page Placement (Page-Wise)</span>
                <span class="dt-badge gold" style="font-size:9.5px;">8 Placements</span>
            </div>
            <span class="dt-collapse-pill"><span class="dt-collapse-sign">−</span> <span class="dt-collapse-text">Collapse</span></span>
        </div>

        <div class="dt-accordion-body" id="sec-body-2">
            <div class="dt-page-subnav">
                <button type="button" class="dt-subnav-pill active" id="sub-shop" onclick="window.DT_DISPLAY.setPlacement('shop')">🛒 Shop &amp; Catalog Grid</button>
                <button type="button" class="dt-subnav-pill" id="sub-collection" onclick="window.DT_DISPLAY.setPlacement('collection')">👑 Collection Page</button>
                <button type="button" class="dt-subnav-pill" id="sub-single" onclick="window.DT_DISPLAY.setPlacement('single')">🔍 Single Product Related Line</button>
                <button type="button" class="dt-subnav-pill" id="sub-home-trending" onclick="window.DT_DISPLAY.setPlacement('home-trending')">🔥 Home: Trending Collection</button>
                <button type="button" class="dt-subnav-pill" id="sub-home-new" onclick="window.DT_DISPLAY.setPlacement('home-new')">✨ Home: New Arrivals 2026</button>
                <button type="button" class="dt-subnav-pill" id="sub-home-sale" onclick="window.DT_DISPLAY.setPlacement('home-sale')">🏷️ Home: Festive Sale / Low MOQ</button>
                <button type="button" class="dt-subnav-pill" id="sub-home-recent" onclick="window.DT_DISPLAY.setPlacement('home-recent')">👁️ Home: Recently Viewed</button>
                <button type="button" class="dt-subnav-pill" id="sub-home-rec" onclick="window.DT_DISPLAY.setPlacement('home-rec')">🎯 Home: Recommended For You</button>
            </div>
        </div>

        <!-- ════ STEP 3: MULTI-DEVICE GRID COLUMNS & DIMENSIONS ════ -->
        <div class="dt-accordion-header active" onclick="window.DT_DISPLAY.toggleSection('sec-body-3', this)">
            <div style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:800; color:#181512;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                <span>Step 3: Multi-Device Grid Columns &amp; Card Dimensions</span>
                <span class="dt-badge gold" style="font-size:9.5px;">Desktop • Tablet • Mobile</span>
            </div>
            <span class="dt-collapse-pill"><span class="dt-collapse-sign">−</span> <span class="dt-collapse-text">Collapse</span></span>
        </div>

        <div class="dt-accordion-body" id="sec-body-3">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:12px;">
                <div class="dt-form-group">
                    <label class="dt-form-label">🖥️ Desktop Columns</label>
                    <select class="dt-form-select" id="dspDeskCols" onchange="window.DT_DISPLAY.updatePreview()">
                        <option value="4" selected>4 Columns (Recommended Wholesale)</option>
                        <option value="3">3 Columns (Luxury Large Cards)</option>
                        <option value="5">5 Columns (Compact Catalog)</option>
                        <option value="6">6 Columns (Ultra High-Density)</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">💻 Tablet Columns</label>
                    <select class="dt-form-select" id="dspTabCols" onchange="window.DT_DISPLAY.updatePreview()">
                        <option value="3" selected>3 Columns (Standard Tablet)</option>
                        <option value="2">2 Columns (Large Touch Cards)</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">📱 Mobile Smartphone Columns</label>
                    <select class="dt-form-select" id="dspMobCols" onchange="window.DT_DISPLAY.updatePreview()">
                        <option value="2" selected>2 Columns (Meesho &amp; Flipkart App Style)</option>
                        <option value="1">1 Column (Single Card Full Width)</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">📐 Image Aspect Ratio</label>
                    <select class="dt-form-select" id="dspRatio" onchange="window.DT_DISPLAY.updatePreview()">
                        <option value="3-4" selected>3:4 Vertical Portrait (Ethnic Standard)</option>
                        <option value="4-5">4:5 Tall Saree &amp; Lehenga Format</option>
                        <option value="1-1">1:1 Clean Square</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">🔢 Products Count / Max Cards</label>
                    <select class="dt-form-select" id="dspPerPage" onchange="window.DT_DISPLAY.updatePreview()">
                        <option value="8" selected>8 Products (Featured Strip)</option>
                        <option value="16">16 Products</option>
                        <option value="24">24 Products / Page</option>
                        <option value="48">48 Products / Page</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">🔃 Default Catalog Sorting</label>
                    <select class="dt-form-select" id="dspSorting" onchange="window.DT_DISPLAY.updateSorting()">
                        <option value="position" selected>Position / Merchandising Priority</option>
                        <option value="price-asc">Price: Low to High (Wholesale Rate)</option>
                        <option value="price-desc">Price: High to Low</option>
                        <option value="popular">Best Sellers / Fast Moving Lots</option>
                        <option value="newest">Latest Catalogues (Newest First)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- ════ STEP 4: CARD THEMES, BUTTON STYLES & RADII ════ -->
        <div class="dt-accordion-header active" onclick="window.DT_DISPLAY.toggleSection('sec-body-4', this)">
            <div style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:800; color:#181512;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                <span>Step 4: Card Themes, Button Styles &amp; Corner Radii</span>
                <span class="dt-badge gold" style="font-size:9.5px;">Visual Aesthetics</span>
            </div>
            <span class="dt-collapse-pill"><span class="dt-collapse-sign">−</span> <span class="dt-collapse-text">Collapse</span></span>
        </div>

        <div class="dt-accordion-body" id="sec-body-4">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:12px;">
                <div class="dt-form-group">
                    <label class="dt-form-label">🎨 Card Border &amp; Shadow Theme</label>
                    <select class="dt-form-select" id="dspCardTheme" onchange="window.DT_DISPLAY.updateCardStyles()">
                        <option value="gold-border" selected>Luxury Gold Border with Soft Shadow (Default)</option>
                        <option value="clean-border">Clean Subtle Grey Border (Shop Standard)</option>
                        <option value="dark-obsidian">Obsidian Dark Luxe Border</option>
                        <option value="borderless">Flat Modern Borderless</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">🔘 Primary Button Style</label>
                    <select class="dt-form-select" id="dspBtnStyle" onchange="window.DT_DISPLAY.updateCardStyles()">
                        <option value="emerald" selected>1-Click WhatsApp Lot (Emerald Gradient)</option>
                        <option value="gold">Primary Gold Master Button</option>
                        <option value="pale-gold">Pale Gold Subtle Action Pill</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">📏 Button Size / Touch Target</label>
                    <select class="dt-form-select" id="dspBtnSize" onchange="window.DT_DISPLAY.updateCardStyles()">
                        <option value="normal" selected>Standard 28px (Balanced)</option>
                        <option value="large">Large 34px (High Conversion Touch)</option>
                        <option value="compact">Compact 24px (High Density)</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">⭕ Card Corner Radius</label>
                    <select class="dt-form-select" id="dspCardRadius" onchange="window.DT_DISPLAY.updateCardStyles()">
                        <option value="8px" selected>8px Rounded (Shop Standard)</option>
                        <option value="12px">12px Modern Pill Curve</option>
                        <option value="4px">4px Sharp Heritage Classic</option>
                        <option value="0px">0px Flat Crisp Edge</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- ════ STEP 5: ALL REAL BADGES & STOREFRONT ELEMENTS ════ -->
        <div class="dt-accordion-header active" onclick="window.DT_DISPLAY.toggleSection('sec-body-5', this)">
            <div style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:800; color:#181512;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                <span>Step 5: Badges, Wholesale Elements &amp; Storefront Actions</span>
                <span class="dt-badge gold" style="font-size:9.5px;">20 Toggles Configured</span>
            </div>
            <span class="dt-collapse-pill"><span class="dt-collapse-sign">−</span> <span class="dt-collapse-text">Collapse</span></span>
        </div>

        <div class="dt-accordion-body" id="sec-body-5">
            <!-- Group A: Trust & Photo Badges -->
            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px; margin-bottom:10px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div style="font-size:11.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.06em;">🏷️ A. Trust &amp; Product Badges</div>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_DISPLAY.toggleSubGroup('grp-a', this)" style="height:20px; font-size:9.5px; padding:0 6px;">− Minimize</button>
                </div>
                <div id="grp-a" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:10px;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkSilkMark" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show "Silk Mark Certified" Badge</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkDepotStock" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show "Surat Depot Stock" Tag</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkUrgency" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Fast Selling / Trending Badge</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkNewBadge" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show New Arrival 2026 Badge</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkBridalBadge" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Bridal Edition Badge</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkCatTag" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Category Photo Tag (Bottom-Right)</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkSuratStamp" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Surat Direct Weaver Stamp</span>
                    </label>
                </div>
            </div>

            <!-- Group B: Wholesale & Commercial B2B Elements -->
            <div style="background:#FDFBF7; border:1px solid #D4AF37; border-radius:6px; padding:12px; margin-bottom:10px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div style="font-size:11.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.06em;">💼 B. Wholesale &amp; Commercial B2B Elements</div>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_DISPLAY.toggleSubGroup('grp-b', this)" style="height:20px; font-size:9.5px; padding:0 6px;">− Minimize</button>
                </div>
                <div id="grp-b" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:10px;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkB2bRate" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Wholesale B2B Rate &amp; Retail MRP</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkMargin" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Resale Margin % Pill (+43%)</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkTieredRates" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Tiered Bulk Lot Rates (1-3, 4-11, 12+ Pcs)</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkMoq" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show MOQ / Bundle Size Badge (MOQ 4)</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkStockQty" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Ready Inventory Qty (420 Pcs in Surat)</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkGstTag" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show GST Invoice &amp; Tax Credit Included</span>
                    </label>
                </div>
            </div>

            <!-- Group C: Buttons, Wishlist, Cart & Photo Tools -->
            <div style="background:#EFF6FF; border:1px solid #BFDBFE; border-radius:6px; padding:12px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div style="font-size:11.5px; font-weight:800; color:#1D4ED8; text-transform:uppercase; letter-spacing:0.06em;">🔘 C. Actions, Wishlist, Cart &amp; Details</div>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_DISPLAY.toggleSubGroup('grp-c', this)" style="height:20px; font-size:9.5px; padding:0 6px;">− Minimize</button>
                </div>
                <div id="grp-c" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:10px;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkWhatsApp" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#16A34A;">
                        <span>Show 1-Click WhatsApp Lot Enquiry Button</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkWishlist" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Wishlist Heart Button (Top-Right)</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkPhotoShare" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Photo Smart WhatsApp Share Button</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkRating" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show 5-Star Rating &amp; Review Count</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkFabricSku" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Fabric &amp; SKU Subtitle Tag</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                        <input type="checkbox" id="chkColorsSizes" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                        <span>Show Colours Count &amp; Available Sizes Row</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- ════ STEP 6: LIVE STOREFRONT SIMULATOR CANVAS ════ -->
        <div class="dt-accordion-header active" onclick="window.DT_DISPLAY.toggleSection('sec-body-6', this)" style="margin-top:14px;">
            <div style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:800; color:#181512;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#16A34A" stroke-width="2.2"><path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path></svg>
                <span>Step 6: Live Storefront Simulator Canvas (0ms Reactive)</span>
                <span class="dt-badge green" style="font-size:9.5px;">Live Preview Synced</span>
            </div>
            <span class="dt-collapse-pill"><span class="dt-collapse-sign">−</span> <span class="dt-collapse-text">Collapse</span></span>
        </div>

        <div class="dt-accordion-body" id="sec-body-6">
            <div style="background:#FDFBF7; border:1px solid #D4AF37; border-radius:8px; padding:16px; box-shadow:0 4px 16px rgba(212,175,55,0.12);">
                
                <!-- Enhanced Real-Time Sync & Live Filter Toolbar -->
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; flex-wrap:wrap; gap:10px; background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:10px 14px; box-shadow:0 2px 6px rgba(0,0,0,0.03);">
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; flex:1; min-width:260px;">
                        <span id="liveSyncPulse" style="display:inline-block; width:9px; height:9px; border-radius:50%; background:#16A34A; box-shadow:0 0 8px #16A34A;"></span>
                        <strong id="liveSyncStatus" style="font-size:12px; color:#181512;">Live Storefront Simulator</strong>
                        <span id="liveContextBadge" class="dt-badge gold" style="font-size:10px; font-weight:800;">🛍️ Customer ➔ 🛒 Shop Grid</span>
                        <span id="liveParamPills" style="font-size:10.5px; color:#64748b;">4 Cols Desk • 2 Cols Mob • 3:4 Aspect</span>
                    </div>

                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <!-- Live SKU Search Box -->
                        <div style="position:relative; min-width:180px;">
                            <input type="text" id="simSkuSearch" placeholder="🔍 Filter simulated items..." oninput="window.DT_DISPLAY.filterCards(this.value)" style="height:28px; font-size:11px; padding:0 8px; border:1px solid #cbd5e1; border-radius:14px; width:100%; box-sizing:border-box; outline:none; background:#FAF8F4;">
                        </div>

                        <!-- Device Switcher -->
                        <div class="dt-device-switcher">
                            <button type="button" class="dt-device-btn active" id="btnDspDesk" onclick="window.DT_DISPLAY.switchDevice('desk')">🖥️ Desktop</button>
                            <button type="button" class="dt-device-btn" id="btnDspMob" onclick="window.DT_DISPLAY.switchDevice('mob')">📱 Mobile</button>
                        </div>
                    </div>
                </div>

                <!-- Simulated Cards Grid (100% Real Shop Structure) -->
                <div id="simulatedGrid" class="products-grid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:12px; transition:all 0.25s ease;">
                    <?php foreach ($real_products as $p): ?>
                    <?php
                        $badge_class = !empty($p['badge']) ? 'badge-'.strtolower(str_replace(' ', '', $p['badge'])) : '';
                    ?>
                    <article class="product-card dt-sim-card" data-id="<?php echo $p['id']; ?>" data-price="<?php echo $p['price']; ?>" data-reviews="<?php echo $p['reviews']; ?>" data-badge="<?php echo htmlspecialchars($p['badge']); ?>" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; position:relative; display:flex; flex-direction:column; overflow:hidden; transition:all 0.25s ease;">
                        
                        <!-- 1. Card Image Wrap with Real Wishlist, Badges, Category Tag & Share -->
                        <div class="card-image-wrap" style="position:relative; overflow:hidden; aspect-ratio:3/3.75; background:#FAF8F4; width:100%;">
                            
                            <img src="<?php echo htmlspecialchars($p['image']); ?>" onerror="this.src='/Shared/Asset/images/product1.png';" alt="<?php echo htmlspecialchars($p['name']); ?>" class="card-img sim-card-img" style="width:100%; height:100%; object-fit:cover; object-position:center top; transition:transform 0.35s ease;">

                            <!-- Real Shop Badges (Heritage, Bridal, Trending, Best Seller, New) -->
                            <?php if (!empty($p['badge'])): ?>
                            <span class="card-badge <?php echo $badge_class; ?> sim-badge-el"><?php echo htmlspecialchars($p['badge']); ?></span>
                            <?php endif; ?>

                            <!-- Real Shop Top-Right Wishlist Button -->
                            <button type="button" class="card-wishlist-btn sim-wishlist-btn" onclick="this.classList.toggle('active'); if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('❤️ Wishlist updated!');" title="Add to Wishlist">
                                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            </button>

                            <!-- Real Shop Share Button on Photo -->
                            <button type="button" class="card-share-btn sim-share-btn" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('📲 WhatsApp sharing link copied for <?php echo addslashes($p['name']); ?>!');" title="Share Product">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                            </button>

                            <!-- Real Shop Category Photo Tag -->
                            <span class="card-cat-photo-tag sim-cat-tag"><?php echo htmlspecialchars($p['category']); ?></span>
                        </div>

                        <!-- 2. Card Body with Exact Real Shop Typography & Colors -->
                        <div class="card-body" style="padding:10px; display:flex; flex-direction:column; gap:3px; flex:1;">
                            
                            <!-- Fabric & SKU Subtitle Tag -->
                            <div class="card-fabric-tag sim-fabric-tag" style="font-size:0.58rem; font-weight:700; color:#8A681F; text-transform:uppercase; letter-spacing:0.08em;">
                                <?php echo htmlspecialchars($p['fabric']); ?> • SKU: <?php echo htmlspecialchars($p['sku']); ?>
                            </div>

                            <!-- Product Name -->
                            <h2 class="card-name" style="font-family:'Plus Jakarta Sans', sans-serif; font-size:0.82rem; font-weight:700; color:#181512; margin:2px 0 3px 0; line-height:1.25; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                <?php echo htmlspecialchars($p['name']); ?>
                            </h2>

                            <!-- Clean Colors & Sizes Info Row -->
                            <div class="card-info-text-row sim-colors-sizes" style="display:flex; justify-content:space-between; align-items:center; font-size:0.68rem; color:#64748b; margin-bottom:4px;">
                                <span class="card-colors-text" style="font-weight:600; color:#8A681F;"><?php echo count($p['colors']); ?> Colours</span>
                                <span class="card-sizes-text" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:120px;"><?php echo htmlspecialchars(implode(', ', $p['size'])); ?></span>
                            </div>

                            <!-- 5-Star Rating Row -->
                            <div class="sim-rating" style="display:flex; align-items:center; gap:3px; font-size:10px; color:#B8860B; font-weight:700; margin-bottom:3px;">
                                <span>★★★★★</span> <span style="color:#64748b; font-weight:500;">(<?php echo $p['rating']; ?> • <?php echo $p['reviews']; ?>)</span>
                            </div>

                            <!-- Dynamic Context Actions & Price Rendering -->
                            <div class="context-card-content">
                                <!-- Price Row -->
                                <div class="card-price-row sim-price-row" style="display:flex; align-items:center; gap:6px; margin:4px 0 6px 0;">
                                    <span class="card-price sim-b2b" style="font-size:0.95rem; font-weight:800; color:#15803D;">₹<?php echo number_format($p['price']); ?></span>
                                    <span class="card-old-price sim-mrp" style="font-size:0.75rem; color:#94a3b8; text-decoration:line-through;">₹<?php echo number_format($p['old_price']); ?></span>
                                    <span class="card-price-discount sim-margin" style="font-size:0.65rem; font-weight:800; color:#15803D; background:#DCFCE7; padding:1px 5px; border-radius:10px;"><?php echo $p['discount']; ?>% OFF</span>
                                </div>

                                <!-- Context Dynamic Pill Box -->
                                <div class="sim-context-pill" style="font-size:9.5px; margin-bottom:6px; display:none;"></div>

                                <!-- Primary Action Button -->
                                <button type="button" class="dt-btn-action-sm emerald sim-whatsapp sim-action-btn" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('📲 Action triggered for <?php echo addslashes($p['name']); ?>!')" style="width:100%; height:28px; justify-content:center; font-size:10.5px; font-weight:700; margin-top:auto;">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                                    <span class="sim-btn-text">WhatsApp Wholesale Lot</span>
                                </button>
                            </div>

                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <!-- Live Simulated Pagination Footer -->
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:14px; padding-top:10px; border-top:1px solid #e2e8f0; flex-wrap:wrap; gap:8px;">
                    <span id="livePaginationInfo" style="font-size:11px; color:#64748b;">Showing <strong>1–8</strong> of <strong>24</strong> Live SKUs (Page 1 of 3)</span>
                    <div style="display:flex; gap:4px;">
                        <button type="button" class="dt-btn-action-sm gold" style="height:22px; padding:0 8px; font-size:10px;">1</button>
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Simulated Page 2 loaded!')" style="height:22px; padding:0 8px; font-size:10px;">2</button>
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Simulated Page 3 loaded!')" style="height:22px; padding:0 8px; font-size:10px;">3</button>
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('Next page loaded!')" style="height:22px; padding:0 8px; font-size:10px;">Next ›</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
