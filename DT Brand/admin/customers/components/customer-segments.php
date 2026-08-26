<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-segments.php — Customer Segmentation & Cohort Cards Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ CUSTOMER SEGMENTS GRID ══ -->
<div>
    <!-- Header & Quick Toolbar -->
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:18px;">
        <div>
            <h4 style="font-size:1rem; font-weight:800; color:#181512; margin:0;">Dynamic Customer Segments &amp; Cohorts</h4>
            <p style="font-size:0.75rem; color:#78716C; margin:3px 0 0 0;">Real-time automated customer clusters based on lifetime value (LTV), location, repeat frequency &amp; order history.</p>
        </div>

        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            <!-- Realtime Segment Filter Search -->
            <div style="position:relative; width:230px;">
                <input type="text" id="dtSegmentSearchInput" class="dt-input-field" placeholder="Search cohorts by name..." oninput="document.getElementById('dtSegmentSearchClearBtn').style.display = this.value.trim() ? 'flex' : 'none'; filterSegmentCards(this.value);" onkeyup="filterSegmentCards(this.value)" style="height:36px; font-size:0.78rem; padding:0 28px 0 12px; width:100%; box-sizing:border-box; background:#FFFFFF;">
                <button type="button" id="dtSegmentSearchClearBtn" onclick="document.getElementById('dtSegmentSearchInput').value=''; this.style.display='none'; filterSegmentCards('');" style="display:none; position:absolute; right:8px; top:50%; transform:translateY(-50%); background:#EAE5D9; border:none; color:#181512; cursor:pointer; font-size:0.68rem; width:18px; height:18px; border-radius:50%; align-items:center; justify-content:center; padding:0;">✕</button>
            </div>
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="height:36px; padding:0 12px; font-size:0.75rem; display:inline-flex; align-items:center; gap:5px;" onclick="filterSegmentCards(document.getElementById('dtSegmentSearchInput').value)">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <span>Search</span>
            </button>

            <button type="button" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px; height:36px; padding:0 14px;" onclick="openCreateSegmentModal()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Create Segment</span>
            </button>
        </div>
    </div>

    <!-- Segment Grid -->
    <div class="dt-segment-grid" id="dtSegmentsGridContainer">
        
        <!-- Segment 1: High Spenders -->
        <div class="dt-segment-card" data-segment-title="High Value VIP Spenders">
            <div class="dt-segment-head">
                <div class="dt-segment-title-wrap">
                    <div class="dt-segment-icon-box" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <h4 class="dt-segment-name">High Value VIP Spenders</h4>
                        <p class="dt-segment-sub">LTV &gt; ₹25,000 • Top 6.4% Buyers</p>
                    </div>
                </div>
                <span class="dt-status-pill active" style="font-size:0.65rem;">● Active</span>
            </div>

            <div class="dt-segment-conditions">
                <div class="dt-segment-cond-item">
                    <span>Criteria:</span>
                    <span class="dt-segment-cond-badge">Total Spent ≥ ₹25,000</span>
                    <span class="dt-segment-cond-badge">Orders ≥ 3</span>
                </div>
            </div>

            <div class="dt-segment-stats">
                <div>
                    <div class="dt-segment-count">312</div>
                    <small style="color:#78716C; font-size:0.68rem; font-weight:700;">Matching Shoppers</small>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="syncSegmentAudience('High Value VIP Spenders')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <span>Sync</span>
                    </button>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:4px 8px; font-size:0.72rem;" onclick="broadcastToSegment('High Value VIP Spenders', 312)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Segment 2: Surat & Gujarat Locals -->
        <div class="dt-segment-card" data-segment-title="Gujarat Hub Retail Shoppers">
            <div class="dt-segment-head">
                <div class="dt-segment-title-wrap">
                    <div class="dt-segment-icon-box" style="background:#DCFCE7; border-color:#86EFAC; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </div>
                    <div>
                        <h4 class="dt-segment-name">Gujarat Hub Retail Shoppers</h4>
                        <p class="dt-segment-sub">Surat, Ahmedabad, Vadodara, Rajkot</p>
                    </div>
                </div>
                <span class="dt-status-pill active" style="font-size:0.65rem;">● Active</span>
            </div>

            <div class="dt-segment-conditions">
                <div class="dt-segment-cond-item">
                    <span>Criteria:</span>
                    <span class="dt-segment-cond-badge">State = Gujarat (GJ)</span>
                </div>
            </div>

            <div class="dt-segment-stats">
                <div>
                    <div class="dt-segment-count">1,240</div>
                    <small style="color:#78716C; font-size:0.68rem; font-weight:700;">Matching Shoppers</small>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="syncSegmentAudience('Gujarat Hub')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <span>Sync</span>
                    </button>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:4px 8px; font-size:0.72rem;" onclick="broadcastToSegment('Gujarat Hub', 1240)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Segment 3: Dormant Accounts -->
        <div class="dt-segment-card" data-segment-title="Dormant Shoppers (> 60 Days)">
            <div class="dt-segment-head">
                <div class="dt-segment-title-wrap">
                    <div class="dt-segment-icon-box" style="background:#FEF3C7; border-color:#FCD34D; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <h4 class="dt-segment-name">Dormant Shoppers (&gt; 60 Days)</h4>
                        <p class="dt-segment-sub">Registered with 0 purchases in last 2 months</p>
                    </div>
                </div>
                <span class="dt-status-pill active" style="font-size:0.65rem;">● Active</span>
            </div>

            <div class="dt-segment-conditions">
                <div class="dt-segment-cond-item">
                    <span>Criteria:</span>
                    <span class="dt-segment-cond-badge">Last Order &gt; 60 Days</span>
                </div>
            </div>

            <div class="dt-segment-stats">
                <div>
                    <div class="dt-segment-count">640</div>
                    <small style="color:#78716C; font-size:0.68rem; font-weight:700;">Matching Shoppers</small>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="syncSegmentAudience('Dormant Shoppers')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <span>Sync</span>
                    </button>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:4px 8px; font-size:0.72rem;" onclick="broadcastToSegment('Dormant Shoppers', 640)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Re-Engage</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Segment 4: International Exporters & NRI Buyers -->
        <div class="dt-segment-card" data-segment-title="International Exporters & NRI Buyers">
            <div class="dt-segment-head">
                <div class="dt-segment-title-wrap">
                    <div class="dt-segment-icon-box" style="background:#EFF6FF; border-color:#BFDBFE; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                    </div>
                    <div>
                        <h4 class="dt-segment-name">International &amp; NRI Buyers</h4>
                        <p class="dt-segment-sub">USA, UAE, UK, Canada, Australia</p>
                    </div>
                </div>
                <span class="dt-status-pill active" style="font-size:0.65rem;">● Active</span>
            </div>

            <div class="dt-segment-conditions">
                <div class="dt-segment-cond-item">
                    <span>Criteria:</span>
                    <span class="dt-segment-cond-badge">Country ≠ India</span>
                    <span class="dt-segment-cond-badge">Global Air Courier</span>
                </div>
            </div>

            <div class="dt-segment-stats">
                <div>
                    <div class="dt-segment-count">486</div>
                    <small style="color:#78716C; font-size:0.68rem; font-weight:700;">Matching Shoppers</small>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="syncSegmentAudience('International Buyers')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <span>Sync</span>
                    </button>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:4px 8px; font-size:0.72rem;" onclick="broadcastToSegment('International Buyers', 486)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Segment 5: B2B Wholesale Lot Buyers -->
        <div class="dt-segment-card" data-segment-title="B2B Wholesale Catalog Lot Orderers">
            <div class="dt-segment-head">
                <div class="dt-segment-title-wrap">
                    <div class="dt-segment-icon-box" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <h4 class="dt-segment-name">B2B Wholesale Lot Orderers</h4>
                        <p class="dt-segment-sub">Catalog Re-orderers &amp; Resellers</p>
                    </div>
                </div>
                <span class="dt-status-pill active" style="font-size:0.65rem;">● Active</span>
            </div>

            <div class="dt-segment-conditions">
                <div class="dt-segment-cond-item">
                    <span>Criteria:</span>
                    <span class="dt-segment-cond-badge">Min Basket ≥ 12 Sarees</span>
                    <span class="dt-segment-cond-badge">Tier = Wholesale</span>
                </div>
            </div>

            <div class="dt-segment-stats">
                <div>
                    <div class="dt-segment-count">890</div>
                    <small style="color:#78716C; font-size:0.68rem; font-weight:700;">Matching Shoppers</small>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="syncSegmentAudience('Wholesale Buyers')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <span>Sync</span>
                    </button>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:4px 8px; font-size:0.72rem;" onclick="broadcastToSegment('Wholesale Buyers', 890)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Segment 6: Recent Festive Silk Repeaters -->
        <div class="dt-segment-card" data-segment-title="Festive Silk Repeaters">
            <div class="dt-segment-head">
                <div class="dt-segment-title-wrap">
                    <div class="dt-segment-icon-box" style="background:#FDF2F8; border-color:#FBCFE8; color:#DB2777;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </div>
                    <div>
                        <h4 class="dt-segment-name">Festive Silk Repeaters</h4>
                        <p class="dt-segment-sub">Wedding &amp; Festival Season Shoppers</p>
                    </div>
                </div>
                <span class="dt-status-pill active" style="font-size:0.65rem;">● Active</span>
            </div>

            <div class="dt-segment-conditions">
                <div class="dt-segment-cond-item">
                    <span>Criteria:</span>
                    <span class="dt-segment-cond-badge">Tags = Saree Lover</span>
                    <span class="dt-segment-cond-badge">Orders ≥ 2</span>
                </div>
            </div>

            <div class="dt-segment-stats">
                <div>
                    <div class="dt-segment-count">512</div>
                    <small style="color:#78716C; font-size:0.68rem; font-weight:700;">Matching Shoppers</small>
                </div>
                <div style="display:flex; align-items:center; gap:6px;">
                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px;" onclick="syncSegmentAudience('Festive Silk Repeaters')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 4v6h-6"></path><path d="M1 20v-6h6"></path><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <span>Sync</span>
                    </button>
                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="display:inline-flex; align-items:center; gap:4px; padding:4px 8px; font-size:0.72rem;" onclick="broadcastToSegment('Festive Silk Repeaters', 512)">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>WhatsApp</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

