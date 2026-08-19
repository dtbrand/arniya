<?php
/**
 * add.php — Multi-Section Add Product Studio
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Add Product";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/products.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/product-form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/variants.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1>
                        <span>Add Product</span>
                        <span class="adm-badge gold">New SKU</span>
                    </h1>
                    <p>Create a new textile product with multi-tier pricing, media gallery, and variant matrices.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">Cancel</a>
                    <button type="button" class="adm-btn-secondary" onclick="window.showToast('Draft saved successfully!')">Save Draft</button>
                    <button type="button" class="adm-btn-primary" onclick="window.showToast('✨ Product published to live catalog!')">Save & Publish</button>
                </div>
            </div>

            <div class="dt-form-grid-layout">
                <!-- Left Main Column -->
                <div>
                    <!-- 1. Basic Information -->
                    <div class="dt-form-section">
                        <div class="dt-form-sec-head">
                            <h3 class="dt-form-sec-title"><span>👗 Basic Information</span></h3>
                        </div>
                        <div class="dt-form-sec-body">
                            <div class="adm-form-grid">
                                <div class="adm-form-group full">
                                    <label class="adm-form-label">Product Name / Title *</label>
                                    <input type="text" id="pFormName" class="adm-form-input" placeholder="e.g. Kanjivaram Pure Silk Gold Zari Wedding Saree" oninput="window.updateGoogleSeoPreview()">
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
                                    <label class="adm-form-label">Subcategory</label>
                                    <select class="adm-form-select">
                                        <option>Kanjivaram Silk</option>
                                        <option>Paithani Zari</option>
                                        <option>Mysore Crepe</option>
                                    </select>
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Brand</label>
                                    <select class="adm-form-select">
                                        <option>DT Signature</option>
                                        <option>Arniya Heritage</option>
                                        <option>DT Couture</option>
                                    </select>
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Fabric / Weave</label>
                                    <input type="text" class="adm-form-input" placeholder="e.g. Pure Mulberry Silk / Gold Zari Weave">
                                </div>
                                <div class="adm-form-group full">
                                    <label class="adm-form-label">Detailed Product Description</label>
                                    <textarea class="adm-form-textarea" rows="4" placeholder="Handwoven authentic Kanjivaram silk saree featuring pure gold zari border and rich pallu design. Includes unstitched matching blouse piece."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Product Media Upload -->
                    <div class="dt-form-section">
                        <div class="dt-form-sec-head">
                            <h3 class="dt-form-sec-title"><span>📸 Product Media & Photos</span></h3>
                        </div>
                        <div class="dt-form-sec-body">
                            <div class="dt-dropzone" onclick="document.getElementById('pFileInput').click()">
                                <div style="font-size:2rem; margin-bottom:6px;">📤</div>
                                <strong>Drag & Drop Product Images or Click to Browse</strong>
                                <p style="font-size:0.75rem; color:#7A7266; margin-top:4px;">Supports high-res JPG, PNG, WebP format (Auto-compressed for web).</p>
                                <input type="file" id="pFileInput" style="display:none;" multiple onchange="window.handleImageUpload(this.files)">
                            </div>
                            <div class="dt-gallery-preview-grid">
                                <div class="dt-gallery-item is-main">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';">
                                    <span class="dt-gallery-main-tag">PRIMARY</span>
                                </div>
                                <div class="dt-gallery-item">
                                    <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Multi-Tier Pricing -->
                    <div class="dt-form-section">
                        <div class="dt-form-sec-head">
                            <h3 class="dt-form-sec-title"><span>🏷️ Multi-Tier Pricing Schedule</span></h3>
                        </div>
                        <div class="dt-form-sec-body">
                            <div class="adm-form-grid">
                                <div class="adm-form-group">
                                    <label class="adm-form-label">MRP (Maximum Retail Price) ₹</label>
                                    <input type="number" id="pFormMrp" class="adm-form-input" placeholder="e.g. 5990" oninput="window.calcPricePreview()">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">B2C Retail Selling Price ₹ *</label>
                                    <input type="number" id="pFormRetail" class="adm-form-input" placeholder="e.g. 4490" oninput="window.calcPricePreview()">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Reseller Base Price ₹ *</label>
                                    <input type="number" class="adm-form-input" placeholder="e.g. 3450">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Wholesale Price (MOQ 8+ pcs) ₹ *</label>
                                    <input type="number" id="pFormWholesale" class="adm-form-input" placeholder="e.g. 2850" oninput="window.calcPricePreview()">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Bulk Lot Price (MOQ 30+ pcs) ₹</label>
                                    <input type="number" class="adm-form-input" placeholder="e.g. 2650">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Weaving Cost Price ₹</label>
                                    <input type="number" id="pFormCost" class="adm-form-input" placeholder="e.g. 2100" oninput="window.calcPricePreview()">
                                </div>
                            </div>

                            <div class="dt-calc-price-card">
                                <div class="dt-calc-row">
                                    <span>Discount on MRP:</span>
                                    <strong id="pPrevDiscount" style="color:#15803D;">25% Off</strong>
                                </div>
                                <div class="dt-calc-row">
                                    <span>Estimated Gross Profit:</span>
                                    <strong id="pPrevMargin" style="color:#8A681F;">53% Gross Margin</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Variants Matrix -->
                    <?php include_once __DIR__ . '/components/variant-table.php'; ?>

                    <!-- 5. SEO Section -->
                    <?php include_once __DIR__ . '/components/seo-section.php'; ?>
                </div>

                <!-- Right Sidebar Column -->
                <div>
                    <!-- Visibility & Publishing -->
                    <div class="dt-form-section">
                        <div class="dt-form-sec-head">
                            <h3 class="dt-form-sec-title"><span>👁️ Visibility & Flags</span></h3>
                        </div>
                        <div class="dt-form-sec-body">
                            <div class="adm-form-group" style="margin-bottom:12px;">
                                <label class="adm-form-label">Publishing Status</label>
                                <select class="adm-form-select">
                                    <option>Published (Live in Shop)</option>
                                    <option>Draft (Admin Only)</option>
                                    <option>Scheduled</option>
                                </select>
                            </div>
                            <div style="display:flex; flex-direction:column; gap:8px; margin-top:12px;">
                                <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" checked> ⭐️ Mark as Featured Product
                                </label>
                                <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" checked> 🔥 Mark as Best Seller
                                </label>
                                <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; font-weight:600; cursor:pointer;">
                                    <input type="checkbox" checked> ✨ Mark as New Arrival
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Section -->
                    <?php include_once __DIR__ . '/components/inventory-section.php'; ?>

                    <!-- Shipping Section -->
                    <?php include_once __DIR__ . '/components/shipping-section.php'; ?>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/product-form.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/product-gallery.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/variants.js?v=<?php echo time(); ?>"></script>
</body>
</html>
