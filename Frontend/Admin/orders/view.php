<?php
/**
 * view.php - DT Brand's Admin Order Fulfillment Inspector
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Order Fulfillment Inspector";
$active_nav = "orders";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Fulfillment Inspector - DT Brand's Admin</title>
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
                        <span>Order Fulfillment Inspector</span>
                        <span class="adm-badge gold">#ORD-9842</span>
                    </h1>
                    <p class="adm-page-subtitle">Complete invoice breakdown, shipping AWB, buyer GST details, and status controls.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/orders/" class="adm-btn-secondary">← Back to Orders Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📦 Order #ORD-9842 (Vardhman Textiles)</span></h3>
                <div style="display:flex; gap:8px;">
                    <button class="adm-btn-secondary" onclick="window.showToast('Printing Tax Invoice...')">🖨️ Print Invoice</button>
                    <button class="adm-btn-primary" onclick="window.showToast('WhatsApp tracking update sent!')">💬 WhatsApp Update</button>
                </div>
            </div>
            <div style="display:grid; grid-template-columns:2fr 1fr; gap:20px;">
                <div style="background:#FAF8F4; padding:18px; border-radius:8px; border:1px solid #E5E1D7;">
                    <h4 style="margin-bottom:10px;">Consignment Items</h4>
                    <p>• Kanjivaram Pure Silk Sarees (25 pcs) — <strong>₹71,250</strong></p>
                    <p>• Banarasi Royal Brocade (10 pcs) — <strong>₹32,000</strong></p>
                    <p>• Heavy Freight Shipping (TCI Freight) — <strong>₹3,500</strong></p>
                    <p>• GST Tax (5%) — <strong>₹5,500</strong></p>
                    <hr style="margin:12px 0; border:none; border-top:1px solid #E5E1D7;">
                    <div style="font-size:1.15rem; font-weight:800; color:#8A681F;">Total Paid: ₹1,12,250</div>
                </div>
                <div style="background:#FAF8F4; padding:18px; border-radius:8px; border:1px solid #E5E1D7;">
                    <h4 style="margin-bottom:10px;">Buyer & Shipping Info</h4>
                    <p><strong>Vardhman Textiles</strong></p>
                    <p>Prop: Rajesh Kumar</p>
                    <p>GSTIN: <code>24AAACV1234F1Z5</code></p>
                    <p>Phone: +91 98220 19283</p>
                    <p>AWB: <code>DEL-994820192</code> (TCI Freight)</p>
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
