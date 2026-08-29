<?php
/**
 * smartshare.php — 1-Click Direct HD Media (Photos + Videos) Downloader & WhatsApp Share Engine
 * DT Brand's & Jai Hanuman Tex
 * 
 * In ONE SINGLE CLICK:
 *  1. Auto-downloads ALL available HD Product Photos & ALL available HD Videos DIRECTLY
 *     (as original individual .jpg / .mp4 files into the device's Downloads folder / Gallery).
 *  2. Auto-copies Full Luxury Formatted Product Details to Clipboard.
 *  3. Seamlessly Launches WhatsApp with formatted description pre-filled!
 *  4. Supports direct Web Share API with attached files on modern mobile devices.
 */
?>
<!-- Include JSZip for optional Archive Packaging -->
<script src="/assets/js/jszip.min.js"></script>

<style>
/* ── Floating Smart Share Quick Notification ── */
.smart-share-toast-banner {
    position: fixed;
    top: 24px;
    left: 50%;
    transform: translateX(-50%) translateY(-100px);
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(250, 245, 235, 0.98) 100%);
    -webkit-backdrop-filter: blur(16px);
    backdrop-filter: blur(16px);
    color: #111827;
    padding: 10px 18px 10px 14px;
    border-radius: 24px;
    box-shadow: 0 12px 36px rgba(138, 104, 31, 0.22), 0 4px 12px rgba(0,0,0,0.08), inset 0 1px 0 rgba(255,255,255,0.9);
    border: 1.5px solid rgba(212, 175, 55, 0.6);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 100000;
    font-family: 'Inter', 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: -0.011em;
    opacity: 0;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
    max-width: min(94vw, 480px);
    text-align: left;
}
.smart-share-toast-banner.active {
    transform: translateX(-50%) translateY(0);
    opacity: 1;
}
.smart-share-toast-icon {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #FAF5E8 0%, #F5ECCE 100%);
    border: 1.2px solid rgba(212, 175, 55, 0.7);
    color: #8A681F;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(138, 104, 31, 0.18);
}
.smart-share-toast-text {
    flex: 1;
    min-width: 0;
    line-height: 1.35;
    color: #1F2937;
}

/* ── Smart Share Modal Overlay ── */
.smart-share-overlay {
    position: fixed;
    inset: 0;
    background: rgba(18, 15, 10, 0.76);
    -webkit-backdrop-filter: blur(8px);
    backdrop-filter: blur(8px);
    z-index: 10000;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.smart-share-overlay.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}
.smart-share-sheet {
    width: 100%;
    max-width: 500px;
    background: #FFFFFF;
    border-radius: 20px 20px 0 0;
    box-shadow: 0 -8px 36px rgba(0,0,0,0.32);
    transform: translateY(100%);
    transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
    overflow: hidden;
    max-height: 92vh;
    display: flex;
    flex-direction: column;
    border-top: 3px solid #25D366;
}
.smart-share-overlay.active .smart-share-sheet {
    transform: translateY(0);
}
@media (min-width: 768px) {
    .smart-share-overlay {
        align-items: center;
        padding: 20px;
    }
    .smart-share-sheet {
        border-radius: 16px;
        transform: translateY(20px) scale(0.96);
        box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        max-height: 88vh;
        border: 1.5px solid #D4AF37;
    }
    .smart-share-overlay.active .smart-share-sheet {
        transform: translateY(0) scale(1);
    }
}
.smart-share-handle {
    width: 40px;
    height: 4px;
    background: #E0DDD8;
    border-radius: 3px;
    margin: 10px auto 4px;
}
@media (min-width: 768px) {
    .smart-share-handle { display: none; }
}
.smart-share-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    border-bottom: 1px solid #E5E3DE;
    background: #FAF8F4;
}
.smart-share-title-group {
    display: flex;
    align-items: center;
    gap: 8px;
}
.smart-share-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: linear-gradient(135deg, #15803D 0%, #16A34A 100%);
    color: #FFFFFF;
    font-size: 0.65rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    padding: 3px 8px;
    border-radius: 12px;
    text-transform: uppercase;
}
.smart-share-title {
    font-family: 'Cinzel', serif;
    font-size: 0.94rem;
    font-weight: 700;
    color: #181512;
    margin: 0;
}
.smart-share-close {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 1px solid #E5E3DE;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #5A5348;
    cursor: pointer;
    transition: all 0.2s ease;
}
.smart-share-close:hover {
    background: #8A681F;
    color: #FFFFFF;
    border-color: #8A681F;
}
.smart-share-product-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    background: #FFFFFF;
    border-bottom: 1px solid #E5E3DE;
}
.smart-share-thumb {
    width: 62px;
    height: 62px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #E5E3DE;
    background: #FAF8F4;
    flex-shrink: 0;
}
.smart-share-product-info {
    flex: 1;
    min-width: 0;
}
.smart-share-prod-name {
    font-family: 'Cinzel', serif;
    font-size: 0.88rem;
    font-weight: 700;
    color: #181512;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.smart-share-prod-meta {
    font-size: 0.70rem;
    color: #64748B;
    margin: 2px 0;
    font-weight: 500;
}
.smart-share-prod-price {
    display: flex;
    align-items: baseline;
    gap: 6px;
    font-family: 'Inter', sans-serif;
}
.smart-share-price-curr {
    font-size: 0.94rem;
    font-weight: 800;
    color: #8A681F;
}
.smart-share-price-old {
    font-size: 0.72rem;
    color: #94A3B8;
    text-decoration: line-through;
}
.smart-share-price-off {
    font-size: 0.60rem;
    font-weight: 800;
    color: #15803D;
    background: #DCFCE7;
    padding: 1px 6px;
    border-radius: 4px;
}
.smart-share-media-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #FAF5E8;
    border: 1px solid #D4AF37;
    color: #705114;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 6px;
    margin-top: 4px;
}
.smart-share-actions-wrap {
    padding: 14px 18px 18px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.smart-whatsapp-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 13px 18px;
    border-radius: 12px;
    background: linear-gradient(135deg, #15803D 0%, #16A34A 100%);
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    font-size: 0.88rem;
    font-weight: 800;
    border: 1px solid #14532D;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(22, 163, 74, 0.38);
    transition: all 0.25s ease;
}
.smart-whatsapp-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(22, 163, 74, 0.48);
    background: linear-gradient(135deg, #166534 0%, #15803D 100%);
}
.smart-whatsapp-btn svg {
    width: 22px;
    height: 22px;
    fill: currentColor;
    flex-shrink: 0;
}
.smart-share-sub-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}
.smart-share-opt-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border-radius: 10px;
    background: #FAF8F4;
    border: 1.5px solid #E5E3DE;
    color: #1F2937;
    font-size: 0.75rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}
.smart-share-opt-btn:hover {
    border-color: #8A681F;
    color: #705114;
    background: #FAF5E8;
    transform: translateY(-1px);
}
.smart-share-opt-btn svg {
    width: 15px;
    height: 15px;
    stroke: currentColor;
    stroke-width: 2.2;
    fill: none;
}
.smart-share-zip-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 6px 12px;
    background: transparent;
    border: 1px dashed #CBD5E1;
    color: #64748B;
    font-size: 0.70rem;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 2px;
}
.smart-share-zip-btn:hover {
    border-color: #8A681F;
    color: #8A681F;
    background: #FAF5E8;
}
</style>

<!-- Floating Luxury Toast Banner for 1-Click Execution -->
<div class="smart-share-toast-banner" id="smartShareToastBanner" role="status" aria-live="polite">
    <div class="smart-share-toast-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
    </div>
    <div class="smart-share-toast-text" id="smartShareToastMsg">All HD Photos &amp; Videos Downloaded Directly! Details Copied! Opening WhatsApp...</div>
</div>

<!-- Modal Dialog (Alternative / Detailed View) -->
<div class="smart-share-overlay" id="smartShareOverlay" onclick="if(event.target===this) window.closeSmartShareModal();" aria-modal="true" role="dialog" aria-label="Smart WhatsApp Share" aria-hidden="true" inert>
    <div class="smart-share-sheet">
        <div class="smart-share-handle"></div>
        <div class="smart-share-header">
            <div class="smart-share-title-group">
                <span class="smart-share-badge">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    1-Click Direct Media
                </span>
                <h3 class="smart-share-title">Smart WhatsApp Share</h3>
            </div>
            <button type="button" class="smart-share-close" onclick="window.closeSmartShareModal();" aria-label="Close">
                <svg width="14" height="14" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="smart-share-product-card">
            <img src="/assets/images/no-image.svg" alt="" class="smart-share-thumb" id="smartShareThumb" />
            <div class="smart-share-product-info">
                <div class="smart-share-prod-name" id="smartShareName"></div>
                <div class="smart-share-prod-meta" id="smartShareMeta"></div>
                <div class="smart-share-prod-price">
                    <span class="smart-share-price-curr" id="smartSharePrice"></span>
                    <span class="smart-share-price-old" id="smartShareOldPrice" style="display:none;"></span>
                    <span class="smart-share-price-off" id="smartShareDiscount" style="display:none;"></span>
                </div>
                <div class="smart-share-media-pill" id="smartShareMediaBadge">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span id="smartShareMediaCountText">Loading available media...</span>
                </div>
            </div>
        </div>
        <div class="smart-share-actions-wrap">
            <button type="button" class="smart-whatsapp-btn" id="smartShareMainBtn" onclick="window.executeSmartMeeshoShare();">
                <svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zM12.05 20.21c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.267 8.267 0 0 1-1.27-4.44c0-4.57 3.71-8.27 8.29-8.27 2.21 0 4.29.86 5.85 2.43a8.217 8.217 0 0 1 2.42 5.85c0 4.56-3.72 8.29-8.3 8.29zm4.54-6.2c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.25-1.5-1.4-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.4-.42-.56-.43h-.47c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.22.89 2.4 1.02 2.57.13.17 1.76 2.68 4.26 3.76.6.26 1.06.41 1.42.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.14-1.18-.06-.11-.22-.17-.47-.3z"/></svg>
                <span id="smartShareMainBtnText">1-Click Direct Download All &amp; Share</span>
            </button>
            <div class="smart-share-sub-grid">
                <button type="button" class="smart-share-opt-btn" id="smartShareDownloadOptBtn" onclick="window.downloadSmartProductMedia('direct');">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span id="smartShareDownloadOptText">Direct Download (JPG &amp; MP4)</span>
                </button>
                <button type="button" class="smart-share-opt-btn" onclick="window.copySmartProductText();">
                    <svg viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    <span>Copy Details</span>
                </button>
            </div>
            <button type="button" class="smart-share-zip-btn" onclick="window.downloadSmartProductMedia('zip');">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                <span>Download as Single ZIP Archive (0 Prompts)</span>
            </button>
        </div>
    </div>
</div>

<script>
/* ── MEESHO-STYLE 1-CLICK DIRECT HD MEDIA (PHOTOS + VIDEOS) DOWNLOAD & SHARE ENGINE ── */
(function() {
    'use strict';

    var currentShareItem = {
        id: 0,
        name: '',
        category: '',
        price: 0,
        old_price: 0,
        discount: 0,
        image: '',
        gallery: [],
        images: [],
        video: '',
        videos: [],
        fabric: '',
        colors: '',
        sizes: '',
        url: window.location.href
    };

    var NO_IMAGE = '/assets/images/no-image.svg';

    /* Helper: Ensure JSZip is loaded with fallback */
    function ensureJSZip(callback) {
        if (typeof window.JSZip !== 'undefined') {
            return callback(window.JSZip);
        }
        var s = document.createElement('script');
        s.src = '/assets/js/jszip.min.js';
        s.onload = function() { callback(window.JSZip); };
        s.onerror = function() {
            var cdn = document.createElement('script');
            cdn.src = 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js';
            cdn.onload = function() { callback(window.JSZip); };
            cdn.onerror = function() { callback(null); };
            document.head.appendChild(cdn);
        };
        document.head.appendChild(s);
    }

    /* Build the WhatsApp message from the fields the product actually has. */
    function buildFormattedWhatsAppMessage(item) {
        var price = Number(item.price) || 0;
        var oldPrice = Number(item.old_price) || 0;
        var discount = Number(item.discount) || 0;

        var msg = '👑 *DT BRAND\'S — ETHNIC LUXURY COUTURE*\n';
        if (item.name) msg += '✨ *' + item.name + '*\n';
        msg += '\n';
        if (price > 0) {
            msg += '🏷️ *Deal Price:* ₹' + price.toLocaleString('en-IN');
            if (oldPrice > price) {
                msg += ' ~₹' + oldPrice.toLocaleString('en-IN') + '~';
                if (discount > 0) msg += ' (' + discount + '% OFF)';
            }
            msg += '\n';
        } else {
            msg += '🏷️ *Price:* On Request\n';
        }
        if (item.fabric) msg += '🧵 *Fabric:* ' + item.fabric + '\n';
        if (item.colors) msg += '🎨 *Colours:* ' + item.colors + '\n';
        if (item.sizes) msg += '📏 *Sizes:* ' + item.sizes + '\n';
        msg += '\n';

        msg += '🌟 *Product Highlights:*\n';
        msg += '• 100% Original Certified Handloom Heritage\n';
        msg += '• ⚡ Fast Express Delivery (Dispatched in 24-48 Hours)\n';
        msg += '• 💎 7-Day Fast Doorstep Exchange\n';
        msg += '• 🎁 Complimentary Royal Box Packaging\n\n';

        var fullLink = item.fullUrl || item.url || window.location.href;
        if (!fullLink.startsWith('http')) {
            fullLink = window.location.origin + (fullLink.startsWith('/') ? '' : '/') + fullLink;
        }
        msg += '🔗 *View & Order Online:*\n' + fullLink + '\n\n';
        msg += '💬 *To Order on WhatsApp:* Reply here to book your order directly!';
        return msg;
    }

    /* Helper: Validate if string is a real valid photo URL */
    function isRealPhoto(src) {
        if (!src || typeof src !== 'string') return false;
        var s = src.trim();
        if (!s || s.indexOf('data:image') !== -1 || s.indexOf('no-image.svg') !== -1) return false;
        return true;
    }

    /* Helper: Validate if string is a real valid direct video file URL */
    function isRealVideo(src) {
        if (!src || typeof src !== 'string') return false;
        var s = src.trim();
        if (!s || s.indexOf('youtube.com') !== -1 || s.indexOf('youtu.be') !== -1 || s.indexOf('vimeo.com') !== -1) return false;
        return true;
    }

    /* Helper: Get File Extension */
    function getFileExtension(src, defaultExt) {
        var clean = String(src).split('?')[0].split('#')[0];
        var dot = clean.lastIndexOf('.');
        var ext = dot > -1 ? clean.substring(dot + 1).toLowerCase() : '';
        return ext || defaultExt;
    }

    /* Helper: Normalize URL to absolute */
    function normalizeMediaUrl(url) {
        if (!url || typeof url !== 'string') return '';
        var u = url.trim();
        if (u.startsWith('//')) return window.location.protocol + u;
        if (u.startsWith('http://') || u.startsWith('https://')) return u;
        if (u.startsWith('/')) return window.location.origin + u;
        return window.location.origin + '/' + u;
    }

    /* ── MASTER MEDIA COLLECTOR: Photos + Videos ── */
    function collectAllProductMedia(item) {
        var images = [];
        var videos = [];
        var sanitizedName = (item.name || 'product').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '') || 'product';

        // 1. Check primary image
        if (isRealPhoto(item.image)) {
            images.push(normalizeMediaUrl(item.image));
        }

        // 2. Check item.gallery and item.images arrays
        var rawGallery = [].concat(item.gallery || [], item.images || []);
        rawGallery.forEach(function(img) {
            if (isRealPhoto(img)) {
                var norm = normalizeMediaUrl(img);
                if (images.indexOf(norm) === -1) images.push(norm);
            }
        });

        // 3. Check item.video and item.videos arrays
        var rawVideos = [].concat(item.video ? [item.video] : [], item.videos || []);
        rawVideos.forEach(function(vid) {
            if (isRealVideo(vid)) {
                var norm = normalizeMediaUrl(vid);
                if (videos.indexOf(norm) === -1) videos.push(norm);
            }
        });

        // 4. Synchronously check window.allProducts / window.catalogProducts / window.products by ID
        var prodId = Number(item.id);
        if (prodId > 0 && Array.isArray(window.allProducts)) {
            var matched = window.allProducts.find(function(p) { return Number(p.id) === prodId; });
            if (matched) {
                if (isRealPhoto(matched.image)) {
                    var n = normalizeMediaUrl(matched.image);
                    if (images.indexOf(n) === -1) images.push(n);
                }
                var mGallery = [].concat(matched.gallery || [], matched.images || []);
                mGallery.forEach(function(img) {
                    if (isRealPhoto(img)) {
                        var n = normalizeMediaUrl(img);
                        if (images.indexOf(n) === -1) images.push(n);
                    }
                });
                var mVideos = [].concat(matched.video ? [matched.video] : [], matched.videos || []);
                mVideos.forEach(function(vid) {
                    if (isRealVideo(vid)) {
                        var n = normalizeMediaUrl(vid);
                        if (videos.indexOf(n) === -1) videos.push(n);
                    }
                });
            }
        }

        // 5. On PDP (Single Product Page), scan live DOM for any extra uploaded angles or videos
        var pdpImgDoms = document.querySelectorAll('.pdp-slider-track img, .pdp-slide img, .pdp-thumb-item img, .pdp-gallery-column img');
        pdpImgDoms.forEach(function(img) {
            var src = img.currentSrc || img.src || img.getAttribute('src');
            if (isRealPhoto(src)) {
                var n = normalizeMediaUrl(src);
                if (images.indexOf(n) === -1) images.push(n);
            }
        });

        var pdpVidDoms = document.querySelectorAll('.pdp-slide video source, .pdp-slide video, video[data-pdp-video]');
        pdpVidDoms.forEach(function(vid) {
            var src = vid.src || vid.getAttribute('src') || vid.currentSrc;
            if (isRealVideo(src)) {
                var n = normalizeMediaUrl(src);
                if (videos.indexOf(n) === -1) videos.push(n);
            }
        });

        if (Array.isArray(window.pdpVideos)) {
            window.pdpVideos.forEach(function(v) {
                if (isRealVideo(v)) {
                    var n = normalizeMediaUrl(v);
                    if (videos.indexOf(n) === -1) videos.push(n);
                }
            });
        }

        return {
            slug: sanitizedName,
            images: images,
            videos: videos,
            total: images.length + videos.length
        };
    }

    /* Single File Direct Download Helper via Blob for Original HD Quality */
    function triggerSingleDownload(url, filename) {
        return fetch(url)
            .then(function(res) {
                if (!res.ok) throw new Error('Fetch failed: ' + res.status);
                return res.blob();
            })
            .then(function(blob) {
                var blobUrl = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = blobUrl;
                a.download = filename;
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                setTimeout(function() { URL.revokeObjectURL(blobUrl); }, 1500);
            })
            .catch(function() {
                var a = document.createElement('a');
                a.href = url;
                a.download = filename;
                a.target = '_blank';
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });
    }

    /* ── MASTER 1-CLICK DIRECT HD MEDIA (PHOTOS + VIDEOS) DOWNLOADER (NO ZIP) ── */
    function downloadDirectProductMedia(item) {
        var media = collectAllProductMedia(item);
        var total = media.total;

        if (total === 0) {
            showShareToast('📸 No photos or videos uploaded for this product yet.');
            return Promise.resolve({ success: false, total: 0 });
        }

        var itemsToDownload = [];
        media.images.forEach(function(imgUrl, idx) {
            var ext = getFileExtension(imgUrl, 'jpg');
            itemsToDownload.push({
                url: imgUrl,
                filename: media.slug + '-' + (idx + 1) + '.' + ext,
                type: 'image'
            });
        });

        media.videos.forEach(function(vidUrl, idx) {
            var ext = getFileExtension(vidUrl, 'mp4');
            itemsToDownload.push({
                url: vidUrl,
                filename: media.slug + '-video-' + (idx + 1) + '.' + ext,
                type: 'video'
            });
        });

        showShareToast('📥 Downloading ' + media.images.length + ' Photo' + (media.images.length === 1 ? '' : 's') + (media.videos.length ? (' & ' + media.videos.length + ' Video' + (media.videos.length === 1 ? '' : 's')) : '') + ' directly... (Click "Allow" once if browser asks)');

        var completed = 0;
        return new Promise(function(resolve) {
            itemsToDownload.forEach(function(fileItem, index) {
                setTimeout(function() {
                    triggerSingleDownload(fileItem.url, fileItem.filename).then(function() {
                        completed++;
                        if (completed === total) {
                            showShareToast('✅ All ' + total + ' HD Photos & Videos Downloaded to your device!');
                            resolve({ success: true, total: total, type: 'direct' });
                        }
                    });
                }, index * 220); // 220ms staggered delay ensures browser downloads 100% of files without dropping!
            });
        });
    }

    /* ── OPTIONAL ZIP DOWNLOAD ENGINE (FOR USERS WHO EXPLICITLY WANT A ZIP) ── */
    function downloadZipProductMedia(item, onProgress) {
        var media = collectAllProductMedia(item);
        var total = media.total;

        if (total === 0) {
            showShareToast('📸 No photos or videos uploaded for this product yet.');
            return Promise.resolve({ success: false, total: 0 });
        }

        if (total === 1) {
            return downloadDirectProductMedia(item);
        }

        showShareToast('⚡ Packaging ' + media.images.length + ' Photos & ' + media.videos.length + ' Videos into ZIP...');

        return new Promise(function(resolve) {
            ensureJSZip(function(JSZip) {
                if (!JSZip) {
                    window.location.href = '/api/download_product_media.php?id=' + (item.id || 0);
                    return resolve({ success: true, total: total, type: 'server_zip' });
                }

                var zip = new JSZip();
                var detailsText = buildFormattedWhatsAppMessage(item);
                zip.file('Product-Details.txt', detailsText);

                var fetchPromises = [];

                media.images.forEach(function(imgUrl, idx) {
                    var ext = getFileExtension(imgUrl, 'jpg');
                    var entryName = media.slug + '-' + (idx + 1) + '.' + ext;
                    var p = fetch(imgUrl)
                        .then(function(r) { return r.ok ? r.blob() : null; })
                        .then(function(blob) {
                            if (blob) zip.file(entryName, blob);
                        })
                        .catch(function() {});
                    fetchPromises.push(p);
                });

                media.videos.forEach(function(vidUrl, idx) {
                    var ext = getFileExtension(vidUrl, 'mp4');
                    var entryName = media.slug + '-video-' + (idx + 1) + '.' + ext;
                    var p = fetch(vidUrl)
                        .then(function(r) { return r.ok ? r.blob() : null; })
                        .then(function(blob) {
                            if (blob) zip.file(entryName, blob);
                        })
                        .catch(function() {});
                    fetchPromises.push(p);
                });

                Promise.all(fetchPromises).then(function() {
                    zip.generateAsync({ type: 'blob' }, function(metadata) {
                        if (typeof onProgress === 'function') onProgress(metadata.percent);
                    }).then(function(zipBlob) {
                        var blobUrl = URL.createObjectURL(zipBlob);
                        var a = document.createElement('a');
                        a.href = blobUrl;
                        a.download = media.slug + '-Catalog-Media.zip';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        setTimeout(function() { URL.revokeObjectURL(blobUrl); }, 1200);

                        showShareToast('✅ All ' + media.images.length + ' Photos & ' + media.videos.length + ' Videos Downloaded in 1 ZIP!');
                        resolve({ success: true, total: total, type: 'client_zip' });
                    }).catch(function(err) {
                        if (item.id) {
                            window.location.href = '/api/download_product_media.php?id=' + item.id;
                        }
                        resolve({ success: false, error: err });
                    });
                });
            });
        });
    }

    /* Show floating banner toast */
    function showShareToast(msg) {
        var banner = document.getElementById('smartShareToastBanner');
        var msgEl = document.getElementById('smartShareToastMsg');
        if (msgEl) msgEl.textContent = msg;
        if (banner) {
            banner.classList.add('active');
            setTimeout(function() { banner.classList.remove('active'); }, 3500);
        }
    }

    function fallbackCopyText(text) {
        var t = document.createElement('textarea');
        t.value = text;
        document.body.appendChild(t);
        t.select();
        document.execCommand('copy');
        document.body.removeChild(t);
    }

    /* 🟢 THE ULTIMATE 1-CLICK DIRECT ALL MEDIA (PHOTOS + VIDEOS) DOWNLOAD & WHATSAPP SHARE */
    window.oneClickAllDownloadAndShare = function(itemData) {
        var item = Object.assign({}, currentShareItem, itemData || {});
        currentShareItem = item;

        // 1. Direct Auto-Download ALL HD Photos & ALL HD Videos as real individual files (.jpg & .mp4)
        downloadDirectProductMedia(item);

        // 2. Auto-Copy Formatted Details to Clipboard
        var formattedText = buildFormattedWhatsAppMessage(item);
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(formattedText).catch(function() {
                fallbackCopyText(formattedText);
            });
        } else {
            fallbackCopyText(formattedText);
        }

        // 3. Launch WhatsApp in 1 Click!
        setTimeout(function() {
            var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(formattedText);
            window.open(waUrl, '_blank');
        }, 600);
    };

    /* 🟢 Open Smart Share Modal with Product Snapshot */
    window.openSmartShareModal = function(itemData) {
        if (itemData) {
            currentShareItem = Object.assign({}, currentShareItem, itemData);
        }

        // Update modal UI elements
        var thumb = document.getElementById('smartShareThumb');
        var name = document.getElementById('smartShareName');
        var meta = document.getElementById('smartShareMeta');
        var price = document.getElementById('smartSharePrice');
        var oldPrice = document.getElementById('smartShareOldPrice');
        var disc = document.getElementById('smartShareDiscount');
        var mediaCountText = document.getElementById('smartShareMediaCountText');

        if (thumb) {
            thumb.src = isRealPhoto(currentShareItem.image) ? currentShareItem.image : NO_IMAGE;
            thumb.alt = currentShareItem.name || '';
        }
        if (name) name.textContent = currentShareItem.name || 'Ethnic Luxury Outfit';
        if (meta) {
            var metaBits = [];
            if (currentShareItem.fabric) metaBits.push('Fabric: ' + currentShareItem.fabric);
            if (currentShareItem.sizes) metaBits.push(currentShareItem.sizes);
            if (!metaBits.length && currentShareItem.category) metaBits.push(currentShareItem.category);
            meta.textContent = metaBits.join(' • ');
            meta.style.display = metaBits.length ? '' : 'none';
        }
        var shPrice = Number(currentShareItem.price) || 0;
        var shOld = Number(currentShareItem.old_price) || 0;
        var shDisc = Number(currentShareItem.discount) || 0;
        if (price) price.textContent = shPrice > 0 ? '₹' + shPrice.toLocaleString('en-IN') : 'Price on request';
        if (oldPrice) {
            if (shPrice > 0 && shOld > shPrice) {
                oldPrice.textContent = '₹' + shOld.toLocaleString('en-IN');
                oldPrice.style.display = 'inline';
            } else {
                oldPrice.style.display = 'none';
            }
        }
        if (disc) {
            if (shPrice > 0 && shOld > shPrice && shDisc > 0) {
                disc.textContent = shDisc + '% OFF';
                disc.style.display = 'inline';
            } else {
                disc.style.display = 'none';
            }
        }

        // Update Media Counter Badge
        var mediaStats = collectAllProductMedia(currentShareItem);
        if (mediaCountText) {
            var bits = [];
            if (mediaStats.images.length > 0) {
                bits.push(mediaStats.images.length + ' HD Photo' + (mediaStats.images.length > 1 ? 's' : ''));
            }
            if (mediaStats.videos.length > 0) {
                bits.push(mediaStats.videos.length + ' HD Video' + (mediaStats.videos.length > 1 ? 's' : ''));
            }
            if (bits.length === 0) {
                mediaCountText.textContent = 'No media uploaded yet';
            } else {
                mediaCountText.textContent = bits.join(' • ') + ' (Direct 1-Click Download Ready)';
            }
        }

        var resolvedUrl = currentShareItem.url || window.location.href;
        if (!resolvedUrl.startsWith('http')) {
            resolvedUrl = window.location.origin + (resolvedUrl.startsWith('/') ? '' : '/') + resolvedUrl;
        }
        currentShareItem.fullUrl = resolvedUrl;

        // Open the Popup Modal
        var overlay = document.getElementById('smartShareOverlay');
        if (overlay) {
            overlay.removeAttribute('inert');
            overlay.setAttribute('aria-hidden', 'false');
            overlay.classList.add('active');
        }
    };

    window.closeSmartShareModal = function() {
        var overlay = document.getElementById('smartShareOverlay');
        if (overlay) {
            if (document.activeElement && overlay.contains(document.activeElement)) {
                document.activeElement.blur();
            }
            overlay.classList.remove('active');
            overlay.setAttribute('aria-hidden', 'true');
            overlay.setAttribute('inert', '');
        }
    };

    /* 🟢 1-Click Direct Download & WhatsApp Share from Modal */
    window.executeSmartMeeshoShare = function() {
        window.closeSmartShareModal();
        window.oneClickAllDownloadAndShare(currentShareItem);
    };

    /* 🟢 Download All Product Media (Direct Files by default or ZIP if specified) */
    window.downloadSmartProductMedia = function(type) {
        if (type === 'zip') {
            downloadZipProductMedia(currentShareItem);
        } else {
            downloadDirectProductMedia(currentShareItem);
        }
    };

    /* 🟢 Copy Product Details to Clipboard */
    window.copySmartProductText = function() {
        var formattedText = buildFormattedWhatsAppMessage(currentShareItem);
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(formattedText).then(function() {
                showShareToast('📋 Full Product Details Copied to Clipboard!');
            }).catch(function() {
                fallbackCopyText(formattedText);
                showShareToast('📋 Full Product Details Copied to Clipboard!');
            });
        } else {
            fallbackCopyText(formattedText);
            showShareToast('📋 Full Product Details Copied to Clipboard!');
        }
    };

})();
</script>
