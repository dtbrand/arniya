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

    <div class="dt-wsh-grid" id="wishlistGrid">
        <!-- Rendered from the shopper's real saved wishlist (localStorage: dtbrands_wishlist) -->
    </div>
    <div id="wishlistEmptyState" style="display:none; text-align:center; padding:50px 20px;">
        <div style="font-size:2.5rem; margin-bottom:12px;">💛</div>
        <h3 style="font-size:1.15rem; font-weight:800; margin:0 0 6px 0;">Your Wishlist is Empty</h3>
        <p style="font-size:0.88rem; color:#78716C; margin:0 0 20px 0;">Tap the heart on any product to save it here for later.</p>
        <a href="/shop" style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; padding:10px 24px; border-radius:8px; font-weight:800; text-decoration:none; border:1px solid #8A681F;">Discover the Collection</a>
    </div>
</div>

<?php include_once __DIR__ . '/shared/cart.php'; ?>
<?php include_once __DIR__ . '/shared/wishlist.php'; ?>
<?php include_once __DIR__ . '/shared/checkout.php'; ?>

<script>
/* Render the dedicated /wishlist page from the shopper's real saved items. */
(function() {
    function readWishlist() {
        try { return JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]') || []; } catch (e) { return []; }
    }
    function money(n) { return '₹' + (Number(String(n).replace(/[^0-9.]/g, '')) || 0).toLocaleString('en-IN'); }

    window.renderWishlistPage = function() {
        var grid = document.getElementById('wishlistGrid');
        var empty = document.getElementById('wishlistEmptyState');
        if (!grid) return;

        var items = readWishlist();
        if (!items.length) {
            grid.innerHTML = '';
            if (empty) empty.style.display = 'block';
            return;
        }
        if (empty) empty.style.display = 'none';

        grid.innerHTML = items.map(function(p) {
            // Fallbacks removed: 'Saved Weave' as a name, 'Handloom' as a category
            // and product1.png (a different product's photo) as the image.
            var name = p.name || p.title || 'Saved product';
            var img = p.image || '/assets/images/no-image.svg';
            var cat = p.category || '';
            var price = Number(p.price) || 0;
            // "In Stock" was printed for every saved item regardless of the real
            // stock level, which is not stored in the wishlist snapshot.
            var stockNote = (p.in_stock === true) ? '🟢 In Stock' : (p.in_stock === false ? 'Out of stock' : '');
            return '' +
              '<div class="dt-wsh-card" data-wid="' + p.id + '">' +
                '<div style="position:relative;">' +
                  '<img src="' + img + '" alt="' + name + '" style="width:100%; height:280px; object-fit:cover;">' +
                  '<button data-remove-wish="' + p.id + '" title="Remove from wishlist" aria-label="Remove from wishlist" style="position:absolute; top:10px; right:10px; width:34px; height:34px; border-radius:50%; border:none; background:rgba(255,255,255,0.92); color:#B91C1C; font-size:1.1rem; font-weight:800; cursor:pointer; box-shadow:0 2px 8px rgba(0,0,0,0.15);">×</button>' +
                '</div>' +
                '<div style="padding:14px;">' +
                  (cat ? '<div style="font-size:0.75rem; font-weight:700; color:#8A681F; text-transform:uppercase;">' + cat + '</div>' : '') +
                  '<h3 style="font-size:1rem; font-weight:800; color:#181512; margin:4px 0 8px 0;">' + name + '</h3>' +
                  '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">' +
                    '<strong style="font-size:1.15rem; color:#8A681F;">' + (price > 0 ? money(price) : 'Price on request') + '</strong>' +
                    (stockNote ? '<span style="font-size:0.78rem; color:#15803D; font-weight:700;">' + stockNote + '</span>' : '') +
                  '</div>' +
                  '<div style="display:flex; gap:8px;">' +
                    '<button data-add-wish="' + p.id + '" style="flex:1; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; padding:8px 0; border-radius:6px; font-weight:800; font-size:13px; border:1px solid #8A681F; cursor:pointer;">Add to Bag</button>' +
                    '<a href="/product.php?id=' + p.id + '" style="flex:1; text-align:center; background:#181512; color:#FAF5E8; padding:8px 0; border-radius:6px; font-weight:800; font-size:13px; text-decoration:none;">View</a>' +
                  '</div>' +
                '</div>' +
              '</div>';
        }).join('');
    };

    document.addEventListener('click', function(e) {
        var t = e.target;
        if (!t || !t.getAttribute) return;
        var removeId = t.getAttribute('data-remove-wish');
        var addId = t.getAttribute('data-add-wish');

        if (removeId !== null) {
            if (typeof window.toggleWishlistProduct === 'function') {
                window.toggleWishlistProduct(removeId); // item is present → toggles off (removes)
            } else {
                var kept = readWishlist().filter(function(x) { return String(x.id) !== String(removeId); });
                localStorage.setItem('dtbrands_wishlist', JSON.stringify(kept));
            }
            window.renderWishlistPage();
        } else if (addId !== null) {
            /* Pass the stored product object so we don't depend on window.allProducts here. */
            var item = readWishlist().find(function(x) { return String(x.id) === String(addId); });
            if (item && typeof window.addToCart === 'function') window.addToCart(item);
        }
    });

    document.addEventListener('DOMContentLoaded', window.renderWishlistPage);
    if (document.readyState !== 'loading') window.renderWishlistPage();
})();
</script>

</body>
</html>
