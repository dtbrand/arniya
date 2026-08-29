<?php
/**
 * smartshare.php — Next-Level 1-Click Meesho-Style WhatsApp Share Engine
 * In ONE SINGLE CLICK:
 *  1. Auto-downloads ALL HD Product Photos & Media to device.
 *  2. Auto-copies Full Luxury Formatted Product Details to Clipboard.
 *  3. Seamlessly Launches WhatsApp with formatted description pre-filled!
 */
?>
<style>
/* ── Floating Smart Share Quick Notification ── */
.smart-share-toast-banner {
    position: fixed;
    top: 24px;
    left: 50%;
    transform: translateX(-50%) translateY(-100px);
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.97) 0%, rgba(250, 245, 235, 0.98) 100%);
    -webkit-backdrop-filter: blur(16px);
    backdrop-filter: blur(16px);
    color: #1C1917;
    padding: 10px 18px 10px 14px;
    border-radius: 24px;
    box-shadow: 0 12px 36px rgba(138, 104, 31, 0.18), 0 4px 12px rgba(0,0,0,0.05), inset 0 1px 0 rgba(255,255,255,0.8);
    border: 1.5px solid rgba(212, 175, 55, 0.45);
    display: flex;
    align-items: center;
    gap: 12px;
    z-index: 100000;
    font-family: var(--font-sans, 'Plus Jakarta Sans', sans-serif);
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.01em;
    opacity: 0;
    transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    pointer-events: none;
    max-width: min(92vw, 440px);
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
    border: 1.2px solid rgba(212, 175, 55, 0.6);
    color: #8A681F;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(138, 104, 31, 0.15);
}

/* ── Smart Share Modal Overlay ── */
.smart-share-overlay {
    position: fixed;
    inset: 0;
    background: rgba(18, 15, 10, 0.72);
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
    box-shadow: 0 -8px 36px rgba(0,0,0,0.28);
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
        border-radius: 18px;
        transform: translateY(20px) scale(0.96);
        box-shadow: 0 20px 60px rgba(0,0,0,0.32);
        max-height: 88vh;
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
    border-bottom: 1px solid var(--soft-platinum, #E5E3DE);
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
    background: #25D366;
    color: #FFFFFF;
    font-size: 0.65rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    padding: 3px 8px;
    border-radius: 12px;
    text-transform: uppercase;
}
.smart-share-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 0.94rem;
    font-weight: 700;
    color: var(--dark-text, #24211C);
}
.smart-share-close {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 1px solid var(--soft-platinum, #E5E3DE);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--mid-text, #5A5348);
    cursor: pointer;
    transition: all 0.2s ease;
}
.smart-share-close:hover {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
}
.smart-share-product-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    background: #FFFFFF;
    border-bottom: 1px solid var(--soft-platinum, #E5E3DE);
}
.smart-share-thumb {
    width: 58px;
    height: 58px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    flex-shrink: 0;
}
.smart-share-product-info {
    flex: 1;
    min-width: 0;
}
.smart-share-prod-name {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 0.86rem;
    font-weight: 700;
    color: var(--dark-text, #24211C);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.smart-share-prod-meta {
    font-size: 0.68rem;
    color: var(--mid-text, #5A5348);
    margin: 2px 0;
}
.smart-share-prod-price {
    display: flex;
    align-items: baseline;
    gap: 6px;
    font-family: var(--font-sans, 'Inter', sans-serif);
}
.smart-share-price-curr {
    font-size: 0.92rem;
    font-weight: 800;
    color: var(--dark-gold, #8A681F);
}
.smart-share-price-old {
    font-size: 0.70rem;
    color: var(--light-text, #9A9490);
    text-decoration: line-through;
}
.smart-share-price-off {
    font-size: 0.58rem;
    font-weight: 700;
    color: #2E7D32;
    background: #E8F5E9;
    padding: 1px 5px;
    border-radius: 4px;
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
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #FFFFFF;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.88rem;
    font-weight: 800;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(37, 211, 102, 0.38);
    transition: all 0.25s ease;
}
.smart-whatsapp-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(37, 211, 102, 0.48);
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
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    color: var(--dark-text, #24211C);
    font-size: 0.74rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
}
.smart-share-opt-btn:hover {
    border-color: var(--dark-gold, #8A681F);
    color: var(--dark-gold, #8A681F);
    background: #FFFFFF;
}
.smart-share-opt-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}
</style>

<!-- Floating Luxury Toast Banner for 1-Click Execution -->
<div class="smart-share-toast-banner" id="smartShareToastBanner" role="status" aria-live="polite">
    <div class="smart-share-toast-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="animation: toastSparkleSpin 3s infinite linear;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
    </div>
    <span id="smartShareToastMsg">All HD Photos Downloaded! Details Copied! Opening WhatsApp...</span>
</div>

<!-- Modal Dialog (Alternative / Detailed View) -->
<div class="smart-share-overlay" id="smartShareOverlay" onclick="if(event.target===this) window.closeSmartShareModal();" aria-modal="true" role="dialog" aria-label="Smart WhatsApp Share" aria-hidden="true" inert>
    <div class="smart-share-sheet">
        <div class="smart-share-handle"></div>
        <div class="smart-share-header">
            <div class="smart-share-title-group">
                <span class="smart-share-badge">⚡ 1-Click Share</span>
                <h3 class="smart-share-title">Smart WhatsApp Share</h3>
            </div>
            <button type="button" class="smart-share-close" onclick="window.closeSmartShareModal();" aria-label="Close">
                <svg width="14" height="14" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="smart-share-product-card">
            <img src="/Shared/Asset/images/product1.png" alt="Product" class="smart-share-thumb" id="smartShareThumb" />
            <div class="smart-share-product-info">
                <div class="smart-share-prod-name" id="smartShareName">Nilambari Silk Saree</div>
                <div class="smart-share-prod-meta" id="smartShareMeta">Fabric: Pure Silk • Free Size</div>
                <div class="smart-share-prod-price">
                    <span class="smart-share-price-curr" id="smartSharePrice">₹4,899</span>
                    <span class="smart-share-price-old" id="smartShareOldPrice">₹6,500</span>
                    <span class="smart-share-price-off" id="smartShareDiscount">25% OFF</span>
                </div>
            </div>
        </div>
        <div class="smart-share-actions-wrap">
            <button type="button" class="smart-whatsapp-btn" onclick="window.executeSmartMeeshoShare();">
                <svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zM12.05 20.21c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.267 8.267 0 0 1-1.27-4.44c0-4.57 3.71-8.27 8.29-8.27 2.21 0 4.29.86 5.85 2.43a8.217 8.217 0 0 1 2.42 5.85c0 4.56-3.72 8.29-8.3 8.29zm4.54-6.2c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.25-1.5-1.4-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.4-.42-.56-.43h-.47c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.22.89 2.4 1.02 2.57.13.17 1.76 2.68 4.26 3.76.6.26 1.06.41 1.42.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.14-1.18-.06-.11-.22-.17-.47-.3z"/></svg>
                <span>1-Click Download Photos &amp; Share</span>
            </button>
            <div class="smart-share-sub-grid">
                <button type="button" class="smart-share-opt-btn" onclick="window.downloadSmartProductMedia();">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download Photos</span>
                </button>
                <button type="button" class="smart-share-opt-btn" onclick="window.copySmartProductText();">
                    <svg viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    <span>Copy Details</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
/* ── MEESHO-STYLE 1-CLICK AUTO DOWNLOAD & SHARE ENGINE ── */
(function() {
    'use strict';

    var currentShareItem = {
        id: 1,
        name: 'Nilambari Silk Saree',
        category: 'Sarees',
        price: 4899,
        old_price: 6500,
        discount: 25,
        image: '/Shared/Asset/images/product1.png',
        fabric: 'Pure Silk',
        colors: 'Navy, Royal Blue',
        sizes: 'Free Size, M, L',
        url: window.location.href
    };

    /* Build Rich Meesho-Style Formatted WhatsApp Message */
    function buildFormattedWhatsAppMessage(item) {
        var msg = '👑 *DT BRAND\'S — ETHNIC LUXURY COUTURE*\n';
        msg += '✨ *' + (item.name || 'Luxury Saree') + '*\n\n';
        msg += '🏷️ *Deal Price:* ₹' + Number(item.price || 0).toLocaleString('en-IN');
        if (item.old_price) {
            msg += ' ~₹' + Number(item.old_price).toLocaleString('en-IN') + '~';
        }
        if (item.discount) {
            msg += ' (' + item.discount + '% OFF)';
        }
        msg += '\n';
        if (item.fabric) msg += '🧵 *Fabric:* ' + item.fabric + '\n';
        if (item.colors) msg += '🎨 *Colours:* ' + item.colors + '\n';
        if (item.sizes) msg += '📏 *Sizes:* ' + item.sizes + '\n\n';

        msg += '🌟 *Product Highlights:*\n';
        msg += '• 100% Original Certified Handloom Heritage\n';
        msg += '• ⚡ Fast Express Delivery (Dispatched in 24-48 Hours)\n';
        msg += '• 💎 7-Day Fast Doorstep Exchange\n';
        msg += '• 🎁 Complimentary Royal Box Packaging\n\n';

        var fullLink = item.fullUrl || item.url || window.location.href;
        if (!fullLink.startsWith('http')) {
            fullLink = window.location.origin + window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/') + 1) + fullLink;
        }
        msg += '🔗 *View & Order Online:*\n' + fullLink + '\n\n';
        msg += '💬 *To Order on WhatsApp:* Reply here to book your order directly!';
        return msg;
    }

    /* Single Photo Download Helper */
    function triggerDownload(url, filename) {
        return fetch(url)
            .then(function(res) { return res.blob(); })
            .then(function(blob) {
                var blobUrl = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = blobUrl;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                setTimeout(function() { URL.revokeObjectURL(blobUrl); }, 300);
            })
            .catch(function() {
                var a = document.createElement('a');
                a.href = url;
                a.download = filename;
                a.target = '_blank';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
            });
    }

    /* Batch Download All HD Photos of Product */
    function downloadAllProductPhotos(item) {
        var sanitizedName = (item.name || 'product').toLowerCase().replace(/[^a-z0-9]/g, '-');
        var imagesToDownload = [
            item.image || '/Shared/Asset/images/product1.png'
        ];

        // If on PDP with gallery, include all gallery angles
        var galleryDoms = document.querySelectorAll('.pdp-gallery-slide img, .pdp-thumb-img');
        if (galleryDoms && galleryDoms.length > 0) {
            galleryDoms.forEach(function(img) {
                if (img.src && imagesToDownload.indexOf(img.src) === -1 && !img.src.includes('data:image')) {
                    imagesToDownload.push(img.src);
                }
            });
        }

        // Trigger downloads with 150ms delay between files
        imagesToDownload.forEach(function(imgUrl, idx) {
            setTimeout(function() {
                triggerDownload(imgUrl, sanitizedName + '-hd-angle-' + (idx + 1) + '.png');
            }, idx * 180);
        });
    }

    /* Show floating banner toast */
    function showShareToast(msg) {
        var banner = document.getElementById('smartShareToastBanner');
        var msgEl = document.getElementById('smartShareToastMsg');
        if (msgEl) msgEl.textContent = msg;
        if (banner) {
            banner.classList.add('active');
            setTimeout(function() { banner.classList.remove('active'); }, 3000);
        }
    }

    /* 🟢 THE ULTIMATE 1-CLICK ALL DOWNLOAD & WHATSAPP SHARE FUNCTION */
    window.oneClickAllDownloadAndShare = function(itemData) {
        var item = Object.assign({}, currentShareItem, itemData || {});
        currentShareItem = item;

        // 1. Auto-Download All HD Photos & Video
        downloadAllProductPhotos(item);

        // 2. Auto-Copy Formatted Details to Clipboard
        var formattedText = buildFormattedWhatsAppMessage(item);
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(formattedText).catch(function() {
                fallbackCopyText(formattedText);
            });
        } else {
            fallbackCopyText(formattedText);
        }

        // 3. Show Toast & Launch WhatsApp in 1 Click!
        showShareToast('⚡ 1-Click Share: HD Photos Downloaded! Details Copied! Opening WhatsApp...');

        setTimeout(function() {
            var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(formattedText);
            window.open(waUrl, '_blank');
        }, 500);
    };

    function fallbackCopyText(text) {
        var t = document.createElement('textarea');
        t.value = text;
        document.body.appendChild(t);
        t.select();
        document.execCommand('copy');
        document.body.removeChild(t);
    }
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

        if (thumb) thumb.src = currentShareItem.image || '/Shared/Asset/images/product1.png';
        if (name) name.textContent = currentShareItem.name || 'Luxury Outfit';
        if (meta) meta.textContent = (currentShareItem.fabric ? 'Fabric: ' + currentShareItem.fabric : 'Ethnic Luxury') + ' • ' + (currentShareItem.sizes || 'Free Size');
        if (price) price.textContent = '₹' + Number(currentShareItem.price || 0).toLocaleString('en-IN');
        if (oldPrice) {
            if (currentShareItem.old_price) {
                oldPrice.textContent = '₹' + Number(currentShareItem.old_price).toLocaleString('en-IN');
                oldPrice.style.display = 'inline';
            } else {
                oldPrice.style.display = 'none';
            }
        }
        if (disc) {
            if (currentShareItem.discount) {
                disc.textContent = currentShareItem.discount + '% OFF';
                disc.style.display = 'inline';
            } else {
                disc.style.display = 'none';
            }
        }

        var resolvedUrl = currentShareItem.url || window.location.href;
        if (!resolvedUrl.startsWith('http')) {
            resolvedUrl = window.location.origin + window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/') + 1) + resolvedUrl;
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

    /* 🟢 1-Click Batch Download & WhatsApp Share from Modal */
    window.executeSmartMeeshoShare = function() {
        window.closeSmartShareModal();
        window.oneClickAllDownloadAndShare(currentShareItem);
    };

    window.downloadSmartProductMedia = function() {
        downloadAllProductPhotos(currentShareItem);
        showShareToast('📸 Downloading All HD Photos...');
    };

    window.copySmartProductText = function() {
        var formattedText = buildFormattedWhatsAppMessage(currentShareItem);
        fallbackCopyText(formattedText);
        showShareToast('📋 Full Product Details Copied to Clipboard!');
    };

})();
</script>
