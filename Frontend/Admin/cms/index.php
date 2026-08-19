<?php
/**
 * index.php - DT Brand's Admin Cms Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "CMS Content & Policy Pages Manager";
$active_nav = "cms";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Content & Policy Pages Manager - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                        <span>CMS Content & Policy Pages Manager</span>
                        <span class="adm-badge gold">8 Pages Live</span>
                    </h1>
                    <p class="adm-page-subtitle">Edit About Us, Wholesale Terms, Return Policy, and SEO Meta tags.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">CMS Pages</span>
                <div class="adm-kpi-icon-box">📄</div>
            </div>
            <div class="adm-kpi-val">8 Pages</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">100% SEO Optimized</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Hero Banners</span>
                <div class="adm-kpi-icon-box">🖼️</div>
            </div>
            <div class="adm-kpi-val">4 Banners</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">High-Res WebP</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Legal Policies</span>
                <div class="adm-kpi-icon-box">⚖️</div>
            </div>
            <div class="adm-kpi-val">Updated 2026</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Compliant with GST Rules</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">SEO Indexing</span>
                <div class="adm-kpi-icon-box">🔍</div>
            </div>
            <div class="adm-kpi-val">Google Indexed</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Clean Metadata</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📄 Static & Policy Content Pages</span></h3>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Page Title</th>
                            <th>URL Slug</th>
                            <th>Last Modified</th>
                            <th>SEO Meta Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>About DT Brand's & Jai Hanuman Tex</strong></td>
                            <td><code>/about-us</code></td>
                            <td>15 Aug 2026</td>
                            <td><span class="adm-badge success">Optimized</span></td>
                            <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Opening CMS Editor...')">✏️ Edit Page</button></td>
                        </tr>
                        <tr>
                            <td><strong>Wholesale B2B Terms & MOQ Policy</strong></td>
                            <td><code>/wholesale-policy</code></td>
                            <td>18 Aug 2026</td>
                            <td><span class="adm-badge success">Optimized</span></td>
                            <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Opening CMS Editor...')">✏️ Edit Page</button></td>
                        </tr>
                        <tr>
                            <td><strong>Return & Replacement Guidelines</strong></td>
                            <td><code>/return-policy</code></td>
                            <td>10 Aug 2026</td>
                            <td><span class="adm-badge success">Optimized</span></td>
                            <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Opening CMS Editor...')">✏️ Edit Page</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
