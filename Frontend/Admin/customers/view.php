<?php
/**
 * view.php - DT Brand's Admin Customer Profile Inspector
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Customer Profile Inspector";
$active_nav = "customers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile Inspector - DT Brand's Admin</title>
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
                        <span>Customer Profile Inspector</span>
                        <span class="adm-badge gold">Pooja Sharma</span>
                    </h1>
                    <p class="adm-page-subtitle">View lifetime orders, shipping addresses, customer tier, and direct WhatsApp history.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/customers/" class="adm-btn-secondary">← Back to Customers Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>👤 Customer: Pooja Sharma</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('WhatsApp Chat Opened!')">💬 Chat on WhatsApp</button>
            </div>
            <div style="display:grid; grid-template-columns:1fr 2fr; gap:20px;">
                <div style="background:#FAF8F4; padding:18px; border-radius:8px; border:1px solid #E5E1D7;">
                    <h4>Profile Details</h4>
                    <p>Phone: <strong>+91 98110 29381</strong></p>
                    <p>Email: pooja.s@gmail.com</p>
                    <p>City: Delhi, DL</p>
                    <p>Joined: Jan 2026</p>
                    <p>Total Orders: <strong>4</strong></p>
                    <p>Total Spend: <strong style="color:#8A681F;">₹18,450</strong></p>
                </div>
                <div style="background:#FAF8F4; padding:18px; border-radius:8px; border:1px solid #E5E1D7;">
                    <h4>Recent Order History</h4>
                    <p>• #ORD-9841 — Banarasi Royal Brocade (₹4,990) — <span class="adm-badge success">Delivered</span></p>
                    <p>• #ORD-9610 — Kanjivaram Pure Silk (₹4,490) — <span class="adm-badge success">Delivered</span></p>
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
