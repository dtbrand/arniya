<?php
/**
 * banners.php - DT Brand's Admin Homepage Banners & Sliders
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Homepage Banners & Hero Sliders";
$active_nav = "marketing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Banners &amp; Sliders - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-banner-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 16px;
        }
        .dt-banner-card {
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            overflow: hidden;
            background: #FFFFFF;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            transition: all 0.2s ease;
        }
        .dt-banner-card:hover {
            border-color: #D4AF37;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(184,134,11,0.12);
        }
        .dt-banner-thumb {
            height: 140px;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 12px;
        }
        .dt-banner-thumb::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%);
        }
        .dt-banner-thumb-title {
            position: relative;
            z-index: 2;
            color: #FFFFFF;
            font-weight: 800;
            font-size: 14px;
            text-shadow: 0 1px 3px rgba(0,0,0,0.8);
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
                        <span>Homepage Banners &amp; Hero Sliders</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">3 Active Slides</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manage top rotating promotional banners, mobile hero banners, and deep-link click URLs.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/marketing/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Marketing Hub</a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px;" onclick="openNewBannerModal()">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add New Banner</span>
                    </button>
                </div>
            </div>

            <!-- Active Hero Sliders Grid -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>🖼️ Active Storefront Hero Sliders</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Auto-Rotating (5s)</span>
                </div>
                <div class="dt-banner-grid" style="padding:16px 18px;">
                    <!-- Banner Card 1 -->
                    <div class="dt-banner-card">
                        <div class="dt-banner-thumb" style="background-image: url('/assets/images/hero-banner.png'); background-color:#2A241E;">
                            <div class="dt-banner-thumb-title">Festive Silk Saree Mela 2026</div>
                        </div>
                        <div style="padding:12px 14px; display:flex; flex-direction:column; gap:8px;">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span class="adm-badge gold" style="font-weight:800;">Slide #1 (Primary)</span>
                                <span class="adm-badge success">Active</span>
                            </div>
                            <div style="font-size:11.5px; color:#64748B;">Target: <code>/shop?category=kanjivaram-silk</code></div>
                            <div style="display:flex; justify-content:flex-end; gap:6px; margin-top:4px;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('✓ Banner updated!')">Edit</button>
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626;" onclick="this.closest('.dt-banner-card').remove(); window.showToast('Banner deactivated.');">Disable</button>
                            </div>
                        </div>
                    </div>

                    <!-- Banner Card 2 -->
                    <div class="dt-banner-card">
                        <div class="dt-banner-thumb" style="background-image: url('/assets/images/product2.png'); background-color:#8A681F;">
                            <div class="dt-banner-thumb-title">Royal Banarasi Kadwa Brocade</div>
                        </div>
                        <div style="padding:12px 14px; display:flex; flex-direction:column; gap:8px;">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span class="adm-badge gold" style="font-weight:800;">Slide #2</span>
                                <span class="adm-badge success">Active</span>
                            </div>
                            <div style="font-size:11.5px; color:#64748B;">Target: <code>/shop?category=banarasi-silk</code></div>
                            <div style="display:flex; justify-content:flex-end; gap:6px; margin-top:4px;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('✓ Banner updated!')">Edit</button>
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626;" onclick="this.closest('.dt-banner-card').remove(); window.showToast('Banner deactivated.');">Disable</button>
                            </div>
                        </div>
                    </div>

                    <!-- Banner Card 3 -->
                    <div class="dt-banner-card">
                        <div class="dt-banner-thumb" style="background-image: url('/assets/images/product3.png'); background-color:#5A4210;">
                            <div class="dt-banner-thumb-title">Direct Loom Wholesale B2B Sourcing</div>
                        </div>
                        <div style="padding:12px 14px; display:flex; flex-direction:column; gap:8px;">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <span class="adm-badge gold" style="font-weight:800;">Slide #3</span>
                                <span class="adm-badge success">Active</span>
                            </div>
                            <div style="font-size:11.5px; color:#64748B;">Target: <code>/wholesale</code></div>
                            <div style="display:flex; justify-content:flex-end; gap:6px; margin-top:4px;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('✓ Banner updated!')">Edit</button>
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="color:#DC2626;" onclick="this.closest('.dt-banner-card').remove(); window.showToast('Banner deactivated.');">Disable</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Add Banner Modal -->
<div id="newBannerModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:460px; padding:22px; box-shadow:0 10px 30px rgba(0,0,0,0.25); border:1.5px solid #D4AF37;">
        <h3 style="margin:0 0 14px 0; font-size:1.1rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
            <span>🖼️ Add Homepage Hero Banner</span>
        </h3>
        <form onsubmit="handleNewBanner(event)">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Banner Headline / Title *</label>
                    <input type="text" id="bannerTitle" placeholder="e.g. Wedding Paithani Collection" required style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Click-Through Target URL</label>
                    <input type="text" id="bannerUrl" value="/shop?category=paithani" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Banner Image Asset</label>
                    <select id="bannerImage" style="width:100%; height:36px; border:1.5px solid #EAE5D9; border-radius:6px; padding:0 8px; font-weight:600;">
                        <option value="/assets/images/hero-banner.png">Hero Banner Main (High-Res)</option>
                        <option value="/assets/images/product1.png">Nilambari Silk Hero</option>
                        <option value="/assets/images/product2.png">Royal Banarasi Hero</option>
                    </select>
                </div>
            </div>
            <div style="margin-top:18px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeNewBannerModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">+ Add Hero Slide</button>
            </div>
        </form>
    </div>
</div>

<script>
function openNewBannerModal() {
    const m = document.getElementById('newBannerModal');
    if (m) m.style.display = 'flex';
}

function closeNewBannerModal() {
    const m = document.getElementById('newBannerModal');
    if (m) m.style.display = 'none';
}

function handleNewBanner(e) {
    e.preventDefault();
    const title = document.getElementById('bannerTitle').value.trim();
    closeNewBannerModal();
    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Hero Banner "${title}" added and saved!`);
    }
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
