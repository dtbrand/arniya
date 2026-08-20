<?php
/**
 * display-settings.php — Catalogue Display Grid & Multi-Portal Storefront Engine
 * DT Brand's & Jai Hanuman Tex
 */
$real_products = [
    [
        'id' => 1,
        'sku' => 'KLN-SR-101',
        'title' => 'Kanjivaram Pure Silk Zari Saree',
        'image' => '/Frontend/Shop/Asset/images/product1.png',
        'wholesale_price' => '₹2,850',
        'tier_4' => '₹2,600',
        'tier_12' => '₹2,400',
        'retail_mrp' => '₹4,999',
        'resale_profit' => '₹2,149',
        'margin' => '+43%',
        'rating' => '5.0',
        'reviews' => 128,
        'moq' => '4 Pieces Bundle',
        'depot_stock' => '420 Pcs Ready',
        'silkmark' => true,
        'depot' => true,
        'urgency' => false
    ],
    [
        'id' => 2,
        'sku' => 'BRL-LH-201',
        'title' => 'Royal Velvet Bridal Zardosi Lehenga',
        'image' => '/Frontend/Shop/Asset/images/product6.png',
        'wholesale_price' => '₹11,500',
        'tier_4' => '₹10,800',
        'tier_12' => '₹9,900',
        'retail_mrp' => '₹18,999',
        'resale_profit' => '₹7,499',
        'margin' => '+39%',
        'rating' => '5.0',
        'reviews' => 84,
        'moq' => '2 Sets (Boutique)',
        'depot_stock' => '85 Sets Ready',
        'silkmark' => false,
        'depot' => true,
        'urgency' => true
    ],
    [
        'id' => 3,
        'sku' => 'BNS-SR-102',
        'title' => 'Banarasi Kadhwa Brocade Weave',
        'image' => '/Frontend/Shop/Asset/images/product2.png',
        'wholesale_price' => '₹3,200',
        'tier_4' => '₹2,950',
        'tier_12' => '₹2,700',
        'retail_mrp' => '₹5,500',
        'resale_profit' => '₹2,300',
        'margin' => '+41%',
        'rating' => '4.7',
        'reviews' => 96,
        'moq' => '4 Pieces Bundle',
        'depot_stock' => '240 Pcs Ready',
        'silkmark' => true,
        'depot' => false,
        'urgency' => false
    ],
    [
        'id' => 4,
        'sku' => 'KRT-AN-301',
        'title' => 'Anarkali Festive Designer Kurti Set',
        'image' => '/Frontend/Shop/Asset/images/product4.png',
        'wholesale_price' => '₹1,650',
        'tier_4' => '₹1,500',
        'tier_12' => '₹1,380',
        'retail_mrp' => '₹2,999',
        'resale_profit' => '₹1,349',
        'margin' => '+45%',
        'rating' => '4.8',
        'reviews' => 112,
        'moq' => '6 Sets Pack',
        'depot_stock' => '310 Sets Ready',
        'silkmark' => false,
        'depot' => true,
        'urgency' => false
    ],
    [
        'id' => 5,
        'sku' => 'DRS-MD-401',
        'title' => 'Pure Modal Silk Unstitched Material',
        'image' => '/Frontend/Shop/Asset/images/product5.png',
        'wholesale_price' => '₹1,420',
        'tier_4' => '₹1,280',
        'tier_12' => '₹1,150',
        'retail_mrp' => '₹2,499',
        'resale_profit' => '₹1,079',
        'margin' => '+43%',
        'rating' => '4.6',
        'reviews' => 68,
        'moq' => '8 Sets Pack',
        'depot_stock' => '180 Sets Ready',
        'silkmark' => false,
        'depot' => true,
        'urgency' => false
    ],
    [
        'id' => 6,
        'sku' => 'DPT-BD-501',
        'title' => 'Bandhani Festive Heritage Dupatta',
        'image' => '/Frontend/Shop/Asset/images/product3.png',
        'wholesale_price' => '₹890',
        'tier_4' => '₹780',
        'tier_12' => '₹690',
        'retail_mrp' => '₹1,599',
        'resale_profit' => '₹709',
        'margin' => '+44%',
        'rating' => '4.9',
        'reviews' => 145,
        'moq' => '10 Pcs Bundle',
        'depot_stock' => '520 Pcs Ready',
        'silkmark' => true,
        'depot' => false,
        'urgency' => false
    ],
    [
        'id' => 7,
        'sku' => 'CHD-SR-103',
        'title' => 'Chanderi Zari Lightweight Saree',
        'image' => '/Frontend/Shop/Asset/images/product7.png',
        'wholesale_price' => '₹2,150',
        'tier_4' => '₹1,950',
        'tier_12' => '₹1,800',
        'retail_mrp' => '₹3,800',
        'resale_profit' => '₹1,650',
        'margin' => '+43%',
        'rating' => '4.7',
        'reviews' => 52,
        'moq' => '4 Pieces Bundle',
        'depot_stock' => '190 Pcs Ready',
        'silkmark' => true,
        'depot' => true,
        'urgency' => false
    ],
    [
        'id' => 8,
        'sku' => 'JAC-SR-108',
        'title' => 'Surat Heritage Jacquard Brocade',
        'image' => '/Frontend/Shop/Asset/images/product8.png',
        'wholesale_price' => '₹3,750',
        'tier_4' => '₹3,400',
        'tier_12' => '₹3,100',
        'retail_mrp' => '₹6,200',
        'resale_profit' => '₹2,450',
        'margin' => '+40%',
        'rating' => '4.8',
        'reviews' => 78,
        'moq' => '4 Pieces Bundle',
        'depot_stock' => '150 Pcs Ready',
        'silkmark' => true,
        'depot' => true,
        'urgency' => true
    ]
];
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Catalogue Storefront Display &amp; Multi-Portal Engine</span>
        </h3>
        <div style="display:flex; gap:6px; align-items:center;">
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_DISPLAY.applyPreset('b2b')" style="height:28px; padding:0 10px; font-size:11px;">⚡ Preset: Surat B2B Wholesale</button>
            <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Display settings saved live!')" style="height:28px; padding:0 12px; font-size:11px;">Save Display Settings</button>
        </div>
    </div>

    <div style="padding:16px;">
        <!-- 1. Multi-Device Columns & Sizing -->
        <h4 style="font-size:13px; font-weight:800; color:#181512; margin:0 0 12px 0; display:flex; align-items:center; gap:6px;">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
            <span>Multi-Device Grid Columns &amp; Card Dimensions</span>
        </h4>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:14px; margin-bottom:18px;">
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
                <select class="dt-form-select" id="dspTabCols">
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
                <label class="dt-form-label">🔢 Products Per Page</label>
                <select class="dt-form-select">
                    <option value="24" selected>24 Products / Page</option>
                    <option value="48">48 Products / Page</option>
                    <option value="96">96 Products / Page</option>
                </select>
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label">🔃 Default Catalog Sorting</label>
                <select class="dt-form-select">
                    <option value="position" selected>Position / Merchandising Priority</option>
                    <option value="newest">Latest Catalogues (Newest First)</option>
                    <option value="price-asc">Price: Low to High (Wholesale Rate)</option>
                    <option value="price-desc">Price: High to Low</option>
                    <option value="popular">Best Sellers / Fast Moving Lots</option>
                </select>
            </div>
        </div>

        <hr style="border:none; border-top:1px solid #f1f5f9; margin:16px 0;">

        <!-- 2. Product Card Badges & B2B Visibility Toggles -->
        <h4 style="font-size:13px; font-weight:800; color:#181512; margin:0 0 12px 0; display:flex; align-items:center; gap:6px;">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
            <span>Product Card Badges &amp; Wholesale Elements</span>
        </h4>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(230px, 1fr)); gap:12px; margin-bottom:20px;">
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="chkRating" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                <span>Show 5-Star Rating &amp; Reviews</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="chkB2bRate" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                <span>Show Wholesale B2B Rate &amp; MRP</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="chkMargin" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                <span>Show Resale Margin % Pill</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="chkWhatsApp" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                <span>Show 1-Click WhatsApp Lot Button</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="chkSilkMark" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                <span>Show "Silk Mark Certified" Badge</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="chkDepotStock" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                <span>Show "Surat Depot Stock" Tag</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="chkMoq" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                <span>Show "MOQ / Bundle Size" Badge</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" id="chkUrgency" checked onchange="window.DT_DISPLAY.updatePreview()" style="width:15px; height:15px; accent-color:#8A681F;">
                <span>Show "Fast Selling / Low Stock" Alert</span>
            </label>
        </div>

        <!-- 3. Multi-Portal Storefront Simulator Tabs & Device Switcher -->
        <div style="background:#FDFBF7; border:1px solid #D4AF37; border-radius:8px; padding:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; flex-wrap:wrap; gap:10px;">
                <div>
                    <strong style="font-size:13px; color:#181512;">Live Storefront Product Card Simulator (Multi-Portal Switcher)</strong>
                    <div style="font-size:11px; color:#64748b;">Select any portal context to preview its exact specialized product card features.</div>
                </div>
                <div class="dt-device-switcher">
                    <button type="button" class="dt-device-btn active" id="btnDspDesk" onclick="window.DT_DISPLAY.switchDevice('desk')">🖥️ Desktop Grid</button>
                    <button type="button" class="dt-device-btn" id="btnDspMob" onclick="window.DT_DISPLAY.switchDevice('mob')">📱 Mobile App Grid</button>
                </div>
            </div>

            <!-- Portal Context Switcher Tabs -->
            <div class="dt-portal-tab-wrap">
                <button type="button" class="dt-portal-tab active" id="tab-shop" onclick="window.DT_DISPLAY.switchPortal('shop')">
                    <span>🛍️</span> <span>Main Customer Shop Grid</span>
                </button>
                <button type="button" class="dt-portal-tab" id="tab-wholesale" onclick="window.DT_DISPLAY.switchPortal('wholesale')">
                    <span>🏢</span> <span>Wholesale B2B Depot</span>
                </button>
                <button type="button" class="dt-portal-tab" id="tab-reseller" onclick="window.DT_DISPLAY.switchPortal('reseller')">
                    <span>💬</span> <span>WhatsApp Reseller Portal</span>
                </button>
                <button type="button" class="dt-portal-tab" id="tab-home" onclick="window.DT_DISPLAY.switchPortal('home')">
                    <span>🏠</span> <span>Homepage Featured Showcase</span>
                </button>
                <button type="button" class="dt-portal-tab" id="tab-single" onclick="window.DT_DISPLAY.switchPortal('single')">
                    <span>🔍</span> <span>Single Product Cross-Sell</span>
                </button>
            </div>

            <!-- Simulated Cards Grid -->
            <div id="simulatedGrid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:12px; transition:all 0.2s ease;">
                <?php foreach ($real_products as $prod): ?>
                <div class="dt-sim-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:10px; position:relative; box-shadow:0 2px 6px rgba(0,0,0,0.04); display:flex; flex-direction:column;">
                    
                    <!-- Badges -->
                    <div class="sim-badge-wrap" style="position:absolute; top:6px; left:6px; display:flex; flex-direction:column; gap:3px; z-index:2;">
                        <?php if ($prod['silkmark']): ?>
                        <span class="dt-badge gold sim-silkmark" style="font-size:9px; padding:1px 5px;">Silk Mark</span>
                        <?php endif; ?>
                        <?php if ($prod['depot']): ?>
                        <span class="dt-badge green sim-depot" style="font-size:9px; padding:1px 5px;">Surat Depot Stock</span>
                        <?php endif; ?>
                        <?php if ($prod['urgency']): ?>
                        <span class="dt-badge red sim-urgency" style="font-size:9px; padding:1px 5px;">🔥 Fast Selling</span>
                        <?php endif; ?>
                    </div>

                    <!-- Image -->
                    <img src="<?php echo htmlspecialchars($prod['image']); ?>" onerror="this.src='/Shared/Asset/images/product1.png';" class="sim-card-img" style="width:100%; height:140px; object-fit:cover; border-radius:6px; margin-bottom:8px; border:1px solid #f1f5f9;">

                    <!-- Rating -->
                    <div class="sim-rating" style="display:flex; align-items:center; gap:3px; font-size:10px; color:#B8860B; font-weight:700; margin-bottom:3px;">
                        <span>★★★★★</span> <span style="color:#64748b; font-weight:500;">(<?php echo $prod['rating']; ?> • <?php echo $prod['reviews']; ?>)</span>
                    </div>

                    <!-- Title & SKU -->
                    <strong style="font-size:12px; color:#181512; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo htmlspecialchars($prod['title']); ?></strong>
                    <div style="font-size:10px; color:#94a3b8; margin-bottom:2px;">SKU: <?php echo htmlspecialchars($prod['sku']); ?></div>

                    <!-- 1. Standard Shop View Content -->
                    <div class="portal-view portal-shop">
                        <div class="sim-price-row" style="display:flex; align-items:center; gap:6px; margin:4px 0;">
                            <span class="sim-b2b" style="font-size:13px; font-weight:800; color:#15803D;"><?php echo htmlspecialchars($prod['wholesale_price']); ?></span>
                            <span style="font-size:10.5px; color:#94a3b8; text-decoration:line-through;"><?php echo htmlspecialchars($prod['retail_mrp']); ?></span>
                            <span class="dt-badge green sim-margin" style="font-size:9px; padding:1px 4px;"><?php echo htmlspecialchars($prod['margin']); ?> Margin</span>
                        </div>
                        <div class="sim-moq" style="font-size:10px; color:#64748b; margin-bottom:6px;">MOQ: <strong><?php echo htmlspecialchars($prod['moq']); ?></strong></div>
                        <button type="button" class="dt-btn-action-sm emerald sim-whatsapp" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('📲 WhatsApp enquiry opened for <?php echo addslashes($prod['title']); ?>!')" style="width:100%; height:26px; justify-content:center; font-size:10.5px; font-weight:700;">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                            <span>WhatsApp Wholesale Lot</span>
                        </button>
                    </div>

                    <!-- 2. Wholesale B2B Bulk View Content -->
                    <div class="portal-view portal-wholesale" style="display:none;">
                        <div style="background:#FAF5E8; border:1px solid #D4AF37; border-radius:4px; padding:4px 6px; margin:4px 0; font-size:9.5px;">
                            <div>1–3 Pcs: <strong><?php echo htmlspecialchars($prod['wholesale_price']); ?></strong></div>
                            <div>4–11 Pcs: <strong style="color:#15803D;"><?php echo htmlspecialchars($prod['tier_4']); ?></strong></div>
                            <div>12+ Master Lot: <strong style="color:#8A681F;"><?php echo htmlspecialchars($prod['tier_12']); ?></strong></div>
                        </div>
                        <div style="font-size:9.5px; color:#15803D; font-weight:700; margin-bottom:4px;">📍 <?php echo htmlspecialchars($prod['depot_stock']); ?></div>
                        <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('🛒 Added Master Lot to Wholesale PO!')" style="width:100%; height:26px; justify-content:center; font-size:10.5px; font-weight:800;">
                            <span>+ Order Wholesale Lot</span>
                        </button>
                    </div>

                    <!-- 3. WhatsApp Reseller View Content -->
                    <div class="portal-view portal-reseller" style="display:none;">
                        <div style="background:#EFF6FF; border:1px solid #93C5FD; border-radius:4px; padding:4px 6px; margin:4px 0; font-size:9.5px;">
                            <div style="color:#1D4ED8; font-weight:700;">Buy @ <?php echo htmlspecialchars($prod['wholesale_price']); ?> ➔ Sell @ <?php echo htmlspecialchars($prod['retail_mrp']); ?></div>
                            <div style="color:#15803D; font-weight:800;">Your Profit: <?php echo htmlspecialchars($prod['resale_profit']); ?> / Pc</div>
                        </div>
                        <div style="display:flex; gap:4px;">
                            <button type="button" class="dt-btn-action-sm emerald" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('📲 WhatsApp catalogue package copied with your profit margin!')" style="flex:1; height:26px; font-size:10px; justify-content:center; padding:0 4px;">
                                <span>📲 Share on WhatsApp</span>
                            </button>
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('📥 Downloaded high-res photos & specifications!')" style="height:26px; font-size:10px; padding:0 6px;" title="Download HD Images">
                                <span>📥</span>
                            </button>
                        </div>
                    </div>

                    <!-- 4. Homepage Featured Showcase View Content -->
                    <div class="portal-view portal-home" style="display:none;">
                        <div style="font-size:10px; color:#8A681F; font-weight:700; margin:4px 0;">👑 Surat Heritage Master Weave</div>
                        <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:6px;">
                            <span style="font-size:13px; font-weight:800; color:#181512;"><?php echo htmlspecialchars($prod['wholesale_price']); ?></span>
                            <span class="dt-badge gold" style="font-size:9px;">Direct Depot</span>
                        </div>
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✨ Opened Surat Heritage Collection!')" style="width:100%; height:26px; justify-content:center; font-size:10.5px; font-weight:700;">
                            <span>Explore Collection ›</span>
                        </button>
                    </div>

                    <!-- 5. Single Product Related Cross-Sell View Content -->
                    <div class="portal-view portal-single" style="display:none;">
                        <div style="font-size:9.5px; color:#64748b; margin:4px 0;">✨ Frequently Bundled Together:</div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                            <span style="font-size:12px; font-weight:800; color:#15803D;"><?php echo htmlspecialchars($prod['wholesale_price']); ?></span>
                            <span class="dt-badge green" style="font-size:9px;">Save 10% on Bundle</span>
                        </div>
                        <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('🛍️ Bundle added to cart with 10% discount!')" style="width:100%; height:26px; justify-content:center; font-size:10.5px; font-weight:700;">
                            <span>+ Add Matching Saree</span>
                        </button>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
