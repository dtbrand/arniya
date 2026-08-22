<?php
/**
 * tags.php — Customer Tagging Studio
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Customer Tags Studio";
$active_nav = "customers";
$active_subnav = "tags";
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
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
                            <span>Customer Tagging Studio</span>
                            <span class="dt-cust-badge gold">Dynamic Labels</span>
                        </h1>
                        <p class="dt-cust-subtitle">Organize customer records with custom labels for VIP tiers, regional groupings, and product affinities.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;" onclick="document.getElementById('dtCustNewTagInput').focus()">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>+ Create Tag</span>
                        </button>
                    </div>
                </div>

                <!-- 4-Card KPI Ribbon -->
                <div class="dt-cust-stats-ribbon" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(210px, 1fr)); gap:12px; margin-bottom:16px;">
                    <div class="dt-cust-stat-card" style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:10px; padding:12px 14px; box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                        <div style="font-size:0.7rem; font-weight:700; color:#78716C; text-transform:uppercase; margin-bottom:4px;">Total Active Tags</div>
                        <div style="font-size:1.4rem; font-weight:900; color:#181512;">12 <span style="font-size:0.75rem; font-weight:600; color:#15803D;">Master Tags</span></div>
                    </div>

                    <div class="dt-cust-stat-card" style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:10px; padding:12px 14px; box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                        <div style="font-size:0.7rem; font-weight:700; color:#78716C; text-transform:uppercase; margin-bottom:4px;">Tagged Customers</div>
                        <div style="font-size:1.4rem; font-weight:900; color:#8A681F;">4,820 <span style="font-size:0.75rem; font-weight:600; color:#78716C;">(100% Base)</span></div>
                    </div>

                    <div class="dt-cust-stat-card" style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:10px; padding:12px 14px; box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                        <div style="font-size:0.7rem; font-weight:700; color:#78716C; text-transform:uppercase; margin-bottom:4px;">Most Popular Tag</div>
                        <div style="font-size:1.15rem; font-weight:900; color:#15803D;">Frequent Buyer <span style="font-size:0.75rem; font-weight:700; color:#181512;">(1,850)</span></div>
                    </div>

                    <div class="dt-cust-stat-card" style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:10px; padding:12px 14px; box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                        <div style="font-size:0.7rem; font-weight:700; color:#78716C; text-transform:uppercase; margin-bottom:4px;">Auto-Rule Cohorts</div>
                        <div style="font-size:1.4rem; font-weight:900; color:#1D4ED8;">6 <span style="font-size:0.75rem; font-weight:600; color:#78716C;">Rules Active</span></div>
                    </div>
                </div>

                <div class="dt-card" style="padding:18px 20px;">
                    <?php include __DIR__ . '/components/customer-tags.php'; ?>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/customers/assets/js/customer-tags.js?v=<?php echo time(); ?>"></script>
</body>
</html>
