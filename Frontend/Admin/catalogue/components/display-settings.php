<?php
/**
 * display-settings.php — Catalogue Display Grid & Column Configuration Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Catalogue Storefront Display &amp; Grid Engine</span>
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
                <span>Show Resale Margin % Pill (+42%)</span>
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

        <!-- 3. Live Interactive Storefront Card Simulator -->
        <div style="background:#FDFBF7; border:1px solid #D4AF37; border-radius:8px; padding:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                <div>
                    <strong style="font-size:13px; color:#181512;">Live Storefront Product Card Simulator</strong>
                    <div style="font-size:11px; color:#64748b;">Changes above reflect live on customer store cards below in real time.</div>
                </div>
                <div class="dt-device-switcher">
                    <button type="button" class="dt-device-btn active" id="btnDspDesk" onclick="window.DT_DISPLAY.switchDevice('desk')">🖥️ Desktop Grid</button>
                    <button type="button" class="dt-device-btn" id="btnDspMob" onclick="window.DT_DISPLAY.switchDevice('mob')">📱 Mobile App Grid</button>
                </div>
            </div>

            <!-- Simulated Cards Grid -->
            <div id="simulatedGrid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:12px; transition:all 0.2s ease;">
                <!-- Sim Product 1 -->
                <div class="dt-sim-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:10px; position:relative; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                    <div class="sim-badge-wrap" style="position:absolute; top:6px; left:6px; display:flex; flex-direction:column; gap:3px; z-index:2;">
                        <span class="dt-badge gold sim-silkmark" style="font-size:9px; padding:1px 5px;">Silk Mark</span>
                        <span class="dt-badge green sim-depot" style="font-size:9px; padding:1px 5px;">Surat Ready Stock</span>
                    </div>
                    <img src="/Frontend/Shop/Asset/images/product1.png" class="sim-card-img" style="width:100%; height:140px; object-fit:cover; border-radius:6px; margin-bottom:8px; border:1px solid #f1f5f9;">
                    <div class="sim-rating" style="display:flex; align-items:center; gap:3px; font-size:10px; color:#B8860B; font-weight:700; margin-bottom:3px;">
                        <span>★★★★★</span> <span style="color:#64748b; font-weight:500;">(4.9)</span>
                    </div>
                    <strong style="font-size:12px; color:#181512; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Kanjivaram Pure Silk Zari</strong>
                    <div class="sim-price-row" style="display:flex; align-items:center; gap:6px; margin:4px 0;">
                        <span class="sim-b2b" style="font-size:13px; font-weight:800; color:#15803D;">₹2,850</span>
                        <span style="font-size:10.5px; color:#94a3b8; text-decoration:line-through;">₹4,999</span>
                        <span class="dt-badge green sim-margin" style="font-size:9px; padding:1px 4px;">+43% Margin</span>
                    </div>
                    <div class="sim-moq" style="font-size:10px; color:#64748b; margin-bottom:6px;">MOQ: <strong>4 Pieces Bundle</strong></div>
                    <button type="button" class="dt-btn-action-sm emerald sim-whatsapp" style="width:100%; height:26px; justify-content:center; font-size:10.5px; font-weight:700;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                        <span>WhatsApp Wholesale Lot</span>
                    </button>
                </div>

                <!-- Sim Product 2 -->
                <div class="dt-sim-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:10px; position:relative; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                    <div class="sim-badge-wrap" style="position:absolute; top:6px; left:6px; display:flex; flex-direction:column; gap:3px; z-index:2;">
                        <span class="dt-badge red sim-urgency" style="font-size:9px; padding:1px 5px;">🔥 Fast Selling</span>
                        <span class="dt-badge green sim-depot" style="font-size:9px; padding:1px 5px;">Surat Depot</span>
                    </div>
                    <img src="/Frontend/Shop/Asset/images/product6.png" class="sim-card-img" style="width:100%; height:140px; object-fit:cover; border-radius:6px; margin-bottom:8px; border:1px solid #f1f5f9;">
                    <div class="sim-rating" style="display:flex; align-items:center; gap:3px; font-size:10px; color:#B8860B; font-weight:700; margin-bottom:3px;">
                        <span>★★★★★</span> <span style="color:#64748b; font-weight:500;">(5.0)</span>
                    </div>
                    <strong style="font-size:12px; color:#181512; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Royal Velvet Bridal Lehenga</strong>
                    <div class="sim-price-row" style="display:flex; align-items:center; gap:6px; margin:4px 0;">
                        <span class="sim-b2b" style="font-size:13px; font-weight:800; color:#15803D;">₹11,500</span>
                        <span style="font-size:10.5px; color:#94a3b8; text-decoration:line-through;">₹18,999</span>
                        <span class="dt-badge green sim-margin" style="font-size:9px; padding:1px 4px;">+39% Margin</span>
                    </div>
                    <div class="sim-moq" style="font-size:10px; color:#64748b; margin-bottom:6px;">MOQ: <strong>2 Sets (Boutique Special)</strong></div>
                    <button type="button" class="dt-btn-action-sm emerald sim-whatsapp" style="width:100%; height:26px; justify-content:center; font-size:10.5px; font-weight:700;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                        <span>WhatsApp Wholesale Lot</span>
                    </button>
                </div>

                <!-- Sim Product 3 -->
                <div class="dt-sim-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:10px; position:relative; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                    <div class="sim-badge-wrap" style="position:absolute; top:6px; left:6px; display:flex; flex-direction:column; gap:3px; z-index:2;">
                        <span class="dt-badge gold sim-silkmark" style="font-size:9px; padding:1px 5px;">Silk Mark</span>
                    </div>
                    <img src="/Frontend/Shop/Asset/images/product2.png" class="sim-card-img" style="width:100%; height:140px; object-fit:cover; border-radius:6px; margin-bottom:8px; border:1px solid #f1f5f9;">
                    <div class="sim-rating" style="display:flex; align-items:center; gap:3px; font-size:10px; color:#B8860B; font-weight:700; margin-bottom:3px;">
                        <span>★★★★☆</span> <span style="color:#64748b; font-weight:500;">(4.7)</span>
                    </div>
                    <strong style="font-size:12px; color:#181512; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Banarasi Kadhwa Brocade</strong>
                    <div class="sim-price-row" style="display:flex; align-items:center; gap:6px; margin:4px 0;">
                        <span class="sim-b2b" style="font-size:13px; font-weight:800; color:#15803D;">₹3,200</span>
                        <span style="font-size:10.5px; color:#94a3b8; text-decoration:line-through;">₹5,500</span>
                        <span class="dt-badge green sim-margin" style="font-size:9px; padding:1px 4px;">+41% Margin</span>
                    </div>
                    <div class="sim-moq" style="font-size:10px; color:#64748b; margin-bottom:6px;">MOQ: <strong>4 Pieces Bundle</strong></div>
                    <button type="button" class="dt-btn-action-sm emerald sim-whatsapp" style="width:100%; height:26px; justify-content:center; font-size:10.5px; font-weight:700;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                        <span>WhatsApp Wholesale Lot</span>
                    </button>
                </div>

                <!-- Sim Product 4 -->
                <div class="dt-sim-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:10px; position:relative; box-shadow:0 2px 6px rgba(0,0,0,0.04);">
                    <div class="sim-badge-wrap" style="position:absolute; top:6px; left:6px; display:flex; flex-direction:column; gap:3px; z-index:2;">
                        <span class="dt-badge green sim-depot" style="font-size:9px; padding:1px 5px;">Surat Ready Stock</span>
                    </div>
                    <img src="/Frontend/Shop/Asset/images/product4.png" class="sim-card-img" style="width:100%; height:140px; object-fit:cover; border-radius:6px; margin-bottom:8px; border:1px solid #f1f5f9;">
                    <div class="sim-rating" style="display:flex; align-items:center; gap:3px; font-size:10px; color:#B8860B; font-weight:700; margin-bottom:3px;">
                        <span>★★★★★</span> <span style="color:#64748b; font-weight:500;">(4.8)</span>
                    </div>
                    <strong style="font-size:12px; color:#181512; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Anarkali Festive Kurti Set</strong>
                    <div class="sim-price-row" style="display:flex; align-items:center; gap:6px; margin:4px 0;">
                        <span class="sim-b2b" style="font-size:13px; font-weight:800; color:#15803D;">₹1,650</span>
                        <span style="font-size:10.5px; color:#94a3b8; text-decoration:line-through;">₹2,999</span>
                        <span class="dt-badge green sim-margin" style="font-size:9px; padding:1px 4px;">+45% Margin</span>
                    </div>
                    <div class="sim-moq" style="font-size:10px; color:#64748b; margin-bottom:6px;">MOQ: <strong>6 Sets Pack</strong></div>
                    <button type="button" class="dt-btn-action-sm emerald sim-whatsapp" style="width:100%; height:26px; justify-content:center; font-size:10.5px; font-weight:700;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                        <span>WhatsApp Wholesale Lot</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
