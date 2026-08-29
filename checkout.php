<?php
/**
 * checkout.php — Standalone Master Checkout Page & Component
 * DT Brand's & Jai Hanuman Tex
 * Luxury Ethnic WhatsApp CRM Checkout Flow
 */
$page_title = "Secure Luxury Checkout";
require_once __DIR__ . '/src/ProductCatalog.php';
require_once __DIR__ . '/src/Database.php';

use DTBrand\ProductCatalog;

$dbProductsForCheckout = ProductCatalog::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $page_title ?> ‹ DT Brand's Luxury Couture</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/assets/css/header.css?v=<?= time() ?>">
    <script>
    window.allProducts = <?php echo json_encode($dbProductsForCheckout); ?>;
    </script>
</head>
<body style="background: #14100C; margin: 0; padding: 0; color: #24211C; min-height: 100vh; display: flex; align-items: center; justify-content: center;">

<?php
// Include the luxury master checkout markup and controller
include __DIR__ . '/Shared/checkout.php';
?>

<script>
// On standalone checkout page, automatically initialize and present the luxury checkout interface
document.addEventListener('DOMContentLoaded', function() {
    // If cart is empty in localStorage, populate with selected demo or initial item for seamless experience if needed
    var cart = [];
    try {
        cart = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
    } catch(e) {
        cart = [];
    }

    // If query string has direct product buy param (e.g. ?buy_id=1&qty=1)
    var urlParams = new URLSearchParams(window.location.search);
    var buyId = urlParams.get('buy_id') || urlParams.get('id');
    if (buyId && window.allProducts && window.allProducts.length) {
        var pMatch = window.allProducts.find(function(p) { return String(p.id) === String(buyId); });
        if (pMatch) {
            var exists = cart.find(function(c) { return String(c.id) === String(buyId); });
            if (!exists) {
                cart.push({
                    id: pMatch.id,
                    name: pMatch.name || pMatch.title,
                    price: pMatch.price || pMatch.retail_price || 1149,
                    qty: parseInt(urlParams.get('qty') || '1', 10),
                    image: pMatch.image || (pMatch.images && pMatch.images[0]) || '/assets/images/product1.png',
                    color: urlParams.get('color') || 'Navy Blue',
                    size: urlParams.get('size') || 'L'
                });
                localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
            }
        }
    }

    var backdrop = document.getElementById('checkoutBackdrop');
    if (backdrop) {
        backdrop.removeAttribute('inert');
        backdrop.setAttribute('aria-hidden', 'false');
        backdrop.classList.add('active');
        backdrop.style.position = 'relative';
        backdrop.style.minHeight = '100vh';
        backdrop.style.zIndex = '10';
        backdrop.style.opacity = '1';
        backdrop.style.visibility = 'visible';
        backdrop.style.pointerEvents = 'auto';

        var closeBtn = document.getElementById('closeCheckoutBtn');
        if (closeBtn) {
            closeBtn.onclick = function() {
                window.location.href = '/shop';
            };
        }
    }

    if (typeof window.renderCheckoutItems === 'function') {
        window.renderCheckoutItems();
    }
});
</script>

<?php include_once __DIR__ . '/Shared/cart.php'; ?>
<?php include_once __DIR__ . '/Shared/wishlist.php'; ?>

</body>
</html>
