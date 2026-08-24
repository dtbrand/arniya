<?php
/**
 * wholesale-segments.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Performance Segments & Cohorts Component (100% Dynamic)
 */
$segments = [
    [
        'id' => 'SEG-01',
        'name' => 'Mega Volume Wholesalers (GMV > ₹20L)',
        'partners' => 24,
        'share' => '48% of GMV',
        'criteria' => 'Orders > 40 • Avg AOV > ₹35,000 • 100% On-time Settle',
        'badge' => 'gold'
    ],
    [
        'id' => 'SEG-02',
        'name' => 'High-Frequency Regional Stockists',
        'partners' => 42,
        'share' => '32% of GMV',
        'criteria' => 'Re-order cycle < 14 days • Net 30 terms',
        'badge' => 'emerald'
    ],
    [
        'id' => 'SEG-03',
        'name' => 'Seasonal Festive Buyers',
        'partners' => 38,
        'share' => '15% of GMV',
        'criteria' => 'Q3 / Q4 Festive peak sourcing only',
        'badge' => 'blue'
    ],
    [
        'id' => 'SEG-04',
        'name' => 'Credit Watch & Dormant Accounts',
        'partners' => 20,
        'share' => '5% of GMV',
        'criteria' => 'No purchase in 60+ days OR Overdue balance',
        'badge' => 'crimson'
    ]
];
?>

<div style="display:flex; flex-direction:column; gap:16px;">

    <!-- ══ 1. 4-CARD COHORTS KPI RIBBON ══ -->
    <div class="dt-pricing-kpi-grid">
        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">TOTAL B2B COHORTS</span>
                <div class="dt-pricing-kpi-icon">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val">4 Active</div>
            <div class="dt-pricing-kpi-bot">
                <span>124 Wholesale Accounts</span>
                <span style="color:#8A681F; font-weight:800;">100% Classified</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">MEGA VOLUME SHARE</span>
                <div class="dt-pricing-kpi-icon emerald">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val" style="color:#15803D;">48% of GMV</div>
            <div class="dt-pricing-kpi-bot">
                <span>24 Top Wholesalers</span>
                <span style="color:#15803D; font-weight:800;">High Loyalty</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">AVG RE-ORDER FREQUENCY</span>
                <div class="dt-pricing-kpi-icon blue">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val" style="color:#1D4ED8;">14.2 Days</div>
            <div class="dt-pricing-kpi-bot">
                <span>Regional Stockists</span>
                <span style="color:#1D4ED8; font-weight:800;">High Velocity</span>
            </div>
        </div>

        <div class="dt-pricing-kpi-card">
            <div class="dt-pricing-kpi-top">
                <span class="dt-pricing-kpi-label">CAMPAIGN REACH</span>
                <div class="dt-pricing-kpi-icon emerald">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                </div>
            </div>
            <div class="dt-pricing-kpi-val" style="color:#15803D;">124 Partners</div>
            <div class="dt-pricing-kpi-bot">
                <span>Direct WhatsApp Delivery</span>
                <span style="color:#15803D; font-weight:800;">100% Opted-In</span>
            </div>
        </div>
    </div>

    <!-- ══ 2. MASTER COHORTS GRID CARD ══ -->
    <div class="dt-card">
        <div class="dt-card-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <h4 class="dt-card-title">Dynamic Wholesale Cohorts &amp; Performance Segments</h4>
            </div>
            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCreateCohortModal()">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Create Cohort</span>
            </button>
        </div>

        <div id="wholesaleCohortsGrid" style="padding:16px; display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
            <?php foreach ($segments as $s): ?>
                <div class="cohort-card-item" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:10px; padding:14px; display:flex; flex-direction:column; justify-content:space-between; gap:10px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                            <strong style="font-size:0.86rem; color:#181512;"><?php echo htmlspecialchars($s['name']); ?></strong>
                            <span class="dt-status-pill-clean <?php echo $s['badge']; ?>"><?php echo $s['partners']; ?> Accounts</span>
                        </div>
                        <div style="font-size:0.7rem; color:#78716C; margin-top:6px;">
                            Revenue Share: <strong style="color:#15803D;"><?php echo $s['share']; ?></strong>
                        </div>
                        <p style="font-size:0.72rem; color:#78716C; margin:6px 0 0 0; background:#FAF8F4; padding:6px 8px; border-radius:6px;">
                            <?php echo htmlspecialchars($s['criteria']); ?>
                        </p>
                    </div>

                    <div style="border-top:1px solid #F1ECE1; padding-top:8px; display:flex; justify-content:space-between; align-items:center; gap:8px;">
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openCohortAccountsModal('<?php echo $s['id']; ?>', '<?php echo addslashes($s['name']); ?>')">
                            <span>View Accounts</span>
                        </button>
                        <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="openCohortBroadcastModal('<?php echo $s['id']; ?>', '<?php echo addslashes($s['name']); ?>')">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#FFFFFF" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <span>WhatsApp Broadcast</span>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     1. CREATE COHORT MODAL
══════════════════════════════════════════════════════════════ -->
<div id="dtCreateCohortModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px); padding:16px;">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:480px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Create Wholesale Performance Cohort</strong>
            </div>
            <button type="button" onclick="closeWholesaleModal('dtCreateCohortModal')" class="dt-drawer-close" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitCreateCohort(event)">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Cohort Segment Name *</label>
                    <input type="text" id="newCohortNameInput" class="dt-wholesale-input" placeholder="e.g. VIP Southern Silk Wholesalers" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.85rem; font-weight:700; box-sizing:border-box;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Revenue Share (% GMV)</label>
                        <input type="text" id="newCohortShareInput" class="dt-wholesale-input" placeholder="e.g. 20% of GMV" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.85rem; font-weight:700; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Initial Accounts Count</label>
                        <input type="number" id="newCohortPartnersInput" class="dt-wholesale-input" value="15" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.85rem; font-weight:700; box-sizing:border-box;">
                    </div>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Classification Criteria / Logic *</label>
                    <textarea id="newCohortCriteriaInput" class="dt-wholesale-input" rows="2" placeholder="e.g. Orders > 25 • GMV > ₹10 Lakhs • South India Hubs" required style="width:100%; border:1.5px solid #EAE5D9; border-radius:8px; padding:8px 12px; font-size:0.82rem; font-weight:600; box-sizing:border-box;"></textarea>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:12px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtCreateCohortModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Save Cohort</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     2. VIEW COHORT ACCOUNTS MODAL
══════════════════════════════════════════════════════════════ -->
<div id="dtViewCohortAccountsModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px); padding:16px;">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:580px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <div>
                    <strong id="cohortAccountsModalTitle" style="font-size:0.95rem; font-weight:800; color:#181512;">Cohort Accounts Inspector</strong>
                    <small style="display:block; color:#78716C; font-size:0.7rem;">Active Wholesalers mapped to this performance tier.</small>
                </div>
            </div>
            <button type="button" onclick="closeWholesaleModal('dtViewCohortAccountsModal')" class="dt-drawer-close" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body" style="padding:18px; max-height:60vh; overflow-y:auto;">
            <div id="cohortAccountsListContainer" style="display:flex; flex-direction:column; gap:10px;">
                <!-- Populated dynamically via JS -->
            </div>
        </div>

        <div class="dt-modal-foot" style="padding:12px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtViewCohortAccountsModal')">Close</button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     3. WHATSAPP BROADCAST MODAL
══════════════════════════════════════════════════════════════ -->
<div id="dtCohortBroadcastModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px); padding:16px;">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #15803D; border-radius:14px; width:95%; max-width:540px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.4"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <div>
                    <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Targeted WhatsApp B2B Broadcast</strong>
                    <small id="broadcastCohortTitle" style="display:block; color:#15803D; font-size:0.7rem; font-weight:700;">Cohort Segment</small>
                </div>
            </div>
            <button type="button" onclick="closeWholesaleModal('dtCohortBroadcastModal')" class="dt-drawer-close" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; font-size:0.75rem; color:#78716C;">
                💡 This broadcast will be delivered simultaneously via DT Brand's verified WhatsApp Business API to all opted-in wholesalers in this cohort.
            </div>

            <div>
                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Broadcast Campaign Message</label>
                <textarea id="broadcastMessageTextarea" class="dt-wholesale-input" rows="6" style="width:100%; border:1.5px solid #EAE5D9; border-radius:8px; padding:10px 12px; font-size:0.85rem; font-family:monospace; box-sizing:border-box;"></textarea>
            </div>
        </div>

        <div class="dt-modal-foot" style="padding:12px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtCohortBroadcastModal')">Cancel</button>
            <button type="button" class="dt-btn dt-btn-emerald" onclick="triggerSegmentBroadcast()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FFFFFF" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                <span>Dispatch WhatsApp Campaign</span>
            </button>
        </div>
    </div>
</div>

