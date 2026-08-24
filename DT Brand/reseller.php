<?php
/**
 * DT Brand/reseller.php — Zero-Investment Reseller Portal & Catalog Share Desk
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\ProductCatalog;

$products = ProductCatalog::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Start your zero-investment saree reselling business with DT Brand's — Share on WhatsApp, add margins, direct customer dispatch." />
    <title>Reseller Partner Portal &bull; DT Brand's &bull; Jai Hanuman Tex</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/DT Brand/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/shop.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/modals.css?v=<?= time() ?>">

    <style>
        .dt-reseller-hero {
            background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
            border-bottom: 2px solid #D4AF37;
            padding: 40px 20px;
            color: #FAF5E8;
            text-align: center;
        }
        .dt-reseller-title { font-size: 2rem; font-weight: 800; color: #FFFFFF; margin-bottom: 6px; }
        .dt-reseller-sub { font-size: 0.95rem; color: #E2E8F0; max-width: 640px; margin: 0 auto 20px; }
        
        .dt-reseller-steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
            max-width: 1000px;
            margin: 20px auto 0;
        }
        .dt-step-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 10px;
            padding: 16px;
            text-align: center;
        }
        .dt-step-icon { font-size: 1.8rem; margin-bottom: 6px; }
        .dt-step-title { font-size: 0.88rem; font-weight: 800; color: #FFE699; margin-bottom: 4px; }
        .dt-step-desc { font-size: 0.75rem; color: #CBD5E1; }
    </style>
</head>
<body>

    <!-- Master Header with Amazon-Style Search & Attached Gold Subnav -->
    <?php include_once __DIR__ . '/includes/header.php'; ?>

    <header class="dt-reseller-hero">
        <span class="dt-btn-pale" style="margin-bottom:12px; display:inline-block; font-size:0.75rem;">💰 ZERO INVESTMENT &bull; WORK FROM HOME</span>
        <h1 class="dt-reseller-title">Start Your WhatsApp Reselling Business</h1>
        <p class="dt-reseller-sub">Earn ₹25,000 to ₹75,000/month by sharing authentic handcrafted sarees with your customer network. We handle manufacturing, packaging & doorstep delivery.</p>

        <div class="dt-reseller-steps-grid">
            <div class="dt-step-card">
                <div class="dt-step-icon">📲</div>
                <div class="dt-step-title">1. Share Catalog</div>
                <div class="dt-step-desc">1-Click share high-res product photos to WhatsApp status & groups.</div>
            </div>
            <div class="dt-step-card">
                <div class="dt-step-icon">💵</div>
                <div class="dt-step-title">2. Add Your Margin</div>
                <div class="dt-step-desc">Set your own selling price. Keep 100% of your profit margin.</div>
            </div>
            <div class="dt-step-card">
                <div class="dt-step-icon">📦</div>
                <div class="dt-step-title">3. We Deliver Direct</div>
                <div class="dt-step-desc">We dispatch from Surat mill in unbranded luxury packaging.</div>
            </div>
        </div>
    </header>

    <main style="max-width:1440px; margin:30px auto; padding:0 20px;">

        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div>
                <h2 style="font-size:1.3rem; font-weight:800; color:#111827;">Ready-to-Share Catalog Products</h2>
                <p style="font-size:0.8rem; color:#6B7280;">Click 'Smart Share' to calculate profit margin and generate WhatsApp messages.</p>
            </div>
            <button type="button" class="dt-btn-gold" onclick="openAuthModal('register')">
                <span>Join Reseller VIP Program &rarr;</span>
            </button>
        </div>

        <!-- Products Grid with Reseller Margin Calculator Action -->
        <div class="dt-products-grid">
            <?php foreach ($products as $p): 
                $rPrice = $p['reseller_price'] ?? round($p['retail_price'] * 0.7);
                $rProfit = $p['reseller_profit'] ?? ($p['retail_price'] - $rPrice);
            ?>
            <div class="dt-product-card">
                <div class="dt-card-img-wrap">
                    <span class="dt-card-badge" style="background:#15803D; color:#FFF;">Reseller Price: ₹<?= number_format($rPrice) ?></span>
                    <button type="button" class="dt-card-share-btn" onclick="openSmartShare(<?= $p['id'] ?>)" aria-label="Share on WhatsApp">
                        <svg viewBox="0 0 24 24"><path fill="#15803D" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                    </button>
                    <a href="/DT Brand/product.php?id=<?= $p['id'] ?>">
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="dt-card-img" />
                    </a>
                </div>
                <div class="dt-card-body">
                    <a href="/DT Brand/product.php?id=<?= $p['id'] ?>" class="dt-card-title"><?= htmlspecialchars($p['name']) ?></a>
                    
                    <div style="background:#DCFCE7; border:1px solid #86EFAC; border-radius:6px; padding:6px 8px; margin:8px 0;">
                        <div style="display:flex; justify-content:space-between; font-size:0.75rem;">
                            <span>Suggested Selling:</span>
                            <strong style="color:#15803D;">₹<?= number_format($p['retail_price']) ?></strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.7rem; color:#166534; font-weight:700;">
                            <span>Your Net Profit:</span>
                            <span>+ ₹<?= number_format($rProfit) ?>/pc</span>
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr; gap:6px; margin-top:8px;">
                        <button type="button" class="dt-btn-emerald" style="padding:6px; font-size:0.75rem;" onclick="openSmartShare(<?= $p['id'] ?>)">
                            <span>💬 Smart WhatsApp Share</span>
                        </button>
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
    <script src="/DT Brand/assets/js/core.js?v=<?= time() ?>"></script>
    <script src="/DT Brand/assets/js/header.js?v=<?= time() ?>"></script>
    <script src="/DT Brand/assets/js/modals.js?v=<?= time() ?>"></script>

</body>
</html>
