<?php
/**
 * display-settings-panel.php — Storefront Display Controls & Live Simulator Component
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */
?>

<!-- ── 1. Master Luxury Ambient Hero Overview Card ── -->
<div class="dt-disp-hero-banner">
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px; height:40px; border-radius:10px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 100%); display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(212,175,55,0.4);">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="#111827" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
            </div>
            <div>
                <h2 style="margin:0; font-size:16px; font-weight:800; color:#FFFFFF; text-shadow:0 2px 4px rgba(0,0,0,0.6);">Storefront Display &amp; Visual Architecture</h2>
                <span style="font-size:11.5px; color:#FEE685; font-weight:600;">Control B2B &amp; B2C grid density, card aspect ratios, and wholesale price badges.</span>
            </div>
        </div>
        <div style="display:flex; gap:8px;">
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="copyDisplayJson()" style="height:32px; padding:0 12px; font-size:11.5px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                <span>Export JSON Config</span>
            </button>
        </div>
    </div>

    <!-- Hero KPI Micro-Ribbon -->
    <div class="dt-disp-hero-grid">
        <div class="dt-disp-hero-stat-box">
            <div class="dt-disp-hero-stat-label">Active Desktop Grid</div>
            <div class="dt-disp-hero-stat-val" id="statActiveCols">4-Column Grid</div>
        </div>
        <div class="dt-disp-hero-stat-box">
            <div class="dt-disp-hero-stat-label">Product Card Ratio</div>
            <div class="dt-disp-hero-stat-val" id="statActiveRatio">3:4 Saree Fashion</div>
        </div>
        <div class="dt-disp-hero-stat-box">
            <div class="dt-disp-hero-stat-label">Mobile Catalog View</div>
            <div class="dt-disp-hero-stat-val">2-Col High Density</div>
        </div>
        <div class="dt-disp-hero-stat-box">
            <div class="dt-disp-hero-stat-label">Live Dispatch Tag</div>
            <div class="dt-disp-hero-stat-val" style="color:#86EFAC;">Surat 24h Active</div>
        </div>
    </div>
</div>

<!-- ── 2. Master 2-Column Display Settings Workspace ── -->
<div class="dt-disp-workspace">

    <!-- ── LEFT COLUMN: Configuration Controls ── -->
    <div class="dt-disp-controls-col">

        <!-- 1. Grid & Columns Density -->
        <div class="dt-disp-card">
            <div class="dt-disp-card-head">
                <h3 class="dt-disp-card-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>Storefront Grid Density &amp; Responsive Columns</span>
                </h3>
                <span class="adm-badge gold" style="font-size:10px; font-weight:700;">Layout</span>
            </div>
            <div class="dt-disp-card-body">
                <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Desktop Grid Columns (Large Screens &gt; 1200px)</label>
                <div class="dt-tile-grid">
                    <div class="dt-tile-opt" data-target="desktopCols" data-val="2">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="8" height="18" rx="2"></rect><rect x="13" y="3" width="8" height="18" rx="2"></rect></svg></div>
                        <span class="dt-tile-label">2 Cols</span>
                        <span class="dt-tile-sub">Large Cards</span>
                    </div>
                    <div class="dt-tile-opt" data-target="desktopCols" data-val="3">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="5" height="18" rx="1"></rect><rect x="9.5" y="3" width="5" height="18" rx="1"></rect><rect x="17" y="3" width="5" height="18" rx="1"></rect></svg></div>
                        <span class="dt-tile-label">3 Cols</span>
                        <span class="dt-tile-sub">Standard</span>
                    </div>
                    <div class="dt-tile-opt active" data-target="desktopCols" data-val="4">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="4" height="18" rx="1"></rect><rect x="7.5" y="3" width="4" height="18" rx="1"></rect><rect x="13" y="3" width="4" height="18" rx="1"></rect><rect x="18.5" y="3" width="4" height="18" rx="1"></rect></svg></div>
                        <span class="dt-tile-label">4 Cols</span>
                        <span class="dt-tile-sub">Recommended</span>
                    </div>
                    <div class="dt-tile-opt" data-target="desktopCols" data-val="5">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="3" height="18"></rect><rect x="6.5" y="3" width="3" height="18"></rect><rect x="11" y="3" width="3" height="18"></rect><rect x="15.5" y="3" width="3" height="18"></rect><rect x="20" y="3" width="3" height="18"></rect></svg></div>
                        <span class="dt-tile-label">5 Cols</span>
                        <span class="dt-tile-sub">High Density</span>
                    </div>
                    <div class="dt-tile-opt" data-target="desktopCols" data-val="6">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="2.5" height="18"></rect><rect x="6" y="3" width="2.5" height="18"></rect><rect x="10" y="3" width="2.5" height="18"></rect><rect x="14" y="3" width="2.5" height="18"></rect><rect x="18" y="3" width="2.5" height="18"></rect></svg></div>
                        <span class="dt-tile-label">6 Cols</span>
                        <span class="dt-tile-sub">Ultra Wholesale</span>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:14px;">
                    <div>
                        <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Tablet Grid Density (iPad / 768px - 1024px)</label>
                        <select id="selTabletCols" class="dt-disp-select" style="width:100%; height:36px; padding:0 10px; border:1px solid #CBD5E1; border-radius:6px; font-size:12px; font-weight:600; color:#1E293B;">
                            <option value="2">2 Columns (Standard Tablet)</option>
                            <option value="3">3 Columns (High Density)</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Mobile Grid Density (&lt; 600px)</label>
                        <select id="selMobileCols" class="dt-disp-select" style="width:100%; height:36px; padding:0 10px; border:1px solid #CBD5E1; border-radius:6px; font-size:12px; font-weight:600; color:#1E293B;">
                            <option value="2">2 Columns (Wholesale High Density)</option>
                            <option value="1">1 Column (Full Width Big Card)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Product Card Media & Image Aspect Ratio -->
        <div class="dt-disp-card">
            <div class="dt-disp-card-head">
                <h3 class="dt-disp-card-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    <span>Product Card Media &amp; Image Ratios</span>
                </h3>
                <span class="adm-badge gold" style="font-size:10px; font-weight:700;">Aesthetics</span>
            </div>
            <div class="dt-disp-card-body">
                <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Image Aspect Ratio</label>
                <div class="dt-tile-grid">
                    <div class="dt-tile-opt" data-target="aspectRatio" data-val="1-1">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"></rect></svg></div>
                        <span class="dt-tile-label">1:1 Square</span>
                        <span class="dt-tile-sub">Standard</span>
                    </div>
                    <div class="dt-tile-opt active" data-target="aspectRatio" data-val="3-4">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"></rect></svg></div>
                        <span class="dt-tile-label">3:4 Portrait</span>
                        <span class="dt-tile-sub">Saree Fashion</span>
                    </div>
                    <div class="dt-tile-opt" data-target="aspectRatio" data-val="4-5">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"></rect></svg></div>
                        <span class="dt-tile-label">4:5 Luxury</span>
                        <span class="dt-tile-sub">Lookbook</span>
                    </div>
                    <div class="dt-tile-opt" data-target="aspectRatio" data-val="9-16">
                        <div class="dt-tile-icon"><svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><rect x="6" y="2" width="12" height="20" rx="2"></rect></svg></div>
                        <span class="dt-tile-label">9:16 Reel</span>
                        <span class="dt-tile-sub">Mobile Story</span>
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Card Hover Animation Style</label>
                    <div class="dt-tile-grid">
                        <div class="dt-tile-opt active" data-target="hoverEffect" data-val="flip">
                            <span class="dt-tile-label">Secondary Photo Flip</span>
                            <span class="dt-tile-sub">Angle 2 Reveal</span>
                        </div>
                        <div class="dt-tile-opt" data-target="hoverEffect" data-val="zoom">
                            <span class="dt-tile-label">Smooth Zoom &amp; Pan</span>
                            <span class="dt-tile-sub">Fabric Details</span>
                        </div>
                        <div class="dt-tile-opt" data-target="hoverEffect" data-val="video">
                            <span class="dt-tile-label">Reel Video Preview</span>
                            <span class="dt-tile-sub">Autoplay on Hover</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Wholesale Badges & Metadata Toggles -->
        <div class="dt-disp-card">
            <div class="dt-disp-card-head">
                <h3 class="dt-disp-card-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Wholesale Badges, Tags &amp; Pricing Visibility</span>
                </h3>
                <span class="adm-badge gold" style="font-size:10px; font-weight:700;">Visibility</span>
            </div>
            <div class="dt-disp-card-body">
                
                <div class="dt-toggle-row">
                    <div class="dt-toggle-meta">
                        <div class="dt-toggle-title">
                            <span>Discount Percentage Badge</span>
                            <span class="adm-badge crimson" style="font-size:9px;">40% OFF</span>
                        </div>
                        <div class="dt-toggle-desc">Show retail discount percentage pill in the top-left corner.</div>
                    </div>
                    <label class="dt-switch">
                        <input type="checkbox" id="chkShowDiscount" checked>
                        <span class="dt-slider"></span>
                    </label>
                </div>

                <div class="dt-toggle-row">
                    <div class="dt-toggle-meta">
                        <div class="dt-toggle-title">
                            <span>Wholesale Minimum Order Quantity (MOQ) Badge</span>
                            <span class="adm-badge gold" style="font-size:9px;">MOQ: 8 pcs</span>
                        </div>
                        <div class="dt-toggle-desc">Show wholesale lot quantity and bulk price tier on card footer.</div>
                    </div>
                    <label class="dt-switch">
                        <input type="checkbox" id="chkShowMoq" checked>
                        <span class="dt-slider"></span>
                    </label>
                </div>

                <div class="dt-toggle-row">
                    <div class="dt-toggle-meta">
                        <div class="dt-toggle-title">
                            <span>Reseller Margin Pill</span>
                            <span class="adm-badge emerald" style="font-size:9px;">Earn ₹1,040</span>
                        </div>
                        <div class="dt-toggle-desc">Show estimated profit margin for logged-in verified resellers.</div>
                    </div>
                    <label class="dt-switch">
                        <input type="checkbox" id="chkShowMargin" checked>
                        <span class="dt-slider"></span>
                    </label>
                </div>

                <div class="dt-toggle-row">
                    <div class="dt-toggle-meta">
                        <div class="dt-toggle-title">
                            <span>Surat Central Depot Dispatch Pill</span>
                            <span class="adm-badge emerald" style="font-size:9px;">24h Dispatch</span>
                        </div>
                        <div class="dt-toggle-desc">Indicate ready inventory status from Surat warehouse.</div>
                    </div>
                    <label class="dt-switch">
                        <input type="checkbox" id="chkShowDispatch" checked>
                        <span class="dt-slider"></span>
                    </label>
                </div>

                <div class="dt-toggle-row">
                    <div class="dt-toggle-meta">
                        <div class="dt-toggle-title">
                            <span>Star Ratings &amp; Review Count</span>
                            <span style="color:#B45309; font-size:10px; font-weight:800;">★ 4.9 (128)</span>
                        </div>
                        <div class="dt-toggle-desc">Display social proof star reviews under product title.</div>
                    </div>
                    <label class="dt-switch">
                        <input type="checkbox" id="chkShowRating" checked>
                        <span class="dt-slider"></span>
                    </label>
                </div>

                <div class="dt-toggle-row">
                    <div class="dt-toggle-meta">
                        <div class="dt-toggle-title">
                            <span>Fabric &amp; Weave Tag</span>
                            <span style="color:#8A681F; font-size:9px; font-weight:700; text-transform:uppercase;">Pure Kanjivaram Silk</span>
                        </div>
                        <div class="dt-toggle-desc">Show primary taxonomy category label above product title.</div>
                    </div>
                    <label class="dt-switch">
                        <input type="checkbox" id="chkShowFabricTag" checked>
                        <span class="dt-slider"></span>
                    </label>
                </div>

                <div class="dt-toggle-row">
                    <div class="dt-toggle-meta">
                        <div class="dt-toggle-title">
                            <span>Direct 1-Click WhatsApp B2B Enquiry Button</span>
                        </div>
                        <div class="dt-toggle-desc">Display direct green WhatsApp lot order button on product card.</div>
                    </div>
                    <label class="dt-switch">
                        <input type="checkbox" id="chkShowWhatsAppBtn" checked>
                        <span class="dt-slider"></span>
                    </label>
                </div>

            </div>
        </div>

        <!-- 4. Pagination & Sidebar Placement -->
        <div class="dt-disp-card">
            <div class="dt-disp-card-head">
                <h3 class="dt-disp-card-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                    <span>Pagination Engine &amp; Sidebar Navigation</span>
                </h3>
                <span class="adm-badge gold" style="font-size:10px; font-weight:700;">Navigation</span>
            </div>
            <div class="dt-disp-card-body">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Products Loaded Per Page</label>
                        <select id="selPerPage" class="dt-disp-select" style="width:100%; height:36px; padding:0 10px; border:1px solid #CBD5E1; border-radius:6px; font-size:12px; font-weight:600; color:#1E293B;">
                            <option value="12">12 SKUs</option>
                            <option value="24" selected>24 SKUs (Optimal)</option>
                            <option value="48">48 SKUs</option>
                            <option value="96">96 SKUs (High Speed Wholesale)</option>
                            <option value="120">120 SKUs (Surat Depot Batch)</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Guest Wholesale Price Visibility</label>
                        <select id="selGuestPriceMode" class="dt-disp-select" style="width:100%; height:36px; padding:0 10px; border:1px solid #CBD5E1; border-radius:6px; font-size:12px; font-weight:600; color:#1E293B;">
                            <option value="wholesale_blur" selected>Show "Login to View Wholesale Rate"</option>
                            <option value="retail_only">Show Retail Price Only</option>
                            <option value="public_all">Show All Wholesale Rates Publicly</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Catalog Pagination Mode</label>
                    <div class="dt-tile-grid">
                        <div class="dt-tile-opt active" data-target="paginationMode" data-val="loadmore">
                            <span class="dt-tile-label">"Load More" Button</span>
                            <span class="dt-tile-sub">Gold Luxury Button</span>
                        </div>
                        <div class="dt-tile-opt" data-target="paginationMode" data-val="infinite">
                            <span class="dt-tile-label">Infinite Auto-Scroll</span>
                            <span class="dt-tile-sub">Smooth Scroll</span>
                        </div>
                        <div class="dt-tile-opt" data-target="paginationMode" data-val="classic">
                            <span class="dt-tile-label">Classic Numbered</span>
                            <span class="dt-tile-sub">1, 2, 3 ... Next</span>
                        </div>
                    </div>
                </div>

                <div style="margin-top:14px;">
                    <label style="font-size:11.5px; font-weight:700; color:#334155; display:block; margin-bottom:4px;">Filter Sidebar Placement</label>
                    <div class="dt-tile-grid">
                        <div class="dt-tile-opt active" data-target="sidebarPlacement" data-val="left">
                            <span class="dt-tile-label">Sticky Left Sidebar</span>
                            <span class="dt-tile-sub">Standard Desktop</span>
                        </div>
                        <div class="dt-tile-opt" data-target="sidebarPlacement" data-val="top">
                            <span class="dt-tile-label">Top Horizontal Strip</span>
                            <span class="dt-tile-sub">Full Width Grid</span>
                        </div>
                        <div class="dt-tile-opt" data-target="sidebarPlacement" data-val="drawer">
                            <span class="dt-tile-label">Off-Canvas Drawer</span>
                            <span class="dt-tile-sub">Mobile Flyout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ── RIGHT COLUMN: Real-Time Interactive Simulator ── -->
    <div class="dt-disp-preview-col">
        <div class="dt-sim-panel">
            
            <!-- Simulator Header with Viewport Switcher -->
            <div class="dt-sim-head">
                <div class="dt-sim-title">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                    <span>Real-Time Storefront Simulator</span>
                </div>
                <div class="dt-sim-viewport-tabs">
                    <button type="button" class="dt-sim-tab-btn active" data-mode="desktop" title="Desktop View (4 Cols)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span>Desktop</span>
                    </button>
                    <button type="button" class="dt-sim-tab-btn" data-mode="tablet" title="Tablet View (2 Cols)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        <span>Tablet</span>
                    </button>
                    <button type="button" class="dt-sim-tab-btn" data-mode="mobile" title="Mobile View (2 Cols Wholesale)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        <span>Mobile</span>
                    </button>
                </div>
            </div>

            <!-- Simulator Live Canvas Stage -->
            <div class="dt-sim-stage-wrap">
                <div class="dt-sim-grid cols-4" id="dtSimGrid">
                    
                    <!-- Mock Card 1 -->
                    <div class="dt-sim-card">
                        <div class="dt-sim-img-wrap ratio-3-4">
                            <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Kanjivaram Silk">
                            <span class="dt-sim-badge-discount">40% OFF</span>
                            <span class="dt-sim-badge-moq">MOQ: 8 pcs</span>
                            <span class="dt-sim-badge-dispatch">Surat 24h</span>
                        </div>
                        <div class="dt-sim-meta">
                            <div class="dt-sim-cat-tag">Pure Silk Sarees</div>
                            <div class="dt-sim-title-text" title="Kanjivaram Pure Silk Gold Zari Saree">Kanjivaram Pure Silk Gold Zari Saree</div>
                            <div class="dt-sim-pricing-row">
                                <span class="dt-sim-retail-price">₹4,490</span>
                                <span class="dt-sim-mrp">₹5,990</span>
                                <span class="dt-sim-margin-tag">Earn ₹1,040</span>
                            </div>
                            <div class="dt-sim-rating-row">
                                <span>★★★★★</span>
                                <span>(128)</span>
                            </div>
                            <button type="button" class="dt-sim-btn-wa">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                                <span>Order on WhatsApp</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mock Card 2 -->
                    <div class="dt-sim-card">
                        <div class="dt-sim-img-wrap ratio-3-4">
                            <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" alt="Banarasi Brocade">
                            <span class="dt-sim-badge-discount">35% OFF</span>
                            <span class="dt-sim-badge-moq">MOQ: 6 pcs</span>
                            <span class="dt-sim-badge-dispatch">Surat 24h</span>
                        </div>
                        <div class="dt-sim-meta">
                            <div class="dt-sim-cat-tag">Banarasi Brocade</div>
                            <div class="dt-sim-title-text" title="Banarasi Royal Brocade Weave Saree">Banarasi Royal Brocade Weave Saree</div>
                            <div class="dt-sim-pricing-row">
                                <span class="dt-sim-retail-price">₹3,890</span>
                                <span class="dt-sim-mrp">₹4,990</span>
                                <span class="dt-sim-margin-tag">Earn ₹890</span>
                            </div>
                            <div class="dt-sim-rating-row">
                                <span>★★★★★</span>
                                <span>(94)</span>
                            </div>
                            <button type="button" class="dt-sim-btn-wa">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                                <span>Order on WhatsApp</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mock Card 3 -->
                    <div class="dt-sim-card">
                        <div class="dt-sim-img-wrap ratio-3-4">
                            <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" alt="Bridal Lehenga">
                            <span class="dt-sim-badge-discount">25% OFF</span>
                            <span class="dt-sim-badge-moq">MOQ: 2 pcs</span>
                            <span class="dt-sim-badge-dispatch">Surat 24h</span>
                        </div>
                        <div class="dt-sim-meta">
                            <div class="dt-sim-cat-tag">Bridal Lehengas</div>
                            <div class="dt-sim-title-text" title="Crimson Bridal Handcrafted Zardosi Lehenga">Crimson Bridal Handcrafted Zardosi Lehenga</div>
                            <div class="dt-sim-pricing-row">
                                <span class="dt-sim-retail-price">₹16,490</span>
                                <span class="dt-sim-mrp">₹21,990</span>
                                <span class="dt-sim-margin-tag">Earn ₹3,500</span>
                            </div>
                            <div class="dt-sim-rating-row">
                                <span>★★★★★</span>
                                <span>(42)</span>
                            </div>
                            <button type="button" class="dt-sim-btn-wa">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                                <span>Order on WhatsApp</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mock Card 4 -->
                    <div class="dt-sim-card">
                        <div class="dt-sim-img-wrap ratio-3-4">
                            <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Festive Kurti Set">
                            <span class="dt-sim-badge-discount">30% OFF</span>
                            <span class="dt-sim-badge-moq">MOQ: 10 pcs</span>
                            <span class="dt-sim-badge-dispatch">Surat 24h</span>
                        </div>
                        <div class="dt-sim-meta">
                            <div class="dt-sim-cat-tag">Designer Kurtis</div>
                            <div class="dt-sim-title-text" title="Chanderi Foil Printed Festive Kurti Set">Chanderi Foil Printed Festive Kurti Set</div>
                            <div class="dt-sim-pricing-row">
                                <span class="dt-sim-retail-price">₹1,650</span>
                                <span class="dt-sim-mrp">₹2,350</span>
                                <span class="dt-sim-margin-tag">Earn ₹450</span>
                            </div>
                            <div class="dt-sim-rating-row">
                                <span>★★★★★</span>
                                <span>(67)</span>
                            </div>
                            <button type="button" class="dt-sim-btn-wa">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                                <span>Order on WhatsApp</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Simulator Bottom Save Bar -->
            <div style="background:#F8FAFC; padding:12px 16px; border-top:1px solid #E2E8F0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
                <span style="font-size:11px; color:#64748B; font-weight:600;">✨ Changes update live in preview</span>
                <div style="display:flex; gap:6px;">
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="resetDisplayDefaults()" style="height:32px; padding:0 12px; font-size:11.5px;">Reset</button>
                    <button type="button" class="dt-btn-action-sm gold" onclick="saveDisplaySettings()" style="height:32px; padding:0 14px; font-size:11.5px;">Save Settings</button>
                </div>
            </div>

        </div>
    </div>

</div>
