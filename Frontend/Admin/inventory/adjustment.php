<?php
/**
 * adjustment.php - DT Brand's Admin Inventory Stock Reconciliation
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Inventory Stock Reconciliation";
$active_nav = "inventory";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Stock Reconciliation - DT Brand's Admin</title>
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
                        <span>Inventory Stock Reconciliation</span>
                        <span class="adm-badge gold">Audit Mode</span>
                    </h1>
                    <p class="adm-page-subtitle">Manually adjust stock counts following physical warehouse audits.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/inventory/" class="adm-btn-secondary">← Back to Inventory Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>⚖️ Physical Stock Adjustment Form</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Stock Count Reconciled!')">Save Adjustment</button>
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label">Select SKU</label>
                    <select class="adm-form-select">
                        <option>KLN-SR-111 (Kanjivaram Silk)</option>
                    </select>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label">Adjustment Quantity (+ / -)</label>
                    <input type="number" class="adm-form-input" value="+5">
                </div>
                <div class="adm-form-group full">
                    <label class="adm-form-label">Reason for Adjustment</label>
                    <input type="text" class="adm-form-input" value="Physical count discrepancy audit at Surat Hub">
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
