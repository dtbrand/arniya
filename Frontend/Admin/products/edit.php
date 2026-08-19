<?php
/**
 * edit.php - DT Brand's Admin Edit Product Details
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Product Details";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product Details - DT Brand's Admin</title>
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
                        <span>Edit Product Details</span>
                        <span class="adm-badge gold">SKU: KLN-SR-111</span>
                    </h1>
                    <p class="adm-page-subtitle">Modify specifications, live pricing, stock allocations, and media gallery.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>✏️ Edit Kanjivaram Pure Silk Gold Zari Saree</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Changes Saved Successfully!')">Save Changes</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group full">
                    <label class="adm-form-label">Product Title</label>
                    <input type="text" class="adm-form-input" value="Kanjivaram Pure Silk Gold Zari Saree">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Retail Price (₹)</label>
                    <input type="number" class="adm-form-input" value="4490">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Wholesale Price (₹)</label>
                    <input type="number" class="adm-form-input" value="2850">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Available Stock Units</label>
                    <input type="number" class="adm-form-input" value="45">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Stock Status</label>
                    <select class="adm-form-select">
                        <option selected>In Stock</option>
                        <option>Low Stock</option>
                        <option>Out of Stock</option>
                    </select>
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
