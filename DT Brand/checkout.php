<?php
/**
 * checkout.php — Dedicated Checkout & Payment Preference Engine
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Express Secure Checkout";
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
    <title><?= $page_title ?> ‹ DT Brand's Luxury Handloom</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/shop.css?v=<?= time() ?>">
    <style>
        .dt-chk-container { max-width: 1000px; margin: 30px auto; padding: 0 20px; font-family: 'Plus Jakarta Sans', sans-serif; }
        .dt-chk-card { background: #FFFFFF; border: 1.5px solid #D4AF37; border-radius: 12px; padding: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); }
        .dt-chk-head { border-bottom: 1.5px solid #EAE5D9; padding-bottom: 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .dt-chk-input { width: 100%; height: 40px; border: 1px solid #CBD5E1; border-radius: 6px; padding: 0 12px; box-sizing: border-box; font-size: 14px; margin-bottom: 12px; }
        .dt-chk-label { display: block; font-size: 12px; font-weight: 700; color: #181512; margin-bottom: 4px; }
    </style>
</head>
<body style="background:#FAF8F5; margin:0; padding:0; color:#181512;">

<div class="dt-chk-container">
    <div class="dt-chk-card">
        <div class="dt-chk-head">
            <div>
                <h1 style="font-family:'Cinzel',serif; font-size:1.6rem; margin:0; color:#8A681F;">Express Secure Checkout</h1>
                <p style="margin:4px 0 0 0; font-size:0.8rem; color:#78716C;">256-Bit SSL Encrypted • Direct Surat Mill Dispatch</p>
            </div>
            <a href="/shop" style="color:#8A681F; font-weight:700; font-size:0.85rem; text-decoration:none;">← Return to Shop</a>
        </div>

        <form id="expressCheckoutForm" onsubmit="handleDirectCheckout(event)" style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div style="grid-column: 1 / -1;">
                <h3 style="font-size:1.05rem; font-weight:800; margin:0 0 12px 0; color:#181512;">1. Customer &amp; Delivery Information</h3>
            </div>
            <div>
                <label class="dt-chk-label">Full Name *</label>
                <input type="text" class="dt-chk-input" id="chkName" placeholder="e.g. Priya Sharma" required>
            </div>
            <div>
                <label class="dt-chk-label">WhatsApp Mobile Number *</label>
                <input type="tel" class="dt-chk-input" id="chkPhone" placeholder="+91 98765 43210" required>
            </div>
            <div style="grid-column: 1 / -1;">
                <label class="dt-chk-label">Complete Shipping Address *</label>
                <input type="text" class="dt-chk-input" id="chkAddress" placeholder="Flat No., Building, Street, Landmark" required>
            </div>
            <div>
                <label class="dt-chk-label">City *</label>
                <input type="text" class="dt-chk-input" id="chkCity" placeholder="e.g. Mumbai" required>
            </div>
            <div>
                <label class="dt-chk-label">Pincode *</label>
                <input type="text" class="dt-chk-input" id="chkPin" placeholder="400001" maxlength="6" required>
            </div>

            <div style="grid-column: 1 / -1; margin-top:10px;">
                <h3 style="font-size:1.05rem; font-weight:800; margin:0 0 12px 0; color:#181512;">2. Payment Method</h3>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
                    <label style="border:2px solid #D4AF37; background:#FAF5E8; border-radius:8px; padding:12px; display:flex; align-items:center; gap:10px; cursor:pointer;">
                        <input type="radio" name="chkPayment" value="cod" checked>
                        <div>
                            <strong style="display:block; font-size:13px; color:#181512;">Cash on Delivery (COD)</strong>
                            <small style="color:#78716C;">Pay upon parcel delivery</small>
                        </div>
                    </label>
                    <label style="border:1px solid #CBD5E1; background:#FFFFFF; border-radius:8px; padding:12px; display:flex; align-items:center; gap:10px; cursor:pointer;">
                        <input type="radio" name="chkPayment" value="upi">
                        <div>
                            <strong style="display:block; font-size:13px; color:#181512;">UPI / Razorpay</strong>
                            <small style="color:#78716C;">GPay, PhonePe, Cards</small>
                        </div>
                    </label>
                </div>
            </div>

            <div style="grid-column: 1 / -1; margin-top:20px; border-top:1.5px solid #EAE5D9; padding-top:18px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:14px;">
                <div style="font-size:13px; color:#64748B;">
                    <span>🔒 Safe &amp; Verified Delivery with 3-Day Easy Replacement Guarantee</span>
                </div>
                <button type="submit" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; height:46px; padding:0 30px; border-radius:8px; font-size:15px; font-weight:900; border:1px solid #8A681F; cursor:pointer; box-shadow:0 4px 15px rgba(212,175,55,0.35);">
                    Confirm &amp; Place Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function handleDirectCheckout(e) {
    e.preventDefault();

    // Build the order from the shopper's REAL cart (localStorage), not a hardcoded item.
    var cart = [];
    try { cart = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]'); } catch (err) { cart = []; }

    if (!Array.isArray(cart) || cart.length === 0) {
        alert('Your shopping bag is empty. Please add a product before checking out.');
        window.location.href = '/shop';
        return;
    }

    var items = cart.map(function(it) {
        return {
            id: it.id,
            name: it.name,
            price: Number(it.price) || 0,
            quantity: Number(it.qty || it.quantity) || 1,
            image: it.image || ''
        };
    });

    var name = document.getElementById('chkName').value.trim();
    var phone = document.getElementById('chkPhone').value.trim();
    var address = document.getElementById('chkAddress').value.trim();
    var city = document.getElementById('chkCity').value.trim();
    var pin = document.getElementById('chkPin').value.trim();

    var payload = {
        customer_name: name,
        customer_phone: phone,
        shipping_address: address + ', ' + city + ' - ' + pin,
        items: items,
        channel: 'retail',
        payment_method: (document.querySelector('input[name="chkPayment"]:checked') || {}).value || 'cod'
    };

    var btn = e.target.querySelector('button[type="submit"]');
    if (btn) { btn.disabled = true; btn.textContent = 'Placing your order…'; }

    fetch('/api/orders.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data && data.success) {
            var num = (data.order && data.order.order_number) ? data.order.order_number : '';
            localStorage.removeItem('dtbrands_cart');
            alert('🎉 Order placed successfully!' + (num ? ' Your order number is ' + num + '.' : '') + ' Our WhatsApp concierge will confirm dispatch shortly.');
            window.location.href = '/shop';
        } else {
            if (btn) { btn.disabled = false; btn.textContent = 'Confirm & Place Order'; }
            alert('We could not place your order: ' + ((data && data.message) ? data.message : 'Please try again.'));
        }
    })
    .catch(function() {
        if (btn) { btn.disabled = false; btn.textContent = 'Confirm & Place Order'; }
        alert('Network error — your order was not placed. Please check your connection and try again.');
    });
}
</script>

<?php include_once __DIR__ . '/shared/cart.php'; ?>
<?php include_once __DIR__ . '/shared/wishlist.php'; ?>

</body>
</html>
