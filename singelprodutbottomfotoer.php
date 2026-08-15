<?php
/**
 * singelprodutbottomfotoer.php — PARTIAL INCLUDE
 * Dedicated Luxury Footer and Mobile Sticky Action Bar for Single Product Page (PDP)
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
    padding: 10px 14px;
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
        padding-bottom: 74px !important;
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

/* ── Full Luxury Footer ─────────────────────────────────────────── */
.pdp-footer {
    background: #181512;
    color: #EAE7DF;
    padding: clamp(36px, 6vw, 60px) clamp(16px, 4vw, 48px) 30px;
    border-top: 3px solid var(--dark-gold, #8A681F);
    font-family: var(--font-sans, 'Inter', sans-serif);
}

.pdp-footer-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: clamp(24px, 4vw, 48px);
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding-bottom: 36px;
}

.pdp-footer-brand h3 {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 1.3rem;
    color: #C5A859;
    letter-spacing: 0.12em;
    margin-bottom: 6px;
}
.pdp-footer-brand p {
    font-size: 0.8rem;
    color: #A09A90;
    line-height: 1.6;
    margin-top: 10px;
}

.pdp-footer-col h4 {
    font-size: 0.82rem;
    font-weight: 800;
    color: #C5A859;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 16px;
}
.pdp-footer-links {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.pdp-footer-links a {
    font-size: 0.82rem;
    color: #BFB8AC;
    text-decoration: none;
    transition: all 0.2s ease;
}
.pdp-footer-links a:hover {
    color: #FFFFFF;
    padding-left: 4px;
}

.pdp-footer-contact-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.82rem;
    color: #BFB8AC;
    margin-bottom: 10px;
}
.pdp-footer-contact-item svg {
    width: 16px; height: 16px;
    stroke: #C5A859;
    fill: none;
    stroke-width: 2;
    flex-shrink: 0;
}

.pdp-footer-bottom {
    max-width: 1200px;
    margin: 24px auto 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.75rem;
    color: #8E877D;
    flex-wrap: wrap;
    gap: 14px;
}
.pdp-footer-payments {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.72rem;
    color: #A09A90;
}
.pdp-payment-pill {
    padding: 3px 8px;
    border-radius: 4px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    color: #FFFFFF;
    font-size: 0.65rem;
    font-weight: 700;
}
</style>

<!-- ═══ Mobile Sticky Bottom Action Bar ═══ -->
<div class="pdp-mobile-bottom-bar" id="pdpMobileBar">
    <div class="pdp-mob-price-wrap">
        <span class="pdp-mob-price" id="pdpMobPrice">₹<?= number_format($product['price'] ?? 4899) ?></span>
        <span class="pdp-mob-tax">FREE SHIPPING</span>
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

<!-- ═══ Luxury Footer ═══ -->
<footer class="pdp-footer">
    <div class="pdp-footer-grid">
        <div class="pdp-footer-brand">
            <h3>KALANIKETAN</h3>
            <span style="font-size:0.65rem; color:#C5A859; letter-spacing:0.18em; text-transform:uppercase; font-weight:700;">Ethnic Luxury Couture</span>
            <p>
                Celebrating Indian royal heritage with authentic handloom silk sarees, bespoke bridal lehengas, and designer couture since 1984.
            </p>
        </div>

        <div class="pdp-footer-col">
            <h4>Collections</h4>
            <div class="pdp-footer-links">
                <a href="shop.php?cat=Sarees">Pure Silk Sarees</a>
                <a href="shop.php?cat=Lehengas">Bridal Lehengas</a>
                <a href="shop.php?cat=Kurtis">Designer Kurtis</a>
                <a href="shop.php?cat=Gowns">Evening Gowns</a>
                <a href="shop.php?cat=New+Arrivals">Festive Arrivals</a>
            </div>
        </div>

        <div class="pdp-footer-col">
            <h4>Customer Care</h4>
            <div class="pdp-footer-links">
                <a href="myaccount.php">My Account & Orders</a>
                <a href="shop.php">Track Delivery</a>
                <a href="shop.php">Size & Fit Guide</a>
                <a href="shop.php">7-Day Return Policy</a>
                <a href="shop.php">Authenticity Guarantee</a>
            </div>
        </div>

        <div class="pdp-footer-col">
            <h4>Atelier & Contact</h4>
            <div class="pdp-footer-contact-item">
                <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span>Ring Road, Surat, Gujarat 395002</span>
            </div>
            <div class="pdp-footer-contact-item">
                <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span>+91 98765 43210</span>
            </div>
            <div class="pdp-footer-contact-item">
                <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <span>care@kalaniketan.com</span>
            </div>
        </div>
    </div>

    <div class="pdp-footer-bottom">
        <div>&copy; <?= date('Y') ?> Kalaniketan Ethnic Luxury. All Rights Reserved.</div>
        <div class="pdp-footer-payments">
            <span>100% Safe Payments:</span>
            <span class="pdp-payment-pill">UPI</span>
            <span class="pdp-payment-pill">Cards</span>
            <span class="pdp-payment-pill">NetBanking</span>
            <span class="pdp-payment-pill">COD</span>
        </div>
    </div>
</footer>
