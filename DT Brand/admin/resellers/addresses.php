<?php
/**
 * addresses.php — DT Brand's & Jai Hanuman Tex
 * Reseller Addresses Management (Business, Billing, Shipping)
 */
$page_title = "Reseller Addresses";
$active_nav = "resellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Addresses - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">

            <div class="dt-resellers-container">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <h1 style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">Reseller Addresses Management</h1>
                            <span class="dt-reseller-badge gold">Dispatch Locations</span>
                        </div>
                        <p style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage registered business showrooms, billing HQ addresses, and primary dispatch destinations.</p>
                    </div>
                    <a href="/DT%20Brand/admin/resellers/index.php" class="dt-btn dt-btn-pale">← Back to Resellers Directory</a>
                </div>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:16px;">
                    <!-- Business Address -->
                    <div class="dt-card" style="padding:18px;">
                        <div class="dt-card-head" style="margin-bottom:12px;">
                            <h4 class="dt-card-title">🏢 Principal Business Address</h4>
                            <span class="dt-reseller-badge emerald">Primary</span>
                        </div>
                        <p style="font-size:0.8rem; color:#1F2937; line-height:1.5; margin:0 0 12px 0;">
                            <strong>Shree Krishna Sarees &amp; Boutique</strong><br>
                            Shop #104-106, 1st Floor, Millennium Textile Market-2,<br>
                            Ring Road, Surat, Gujarat - 395002, India<br>
                            <strong>Phone:</strong> +91 98251 44321
                        </p>
                        <div style="display:flex; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Address editor opened')">Edit</button>
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="copyToClipboard('Shop #104-106, Millennium Textile Market-2, Surat 395002', 'Address')">Copy</button>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="dt-card" style="padding:18px;">
                        <div class="dt-card-head" style="margin-bottom:12px;">
                            <h4 class="dt-card-title">🧾 GST Billing Address</h4>
                            <span class="dt-reseller-badge gold">Tax Address</span>
                        </div>
                        <p style="font-size:0.8rem; color:#1F2937; line-height:1.5; margin:0 0 12px 0;">
                            <strong>Shree Krishna Sarees (Proprietorship)</strong><br>
                            Shop #104-106, Millennium Textile Market-2,<br>
                            Ring Road, Surat, Gujarat - 395002<br>
                            <strong>GSTIN:</strong> 24AAAPL1234F1Z8
                        </p>
                        <div style="display:flex; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Billing address editor opened')">Edit</button>
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="copyToClipboard('24AAAPL1234F1Z8', 'GSTIN')">Copy GSTIN</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/resellers/assets/js/reseller-view.js?v=<?php echo time(); ?>"></script>
</body>
</html>
