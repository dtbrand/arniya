<?php
/**
 * index.php - DT Brand's Admin Reviews Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Customer Reviews & Moderation Hub";
$active_nav = "reviews";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews & Moderation Hub - DT Brand's Admin</title>
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
                        <span>Customer Reviews & Moderation Hub</span>
                        <span class="adm-badge gold">4.9 ★ Rating</span>
                    </h1>
                    <p class="adm-page-subtitle">Review authentic customer ratings, buyer testimonials, and photo reviews.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Average Rating</span>
                <div class="adm-kpi-icon-box">⭐</div>
            </div>
            <div class="adm-kpi-val">4.9 / 5.0</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">From 1,280 Reviews</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">5-Star Reviews</span>
                <div class="adm-kpi-icon-box">🌟</div>
            </div>
            <div class="adm-kpi-val">92%</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">1,177 Five Stars</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Pending Approval</span>
                <div class="adm-kpi-icon-box">⏳</div>
            </div>
            <div class="adm-kpi-val">4</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta down">Requires Verification</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Photo Reviews</span>
                <div class="adm-kpi-icon-box">📸</div>
            </div>
            <div class="adm-kpi-val">340</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">With Saree Photos</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>⭐ Recent Customer Reviews Moderation</span></h3>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Customer & Date</th>
                            <th>Product Reviewed</th>
                            <th>Rating</th>
                            <th>Review Snippet</th>
                            <th>Moderation Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Sunita Rao</strong><br><small style="color:#7A7266;">Yesterday, 03:20 PM</small></td>
                            <td>Kanjivaram Pure Silk Saree</td>
                            <td><span style="color:#F59E0B; font-weight:800;">★★★★★</span> (5.0)</td>
                            <td>"The fabric is pure zari silk and color richness is unmatched! Delivered in 2 days."</td>
                            <td><span class="adm-badge success">Approved & Live</span></td>
                            <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Review pinned to homepage!')">📌 Pin to Home</button></td>
                        </tr>
                        <tr>
                            <td><strong>Deepak Singhal</strong><br><small style="color:#7A7266;">2 days ago</small></td>
                            <td>Banarasi Royal Brocade</td>
                            <td><span style="color:#F59E0B; font-weight:800;">★★★★★</span> (5.0)</td>
                            <td>"Excellent bulk lot packaging. Quality verified by our boutique master."</td>
                            <td><span class="adm-badge warning">Pending</span></td>
                            <td><button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Review Approved!')">✓ Approve</button></td>
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
