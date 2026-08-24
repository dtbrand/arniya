<?php
/**
 * segments.php — DT Brand's & Jai Hanuman Tex
 * Reseller Segments & Performance Cohorts
 */
$page_title = "Reseller Segments & Cohorts";
$active_nav = "resellers";
$active_subnav = "segments";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Segments - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-segments.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px; margin-bottom:24px;">
                <!-- ══ TOP HEADER ══ -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Reseller Performance Segments</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">4 Dynamic Clusters</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Group resellers by monthly GMV velocity, order regularity, credit repayment speed, and margin tier.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="openCreateSegmentModal()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>+ New Segment</span>
                        </button>
                    </div>
                </div>

                <!-- ══ SEGMENT COMPONENT ══ -->
                <?php include_once __DIR__ . '/components/reseller-segments.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     INTERACTIVE MODALS FOR SEGMENT HUB
══════════════════════════════════════════════════════════════ -->

<!-- 1. Create New Segment Modal -->
<div id="dtCreateSegmentModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:500px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Define New Performance Cohort</strong>
            </div>
            <button type="button" onclick="closeSegmentModal('dtCreateSegmentModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitCreateSegment(event)">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Cohort / Segment Name *</label>
                    <input type="text" id="newSegmentName" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. Festival Pre-Bookers" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Min Quarterly GMV (₹) *</label>
                        <input type="number" id="newSegmentGmv" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. 300000" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Margin Discount (%) *</label>
                        <input type="number" id="newSegmentMargin" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. 25" min="5" max="50" required>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Qualification Criteria &amp; Rules</label>
                    <input type="text" id="newSegmentRules" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. Minimum 15 orders/month with zero payment bounce">
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeSegmentModal('dtCreateSegmentModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Save Cohort Rule</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Re-assign Reseller Cohort Modal -->
<div id="dtReassignCohortModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #8A681F; border-radius:14px; width:95%; max-width:480px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Re-assign Partner Cohort</strong>
            </div>
            <button type="button" onclick="closeSegmentModal('dtReassignCohortModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitReassignCohort(event)">
            <input type="hidden" id="reassignPartnerId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FAF8F4; padding:12px; border-radius:8px; border:1px solid #EAE5D9;">
                    <span style="font-size:0.7rem; color:#78716C; font-weight:700;">PARTNER PROFILE:</span>
                    <strong id="reassignPartnerName" style="font-size:0.95rem; color:#181512; display:block;">Arniya Silk Heritage (RES-1048)</strong>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Select New Performance Cohort *</label>
                    <select id="reassignTargetCohortSelect" class="dt-cust-select" style="width:100%; height:38px; border-radius:8px;">
                        <option value="elite">Elite Power Resellers (30% Margin)</option>
                        <option value="dropship">High-Frequency Dropshippers (22% Margin)</option>
                        <option value="boutique">Emerging Social Boutiques (15% Margin)</option>
                        <option value="dormant">Credit Watch &amp; Dormant (Audit Needed)</option>
                    </select>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeSegmentModal('dtReassignCohortModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Update Partner Cohort</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. WhatsApp Cohort Broadcast Modal -->
<div id="dtBroadcastCohortModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #15803D; border-radius:14px; width:95%; max-width:480px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.4"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Targeted WhatsApp Broadcast</strong>
            </div>
            <button type="button" onclick="closeSegmentModal('dtBroadcastCohortModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitCohortBroadcast(event)">
            <input type="hidden" id="broadcastCohortId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="background:#DCFCE7; border:1px solid #86EFAC; padding:10px 12px; border-radius:8px;">
                    <span style="font-size:0.7rem; color:#15803D; font-weight:800; display:block;">TARGET RECIPIENT COHORT:</span>
                    <strong id="broadcastCohortTitle" style="font-size:0.95rem; color:#181512; display:block;">High-Frequency Dropshippers</strong>
                    <small id="broadcastCohortCount" style="color:#15803D; font-weight:700;">94 Verified WhatsApp Partners</small>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Select Broadcast Template</label>
                    <select class="dt-cust-select" style="width:100%; height:38px; border-radius:8px;">
                        <option>New Festive Silk Saree Catalog Release (1-Click PDF Link)</option>
                        <option>Exclusive 5% Extra Margin Booster on Pure Katan Sarees</option>
                        <option>Dropship Courier Priority SLA Update</option>
                        <option>Payment Credit Renewal &amp; Settlement Reminder</option>
                    </select>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeSegmentModal('dtBroadcastCohortModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-emerald">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FFFFFF" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Launch Cohort Broadcast</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-segments.js?v=<?php echo time(); ?>"></script>
</body>
</html>
