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
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/customers/assets/css/customer-profile.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <!-- Page Header -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Tagging Studio</span>
                            <span class="dt-cust-badge gold">Dynamic Labels</span>
                        </h1>
                        <p class="dt-cust-subtitle">Organize customer records with custom labels for VIP tiers, regional groupings, and product affinities.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/admin/customers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="document.getElementById('dtCustNewTagInput').focus()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Create Tag</span>
                        </button>
                    </div>
                </div>

                <!-- 4-Card Master KPI Ribbon -->
                <div class="dt-cust-kpi-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); margin-bottom:18px;">
                    <!-- Card 1: Total Tags -->
                    <div class="dt-cust-kpi-card active">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">TOTAL ACTIVE TAGS</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val">12</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">● 100% Active</span>
                            <span style="color:#78716C;">Master Directory</span>
                        </div>
                    </div>

                    <!-- Card 2: Tagged Customers -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">TAGGED CUSTOMERS</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#8A681F;">4,820</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">100% Shopper Coverage</span>
                            <span style="color:#78716C;">Total Base</span>
                        </div>
                    </div>

                    <!-- Card 3: Most Popular -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">MOST POPULAR TAG</span>
                            <div class="dt-cust-kpi-icon emerald">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#15803D; font-size:1.15rem;">Frequent Buyer</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">1,850 Shoppers</span>
                            <span style="color:#15803D; font-weight:800;">38.3% Share</span>
                        </div>
                    </div>

                    <!-- Card 4: Auto-Rule Cohorts -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">AUTO-RULE COHORTS</span>
                            <div class="dt-cust-kpi-icon purple">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val">6</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">6 Dynamic Rules</span>
                            <span style="color:#78716C;">Live Triggers</span>
                        </div>
                    </div>
                </div>

                <!-- Main Tagging Studio Component -->
                <?php include __DIR__ . '/components/customer-tags.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/customers/assets/js/customer-tags.js?v=<?php echo time(); ?>"></script>
</body>
</html>
