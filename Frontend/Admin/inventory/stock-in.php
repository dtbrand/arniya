<?php
/**
 * stock-in.php - DT Brand's Admin Stock Inward Consignment Entry
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Stock Inward Consignment Entry";
$active_nav = "inventory";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Inward Consignment Entry - DT Brand's Admin</title>
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
                        <span>Stock Inward Consignment Entry</span>
                        <span class="adm-badge gold">Warehouse Inward</span>
                    </h1>
                    <p class="adm-page-subtitle">Record incoming lots from Surat weaving mills into warehouse stock.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/inventory/" class="adm-btn-secondary">← Back to Inventory Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📥 Stock Inward Entry Form</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Stock Inward Recorded Successfully!')">+ Record Inward</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Select SKU</label>
                    <select class="adm-form-select">
                        <option>KLN-SR-111 (Kanjivaram Silk)</option>
                        <option>BNR-SR-204 (Banarasi Brocade)</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Received Quantity (Pcs)</label>
                    <input type="number" class="adm-form-input" value="50">
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Warehouse Depot</label>
                    <select class="adm-form-select">
                        <option>Surat Central Hub</option>
                        <option>Bhiwandi Depot</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Supplier / Weaving Unit</label>
                    <input type="text" class="adm-form-input" value="Surat Mill Weaving Unit #3">
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
