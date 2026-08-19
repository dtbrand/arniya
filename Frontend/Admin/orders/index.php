<?php
/**
 * index.php - DT Brand's Admin Orders Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Orders & Logistics Fulfillment Center";
$active_nav = "orders";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders & Logistics Fulfillment Center - DT Brand's Admin</title>
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
                        <span>Orders & Logistics Fulfillment Center</span>
                        <span class="adm-badge gold">1,624 Orders</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage B2B wholesale dispatches, reseller margins, and retail parcel shipments.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Total Orders</span>
                <div class="adm-kpi-icon-box">📦</div>
            </div>
            <div class="adm-kpi-val">1,624</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">↑ +14.6% growth</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Pending Dispatch</span>
                <div class="adm-kpi-icon-box">⏳</div>
            </div>
            <div class="adm-kpi-val">18</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta down">Requires Shipping</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">In Transit</span>
                <div class="adm-kpi-icon-box">🚚</div>
            </div>
            <div class="adm-kpi-val">84</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Courier Surface/Air</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Delivered Success</span>
                <div class="adm-kpi-icon-box">✅</div>
            </div>
            <div class="adm-kpi-val">1,542</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">94.9% Success Rate</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div class="adm-table-filters">
                    <select class="adm-filter-select" onchange="filterModuleTable(this.value, 'channel')">
                        <option value="all">All Channels</option>
                        <option value="Wholesale B2B">Wholesale B2B</option>
                        <option value="Reseller">Reseller Hub</option>
                        <option value="B2C Shop">B2C Shop</option>
                    </select>
                    <select class="adm-filter-select" onchange="filterModuleTable(this.value, 'status')">
                        <option value="all">All Status</option>
                        <option value="Delivered">Delivered</option>
                        <option value="In Transit">In Transit</option>
                        <option value="Packed">Packed</option>
                        <option value="Confirmed">Confirmed</option>
                    </select>
                </div>
                <div class="adm-page-actions">
                    <button class="adm-btn-secondary" onclick="window.showToast('Exporting Orders CSV...')">📥 Export CSV</button>
                    <button class="adm-btn-primary" onclick="window.showToast('Generating Bulk Shipping Labels...')">🏷️ Bulk Labels</button>
                </div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer / Partner</th>
                            <th>Channel</th>
                            <th>Consignment Items</th>
                            <th>Amount & Payment</th>
                            <th>Fulfillment Status</th>
                            <th>Courier & Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong style="color:#8A681F; font-size:0.88rem;">#ORD-9842</strong><br><small style="color:#7A7266;">Today, 11:20 AM</small></td>
                            <td><strong>Rajesh Kumar (Vardhman Tex)</strong><br><small style="color:#8A681F;">+91 98220 19283 • Surat, GJ</small></td>
                            <td><span style="font-weight:700; background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:6px;">Wholesale B2B</span></td>
                            <td>Kanjivaram Silks Lot (Qty: 25 pcs)</td>
                            <td><strong>₹1,12,250</strong><br><small style="color:#15803D;">Bank Wire Paid</small></td>
                            <td><span class="adm-badge info">In Transit</span></td>
                            <td>
                                <div class="adm-action-btn-group">
                                    <button class="adm-action-btn wa" title="Send WhatsApp Update" onclick="window.showToast('WhatsApp tracking sent!')">💬</button>
                                    <button class="adm-action-btn" title="Print GST Invoice" onclick="window.showToast('Printing GST Invoice...')">🖨️</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong style="color:#8A681F; font-size:0.88rem;">#ORD-9841</strong><br><small style="color:#7A7266;">Today, 09:45 AM</small></td>
                            <td><strong>Pooja Sharma</strong><br><small style="color:#8A681F;">+91 98110 29381 • Delhi, DL</small></td>
                            <td><span style="font-weight:700; background:#F8F6F0; padding:2px 8px; border-radius:6px;">B2C Shop</span></td>
                            <td>Banarasi Brocade Weave (Qty: 1 pc)</td>
                            <td><strong>₹4,990</strong><br><small style="color:#15803D;">Prepaid (UPI)</small></td>
                            <td><span class="adm-badge success">Delivered</span></td>
                            <td>
                                <div class="adm-action-btn-group">
                                    <button class="adm-action-btn wa" title="Send WhatsApp Update" onclick="window.showToast('WhatsApp tracking sent!')">💬</button>
                                    <button class="adm-action-btn" title="Print GST Invoice" onclick="window.showToast('Printing GST Invoice...')">🖨️</button>
                                </div>
                            </td>
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
