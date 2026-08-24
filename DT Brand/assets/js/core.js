/**
 * DT Brand/assets/js/core.js — Master Core State Engine & Global Utilities
 * DT Brand's & Jai Hanuman Tex
 */

(function () {
    'use strict';

    // Global Luxury Toast Notification Engine
    window.showToast = function (msg, explicitType) {
        var container = document.getElementById('dtToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'dtToastContainer';
            container.className = 'dt-toast-container';
            document.body.appendChild(container);
        }

        var t = document.createElement('div');
        t.className = 'dt-toast';
        var icon = '✨';
        if (explicitType === 'cart' || msg.toLowerCase().indexOf('bag') !== -1) icon = '🛍️';
        if (explicitType === 'wishlist' || msg.toLowerCase().indexOf('wishlist') !== -1) icon = '♡';
        if (explicitType === 'success') icon = '✓';
        if (explicitType === 'error') icon = '⚠️';

        t.innerHTML = '<span>' + icon + '</span><span>' + msg + '</span>';
        container.appendChild(t);

        setTimeout(function () {
            t.style.opacity = '0';
            t.style.transform = 'translateY(-10px)';
            t.style.transition = 'all 0.25s ease';
            setTimeout(function () { t.remove(); }, 250);
        }, 3200);
    };

    // Global Cart State Manager
    window.getCart = function () {
        try {
            return JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
        } catch (e) {
            return [];
        }
    };

    window.saveCart = function (cart) {
        localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
        window.syncBadges();
        if (typeof window.renderCartDrawerItems === 'function') {
            window.renderCartDrawerItems();
        }
    };

    window.addToCart = function (product, qty, lotType, selectedColor, selectedSize) {
        var cart = window.getCart();
        var pId = Number(product.id);
        var q = Math.max(1, Number(qty || 1));
        var lot = lotType || 'single';
        var col = selectedColor || (Array.isArray(product.colors) ? product.colors[0] : (product.color || 'Default'));
        var sz = selectedSize || (Array.isArray(product.size) ? product.size[0] : 'Free Size');

        var existingIdx = cart.findIndex(function (item) {
            return item.id === pId && item.lot_type === lot && item.color === col && item.size === sz;
        });

        if (existingIdx > -1) {
            cart[existingIdx].qty += q;
        } else {
            cart.push({
                id: pId,
                name: product.name || product.title,
                price: Number(product.price || product.retail_price || 0),
                image: product.image || '/Frontend/Shop/Asset/images/product1.png',
                color: col,
                size: sz,
                lot_type: lot,
                qty: q
            });
        }

        window.saveCart(cart);
        window.showToast('Added ' + (product.name || 'item') + ' to bag', 'cart');
    };

    // Global Wishlist State Manager
    window.getWishlist = function () {
        try {
            return JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]');
        } catch (e) {
            return [];
        }
    };

    window.toggleWishlist = function (product) {
        var wish = window.getWishlist();
        var pId = Number(product.id);
        var idx = wish.findIndex(function (w) { return Number(w.id) === pId; });
        var added = false;

        if (idx > -1) {
            wish.splice(idx, 1);
            window.showToast('Removed from wishlist');
        } else {
            wish.push({
                id: pId,
                name: product.name || product.title,
                price: Number(product.price || product.retail_price || 0),
                image: product.image || '/Frontend/Shop/Asset/images/product1.png',
                category: product.category || ''
            });
            added = true;
            window.showToast('Saved ' + (product.name || 'item') + ' to wishlist', 'wishlist');
        }

        localStorage.setItem('dtbrands_wishlist', JSON.stringify(wish));
        window.syncBadges();
        if (typeof window.renderWishlistItems === 'function') {
            window.renderWishlistItems();
        }
        return added;
    };

    // Global Badge Synchronization
    window.syncBadges = function () {
        var cart = window.getCart();
        var wish = window.getWishlist();
        var cartTotalQty = cart.reduce(function (sum, item) { return sum + (Number(item.qty) || 1); }, 0);
        var wishTotal = wish.length;

        // Header Badges
        var hCartBadge = document.getElementById('dtCartCount');
        if (hCartBadge) {
            hCartBadge.textContent = cartTotalQty;
            hCartBadge.style.display = cartTotalQty > 0 ? 'flex' : 'none';
        }
        var hWishBadge = document.getElementById('dtWishlistCount');
        if (hWishBadge) {
            hWishBadge.textContent = wishTotal;
            hWishBadge.style.display = wishTotal > 0 ? 'flex' : 'none';
        }

        // Mobile Bottom Tab Badges
        var bCartBadge = document.getElementById('dtBottomCartBadge');
        if (bCartBadge) {
            bCartBadge.textContent = cartTotalQty;
            bCartBadge.style.display = cartTotalQty > 0 ? 'flex' : 'none';
        }
    };

    document.addEventListener('DOMContentLoaded', window.syncBadges);
    window.addEventListener('storage', window.syncBadges);

})();
