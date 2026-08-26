<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * segments.php — Customer Segmentation & Cohort Engine
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Customer Segments & Cohorts";
$active_nav = "customers";
$active_subnav = "segments";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-segments.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Segments &amp; Cohorts</span>
                            <span class="dt-cust-badge gold">Dynamic CRM</span>
                        </h1>
                        <p class="dt-cust-subtitle">Target customer groups by purchase frequency, basket size, location clusters, and dormancy.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;" onclick="openCreateSegmentModal()">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>New Segment</span>
                        </button>
                    </div>
                </div>

                <div class="dt-card" style="padding:18px 20px;">
                    <?php include __DIR__ . '/components/customer-segments.php'; ?>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══ MODAL: CREATE NEW DYNAMIC SEGMENT ══ -->
<div class="dt-modal-overlay" id="dtCreateSegmentModal" style="display:none;" onclick="if(event.target===this) closeCreateSegmentModal();">
    <div class="dt-modal-dialog" style="max-width:540px; width:95%; background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; box-shadow:0 16px 40px rgba(0,0,0,0.22); overflow:hidden; animation:dtModalPop 0.2s cubic-bezier(0.16, 1, 0.3, 1);">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); padding:14px 20px; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg, #B8860B, #D4AF37); display:flex; align-items:center; justify-content:center; color:#111827;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.6"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:1rem; font-weight:800; color:#FFFFFF;">Create Dynamic Customer Segment</h3>
                    <p style="margin:2px 0 0 0; font-size:0.72rem; color:#FEE685;">Auto-updating cohort based on spending, region &amp; activity</p>
                </div>
            </div>
            <button type="button" style="background:none; border:none; color:#FAF5E8; font-size:1.2rem; cursor:pointer; padding:4px;" onclick="closeCreateSegmentModal()">✕</button>
        </div>

        <form id="dtCreateSegmentForm" onsubmit="handleCreateSegmentSubmit(event)" style="padding:18px 20px;">
            <div class="dt-form-group" style="margin-bottom:14px;">
                <label class="dt-form-label" style="display:block; font-size:0.78rem; font-weight:700; color:#181512; margin-bottom:6px;">Segment Title / Name <span style="color:#DC2626;">*</span></label>
                <input type="text" id="dtSegNameInput" class="dt-input-field no-icon" placeholder="e.g. Surat Festive Silk Buyers, VIP Repeaters..." required style="width:100%; box-sizing:border-box;">
            </div>

            <div class="dt-form-grid-2" style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
                <div class="dt-form-group">
                    <label class="dt-form-label" style="display:block; font-size:0.78rem; font-weight:700; color:#181512; margin-bottom:6px;">Target Geographic Market</label>
                    <select id="dtSegGeoSelect" class="dt-cust-select" style="width:100%; height:38px;">
                        <option value="ALL">All Markets (Global + Domestic)</option>
                        <option value="GJ">Gujarat Regional Hub</option>
                        <option value="DOMESTIC">All India Domestic</option>
                        <option value="INTERNATIONAL">International (USA, UAE, UK, etc.)</option>
                    </select>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label" style="display:block; font-size:0.78rem; font-weight:700; color:#181512; margin-bottom:6px;">Customer Tier Filter</label>
                    <select id="dtSegTierSelect" class="dt-cust-select" style="width:100%; height:38px;">
                        <option value="ALL">All Standing Tiers</option>
                        <option value="VIP">VIP High-Value Only</option>
                        <option value="WHOLESALE">B2B Wholesalers &amp; Resellers</option>
                        <option value="REGULAR">Direct Retail Shoppers</option>
                    </select>
                </div>
            </div>

            <div class="dt-form-grid-2" style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                <div class="dt-form-group">
                    <label class="dt-form-label" style="display:block; font-size:0.78rem; font-weight:700; color:#181512; margin-bottom:6px;">Min Lifetime Spend (₹)</label>
                    <input type="number" id="dtSegMinSpend" class="dt-input-field no-icon" placeholder="e.g. 15000" style="width:100%; box-sizing:border-box;">
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label" style="display:block; font-size:0.78rem; font-weight:700; color:#181512; margin-bottom:6px;">Min Completed Orders</label>
                    <input type="number" id="dtSegMinOrders" class="dt-input-field no-icon" placeholder="e.g. 2" style="width:100%; box-sizing:border-box;">
                </div>
            </div>

            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; margin-bottom:18px; display:flex; align-items:center; justify-content:space-between;">
                <span style="font-size:0.75rem; color:#78716C;">Estimated Live Audience:</span>
                <span style="font-size:0.95rem; font-weight:900; color:#8A681F;" id="dtSegEstimatedCount">~ 480 Matching Shoppers</span>
            </div>

            <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; border-top:1.5px solid #F1ECE1; padding-top:14px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeCreateSegmentModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Create &amp; Save Cohort</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-segments.js?v=<?php echo time(); ?>"></script>
</body>
</html>
