<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * about.php - DT Brand's Admin About Us & Heritage Story Editor
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "About Us & Heritage Story Editor";
$active_nav = "cms";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us &amp; Heritage Story Editor - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-cms-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 768px) {
            .dt-cms-grid {
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
                        <span>About Us &amp; Heritage Story Editor</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">CMS Page Editor</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Update Surat weaving legacy narrative, craftsmanship credentials, and brand values displayed on /about-us.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/cms/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← CMS Hub</a>
                    <a href="/about-us" target="_blank" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; color:#1D4ED8;">View Live Page ↗</a>
                </div>
            </div>

            <!-- Page Editor Card -->
            <div class="adm-card" style="max-width:900px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>🏛️ Brand Heritage Story Editor</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Published Live</span>
                </div>
                <form onsubmit="event.preventDefault(); window.showToast('✨ About Us story updated and published live!');" style="padding:18px 20px;">
                    <div style="display:flex; flex-direction:column; gap:16px;">
                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Main Heritage Headline *</label>
                            <input type="text" value="3 Decades of Handloom Mastery &amp; Surat Weaving Heritage" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:700; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Brand Narrative &amp; Mission Statement *</label>
                            <textarea rows="5" required style="width:100%; border:1.5px solid #EAE5D9; border-radius:8px; padding:12px; font-weight:600; font-size:12.5px; line-height:1.5; box-sizing:border-box; resize:vertical;">DT Brand's (Jai Hanuman Tex) is a premier textile manufacturing and direct-to-retail/wholesale powerhouse based in Surat, Gujarat. We specialize in authentic handcrafted Pure Silk Sarees, Royal Banarasi Kadwa Brocades, Kanjivaram Bridal Silks, and Designer Festive Lehengas. Our mission is to deliver authentic handloom grandeur directly from our Surat powerlooms to boutiques and homes worldwide.</textarea>
                        </div>

                        <div class="dt-cms-grid">
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Powerlooms &amp; Artisans Stat Badge</label>
                                <input type="text" value="120+ Active Looms | 450 Master Artisans" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Wholesale Footprint Badge</label>
                                <input type="text" value="1,200+ Wholesale Boutiques Worldwide" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                            </div>
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">SEO Meta Description</label>
                            <input type="text" value="Explore the royal heritage of DT Brand's &amp; Jai Hanuman Tex — Surat's leading manufacturer of handcrafted Pure Silk &amp; Banarasi Sarees." style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>
                    </div>

                    <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                        <a href="/admin/cms/" class="dt-btn dt-btn-pale" style="text-decoration:none;">Cancel</a>
                        <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Save &amp; Publish Changes</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
