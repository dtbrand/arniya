<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * DT Brand/admin/categories.php — Category Hierarchy & Sorting Management
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

/*
 * Both branches printed "... successfully!" without looking at what the
 * database returned, and when there was no connection at all they were skipped
 * with no message either way - so a failed insert and a saved one looked
 * identical. Database::execute() returns false on failure, so the notice now
 * follows the actual result.
 */
$msg = '';
$msgOk = true;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $pdo = Database::getConnection();

    if ($pdo === null) {
        $msg = 'No database connection - nothing was saved.';
        $msgOk = false;
    } elseif ($action === 'create') {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            $msg = 'A category name is required.';
            $msgOk = false;
        } else {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
            $desc = trim($_POST['description'] ?? '');
            /*
             * The image field defaulted to /assets/images/product1.png, so every
             * category created here was stamped with one saree's photo as its
             * thumbnail. Left empty it shows the no-image placeholder until a
             * real image is set.
             */
            $img = trim($_POST['image'] ?? '');

            $msgOk = Database::execute("
                INSERT INTO categories (name, slug, description, image, status, display_order, created_at)
                VALUES (?, ?, ?, ?, 'active', 99, NOW())
            ", [$name, $slug, $desc, $img]);
            $msg = $msgOk
                ? 'Category "' . $name . '" created.'
                : 'The category could not be saved. The name or slug may already exist - check the server error log.';
        }
    } elseif ($action === 'delete') {
        $delId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $msgOk = $delId > 0 && Database::execute("DELETE FROM categories WHERE id = ?", [$delId]);
        $msg = $msgOk
            ? 'Category deleted.'
            : 'The category could not be deleted - check the server error log.';
    }
}

$categories = ProductCatalog::getCategoriesWithDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Categories Management &bull; DT Brand's Admin</title>

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
        .dt-adm-container { max-width: 1200px; margin: 24px auto; padding: 0 20px; }
        .dt-adm-table-card { background: #FFFFFF; border: 1px solid #E2E8F0; border-radius: 10px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .dt-adm-table { width: 100%; border-collapse: collapse; font-size: 0.84rem; }
        .dt-adm-table th { background: #F8FAFC; padding: 10px 14px; text-align: left; font-weight: 700; color: #475569; border-bottom: 1.5px solid #E2E8F0; }
        .dt-adm-table td { padding: 10px 14px; border-bottom: 1px solid #F1F5F9; vertical-align: middle; }
    </style>
</head>
<body>

    <header class="dt-adm-header">
        <div style="display:flex; align-items:center; gap:12px;">
            <a href="/admin/"><img src="/assets/images/logo.png" alt="DT Brand's" style="height:28px;" /></a>
            <h1 style="font-size:1.15rem; font-weight:800; color:#FFFFFF;">Category Management</h1>
        </div>
        <nav style="display:flex; align-items:center; gap:8px;">
            <a href="/admin/" class="dt-adm-nav-link">Dashboard</a>
            <a href="/admin/products.php" class="dt-adm-nav-link">Products</a>
            <a href="/admin/categories.php" class="dt-adm-nav-link active">Categories (<?= count($categories) ?>)</a>
            <a href="/admin/orders.php" class="dt-adm-nav-link">Orders</a>
        </nav>
    </header>

    <main class="dt-adm-container">
        
        <?php if (!empty($msg)): ?>
        <div style="background:<?= $msgOk ? '#DCFCE7' : '#FEE2E2' ?>; border:1px solid <?= $msgOk ? '#86EFAC' : '#FECACA' ?>; color:<?= $msgOk ? '#15803D' : '#B91C1C' ?>; padding:10px 16px; border-radius:6px; margin-bottom:16px; font-weight:700;">
            <?= htmlspecialchars($msg) ?>
        </div>
        <?php endif; ?>

        <!-- Add Category Card -->
        <div class="dt-adm-table-card" style="margin-bottom:24px;">
            <h3 style="font-size:1.05rem; font-weight:800; color:#0F172A; margin-bottom:14px;">+ Add New Category</h3>
            <form method="POST">
                <input type="hidden" name="action" value="create" />
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:12px; margin-bottom:12px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Category Name *</label>
                        <input type="text" name="name" class="dt-input-field" placeholder="e.g. Chanderi Silk" required />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Image URL</label>
                        <input type="text" name="image" class="dt-input-field" value="" placeholder="/assets/images/categories/your-file.jpg (optional)" />
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label style="font-size:0.75rem; font-weight:700; color:#475569;">Short Description</label>
                        <input type="text" name="description" class="dt-input-field" placeholder="e.g. Traditional Chanderi handloom zari sarees" />
                    </div>
                </div>
                <button type="submit" class="dt-btn-gold">
                    <span>Save Category</span>
                </button>
            </form>
        </div>

        <!-- Categories List -->
        <div class="dt-adm-table-card">
            <h3 style="font-size:1.05rem; font-weight:800; color:#0F172A; margin-bottom:16px;">Active Categories (<?= count($categories) ?>)</h3>
            <div style="overflow-x:auto;">
                <table class="dt-adm-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Slug</th>
                            <th>Designs Count</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="4" style="padding:24px 14px; text-align:center; color:#64748B;">
                                No active categories are in the database yet. Add the first one with the form above.
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php foreach ($categories as $c): ?>
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <img src="<?= htmlspecialchars($c['image']) ?>" alt="" style="width:36px; height:36px; border-radius:50%; object-fit:<?= !empty($c['has_image']) ? 'cover' : 'contain' ?>; background:#F8FAFC; border:1px solid #D4AF37;" />
                                    <span style="font-weight:700; color:#0F172A;"><?= htmlspecialchars($c['name']) ?></span>
                                </div>
                            </td>
                            <td><code><?= htmlspecialchars($c['slug']) ?></code></td>
                            <td><?= (int)($c['products_count'] ?? 0) ?> SKUs</td>
                            <td>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    <input type="hidden" name="action" value="delete" />
                                    <input type="hidden" name="id" value="<?= $c['id'] ?>" />
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
