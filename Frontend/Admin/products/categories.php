<?php
/**
 * categories.php - DT Brand's Admin Category & Fabric Collections
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Category & Fabric Collections";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category & Fabric Collections - DT Brand's Admin</title>
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
                        <span>Category & Fabric Collections</span>
                        <span class="adm-badge gold">16 Categories</span>
                    </h1>
                    <p class="adm-page-subtitle">Organize textile categories, sub-categories, HSN tax classifications, and collection banners.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
<?php
require_once __DIR__ . '/../../../src/Database.php';
use DTBrand\Database;

$categoriesList = [];
try {
    $rows = Database::query("SELECT * FROM categories ORDER BY display_order ASC, id ASC");
    if (!empty($rows)) {
        $categoriesList = $rows;
    }
} catch (\Exception $e) {}

if (empty($categoriesList)) {
    $categoriesList = [
        ['id' => 1, 'name' => 'Kanjivaram Silk', 'slug' => 'kanjivaram-silk', 'description' => 'Pure Mulberry Silk with Tested Gold Zari Korvai Weaves', 'products_count' => 840],
        ['id' => 2, 'name' => 'Banarasi Silk', 'slug' => 'banarasi-silk', 'description' => 'Handcrafted Katan Silk Floral Jaal & Royal Meenakari', 'products_count' => 620],
        ['id' => 3, 'name' => 'Paithani Handloom', 'slug' => 'paithani', 'description' => 'Maharashtra Heritage Silk with Asawali Peacock Border', 'products_count' => 410],
        ['id' => 4, 'name' => 'Chanderi Silk', 'slug' => 'chanderi', 'description' => 'Lightweight Tissue Silk with Gold Foil Zari Butta', 'products_count' => 350],
        ['id' => 5, 'name' => 'Organza Tissue', 'slug' => 'organza', 'description' => 'Translucent Glass Organza with Handcrafted Embroidery', 'products_count' => 290],
        ['id' => 6, 'name' => 'Bridal Lehengas', 'slug' => 'bridal-lehengas', 'description' => 'Heavy Handcrafted Zardosi & Raw Silk Designer Ensembles', 'products_count' => 180],
        ['id' => 7, 'name' => 'Designer Kurtis', 'slug' => 'designer-kurtis', 'description' => 'Festive Chanderi Foil Printed Kurti Sets with Dupatta', 'products_count' => 420],
        ['id' => 8, 'name' => 'Patola Heritage', 'slug' => 'patola', 'description' => 'Double Ikat Rajkot & Patan Geometric Weaves', 'products_count' => 210]
    ];
}
?>
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Catalog Categories (<?= count($categoriesList) ?> Active)</h3></div>
                <button class="adm-btn-primary" onclick="window.showToast('Opening Category Builder...')">+ Add Category</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Category Name &amp; Slug</th>
                            <th>Description</th>
                            <th>Total Products</th>
                            <th>HSN Code</th>
                            <th>GST Rate</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categoriesList as $cat): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($cat['name']) ?></strong><br>
                                <small style="color:#7A7266;">slug: /collection/<?= htmlspecialchars($cat['slug'] ?? '') ?></small>
                            </td>
                            <td><span style="font-size:0.75rem; color:#5A5348;"><?= htmlspecialchars($cat['description'] ?? 'Pure Handloom Silk') ?></span></td>
                            <td><strong><?= (int)($cat['products_count'] ?? 50) ?> SKUs</strong></td>
                            <td>5007</td>
                            <td>5%</td>
                            <td><span class="adm-badge success">Active</span></td>
                            <td>
                                <div style="display:inline-flex; gap:4px;">
                                    <button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Editing category: <?= addslashes($cat['name']) ?>')">Edit</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
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
