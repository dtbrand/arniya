<?php
/**
 * DT Brand/admin/products.php — Products Inventory Management & CRUD
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

// Handle CRUD operations
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $pdo = Database::getConnection();

    if ($action === 'create' && $pdo) {
        $sku = trim($_POST['sku'] ?? 'SKU-' . time());
        $title = trim($_POST['title'] ?? 'New Ethnic Saree');
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $cat = trim($_POST['category_name'] ?? 'Kanjivaram Silk');
        $fabric = trim($_POST['fabric'] ?? 'Pure Silk');
        $retail = (float)($_POST['retail_price'] ?? 4899);
        $wholesale = (float)($_POST['wholesale_price'] ?? 1399);
        $reseller = (float)($_POST['reseller_price'] ?? 2100);
        $mrp = (float)($_POST['mrp'] ?? ($retail * 1.3));
        $stock = (int)($_POST['stock_qty'] ?? 50);
        $img = trim($_POST['primary_image'] ?? '/assets/images/product1.png');

        Database::execute("
            INSERT INTO products (sku, title, slug, category_name, fabric, mrp, retail_price, wholesale_price, reseller_price, stock_qty, primary_image, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'in_stock', NOW())
        ", [$sku, $title, $slug, $cat, $fabric, $mrp, $retail, $wholesale, $reseller, $stock, $img]);
        $msg = 'Product created successfully!';
    } elseif ($action === 'delete' && $pdo && isset($_POST['id'])) {
        $delId = (int)$_POST['id'];
        Database::execute("DELETE FROM products WHERE id = ?", [$delId]);
        $msg = 'Product deleted successfully!';
    }
}

$products = ProductCatalog::getAll();
$categories = ProductCatalog::getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Products Management &bull; DT Brand's Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/header.css?v=<?= time() ?>">

    <style>
        body { background: #F8FAFC; color: #1E293B; }
        .dt-adm-header {
            background: #181512;
            color: #FAF5E8;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #D4AF37;
        }
        .dt-adm-nav-link { color: #CBD5E1; font-size: 0.82rem; font-weight: 600; padding: 6px 12px; border-radius: 6px; text-decoration: none; }
        .dt-adm-nav-link:hover, .dt-adm-nav-link.active { background: rgba(212, 175, 55, 0.2); color: #FFE699; }
        .dt-adm-container { max-width: 1440px; margin: 24px auto; padding: 0 20px; }
        .dt-adm-table-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .dt-adm-table { width: 100%; border-collapse: collapse; font-size: 0.84rem; min-width: 780px; }
        .dt-adm-table th { background: #F8FAFC; padding: 10px 14px; text-align: left; font-weight: 700; color: #475569; border-bottom: 1.5px solid #E2E8F0; }
        .dt-adm-table td { padding: 10px 14px; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
    </style>
</head>
<body>

    <header class="dt-adm-header">
        <div style="display:flex; align-items:center; gap:12px;">
            <a href="/admin/"><img src="/assets/images/logo.png" onerror="this.src='/assets/images/logo.png';" alt="DT Brand's" style="height:28px;" /></a>
            <h1 style="font-size:1.15rem; font-weight:800; color:#FFFFFF;">Products Management</h1>
        </div>
        <nav style="display:flex; align-items:center; gap:8px;">
            <a href="/admin/" class="dt-adm-nav-link">Dashboard</a>
            <a href="/admin/products.php" class="dt-adm-nav-link active">Products (<?= count($products) ?>)</a>
            <a href="/admin/categories.php" class="dt-adm-nav-link">Categories</a>
            <a href="/admin/orders.php" class="dt-adm-nav-link">Orders</a>
        </nav>
    </header>

    <main class="dt-adm-container">
        
        <?php if (!empty($msg)): ?>
        <div style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; padding:10px 16px; border-radius:6px; margin-bottom:16px; font-weight:700;">
            <?= htmlspecialchars($msg) ?>
        </div>
        <?php endif; ?>

        <!-- Add Product Form Card -->
        <div class="dt-adm-table-card" style="margin-bottom:24px;">
            <h3 style="font-size:1.05rem; font-weight:800; color:#0F172A; margin-bottom:14px;">+ Add New Product to Inventory</h3>
            <form method="POST">
                <input type="hidden" name="action" value="create" />
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Title / Name *</label>
                        <input type="text" name="title" class="dt-input-field" placeholder="e.g. Zari Kanjivaram Saree" required />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">SKU *</label>
                        <input type="text" name="sku" class="dt-input-field" placeholder="e.g. KLN-SR-999" required />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Category *</label>
                        <select name="category_name" class="dt-input-field">
                            <?php foreach ($categories as $c): ?>
                            <option value="<?= htmlspecialchars($c) ?>"><?= htmlspecialchars($c) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Fabric</label>
                        <input type="text" name="fabric" class="dt-input-field" value="Pure Silk" />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Retail Price (₹)</label>
                        <input type="number" name="retail_price" class="dt-input-field" value="4899" required />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Wholesale Price (₹)</label>
                        <input type="number" name="wholesale_price" class="dt-input-field" value="1399" required />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Reseller Price (₹)</label>
                        <input type="number" name="reseller_price" class="dt-input-field" value="2100" required />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Stock Qty</label>
                        <input type="number" name="stock_qty" class="dt-input-field" value="50" required />
                    </div>
                </div>
                <button type="submit" class="dt-btn-gold">
                    <span>Save Product to Catalog</span>
                </button>
            </form>
        </div>

        <!-- Inventory List -->
        <div class="dt-adm-table-card">
            <h3 style="font-size:1.05rem; font-weight:800; color:#0F172A; margin-bottom:16px;">Product Inventory (<?= count($products) ?> SKUs)</h3>
            <div style="overflow-x:auto;">
                <table class="dt-adm-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Retail Price</th>
                            <th>Wholesale Price</th>
                            <th>Reseller Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $p): ?>
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="" style="width:34px; height:44px; border-radius:4px; object-fit:cover;" />
                                    <span style="font-weight:700; color:#0F172A;"><?= htmlspecialchars($p['name']) ?></span>
                                </div>
                            </td>
                            <td><code><?= htmlspecialchars($p['sku']) ?></code></td>
                            <td><?= htmlspecialchars($p['category']) ?></td>
                            <td><strong>₹<?= number_format($p['price']) ?></strong></td>
                            <td><strong style="color:#8A681F;">₹<?= number_format($p['wholesale_price']) ?></strong></td>
                            <td><strong style="color:#15803D;">₹<?= number_format($p['reseller_price']) ?></strong></td>
                            <td><?= $p['stock_qty'] ?? 50 ?> Pcs</td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <input type="hidden" name="action" value="delete" />
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>" />
                                    <button type="submit" class="dt-btn-pale" style="color:#DC2626; border-color:#DC2626; padding:2px 8px; font-size:0.72rem;">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>
