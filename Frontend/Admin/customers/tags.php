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
            
            <div class="dt-customers-container" style="max-width:100%; box-sizing:border-box;">
                <!-- Page Head -->
                <div class="dt-cust-head" style="margin-bottom:16px;">
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
                            <span>Create Tag</span>
                        </button>
                    </div>
                </div>

                <!-- 4-Card Luxury KPI Ribbon -->
                <div class="dt-cust-stats-ribbon" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px; margin-bottom:18px;">
                    <!-- KPI 1 -->
                    <div style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:12px; padding:14px 16px; box-shadow:0 2px 8px rgba(0,0,0,0.02); display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div style="font-size:0.7rem; font-weight:800; color:#78716C; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:4px;">Total Active Tags</div>
                            <div style="font-size:1.35rem; font-weight:900; color:#181512; line-height:1.2;">12 <span style="font-size:0.72rem; font-weight:700; color:#15803D;">Master Tags</span></div>
                        </div>
                        <div style="width:36px; height:36px; border-radius:10px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        </div>
                    </div>

                    <!-- KPI 2 -->
                    <div style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:12px; padding:14px 16px; box-shadow:0 2px 8px rgba(0,0,0,0.02); display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div style="font-size:0.7rem; font-weight:800; color:#78716C; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:4px;">Tagged Customers</div>
                            <div style="font-size:1.35rem; font-weight:900; color:#8A681F; line-height:1.2;">4,820 <span style="font-size:0.72rem; font-weight:700; color:#78716C;">(100% Base)</span></div>
                        </div>
                        <div style="width:36px; height:36px; border-radius:10px; background:#EFF6FF; border:1px solid #BFDBFE; display:flex; align-items:center; justify-content:center; color:#1D4ED8; flex-shrink:0;">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                    </div>

                    <!-- KPI 3 -->
                    <div style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:12px; padding:14px 16px; box-shadow:0 2px 8px rgba(0,0,0,0.02); display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div style="font-size:0.7rem; font-weight:800; color:#78716C; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:4px;">Most Popular Tag</div>
                            <div style="font-size:1.1rem; font-weight:900; color:#15803D; line-height:1.2;">Frequent Buyer <span style="font-size:0.72rem; font-weight:700; color:#181512;">(1,850)</span></div>
                        </div>
                        <div style="width:36px; height:36px; border-radius:10px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D; flex-shrink:0;">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </div>
                    </div>

                    <!-- KPI 4 -->
                    <div style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:12px; padding:14px 16px; box-shadow:0 2px 8px rgba(0,0,0,0.02); display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <div style="font-size:0.7rem; font-weight:800; color:#78716C; text-transform:uppercase; letter-spacing:0.03em; margin-bottom:4px;">Auto-Rule Cohorts</div>
                            <div style="font-size:1.35rem; font-weight:900; color:#181512; line-height:1.2;">6 <span style="font-size:0.72rem; font-weight:700; color:#1D4ED8;">Rules Active</span></div>
                        </div>
                        <div style="width:36px; height:36px; border-radius:10px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
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
