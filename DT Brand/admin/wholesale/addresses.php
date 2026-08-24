<?php
/**
 * addresses.php — DT Brand's & Jai Hanuman Tex
 * Multi-Warehouse & Wholesale Dispatch Addresses
 */
$page_title = "Wholesale Addresses";
$active_nav = "wholesalers";
$active_subnav = "all";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Addresses - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
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
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">
                            <span>Wholesale Warehouses &amp; Dispatch Hubs</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Primary commercial billing addresses and regional bulk delivery warehouse locations.</p>
                    </div>
                </div>

                <div class="dt-card" style="padding:20px;">
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                        <div style="background:#FAF8F4; border:1.5px solid #D4AF37; border-radius:10px; padding:16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="dt-status-pill-clean gold">DEFAULT PRIMARY WAREHOUSE</span>
                                <span style="font-size:0.7rem; color:#78716C;">Surat Hub</span>
                            </div>
                            <strong style="font-size:0.88rem; color:#181512; display:block;">Shree Balaji Textile Central Stockyard</strong>
                            <p style="font-size:0.76rem; color:#78716C; margin:6px 0 0 0; line-height:1.4;">
                                Plot 42, Millennium Textile Market-2, Ring Road, Surat, Gujarat 395002<br>
                                Contact: Rameshwar Agarwal • Ph: +91 98251 44321
                            </p>
                        </div>

                        <div style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:10px; padding:16px;">
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <span class="dt-status-pill-clean blue">SECONDARY WAREHOUSE</span>
                                <span style="font-size:0.7rem; color:#78716C;">Ahmedabad Depot</span>
                            </div>
                            <strong style="font-size:0.88rem; color:#181512; display:block;">Balaji North Gujarat Sourcing Point</strong>
                            <p style="font-size:0.76rem; color:#78716C; margin:6px 0 0 0; line-height:1.4;">
                                Shed 18, GIDC Industrial Estate, Naroda, Ahmedabad, Gujarat 382330<br>
                                Contact: Jitendra Vyas • Ph: +91 94280 99887
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
</body>
</html>
