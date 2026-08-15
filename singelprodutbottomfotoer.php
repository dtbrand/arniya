<?php
/**
 * singelprodutbottomfotoer.php — PARTIAL INCLUDE
 * Dedicated Mobile Sticky Action Bar for Single Product Page (PDP)
 * Features High-Converting Mobile Bottom Bar with Add to Bag, Buy Now, and Wishlist
 */
?>
<style>
/* ── Mobile Sticky Bottom Action Bar ─────────────────────────────── */
.pdp-mobile-bottom-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9999;
    background: #FFFFFF;
    border-top: 1.5px solid var(--gold-border, rgba(138,104,31,0.25));
    box-shadow: 0 -4px 20px rgba(0,0,0,0.12);
    padding: 10px 14px calc(10px + env(safe-area-inset-bottom, 0px));
    display: none; /* Desktop default */
    align-items: center;
    gap: 10px;
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

@media (max-width: 767px) {
    .pdp-mobile-bottom-bar {
        display: flex;
    }
    /* Add padding to page bottom so content doesn't get covered by sticky bar */
    .pdp-main-wrapper {
        padding-bottom: calc(84px + env(safe-area-inset-bottom, 0px)) !important;
    }
}

.pdp-mob-price-wrap {
    display: flex;
    flex-direction: column;
    min-width: 80px;
}
.pdp-mob-price {
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dark-gold, #8A681F);
    line-height: 1;
}
.pdp-mob-tax {
    font-size: 0.58rem;
    font-weight: 600;
    color: #2E7D32;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 2px;
}

.pdp-mob-wish-btn {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    color: var(--dark-text, #24211C);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.pdp-mob-wish-btn.active {
    border-color: #E53935;
    background: #FFEBEE;
    color: #E53935;
}
.pdp-mob-wish-btn.active svg { fill: #E53935; }
.pdp-mob-wish-btn svg {
    width: 20px; height: 20px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}

.pdp-mob-btn-group {
    display: flex;
    flex: 1;
    gap: 8px;
}
.pdp-mob-atc-btn {
    flex: 1;
    height: 44px;
    border-radius: 10px;
    border: 1.5px solid var(--dark-gold, #8A681F);
    background: #FAF4E6;
    color: var(--dark-gold, #8A681F);
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.pdp-mob-atc-btn:hover {
    background: #F5E8C8;
}
.pdp-mob-atc-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.2; }

.pdp-mob-buy-btn {
    flex: 1;
    height: 44px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, var(--dark-gold, #8A681F) 0%, var(--deep-gold, #6F5218) 100%);
    color: #FFFFFF;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(138,104,31,0.3);
    transition: all 0.2s ease;
}
.pdp-mob-buy-btn:hover {
    background: var(--deep-gold, #6F5218);
}
.pdp-mob-buy-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.2; }
</style>

<!-- ═══ Mobile Sticky Bottom Action Bar ═══ -->
<div class="pdp-mobile-bottom-bar" id="pdpMobileBar">
    <div class="pdp-mob-price-wrap">
        <span class="pdp-mob-price" id="pdpMobPrice">₹<?= number_format($product['price'] ?? 4899) ?></span>
        <span class="pdp-mob-tax">⚡ FAST DELIVERY</span>
    </div>

    <!-- Wishlist Quick Toggle -->
    <button class="pdp-mob-wish-btn" id="pdpMobWishBtn" aria-label="Add to Wishlist" onclick="handlePdpWishlistClick()">
        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
    </button>

    <div class="pdp-mob-btn-group">
        <!-- Add to Bag -->
        <button class="pdp-mob-atc-btn" id="pdpMobAtcBtn" onclick="handlePdpAddToCart()">
            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <span>ADD TO BAG</span>
        </button>

        <!-- Buy Now (Instant Checkout) -->
        <button class="pdp-mob-buy-btn" id="pdpMobBuyBtn" onclick="handlePdpBuyNow()">
            <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            <span>BUY NOW</span>
        </button>
    </div>
</div>
