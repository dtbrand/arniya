<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * contact.php - DT Brand's Admin Contact & Showroom Info Editor
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Contact & Showroom Info Editor";
$active_nav = "cms";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact &amp; Showroom Info Editor - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 768px) {
            .dt-contact-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Contact &amp; Showroom Info Editor</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Direct Channel Config</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Update Surat flagship showroom address, WhatsApp customer care numbers, B2B wholesale hotlines, and GSTIN.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/cms/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← CMS Hub</a>
                </div>
            </div>

            <!-- Page Editor Card -->
            <div class="adm-card" style="max-width:850px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>📍 Flagship Showroom &amp; Customer Support</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Synchronized with Footer</span>
                </div>
                <form onsubmit="event.preventDefault(); window.showToast('✨ Contact information and showroom details saved!');" style="padding:18px 20px;">
                    <div class="dt-contact-grid">
                        <div style="grid-column: 1 / -1;">
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Surat Flagship Showroom Address *</label>
                            <input type="text" value="Shop #104–108, First Floor, Ring Road Textile Market, Surat, Gujarat - 395002" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Official WhatsApp Concierge Hotline *</label>
                            <input type="text" value="+91 98220 19283" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:700; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">B2B Wholesale Dispatch Direct Line</label>
                            <input type="text" value="+91 94281 77320" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:700; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Support Email Address *</label>
                            <input type="email" value="support@jaihanumantex.in" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">B2B Wholesale Trade Email</label>
                            <input type="email" value="wholesale@jaihanumantex.in" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Showroom Business Hours</label>
                            <input type="text" value="Mon – Sat: 10:00 AM – 8:30 PM (Sunday Closed)" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Registered GSTIN Number</label>
                            <input type="text" value="24AAACG1289F1Z4" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:700; box-sizing:border-box;">
                        </div>
                    </div>

                    <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                        <a href="/admin/cms/" class="dt-btn dt-btn-pale" style="text-decoration:none;">Cancel</a>
                        <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Save Contact Settings</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
