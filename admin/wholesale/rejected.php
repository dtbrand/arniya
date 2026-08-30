<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * rejected.php — DT Brand's & Jai Hanuman Tex
 * Rejected Wholesale Applications Archive
 */
$page_title = "Rejected Wholesale Applications";
$active_nav = "wholesalers";
$active_subnav = "rejected";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected Applications - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale-list.css?v=<?php echo time(); ?>">
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
                            <span>Rejected Applications Archive</span>
                            <span class="dt-cust-badge crimson" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FEF2F2; color:#DC2626; border:1px solid #FECACA; font-weight:800;">10 Applications Rejected</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Wholesale registrations that failed GSTIN verification, submitted invalid KYC documents, or failed credit checks.</p>
                    </div>
                </div>

                <?php include __DIR__ . '/components/wholesale-stats.php'; ?>
                <?php include __DIR__ . '/components/wholesale-table.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-list.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-filters.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-status.js?v=<?php echo time(); ?>"></script>
</body>
</html>
