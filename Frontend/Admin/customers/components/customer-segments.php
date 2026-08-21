<?php
/**
 * customer-segments.php — Customer Segmentation & Cohort Cards Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ CUSTOMER SEGMENTS GRID ══ -->
<div>
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
        <div>
            <h4 style="font-size:0.95rem; font-weight:800; color:#181512; margin:0;">Dynamic Customer Segments</h4>
            <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Automated cohorts based on lifetime spend, order frequency and location.</p>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="createNewSegmentModal()">+ Create Segment</button>
    </div>

    <div class="dt-segment-grid">
        <!-- Segment 1: High Spenders -->
        <div class="dt-segment-card">
            <div class="dt-segment-head">
                <div class="dt-segment-title-wrap">
                    <div class="dt-segment-icon-box">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <h4 class="dt-segment-name">High Value VIP Spenders</h4>
                        <p class="dt-segment-sub">LTV > ₹25,000 • Top 6.4% Buyers</p>
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
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="syncSegmentAudience('VIP Spenders')">Sync Audience ↗</button>
            </div>
        </div>

        <!-- Segment 2: Surat & Gujarat Locals -->
        <div class="dt-segment-card">
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
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="syncSegmentAudience('Gujarat Hub')">Sync Audience ↗</button>
            </div>
        </div>

        <!-- Segment 3: Dormant Accounts -->
        <div class="dt-segment-card">
            <div class="dt-segment-head">
                <div class="dt-segment-title-wrap">
                    <div class="dt-segment-icon-box" style="background:#FEF3C7; border-color:#FCD34D; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <h4 class="dt-segment-name">Dormant Shoppers (> 60 Days)</h4>
                        <p class="dt-segment-sub">Registered with 0 purchases in last 2 months</p>
                    </div>
                </div>
                <span class="dt-status-pill active" style="font-size:0.65rem;">● Active</span>
            </div>

            <div class="dt-segment-conditions">
                <div class="dt-segment-cond-item">
                    <span>Criteria:</span>
                    <span class="dt-segment-cond-badge">Last Order > 60 Days</span>
                </div>
            </div>

            <div class="dt-segment-stats">
                <div>
                    <div class="dt-segment-count">640</div>
                    <small style="color:#78716C; font-size:0.68rem; font-weight:700;">Matching Shoppers</small>
                </div>
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="syncSegmentAudience('Dormant Shoppers')">Sync Audience ↗</button>
            </div>
        </div>
    </div>
</div>
