<?php
/**
 * singelprodutbottomfotoer.php — PARTIAL INCLUDE
 * Dedicated Mobile Sticky Action Bar for Single Product Page (PDP)
 * Features High-Converting Mobile Bottom Bar with Add to Bag, Buy Now, and Intelligent Modal Auto-Hide
 */
?>
<style>
/* ── Mobile Sticky Bottom Action Bar ─────────────────────────────── */
.pdp-mobile-bottom-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9990 !important;
    background: rgba(255, 255, 255, 0.98);
    border-top: 1.5px solid var(--gold-border, rgba(138,104,31,0.25));
    box-shadow: 0 -4px 20px rgba(0,0,0,0.12);
    padding: 6px 10px calc(6px + env(safe-area-inset-bottom, 0px));
    display: none;
    align-items: center;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    pointer-events: auto !important;
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
    transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.25s ease, visibility 0.25s ease;
    will-change: transform, opacity;
}

@media (max-width: 768px) {
    .pdp-mobile-bottom-bar {
        display: flex !important;
    }
    /* Add padding to page bottom so content doesn't get covered by sticky bar */
    .pdp-main-wrapper {
        padding-bottom: calc(68px + env(safe-area-inset-bottom, 0px)) !important;
    }
}
@media (min-width: 769px) {
    .pdp-mobile-bottom-bar {
        display: none !important;
    }
}

/* ── Auto-Hide Sticky Bottom Bar When ANY Modal / Drawer / Popup is Open ── */
body.modal-open .pdp-mobile-bottom-bar,
body.drawer-open .pdp-mobile-bottom-bar,
body.cart-open .pdp-mobile-bottom-bar,
body.qv-open .pdp-mobile-bottom-bar,
body.pdp-popup-active .pdp-mobile-bottom-bar,
body:has(.cart-drawer-backdrop.active) .pdp-mobile-bottom-bar,
body:has(.wishlist-drawer-backdrop.active) .pdp-mobile-bottom-bar,
body:has(#quickViewModal.active) .pdp-mobile-bottom-bar,
body:has(.quickview-modal-backdrop.active) .pdp-mobile-bottom-bar,
body:has(#pdpLightboxOverlay.open) .pdp-mobile-bottom-bar,
body:has(#pdpWaCheckoutModal.open) .pdp-mobile-bottom-bar,
body:has(#pdpWriteReviewModal.open) .pdp-mobile-bottom-bar,
body:has(#pdpSizeGuideModal.open) .pdp-mobile-bottom-bar,
body:has(.pdp-modal-overlay.open) .pdp-mobile-bottom-bar,
body:has(#smartShareModal.active) .pdp-mobile-bottom-bar,
body:has(.smart-share-backdrop.active) .pdp-mobile-bottom-bar,
body:has(#reelsModal.active) .pdp-mobile-bottom-bar,
body:has(.reels-modal-overlay.active) .pdp-mobile-bottom-bar,
body:has(#accountModalBackdrop.open) .pdp-mobile-bottom-bar,
body:has(.account-modal-backdrop.open) .pdp-mobile-bottom-bar,
body:has(#checkoutModal.active) .pdp-mobile-bottom-bar,
body:has(.checkout-modal-backdrop.active) .pdp-mobile-bottom-bar,
.pdp-mobile-bottom-bar.hide-for-modal {
    transform: translateY(120%) !important;
    opacity: 0 !important;
    pointer-events: none !important;
    visibility: hidden !important;
}

.pdp-mob-btn-group {
    display: flex;
    width: 100%;
    gap: 8px;
}
.pdp-mob-atc-btn {
    flex: 1;
    height: 40px;
    border-radius: 9px;
    border: 1px solid #8A681F;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    color: #111827;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 8px rgba(184,134,11,0.28);
    transition: all 0.2s ease;
}
.pdp-mob-atc-btn:hover, .pdp-mob-atc-btn:active {
    background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
    transform: scale(0.98);
}
.pdp-mob-atc-btn svg {
    width: 15px;
    height: 15px;
    stroke: #111827;
    fill: none;
    stroke-width: 2.2;
    animation: pdpBagSwing 2.4s infinite ease-in-out;
    transform-origin: top center;
    flex-shrink: 0;
}
@keyframes pdpBagSwing {
    0%, 100% { transform: rotate(0deg); }
    15% { transform: rotate(-14deg); }
    30% { transform: rotate(14deg); }
    45% { transform: rotate(-8deg); }
    60% { transform: rotate(8deg); }
    75% { transform: rotate(0deg); }
}

.pdp-mob-buy-btn {
    flex: 1;
    height: 40px;
    border-radius: 9px;
    border: 1.2px solid #8A681F;
    background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
    color: #FAF5E8;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    box-shadow: 0 3px 12px rgba(0,0,0,0.3);
    transition: all 0.2s ease;
}
.pdp-mob-buy-btn:hover, .pdp-mob-buy-btn:active {
    border-color: #D4AF37;
    background: linear-gradient(135deg, #241F1A 0%, #383028 100%);
    transform: scale(0.98);
}
.pdp-mob-buy-btn svg {
    width: 14px;
    height: 14px;
    fill: currentColor;
    stroke: currentColor;
    stroke-width: 1;
    animation: pdpBoltPulse 1.6s infinite ease-in-out;
    flex-shrink: 0;
}
@keyframes pdpBoltPulse {
    0%, 100% { transform: scale(1); filter: drop-shadow(0 0 1px rgba(255,255,255,0.6)); }
    50% { transform: scale(1.26); filter: drop-shadow(0 0 5px rgba(255,255,255,0.95)); }
}
</style>

<!-- ═══ Mobile Sticky Bottom Action Bar (Full-Width Dual Action: Add to Bag & Buy Now) ═══ -->
<div class="pdp-mobile-bottom-bar" id="pdpMobileBar">
    <div class="pdp-mob-btn-group">
        <!-- Add to Bag -->
        <button class="pdp-mob-atc-btn" id="pdpMobAtcBtn" onclick="if(typeof handlePdpAddToCart==='function') handlePdpAddToCart();">
            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <span>ADD TO BAG</span>
        </button>

        <!-- Buy Now (Instant Checkout) -->
        <button class="pdp-mob-buy-btn" id="pdpMobBuyBtn" onclick="if(typeof handlePdpBuyNow==='function') handlePdpBuyNow();">
            <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            <span>BUY NOW</span>
        </button>
    </div>
</div>

<script>
(function() {
    function checkPdpModalsState() {
        var bar = document.getElementById('pdpMobileBar');
        if (!bar) return;

        var isAnyOpen = false;

        // Check body style overflow
        if (document.body.style.overflow === 'hidden' || document.body.classList.contains('modal-open') || document.body.classList.contains('cart-open') || document.body.classList.contains('pdp-popup-active')) {
            isAnyOpen = true;
        }

        // Check active / open selectors
        var modalSelectors = [
            '.cart-drawer-backdrop.active',
            '.wishlist-drawer-backdrop.active',
            '#quickViewModal.active',
            '.quickview-modal-backdrop.active',
            '#pdpLightboxOverlay.open',
            '#pdpWaCheckoutModal.open',
            '#pdpWriteReviewModal.open',
            '#pdpSizeGuideModal.open',
            '.pdp-modal-overlay.open',
            '#smartShareModal.active',
            '.smart-share-backdrop.active',
            '#reelsModal.active',
            '.reels-modal-overlay.active',
            '#accountModalBackdrop.open',
            '.account-modal-backdrop.open',
            '#checkoutModal.active',
            '.checkout-modal-backdrop.active'
        ];

        for (var i = 0; i < modalSelectors.length; i++) {
            var el = document.querySelector(modalSelectors[i]);
            if (el && (el.classList.contains('open') || el.classList.contains('active'))) {
                isAnyOpen = true;
                break;
            }
        }

        if (isAnyOpen) {
            bar.classList.add('hide-for-modal');
            document.body.classList.add('pdp-popup-active');
        } else {
            bar.classList.remove('hide-for-modal');
            document.body.classList.remove('pdp-popup-active');
        }
    }

    // Set up MutationObserver to auto-detect popup states in real-time
    if (typeof MutationObserver !== 'undefined') {
        var observer = new MutationObserver(function() {
            checkPdpModalsState();
        });
        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['class', 'style'],
            childList: true,
            subtree: true
        });
    }

    // Listen to window & interaction events
    window.addEventListener('resize', checkPdpModalsState, { passive: true });
    window.addEventListener('scroll', checkPdpModalsState, { passive: true });
    document.addEventListener('DOMContentLoaded', checkPdpModalsState);
    document.addEventListener('click', function() {
        setTimeout(checkPdpModalsState, 80);
    });

    window.hidePdpMobileBar = function() {
        var bar = document.getElementById('pdpMobileBar');
        if (bar) bar.classList.add('hide-for-modal');
    };
    window.showPdpMobileBar = function() {
        var bar = document.getElementById('pdpMobileBar');
        if (bar) bar.classList.remove('hide-for-modal');
    };
})();
</script>
