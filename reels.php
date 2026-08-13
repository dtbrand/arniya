<?php
/**
 * reels.php — PARTIAL INCLUDE
 * Instagram Reels / TikTok Style Shoppable Full-Screen Video Feed for Kalaniketan
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
<div class="reels-overlay" id="reelsModalOverlay" role="dialog" aria-modal="true" aria-label="Kalaniketan Video Reels" aria-hidden="true">
    <div class="reels-wrapper" id="reelsWrapper">
        
        <!-- Top Bar Header -->
        <div class="reels-top-bar">
            <div class="reels-brand-tag">
                <span class="reels-live-dot"></span>
                <span>Kalaniketan Reels</span>
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
/* ── Kalaniketan Instagram Reels Controller Engine ── */
(function() {
    var reelsVideos = [
        'https://assets.mixkit.co/videos/preview/mixkit-woman-modeling-a-traditional-indian-dress-41312-large.mp4',
        'https://assets.mixkit.co/videos/preview/mixkit-beautiful-woman-wearing-a-sari-and-jewelry-41315-large.mp4',
        'https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-ethnic-sari-41317-large.mp4',
        'https://assets.mixkit.co/videos/preview/mixkit-bride-wearing-a-traditional-indian-dress-41319-large.mp4',
        'https://assets.mixkit.co/videos/preview/mixkit-young-woman-in-a-traditional-sari-41314-large.mp4',
        'https://assets.mixkit.co/videos/preview/mixkit-model-posing-in-traditional-dress-41316-large.mp4',
        'https://assets.mixkit.co/videos/preview/mixkit-indian-bride-posing-in-traditional-outfit-41318-large.mp4',
        'https://assets.mixkit.co/videos/preview/mixkit-traditional-indian-garment-fabric-close-up-41313-large.mp4'
    ];

    var isMuted = true;

    window.openReelsModal = function(startIndex) {
        var overlay = document.getElementById('reelsModalOverlay');
        var track = document.getElementById('reelsTrack');
        if (!overlay || !track) return;

        var products = window.allProducts || [];
        if (products.length === 0) return;

        /* Build Slides */
        track.innerHTML = products.map(function(p, idx) {
            var videoSrc = reelsVideos[idx % reelsVideos.length];
            var sizeArr = Array.isArray(p.size) ? p.size : ['Free Size'];
            var isWish = Array.isArray(window.wishlistState) && window.wishlistState.some(function(item) { return item.id == p.id; });
            var likesCount = (1.2 + (p.id * 0.3)).toFixed(1) + 'k';

            return '<div class="reel-slide" data-index="' + idx + '" data-product-id="' + p.id + '">' +
                '<!-- Background Video -->' +
                '<video class="reel-video" loop playsinline preload="auto" poster="' + p.image + '" muted>' +
                    '<source src="' + videoSrc + '" type="video/mp4">' +
                '</video>' +

                '<!-- Heart Pop Animation -->' +
                '<svg class="reel-heart-pop" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>' +

                '<!-- Play/Pause Indicator -->' +
                '<div class="reel-play-state">' +
                    '<svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>' +
                '</div>' +

                '<!-- Right-Side Instagram Action Bar -->' +
                '<div class="reel-actions-bar">' +
                    '<button class="reel-action-item reel-wishlist-action" data-id="' + p.id + '" aria-label="Wishlist">' +
                        '<div class="reel-action-btn-circle ' + (isWish ? 'liked' : '') + '">' +
                            '<svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>' +
                        '</div>' +
                        '<span class="reel-action-label reel-likes-count">' + likesCount + '</span>' +
                    '</button>' +

                    '<button class="reel-action-item reel-cart-action" data-id="' + p.id + '" aria-label="Add to Bag">' +
                        '<div class="reel-action-btn-circle">' +
                            '<svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>' +
                        '</div>' +
                        '<span class="reel-action-label">Add Bag</span>' +
                    '</button>' +

                    '<button class="reel-action-item reel-share-action" data-name="' + p.name + '" data-price="' + p.price + '" aria-label="Share">' +
                        '<div class="reel-action-btn-circle">' +
                            '<svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>' +
                        '</div>' +
                        '<span class="reel-action-label">Share</span>' +
                    '</button>' +
                '</div>' +

                '<!-- Bottom Info Overlay -->' +
                '<div class="reel-bottom-info">' +
                    '<h3 class="reel-product-title">' + p.name + '</h3>' +

                    '<div class="reel-price-row">' +
                        '<span class="reel-price-val">₹' + Number(p.price).toLocaleString('en-IN') + '</span>' +
                        (p.old_price ? '<span class="reel-old-price">₹' + Number(p.old_price).toLocaleString('en-IN') + '</span>' : '') +
                        (p.discount ? '<span class="reel-discount-badge">' + p.discount + '% OFF</span>' : '') +
                    '</div>' +

                    '<div class="reel-bottom-cta-row">' +
                        '<button class="reel-atc-cta-btn reel-buy-btn" data-id="' + p.id + '">' +
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

        overlay.classList.add('open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        /* Bind Interactive Events */
        bindReelsEvents();

        /* Scroll to target slide */
        var targetIndex = typeof startIndex === 'number' ? startIndex : 0;
        var slides = track.querySelectorAll('.reel-slide');
        if (slides[targetIndex]) {
            slides[targetIndex].scrollIntoView();
            playSlide(slides[targetIndex]);
        }
    };

    window.closeReelsModal = function() {
        var overlay = document.getElementById('reelsModalOverlay');
        if (overlay) {
            overlay.classList.remove('open');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';

            /* Pause all videos */
            var track = document.getElementById('reelsTrack');
            if (track) {
                track.querySelectorAll('video').forEach(function(v) {
                    v.pause();
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
                    var defaultSize = p && Array.isArray(p.size) && p.size.length > 0 ? p.size[0] : 'Free Size';

                    if (p && typeof window.addToCart === 'function') {
                        window.addToCart(p, defaultSize);
                    }
                });
            });

            /* Share Action */
            var shareBtn = slide.querySelector('.reel-share-action');
            if (shareBtn) {
                shareBtn.addEventListener('click', function() {
                    var pName = shareBtn.dataset.name;
                    var pPrice = shareBtn.dataset.price;
                    var shareText = '✨ Check out ' + pName + ' at ₹' + Number(pPrice).toLocaleString('en-IN') + ' on Kalaniketan Ethnic Luxury!\n' + window.location.href;

                    if (navigator.share) {
                        navigator.share({
                            title: pName + ' - Kalaniketan',
                            text: shareText,
                            url: window.location.href
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
