<?php
/**
 * approved.php — DT Brand's & Jai Hanuman Tex
 * Approved & Active Wholesale Partners Roster
 */
$page_title = "Approved Wholesale Partners";
$active_nav = "wholesalers";
$active_subnav = "approved";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Wholesalers - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/wholesale/assets/css/wholesale-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-wholesale-container">
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Approved Wholesale Partners</span>
                            <span class="dt-cust-badge emerald" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:800;">98 Verified Partners</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Active B2B wholesale buyers with sanctioned credit facilities and customized price lists.</p>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <a href="/DT%20Brand/admin/wholesale/export.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Roster</span>
                        </a>
                    </div>
                </div>

                <?php include __DIR__ . '/components/wholesale-stats.php'; ?>
                <?php include __DIR__ . '/components/wholesale-table.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale-list.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale-filters.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale-status.js?v=<?php echo time(); ?>"></script>
</body>
</html>
