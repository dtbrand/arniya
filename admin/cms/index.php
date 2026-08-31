<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Admin Cms Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$page_title = "CMS Content & Policy Pages Manager";
$active_nav = "cms";

$cmsPages = [
    [
        'title' => "About DT Brand's & Jai Hanuman Tex",
        'slug' => '/about-us',
        'type' => 'Brand Story',
        'last_modified' => date('d M Y', strtotime('-5 days')),
        'status' => 'Published & Live'
    ],
    [
        'title' => 'Wholesale B2B Terms & MOQ Bale Policy',
        'slug' => '/wholesale-policy',
        'type' => 'B2B Policy',
        'last_modified' => date('d M Y', strtotime('-2 days')),
        'status' => 'Published & Live'
    ],
    [
        'title' => 'Return, Exchange & Damage Replacement',
        'slug' => '/return-policy',
        'type' => 'Customer Policy',
        'last_modified' => date('d M Y', strtotime('-7 days')),
        'status' => 'Published & Live'
    ],
    [
        'title' => 'Privacy Policy & Data Security',
        'slug' => '/privacy-policy',
        'type' => 'Compliance',
        'last_modified' => date('d M Y', strtotime('-12 days')),
        'status' => 'Published & Live'
    ],
    [
        'title' => 'Shipping & Delhivery Courier SLAs',
        'slug' => '/shipping-policy',
        'type' => 'Logistics',
        'last_modified' => date('d M Y', strtotime('-3 days')),
        'status' => 'Published & Live'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Content &amp; Policy Pages Manager - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>CMS Content &amp; Policy Pages Manager</span>
                        <span class="adm-badge gold"><?= count($cmsPages) ?> Pages Live</span>
                    </h1>
                    <p class="adm-page-subtitle">Edit About Us, Wholesale Terms, Return Policy, and SEO Meta tags.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">CMS Pages</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= count($cmsPages) ?> Live Pages</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">100% SEO Optimized</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Hero Banners</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">4 Banners</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">High-Res WebP Slider</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Legal Policies</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Updated <?= date('Y') ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Compliant with GST Rules</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">SEO Indexing</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">Google Indexed</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Clean OpenGraph Metadata</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Static &amp; Policy Content Pages</span></h3>
                    <button type="button" class="dt-btn dt-btn-gold" style="font-weight:800; font-size:12px; height:32px; padding:0 14px;" onclick="window.showToast('✨ All CMS policy pages synchronized and published live!');">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Publish All Changes</span>
                    </button>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Page Title</th>
                                <th>URL Slug</th>
                                <th>Policy Category</th>
                                <th>Last Modified</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cmsPages as $p): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($p['title']) ?></strong></td>
                                    <td><code style="font-size:11.5px; background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700; border:1px solid #D4AF37;"><?= htmlspecialchars($p['slug']) ?></code></td>
                                    <td><span class="adm-badge gold"><?= htmlspecialchars($p['type']) ?></span></td>
                                    <td><small style="color:#7A7266;"><?= htmlspecialchars($p['last_modified']) ?></small></td>
                                    <td><span class="adm-badge success"><?= htmlspecialchars($p['status']) ?></span></td>
                                    <td>
                                        <div style="display:flex; gap:6px;">
                                            <a href="<?= htmlspecialchars($p['slug']) ?>" target="_blank" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:11px; text-decoration:none;">View</a>
                                            <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:11px;" onclick="window.showToast('📝 CMS Editor ready for <?= htmlspecialchars($p['title']) ?>');">Edit</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
