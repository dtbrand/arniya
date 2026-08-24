<?php
/**
 * DT Brand/wholesale.php — Master Wholesale Hub & B2B Bale Lot Desk
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\ProductCatalog;

$products = ProductCatalog::getAll();
$categoriesDetails = ProductCatalog::getCategoriesWithDetails();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Surat direct handloom silk saree wholesale hub — Bale discounts, catalog set lots, GST invoicing & mill dispatch." />
    <title>Wholesale B2B Hub &bull; DT Brand's &bull; Jai Hanuman Tex</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/modals.css?v=<?= time() ?>">

    <style>
        .dt-ws-hero {
            background: linear-gradient(135deg, #181512 0%, #3D342A 100%);
            border-bottom: 2px solid #D4AF37;
            padding: 40px 20px;
            color: #FAF5E8;
            text-align: center;
        }
        .dt-ws-badge {
            display: inline-block;
            background: rgba(212, 175, 55, 0.2);
            border: 1px solid #D4AF37;
            color: #FFE699;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 12px;
        }
        .dt-ws-title {
            font-size: 2rem;
            font-weight: 800;
            color: #FFFFFF;
            margin-bottom: 8px;
        }
        .dt-ws-sub {
            font-size: 0.95rem;
            color: #E2E8F0;
            max-width: 680px;
            margin: 0 auto 24px;
        }
        .dt-ws-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
            max-width: 1100px;
            margin: 0 auto;
        }
        .dt-ws-kpi-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(212, 175, 55, 0.4);
            border-radius: 10px;
            padding: 16px;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        .dt-ws-kpi-val { font-size: 1.5rem; font-weight: 800; color: #FFE699; }
        .dt-ws-kpi-lbl { font-size: 0.75rem; color: #CBD5E1; }
    </style>
</head>
<body>

    <!-- Master Header with Amazon-Style Search & Attached Gold Subnav -->
    <?php include_once __DIR__ . '/includes/header.php'; ?>

    <!-- Wholesale Hero Header -->
    <header class="dt-ws-hero">
        <span class="dt-ws-badge">🏭 DIRECT SURAT MILL B2B PORTAL</span>
        <h1 class="dt-ws-title">Surat Handloom Wholesale & Bale Lots</h1>
        <p class="dt-ws-sub">Direct factory rates with tiered master bale discounts, GST billing, and door delivery across 28 states of India.</p>
        
        <div class="dt-ws-kpi-grid">
            <div class="dt-ws-kpi-card">
                <div class="dt-ws-kpi-val">Up to 70% Off</div>
                <div class="dt-ws-kpi-lbl">Direct Mill Price vs Retail MRP</div>
            </div>
            <div class="dt-ws-kpi-card">
                <div class="dt-ws-kpi-val">4 - 8 Pcs</div>
                <div class="dt-ws-kpi-lbl">Low Catalog MOQ (Half & Full Sets)</div>
            </div>
            <div class="dt-ws-kpi-card">
                <div class="dt-ws-kpi-val">100% Verified</div>
                <div class="dt-ws-kpi-lbl">Pure Tested Zari & Silk Mark Certified</div>
            </div>
            <div class="dt-ws-kpi-card">
                <div class="dt-ws-kpi-val">Express Cargo</div>
                <div class="dt-ws-kpi-lbl">VRL, TCI & Delhivery Freight Support</div>
            </div>
        </div>
    </header>

    <main style="max-width:1440px; margin:30px auto; padding:0 20px;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div>
                <h2 style="font-size:1.3rem; font-weight:800; color:#111827;">Wholesale Catalog Lots</h2>
                <p style="font-size:0.8rem; color:#6B7280;">Order sample single pieces or bulk full sets at factory rates.</p>
            </div>
            <a href="https://wa.me/919876543210?text=Hi%20DT%20Brands,%20I%20want%20to%20place%20a%20wholesale%20bulk%20bale%20order" target="_blank" rel="noopener" class="dt-btn-emerald">
                <span>💬 WhatsApp Wholesale Desk</span>
            </a>
        </div>

        <!-- Products Grid with Wholesale Pricing -->
        <div class="dt-products-grid">
            <?php foreach ($products as $p): ?>
            <div class="dt-product-card">
                <div class="dt-card-img-wrap">
                    <span class="dt-card-badge" style="background:#15803D; color:#FFF; border-color:#14532D;">Wholesale MOQ: <?= $p['moq'] ?? 8 ?> Pcs</span>
                    <a href="/product.php?id=<?= $p['id'] ?>">
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="dt-card-img" />
                    </a>
                </div>
                <div class="dt-card-body">
                    <a href="/product.php?id=<?= $p['id'] ?>" class="dt-card-title"><?= htmlspecialchars($p['name']) ?></a>
                    
                    <div style="background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; padding:6px 8px; margin:8px 0;">
                        <div style="display:flex; justify-content:space-between; font-size:0.75rem;">
                            <span>Wholesale Rate:</span>
                            <strong style="color:#8A681F; font-size:0.95rem;">₹<?= number_format($p['wholesale_price']) ?>/pc</strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.7rem; color:#6B7280;">
                            <span>Retail MRP: ₹<?= number_format($p['mrp']) ?></span>
                            <span style="color:#15803D; font-weight:700;">Margin: ₹<?= number_format($p['mrp'] - $p['wholesale_price']) ?></span>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px; margin-top:8px;">
                        <button type="button" class="dt-btn-gold" style="padding:6px; font-size:0.75rem;" onclick="addToCart(<?= htmlspecialchars(json_encode($p)) ?>, <?= $p['moq'] ?? 8 ?>, 'full_set')">
                            <span>Add Set (<?= $p['moq'] ?? 8 ?> Pcs)</span>
                        </button>
                        <a href="/product.php?id=<?= $p['id'] ?>" class="dt-btn-pale" style="padding:6px; font-size:0.75rem; text-align:center;">
                            <span>View Lots</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </main>

    <!-- Master Footer -->
    <?php include_once __DIR__ . '/includes/footer.php'; ?>

    <!-- Mobile Floating Bottom App Bar -->
    <?php include_once __DIR__ . '/includes/mobile_bottom_nav.php'; ?>

    <!-- Shared Modals (Cart, Wishlist, Checkout, Auth, QuickView, SmartShare, Reels) -->
    <?php include_once __DIR__ . '/shared/cart_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/wishlist_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/checkout_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/auth_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/quickview_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/smart_share_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/reels_modal.php'; ?>

    <!-- Master Scripts -->
    <script src="/assets/js/core.js?v=<?= time() ?>"></script>
    <script src="/assets/js/header.js?v=<?= time() ?>"></script>
    <script src="/assets/js/modals.js?v=<?= time() ?>"></script>

</body>
</html>
