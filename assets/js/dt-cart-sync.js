/**
 * DT Brand's — Global Cart & Wishlist Real-Time Sync Engine
 * Handles: product card buttons, badge updates, drawer sync
 * Works across: index.php, shop.php, product.php, quickview, all popups
 */
(function() {
    'use strict';

    // ── Toast Notification ──────────────────────────────────────────────────
    function dtToast(msg, type) {
        var tc = document.getElementById('toastContainer');
        if (!tc) {
            tc = document.createElement('div');
            tc.id = 'toastContainer';
            tc.style.cssText = 'position:fixed;bottom:80px;left:50%;transform:translateX(-50%);z-index:99999;display:flex;flex-direction:column;gap:8px;pointer-events:none;';
            document.body.appendChild(tc);
        }
        var t = document.createElement('div');
        var color = type === 'wish' ? '#15803D' : type === 'remove' ? '#DC2626' : '#B8860B';
        t.style.cssText = 'background:#111827;color:#fff;padding:10px 18px;border-radius:10px;font-size:13px;font-weight:600;font-family:Inter,sans-serif;display:flex;align-items:center;gap:8px;box-shadow:0 4px 20px rgba(0,0,0,0.35);border-left:3px solid ' + color + ';opacity:0;transform:translateY(10px);transition:all 0.25s ease;min-width:200px;pointer-events:none;';
        t.innerHTML = msg;
        tc.appendChild(t);
        requestAnimationFrame(function() {
            t.style.opacity = '1';
            t.style.transform = 'translateY(0)';
        });
        setTimeout(function() {
            t.style.opacity = '0';
            t.style.transform = 'translateY(10px)';
            setTimeout(function() { t.remove(); }, 300);
        }, 2800);
    }

    // ── Helper: find product by id from global catalog ──────────────────────
    function findProduct(id) {
        id = parseInt(id);
        var src = window.shopProductsData || window.allProducts || window.catalogProducts || window.products || [];
        for (var i = 0; i < src.length; i++) {
            if (parseInt(src[i].id) === id) return src[i];
        }
        return null;
    }

    // ── Badge Sync (runs immediately + called after every change) ────────────
    function dtSyncBadges() {
        try {
            var cartItems = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
            var wishItems = JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]');
            var cartQty  = cartItems.reduce(function(s, x) { return s + (parseInt(x.qty) || 1); }, 0);
            var wishQty  = wishItems.length;

            // Update all cart badges across page
            ['cartBadge','headerCartBadge','pdpCartCount','mobileCartBadge'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) { el.textContent = cartQty; el.style.display = cartQty > 0 ? 'flex' : 'none'; }
            });
            // Update all wishlist badges
            ['wishlistBadge','smartWishlistBadge','shopSmartWishlistBadge','pdpWishlistCount','mobileWishBadge'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) { el.textContent = wishQty; el.style.display = wishQty > 0 ? 'flex' : 'none'; }
            });
            // Subtitle badges
            var cSub = document.getElementById('cartBadgeSub');
            if (cSub) cSub.textContent = cartQty + ' Luxury Item' + (cartQty === 1 ? '' : 's');
            var wSub = document.getElementById('wishlistBadgeSub');
            if (wSub) wSub.textContent = wishQty + ' Saved Item' + (wishQty === 1 ? '' : 's');

            // Sync existing global state
            if (typeof window.cartState !== 'undefined') window.cartState = cartItems;
            if (typeof window.wishlistState !== 'undefined') window.wishlistState = wishItems;

            // Trigger drawer re-render if open
            if (typeof window.updateGlobalBadges === 'function') window.updateGlobalBadges();
            if (typeof window.renderCart === 'function') {
                var cartDrawer = document.getElementById('cartDrawer') || document.getElementById('cartDrawerWrap');
                if (cartDrawer && cartDrawer.classList.contains('open')) window.renderCart();
            }
            if (typeof window.renderWishlist === 'function') {
                var wishDrawer = document.getElementById('wishlistDrawer') || document.getElementById('wishlistDrawerWrap');
                if (wishDrawer && wishDrawer.classList.contains('open')) window.renderWishlist();
            }
        } catch(e) {}
    }

    // ── GLOBAL: addToCart ───────────────────────────────────────────────────
    window.dtAddToCart = function(productIdOrObj, qty, size, color) {
        var p = (typeof productIdOrObj === 'object') ? productIdOrObj : findProduct(productIdOrObj);
        if (!p) {
            // Fallback: read from data attributes on card
            p = { id: productIdOrObj, name: 'Product #' + productIdOrObj, price: 0, image: '/assets/images/product1.png' };
        }
        qty = qty || 1;
        var cart = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
        var idx  = cart.findIndex(function(x) { return parseInt(x.id) === parseInt(p.id) && (x.size || '') === (size || '') && (x.color || '') === (color || ''); });
        if (idx >= 0) {
            cart[idx].qty = (parseInt(cart[idx].qty) || 1) + qty;
        } else {
            cart.push({
                id:    parseInt(p.id),
                name:  p.name || p.title || 'Ethnic Wear',
                price: parseFloat(p.price || p.selling_price || 0),
                old_price: parseFloat(p.old_price || p.mrp || 0),
                image: p.image || p.img || p.thumbnail || '/assets/images/product1.png',
                size:  size  || p.size  || '',
                color: color || p.color || '',
                qty:   qty
            });
        }
        localStorage.setItem('dtbrands_cart', JSON.stringify(cart));

        // Show toast
        dtToast('<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2.5" style="flex-shrink:0"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg> <span>Added to Cart!</span>', 'cart');

        dtSyncBadges();

        // Open cart drawer
        setTimeout(function() {
            if (typeof window.openCartDrawer === 'function') window.openCartDrawer();
        }, 200);

        // Animate button
        var btn = document.querySelector('[data-id="' + p.id + '"].card-add-cart-btn, .card-add-cart-btn[data-id="' + p.id + '"]');
        if (btn) {
            btn.classList.add('added');
            btn.style.background = 'linear-gradient(135deg,#15803D 0%,#16A34A 100%)';
            btn.style.borderColor = '#15803D';
            setTimeout(function() {
                btn.style.background = '';
                btn.style.borderColor = '';
                btn.classList.remove('added');
            }, 1500);
        }
        return false;
    };

    // ── GLOBAL: toggleWishlist ──────────────────────────────────────────────
    window.dtToggleWishlist = function(productIdOrObj) {
        var p = (typeof productIdOrObj === 'object') ? productIdOrObj : findProduct(productIdOrObj);
        var id = parseInt((p && p.id) || productIdOrObj);
        if (!p) p = { id: id, name: 'Product #' + id, price: 0, image: '/assets/images/product1.png' };

        var list = JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]');
        var idx  = list.findIndex(function(x) { return parseInt(x.id) === id; });
        var added;
        if (idx >= 0) {
            list.splice(idx, 1);
            added = false;
        } else {
            list.push({
                id:       id,
                name:     p.name || p.title || 'Ethnic Wear',
                price:    parseFloat(p.price || p.selling_price || 0),
                old_price:parseFloat(p.old_price || p.mrp || 0),
                image:    p.image || p.img || p.thumbnail || '/assets/images/product1.png',
                category: p.category || '',
                fabric:   p.fabric || '',
                color:    p.color || ''
            });
            added = true;
        }
        localStorage.setItem('dtbrands_wishlist', JSON.stringify(list));

        // Toast
        dtToast(added
            ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="#15803D" stroke="#15803D" stroke-width="1.5" style="flex-shrink:0"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> <span>Saved to Wishlist!</span>'
            : '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2" style="flex-shrink:0"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> <span>Removed from Wishlist</span>',
            added ? 'wish' : 'remove'
        );

        dtSyncBadges();

        // Update all heart buttons for this product across page
        document.querySelectorAll('.card-wishlist-btn[data-id="' + id + '"],.wish-btn[data-id="' + id + '"],.wd-card-wish-btn[data-id="' + id + '"]').forEach(function(btn) {
            btn.classList.toggle('active', added);
            btn.setAttribute('aria-pressed', added ? 'true' : 'false');
            // Fill/unfill heart SVG
            var path = btn.querySelector('svg path');
            if (path) {
                path.setAttribute('fill', added ? '#DC2626' : 'none');
                path.setAttribute('stroke', added ? '#DC2626' : 'currentColor');
            }
        });

        // Open wishlist drawer
        setTimeout(function() {
            if (typeof window.openWishlistDrawer === 'function') window.openWishlistDrawer();
        }, 200);

        return false;
    };

    // ── Wire all product card buttons on page ────────────────────────────────
    function wireProductCards() {
        // Add to Cart buttons
        document.querySelectorAll('.card-add-cart-btn, .btn-add-cart, [data-action="add-cart"]').forEach(function(btn) {
            if (btn.dataset.dtWired) return;
            btn.dataset.dtWired = '1';
            var id = btn.dataset.id || btn.dataset.productId || btn.closest('[data-id]')?.dataset.id;
            if (!id) return;
            btn.addEventListener('click', function(e) {
                e.preventDefault(); e.stopPropagation();
                window.dtAddToCart(id);
            });
        });

        // Wishlist heart buttons
        document.querySelectorAll('.card-wishlist-btn, .btn-wishlist, [data-action="wishlist"]').forEach(function(btn) {
            if (btn.dataset.dtWired) return;
            btn.dataset.dtWired = '1';
            var id = btn.dataset.id || btn.dataset.productId || btn.closest('[data-id]')?.dataset.id;
            if (!id) return;
            // Set initial state
            var list = JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]');
            var inWish = list.some(function(x) { return parseInt(x.id) === parseInt(id); });
            if (inWish) {
                btn.classList.add('active');
                btn.setAttribute('aria-pressed', 'true');
                var path = btn.querySelector('svg path');
                if (path) { path.setAttribute('fill','#DC2626'); path.setAttribute('stroke','#DC2626'); }
            }
            btn.addEventListener('click', function(e) {
                e.preventDefault(); e.stopPropagation();
                window.dtToggleWishlist(id);
            });
        });
    }

    // ── Bridge old function names to new ones ──────────────────────────────
    // Called by old onclick="window.addToCart(...)" code
    var _origAddToCart = window.addToCart;
    window.addToCart = function(productOrId, qty, size, color) {
        if (typeof _origAddToCart === 'function') {
            _origAddToCart(productOrId, qty, size, color);
        } else {
            window.dtAddToCart(productOrId, qty, size, color);
        }
        dtSyncBadges();
    };

    var _origToggleWish = window.toggleWishlistProduct;
    window.toggleWishlistProduct = function(productOrId) {
        if (typeof _origToggleWish === 'function') {
            _origToggleWish(productOrId);
            dtSyncBadges();
        } else {
            window.dtToggleWishlist(productOrId);
        }
    };

    // ── Init on DOM ready ─────────────────────────────────────────────────
    function init() {
        dtSyncBadges();
        wireProductCards();
        // Re-wire after dynamic content loads (filters, AJAX)
        if (typeof MutationObserver !== 'undefined') {
            var obs = new MutationObserver(function(muts) {
                for (var m of muts) {
                    if (m.addedNodes.length) { wireProductCards(); break; }
                }
            });
            obs.observe(document.body, { childList: true, subtree: true });
        }
        // Also sync on storage events (multi-tab)
        window.addEventListener('storage', function(e) {
            if (e.key === 'dtbrands_cart' || e.key === 'dtbrands_wishlist') dtSyncBadges();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose for external calls
    window.dtSyncBadges = dtSyncBadges;
    window.dtToast = dtToast;

})();
