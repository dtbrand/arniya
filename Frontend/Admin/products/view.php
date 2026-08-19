<?php
/**
 * view.php - DT Brand's Admin Product Catalog Inspector
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Catalog Inspector";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog Inspector - DT Brand's Admin</title>
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
                        <span>Product Catalog Inspector</span>
                        <span class="adm-badge gold">Live SKU</span>
                    </h1>
                    <p class="adm-page-subtitle">Detailed preview of product specifications, stock locations, and tiered pricing.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>👗 Kanjivaram Pure Silk Gold Zari Saree (KLN-SR-111)</span></h3>
                <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products</a>
            </div>
            <div style="display:grid; grid-template-columns:1fr 2fr; gap:24px;">
                <div>
                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:100%; border-radius:8px; border:1px solid #E5E1D7;">
                </div>
                <div>
                    <h2 style="font-family:var(--adm-font-serif); font-size:1.3rem; margin-bottom:8px;">Kanjivaram Pure Silk Gold Zari Saree</h2>
                    <p style="color:#7A7266; font-size:0.85rem; margin-bottom:16px;">SKU: <strong>KLN-SR-111</strong> • HSN: <strong>5007</strong> • Fabric: <strong>Pure Silk</strong> • Warehouse: <strong>Surat Hub</strong></p>
                    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:12px; margin-bottom:18px;">
                        <div style="padding:12px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:6px; text-align:center;">
                            <small style="color:#7A7266;">Retail MRP</small>
                            <div style="font-size:1.15rem; font-weight:800; color:#181512;">₹4,490</div>
                        </div>
                        <div style="padding:12px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:6px; text-align:center;">
                            <small style="color:#7A7266;">Reseller Margin</small>
                            <div style="font-size:1.15rem; font-weight:800; color:#7E22CE;">₹3,450</div>
                        </div>
                        <div style="padding:12px; background:#FAF5E8; border:1px solid #E5D5A8; border-radius:6px; text-align:center;">
                            <small style="color:#8A681F; font-weight:700;">Wholesale MOQ 8+</small>
                            <div style="font-size:1.15rem; font-weight:800; color:#8A681F;">₹2,850</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:10px;">
                        <button class="adm-btn-primary" onclick="window.showToast('Opening Edit Screen...')">✏️ Edit Product</button>
                        <button class="adm-btn-secondary" onclick="window.showToast('WhatsApp share link copied!')">💬 Share on WhatsApp</button>
                    </div>
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
