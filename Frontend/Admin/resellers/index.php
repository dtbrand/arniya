<?php
/**
 * index.php — DT Brand's & Jai Hanuman Tex
 * Master Production Reseller Management Hub & Directory
 */
$page_title = "Resellers Network & Payouts Hub";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resellers Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="dt-resellers-container">
                <!-- Page Title Header -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <h1 style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">Resellers Management</h1>
                            <span class="dt-reseller-badge gold">348 Active Network</span>
                        </div>
                        <p style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">
                            Manage DT Brand's reseller accounts, KYC verification, tiered pricing, margins, and weekly payout settlements.
                        </p>
                    </div>

                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/Frontend/Admin/resellers/applications.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#705114" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                            <span>Review Applications (24)</span>
                        </a>
                        <a href="/Frontend/Admin/resellers/analytics.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#705114" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                            <span>Analytics</span>
                        </a>
                        <a href="/Frontend/Admin/resellers/edit.php?action=new" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>+ Add Reseller</span>
                        </a>
                    </div>
                </div>

                <!-- 1. 8-Card Master Executive KPI Ribbon -->
                <?php include_once __DIR__ . '/components/reseller-stats.php'; ?>

                <!-- 2. Status Flow Filter Pills -->
                <div class="dt-reseller-filter-strip">
                    <button type="button" class="dt-reseller-pill-btn active" onclick="filterResellersByStatus('all', this)">
                        <span>All Resellers</span>
                        <span class="dt-reseller-pill-count">348</span>
                    </button>
                    <button type="button" class="dt-reseller-pill-btn" onclick="filterResellersByStatus('pending', this)">
                        <span>Pending Applications</span>
                        <span class="dt-reseller-pill-count" style="background:#FEF3C7; color:#B45309;">24</span>
                    </button>
                    <button type="button" class="dt-reseller-pill-btn" onclick="filterResellersByStatus('approved', this)">
                        <span>Approved &amp; Active</span>
                        <span class="dt-reseller-pill-count">296</span>
                    </button>
                    <button type="button" class="dt-reseller-pill-btn" onclick="filterResellersByStatus('suspended', this)">
                        <span>Suspended</span>
                        <span class="dt-reseller-pill-count">12</span>
                    </button>
                    <button type="button" class="dt-reseller-pill-btn" onclick="filterResellersByStatus('rejected', this)">
                        <span>Rejected</span>
                        <span class="dt-reseller-pill-count">16</span>
                    </button>
                </div>

                <!-- 3. Master Reseller Card & Table -->
                <div class="dt-card">
                    <?php include_once __DIR__ . '/components/reseller-search.php'; ?>
                    <?php include_once __DIR__ . '/components/reseller-table.php'; ?>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Modals & Bulk Actions -->
<?php include_once __DIR__ . '/components/bulk-actions.php'; ?>
<?php include_once __DIR__ . '/components/reseller-filters.php'; ?>
<?php include_once __DIR__ . '/components/reseller-status.php'; ?>

<script src="/Frontend/Admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-list.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-filters.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-status.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-credit.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>

</body>
</html>
