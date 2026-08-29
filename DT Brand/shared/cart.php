<?php
/**
 * cart.php — PARTIAL INCLUDE
 * Self-Contained Fully Styled & Dynamic Cart Drawer Component
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/Database.php';

use DTBrand\ProductCatalog;

$dbProductsForCart = ProductCatalog::getAll();
?>
<script>
window.allProducts = <?php echo json_encode($dbProductsForCart); ?>;
</script>
<style>
/* ── Cart Drawer Base Styles ── */
.cart-drawer-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(24, 20, 16, 0.78); backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: flex-end;
    z-index: 999999 !important; opacity: 0; visibility: hidden;
    pointer-events: none;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.cart-drawer-backdrop.active { opacity: 1; visibility: visible; pointer-events: auto; }

.cart-drawer-content {
    background: linear-gradient(180deg, #FFFFFF 0%, #FAF6EE 100%);
    width: 100%; max-width: 440px; height: 100%;
    box-shadow: -10px 0 30px rgba(0,0,0,0.25);
    display: flex; flex-direction: column;
    transform: translateX(100%); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    border-left: 3px solid var(--dark-gold, #8A681F);
}
.cart-drawer-backdrop.active .cart-drawer-content {
    transform: translateX(0);
}

.cd-header { display: flex; align-items: center; justify-content: space-between; padding: 10px 18px; height: 50px; border-bottom: 1.5px solid var(--dark-gold, #8A681F); background: #FFFFFF; flex-shrink: 0; }
.cd-title { font-family: var(--font-serif, 'Cinzel', serif); font-size: 1.02rem; color: var(--dark-gold, #8A681F); font-weight: 700; margin: 0; line-height: 1.1; }
.cd-subtitle { font-size: 0.58rem; color: var(--mid-text, #5A5348); font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; display: block; margin-top: 1px; }
.cd-close-btn { width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--soft-platinum, #E5E3DE); background: #FAF8F4; font-size: 1.2rem; color: var(--dark-gold, #8A681F); cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; line-height: 1; flex-shrink: 0; }
.cd-close-btn:hover { color: #FFFFFF; background: var(--dark-gold, #8A681F); border-color: var(--dark-gold, #8A681F); transform: rotate(90deg); }

.cd-body { padding: 18px 22px; flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 14px; }

/* ── Cart Item Card ── */
.cd-item { display: flex; gap: 14px; background: #FFFFFF; padding: 12px; border-radius: 12px; border: 1.5px solid rgba(138,104,31,0.2); align-items: center; transition: all 0.25s ease; }
.cd-item:hover { box-shadow: 0 4px 16px rgba(138,104,31,0.12); border-color: var(--dark-gold, #8A681F); }
.cd-item-img { width: 78px; height: 104px; aspect-ratio: 3 / 4; object-fit: cover; object-position: top center; border-radius: 8px; border: 1.5px solid rgba(138,104,31,0.25); flex-shrink: 0; background: #F8F5EE; }
.cd-item-info { display: flex; flex-direction: column; gap: 4px; flex: 1; }
.cd-item-title { font-family: var(--font-serif, 'Cinzel', serif); font-size: 0.92rem; font-weight: 700; color: var(--dark-text, #24211C); margin: 0; }
.cd-item-meta { font-size: 0.7rem; color: var(--mid-text, #5A5348); font-weight: 500; }
.cd-price-row { display: flex; align-items: baseline; gap: 8px; }
.cd-item-price { font-size: 0.95rem; font-weight: 800; color: var(--dark-gold, #8A681F); }
.cd-item-old { font-size: 0.75rem; color: var(--light-text, #9A9490); text-decoration: line-through; }

.cd-qty-wrap { display: flex; align-items: center; gap: 8px; margin-top: 4px; }
.cd-qty-btn { width: 26px; height: 26px; border-radius: 6px; border: 1px solid var(--dark-gold, #8A681F); background: #FAF3E0; color: var(--dark-gold, #8A681F); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
.cd-qty-btn:hover { background: var(--dark-gold, #8A681F); color: #FFFFFF; }
.cd-qty-num { font-size: 0.8rem; font-weight: 700; color: var(--dark-text, #24211C); min-width: 16px; text-align: center; }
.cd-remove-btn { border: none; background: none; color: #E53935; font-size: 0.72rem; font-weight: 600; cursor: pointer; margin-left: auto; transition: opacity 0.2s; }
.cd-remove-btn:hover { text-decoration: underline; opacity: 0.8; }

.cd-footer { padding: 18px 22px; border-top: 2px solid var(--dark-gold, #8A681F); background: #FFFFFF; display: flex; flex-direction: column; gap: 10px; }
.cd-summary-row { display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; font-weight: 700; color: var(--dark-text, #24211C); }
.cd-total-val { font-size: 1.2rem; color: var(--dark-gold, #8A681F); }
.cd-shipping { font-size: 0.75rem; color: var(--mid-text, #5A5348); font-weight: 500; }
.cd-free-txt { color: #2E7D32; font-weight: 700; }
.cd-checkout-btn { width: 100%; padding: 14px; border-radius: 8px; background: var(--dark-gold, #8A681F); color: #FFF; border: none; font-family: var(--font-sans, 'Inter', sans-serif); font-size: 0.85rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(138,104,31,0.25); }
.cd-checkout-btn:hover { background: var(--deep-gold, #6F5218); box-shadow: 0 6px 20px rgba(138,104,31,0.35); }

/* ── Animated Empty Cart Styles ── */
.cd-empty-container {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 24px 12px 10px; text-align: center; width: 100%;
}
.cd-empty-icon-wrap {
    position: relative; width: 96px; height: 96px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 12px;
}
.cd-empty-glow-ring {
    position: absolute; inset: -10px; border-radius: 50%;
    background: radial-gradient(circle, rgba(138,104,31,0.2) 0%, rgba(138,104,31,0) 70%);
    animation: pulseRing 3s ease-in-out infinite;
}
@keyframes pulseRing {
    0%, 100% { transform: scale(0.9); opacity: 0.4; }
    50% { transform: scale(1.2); opacity: 1; }
}

.cd-empty-svg {
    width: 68px; height: 68px;
    stroke: var(--dark-gold, #8A681F); fill: none; stroke-width: 1.6;
    animation: floatBag 3.6s ease-in-out infinite;
    filter: drop-shadow(0 8px 16px rgba(138,104,31,0.25));
    position: relative; z-index: 2;
}
@keyframes floatBag {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-12px) rotate(4deg); }
}

.cd-empty-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 1.2rem; font-weight: 700; color: var(--dark-gold, #8A681F);
    letter-spacing: 0.1em; text-transform: uppercase; margin: 0 0 4px;
}
.cd-empty-desc {
    font-size: 0.78rem; color: var(--mid-text, #5A5348);
    margin: 0 0 16px; line-height: 1.5; max-width: 270px;
}

.cd-explore-btn {
    padding: 11px 24px; border-radius: 26px;
    background: linear-gradient(135deg, var(--dark-gold, #8A681F) 0%, var(--deep-gold, #6F5218) 100%);
    color: #FFFFFF; font-size: 0.72rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase; border: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(138,104,31,0.3); transition: all 0.25s ease;
    display: inline-flex; align-items: center; gap: 8px;
}
.cd-explore-btn:hover {
    transform: translateY(-2px); box-shadow: 0 6px 20px rgba(138,104,31,0.42);
}

/* ── Interactive Auto-Slide Product Recommendations with Full-Size Portrait Photo ── */
.cd-recommend-section {
    margin-top: 18px; padding-top: 16px;
    border-top: 1px dashed rgba(138,104,31,0.3);
    width: 100%; text-align: left;
}
.cd-rec-head {
    font-family: var(--font-serif, 'Cinzel', serif); font-size: 0.78rem; font-weight: 700;
    color: var(--dark-gold, #8A681F); letter-spacing: 0.1em; text-transform: uppercase;
    margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;
}
.cd-rec-track {
    display: flex; gap: 14px; overflow-x: auto;
    padding: 4px 2px 10px; scrollbar-width: none; -webkit-overflow-scrolling: touch;
    cursor: grab; user-select: none; scroll-behavior: auto;
}
.cd-rec-track.active-drag {
    cursor: grabbing; cursor: -webkit-grabbing;
}
.cd-rec-track::-webkit-scrollbar { display: none; }

.cd-rec-card {
    flex: 0 0 152px;
    background: #FFFFFF; border: 1.5px solid rgba(138,104,31,0.22);
    border-radius: 12px; padding: 9px; display: flex; flex-direction: column; gap: 8px;
    transition: all 0.25s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: relative;
}
.cd-rec-card:hover { border-color: var(--dark-gold, #8A681F); box-shadow: 0 6px 18px rgba(138,104,31,0.2); transform: translateY(-2px); }

.cd-rec-img-wrap {
    width: 100%; aspect-ratio: 3 / 4; border-radius: 8px; overflow: hidden;
    background: #F8F5EE; position: relative;
}
.cd-rec-img {
    width: 100%; height: 100%; object-fit: cover; object-position: top center;
    display: block; pointer-events: none; transition: transform 0.35s ease;
}
.cd-rec-card:hover .cd-rec-img { transform: scale(1.05); }

.cd-rec-title { font-size: 0.74rem; font-weight: 700; color: var(--dark-text, #24211C); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; }
.cd-rec-price-row { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
.cd-rec-price { font-size: 0.82rem; font-weight: 800; color: var(--dark-gold, #8A681F); }
.cd-rec-add-btn {
    padding: 5px 10px; border-radius: 6px; background: var(--dark-gold, #8A681F);
    color: #FFF; border: none; font-size: 0.65rem; font-weight: 700; cursor: pointer;
    transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 3px;
}
.cd-rec-add-btn:hover { background: var(--deep-gold, #6F5218); transform: scale(1.05); }
</style>

<!-- ════════════ CART DRAWER MODAL ════════════ -->
<div class="cart-drawer-backdrop" id="cartDrawerModal" aria-hidden="true" role="dialog" aria-label="Shopping Cart Drawer" inert>
    <div class="cart-drawer-content">
        <div class="cd-header">
    <div style="display:flex; align-items:center; gap:10px;">
        <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/Shared/Asset/images/logo.png';" alt="DT Brand's" style="height:28px; width:auto; max-width:120px; object-fit:contain;">
        <div>
            <h3 class="cd-title" style="margin:0; font-size:0.95rem;">Shopping Bag</h3>
            <span class="cd-subtitle" style="font-size:0.56rem;">Ethnic Luxury</span>
        </div>
    </div>
    <button class="cd-close-btn" id="closeCartDrawerBtn" onclick="if(typeof window.closeCartDrawer==='function') window.closeCartDrawer();" aria-label="Close Cart">✕</button>
</div>

        <div class="cd-body" id="cartDrawerItemsWrap">
            <!-- Dynamic Items or Animated Empty State rendered via JS -->
        </div>

        <div class="cd-footer">
            <div class="cd-summary-row">
                <span>Subtotal</span>
                <span class="cd-total-val" id="cartTotalVal">₹0</span>
            </div>
            <div class="cd-summary-row cd-shipping">
                <span>⚡ Fast Express Delivery & Fast Exchange</span>
                <span class="cd-free-txt">FAST DISPATCH</span>
            </div>
            <button class="cd-checkout-btn" id="cartCheckoutBtn">
                PROCEED TO CHECKOUT &rarr;
            </button>
        </div>
    </div>
</div>

<script>
/* ── Cart Drawer Controller with Smooth Auto-Slide & Touch/Mouse Drag ── */
(function() {
    var CD_NO_IMAGE = '/assets/images/no-image.svg';

    // Cart lines are built as HTML strings, so every stored value (product name,
    // colour, size) is escaped before it is interpolated.
    function cdEsc(v) {
        return String(v === null || typeof v === 'undefined' ? '' : v)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function loadCart() {
        try {
            var raw = localStorage.getItem('dtbrands_cart');
            if (raw !== null) return JSON.parse(raw);
        } catch(e) {}
        return [];
    }

    function saveCart(cart) {
        try {
            localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
        } catch(e) {}
    }

    window.cartState = loadCart();

    /* Auto-Slider Engine for Continuous Slow Motion + Desktop Mouse Drag + Mobile Touch Swipe */
    window.attachAutoSlider = function(track) {
        if (!track || track._autoSliderAttached) return;
        track._autoSliderAttached = true;

        var isPaused = false;
        var isDown = false;
        var startX = 0;
        var startScrollLeft = 0;
        var scrollSpeed = 0.6; // gentle, slow auto slide

        function autoStep() {
            if (!isPaused && !isDown && track.isConnected) {
                track.scrollLeft += scrollSpeed;
                if (track.scrollLeft >= track.scrollWidth - track.clientWidth - 1) {
                    track.scrollLeft = 0;
                }
            }
            requestAnimationFrame(autoStep);
        }
        requestAnimationFrame(autoStep);

        /* Desktop Mouse Interaction */
        track.addEventListener('mouseenter', function() { isPaused = true; });
        track.addEventListener('mouseleave', function() {
            if (!isDown) isPaused = false;
            isDown = false;
            track.classList.remove('active-drag');
        });

        track.addEventListener('mousedown', function(e) {
            isDown = true;
            isPaused = true;
            track.classList.add('active-drag');
            startX = e.pageX - track.offsetLeft;
            startScrollLeft = track.scrollLeft;
        });

        window.addEventListener('mouseup', function() {
            if (isDown) {
                isDown = false;
                track.classList.remove('active-drag');
                setTimeout(function() { isPaused = false; }, 1800);
            }
        });

        track.addEventListener('mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            var x = e.pageX - track.offsetLeft;
            var walk = (x - startX) * 1.5;
            track.scrollLeft = startScrollLeft - walk;
        });

        /* Mobile Touch Interaction */
        track.addEventListener('touchstart', function() {
            isPaused = true;
        }, { passive: true });

        track.addEventListener('touchend', function() {
            setTimeout(function() { isPaused = false; }, 2000);
        }, { passive: true });
    };

    window.renderCart = function() {
        var wrap = document.getElementById('cartDrawerItemsWrap');
        var totalValEl = document.getElementById('cartTotalVal');

        if (!wrap) return;

        var items = window.cartState || [];
        var footer = document.querySelector('.cd-footer');

        if (items.length === 0) {
            if (footer) footer.style.display = 'none';

            /* Render Animated SVG Empty Cart + Auto Product Recommendation Slider.
               The picks are real catalogue rows only. This used to fall back to
               five invented sarees ("Nilambari Silk Saree ₹4,899" and friends)
               whose ids did not have to match anything in the database, so
               "+ ADD" on them silently did nothing. */
            var products = (window.allProducts || []).filter(function(p) {
                return p && p.id && Number(p.price) > 0;
            }).slice(0, 10);

            // Render loop duplicates for seamless long scrolling
            var fullList = products.length ? products.concat(products) : [];

            var sliderCardsHtml = fullList.map(function(p) {
                var hasImg = p.has_photo !== false && p.image && p.image !== CD_NO_IMAGE;
                return '<div class="cd-rec-card">' +
                    '<div class="cd-rec-img-wrap">' +
                        '<img src="' + cdEsc(hasImg ? p.image : CD_NO_IMAGE) + '" alt="' + cdEsc(p.name) + '" class="cd-rec-img"' + (hasImg ? '' : ' style="opacity:.45;"') + ' />' +
                    '</div>' +
                    '<h5 class="cd-rec-title">' + cdEsc(p.name) + '</h5>' +
                    '<div class="cd-price-row">' +
                        '<span class="cd-rec-price">₹' + Number(p.price).toLocaleString('en-IN') + '</span>' +
                        '<button class="cd-rec-add-btn" onclick="window.addRecToCart(' + (parseInt(p.id, 10) || 0) + ')">+ ADD</button>' +
                    '</div>' +
                '</div>';
            }).join('');

            wrap.innerHTML =
                '<div class="cd-empty-container">' +
                    '<div class="cd-empty-icon-wrap">' +
                        '<div class="cd-empty-glow-ring"></div>' +
                        '<svg class="cd-empty-svg" viewBox="0 0 24 24">' +
                            '<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>' +
                            '<line x1="3" y1="6" x2="21" y2="6"></line>' +
                            '<path d="M16 10a4 4 0 0 1-8 0"></path>' +
                        '</svg>' +
                    '</div>' +
                    '<h4 class="cd-empty-title">YOUR BAG IS EMPTY</h4>' +
                    '<p class="cd-empty-desc">Discover our handcrafted ethnic luxury collection & elevate your wardrobe.</p>' +
                    '<button class="cd-explore-btn" onclick="window.closeCartDrawer(); window.location.href=\'/shop\';">' +
                        'EXPLORE COLLECTION &rarr;' +
                    '</button>' +

                    // Hidden outright when the catalogue has nothing to suggest,
                    // rather than showing an empty "TRENDING LUXURY PICKS" strip.
                    (sliderCardsHtml ?
                    '<div class="cd-recommend-section">' +
                        '<div class="cd-rec-head">' +
                            '<span>✨ TRENDING LUXURY PICKS</span>' +
                            '<span style="font-size:0.65rem; opacity:0.8;">SWIPE &rsaquo;</span>' +
                        '</div>' +
                        '<div class="cd-rec-track" id="cdRecTrack">' +
                            sliderCardsHtml +
                        '</div>' +
                    '</div>' : '') +
                '</div>';

            /* Initialize Auto Slider with Mouse and Touch Support */
            setTimeout(function() {
                var track = document.getElementById('cdRecTrack');
                if (track) window.attachAutoSlider(track);
            }, 60);

        } else {
            if (footer) footer.style.display = 'flex';
            var html = '';
            var totalPrice = 0;
            items.forEach(function(item, idx) {
                totalPrice += item.price * item.qty;
                // A missing photo shows the placeholder, not another product's
                // picture (this used to fall back to product1.png).
                var hasImg = item.image && item.image !== CD_NO_IMAGE;
                var imgUrl = hasImg ? item.image : CD_NO_IMAGE;
                var metaBits = [];
                if (item.color) metaBits.push('Colour: ' + cdEsc(item.color));
                if (item.size) metaBits.push('Size: ' + cdEsc(item.size));

                html += '<div class="cd-item" data-index="' + idx + '">' +
                    '<img src="' + cdEsc(imgUrl) + '" alt="' + cdEsc(item.name) + '" class="cd-item-img"' + (hasImg ? '' : ' style="opacity:.45;"') + ' />' +
                    '<div class="cd-item-info">' +
                        '<h4 class="cd-item-title">' + cdEsc(item.name) + '</h4>' +
                        (metaBits.length ? '<span class="cd-item-meta">' + metaBits.join(' &bull; ') + '</span>' : '') +
                        '<div class="cd-price-row">' +
                            '<span class="cd-item-price">₹' + Number(item.price * item.qty).toLocaleString('en-IN') + '</span>' +
                            (item.old_price ? '<span class="cd-item-old">₹' + Number(item.old_price * item.qty).toLocaleString('en-IN') + '</span>' : '') +
                        '</div>' +
                        '<div class="cd-qty-wrap">' +
                            '<button class="cd-qty-btn cd-minus-btn" onclick="window.updateCartQty(' + idx + ', -1)">-</button>' +
                            '<span class="cd-qty-num">' + item.qty + '</span>' +
                            '<button class="cd-qty-btn cd-plus-btn" onclick="window.updateCartQty(' + idx + ', 1)">+</button>' +
                            '<button class="cd-remove-btn" onclick="window.removeFromCart(' + idx + ')">&times; Remove</button>' +
                        '</div>' +
                    '</div>' +
                '</div>';
            });
            wrap.innerHTML = html;
        }

        if (totalValEl) totalValEl.textContent = '₹' + Number(totalPrice).toLocaleString('en-IN');

        /* Synchronize all header and sheet badges */
        if (typeof window.updateGlobalBadges === 'function') {
            window.updateGlobalBadges();
        }
    };

    window.addRecToCart = function(productId) {
        var products = window.allProducts || [];
        var p = products.find(function(x) { return x.id == productId; });
        if (p && typeof window.addToCart === 'function') {
            window.addToCart(p);
        }
    };

    /* Legacy alias used by some home-page sliders (e.g. Recently Viewed) */
    window.directAddToCart = function(productId) {
        if (typeof window.addToCart === 'function') window.addToCart(productId);
    };

    window.updateCartQty = function(idx, delta) {
        if (!window.cartState[idx]) return;
        window.cartState[idx].qty += delta;
        if (window.cartState[idx].qty <= 0) {
            window.cartState.splice(idx, 1);
        }
        saveCart(window.cartState);
        window.renderCart();
    };

    window.removeFromCart = function(idx) {
        if (!window.cartState[idx]) return;
        window.cartState.splice(idx, 1);
        saveCart(window.cartState);
        window.renderCart();
        if (typeof window.showToast === 'function') window.showToast('Item removed from bag');
    };

    window.addToCart = function(product, sizeOrOpts, color, qtyArg) {
        // Accept a product OBJECT or a product id (resolve via the live catalog).
        if (product === null || typeof product === 'undefined') return;
        if (typeof product !== 'object') {
            var pid = product;
            product = (window.allProducts || []).find(function(x) {
                return x.id == pid || String(x.id) === String(pid);
            });
            if (!product) {
                if (typeof window.showToast === 'function') window.showToast('Sorry, this product is currently unavailable.');
                return;
            }
        }

        // Callers reach this from several places, so the arguments are sniffed
        // rather than fixed. Quantity used to be ignored entirely: a shopper who
        // stepped the quick view up to 6 pieces got a bag with 1.
        //   addToCart(p, { qty: 6, size: 'M', color: 'Red' })
        //   addToCart(p, 'M', 'Red')       - size + colour
        //   addToCart(p, 6)                - quantity only
        //   addToCart(p, 6, 'single', ...) - legacy lot-type call
        var size, chosenQty = 1;
        if (sizeOrOpts && typeof sizeOrOpts === 'object') {
            size = sizeOrOpts.size;
            color = sizeOrOpts.color || color;
            chosenQty = parseInt(sizeOrOpts.qty, 10) || 1;
        } else if (typeof sizeOrOpts === 'number') {
            chosenQty = parseInt(sizeOrOpts, 10) || 1;
            // A legacy third argument was a lot type ('single'/'half_set'), not a
            // colour, so it must not be recorded as one.
            if (typeof color === 'string' && /^(single|half_set|full_set|master_bale)$/i.test(color)) color = undefined;
        } else {
            size = sizeOrOpts;
            if (typeof qtyArg !== 'undefined') chosenQty = parseInt(qtyArg, 10) || 1;
        }
        if (!(chosenQty > 0)) chosenQty = 1;
        if (chosenQty > 999) chosenQty = 999;

        // Only a real selection is stored. 'Free Size'/'Standard' used to be
        // invented here for products that have no variants recorded at all.
        var chosenSize = size || (Array.isArray(product.size) ? product.size[0] : product.size) || '';
        var chosenColor = color || (Array.isArray(product.colors) ? product.colors[0] : product.color) || '';
        chosenSize = String(chosenSize || '').trim();
        chosenColor = String(chosenColor || '').trim();

        var existing = window.cartState.find(function(item) {
            return item.id == product.id && (item.size || '') == chosenSize && (item.color || '') == chosenColor;
        });

        if (existing) {
            existing.qty += chosenQty;
        } else {
            window.cartState.push({
                id: product.id,
                name: product.name,
                price: product.price,
                old_price: product.old_price,
                image: product.image,
                size: chosenSize,
                color: chosenColor,
                qty: chosenQty
            });
        }
        saveCart(window.cartState);
        window.renderCart();
        if (typeof window.showToast === 'function') {
            var what = [chosenColor, chosenSize].filter(Boolean).join(' / ');
            window.showToast('Added ' + product.name + (what ? ' (' + what + ')' : '') + (chosenQty > 1 ? ' x' + chosenQty : '') + ' to bag');
        }
        window.openCartDrawer();
    };

    window.openCartDrawer = function() {
        var modal = document.getElementById('cartDrawerModal');
        if (modal) {
            modal.removeAttribute('inert');
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            modal.style.setProperty('display', 'flex', 'important');
            modal.style.setProperty('opacity', '1', 'important');
            modal.style.setProperty('visibility', 'visible', 'important');
            modal.style.setProperty('pointer-events', 'auto', 'important');
            document.body.style.overflow = 'hidden';
            if (typeof window.renderCart === 'function') {
                window.renderCart();
            }
        }
    };

    window.openCart = window.openCartDrawer;

    window.closeCartDrawer = function() {
        var modal = document.getElementById('cartDrawerModal');
        if (modal) {
            if (document.activeElement && modal.contains(document.activeElement)) {
                document.activeElement.blur();
            }
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            modal.setAttribute('inert', '');
            modal.style.removeProperty('display');
            modal.style.removeProperty('opacity');
            modal.style.removeProperty('visibility');
            modal.style.removeProperty('pointer-events');
            document.body.style.overflow = '';
        }
    };

    // Aliased AFTER the function exists. The alias used to be assigned on the
    // line above the definition, so window.closeCart was permanently undefined
    // and every caller of it threw.
    window.closeCart = window.closeCartDrawer;

    /* Global Badge Sync Helper */
    window.updateGlobalBadges = function() {
        var cartList = window.cartState || [];
        var wishList = window.wishlistState || [];

        var cartQty = cartList.reduce(function(sum, item) { return sum + (item.qty || 1); }, 0);
        var wishQty = wishList.length;

        /* 1. Header Cart Badge */
        var cartBadge = document.getElementById('cartBadge');
        if (cartBadge) {
            cartBadge.textContent = cartQty;
            cartBadge.style.display = cartQty > 0 ? 'flex' : 'none';
        }

        /* 2. Header Wishlist Badge */
        var wishBadge = document.getElementById('wishlistBadge');
        if (wishBadge) {
            wishBadge.textContent = wishQty;
            wishBadge.style.display = wishQty > 0 ? 'flex' : 'none';
        }

        /* 3. Mobile Options Cart Label */
        var moreCartLabel = document.getElementById('moreCartLabel');
        if (moreCartLabel) {
            moreCartLabel.textContent = 'My Cart (' + cartQty + ' Item' + (cartQty === 1 ? '' : 's') + ')';
        }

        /* 4. Mobile Options Wishlist Label */
        var moreWishlistLabel = document.getElementById('moreWishlistLabel');
        if (moreWishlistLabel) {
            moreWishlistLabel.textContent = 'My Wishlist (' + wishQty + ' Item' + (wishQty === 1 ? '' : 's') + ')';
        }

        /* 5. Subheader Labels */
        var cartBadgeSub = document.getElementById('cartBadgeSub');
        if (cartBadgeSub) {
            cartBadgeSub.textContent = cartQty + ' Luxury Item' + (cartQty === 1 ? '' : 's');
        }

        var wishlistBadgeSub = document.getElementById('wishlistBadgeSub');
        if (wishlistBadgeSub) {
            wishlistBadgeSub.textContent = wishQty + ' Saved Item' + (wishQty === 1 ? '' : 's');
        }

        /* 6. Product Cards Wishlist Sync */
        document.querySelectorAll('.card-wishlist-btn').forEach(function(btn) {
            var id = btn.dataset.id;
            var isWish = wishList.some(function(w) { return w.id == id; });
            btn.classList.toggle('active', isWish);
            btn.setAttribute('aria-pressed', isWish ? 'true' : 'false');
        });
    };

    /* Bind events on DOM Load */
    document.addEventListener('DOMContentLoaded', function() {
        window.renderCart();

        var closeBtn = document.getElementById('closeCartDrawerBtn');
        if (closeBtn) closeBtn.addEventListener('click', window.closeCartDrawer);

        var modal = document.getElementById('cartDrawerModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) window.closeCartDrawer();
            });
        }

        var checkoutBtn = document.getElementById('cartCheckoutBtn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', function() {
                if (!window.cartState || window.cartState.length === 0) {
                    if (typeof window.showToast === 'function') window.showToast('Your bag is currently empty!');
                    return;
                }
                if (typeof window.openCheckout === 'function') {
                    window.openCheckout();
                } else {
                    window.location.href = '/checkout';
                }
            });
        }
    });

    /* Initial sync call */
    setTimeout(function() {
        window.renderCart();
    }, 50);
})();
</script>
