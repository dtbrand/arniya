<?php
/**
 * wholesale-profile.php — DT Brand's & Jai Hanuman Tex
 * Master Luxury 360 Wholesale Partner Profile & Ambient Glass Hero Component (100% Dynamic)
 */

require_once __DIR__ . '/wholesale-data.php';

$whl_id = isset($_GET['id']) ? $_GET['id'] : (isset($wholesale['id']) ? $wholesale['id'] : 'WHL-8012');
$wholesale = getWholesalePartner($whl_id);

$sanctioned = max(0, (float)$wholesale['sanctioned_limit']);
$utilized = max(0, (float)$wholesale['utilized_credit']);
$available = max(0, (float)$wholesale['available_credit']);

$util_pct = $sanctioned > 0 ? round(($utilized / $sanctioned) * 100, 1) : 0;
$avail_pct = $sanctioned > 0 ? round(100 - $util_pct, 1) : 100;
?>

<div style="display:flex; flex-direction:column; gap:16px;">
    <!-- ══ MASTER LUXURY AMBIENT GLASS HERO BANNER ══ -->
    <div class="dt-wholesale-hero-luxury">
        <div class="dt-wholesale-hero-top">
            <!-- Left Info Block -->
            <div style="display:flex; align-items:center; gap:14px;">
                <div class="dt-wholesale-avatar-box"><?php echo htmlspecialchars($wholesale['initials']); ?></div>
                <div>
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <h2 style="font-size:1.25rem; font-weight:900; color:#FFFFFF; margin:0;"><?php echo htmlspecialchars($wholesale['name']); ?></h2>
                        <span class="dt-status-pill-clean <?php echo $wholesale['tier_badge']; ?>"><?php echo $wholesale['tier_short']; ?></span>
                        <span class="dt-status-pill-clean <?php echo $wholesale['verification_badge']; ?>">✓ <?php echo strtoupper($wholesale['verification']); ?></span>
                    </div>
                    <div style="font-size:0.75rem; color:#F5ECCE; margin-top:3px; display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                        <span style="font-family:monospace; color:#FFE57F; font-weight:800;"><?php echo $wholesale['id']; ?></span>
                        <span>•</span>
                        <span><?php echo htmlspecialchars($wholesale['legal_name']); ?></span>
                        <span>•</span>
                        <span>GSTIN: <code style="font-family:monospace; color:#FFE57F;"><?php echo $wholesale['gstin']; ?></code></span>
                    </div>
                </div>
            </div>

            <!-- Right Stat Pills Strip -->
            <div class="dt-wholesale-stat-badge-strip">
                <div class="dt-wholesale-stat-pill">
                    <span style="font-size:0.65rem; color:#F5ECCE; font-weight:800; text-transform:uppercase; display:block;">LIFETIME PURCHASES</span>
                    <strong style="font-size:1.15rem; color:#FFE57F; font-weight:900;">₹<?php echo number_format($wholesale['total_purchase']); ?></strong>
                    <small style="font-size:0.68rem; color:#FFFFFF; display:block;"><?php echo $wholesale['orders_count']; ?> Saree Orders</small>
                </div>
                <div class="dt-wholesale-stat-pill" style="border-color:rgba(134,239,172,0.4); background:rgba(21,128,61,0.15);">
                    <span style="font-size:0.65rem; color:#86EFAC; font-weight:800; text-transform:uppercase; display:block;">AVAILABLE CREDIT</span>
                    <strong style="font-size:1.15rem; color:#86EFAC; font-weight:900;">₹<?php echo number_format($available); ?></strong>
                    <small style="font-size:0.68rem; color:#FFFFFF; display:block;"><?php echo $sanctioned > 0 ? $avail_pct . '% Headroom' : 'Prepaid Account'; ?></small>
                </div>
            </div>
        </div>

        <!-- 6px Progress Bar -->
        <div style="display:flex; flex-direction:column; gap:5px; border-top:1px solid rgba(212, 175, 55, 0.25); padding-top:10px;">
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.72rem;">
                <span style="color:#F5ECCE; font-weight:700;">Revolving Credit Line: <strong style="color:#FFE57F;"><?php echo $sanctioned > 0 ? $util_pct . '% Utilized (₹' . number_format($utilized) . ' of ₹' . number_format($sanctioned) . ')' : 'No Credit Facility Assigned (Prepaid / Proforma)'; ?></strong></span>
                <span style="color:#86EFAC; font-weight:700;">Payment Terms: <strong><?php echo $wholesale['payment_terms']; ?></strong></span>
            </div>
            <div class="dt-wholesale-progress-wrap">
                <div class="dt-wholesale-progress-bar" style="width:<?php echo min(100, $util_pct); ?>%;"></div>
            </div>
        </div>
    </div>

    <!-- ══ SUB-TABS NAVIGATION ══ -->
    <div class="dt-wholesale-tabs-nav">
        <button type="button" class="dt-wholesale-tab-btn active" onclick="switchWholesaleTab('overview', this)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Overview Dossier</span>
        </button>
        <button type="button" class="dt-wholesale-tab-btn" onclick="switchWholesaleTab('business', this)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <span>Business &amp; Legal KYC</span>
        </button>
        <button type="button" class="dt-wholesale-tab-btn" onclick="switchWholesaleTab('documents', this)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            <span>Document Vault</span>
        </button>
        <button type="button" class="dt-wholesale-tab-btn" onclick="switchWholesaleTab('orders', this)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
            <span>Orders History (<?php echo $wholesale['orders_count']; ?>)</span>
        </button>
        <button type="button" class="dt-wholesale-tab-btn" onclick="switchWholesaleTab('pricing', this)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Pricing &amp; Margins</span>
        </button>
        <button type="button" class="dt-wholesale-tab-btn" onclick="switchWholesaleTab('credit', this)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
            <span>Credit Ledger</span>
        </button>
        <button type="button" class="dt-wholesale-tab-btn" onclick="switchWholesaleTab('activity', this)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
            <span>Activity Timeline</span>
        </button>
        <button type="button" class="dt-wholesale-tab-btn" onclick="switchWholesaleTab('notes', this)">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Notes &amp; Tags</span>
        </button>
    </div>

    <!-- ══ TAB PANES ══ -->
    <div id="tabPane_overview" class="dt-wholesale-tab-pane" style="display:block;">
        <div style="display:grid; grid-template-columns:2fr 1fr; gap:16px;">
            <!-- Left Overview Column -->
            <div style="display:flex; flex-direction:column; gap:16px;">
                <?php include __DIR__ . '/wholesale-business.php'; ?>
                <?php include __DIR__ . '/wholesale-verification.php'; ?>
            </div>
            <!-- Right Quick Contacts & Actions -->
            <div style="display:flex; flex-direction:column; gap:16px;">
                <div class="dt-card" style="padding:16px;">
                    <h4 class="dt-card-title" style="margin-bottom:12px;">Primary Commercial Contact</h4>
                    <div style="display:flex; flex-direction:column; gap:10px; font-size:0.78rem;">
                        <div>
                            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">CONTACT PERSON:</span>
                            <strong style="color:#181512; font-size:0.88rem;"><?php echo htmlspecialchars($wholesale['contact']); ?></strong>
                        </div>
                        <div>
                            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">OFFICIAL EMAIL:</span>
                            <strong style="color:#1D4ED8; font-family:monospace;"><?php echo htmlspecialchars($wholesale['email']); ?></strong>
                        </div>
                        <div>
                            <span style="font-size:0.68rem; color:#78716C; font-weight:700; display:block;">WHATSAPP / PHONE:</span>
                            <strong style="color:#15803D; font-family:monospace;"><?php echo htmlspecialchars($wholesale['phone']); ?></strong>
                        </div>
                        <div style="display:flex; gap:8px; margin-top:4px;">
                            <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" style="flex:1;" onclick="window.showToast('Connecting to WhatsApp: <?php echo $wholesale['phone']; ?>')">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#FFFFFF" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span>WhatsApp</span>
                            </button>
                            <a href="mailto:<?php echo $wholesale['email']; ?>" class="dt-btn dt-btn-pale dt-btn-sm" style="flex:1;">Email</a>
                        </div>
                    </div>
                </div>

                <div class="dt-card" style="padding:16px;">
                    <h4 class="dt-card-title" style="margin-bottom:10px;">Account Standing</h4>
                    <div style="display:flex; flex-direction:column; gap:8px; font-size:0.75rem;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#78716C;">Registration Date:</span>
                            <strong style="color:#181512;"><?php echo $wholesale['joined_date']; ?></strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#78716C;">Account Status:</span>
                            <span class="dt-status-pill-clean <?php echo $wholesale['status_type'] === 'approved' ? 'emerald' : ($wholesale['status_type'] === 'pending' ? 'amber' : 'crimson'); ?>">✓ <?php echo strtoupper($wholesale['status']); ?></span>
                        </div>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:#78716C;">Assigned Tier:</span>
                            <span class="dt-status-pill-clean <?php echo $wholesale['tier_badge']; ?>"><?php echo $wholesale['tier_short']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tabPane_business" class="dt-wholesale-tab-pane" style="display:none;">
        <?php include __DIR__ . '/wholesale-business.php'; ?>
    </div>

    <div id="tabPane_documents" class="dt-wholesale-tab-pane" style="display:none;">
        <?php include __DIR__ . '/wholesale-documents.php'; ?>
    </div>

    <div id="tabPane_orders" class="dt-wholesale-tab-pane" style="display:none;">
        <?php include __DIR__ . '/wholesale-orders.php'; ?>
    </div>

    <div id="tabPane_pricing" class="dt-wholesale-tab-pane" style="display:none;">
        <?php include __DIR__ . '/wholesale-pricing.php'; ?>
    </div>

    <div id="tabPane_credit" class="dt-wholesale-tab-pane" style="display:none;">
        <?php include __DIR__ . '/wholesale-credit.php'; ?>
    </div>

    <div id="tabPane_activity" class="dt-wholesale-tab-pane" style="display:none;">
        <?php include __DIR__ . '/wholesale-activity.php'; ?>
    </div>

    <div id="tabPane_notes" class="dt-wholesale-tab-pane" style="display:none;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            <?php include __DIR__ . '/wholesale-notes.php'; ?>
            <?php include __DIR__ . '/wholesale-tags.php'; ?>
        </div>
    </div>
</div>
