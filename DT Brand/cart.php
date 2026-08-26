<?php
/**
 * cart.php — Dedicated Shopping Bag & Cart View
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "My Shopping Bag";
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
    <title><?= $page_title ?> ‹ DT Brand's Pure Handloom Luxury</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <style>
        .dt-cart-page { max-width: 1200px; margin: 30px auto; padding: 0 20px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .dt-cart-hero { background: linear-gradient(135deg, #181512 0%, #2A241E 100%); border: 2px solid #D4AF37; border-radius: 12px; padding: 24px; color: #FAF5E8; margin-bottom: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .dt-cart-hero h1 { font-family: 'Cinzel', serif; font-size: 1.8rem; margin: 0 0 8px 0; color: #D4AF37; }
        .dt-cart-grid { display: grid; grid-template-columns: 1fr 380px; gap: 24px; }
        @media(max-width: 900px) { .dt-cart-grid { grid-template-columns: 1fr; } }
        .dt-cart-card { background: #FFFFFF; border: 1px solid #EAE5D9; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); }
    </style>
</head>
<body style="background:#FAF8F5; margin:0; padding:0; color:#181512;">

<?php include_once __DIR__ . '/includes/singelprodutbottomfotoer.php'; ?>

<div class="dt-cart-page">
    <div class="dt-cart-hero">
        <h1>Royal Shopping Bag</h1>
        <p style="margin:0; font-size:0.9rem; color:#E5E1D7;">Pure Mulberry Silks, Royal Zari Brocades & Artisanal Masterpieces direct from Surat Mill Loom.</p>
    </div>

    <div class="dt-cart-grid">
        <div class="dt-cart-card">
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1.5px solid #EAE5D9; padding-bottom:14px; margin-bottom:18px;">
                <h2 style="font-size:1.15rem; font-weight:800; margin:0;">Cart Items</h2>
                <a href="/shop" style="color:#8A681F; font-weight:700; font-size:0.85rem; text-decoration:none;">+ Continue Shopping</a>
            </div>
            
            <div id="cartItemsList" style="display:flex; flex-direction:column; gap:16px;">
                <!-- Filled dynamically via localStorage / shared/cart.php -->
                <div style="text-align:center; padding:40px 20px;">
                    <div style="font-size:2.5rem; margin-bottom:12px;">🛍️</div>
                    <h3 style="font-size:1.1rem; font-weight:800; margin:0 0 6px 0;">Your Bag is Ready</h3>
                    <p style="font-size:0.85rem; color:#78716C; margin:0 0 20px 0;">Explore our 2026 pure handloom collection and wholesale sets.</p>
                    <a href="/shop" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; padding:10px 24px; border-radius:8px; font-weight:800; text-decoration:none; border:1px solid #8A681F;">Explore Handloom Edit</a>
                </div>
            </div>
        </div>

        <div class="dt-cart-card" style="height:fit-content;">
            <h2 style="font-size:1.15rem; font-weight:800; margin:0 0 16px 0; border-bottom:1.5px solid #EAE5D9; padding-bottom:14px;">Order Summary</h2>
            <div style="display:flex; flex-direction:column; gap:12px; font-size:0.9rem;">
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#64748B;">Subtotal</span>
                    <strong id="cartSubtotal">₹0</strong>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#64748B;">Shipping (Express Air)</span>
                    <span style="color:#15803D; font-weight:700;">FREE</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#64748B;">Textile GST (5%)</span>
                    <span style="color:#64748B;">Included in Price</span>
                </div>
                <div style="border-top:1.5px solid #EAE5D9; padding-top:12px; display:flex; justify-content:space-between; font-size:1.1rem; font-weight:900;">
                    <span>Grand Total</span>
                    <span style="color:#8A681F;" id="cartGrandTotal">₹0</span>
                </div>
            </div>

            <a href="/checkout" style="display:flex; justify-content:center; align-items:center; gap:8px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; height:44px; border-radius:8px; font-weight:900; text-decoration:none; margin-top:20px; border:1px solid #8A681F; box-shadow:0 4px 15px rgba(212,175,55,0.35);">
                <span>Proceed to Checkout</span>
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#111827" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </a>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/shared/cart.php'; ?>
<?php include_once __DIR__ . '/shared/wishlist.php'; ?>
<?php include_once __DIR__ . '/shared/checkout.php'; ?>

</body>
</html>
