<?php
/**
 * smartshare.php — Meesho-Grade Smart WhatsApp Product Share Engine
 * Features:
 *  1. 1-Click Smart WhatsApp Share (Auto-downloads HD photos, copies formatted product details, opens WhatsApp).
 *  2. Web Share API Level 2 support (Direct file attachment to WhatsApp on supported mobile browsers).
 *  3. Batch HD Photo & Media Downloader.
 *  4. Copy Formatted Luxury Product Details.
 *  5. Copy Direct Product Link.
 */
?>
<style>
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.smart-share-overlay.active {
    opacity: 1;
    visibility: visible;
}

/* ── Modal Card (Bottom Sheet on Mobile, Centered on Desktop) ── */
.smart-share-sheet {
    width: 100%;
    max-width: 520px;
    background: #FFFFFF;
    border-radius: 20px 20px 0 0;
    box-shadow: 0 -8px 36px rgba(0,0,0,0.28);
    transform: translateY(100%);
    transition: transform 0.35s cubic-bezier(0.25, 1, 0.5, 1);
    overflow: hidden;
    max-height: 92vh;
    display: flex;
    flex-direction: column;
    border-top: 3px solid var(--dark-gold, #8A681F);
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

/* ── Modal Drag Handle (Mobile) ── */
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

/* ── Modal Header ── */
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
    box-shadow: 0 2px 6px rgba(37, 211, 102, 0.35);
}
.smart-share-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 0.96rem;
    font-weight: 700;
    color: var(--dark-text, #24211C);
    letter-spacing: 0.02em;
}
.smart-share-close {
    width: 32px;
    height: 32px;
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
    border-color: var(--dark-gold, #8A681F);
}

/* ── Modal Product Snapshot ── */
.smart-share-product-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    background: #FFFFFF;
    border-bottom: 1px solid var(--soft-platinum, #E5E3DE);
}
.smart-share-thumb {
    width: 60px;
    height: 60px;
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
    line-height: 1.25;
}
.smart-share-prod-meta {
    font-size: 0.68rem;
    color: var(--mid-text, #5A5348);
    margin: 2px 0;
    display: flex;
    align-items: center;
    gap: 6px;
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
    font-size: 0.72rem;
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

/* ── Smart Progress Status Bar (Meesho automation feedback) ── */
.smart-share-status-box {
    display: none;
    margin: 12px 18px 0;
    padding: 10px 14px;
    border-radius: 10px;
    background: #F0FDF4;
    border: 1px solid #BBF7D0;
    color: #166534;
    font-size: 0.76rem;
    font-weight: 600;
    align-items: center;
    gap: 10px;
    animation: statusSlideDown 0.25s ease;
}
.smart-share-status-box.active {
    display: flex;
}
@keyframes statusSlideDown {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
}
.smart-share-spinner {
    width: 16px;
    height: 16px;
    border: 2px solid #86EFAC;
    border-top-color: #16A34A;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
    flex-shrink: 0;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Actions List ── */
.smart-share-actions-wrap {
    padding: 14px 18px 18px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    overflow-y: auto;
}

/* 🟢 Primary 1-Click Smart WhatsApp Share Button */
.smart-whatsapp-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 14px 18px;
    border-radius: 12px;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #FFFFFF;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.88rem;
    font-weight: 800;
    letter-spacing: 0.03em;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 18px rgba(37, 211, 102, 0.38);
    transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
}
.smart-whatsapp-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.48);
}
.smart-whatsapp-btn:active {
    transform: scale(0.98);
}
.smart-whatsapp-btn svg {
    width: 22px;
    height: 22px;
    fill: currentColor;
    flex-shrink: 0;
}
.smart-whatsapp-subtext {
    display: block;
    font-size: 0.64rem;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    margin-top: 1px;
}

/* Secondary Action Buttons Grid */
.smart-share-sub-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}
.smart-share-opt-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 12px;
    border-radius: 10px;
    background: #FAF8F4;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    color: var(--dark-text, #24211C);
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.74rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}
.smart-share-opt-btn:hover {
    background: #FFFFFF;
    border-color: var(--dark-gold, #8A681F);
    color: var(--dark-gold, #8A681F);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(138,104,31,0.12);
}
.smart-share-opt-btn svg {
    width: 15px;
    height: 15px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    flex-shrink: 0;
}

/* Copy Link Pill Button */
.smart-copy-link-btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 14px;
    border-radius: 10px;
    background: #FAF8F4;
    border: 1px solid var(--soft-platinum, #E5E3DE);
    font-size: 0.74rem;
    color: var(--mid-text, #5A5348);
    cursor: pointer;
    transition: all 0.2s ease;
}
.smart-copy-link-btn:hover {
    border-color: var(--dark-gold, #8A681F);
    color: var(--dark-gold, #8A681F);
    background: #FFFFFF;
}
.smart-copy-link-btn-badge {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    font-size: 0.62rem;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 10px;
}

/* ── Meesho How-It-Works Footnote ── */
.smart-share-footnote {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    font-size: 0.62rem;
    color: var(--light-text, #9A9490);
    text-align: center;
    margin-top: 4px;
}
</style>

<!-- ════ SMART SHARE MODAL DIALOG ════ -->
<div class="smart-share-overlay" id="smartShareOverlay" onclick="if(event.target===this) window.closeSmartShareModal();" aria-modal="true" role="dialog" aria-label="Smart WhatsApp Share">
    <div class="smart-share-sheet">
        <div class="smart-share-handle"></div>

        <!-- Header -->
        <div class="smart-share-header">
            <div class="smart-share-title-group">
                <span class="smart-share-badge">⚡ Smart Share</span>
                <h3 class="smart-share-title">Share with Customers</h3>
            </div>
            <button type="button" class="smart-share-close" onclick="window.closeSmartShareModal();" aria-label="Close">
                <svg width="14" height="14" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.4" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <!-- Product Snapshot -->
        <div class="smart-share-product-card">
            <img src="images/product1.png" alt="Product" class="smart-share-thumb" id="smartShareThumb" />
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

        <!-- Status Progress Indicator (Shown while Meesho automation executes) -->
        <div class="smart-share-status-box" id="smartShareStatusBox">
            <div class="smart-share-spinner"></div>
            <span id="smartShareStatusText">Auto-downloading HD Photos &amp; copying details...</span>
        </div>

        <!-- Share Actions -->
        <div class="smart-share-actions-wrap">
            <!-- 🟢 PRIMARY 1-CLICK SMART WHATSAPP SHARE (Meesho Flow) -->
            <button type="button" class="smart-whatsapp-btn" id="smartWhatsAppMainBtn" onclick="window.executeSmartMeeshoShare();">
                <svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zM12.05 20.21c-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.267 8.267 0 0 1-1.27-4.44c0-4.57 3.71-8.27 8.29-8.27 2.21 0 4.29.86 5.85 2.43a8.217 8.217 0 0 1 2.42 5.85c0 4.56-3.72 8.29-8.3 8.29zm4.54-6.2c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.02-1.25-.75-.67-1.25-1.5-1.4-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.15.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.35-.77-1.85-.2-.49-.4-.42-.56-.43h-.47c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.22.89 2.4 1.02 2.57.13.17 1.76 2.68 4.26 3.76.6.26 1.06.41 1.42.53.6.19 1.15.16 1.58.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.14-1.18-.06-.11-.22-.17-.47-.3z"/></svg>
                <div>
                    <div>1-Click Smart WhatsApp Share</div>
                    <span class="smart-whatsapp-subtext">Auto-Downloads HD Photo + Copies Full Details to WhatsApp</span>
                </div>
            </button>

            <!-- Secondary Options -->
            <div class="smart-share-sub-grid">
                <!-- Download HD Photos Only -->
                <button type="button" class="smart-share-opt-btn" onclick="window.downloadSmartProductMedia();">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download HD Photos</span>
                </button>

                <!-- Copy Formatted Text Only -->
                <button type="button" class="smart-share-opt-btn" onclick="window.copySmartProductText();">
                    <svg viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                    <span>Copy Full Details</span>
                </button>
            </div>

            <!-- Copy Direct Product Link -->
            <div class="smart-copy-link-btn" onclick="window.copySmartProductLink();">
                <div style="display:flex;align-items:center;gap:8px;overflow:hidden;">
                    <svg width="15" height="15" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                    <span id="smartShareLinkText" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">https://...</span>
                </div>
                <span class="smart-copy-link-btn-badge">Copy Link</span>
            </div>

            <div class="smart-share-footnote">
                <span>🛡️ Verified Kalaniketan Reseller Flow • 100% HD Quality Images</span>
            </div>
        </div>
    </div>
</div>

<script>
/* ── MEESHO-STYLE SMART WHATSAPP SHARE ENGINE ── */
(function() {
    'use strict';

    var currentShareItem = {
        id: 1,
        name: 'Nilambari Silk Saree',
        category: 'Sarees',
        price: 4899,
        old_price: 6500,
        discount: 25,
        image: 'images/product1.png',
        fabric: 'Pure Silk',
        colors: 'Navy, Royal Blue',
        sizes: 'Free Size, M, L',
        url: window.location.href
    };

    /* Open Smart Share Modal with Product Context */
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
        var linkText = document.getElementById('smartShareLinkText');
        var statusBox = document.getElementById('smartShareStatusBox');

        if (thumb) thumb.src = currentShareItem.image || 'images/product1.png';
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

        // Build absolute link URL
        var resolvedUrl = currentShareItem.url || window.location.href;
        if (!resolvedUrl.startsWith('http')) {
            resolvedUrl = window.location.origin + window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/') + 1) + resolvedUrl;
        }
        currentShareItem.fullUrl = resolvedUrl;
        if (linkText) linkText.textContent = resolvedUrl;

        if (statusBox) statusBox.classList.remove('active');

        var overlay = document.getElementById('smartShareOverlay');
        if (overlay) overlay.classList.add('active');
    };

    window.closeSmartShareModal = function() {
        var overlay = document.getElementById('smartShareOverlay');
        if (overlay) overlay.classList.remove('active');
    };

    /* Build Rich Meesho-Style Formatted WhatsApp Text */
    function buildFormattedWhatsAppMessage(item) {
        var msg = '👑 *KALANIKETAN — ETHNIC LUXURY COUTURE*\n';
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

        msg += '🔗 *View & Order Online:*\n' + (item.fullUrl || window.location.href) + '\n\n';
        msg += '💬 *To Order on WhatsApp:* Reply with your address to confirm booking!';
        return msg;
    }

    /* Helper to download an image file to user device */
    function triggerImageDownload(imgUrl, filename) {
        return new Promise(function(resolve) {
            fetch(imgUrl)
                .then(function(res) { return res.blob(); })
                .then(function(blob) {
                    var blobUrl = URL.createObjectURL(blob);
                    var a = document.createElement('a');
                    a.href = blobUrl;
                    a.download = filename || 'kalaniketan-product.png';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    setTimeout(function() {
                        URL.revokeObjectURL(blobUrl);
                        resolve(blob);
                    }, 200);
                })
                .catch(function() {
                    // Fallback direct link download
                    var a = document.createElement('a');
                    a.href = imgUrl;
                    a.download = filename || 'kalaniketan-product.png';
                    a.target = '_blank';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    resolve(null);
                });
        });
    }

    /* 🟢 EXECUTE 1-CLICK MEESHO SMART WHATSAPP SHARE */
    window.executeSmartMeeshoShare = function() {
        var statusBox = document.getElementById('smartShareStatusBox');
        var statusText = document.getElementById('smartShareStatusText');
        if (statusBox) statusBox.classList.add('active');
        if (statusText) statusText.textContent = '📸 Step 1/3: Downloading HD Product Photos...';

        var formattedText = buildFormattedWhatsAppMessage(currentShareItem);
        var imageUrl = currentShareItem.image || 'images/product1.png';
        var sanitizedName = (currentShareItem.name || 'product').toLowerCase().replace(/[^a-z0-9]/g, '-');

        // Check if Web Share API Level 2 with files is supported
        fetch(imageUrl)
            .then(function(res) { return res.blob(); })
            .then(function(blob) {
                var file = new File([blob], sanitizedName + '-hd.png', { type: blob.type });

                if (navigator.canShare && navigator.canShare({ files: [file] })) {
                    // Native direct file share with caption directly to WhatsApp/Apps
                    if (statusText) statusText.textContent = '🚀 Opening WhatsApp with HD Photo & Details...';
                    navigator.share({
                        files: [file],
                        title: currentShareItem.name,
                        text: formattedText
                    }).then(function() {
                        if (statusBox) statusBox.classList.remove('active');
                        window.closeSmartShareModal();
                    }).catch(function(err) {
                        fallbackMeeshoFlow(formattedText, imageUrl, sanitizedName);
                    });
                } else {
                    fallbackMeeshoFlow(formattedText, imageUrl, sanitizedName);
                }
            })
            .catch(function() {
                fallbackMeeshoFlow(formattedText, imageUrl, sanitizedName);
            });
    };

    /* Standard Meesho 2-Step Flow: Download Photo -> Copy Text -> Open WhatsApp */
    function fallbackMeeshoFlow(formattedText, imageUrl, sanitizedName) {
        var statusBox = document.getElementById('smartShareStatusBox');
        var statusText = document.getElementById('smartShareStatusText');

        triggerImageDownload(imageUrl, sanitizedName + '-kalaniketan-hd.png').then(function() {
            if (statusText) statusText.textContent = '📋 Step 2/3: Copying Product Details to Clipboard...';

            // Copy to clipboard
            var copyPromise = (navigator.clipboard && navigator.clipboard.writeText)
                ? navigator.clipboard.writeText(formattedText)
                : Promise.reject();

            copyPromise.catch(function() {
                var t = document.createElement('textarea');
                t.value = formattedText;
                document.body.appendChild(t);
                t.select();
                document.execCommand('copy');
                document.body.removeChild(t);
                return Promise.resolve();
            }).finally(function() {
                if (statusText) statusText.textContent = '🚀 Step 3/3: Opening WhatsApp... Paste details & send!';

                setTimeout(function() {
                    var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(formattedText);
                    window.open(waUrl, '_blank');
                    if (statusBox) statusBox.classList.remove('active');
                    window.closeSmartShareModal();
                }, 700);
            });
        });
    }

    /* Download HD Gallery Media */
    window.downloadSmartProductMedia = function() {
        var imageUrl = currentShareItem.image || 'images/product1.png';
        var sanitizedName = (currentShareItem.name || 'product').toLowerCase().replace(/[^a-z0-9]/g, '-');
        triggerImageDownload(imageUrl, sanitizedName + '-hd.png').then(function() {
            alert('✅ HD Product Photo downloaded to your device!');
        });
    };

    /* Copy Formatted Text Only */
    window.copySmartProductText = function() {
        var formattedText = buildFormattedWhatsAppMessage(currentShareItem);
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(formattedText).then(function() {
                alert('📋 Full Product Details Copied to Clipboard! You can now paste into WhatsApp.');
            });
        } else {
            var t = document.createElement('textarea');
            t.value = formattedText;
            document.body.appendChild(t);
            t.select();
            document.execCommand('copy');
            document.body.removeChild(t);
            alert('📋 Full Product Details Copied to Clipboard! You can now paste into WhatsApp.');
        }
    };

    /* Copy Product Link */
    window.copySmartProductLink = function() {
        var link = currentShareItem.fullUrl || window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(link).then(function() {
                alert('🔗 Direct Product Link copied to clipboard!');
            });
        } else {
            var t = document.createElement('textarea');
            t.value = link;
            document.body.appendChild(t);
            t.select();
            document.execCommand('copy');
            document.body.removeChild(t);
            alert('🔗 Direct Product Link copied to clipboard!');
        }
    };

})();
</script>
