<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php — Reseller Management Master Dashboard & Directory
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
require_once __DIR__ . '/../../src/CustomerManager.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

$resellersList = CustomerManager::getByType('reseller');
$totalResellerCount = count($resellersList);

$page_title = "Reseller Network & Directory";
$active_nav = "resellers";
$active_subnav = "all";
$active_filter = "all";
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
    <link rel="stylesheet" href="/admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:12px;">
                <!-- Page Header -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Reseller Network &amp; Partner Directory</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;"><?php echo number_format($totalResellerCount); ?> Active Partners</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage DT Brand's authorized resellers, KYC verification, tiered margins, revolving credit lines, and 1-click WhatsApp connect.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <button type="button" class="dt-btn dt-btn-pale" onclick="window.location.reload();">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            <span>Refresh</span>
                        </button>
                        <a href="/admin/resellers/export.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export All Resellers</span>
                        </a>
                    </div>
                </div>

                <!-- 8-Card KPI Ribbon & Flow Filter Pills -->
                <?php include __DIR__ . '/components/reseller-stats.php'; ?>

                <!-- Toolbar & Debounced Live Search -->
                <?php include __DIR__ . '/components/reseller-search.php'; ?>

                <!-- Master Resellers Table -->
                <?php include __DIR__ . '/components/reseller-table.php'; ?>
            </div>

            <!-- Modals & Drawers -->
            <?php include __DIR__ . '/components/reseller-filters.php'; ?>
            <?php include __DIR__ . '/components/reseller-status.php'; ?>
            <?php include __DIR__ . '/components/bulk-actions.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
    window.dbResellersData = <?= json_encode($resellersList) ?>;
</script>
<script src="/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-list.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-filters.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-status.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
