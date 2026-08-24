<?php
/**
 * checkout.php — Standalone & Modal Partial Component
 * Luxury Ethnic WhatsApp CRM Checkout Flow
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;

$dbProductsForCheckout = ProductCatalog::getAll();
?>
<script>
window.allProducts = <?php echo json_encode($dbProductsForCheckout); ?>;
</script>
<!-- ════════════════════════════════════════════════════
     CHECKOUT MODAL / DRAWER / CONTAINER
════════════════════════════════════════════════════ -->
<style>
/* ── Checkout Root Design Tokens ── */
:root {
    --co-gold-primary: #8A681F;
    --co-gold-deep: #6F5218;
    --co-gold-light: #C5A859;
    --co-gold-bg: #FAF5E8;
    --co-gold-border: rgba(138, 104, 31, 0.25);
    --co-dark-text: #24211C;
    --co-mid-text: #5A5348;
    --co-light-text: #8E877D;
    --co-cream-bg: #FCFBF8;
    --co-white: #FFFFFF;
    --co-green: #2E7D32;
    --co-green-bg: #E8F5E9;
    --co-wa-green: #25D366;
    --co-wa-dark: #128C7E;
    --co-shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
    --co-shadow-md: 0 8px 24px rgba(138,104,31,0.12);
    --co-shadow-lg: 0 16px 40px rgba(0,0,0,0.22);
}

/* ── Modal Backdrop ── */
.checkout-backdrop {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(20, 16, 12, 0.82);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    z-index: 1000000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity 0.32s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.32s ease;
    padding: 0;
    box-sizing: border-box;
}
.checkout-backdrop.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

/* ── Checkout Main Container (Full screen on mobile, elegant dialog on desktop) ── */
.checkout-wrapper {
    background: var(--co-cream-bg);
    width: 100%;
    max-width: 1100px;
    height: 100%;
    max-height: 100vh;
    display: flex;
    flex-direction: column;
    box-shadow: var(--co-shadow-lg);
    border: 1px solid var(--co-gold-border);
    transform: translateY(20px) scale(0.98);
    transition: transform 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
    position: relative;
    overflow: hidden;
    font-family: var(--font-sans, 'Inter', -apple-system, sans-serif);
    color: var(--co-dark-text);
}
@media (min-width: 900px) {
    .checkout-wrapper {
        height: 92vh;
        max-height: 820px;
        border-radius: 16px;
        transform: scale(0.96);
    }
}
.checkout-backdrop.active .checkout-wrapper {
    transform: translateY(0) scale(1);
}

/* ── Checkout Header ── */
.co-header {
    background: #FFFFFF;
    border-bottom: 1.5px solid var(--co-gold-primary);
    padding: clamp(8px, 2vw, 14px) clamp(12px, 3vw, 24px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
    position: relative;
    z-index: 10;
}
.co-header-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}
.co-brand-icon {
    width: clamp(28px, 6vw, 36px);
    height: clamp(28px, 6vw, 36px);
    border-radius: 50%;
    background: linear-gradient(135deg, var(--co-gold-primary) 0%, var(--co-gold-deep) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    box-shadow: 0 2px 8px rgba(138,104,31,0.3);
}
.co-brand-icon svg {
    width: clamp(14px, 3.5vw, 18px);
    height: clamp(14px, 3.5vw, 18px);
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}
.co-title-group h2 {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(0.92rem, 3.2vw, 1.25rem);
    font-weight: 700;
    color: var(--co-gold-primary);
    margin: 0;
    letter-spacing: 0.06em;
    line-height: 1.1;
}
.co-title-group span {
    font-size: clamp(0.55rem, 1.8vw, 0.68rem);
    color: var(--co-mid-text);
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}
.co-close-btn {
    width: clamp(30px, 7vw, 36px);
    height: clamp(30px, 7vw, 36px);
    border-radius: 50%;
    border: 1px solid var(--co-gold-border);
    background: #FAF8F4;
    color: var(--co-gold-primary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.co-close-btn:hover {
    background: var(--co-gold-primary);
    color: #FFFFFF;
    border-color: var(--co-gold-primary);
    transform: rotate(90deg);
}

/* ── Checkout Steps Breadcrumbs / Progress ── */
.co-progress-bar {
    background: #FAF7F0;
    border-bottom: 1px solid var(--co-gold-border);
    padding: 8px 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: clamp(10px, 4vw, 36px);
    flex-shrink: 0;
}
.co-step-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: clamp(0.62rem, 2vw, 0.75rem);
    font-weight: 600;
    color: var(--co-light-text);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    cursor: pointer;
    transition: color 0.2s ease;
}
.co-step-pill.active {
    color: var(--co-gold-primary);
    font-weight: 700;
}
.co-step-num {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #E5E1D8;
    color: #5A5348;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    font-weight: 700;
}
.co-step-pill.active .co-step-num {
    background: var(--co-gold-primary);
    color: #FFFFFF;
    box-shadow: 0 2px 6px rgba(138,104,31,0.3);
}
.co-step-divider {
    width: clamp(16px, 4vw, 36px);
    height: 1px;
    background: var(--co-gold-border);
}

/* ── Checkout Content Body (2-Column Grid on Desktop, 1-Column on Mobile) ── */
.co-content-body {
    flex: 1;
    overflow-y: auto;
    display: grid;
    grid-template-columns: 1fr;
    gap: 0;
    -webkit-overflow-scrolling: touch;
}
@media (min-width: 900px) {
    .co-content-body {
        grid-template-columns: 1.15fr 0.85fr;
        gap: 0;
    }
}

/* ── Left Column: Form & Payment ── */
.co-form-column {
    padding: clamp(14px, 3vw, 26px);
    display: flex;
    flex-direction: column;
    gap: 20px;
    border-right: none;
}
@media (min-width: 900px) {
    .co-form-column {
        border-right: 1px solid var(--co-gold-border);
        overflow-y: auto;
    }
}

/* Section Box ── */
.co-section-card {
    background: #FFFFFF;
    border: 1.5px solid var(--co-gold-border);
    border-radius: 12px;
    padding: clamp(12px, 2.5vw, 18px);
    box-shadow: var(--co-shadow-sm);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.co-section-card:hover {
    border-color: var(--co-gold-primary);
    box-shadow: 0 4px 14px rgba(138,104,31,0.08);
}
.co-sec-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 14px;
    padding-bottom: 8px;
    border-bottom: 1px dashed rgba(138,104,31,0.25);
}
.co-sec-header svg {
    width: 17px;
    height: 17px;
    stroke: var(--co-gold-primary);
    stroke-width: 2;
    fill: none;
    flex-shrink: 0;
}
.co-sec-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(0.82rem, 2.4vw, 0.95rem);
    font-weight: 700;
    color: var(--co-gold-primary);
    letter-spacing: 0.05em;
    margin: 0;
    text-transform: uppercase;
}

/* Form Inputs Grid ── */
.co-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
@media (max-width: 520px) {
    .co-grid-2 {
        grid-template-columns: 1fr;
    }
}
.co-input-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 12px;
}
.co-input-group:last-child {
    margin-bottom: 0;
}
.co-label {
    font-size: clamp(0.68rem, 1.8vw, 0.74rem);
    font-weight: 700;
    color: var(--co-dark-text);
    letter-spacing: 0.02em;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.co-label .required {
    color: #D32F2F;
}
.co-input {
    width: 100%;
    height: clamp(38px, 9vw, 44px);
    border: 1.5px solid #DDD8CD;
    border-radius: 8px;
    padding: 0 12px;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: clamp(0.78rem, 2.2vw, 0.88rem);
    color: var(--co-dark-text);
    background: #FAF9F5;
    outline: none;
    box-sizing: border-box;
    transition: all 0.2s ease;
}
.co-input:focus {
    border-color: var(--co-gold-primary);
    background: #FFFFFF;
    box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
}
.co-textarea {
    width: 100%;
    min-height: 60px;
    border: 1.5px solid #DDD8CD;
    border-radius: 8px;
    padding: 8px 12px;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: clamp(0.76rem, 2vw, 0.85rem);
    color: var(--co-dark-text);
    background: #FAF9F5;
    outline: none;
    box-sizing: border-box;
    resize: vertical;
    transition: all 0.2s ease;
}
.co-textarea:focus {
    border-color: var(--co-gold-primary);
    background: #FFFFFF;
    box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
}

/* WhatsApp Phone Input with Prefix ── */
.co-phone-wrap {
    display: flex;
    align-items: center;
    border: 1.5px solid #DDD8CD;
    border-radius: 8px;
    background: #FAF9F5;
    overflow: hidden;
    transition: all 0.2s ease;
}
.co-phone-wrap:focus-within {
    border-color: var(--co-gold-primary);
    background: #FFFFFF;
    box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
}
.co-phone-prefix {
    padding: 0 10px;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--co-gold-primary);
    background: #F0EAD8;
    height: clamp(38px, 9vw, 44px);
    display: flex;
    align-items: center;
    border-right: 1px solid #DDD8CD;
    flex-shrink: 0;
}
.co-phone-input {
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;
    padding: 0 10px !important;
}

/* Payment Mode Selection Cards ── */
.co-payment-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.co-pay-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1.5px solid #DDD8CD;
    background: #FAF9F5;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}
.co-pay-option:hover {
    border-color: var(--co-gold-primary);
    background: #FFFFFF;
}
.co-pay-option.selected {
    border-color: var(--co-gold-primary);
    background: #FCF8EE;
    box-shadow: 0 2px 10px rgba(138,104,31,0.12);
}
.co-pay-radio {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #C5BBAA;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.co-pay-option.selected .co-pay-radio {
    border-color: var(--co-gold-primary);
}
.co-pay-option.selected .co-pay-radio::after {
    content: '';
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: var(--co-gold-primary);
}
.co-pay-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.co-pay-icon.wa { background: #E8F8EE; color: var(--co-wa-green); }
.co-pay-icon.upi { background: #EDE7F6; color: #673AB7; }
.co-pay-icon.cod { background: #FFF3E0; color: #E65100; }
.co-pay-icon svg { width: 18px; height: 18px; fill: currentColor; }
.co-pay-text {
    flex: 1;
}
.co-pay-name {
    font-size: clamp(0.76rem, 2.2vw, 0.86rem);
    font-weight: 700;
    color: var(--co-dark-text);
    display: flex;
    align-items: center;
    gap: 6px;
}
.co-pay-tag {
    font-size: 0.55rem;
    padding: 2px 6px;
    border-radius: 10px;
    background: #E8F5E9;
    color: var(--co-green);
    font-weight: 800;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.co-pay-desc {
    font-size: clamp(0.64rem, 1.8vw, 0.72rem);
    color: var(--co-mid-text);
    margin-top: 2px;
}

/* ── Right Column: Order Summary & Actions ── */
.co-summary-column {
    background: #FFFFFF;
    padding: clamp(14px, 3vw, 26px);
    display: flex;
    flex-direction: column;
    gap: 16px;
    border-top: 1px solid var(--co-gold-border);
}
@media (min-width: 900px) {
    .co-summary-column {
        border-top: none;
        overflow-y: auto;
    }
}

/* Items Review List ── */
.co-items-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 230px;
    overflow-y: auto;
    padding-right: 4px;
    scrollbar-width: thin;
}
.co-item-row {
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 8px 10px;
    border-radius: 8px;
    background: #FAF8F4;
    border: 1px solid var(--co-gold-border);
}
.co-item-img {
    width: 48px;
    height: 64px;
    aspect-ratio: 3 / 4;
    border-radius: 6px;
    object-fit: cover;
    object-position: top center;
    border: 1px solid var(--co-gold-border);
    background: #F5F1E8;
    flex-shrink: 0;
}
.co-item-info {
    flex: 1;
    min-width: 0;
}
.co-item-name {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(0.74rem, 2vw, 0.84rem);
    font-weight: 700;
    color: var(--co-dark-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}
.co-item-meta {
    font-size: clamp(0.62rem, 1.8vw, 0.7rem);
    color: var(--co-mid-text);
}
.co-item-price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 3px;
}
.co-item-price {
    font-size: clamp(0.78rem, 2.2vw, 0.88rem);
    font-weight: 700;
    color: var(--co-gold-primary);
}

/* Coupon Box ── */
.co-coupon-wrap {
    display: flex;
    gap: 6px;
}
.co-coupon-input {
    flex: 1;
    height: 36px;
    border: 1.5px dashed var(--co-gold-primary);
    border-radius: 6px;
    padding: 0 10px;
    font-family: var(--font-sans);
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    background: #FAF8F4;
    outline: none;
}
.co-coupon-btn {
    padding: 0 14px;
    height: 36px;
    border-radius: 6px;
    border: none;
    background: var(--co-gold-primary);
    color: #FFFFFF;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s ease;
    flex-shrink: 0;
}
.co-coupon-btn:hover { background: var(--co-gold-deep); }

/* Pricing Breakdown ── */
.co-price-breakdown {
    display: flex;
    flex-direction: column;
    gap: 7px;
    padding-top: 12px;
    border-top: 1.5px dashed var(--co-gold-border);
}
.co-price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: clamp(0.74rem, 2vw, 0.82rem);
    color: var(--co-mid-text);
}
.co-price-row.discount {
    color: var(--co-green);
    font-weight: 600;
}
.co-price-row.total {
    font-size: clamp(0.95rem, 2.6vw, 1.15rem);
    font-weight: 800;
    color: var(--co-dark-text);
    padding-top: 8px;
    border-top: 1.5px solid var(--co-gold-primary);
}
.co-price-row.total .val {
    color: var(--co-gold-primary);
    font-family: var(--font-serif, 'Cinzel', serif);
}

/* Place Order WhatsApp CTA ── */
.co-submit-btn {
    width: 100%;
    padding: clamp(12px, 3vw, 16px);
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #FFFFFF;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: clamp(0.82rem, 2.4vw, 0.95rem);
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 18px rgba(37, 211, 102, 0.35);
    transition: all 0.25s ease;
}
.co-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(37, 211, 102, 0.5);
    filter: brightness(1.05);
}
.co-submit-btn:active {
    transform: scale(0.98);
}
.co-submit-btn svg {
    width: 20px;
    height: 20px;
    fill: currentColor;
    flex-shrink: 0;
}

.co-guarantee-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: clamp(0.62rem, 1.8vw, 0.7rem);
    color: var(--co-light-text);
    text-align: center;
    margin-top: 4px;
}
.co-guarantee-note svg {
    width: 14px;
    height: 14px;
    stroke: var(--co-gold-primary);
    fill: none;
    stroke-width: 2;
}

/* ── Order Success Modal Overlay ── */
.co-success-overlay {
    position: absolute;
    inset: 0;
    background: #FFFFFF;
    z-index: 50;
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 24px;
    text-align: center;
    animation: coSuccessFadeIn 0.35s cubic-bezier(0.16, 1, 0.3, 1);
}
.co-success-overlay.active {
    display: flex;
}
@keyframes coSuccessFadeIn {
    from { opacity: 0; transform: scale(0.94); }
    to { opacity: 1; transform: scale(1); }
}
.co-success-seal {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
    margin-bottom: 16px;
    animation: sealBounce 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes sealBounce {
    0% { transform: scale(0); }
    60% { transform: scale(1.15); }
    100% { transform: scale(1); }
}
.co-success-seal svg {
    width: 36px;
    height: 36px;
    stroke: #FFFFFF;
    stroke-width: 2.5;
    fill: none;
}
.co-success-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(1.2rem, 4vw, 1.6rem);
    font-weight: 700;
    color: var(--co-gold-primary);
    margin: 0 0 6px;
}
.co-order-id-pill {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    background: #F0EAD8;
    color: var(--co-gold-deep);
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    margin-bottom: 12px;
    border: 1px solid var(--co-gold-border);
}
.co-success-desc {
    font-size: 0.84rem;
    color: var(--co-mid-text);
    max-width: 380px;
    line-height: 1.5;
    margin: 0 0 20px;
}
.co-success-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    max-width: 320px;
}
.co-wa-chat-btn {
    padding: 12px 20px;
    border-radius: 8px;
    background: #25D366;
    color: #FFFFFF;
    font-weight: 700;
    font-size: 0.84rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3);
}
.co-wa-chat-btn:hover { background: #128C7E; }
.co-done-btn {
    padding: 10px 20px;
    border-radius: 8px;
    background: #FAF8F4;
    border: 1.5px solid var(--co-gold-primary);
    color: var(--co-gold-primary);
    font-weight: 700;
    font-size: 0.8rem;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}
.co-done-btn:hover { background: var(--co-gold-primary); color: #FFFFFF; }
</style>

<!-- ════════════════════════════════════════════════════
     CHECKOUT MODAL MARKUP
════════════════════════════════════════════════════ -->
<div class="checkout-backdrop" id="checkoutBackdrop" role="dialog" aria-modal="true" aria-label="Secure Checkout">
    <div class="checkout-wrapper">
        
        <!-- Header -->
                <div class="co-header">
            <div class="co-header-brand" style="display:flex; align-items:center; gap:10px;">
                <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" style="height:32px; width:auto; max-width:130px; object-fit:contain;">
                <div class="co-title-group">
                    <h2>Secure Luxury Checkout</h2>
                    <span>DT Brand's Ethnic Couture</span>
                </div>
            </div>
            <button class="co-close-btn" id="closeCheckoutBtn" aria-label="Close Checkout">✕</button>
        </div>

        <!-- Progress Steps -->
        <div class="co-progress-bar">
            <div class="co-step-pill active" id="coStep1">
                <span class="co-step-num">1</span>
                <span>Shipping & Payment</span>
            </div>
            <div class="co-step-divider"></div>
            <div class="co-step-pill" id="coStep2">
                <span class="co-step-num">2</span>
                <span>WhatsApp Order</span>
            </div>
        </div>

        <!-- Body Grid -->
        <div class="co-content-body">
            
            <!-- Left Column: Shipping & Payment Form -->
            <div class="co-form-column">
                
                <!-- Contact Details -->
                <div class="co-section-card">
                    <div class="co-sec-header">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <h3 class="co-sec-title">1. Customer Details</h3>
                    </div>
                    <div class="co-grid-2">
                        <div class="co-input-group">
                            <label class="co-label" for="coFullName">Full Name <span class="required">*</span></label>
                            <input type="text" id="coFullName" class="co-input" placeholder="e.g. Radhika Sharma" required>
                        </div>
                        <div class="co-input-group">
                            <label class="co-label" for="coWhatsApp">WhatsApp Number <span class="required">*</span></label>
                            <div class="co-phone-wrap">
                                <span class="co-phone-prefix">+91</span>
                                <input type="tel" id="coWhatsApp" class="co-input co-phone-input" placeholder="9876543210" maxlength="10" required>
                            </div>
                        </div>
                    </div>
                    <div class="co-input-group">
                        <label class="co-label" for="coEmail">Email Address (Optional for e-Invoice)</label>
                        <input type="email" id="coEmail" class="co-input" placeholder="radhika@example.com">
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="co-section-card">
                    <div class="co-sec-header">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <h3 class="co-sec-title">2. Delivery Address</h3>
                    </div>
                    <div class="co-input-group">
                        <label class="co-label" for="coAddress">House / Flat / Building / Street <span class="required">*</span></label>
                        <input type="text" id="coAddress" class="co-input" placeholder="e.g. 402, Royal Residency, M.G. Road" required>
                    </div>
                    <div class="co-grid-2">
                        <div class="co-input-group">
                            <label class="co-label" for="coPincode">Pincode <span class="required">*</span></label>
                            <input type="text" id="coPincode" class="co-input" placeholder="400001" maxlength="6" required>
                        </div>
                        <div class="co-input-group">
                            <label class="co-label" for="coCity">City <span class="required">*</span></label>
                            <input type="text" id="coCity" class="co-input" placeholder="Mumbai" required>
                        </div>
                    </div>
                    <div class="co-grid-2">
                        <div class="co-input-group">
                            <label class="co-label" for="coState">State <span class="required">*</span></label>
                            <input type="text" id="coState" class="co-input" placeholder="Maharashtra" required>
                        </div>
                        <div class="co-input-group">
                            <label class="co-label" for="coLandmark">Landmark (Optional)</label>
                            <input type="text" id="coLandmark" class="co-input" placeholder="Near Golden Temple">
                        </div>
                    </div>
                    <div class="co-input-group">
                        <label class="co-label" for="coNote">Special Instructions / Custom Stitching Note</label>
                        <textarea id="coNote" class="co-textarea" placeholder="e.g. Please stitch blouse in size 38, or gift wrap in royal box"></textarea>
                    </div>
                </div>

                <!-- Payment Selection -->
                <div class="co-section-card">
                    <div class="co-sec-header">
                        <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        <h3 class="co-sec-title">3. Payment Preference</h3>
                    </div>
                    <div class="co-payment-options">
                        
                        <!-- WhatsApp Direct Pay -->
                        <div class="co-pay-option selected" data-method="whatsapp" onclick="window.selectPaymentMethod('whatsapp')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon wa">
                                <svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">Direct WhatsApp Order & Pay <span class="co-pay-tag">Recommended</span></div>
                                <div class="co-pay-desc">Instant confirmation + Custom styling support on WhatsApp</div>
                            </div>
                        </div>

                        <!-- Instant UPI / Cards -->
                        <div class="co-pay-option" data-method="upi" onclick="window.selectPaymentMethod('upi')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon upi">
                                <svg viewBox="0 0 24 24"><path d="M21 4H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4l-9 5-9-5V6l9 5 9-5v2z"/></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">Instant UPI / QR / Net Banking</div>
                                <div class="co-pay-desc">GPay, PhonePe, Paytm & Credit/Debit Cards</div>
                            </div>
                        </div>

                        <!-- Cash on Delivery -->
                        <div class="co-pay-option" data-method="cod" onclick="window.selectPaymentMethod('cod')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon cod">
                                <svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">Cash on Delivery (COD)</div>
                                <div class="co-pay-desc">Pay in cash upon doorstep delivery</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Right Column: Order Summary & Placement -->
            <div class="co-summary-column">
                
                <div class="co-sec-header">
                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    <h3 class="co-sec-title">Order Items (<span id="coItemCount">0</span>)</h3>
                </div>

                <!-- Items List -->
                <div class="co-items-list" id="coItemsList">
                    <!-- Dynamic Cart Items Rendered Here -->
                </div>

                <!-- Coupon Box -->
                <div class="co-coupon-wrap">
                    <input type="text" id="coCouponInput" class="co-coupon-input" placeholder="Promo code (e.g. ROYAL10)">
                    <button class="co-coupon-btn" id="coApplyCouponBtn">Apply</button>
                </div>
                <div id="coCouponMessage" style="font-size: 0.7rem; display: none;"></div>

                <!-- Price Breakdown -->
                <div class="co-price-breakdown">
                    <div class="co-price-row">
                        <span>Items Subtotal</span>
                        <span id="coSubtotalVal">₹0</span>
                    </div>
                    <div class="co-price-row discount" id="coDiscountRow" style="display: none;">
                        <span>Luxury Discount</span>
                        <span id="coDiscountVal">-₹0</span>
                    </div>
                    <div class="co-price-row">
                        <span>⚡ Fast Express Delivery</span>
                        <span style="color: var(--co-green); font-weight: 700;">FAST DISPATCH</span>
                    </div>
                    <div class="co-price-row">
                        <span>GST (Included)</span>
                        <span>₹0</span>
                    </div>
                    <div class="co-price-row total">
                        <span>Grand Total</span>
                        <span class="val" id="coGrandTotalVal">₹0</span>
                    </div>
                </div>

                <!-- Submit WhatsApp Button -->
                <button class="co-submit-btn" id="coPlaceOrderBtn">
                    <svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                    <span>Confirm & Place Order</span>
                </button>

                <div class="co-guarantee-note">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>✨ 100% Original Product • ⚡ 7-Day Fast Exchange</span>
                </div>

            </div>

        </div>

        <!-- Success Overlay -->
        <div class="co-success-overlay" id="coSuccessOverlay">
            <div class="co-success-seal">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h2 class="co-success-title">Order Placed Successfully!</h2>
            <div class="co-order-id-pill" id="coSuccessOrderId">#KLN-847291</div>
            <p class="co-success-desc" id="coSuccessDesc">
                Thank you for choosing DT Brand's Ethnic Luxury. We have forwarded your order invoice directly to our WhatsApp concierge team.
            </p>
            <div class="co-success-actions">
                <a href="#" class="co-wa-chat-btn" id="coSuccessWhatsAppLink" target="_blank">
                    <svg style="width:18px;height:18px;fill:currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                    <span>Track on WhatsApp</span>
                </a>
                <button class="co-done-btn" onclick="window.closeCheckout(); if(typeof window.renderCart==='function')window.renderCart();">Continue Shopping</button>
            </div>
        </div>

    </div>
</div>

<!-- ════════════════════════════════════════════════════
     CHECKOUT JAVASCRIPT CONTROLLER
════════════════════════════════════════════════════ -->
<script>
(function() {
    'use strict';

    var activePaymentMethod = 'whatsapp';
    var appliedDiscountAmount = 0;
    var appliedCouponCode = '';

    /* WhatsApp Business Number for Order Routing */
    var BRAND_WHATSAPP_NUMBER = '919876543210'; 

    /* Expose Global Controller */
    window.openCheckout = function() {
        var modal = document.getElementById('checkoutBackdrop');
        if (!modal) return;

        /* Close Cart Drawer if open */
        if (typeof window.closeCartDrawer === 'function') {
            window.closeCartDrawer();
        }

        /* Check if cart is empty */
        var cart = window.cartState || JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
        if (!cart || cart.length === 0) {
            if (typeof window.showToast === 'function') {
                window.showToast('Your shopping bag is empty! Add items to checkout.');
            } else {
                alert('Your shopping bag is empty! Add items to checkout.');
            }
            return;
        }

        /* Reset Success State */
        var successOverlay = document.getElementById('coSuccessOverlay');
        if (successOverlay) successOverlay.classList.remove('active');

        window.renderCheckoutItems();
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.closeCheckout = function() {
        var modal = document.getElementById('checkoutBackdrop');
        if (modal) modal.classList.remove('active');
        document.body.style.overflow = '';
    };

    window.selectPaymentMethod = function(method) {
        activePaymentMethod = method;
        document.querySelectorAll('.co-pay-option').forEach(function(opt) {
            opt.classList.toggle('selected', opt.dataset.method === method);
        });

        var btnTxt = document.querySelector('#coPlaceOrderBtn span');
        if (btnTxt) {
            if (method === 'whatsapp') {
                btnTxt.textContent = 'Confirm & Order via WhatsApp';
            } else if (method === 'upi') {
                btnTxt.textContent = 'Pay with UPI & Confirm';
            } else {
                btnTxt.textContent = 'Confirm COD Order';
            }
        }
    };

    /* Render Items inside Checkout */
    window.renderCheckoutItems = function() {
        var listContainer = document.getElementById('coItemsList');
        var countEl = document.getElementById('coItemCount');
        if (!listContainer) return;

        var cart = window.cartState || JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
        var totalQty = cart.reduce(function(sum, item) { return sum + (item.qty || 1); }, 0);
        if (countEl) countEl.textContent = totalQty;

        if (cart.length === 0) {
            listContainer.innerHTML = '<div style="text-align:center;padding:20px;font-size:0.8rem;color:#8E877D;">Your bag is empty</div>';
            return;
        }

        var subtotal = 0;
        var html = '';

        cart.forEach(function(item, idx) {
            var priceNum = parseInt(String(item.price).replace(/[^0-9]/g, ''), 10) || 0;
            var itemTotal = priceNum * (item.qty || 1);
            subtotal += itemTotal;

            html += `
                <div class="co-item-row">
                    <img src="${item.img || '/Shared/Asset/images/product1.png'}" alt="${item.title || 'Ethnic Product'}" class="co-item-img" onerror="this.src='/Shared/Asset/images/product1.png';">
                    <div class="co-item-info">
                        <div class="co-item-name">${item.title || 'Ethnic Attire'}</div>
                        <div class="co-item-meta">Size: <strong>${item.size || 'M'}</strong> | Qty: <strong>${item.qty || 1}</strong></div>
                        <div class="co-item-price-row">
                            <span class="co-item-price">₹${itemTotal.toLocaleString('en-IN')}</span>
                        </div>
                    </div>
                </div>
            `;
        });

        listContainer.innerHTML = html;

        /* Calculate Price Breakdown */
        var discount = appliedDiscountAmount;
        var grandTotal = Math.max(0, subtotal - discount);

        var subtotalEl = document.getElementById('coSubtotalVal');
        var discountRow = document.getElementById('coDiscountRow');
        var discountEl = document.getElementById('coDiscountVal');
        var grandTotalEl = document.getElementById('coGrandTotalVal');

        if (subtotalEl) subtotalEl.textContent = '₹' + subtotal.toLocaleString('en-IN');
        if (discountRow && discountEl) {
            if (discount > 0) {
                discountRow.style.display = 'flex';
                discountEl.textContent = '-₹' + discount.toLocaleString('en-IN');
            } else {
                discountRow.style.display = 'none';
            }
        }
        if (grandTotalEl) grandTotalEl.textContent = '₹' + grandTotal.toLocaleString('en-IN');
    };

    /* Coupon Handler */
    function applyCoupon() {
        var input = document.getElementById('coCouponInput');
        var msg = document.getElementById('coCouponMessage');
        if (!input) return;

        var code = input.value.trim().toUpperCase();
        var cart = window.cartState || JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
        var subtotal = cart.reduce(function(sum, item) {
            var priceNum = parseInt(String(item.price).replace(/[^0-9]/g, ''), 10) || 0;
            return sum + (priceNum * (item.qty || 1));
        }, 0);

        if (!code) {
            appliedDiscountAmount = 0;
            appliedCouponCode = '';
            if (msg) msg.style.display = 'none';
            window.renderCheckoutItems();
            return;
        }

        if (code === 'ROYAL10') {
            appliedDiscountAmount = Math.round(subtotal * 0.10);
            appliedCouponCode = 'ROYAL10';
            if (msg) {
                msg.style.display = 'block';
                msg.style.color = '#2E7D32';
                msg.textContent = '✨ Coupon ROYAL10 applied! 10% Royal Festive discount saved.';
            }
        } else if (code === 'FESTIVE500') {
            appliedDiscountAmount = Math.min(subtotal, 500);
            appliedCouponCode = 'FESTIVE500';
            if (msg) {
                msg.style.display = 'block';
                msg.style.color = '#2E7D32';
                msg.textContent = '✨ Coupon FESTIVE500 applied! Flat ₹500 discount saved.';
            }
        } else {
            appliedDiscountAmount = 0;
            appliedCouponCode = '';
            if (msg) {
                msg.style.display = 'block';
                msg.style.color = '#D32F2F';
                msg.textContent = '❌ Invalid Coupon Code. Try "ROYAL10" for 10% off!';
            }
        }
        window.renderCheckoutItems();
    }

    /* Place Order & WhatsApp Integration */
    function handlePlaceOrder() {
        var fullName = document.getElementById('coFullName').value.trim();
        var whatsApp = document.getElementById('coWhatsApp').value.trim();
        var address = document.getElementById('coAddress').value.trim();
        var pincode = document.getElementById('coPincode').value.trim();
        var city = document.getElementById('coCity').value.trim();
        var state = document.getElementById('coState').value.trim();
        var note = document.getElementById('coNote').value.trim();

        if (!fullName) {
            alert('Please enter your Full Name.');
            document.getElementById('coFullName').focus();
            return;
        }
        if (!whatsApp || whatsApp.length < 10) {
            alert('Please enter a valid 10-digit WhatsApp number.');
            document.getElementById('coWhatsApp').focus();
            return;
        }
        if (!address) {
            alert('Please enter your Delivery Address.');
            document.getElementById('coAddress').focus();
            return;
        }
        if (!pincode || pincode.length < 6) {
            alert('Please enter a valid 6-digit Pincode.');
            document.getElementById('coPincode').focus();
            return;
        }
        if (!city || !state) {
            alert('Please enter City and State.');
            return;
        }

        var cart = window.cartState || JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
        if (cart.length === 0) {
            alert('Your bag is empty.');
            return;
        }

        /* Generate Order ID */
        var randomNum = Math.floor(100000 + Math.random() * 900000);
        var orderId = 'KLN-' + randomNum;

        /* Calculate Subtotal and Grand Total */
        var subtotal = 0;
        var itemsSummaryTxt = '';

        cart.forEach(function(item, i) {
            var priceNum = parseInt(String(item.price).replace(/[^0-9]/g, ''), 10) || 0;
            var itemTotal = priceNum * (item.qty || 1);
            subtotal += itemTotal;
            itemsSummaryTxt += `${i + 1}. *${item.title || 'Ethnic Product'}*\n   Size: ${item.size || 'M'} | Qty: ${item.qty || 1} | ₹${itemTotal.toLocaleString('en-IN')}\n`;
        });

        var grandTotal = Math.max(0, subtotal - appliedDiscountAmount);

        /* Save Real Order to MySQL Database via api/orders.php */
        var params = new URLSearchParams();
        params.append('action', 'create');
        params.append('customer_name', fullName);
        params.append('customer_phone', whatsApp);
        params.append('payment_method', activePaymentMethod);
        params.append('discount', appliedDiscountAmount);
        params.append('items', JSON.stringify(cart));

        fetch('/api/orders.php', {
            method: 'POST',
            body: params
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            var realOrderNumber = (data.order && data.order.order_number) ? data.order.order_number : orderId;

            /* Craft Luxury WhatsApp Invoice Message */
            var waMessage = `👑 *DT BRAND'S ETHNIC LUXURY — NEW ORDER*\n\n` +
                            `🔖 *Order ID:* #${realOrderNumber}\n` +
                            `📅 *Date:* ${new Date().toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' })}\n` +
                            `───────────────\n` +
                            `👤 *Customer Name:* ${fullName}\n` +
                            `📞 *WhatsApp:* +91 ${whatsApp}\n` +
                            `📍 *Shipping Address:*\n${address}, ${city}, ${state} - ${pincode}\n` +
                            (note ? `📝 *Custom Note:* ${note}\n` : '') +
                            `───────────────\n` +
                            `🛍️ *ORDERED ITEMS:*\n${itemsSummaryTxt}\n` +
                            `───────────────\n` +
                            `💵 *Subtotal:* ₹${subtotal.toLocaleString('en-IN')}\n` +
                            (appliedDiscountAmount > 0 ? `🎁 *Discount (${appliedCouponCode}):* -₹${appliedDiscountAmount.toLocaleString('en-IN')}\n` : '') +
                            `🚚 *Fast Delivery:* Express Priority Dispatch\n` +
                            `✨ *GRAND TOTAL:* ₹${grandTotal.toLocaleString('en-IN')}\n` +
                            `💳 *Payment Method:* ${activePaymentMethod.toUpperCase()}\n` +
                            `───────────────\n` +
                            `Please confirm and share order dispatch tracking. Thank you! 🙏`;

            var waUrl = `https://api.whatsapp.com/send?phone=${BRAND_WHATSAPP_NUMBER}&text=${encodeURIComponent(waMessage)}`;

            /* Show Success Overlay */
            var successOverlay = document.getElementById('coSuccessOverlay');
            var successOrderId = document.getElementById('coSuccessOrderId');
            var successWaLink = document.getElementById('coSuccessWhatsAppLink');

            if (successOrderId) successOrderId.textContent = '#' + realOrderNumber;
            if (successWaLink) successWaLink.href = waUrl;
            if (successOverlay) successOverlay.classList.add('active');

            /* Clear Cart upon successful order placement */
            localStorage.removeItem('dtbrands_cart');
            window.cartState = [];
            if (typeof window.syncBadges === 'function') window.syncBadges();
            if (typeof window.renderCart === 'function') window.renderCart();

            /* Automatically open WhatsApp chat in new window/tab */
            window.open(waUrl, '_blank');
        })
        .catch(function(_err) {
            var waMessage = `👑 *DT BRAND'S ETHNIC LUXURY — NEW ORDER*\n\n` +
                            `🔖 *Order ID:* #${orderId}\n` +
                            `👤 *Customer:* ${fullName}\n` +
                            `📞 *WhatsApp:* +91 ${whatsApp}\n` +
                            `✨ *GRAND TOTAL:* ₹${grandTotal.toLocaleString('en-IN')}\n` +
                            `Please confirm order dispatch.`;
            var waUrl = `https://api.whatsapp.com/send?phone=${BRAND_WHATSAPP_NUMBER}&text=${encodeURIComponent(waMessage)}`;
            var successOverlay = document.getElementById('coSuccessOverlay');
            if (successOverlay) successOverlay.classList.add('active');
            localStorage.removeItem('dtbrands_cart');
            window.cartState = [];
            window.open(waUrl, '_blank');
        });
    }

    /* Bind Event Listeners on DOM Load */
    document.addEventListener('DOMContentLoaded', function() {
        var closeBtn = document.getElementById('closeCheckoutBtn');
        if (closeBtn) closeBtn.addEventListener('click', window.closeCheckout);

        var backdrop = document.getElementById('checkoutBackdrop');
        if (backdrop) {
            backdrop.addEventListener('click', function(e) {
                if (e.target === backdrop) window.closeCheckout();
            });
        }

        var applyCouponBtn = document.getElementById('coApplyCouponBtn');
        if (applyCouponBtn) applyCouponBtn.addEventListener('click', applyCoupon);

        var placeOrderBtn = document.getElementById('coPlaceOrderBtn');
        if (placeOrderBtn) placeOrderBtn.addEventListener('click', handlePlaceOrder);
    });

})();
</script>
