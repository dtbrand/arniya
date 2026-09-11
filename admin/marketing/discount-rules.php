<?php
/* DT admin access guard (hardened fallback) */
$__dtg1 = __DIR__ . '/../includes/adminguard.php';
$__dtg2 = __DIR__ . '/../../admin/includes/adminguard.php';
$__dtg3 = (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php' : '';
if (is_file($__dtg1)) { require_once $__dtg1; }
elseif (is_file($__dtg2)) { require_once $__dtg2; }
elseif ($__dtg3 && is_file($__dtg3)) { require_once $__dtg3; }

/**
 * discount-rules.php - DT Brand's Admin Tiered Discount & Volume Incentives Policy
 * DT Brand's & Jai Hanuman Tex — Section 26 Master Architecture
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "Discount Rules & Volume Policies";
$active_nav = "marketing";

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Rules &amp; Volume Policies - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-nav-tabs {
            display: flex;
            gap: 8px;
            border-bottom: 1.5px solid #EAE5D9;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 2px;
        }
        .dt-nav-tab {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 700;
            color: #64748B;
            text-decoration: none;
            border-bottom: 2.5px solid transparent;
            white-space: nowrap;
            transition: all 0.2s ease;
        }
        .dt-nav-tab:hover { color: #8A681F; }
        .dt-nav-tab.active {
            color: #8A681F;
            border-bottom-color: #D4AF37;
            background: #FAF5E8;
            border-radius: 6px 6px 0 0;
        }
        .dt-policy-card {
            background: #FFFFFF;
            border: 1.2px solid #EAE5D9;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .dt-policy-card:hover {
            border-color: #D4AF37;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:14px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Discount Rules &amp; Tiered Policies</span>
                        <span class="adm-badge gold">Section 26</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Configure automated cart-level volume discounts, B2B wholesale MOQ tiers, and role-specific promotion rules.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/marketing/coupons.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:34px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Coupons Studio</span>
                    </a>
                </div>
            </div>

            <!-- Navigation Tabs -->
            <div class="dt-nav-tabs">
                <a href="/admin/marketing/coupons.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    <span>Coupons Studio</span>
                </a>
                <a href="/admin/marketing/discount-rules.php" class="dt-nav-tab active">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span>Discount Rules</span>
                </a>
                <a href="/admin/marketing/usage.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    <span>Coupon Usage Ledger</span>
                </a>
                <a href="/admin/marketing/expired.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Expired Codes</span>
                </a>
                <a href="/admin/marketing/audit.php" class="dt-nav-tab">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <span>Security Audit</span>
                </a>
            </div>

            <!-- Discount Rule Cards -->
            <div class="dt-policy-card">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                    <div>
                        <h3 style="margin:0 0 4px 0; font-size:1.05rem; font-weight:800; color:#181512;">1. Wholesaler Multi-Variant Lot (MCQ) Volume Incentive</h3>
                        <p style="margin:0; font-size:0.8rem; color:#64748B;">Automated server-side wholesale pricing applied when full color × size matrix is purchased.</p>
                    </div>
                    <span class="adm-badge success" style="font-weight:700;">Active Enforcement</span>
                </div>
                <div style="background:#FAF8F4; padding:12px 16px; border-radius:8px; border:1px solid #EAE5D9; font-size:12.5px; line-height:1.5;">
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                        <div><strong>Formula:</strong> <code>MCQ = Color Count × Size Count</code></div>
                        <div><strong>Role Scope:</strong> <span class="dt-channel-pill dt-channel-wholesaler">WHOLESALER</span></div>
                        <div><strong>Price Tier:</strong> Wholesale Price / Sale Price</div>
                        <div><strong>Server Verification:</strong> Mandatory in <code>OrderManager.php</code></div>
                    </div>
                </div>
            </div>

            <div class="dt-policy-card">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                    <div>
                        <h3 style="margin:0 0 4px 0; font-size:1.05rem; font-weight:800; color:#181512;">2. Retailer &amp; Boutique Partner Volume Incentive</h3>
                        <p style="margin:0; font-size:0.8rem; color:#64748B;">Tiered discount benefit for verified boutiques purchasing multi-piece full sets and catalog lots.</p>
                    </div>
                    <span class="adm-badge success" style="font-weight:700;">Active Enforcement</span>
                </div>
                <div style="background:#FAF8F4; padding:12px 16px; border-radius:8px; border:1px solid #EAE5D9; font-size:12.5px; line-height:1.5;">
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                        <div><strong>Eligible Product:</strong> Single Piece &amp; Full Set Catalog</div>
                        <div><strong>Role Scope:</strong> <span class="dt-channel-pill dt-channel-retailer">RETAILER</span></div>
                        <div><strong>Price Tier:</strong> Retailer Price / Sale Price</div>
                        <div><strong>Checkout Minimum:</strong> <?= $rupeeSvg ?> 1,999.00</div>
                    </div>
                </div>
            </div>

            <div class="dt-policy-card">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                    <div>
                        <h3 style="margin:0 0 4px 0; font-size:1.05rem; font-weight:800; color:#181512;">3. VIP Reseller Dropship Incentive</h3>
                        <p style="margin:0; font-size:0.8rem; color:#64748B;">Reseller partner rates with margin protection and zero full-set dilution.</p>
                    </div>
                    <span class="adm-badge success" style="font-weight:700;">Active Enforcement</span>
                </div>
                <div style="background:#FAF8F4; padding:12px 16px; border-radius:8px; border:1px solid #EAE5D9; font-size:12.5px; line-height:1.5;">
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                        <div><strong>Eligible Product:</strong> Single Piece Catalog Only</div>
                        <div><strong>Role Scope:</strong> <span class="dt-channel-pill dt-channel-reseller">RESELLER</span></div>
                        <div><strong>Price Tier:</strong> Reseller Price / Sale Price</div>
                        <div><strong>Full Set Block:</strong> Strictly Disallowed (Section 5 Spec)</div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
