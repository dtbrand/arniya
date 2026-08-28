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
    padding: 11px 24px; border-radius: 26px;
    background: linear-gradient(135deg, var(--dark-gold, #8A681F) 0%, var(--deep-gold, #6F5218) 100%);
    color: #FFFFFF; font-size: 0.72rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase; border: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(138,104,31,0.3); transition: all 0.25s ease;
    display: inline-flex; align-items: center; gap: 8px;
}
.wd-explore-btn:hover {
    transform: translateY(-2px); box-shadow: 0 6px 20px rgba(138,104,31,0.42);
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
    padding: 5px 10px; border-radius: 6px; background: var(--dark-gold, #8A681F);
    color: #FFF; border: none; font-size: 0.65rem; font-weight: 700; cursor: pointer;
    transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 3px;
}
.wd-rec-add-btn:hover { background: var(--deep-gold, #6F5218); transform: scale(1.05); }
</style>

<!-- ════════════ WISHLIST DRAWER MODAL ════════════ -->
<div class="wishlist-drawer-backdrop" id="wishlistDrawerModal" aria-hidden="true" role="dialog" aria-label="Wishlist Drawer">
    <div class="wishlist-drawer-content">
        <div class="wd-header">
            <div class="wd-title-wrap">
                <h3 class="wd-title">My Saved Wishlist</h3>
                <span class="wd-subtitle" id="wishlistBadgeSub">0 Saved Items</span>
            </div>
            <button class="wd-close-btn" id="closeWishlistDrawerBtn" aria-label="Close Wishlist">&times;</button>
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
        return [];
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
            // The recommendation strip used to fall back to four hardcoded products
            // (Banarasi Zari Saree Rs 8,499, Georgette Bloom Rs 3,299, Bridal Zardosi
            // Lehenga Rs 24,999, Mustard Block Print Rs 1,899) that a shopper could
            // save and open, so it advertised products that may not exist.
            var products = (window.allProducts || []).slice(0, 8);

            var fullList = products.length ? products.concat(products) : [];

            var sliderCardsHtml = fullList.map(function(p) {
                var saleDisc = Number(p.sale_discount || p.sale_price) || 0;
                var custBase = Number(p.customer_price) || Number(p.retail_price) || Number(p.price) || 0;
                var recPrice = Number(p.effective_customer_price || p.price) || (custBase > 0 ? Math.max(0, custBase - saleDisc) : 0);
                return '<div class="wd-rec-card">' +
                    '<div class="wd-rec-img-wrap">' +
                        '<img src="' + (p.image || '/assets/images/no-image.svg') + '" alt="' + (p.name || '') + '" class="wd-rec-img" />' +
                    '</div>' +
                    '<h5 class="wd-rec-title">' + (p.name || '') + '</h5>' +
                    '<div class="wd-rec-price-row">' +
                        '<span class="wd-rec-price">' + (recPrice > 0 ? '₹' + recPrice.toLocaleString('en-IN') : 'Price on request') + '</span>' +
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
                // The meta line used to read "Ethnic Wear • Pure Silk • Standard"
                // for a saved product with no category, fabric or colour recorded,
                // and the photo fell back to another product's saree.
                var imgUrl = item.image || '/assets/images/no-image.svg';
                var metaBits = [item.category, item.fabric, item.color].filter(function(v) { return String(v || '').trim() !== ''; });
                var saleDisc = Number(item.sale_discount || item.sale_price) || 0;
                var custBase = Number(item.customer_price) || Number(item.retail_price) || Number(item.price) || 0;
                var wPrice = Number(item.effective_customer_price || item.price) || (custBase > 0 ? Math.max(0, custBase - saleDisc) : 0);
                var wOld = saleDisc > 0 ? custBase : (Number(item.old_price || item.mrp) || 0);

                html += '<div class="wd-item" data-index="' + idx + '">' +
                    '<img src="' + imgUrl + '" alt="' + item.name + '" class="wd-item-img" />' +
                    '<div class="wd-item-info">' +
                        '<h4 class="wd-item-title">' + item.name + '</h4>' +
                        (metaBits.length ? '<span class="wd-item-meta">' + metaBits.join(' &bull; ') + '</span>' : '') +
                        '<span class="wd-item-price">' + (wPrice > 0 ? '₹' + wPrice.toLocaleString('en-IN') : 'Price on request') + (wPrice > 0 && wOld > wPrice ? ' <span class="wd-item-old">₹' + wOld.toLocaleString('en-IN') + '</span>' : '') + '</span>' +
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
            ((window.allProducts || window.catalogProducts || window.products || []).find(function(x) { return x.id == productOrId || String(x.id) === String(productOrId); }) || null);

        // An id that is not in the catalogue used to be saved as "Saved Item" at
        // Rs 2,999 with product1.png as its photo - a wishlist entry for a product
        // that does not exist, at a price nobody set.
        if (!p || !p.id) {
            if (typeof window.showToast === 'function') {
                window.showToast('That product is not in the catalogue any more.');
            }
            return false;
        }

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
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
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
