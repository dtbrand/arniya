<?php
/**
 * index.php - DT Brand's Admin Customers Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "B2C Customer CRM & Directory";
$active_nav = "customers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B2C Customer CRM & Directory - DT Brand's Admin</title>
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
                        <span>B2C Customer CRM & Directory</span>
                        <span class="adm-badge gold">4,820 Shoppers</span>
                    </h1>
                    <p class="adm-page-subtitle">Explore direct retail customers, wishlists, repeat rate, and lifetime spend values.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Total Customers</span>
                <div class="adm-kpi-icon-box">👥</div>
            </div>
            <div class="adm-kpi-val">4,820</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">↑ +348 this month</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Repeat Purchase Rate</span>
                <div class="adm-kpi-icon-box">🔄</div>
            </div>
            <div class="adm-kpi-val">38.4%</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">High Customer Loyalty</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Average Customer LTV</span>
                <div class="adm-kpi-icon-box">💎</div>
            </div>
            <div class="adm-kpi-val">₹6,850</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">2.8 Orders / Year</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Average Order Value</span>
                <div class="adm-kpi-icon-box">🛍️</div>
            </div>
            <div class="adm-kpi-val">₹2,299</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Prepaid + COD Mix</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div class="adm-table-filters">
                    <input type="text" class="adm-form-input" style="width:260px;" placeholder="Search customer name, phone, city..." oninput="window.filterCustomers(this.value)">
                </div>
                <div class="adm-page-actions">
                    <button class="adm-btn-secondary" onclick="window.showToast('Exporting Customer CSV...')">📥 Export CSV</button>
                </div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Phone & Email</th>
                            <th>City / State</th>
                            <th>Orders Placed</th>
                            <th>Lifetime Spent</th>
                            <th>Last Purchase</th>
                            <th>Direct Connect</th>
                        </tr>
                    </thead>
                    <tbody id="admCustomersTableBody">
                        <tr>
                            <td>
                                <div class="adm-table-prod-cell">
                                    <div class="adm-wa-avatar" style="background:#FAF5E8; color:#8A681F;">P</div>
                                    <div><strong>Pooja Sharma</strong><br><small style="color:#15803D;">Verified Buyer</small></div>
                                </div>
                            </td>
                            <td>+91 98110 29381<br><small style="color:#7A7266;">pooja.s@gmail.com</small></td>
                            <td>Delhi, DL</td>
                            <td><strong>4 orders</strong></td>
                            <td><strong style="color:#8A681F;">₹18,450</strong></td>
                            <td>Today, 09:45 AM</td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('WhatsApp Chat Opened!')">💬</button></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="adm-table-prod-cell">
                                    <div class="adm-wa-avatar" style="background:#FAF5E8; color:#8A681F;">A</div>
                                    <div><strong>Ananya Roy</strong><br><small style="color:#15803D;">Verified Buyer</small></div>
                                </div>
                            </td>
                            <td>+91 97118 23901<br><small style="color:#7A7266;">ananya.roy@yahoo.com</small></td>
                            <td>Jaipur, RJ</td>
                            <td><strong>3 orders</strong></td>
                            <td><strong style="color:#8A681F;">₹12,890</strong></td>
                            <td>Yesterday</td>
                            <td><button class="adm-action-btn wa" onclick="window.showToast('WhatsApp Chat Opened!')">💬</button></td>
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
