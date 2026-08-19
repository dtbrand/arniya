<?php
/**
 * add.php - DT Brand's Admin Add New Textile Product
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Add New Textile Product";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Textile Product - DT Brand's Admin</title>
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
                        <span>Add New Textile Product</span>
                        <span class="adm-badge gold">Catalog Studio</span>
                    </h1>
                    <p class="adm-page-subtitle">Create a new Pure Silk Saree, Brocade, Lehenga, or Kurti with multi-tier pricing.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>👗 Product Information & Specifications</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Product Published to Catalog!')">Publish Product</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group full">
                    <label class="adm-form-label">Product Name / Title *</label>
                    <input type="text" class="adm-form-input" placeholder="e.g. Kanjivaram Pure Silk Gold Zari Wedding Saree">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">SKU Code *</label>
                    <input type="text" class="adm-form-input" placeholder="e.g. KLN-SR-112">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">HSN Code *</label>
                    <input type="text" class="adm-form-input" value="5007 (Silk)">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Category *</label>
                    <select class="adm-form-select">
                        <option>Silk Sarees</option>
                        <option>Banarasi Brocade</option>
                        <option>Bridal Lehengas</option>
                        <option>Designer Kurtis</option>
                        <option>Dress Materials</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Fabric / Material</label>
                    <input type="text" class="adm-form-input" placeholder="e.g. Pure Mulberry Silk / Zari Weave">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Retail MRP (₹) *</label>
                    <input type="number" class="adm-form-input" placeholder="e.g. 4490">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Reseller Price (₹) *</label>
                    <input type="number" class="adm-form-input" placeholder="e.g. 3450">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Wholesale Price (₹) *</label>
                    <input type="number" class="adm-form-input" placeholder="e.g. 2850">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Wholesale MOQ (Min Qty) *</label>
                    <input type="number" class="adm-form-input" value="8">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Initial Stock Units *</label>
                    <input type="number" class="adm-form-input" value="50">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Warehouse Location</label>
                    <select class="adm-form-select">
                        <option>Surat Central Hub</option>
                        <option>Bhiwandi Depot</option>
                    </select>
                </div>
                <div class="adm-form-group full">
                    <label class="adm-form-label">Product Description & Weaving Details</label>
                    <textarea class="adm-form-textarea" rows="3" placeholder="Handwoven authentic Kanjivaram silk saree featuring pure gold zari border and rich pallu design. Includes unstitched matching blouse piece."></textarea>
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
