<?php
/**
 * index.php - DT Brand's Admin Shipping Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Shipping Logistics & Courier Hub";
$active_nav = "shipping";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Logistics & Courier Hub - DT Brand's Admin</title>
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
                        <span>Shipping Logistics & Courier Hub</span>
                        <span class="adm-badge gold">Integrated</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage Delhivery, BlueDart, and TCI Freight consignments with real-time tracking.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Dispatches MTD</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">1,624 Pcs</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Air & Surface Mix</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Avg Delivery Time</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">2.8 Days</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Express Courier SLA</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Live In Transit</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">84 Consignments</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Out for Delivery</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">RTO Return Rate</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">0.3%</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Lowest Industry RTO</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Courier Partner Serviceability & Dispatches</span></h3>
                    <button class="adm-btn-primary" onclick="window.showToast('Generating Courier Manifest...')">📄 Generate Manifest</button>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>AWB / Tracking #</th>
                                <th>Order ID</th>
                                <th>Courier Partner</th>
                                <th>Destination City</th>
                                <th>Weight / Pcs</th>
                                <th>Shipping Mode</th>
                                <th>Tracking Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>DEL-994820192</code></td>
                                <td><strong>#ORD-9842</strong></td>
                                <td>TCI Freight Cargo</td>
                                <td>Surat → Delhi</td>
                                <td>18.5 kg (25 pcs)</td>
                                <td>Heavy Surface B2B</td>
                                <td><span class="adm-badge info">In Transit (Hub Arrival)</span></td>
                            </tr>
                            <tr>
                                <td><code>BLU-441920481</code></td>
                                <td><strong>#ORD-9841</strong></td>
                                <td>BlueDart Express</td>
                                <td>Surat → Delhi</td>
                                <td>0.8 kg (1 pc)</td>
                                <td>Express Air B2C</td>
                                <td><span class="adm-badge success">Delivered</span></td>
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
