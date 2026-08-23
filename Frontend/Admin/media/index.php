<?php
/**
 * index.php - DT Brand's Admin Media Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "High-Resolution Media Asset Library";
$active_nav = "media";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High-Resolution Media Asset Library - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>High-Resolution Media Asset Library</span>
                        <span class="adm-badge gold">WebP Ready</span>
                    </h1>
                    <p class="adm-page-subtitle">Upload product photos, catalog shoots, and hero banner creatives.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Assets</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">480 Files</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Silk Sarees & Lehengas</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Storage Used</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="22" y1="12" x2="2" y2="12"></line><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" y1="16" x2="6.01" y2="16"></line><line x1="10" y1="16" x2="10.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">1.8 GB</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Compressed WebP Format</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">CDN Performance</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">100% Cached</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Ultra-Fast Delivery</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Video Reels</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect><line x1="7" y1="2" x2="7" y2="22"></line><line x1="17" y1="2" x2="17" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><line x1="2" y1="7" x2="7" y2="7"></line><line x1="2" y1="17" x2="7" y2="17"></line><line x1="17" y1="17" x2="22" y2="17"></line><line x1="17" y1="7" x2="22" y2="7"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">18 Clips</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Draping Showcase</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Media Gallery & Asset Uploader</span></h3>
                    <button class="adm-btn-primary" onclick="window.showToast('Select files to upload...')">Upload New Media</button>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(140px, 1fr)); gap:14px;">
                    <div style="border:1px solid #E5E1D7; border-radius:8px; overflow:hidden; background:#FAF8F4; text-align:center;">
                        <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:100%; height:110px; object-fit:cover;">
                        <div style="padding:6px; font-size:0.7rem; font-weight:700;">kanjivaram-1.webp</div>
                    </div>
                    <div style="border:1px solid #E5E1D7; border-radius:8px; overflow:hidden; background:#FAF8F4; text-align:center;">
                        <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width:100%; height:110px; object-fit:cover;">
                        <div style="padding:6px; font-size:0.7rem; font-weight:700;">banarasi-brocade.webp</div>
                    </div>
                    <div style="border:1px solid #E5E1D7; border-radius:8px; overflow:hidden; background:#FAF8F4; text-align:center;">
                        <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" style="width:100%; height:110px; object-fit:cover;">
                        <div style="padding:6px; font-size:0.7rem; font-weight:700;">bridal-lehenga.webp</div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
