<?php
/**
 * wishlist.php — PARTIAL INCLUDE
 * Self-Contained Fully Styled & Dynamic Wishlist Drawer Component
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/Database.php';

use DTBrand\ProductCatalog;

$dbProductsForWishlist = ProductCatalog::getAll();
?>
<script>
window.allProducts = <?php echo json_encode($dbProductsForWishlist); ?>;
</script>
<style>
/* ── Wishlist Drawer Base Styles ── */
.wishlist-drawer-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(24, 20, 16, 0.78); backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: flex-end;
    z-index: 999999 !important; opacity: 0; visibility: hidden;
    pointer-events: none;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.wishlist-drawer-backdrop.active { opacity: 1; visibility: visible; pointer-events: auto; }

.wishlist-drawer-content {
    background: linear-gradient(180deg, #FFFFFF 0%, #FAF6EE 100%);
    width: 100%; max-width: 440px; height: 100%;
    box-shadow: -10px 0 30px rgba(0,0,0,0.25);
    display: flex; flex-direction: column;
    transform: translateX(100%); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    border-left: 3px solid var(--dark-gold, #8A681F);
}
.wishlist-drawer-backdrop.active .wishlist-drawer-content {
    transform: translateX(0);
}

.wd-header { display: flex; align-items: center; justify-content: space-between; padding: 10px 18px; height: 50px; border-bottom: 1.5px solid var(--dark-gold, #8A681F); background: #FFFFFF; flex-shrink: 0; }
.wd-title { font-family: var(--font-serif, 'Cinzel', serif); font-size: 1.02rem; color: var(--dark-gold, #8A681F); font-weight: 700; margin: 0; line-height: 1.1; }
.wd-subtitle { font-size: 0.58rem; color: var(--mid-text, #5A5348); font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; display: block; margin-top: 1px; }
.wd-close-btn { width: 32px; height: 32px; border-radius: 50%; border: 1px solid var(--soft-platinum, #E5E3DE); background: #FAF8F4; font-size: 1.2rem; color: var(--dark-gold, #8A681F); cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; line-height: 1; flex-shrink: 0; }
.wd-close-btn:hover { color: #FFFFFF; background: var(--dark-gold, #8A681F); border-color: var(--dark-gold, #8A681F); transform: rotate(90deg); }

.wd-body { padding: 18px 22px; flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 14px; }

/* ── Wishlist Item Card ── */
.wd-item { display: flex; gap: 14px; background: #FFFFFF; padding: 12px; border-radius: 12px; border: 1.5px solid rgba(138,104,31,0.2); align-items: center; transition: all 0.25s ease; }
.wd-item:hover { box-shadow: 0 4px 16px rgba(138,104,31,0.12); border-color: var(--dark-gold, #8A681F); }
.wd-item-img { width: 78px; height: 104px; aspect-ratio: 3 / 4; object-fit: cover; object-position: top center; border-radius: 8px; border: 1.5px solid rgba(138,104,31,0.25); flex-shrink: 0; background: #F8F5EE; }
.wd-item-info { display: flex; flex-direction: column; gap: 4px; flex: 1; }
.wd-item-title { font-family: var(--font-serif, 'Cinzel', serif); font-size: 0.92rem; font-weight: 700; color: var(--dark-text, #24211C); margin: 0; }
.wd-item-meta { font-size: 0.7rem; color: var(--mid-text, #5A5348); font-weight: 500; }
.wd-item-price { font-size: 0.95rem; font-weight: 800; color: var(--dark-gold, #8A681F); }
.wd-item-old { font-size: 0.75rem; color: var(--light-text, #9A9490); text-decoration: line-through; margin-left: 4px; }

.wd-actions { display: flex; align-items: center; gap: 8px; margin-top: 6px; }
.wd-move-bag-btn { padding: 7px 14px; border-radius: 6px; background: var(--dark-gold, #8A681F); color: #FFF; border: none; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em; cursor: pointer; transition: all 0.2s; }
.wd-move-bag-btn:hover { background: var(--deep-gold, #6F5218); box-shadow: 0 2px 8px rgba(138,104,31,0.3); }
.wd-remove-btn { border: none; background: none; color: #E53935; font-size: 0.72rem; font-weight: 600; cursor: pointer; margin-left: auto; transition: opacity 0.2s; }
.wd-remove-btn:hover { text-decoration: underline; opacity: 0.8; }

/* ── Animated Empty Wishlist Styles ── */
.wd-empty-container {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    padding: 24px 12px 10px; text-align: center; width: 100%;
}
.wd-empty-icon-wrap {
    position: relative; width: 96px; height: 96px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 12px;
}
.wd-empty-glow-ring {
    position: absolute; inset: -10px; border-radius: 50%;
    background: radial-gradient(circle, rgba(229,57,53,0.18) 0%, rgba(229,57,53,0) 70%);
    animation: pulseHeartRing 3s ease-in-out infinite;
}
@keyframes pulseHeartRing {
    0%, 100% { transform: scale(0.9); opacity: 0.4; }
    50% { transform: scale(1.2); opacity: 1; }
}

.wd-empty-svg {
    width: 68px; height: 68px;
    stroke: #E53935; fill: none; stroke-width: 1.6;
    animation: floatHeart 3.6s ease-in-out infinite;
    filter: drop-shadow(0 8px 16px rgba(229,57,53,0.25));
    position: relative; z-index: 2;
}
@keyframes floatHeart {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-10px) scale(1.08); }
}

.wd-empty-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 1.2rem; font-weight: 700; color: var(--dark-gold, #8A681F);
    letter-spacing: 0.1em; text-transform: uppercase; margin: 0 0 4px;
}
.wd-empty-desc {
    font-size: 0.78rem; color: var(--mid-text, #5A5348);
    margin: 0 0 16px; line-height: 1.5; max-width: 270px;
}

.wd-explore-btn {
    padding: 10px 22px; border-radius: 24px;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    border: 1px solid #8A681F;
    color: #111827; font-size: 0.72rem; font-weight: 800;
    letter-spacing: 0.12em; text-transform: uppercase; border: none; cursor: pointer;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 3px 12px rgba(184,134,11,0.3); transition: all 0.22s ease;
    display: inline-flex; align-items: center; gap: 8px;
}
.wd-explore-btn:hover {
    background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
    transform: translateY(-2px); box-shadow: inset 0 1px 0 rgba(255,255,255,0.5), 0 5px 16px rgba(184,134,11,0.42);
}

/* ── Interactive Auto-Slide Product Recommendations with Full-Size Portrait Photo ── */
.wd-recommend-section {
    margin-top: 18px; padding-top: 16px;
    border-top: 1px dashed rgba(138,104,31,0.3);
    width: 100%; text-align: left;
}
.wd-rec-head {
    font-family: var(--font-serif, 'Cinzel', serif); font-size: 0.78rem; font-weight: 700;
    color: var(--dark-gold, #8A681F); letter-spacing: 0.1em; text-transform: uppercase;
    margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between;
}
.wd-rec-track {
    display: flex; gap: 14px; overflow-x: auto;
    padding: 4px 2px 10px; scrollbar-width: none; -webkit-overflow-scrolling: touch;
    cursor: grab; user-select: none; scroll-behavior: auto;
}
.wd-rec-track.active-drag {
    cursor: grabbing; cursor: -webkit-grabbing;
}
.wd-rec-track::-webkit-scrollbar { display: none; }

.wd-rec-card {
    flex: 0 0 152px;
    background: #FFFFFF; border: 1.5px solid rgba(138,104,31,0.22);
    border-radius: 12px; padding: 9px; display: flex; flex-direction: column; gap: 8px;
    transition: all 0.25s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: relative;
}
.wd-rec-card:hover { border-color: var(--dark-gold, #8A681F); box-shadow: 0 6px 18px rgba(138,104,31,0.2); transform: translateY(-2px); }

.wd-rec-img-wrap {
    width: 100%; aspect-ratio: 3 / 4; border-radius: 8px; overflow: hidden;
    background: #F8F5EE; position: relative;
}
.wd-rec-img {
    width: 100%; height: 100%; object-fit: cover; object-position: top center;
    display: block; pointer-events: none; transition: transform 0.35s ease;
}
.wd-rec-card:hover .wd-rec-img { transform: scale(1.05); }

.wd-rec-title { font-size: 0.74rem; font-weight: 700; color: var(--dark-text, #24211C); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; }
.wd-rec-price-row { display: flex; align-items: center; justify-content: space-between; margin-top: auto; }
.wd-rec-price { font-size: 0.82rem; font-weight: 800; color: var(--dark-gold, #8A681F); }
.wd-rec-add-btn {
    padding: 5px 10px; border-radius: 6px;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    border: 1px solid #8A681F;
    color: #111827; font-size: 0.65rem; font-weight: 800; cursor: pointer;
    transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 3px;
}
.wd-rec-add-btn:hover {
    background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
    transform: scale(1.05);
}

.wd-move-bag-btn {
    padding: 7px 14px; border-radius: 7px;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    border: 1px solid #8A681F;
    color: #111827; font-size: 0.68rem; font-weight: 800; letter-spacing: 0.08em; cursor: pointer;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 6px rgba(184,134,11,0.25);
    transition: all 0.2s ease;
}
.wd-move-bag-btn:hover {
    background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
    transform: translateY(-1px);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.5), 0 4px 12px rgba(184,134,11,0.38);
}
</style>

<!-- ════════════ WISHLIST DRAWER MODAL ════════════ -->
<div class="wishlist-drawer-backdrop" id="wishlistDrawerModal" aria-hidden="true" role="dialog" aria-label="Wishlist Drawer" inert>
    <div class="wishlist-drawer-content">
        <div class="wd-header">
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/Shared/Asset/images/logo.png';" alt="DT Brand's" style="height:28px; width:auto; max-width:120px; object-fit:contain;">
                <div>
                    <h3 class="wd-title" style="margin:0; font-size:0.95rem;">Saved Wishlist</h3>
                    <span class="wd-subtitle" id="wishlistBadgeSub" style="font-size:0.56rem;">0 Saved Items</span>
                </div>
            </div>
            <button class="wd-close-btn" id="closeWishlistDrawerBtn" onclick="if(typeof window.closeWishlistDrawer==='function') window.closeWishlistDrawer();" aria-label="Close Wishlist">✕</button>
        </div>

        <div class="wd-body" id="wishlistItemsWrap">
            <!-- Dynamic Items or Animated Empty Wishlist rendered via JS -->
        </div>
    </div>
</div>

<script>
/* ── Wishlist Controller with Smooth Auto-Slide & Touch/Mouse Drag ── */
(function() {
    function loadWishlist() {
        try {
            var raw = localStorage.getItem('dtbrands_wishlist');
            if (raw !== null) return JSON.parse(raw);
        } catch(e) {}
        return [
            {
                id: 5,
                name: 'Royal Anarkali Kurti',
                price: 2799,
                old_price: 3900,
                image: '/Shared/Asset/images/product5.png',
                category: 'Kurtis',
                fabric: 'Cotton',
                color: 'Green'
            },
            {
                id: 8,
                name: 'Ivory Designer Gown',
                price: 7499,
                old_price: 9500,
                image: '/Shared/Asset/images/product8.png',
                category: 'Gowns',
                fabric: 'Chiffon',
                color: 'White'
            }
        ];
    }

    function saveWishlist(list) {
        try {
            localStorage.setItem('dtbrands_wishlist', JSON.stringify(list));
        } catch(e) {}
    }

    window.wishlistState = loadWishlist();

    window.attachWishlistAutoSlider = function(track) {
        if (!track || track._wishlistAutoAttached) return;
        track._wishlistAutoAttached = true;

        var isPaused = false;
        var isDown = false;
        var startX = 0;
        var startScrollLeft = 0;
        var scrollSpeed = 0.6; // smooth, gentle auto-slide

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

        /* Desktop Mouse Drag */
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

        /* Mobile Touch Swipe */
        track.addEventListener('touchstart', function() {
            isPaused = true;
        }, { passive: true });

        track.addEventListener('touchend', function() {
            setTimeout(function() { isPaused = false; }, 2000);
        }, { passive: true });
    };

    window.renderWishlist = function() {
        var wrap = document.getElementById('wishlistItemsWrap');

        if (!wrap) return;

        var items = window.wishlistState || [];

        if (items.length === 0) {
            /* Render Animated Floating Heart SVG Empty Wishlist + Recommended Product Slider */
            var products = window.allProducts || [
                { id: 2, name: 'Banarasi Zari Saree', price: 8499, image: '/Shared/Asset/images/product2.png' },
                { id: 4, name: 'Georgette Bloom Saree', price: 3299, image: '/Shared/Asset/images/product4.png' },
                { id: 6, name: 'Bridal Zardosi Lehenga', price: 24999, image: '/Shared/Asset/images/product6.png' },
                { id: 7, name: 'Mustard Block Print', price: 1899, image: '/Shared/Asset/images/product7.png' }
            ];

            var fullList = products.concat(products);

            var sliderCardsHtml = fullList.map(function(p) {
                return '<div class="wd-rec-card">' +
                    '<div class="wd-rec-img-wrap">' +
                        '<img src="' + p.image + '" alt="' + p.name + '" class="wd-rec-img" />' +
                    '</div>' +
                    '<h5 class="wd-rec-title">' + p.name + '</h5>' +
                    '<div class="wd-rec-price-row">' +
                        '<span class="wd-rec-price">₹' + Number(p.price).toLocaleString('en-IN') + '</span>' +
                        '<button class="wd-rec-add-btn" onclick="window.addRecToWishlist(' + p.id + ')">♡ SAVE</button>' +
                    '</div>' +
                '</div>';
            }).join('');

            wrap.innerHTML =
                '<div class="wd-empty-container">' +
                    '<div class="wd-empty-icon-wrap">' +
                        '<div class="wd-empty-glow-ring"></div>' +
                        '<svg class="wd-empty-svg" viewBox="0 0 24 24">' +
                            '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>' +
                        '</svg>' +
                    '</div>' +
                    '<h4 class="wd-empty-title">YOUR WISHLIST IS EMPTY</h4>' +
                    '<p class="wd-empty-desc">Save your favorite ethnic luxury sarees, kurtis & lehengas to shop anytime.</p>' +
                    '<button class="wd-explore-btn" onclick="window.closeWishlistDrawer(); window.scrollTo({top: 500, behavior: \'smooth\'});">' +
                        'EXPLORE CATALOGUE &rarr;' +
                    '</button>' +

                    '<div class="wd-recommend-section">' +
                        '<div class="wd-rec-head">' +
                            '<span>✨ RECOMMENDED FOR YOU</span>' +
                            '<span style="font-size:0.65rem; opacity:0.8;">SWIPE &rsaquo;</span>' +
                        '</div>' +
                        '<div class="wd-rec-track" id="wdRecTrack">' +
                            sliderCardsHtml +
                        '</div>' +
                    '</div>' +
                '</div>';

            setTimeout(function() {
                var track = document.getElementById('wdRecTrack');
                if (track) window.attachWishlistAutoSlider(track);
            }, 60);

        } else {
            var html = '';
            items.forEach(function(item, idx) {
                var imgUrl = item.image || '/Shared/Asset/images/product1.png';

                html += '<div class="wd-item" data-index="' + idx + '">' +
                    '<img src="' + imgUrl + '" alt="' + item.name + '" class="wd-item-img" />' +
                    '<div class="wd-item-info">' +
                        '<h4 class="wd-item-title">' + item.name + '</h4>' +
                        '<span class="wd-item-meta">' + (item.category || 'Ethnic Wear') + ' &bull; ' + (item.fabric || 'Pure Silk') + ' &bull; ' + (item.color || 'Standard') + '</span>' +
                        '<span class="wd-item-price">₹' + Number(item.price).toLocaleString('en-IN') + (item.old_price ? ' <span class="wd-item-old">₹' + Number(item.old_price).toLocaleString('en-IN') + '</span>' : '') + '</span>' +
                        '<div class="wd-actions">' +
                            '<button class="wd-move-bag-btn" onclick="window.moveToBag(' + idx + ')">MOVE TO BAG</button>' +
                            '<button class="wd-remove-btn" onclick="window.removeFromWishlist(' + idx + ')">&times; Remove</button>' +
                        '</div>' +
                    '</div>' +
                '</div>';
            });
            wrap.innerHTML = html;
        }

        if (typeof window.updateGlobalBadges === 'function') {
            window.updateGlobalBadges();
        }
    };

    window.addRecToWishlist = function(productId) {
        var products = window.allProducts || [];
        var p = products.find(function(x) { return x.id == productId; });
        if (p && typeof window.toggleWishlistProduct === 'function') {
            window.toggleWishlistProduct(p);
            if (typeof window.showToast === 'function') window.showToast('♡ Saved ' + p.name + ' to wishlist');
        }
    };

    window.removeFromWishlist = function(idx) {
        if (!window.wishlistState[idx]) return;
        window.wishlistState.splice(idx, 1);
        saveWishlist(window.wishlistState);
        window.renderWishlist();
        if (typeof window.showToast === 'function') window.showToast('Item removed from wishlist');
    };

    window.moveToBag = function(idx) {
        if (!window.wishlistState[idx]) return;
        var item = window.wishlistState.splice(idx, 1)[0];
        saveWishlist(window.wishlistState);
        window.renderWishlist();

        if (typeof window.addToCart === 'function') {
            window.addToCart(item);
        }
        window.closeWishlistDrawer();
    };

        window.toggleWishlistProduct = function(productOrId) {
        if (!productOrId) return false;
        var p = (typeof productOrId === 'object' && productOrId !== null) ? productOrId :
            ((window.allProducts || window.catalogProducts || window.products || []).find(function(x) { return x.id == productOrId || String(x.id) === String(productOrId); }) || { id: productOrId, name: 'Saved Item', price: 2999, image: '/Shared/Asset/images/product1.png' });
        
        var idx = (window.wishlistState || []).findIndex(function(item) { return item && (item.id == p.id || String(item.id) === String(p.id)); });
        var added = false;
        if (!Array.isArray(window.wishlistState)) window.wishlistState = [];

        if (idx > -1) {
            window.wishlistState.splice(idx, 1);
            added = false;
        } else {
            window.wishlistState.push(p);
            added = true;
        }
        saveWishlist(window.wishlistState);
        if (typeof window.renderWishlist === 'function') window.renderWishlist();
        if (typeof window.updateGlobalBadges === 'function') window.updateGlobalBadges();
        return added;
    };

    window.openWishlistDrawer = function() {
        var modal = document.getElementById('wishlistDrawerModal');
        if (modal) {
            modal.removeAttribute('inert');
            modal.classList.add('active');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
    };

    window.openWishlist = window.openWishlistDrawer;
    window.closeWishlist = window.closeWishlistDrawer;

    window.closeWishlistDrawer = function() {
        var modal = document.getElementById('wishlistDrawerModal');
        if (modal) {
            if (document.activeElement && modal.contains(document.activeElement)) {
                document.activeElement.blur();
            }
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            modal.setAttribute('inert', '');
            document.body.style.overflow = '';
        }
    };

    /* Bind events on DOM Load */
    document.addEventListener('DOMContentLoaded', function() {
        window.renderWishlist();

        var closeBtn = document.getElementById('closeWishlistDrawerBtn');
        if (closeBtn) closeBtn.addEventListener('click', window.closeWishlistDrawer);

        var modal = document.getElementById('wishlistDrawerModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) window.closeWishlistDrawer();
            });
        }
    });

    /* Initial sync call */
    setTimeout(function() {
        window.renderWishlist();
    }, 50);
})();
</script>
