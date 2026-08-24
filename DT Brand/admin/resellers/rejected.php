<?php
/**
 * rejected.php — DT Brand's & Jai Hanuman Tex
 * Rejected Ineligible Reseller Applications
 */
$page_title = "Rejected Resellers Archive";
$active_nav = "resellers";
$active_subnav = "rejected";
$active_filter = "rejected";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected Resellers - DT Brand's Admin</title>
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
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Rejected Resellers Archive</span>
                            <span class="dt-cust-badge rose" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FEF2F2; color:#DC2626; border:1px solid #FCA5A5; font-weight:800;">16 Ineligible</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Review ineligible applications with documented audit rejection grounds.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">← Back to All Resellers</a>
                    </div>
                </div>

                <!-- 8-Card KPI Ribbon & Flow Filter Pills -->
                <?php include __DIR__ . '/components/reseller-stats.php'; ?>

                <!-- Toolbar & Live Search -->
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

<script src="/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-list.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-filters.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-status.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    filterResellersByStatus('rejected');
});
</script>
</body>
</html>
