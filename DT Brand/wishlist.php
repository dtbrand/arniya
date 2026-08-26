<?php
/**
 * wishlist.php — Customer Saved Favorites
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "My Wishlist & Saved Weaves";
require_once __DIR__ . '/src/ProductCatalog.php';
require_once __DIR__ . '/src/Database.php';

use DTBrand\ProductCatalog;

$catalogProducts = ProductCatalog::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?> ‹ DT Brand's Pure Silk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <style>
        .dt-wsh-container { max-width: 1200px; margin: 30px auto; padding: 0 20px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .dt-wsh-hero { background: linear-gradient(135deg, #181512 0%, #2A241E 100%); border: 2px solid #D4AF37; border-radius: 12px; padding: 24px; color: #FAF5E8; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .dt-wsh-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; }
        .dt-wsh-card { background: #FFFFFF; border: 1px solid #EAE5D9; border-radius: 10px; overflow: hidden; transition: transform 0.2s; box-shadow: 0 2px 10px rgba(0,0,0,0.04); }
        .dt-wsh-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(212,175,55,0.18); border-color: #D4AF37; }
    </style>
</head>
<body style="background:#FAF8F5; margin:0; padding:0; color:#181512;">

<?php include_once __DIR__ . '/includes/singelprodutbottomfotoer.php'; ?>

<div class="dt-wsh-container">
    <div class="dt-wsh-hero">
        <h1 style="font-family:'Cinzel',serif; font-size:1.8rem; margin:0 0 6px 0; color:#D4AF37;">Saved Masterpieces &amp; Wishlist</h1>
        <p style="margin:0; font-size:0.88rem; color:#E5E1D7;">Bookmark pure zari sarees, bridal lehengas, and wholesale catalogs for rapid ordering.</p>
    </div>

    <div class="dt-wsh-grid">
        <?php foreach (array_slice($catalogProducts, 0, 4) as $p): ?>
            <div class="dt-wsh-card">
                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" onerror="this.src='/assets/images/product1.png';" style="width:100%; height:280px; object-fit:cover;">
                <div style="padding:14px;">
                    <div style="font-size:0.75rem; font-weight:700; color:#8A681F; text-transform:uppercase;"><?= htmlspecialchars($p['category']) ?></div>
                    <h3 style="font-size:1rem; font-weight:800; color:#181512; margin:4px 0 8px 0;"><?= htmlspecialchars($p['title']) ?></h3>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <strong style="font-size:1.15rem; color:#8A681F;">₹<?= number_format((float)$p['price']) ?></strong>
                        <span style="font-size:0.78rem; color:#15803D; font-weight:700;">🟢 In Stock</span>
                    </div>
                    <a href="/product.php?id=<?= $p['id'] ?>" style="display:block; text-align:center; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; padding:8px 0; border-radius:6px; font-weight:800; font-size:13px; text-decoration:none; border:1px solid #8A681F;">View Product</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include_once __DIR__ . '/shared/cart.php'; ?>
<?php include_once __DIR__ . '/shared/wishlist.php'; ?>
<?php include_once __DIR__ . '/shared/checkout.php'; ?>

</body>
</html>
