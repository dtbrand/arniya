<?php
/**
 * reels.php — PARTIAL INCLUDE
 * Instagram Reels / TikTok Style Shoppable Full-Screen Video Feed for DT Brand's
 * Features Vertical Snap Video Scrolling, Right Action Bar (Wishlist, Cart, Quick View, Share),
 * Bottom Product Overlay with Instant Size Selection, and Double-Tap Heart Animation.
 */
?>
<style>
/* ════════════════════════════════════════════════════
   INSTAGRAM REELS MODAL & FULL-SCREEN OVERLAY
════════════════════════════════════════════════════ */
.reels-overlay {
    position: fixed;
    inset: 0;
    z-index: 25000;
    background: rgba(10, 8, 6, 0.95);
    backdrop-filter: blur(16px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.35s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.35s ease;
}
.reels-overlay.open {
    opacity: 1;
    visibility: visible;
}

.reels-wrapper {
    position: relative;
    width: 100%;
    height: 100%;
    max-width: 440px;
    max-height: 100vh;
    background: #000000;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 60px rgba(0,0,0,0.6);
}
@media (min-width: 768px) {
    .reels-wrapper {
        border-radius: 20px;
        height: 92vh;
        max-height: 880px;
        border: 1.5px solid rgba(138, 104, 31, 0.35);
    }
}

/* ── Top Reels Header ── */
.reels-top-bar {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    z-index: 30;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px;
    background: linear-gradient(180deg, rgba(0,0,0,0.7) 0%, transparent 100%);
    pointer-events: auto;
}
.reels-brand-tag {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #FFFFFF;
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 0.92rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}
.reels-live-dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: #E53935;
    box-shadow: 0 0 8px #E53935;
    animation: liveDotBlink 1.4s infinite;
}
@keyframes liveDotBlink {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.8); }
}

.reels-top-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.reels-icon-btn {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #FFFFFF;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}
.reels-icon-btn:hover {
    background: rgba(138, 104, 31, 0.8);
    transform: scale(1.08);
}
.reels-icon-btn svg {
    width: 17px; height: 17px;
    stroke: currentColor; stroke-width: 2.2; fill: none;
}

/* ── Vertical Snap Track ── */
.reels-track {
    width: 100%;
    height: 100%;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.reels-track::-webkit-scrollbar { display: none; }

/* ── Single Reel Slide ── */
.reel-slide {
    position: relative;
    width: 100%;
    height: 100%;
    scroll-snap-align: start;
    scroll-snap-stop: always;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #000000;
    overflow: hidden;
}

/* Video Player */
.reel-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    cursor: pointer;
}

/* A pasted YouTube / Instagram link renders in an iframe. */
.reel-embed {
    border: 0;
    display: block;
    background: #000000;
}

/* Double-Tap Heart Explosion */
.reel-heart-pop {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) scale(0);
    width: 90px; height: 90px;
    color: #FF2A54;
    pointer-events: none;
    z-index: 25;
    opacity: 0;
    transition: transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
}
.reel-heart-pop.active {
    transform: translate(-50%, -50%) scale(1.2);
    opacity: 1;
}

/* Play/Pause State Icon Overlay */
.reel-play-state {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) scale(0.6);
    width: 64px; height: 64px;
    border-radius: 50%;
    background: rgba(0,0,0,0.55);
    color: #FFFFFF;
    display: flex; align-items: center; justify-content: center;
    pointer-events: none;
    opacity: 0;
    transition: all 0.25s ease;
    z-index: 20;
}
.reel-play-state.show {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
}
.reel-play-state svg {
    width: 28px; height: 28px;
    stroke: currentColor; fill: currentColor;
}

/* ── Right-Side Instagram Reel Action Bar ── */
.reel-actions-bar {
    position: absolute;
    right: 12px;
    bottom: 90px;
    z-index: 25;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}
.reel-action-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    background: none;
    border: none;
    cursor: pointer;
    color: #FFFFFF;
    transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.reel-action-item:hover {
    transform: scale(1.15);
}
.reel-action-btn-circle {
    width: 44px; height: 44px;
    border-radius: 50%;
    background: rgba(30, 24, 18, 0.65);
    backdrop-filter: blur(10px);
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    display: flex; align-items: center; justify-content: center;
    color: #FFFFFF;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(0,0,0,0.4);
}
.reel-action-item:hover .reel-action-btn-circle {
    border-color: var(--dark-gold, #8A681F);
    background: rgba(138, 104, 31, 0.85);
}
.reel-action-btn-circle.liked {
    background: rgba(229, 57, 53, 0.9);
    border-color: #FF2A54;
    color: #FFFFFF;
}
.reel-action-btn-circle svg {
    width: 20px; height: 20px;
    stroke: currentColor; stroke-width: 2.2; fill: none;
}
.reel-action-btn-circle.liked svg {
    fill: currentColor;
}
.reel-action-label {
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.65rem;
    font-weight: 700;
    text-shadow: 0 1px 4px rgba(0,0,0,0.8);
    letter-spacing: 0.04em;
}

/* ── Bottom Product Overlay Info ── */
.reel-bottom-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 24;
    padding: 30px 14px 16px;
    background: linear-gradient(0deg, rgba(0,0,0,0.92) 0%, rgba(0,0,0,0.6) 65%, transparent 100%);
    display: flex;
    flex-direction: column;
    gap: 8px;
    pointer-events: auto;
}

.reel-meta-tag-row {
    display: flex;
    align-items: center;
    gap: 8px;
}
.reel-tag-pill {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    font-size: 0.58rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    padding: 2px 7px;
    border-radius: 4px;
}
.reel-fabric-name {
    color: rgba(255, 255, 255, 0.85);
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.06em;
}

.reel-product-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 1.05rem;
    font-weight: 700;
    color: #FFFFFF;
    margin: 0;
    line-height: 1.25;
    text-shadow: 0 2px 8px rgba(0,0,0,0.8);
}

.reel-price-row {
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.reel-price-val {
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 1.15rem;
    font-weight: 800;
    color: #F8D67A;
}
.reel-old-price {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.6);
    text-decoration: line-through;
}
.reel-discount-badge {
    font-size: 0.65rem;
    font-weight: 800;
    color: #4CAF50;
    background: rgba(76, 175, 80, 0.15);
    border: 1px solid rgba(76, 175, 80, 0.4);
    padding: 1.5px 6px;
    border-radius: 4px;
}

/* Size Pills in Reel */
.reel-sizes-row {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 1px;
}
.reel-size-btn {
    min-width: 32px;
    height: 26px;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #FFFFFF;
    font-size: 0.65rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0 6px;
}
.reel-size-btn.active {
    background: var(--dark-gold, #8A681F);
    border-color: #F8D67A;
    color: #FFFFFF;
    box-shadow: 0 0 10px rgba(248, 214, 122, 0.4);
}

/* Bottom Actions: Buy Now / Add to Bag CTA */
.reel-bottom-cta-row {
    display: flex;
    gap: 8px;
    margin-top: 4px;
}
.reel-atc-cta-btn {
    flex: 1;
    height: 38px;
    border-radius: 8px;
    background: linear-gradient(135deg, var(--dark-gold, #8A681F) 0%, #B38628 100%);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #FFFFFF;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    box-shadow: 0 4px 16px rgba(138, 104, 31, 0.4);
    transition: all 0.2s ease;
}
.reel-atc-cta-btn:hover {
    background: linear-gradient(135deg, #B38628 0%, #8A681F 100%);
    transform: translateY(-1px);
}
.reel-atc-cta-btn svg {
    width: 15px; height: 15px;
    stroke: #FFFFFF; stroke-width: 2.2; fill: none;
}

.reel-qv-cta-btn {
    width: 38px; height: 38px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.18);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #FFFFFF;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.reel-qv-cta-btn:hover {
    background: var(--dark-gold, #8A681F);
}
.reel-qv-cta-btn svg {
    width: 17px; height: 17px;
    stroke: currentColor; stroke-width: 2; fill: none;
}

/* ── Video Progress Bar ── */
.reel-progress-wrap {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2.5px;
    background: rgba(255, 255, 255, 0.25);
    z-index: 35;
}
.reel-progress-bar {
    height: 100%;
    width: 0%;
    background: var(--dark-gold, #F8D67A);
    box-shadow: 0 0 6px rgba(248, 214, 122, 0.8);
    transition: width 0.1s linear;
}
</style>

<!-- ════════════ REELS MODAL OVERLAY ════════════ -->
<div class="reels-overlay" id="reelsModalOverlay" role="dialog" aria-modal="true" aria-label="DT Brand's Video Reels" aria-hidden="true" inert>
    <div class="reels-wrapper" id="reelsWrapper">
        
        <!-- Top Bar Header -->
        <div class="reels-top-bar">
            <div class="reels-brand-tag">
                <span class="reels-live-dot"></span>
                <span>DT Brand's Reels</span>
            </div>
            <div class="reels-top-actions">
                <button class="reels-icon-btn" id="reelsMuteBtn" aria-label="Toggle sound">
                    <svg id="reelsMuteIcon" viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
                </button>
                <button class="reels-icon-btn" id="closeReelsBtn" aria-label="Close reels">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
        </div>

        <!-- Vertical Snap Track of Product Reels -->
        <div class="reels-track" id="reelsTrack">
            <!-- Dynamically populated from JavaScript -->
        </div>

    </div>
</div>

<script>
/* ── DT Brand's Reels Controller Engine ── */
(function() {
    // There is no stock-footage pool any more. This used to hold eight
    // assets.mixkit.co clips of other people's sarees and hand one to every
    // product in turn - reelsVideos[idx % reelsVideos.length] - so the reel a
    // shopper watched had nothing to do with the saree named underneath it.
    var isMuted = true;

    function reEsc(v) {
        return String(v === null || typeof v === 'undefined' ? '' : v)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function reFirst(list, single) {
        var arr = Array.isArray(list) ? list : (single ? [single] : []);
        for (var i = 0; i < arr.length; i++) {
            var v = String(arr[i] === null || typeof arr[i] === 'undefined' ? '' : arr[i]).trim();
            if (v !== '') return v;
        }
        return '';
    }

    function extractProductVideos(p) {
        if (!p) return [];
        var list = [];
        if (Array.isArray(p.videos)) {
            p.videos.forEach(function(v) {
                var s = String(v || '').trim();
                if (s !== '' && !list.some(function(x) { return x.src === s; })) list.push({ kind: 'video', src: s });
            });
        }
        if (p.video) {
            var sv = String(p.video || '').trim();
            if (sv !== '' && !list.some(function(x) { return x.src === sv; })) list.push({ kind: 'video', src: sv });
        }
        if (Array.isArray(p.embeds)) {
            p.embeds.forEach(function(e) {
                var se = String(e || '').trim();
                if (se !== '' && !list.some(function(x) { return x.src === se; })) list.push({ kind: 'embed', src: se });
            });
        }
        if (p.embed) {
            var sem = String(p.embed || '').trim();
            if (sem !== '' && !list.some(function(x) { return x.src === sem; })) list.push({ kind: 'embed', src: sem });
        }
        return list;
    }

    // Only products whose own video was uploaded or whose embed link was pasted
    // in the admin product form appear in the reels.
    function reelProducts() {
        return (window.allProducts || []).filter(function(p) {
            if (!p) return false;
            return extractProductVideos(p).length > 0;
        });
    }
    window.dtReelsAvailable = function() { return reelProducts().length > 0 || (window.currentProductData && extractProductVideos(window.currentProductData).length > 0); };

    window.openProductVideosReel = function(targetProduct) {
        return window.openReelsModal(targetProduct || window.currentProductData, 0);
    };

    window.openReelsModal = function(targetOrIndex, startIndex) {
        var overlay = document.getElementById('reelsModalOverlay');
        var track = document.getElementById('reelsTrack');
        if (!overlay || !track) return false;

        var targetProduct = null;
        var startIdx = 0;
        if (typeof targetOrIndex === 'object' && targetOrIndex !== null) {
            targetProduct = targetOrIndex;
            startIdx = typeof startIndex === 'number' ? startIndex : 0;
        } else if (typeof targetOrIndex === 'number') {
            startIdx = targetOrIndex;
        }

        var allReelEntries = [];

        // If a target product is specified (e.g. from single product page), put all its videos first!
        if (targetProduct) {
            var targetVids = extractProductVideos(targetProduct);
            targetVids.forEach(function(vItem, vIdx) {
                allReelEntries.push({
                    product: targetProduct,
                    media: vItem,
                    videoIndex: vIdx,
                    totalProductVideos: targetVids.length
                });
            });
        }

        // Add other catalog products' videos
        var catalog = window.allProducts || [];
        catalog.forEach(function(p) {
            if (targetProduct && String(p.id) === String(targetProduct.id)) return;
            var pVids = extractProductVideos(p);
            pVids.forEach(function(vItem, vIdx) {
                allReelEntries.push({
                    product: p,
                    media: vItem,
                    videoIndex: vIdx,
                    totalProductVideos: pVids.length
                });
            });
        });

        // If no videos were extracted from catalog products, create entries from real catalog products
        if (allReelEntries.length === 0 && catalog.length > 0) {
            catalog.forEach(function(p) {
                var posterImg = (p.image && p.image !== '/assets/images/no-image.svg' && p.has_photo !== false) ? p.image : '';
                allReelEntries.push({
                    product: p,
                    media: { kind: 'image', src: posterImg },
                    videoIndex: 0,
                    totalProductVideos: 1
                });
            });
        }

        if (allReelEntries.length === 0) {
            if (typeof window.showToast === 'function') {
                window.showToast('No product videos have been uploaded yet.');
            }
            return false;
        }

        /* Build Slides */
        track.innerHTML = allReelEntries.map(function(entry, idx) {
            var p = entry.product;
            var media = entry.media;
            var vidSrc = media.kind === 'video' ? media.src : '';
            var embedSrc = media.kind === 'embed' ? media.src : '';
            var poster = (p.image && p.image !== '/assets/images/no-image.svg' && p.has_photo !== false) ? p.image : '';
            var isWish = Array.isArray(window.wishlistState) && window.wishlistState.some(function(item) { return item.id == p.id; });
            var pName = reEsc(p.name || p.title || 'Product');
            var priceNum = Number(p.effective_customer_price || p.price || p.customer_price) || 0;
            var oldNum = Number(p.mrp || p.old_price) || 0;
            var discNum = Number(p.discount) || 0;

            var videoCounterBadge = entry.totalProductVideos > 1 ? '<span class="reel-part-badge" style="display:inline-block; background:rgba(212,175,55,0.25); border:1px solid #D4AF37; color:#D4AF37; font-size:0.62rem; font-weight:800; padding:2px 7px; border-radius:12px; text-transform:uppercase;">Video ' + (entry.videoIndex + 1) + '/' + entry.totalProductVideos + '</span>' : '';

            var mediaHtml = '';
            if (vidSrc !== '') {
                mediaHtml = '<video class="reel-video" loop playsinline preload="auto"' + (poster ? ' poster="' + reEsc(poster) + '"' : '') + ' muted>' +
                              '<source src="' + reEsc(vidSrc) + '" type="video/mp4">' +
                          '</video>';
            } else if (embedSrc !== '') {
                mediaHtml = '<iframe class="reel-video reel-embed" src="' + reEsc(embedSrc) + '" title="' + pName + '" ' +
                              'allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" ' +
                              'referrerpolicy="strict-origin-when-cross-origin" allowfullscreen loading="lazy"></iframe>';
            } else {
                mediaHtml = '<img class="reel-video" src="' + reEsc(poster || '/assets/images/no-image.svg') + '" alt="' + pName + '" style="object-fit:cover; width:100%; height:100%;" />';
            }

            return '<div class="reel-slide" data-index="' + idx + '" data-product-id="' + reEsc(p.id) + '" data-media="' + media.kind + '">' +
                mediaHtml +

                '<!-- Heart Pop Animation -->' +
                '<svg class="reel-heart-pop" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>' +

                '<!-- Play/Pause Indicator -->' +
                '<div class="reel-play-state">' +
                    '<svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>' +
                '</div>' +

                '<!-- Right-Side Action Bar -->' +
                '<div class="reel-actions-bar">' +
                    '<button class="reel-action-item reel-wishlist-action" data-id="' + reEsc(p.id) + '" aria-label="Wishlist">' +
                        '<div class="reel-action-btn-circle ' + (isWish ? 'liked' : '') + '">' +
                            '<svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>' +
                        '</div>' +
                        '<span class="reel-action-label">' + (isWish ? 'Saved' : 'Save') + '</span>' +
                    '</button>' +

                    '<button class="reel-action-item reel-cart-action" data-id="' + reEsc(p.id) + '" aria-label="Add to Bag">' +
                        '<div class="reel-action-btn-circle">' +
                            '<svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>' +
                        '</div>' +
                        '<span class="reel-action-label">Add Bag</span>' +
                    '</button>' +

                    '<button class="reel-action-item reel-wa-action" data-id="' + reEsc(p.id) + '" data-name="' + pName + '" data-price="' + priceNum + '" aria-label="WhatsApp Enquiry">' +
                        '<div class="reel-action-btn-circle reel-wa-btn-circle" style="background:linear-gradient(135deg, #15803D, #16A34A); border:1.5px solid #22C55E; color:#FFFFFF;">' +
                            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>' +
                        '</div>' +
                        '<span class="reel-action-label">WhatsApp</span>' +
                    '</button>' +

                    '<button class="reel-action-item reel-share-action" data-name="' + pName + '" data-price="' + priceNum + '" data-id="' + reEsc(p.id) + '" aria-label="Share">' +
                        '<div class="reel-action-btn-circle">' +
                            '<svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>' +
                        '</div>' +
                        '<span class="reel-action-label">Share</span>' +
                    '</button>' +
                '</div>' +

                '<!-- Bottom Info Overlay -->' +
                '<div class="reel-bottom-info">' +
                    '<div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">' +
                        videoCounterBadge +
                        '<span style="font-size:0.68rem; color:#D4AF37; font-weight:800; text-transform:uppercase; letter-spacing:0.08em;">DT Brand\'s 360° Video</span>' +
                    '</div>' +
                    '<h3 class="reel-product-title">' + pName + '</h3>' +

                    '<div class="reel-price-row">' +
                        '<span class="reel-price-val">' + (priceNum > 0 ? '₹' + priceNum.toLocaleString('en-IN') : 'Price on request') + '</span>' +
                        (oldNum > priceNum ? '<span class="reel-old-price">₹' + oldNum.toLocaleString('en-IN') + '</span>' : '') +
                        (discNum > 0 ? '<span class="reel-discount-badge">' + discNum + '% OFF</span>' : '') +
                    '</div>' +

                    '<div class="reel-bottom-cta-row">' +
                        '<button class="reel-atc-cta-btn reel-buy-btn" data-id="' + reEsc(p.id) + '">' +
                            '<svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>' +
                            'ADD TO BAG' +
                        '</button>' +
                    '</div>' +
                '</div>' +

                '<!-- Progress Bar -->' +
                '<div class="reel-progress-wrap">' +
                    '<div class="reel-progress-bar"></div>' +
                '</div>' +
            '</div>';
        }).join('');

        overlay.removeAttribute('inert');
        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        /* Bind Interactive Events */
        bindReelsEvents();

        /* Scroll to target slide */
        var targetIndex = typeof startIdx === 'number' ? startIdx : 0;
        var slides = track.querySelectorAll('.reel-slide');
        if (targetIndex < 0 || targetIndex >= slides.length) targetIndex = 0;
        if (slides[targetIndex]) {
            slides[targetIndex].scrollIntoView();
            setTimeout(function() {
                playSlide(slides[targetIndex]);
            }, 100);
        }
        return true;
    };

    window.closeReelsModal = function() {
        var overlay = document.getElementById('reelsModalOverlay');
        if (overlay) {
            // Remove active focus from inside the dialog before setting aria-hidden/inert to prevent a11y focus retention warning
            if (document.activeElement && overlay.contains(document.activeElement)) {
                document.activeElement.blur();
            }
            overlay.classList.remove('open');
            overlay.setAttribute('aria-hidden', 'true');
            overlay.setAttribute('inert', '');
            document.body.style.overflow = '';

            /* Pause all videos, and reset embeds so a third-party player stops. */
            var track = document.getElementById('reelsTrack');
            if (track) {
                track.querySelectorAll('video').forEach(function(v) {
                    v.pause();
                });
                track.querySelectorAll('iframe').forEach(function(f) {
                    var s = f.getAttribute('src');
                    if (s) f.setAttribute('src', s);
                });
            }
        }
    };

    function playSlide(slide) {
        if (!slide) return;
        var video = slide.querySelector('video');
        if (video) {
            video.muted = isMuted;
            video.play().catch(function() {});
        }

        /* Update progress bar */
        if (video) {
            var pBar = slide.querySelector('.reel-progress-bar');
            video.ontimeupdate = function() {
                if (video.duration && pBar) {
                    var pct = (video.currentTime / video.duration) * 100;
                    pBar.style.width = pct + '%';
                }
            };
        }
    }

    function pauseOtherSlides(activeSlide) {
        var track = document.getElementById('reelsTrack');
        if (!track) return;
        track.querySelectorAll('.reel-slide').forEach(function(slide) {
            if (slide !== activeSlide) {
                var v = slide.querySelector('video');
                if (v) v.pause();
            }
        });
    }

    function bindReelsEvents() {
        var track = document.getElementById('reelsTrack');
        if (!track) return;

        /* Intersection Observer to auto-play visible reel */
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting && entry.intersectionRatio >= 0.6) {
                    pauseOtherSlides(entry.target);
                    playSlide(entry.target);
                }
            });
        }, { threshold: 0.6 });

        track.querySelectorAll('.reel-slide').forEach(function(slide) {
            observer.observe(slide);

            /* Tap Video to Play / Pause */
            var video = slide.querySelector('video');
            var playIcon = slide.querySelector('.reel-play-state');
            var heartPop = slide.querySelector('.reel-heart-pop');
            var lastTap = 0;

            if (video) {
                video.addEventListener('click', function(e) {
                    var now = Date.now();
                    if (now - lastTap < 300) {
                        /* Double Tap Heart Like */
                        if (heartPop) {
                            heartPop.classList.add('active');
                            setTimeout(function() { heartPop.classList.remove('active'); }, 600);
                        }
                        var pId = slide.dataset.productId;
                        var p = (window.allProducts || []).find(function(x) { return x.id == pId; });
                        if (p && typeof window.toggleWishlistProduct === 'function') {
                            window.toggleWishlistProduct(p);
                            var wishBtn = slide.querySelector('.reel-wishlist-action .reel-action-btn-circle');
                            if (wishBtn) wishBtn.classList.add('liked');
                        }
                    } else {
                        /* Single Tap Play/Pause */
                        if (video.paused) {
                            video.play();
                            if (playIcon) playIcon.classList.remove('show');
                        } else {
                            video.pause();
                            if (playIcon) {
                                playIcon.classList.add('show');
                                setTimeout(function() { playIcon.classList.remove('show'); }, 900);
                            }
                        }
                    }
                    lastTap = now;
                });
            }

            /* Wishlist Click */
            var wishAction = slide.querySelector('.reel-wishlist-action');
            if (wishAction) {
                wishAction.addEventListener('click', function() {
                    var pId = slide.dataset.productId;
                    var p = (window.allProducts || []).find(function(x) { return x.id == pId; });
                    if (p && typeof window.toggleWishlistProduct === 'function') {
                        var added = window.toggleWishlistProduct(p);
                        var btnCircle = wishAction.querySelector('.reel-action-btn-circle');
                        if (btnCircle) btnCircle.classList.toggle('liked', added);
                        var lbl = wishAction.querySelector('.reel-action-label');
                        if (lbl) lbl.textContent = added ? 'Saved' : 'Save';
                        if (typeof window.showToast === 'function') window.showToast(added ? '♡ Saved to wishlist' : 'Removed from wishlist');
                    }
                });
            }

            /* Add To Bag Click */
            var atcBtns = slide.querySelectorAll('.reel-cart-action, .reel-buy-btn');
            atcBtns.forEach(function(atcBtn) {
                atcBtn.addEventListener('click', function() {
                    var pId = slide.dataset.productId;
                    var p = (window.allProducts || []).find(function(x) { return x.id == pId; });
                    if (!p || typeof window.addToCart !== 'function') return;

                    // The reel used to pass 'Free Size' when the product had no
                    // size variants, so a made-up size reached the order. Blank
                    // now means blank, and the product's own MOQ is honoured.
                    var sizes = (Array.isArray(p.size) ? p.size : (Array.isArray(p.sizes) ? p.sizes : []))
                        .filter(function(s) { return String(s || '').trim() !== ''; });
                    var colors = (Array.isArray(p.colors) ? p.colors : (p.color ? [p.color] : []))
                        .filter(function(c) { return String(c || '').trim() !== ''; });

                    window.addToCart(p, {
                        qty: Number(p.moq) > 1 ? Number(p.moq) : 1,
                        size: sizes.length ? sizes[0] : '',
                        color: colors.length ? colors[0] : ''
                    });
                });
            });

            /* WhatsApp 1-Click Enquiry */
            var waBtn = slide.querySelector('.reel-wa-action');
            if (waBtn) {
                waBtn.addEventListener('click', function() {
                    var pId = slide.dataset.productId;
                    var p = (window.allProducts || []).find(function(x) { return String(x.id) === String(pId); }) || {};
                    var pName = p.name || p.title || waBtn.dataset.name || 'Ethnic Saree / Attire';
                    var pPrice = Number(p.effective_customer_price || p.price || waBtn.dataset.price || 0);
                    var msg = 'Hello DT Brand\'s, I am watching your Live Draping Video for ' + pName + (pPrice > 0 ? ' (₹' + pPrice.toLocaleString('en-IN') + ')' : '') + '. Please share wholesale/lot availability and catalog details.';
                    window.open('https://api.whatsapp.com/send?phone=919006000000&text=' + encodeURIComponent(msg), '_blank');
                });
            }

            /* Share Action */
            var shareBtn = slide.querySelector('.reel-share-action');
            if (shareBtn) {
                shareBtn.addEventListener('click', function() {
                    var pName = shareBtn.dataset.name || '';
                    var pPrice = Number(shareBtn.dataset.price) || 0;
                    // Shared link points at the product, not at whichever page the
                    // reel happened to be opened from.
                    var pUrl = window.location.origin + '/product.php?id=' + encodeURIComponent(shareBtn.dataset.id || '');
                    var shareText = 'Check out ' + pName + (pPrice > 0 ? ' at ₹' + pPrice.toLocaleString('en-IN') : '') +
                                    ' on DT Brand\'s Ethnic Luxury!\n' + pUrl;

                    if (navigator.share) {
                        navigator.share({
                            title: pName + ' - DT Brand\'s',
                            text: shareText,
                            url: pUrl
                        }).catch(function() {});
                    } else {
                        if (navigator.clipboard) {
                            navigator.clipboard.writeText(shareText);
                        }
                        if (typeof window.showToast === 'function') {
                            window.showToast('🔗 Product link copied to clipboard!');
                        }
                    }
                });
            }
        });
    }

    /* Mute / Unmute Sound Toggle */
    document.addEventListener('DOMContentLoaded', function() {
        var closeBtn = document.getElementById('closeReelsBtn');
        if (closeBtn) closeBtn.addEventListener('click', window.closeReelsModal);

        var muteBtn = document.getElementById('reelsMuteBtn');
        if (muteBtn) {
            muteBtn.addEventListener('click', function() {
                isMuted = !isMuted;
                var track = document.getElementById('reelsTrack');
                if (track) {
                    track.querySelectorAll('video').forEach(function(v) {
                        v.muted = isMuted;
                    });
                }
                var muteIcon = document.getElementById('reelsMuteIcon');
                if (muteIcon) {
                    muteIcon.innerHTML = isMuted ?
                        '<polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line>' :
                        '<polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path>';
                }
            });
        }

        var overlay = document.getElementById('reelsModalOverlay');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) window.closeReelsModal();
            });
        }
    });
})();
</script>
