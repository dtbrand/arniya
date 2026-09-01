<?php
/**
 * checkout.php — Standalone & Modal Partial Component
 * Luxury Ethnic WhatsApp CRM Checkout Flow & Multi-Gateway Engine
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/PaymentManager.php';

use DTBrand\ProductCatalog;
use DTBrand\PaymentManager;

$dbProductsForCheckout = ProductCatalog::getAll();
$paymentGateways = PaymentManager::getPublicConfig();
?>
<script>
window.allProducts = <?php echo json_encode($dbProductsForCheckout); ?>;
window.paymentGatewaysConfig = <?php echo json_encode($paymentGateways); ?>;
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

/* ── Checkout Main Container ── */
.checkout-wrapper {
    background: var(--co-cream-bg);
    width: 100%;
    max-width: 1120px;
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
        max-height: 840px;
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
.co-title-group h2 {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(0.95rem, 2.5vw, 1.15rem);
    font-weight: 700;
    color: var(--co-gold-primary);
    margin: 0;
    letter-spacing: 0.04em;
}
.co-title-group span {
    font-size: 0.68rem;
    color: var(--co-light-text);
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.co-close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1px solid var(--co-gold-border);
    background: #FAF9F6;
    color: var(--co-mid-text);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.2s ease;
}
.co-close-btn:hover {
    background: var(--co-gold-primary);
    color: #FFFFFF;
    border-color: var(--co-gold-primary);
}

/* Progress Steps */
.co-progress-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    background: #FAF8F4;
    padding: 8px 16px;
    border-bottom: 1px solid var(--co-gold-border);
    flex-shrink: 0;
}
.co-step-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--co-mid-text);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.co-step-pill.active {
    color: var(--co-gold-primary);
}
.co-step-num {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #DDD8CD;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    font-weight: 800;
}
.co-step-pill.active .co-step-num {
    background: var(--co-gold-primary);
}
.co-step-divider {
    width: 30px;
    height: 1.5px;
    background: #DDD8CD;
}

/* ── Checkout Body Grid ── */
.co-content-body {
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
@media (min-width: 900px) {
    .co-content-body {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        overflow: hidden;
    }
}

/* Left Form Column */
.co-form-column {
    padding: clamp(14px, 3vw, 24px);
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.co-section-card {
    background: #FFFFFF;
    border: 1px solid var(--co-gold-border);
    border-radius: 12px;
    padding: clamp(12px, 2.5vw, 18px);
    box-shadow: var(--co-shadow-sm);
}
.co-sec-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(138,104,31,0.12);
}
.co-sec-header svg {
    width: 18px;
    height: 18px;
    stroke: var(--co-gold-primary);
    stroke-width: 2.2;
    fill: none;
}
.co-sec-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(0.82rem, 2.2vw, 0.94rem);
    font-weight: 700;
    color: var(--co-gold-primary);
    margin: 0;
}

/* Form Inputs */
.co-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}
@media (max-width: 600px) {
    .co-grid-2 { grid-template-columns: 1fr; }
}
.co-input-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 8px;
}
.co-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: var(--co-dark-text);
}
.co-label .required { color: #DC2626; }
.co-input, .co-textarea {
    width: 100%;
    padding: 9px 12px;
    border-radius: 8px;
    border: 1.5px solid #DDD8CD;
    background: #FAF9F5;
    font-family: inherit;
    font-size: 0.82rem;
    color: #111827;
    box-sizing: border-box;
    transition: all 0.2s ease;
}
.co-input:focus, .co-textarea:focus {
    border-color: var(--co-gold-primary);
    background: #FFFFFF;
    outline: none;
    box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
}
.co-phone-wrap {
    display: flex;
    align-items: center;
    border: 1.5px solid #DDD8CD;
    border-radius: 8px;
    background: #FAF9F5;
    overflow: hidden;
}
.co-phone-prefix {
    padding: 0 10px;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--co-gold-primary);
    background: #F0EAD8;
    height: 38px;
    display: flex;
    align-items: center;
    border-right: 1px solid #DDD8CD;
}
.co-phone-input {
    border: none !important;
    background: transparent !important;
    box-shadow: none !important;
    padding: 0 10px !important;
}

/* Payment Selector Cards */
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
    width: 34px;
    height: 34px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.co-pay-icon.upi { background: #EDE7F6; color: #673AB7; }
.co-pay-icon.cards { background: #E0F2FE; color: #0284C7; }
.co-pay-icon.cod { background: #FFF3E0; color: #E65100; }
.co-pay-icon.wa { background: #E8F8EE; color: var(--co-wa-green); }
.co-pay-icon svg { width: 18px; height: 18px; fill: currentColor; }
.co-pay-text { flex: 1; min-width: 0; }
.co-pay-name {
    font-size: 0.84rem;
    font-weight: 700;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 6px;
}
.co-pay-tag {
    font-size: 0.58rem;
    padding: 2px 6px;
    border-radius: 10px;
    background: #E8F5E9;
    color: #15803D;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.co-pay-desc {
    font-size: 0.7rem;
    color: #64748B;
    margin-top: 2px;
}

/* Right Summary Column */
.co-summary-column {
    background: #FFFFFF;
    padding: clamp(14px, 3vw, 24px);
    display: flex;
    flex-direction: column;
    gap: 14px;
    border-top: 1px solid var(--co-gold-border);
    overflow-y: auto;
}
@media (min-width: 900px) {
    .co-summary-column { border-top: none; }
}
.co-items-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    max-height: 220px;
    overflow-y: auto;
    scrollbar-width: thin;
}
.co-item-row {
    display: flex;
    gap: 10px;
    align-items: center;
    padding: 8px;
    border-radius: 8px;
    background: #FAF8F4;
    border: 1px solid var(--co-gold-border);
}
.co-item-img {
    width: 44px;
    height: 58px;
    aspect-ratio: 3/4;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid var(--co-gold-border);
}
.co-item-info { flex: 1; min-width: 0; }
.co-item-name {
    font-size: 0.8rem;
    font-weight: 700;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.co-item-meta { font-size: 0.68rem; color: #64748B; }
.co-item-price { font-size: 0.78rem; font-weight: 800; color: #8A681F; }

/* Coupon & Price Breakdown */
.co-coupon-wrap { display: flex; gap: 8px; }
.co-coupon-input {
    flex: 1;
    padding: 8px 12px;
    border-radius: 8px;
    border: 1.5px solid #DDD8CD;
    background: #FAF9F5;
    font-size: 0.78rem;
    text-transform: uppercase;
}
.co-coupon-btn {
    padding: 8px 16px;
    border-radius: 8px;
    background: var(--co-gold-primary);
    color: #FFFFFF;
    font-weight: 700;
    font-size: 0.76rem;
    border: none;
    cursor: pointer;
}
.co-price-breakdown {
    background: #FAF9F5;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid var(--co-gold-border);
    display: flex;
    flex-direction: column;
    gap: 6px;
    font-size: 0.78rem;
}
.co-price-row { display: flex; justify-content: space-between; color: #475569; }
.co-price-row.total {
    border-top: 1.5px solid var(--co-gold-primary);
    padding-top: 8px;
    margin-top: 4px;
    font-size: 0.94rem;
    font-weight: 800;
    color: #111827;
}
.co-price-row.total .val { color: var(--co-gold-primary); }

/* Submit Master Button */
.co-submit-btn {
    padding: 14px 20px;
    border-radius: 10px;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    border: 1.5px solid #8A681F;
    color: #111827;
    font-weight: 800;
    font-size: 0.88rem;
    letter-spacing: -0.01em;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(184,134,11,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
}
.co-submit-btn:hover {
    background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(184,134,11,0.48);
}
.co-submit-btn svg { width: 18px; height: 18px; fill: currentColor; }

/* ── UPI Interactive Studio Modal (Desktop QR & Mobile Intent) ── */
.co-upi-modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(20, 16, 12, 0.94);
    z-index: 100;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
    animation: coSuccessFadeIn 0.3s ease;
}
.co-upi-modal-overlay.active { display: flex; }
.co-upi-modal-card {
    background: #FFFFFF;
    border-radius: 14px;
    width: 100%;
    max-width: 440px;
    padding: 22px;
    text-align: center;
    border: 2px solid #D4AF37;
    box-shadow: 0 12px 36px rgba(0,0,0,0.3);
    max-height: 90vh;
    overflow-y: auto;
}
.co-upi-timer-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    background: #FEF3C7;
    color: #B45309;
    border-radius: 20px;
    font-size: 0.74rem;
    font-weight: 700;
    margin-bottom: 12px;
}
.co-upi-qr-wrapper {
    width: 180px;
    height: 180px;
    margin: 0 auto 12px;
    padding: 8px;
    border: 1.5px solid #D4AF37;
    border-radius: 10px;
    background: #FAF9F5;
    display: flex;
    align-items: center;
    justify-content: center;
}
.co-upi-app-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
    margin-bottom: 14px;
}
.co-upi-app-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #CBD5E1;
    background: #F8FAFC;
    font-size: 0.78rem;
    font-weight: 700;
    text-decoration: none;
    color: #1E293B;
    transition: all 0.2s;
}
.co-upi-app-btn:hover {
    background: #FAF5E8;
    border-color: #D4AF37;
    color: #8A681F;
}

/* Success Overlay */
.co-success-overlay {
    position: absolute;
    inset: 0;
    background: #FFFFFF;
    z-index: 120;
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 24px;
    text-align: center;
    animation: coSuccessFadeIn 0.35s ease;
}
.co-success-overlay.active { display: flex; }
.co-success-seal {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    margin-bottom: 14px;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
}
.co-success-seal svg { width: 34px; height: 34px; stroke: #FFFFFF; stroke-width: 2.5; fill: none; }
</style>

<!-- ════════════════════════════════════════════════════
     CHECKOUT MODAL MARKUP
════════════════════════════════════════════════════ -->
<div class="checkout-backdrop" id="checkoutBackdrop" role="dialog" aria-modal="true" aria-label="Secure Checkout" aria-hidden="true" inert>
    <div class="checkout-wrapper">
        
        <!-- Header -->
        <div class="co-header">
            <div class="co-header-brand">
                <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/Shared/Asset/images/logo.png';" alt="DT Brand's" style="height:32px; width:auto; max-width:130px; object-fit:contain;">
                <div class="co-title-group">
                    <h2>Secure Luxury Checkout</h2>
                    <span>DT Brand's & Jai Hanuman Tex</span>
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
                <span>Order Confirmation</span>
            </div>
        </div>

        <!-- Body Grid -->
        <div class="co-content-body">
            
            <!-- Left Column: Details & Payment -->
            <div class="co-form-column">
                
                <!-- 1. Customer Details -->
                <div class="co-section-card">
                    <div class="co-sec-header">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <h3 class="co-sec-title">1. Customer Information</h3>
                    </div>
                    <div class="co-grid-2">
                        <div class="co-input-group">
                            <label class="co-label" for="coFullName">Full Name <span class="required">*</span></label>
                            <input type="text" id="coFullName" class="co-input" placeholder="e.g. Radhika Sharma" required>
                        </div>
                        <div class="co-input-group">
                            <label class="co-label" for="coWhatsApp">WhatsApp Mobile Number <span class="required">*</span></label>
                            <div class="co-phone-wrap">
                                <span class="co-phone-prefix">+91</span>
                                <input type="tel" id="coWhatsApp" class="co-input co-phone-input" placeholder="9876543210" maxlength="10" required>
                            </div>
                        </div>
                    </div>
                    <div class="co-input-group">
                        <label class="co-label" for="coEmail">Email Address (for Tax Invoice)</label>
                        <input type="email" id="coEmail" class="co-input" placeholder="radhika@example.com">
                    </div>
                </div>

                <!-- 2. Shipping Address -->
                <div class="co-section-card">
                    <div class="co-sec-header">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <h3 class="co-sec-title">2. Shipping Address</h3>
                    </div>
                    <div class="co-input-group">
                        <label class="co-label" for="coAddress">Address / Building / Street <span class="required">*</span></label>
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
                        <textarea id="coNote" class="co-textarea" placeholder="e.g. Blouse size 38, or gift wrap in royal luxury box"></textarea>
                    </div>
                </div>

                <!-- 3. Payment Preference -->
                <div class="co-section-card">
                    <div class="co-sec-header">
                        <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        <h3 class="co-sec-title">3. Payment Preference</h3>
                    </div>
                    <div class="co-payment-options">
                        
                        <!-- ⚡ Option 1: Instant Direct UPI (0% Fee) -->
                        <div class="co-pay-option selected" data-method="direct_upi" onclick="window.selectPaymentMethod('direct_upi')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon upi">
                                <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">Instant UPI / Apps / QR <span class="co-pay-tag">⚡ 0% Fee • Instant</span></div>
                                <div class="co-pay-desc">Auto-opens GPay, PhonePe, Paytm, CRED on mobile or scans QR on desktop</div>
                            </div>
                        </div>

                        <!-- 💳 Option 2: Razorpay Online Cards & NetBanking -->
                        <div class="co-pay-option" data-method="razorpay" onclick="window.selectPaymentMethod('razorpay')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon cards">
                                <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">Credit / Debit Cards & NetBanking <span class="co-pay-tag">Cards & Banks</span></div>
                                <div class="co-pay-desc">Visa, Mastercard, RuPay, 50+ Banks Netbanking, Wallets & EMI</div>
                            </div>
                        </div>

                        <!-- 🚚 Option 3: Cash on Delivery (COD) -->
                        <div class="co-pay-option" data-method="cod" onclick="window.selectPaymentMethod('cod')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon cod">
                                <svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">Cash on Delivery (COD)</div>
                                <div class="co-pay-desc">Pay cash upon doorstep courier delivery</div>
                            </div>
                        </div>

                        <!-- 💬 Option 4: Direct WhatsApp Concierge Order -->
                        <div class="co-pay-option" data-method="whatsapp" onclick="window.selectPaymentMethod('whatsapp')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon wa">
                                <svg viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">Direct WhatsApp Order & Pay <span class="co-pay-tag">Stylist Support</span></div>
                                <div class="co-pay-desc">Order directly on WhatsApp with customized styling assistance</div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Right Column: Order Summary & Place Order -->
            <div class="co-summary-column">
                
                <div class="co-sec-header">
                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    <h3 class="co-sec-title">Order Items (<span id="coItemCount">0</span>)</h3>
                </div>

                <div class="co-items-list" id="coItemsList">
                    <!-- Cart items rendered here -->
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
                        <span>GST & Taxes</span>
                        <span style="color: #15803D; font-weight: 700;">Included</span>
                    </div>
                    <div class="co-price-row total">
                        <span>Grand Total</span>
                        <span class="val" id="coGrandTotalVal">₹0</span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button class="co-submit-btn" id="coPlaceOrderBtn">
                    <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                    <span>Proceed to Pay (Instant UPI)</span>
                </button>

                <div style="font-size: 0.7rem; color: #64748B; text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>100% Secure Checkout • 100% Original Products • Fast Exchange</span>
                </div>

            </div>

        </div>

        <!-- ══════════════════════════════════════════════════
             UPI INTERACTIVE STUDIO MODAL (DYNAMIC QR & APPS)
        ══════════════════════════════════════════════════ -->
        <div class="co-upi-modal-overlay" id="coUpiModalOverlay">
            <div class="co-upi-modal-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <h3 style="margin:0; font-family:var(--font-serif); font-size:1.05rem; color:#8A681F;">⚡ Instant UPI Payment</h3>
                    <button type="button" style="background:none; border:none; font-size:18px; cursor:pointer; color:#64748B;" onclick="document.getElementById('coUpiModalOverlay').classList.remove('active')">✕</button>
                </div>

                <div class="co-upi-timer-badge">
                    <span>⏱ Session Expires in: <strong id="coUpiCountdown">04:59</strong></span>
                </div>

                <!-- Order Amount Header -->
                <div style="background:#FAF8F4; padding:8px 12px; border-radius:8px; margin-bottom:12px; border:1px solid #D4AF37;">
                    <div style="font-size:0.75rem; color:#64748B;">Amount Payable:</div>
                    <div style="font-size:1.3rem; font-weight:800; color:#111827;" id="coUpiModalAmount">₹0</div>
                    <div style="font-size:0.72rem; color:#8A681F; font-weight:700;" id="coUpiModalOrderNum">Order #KLN-000000</div>
                </div>

                <!-- Desktop Dynamic QR Section -->
                <div id="coUpiQrSection">
                    <div class="co-upi-qr-wrapper">
                        <img id="coUpiDynamicQrImg" src="" alt="Scan & Pay QR" style="width:100%; height:100%; object-fit:contain;">
                    </div>
                    <div style="font-size:0.74rem; color:#64748B; margin-bottom:8px;">
                        Scan with <strong>Google Pay, PhonePe, Paytm, BHIM</strong>
                    </div>
                </div>

                <!-- Mobile 1-Tap App Launcher Buttons -->
                <div style="margin-bottom:12px;">
                    <a href="#" id="coDirectUpiIntentBtn" class="co-submit-btn" style="padding:10px; font-size:0.82rem; margin-bottom:8px; text-decoration:none;">
                        <span>📱 Open Default UPI App (Pay Now)</span>
                    </a>
                    <div class="co-upi-app-grid">
                        <a href="#" id="coGpayLink" class="co-upi-app-btn"><span>Google Pay</span></a>
                        <a href="#" id="coPhonepeLink" class="co-upi-app-btn"><span>PhonePe</span></a>
                        <a href="#" id="coPaytmLink" class="co-upi-app-btn"><span>Paytm</span></a>
                        <a href="#" id="coCredLink" class="co-upi-app-btn"><span>CRED / BHIM</span></a>
                    </div>
                </div>

                <!-- UPI ID Copy Strip -->
                <div style="display:flex; align-items:center; justify-content:space-between; padding:8px 10px; background:#F1F5F9; border-radius:6px; margin-bottom:14px; font-size:0.75rem;">
                    <span style="color:#475569;">UPI VPA: <strong id="coUpiVpaText">917046363528@okaxis</strong></span>
                    <button type="button" class="co-coupon-btn" style="padding:4px 8px; font-size:0.7rem;" onclick="copyUpiVpa()">Copy</button>
                </div>

                <!-- 12-Digit UTR Input Form -->
                <div style="border-top:1px solid #E2E8F0; padding-top:12px; text-align:left;">
                    <label style="font-size:0.75rem; font-weight:700; color:#111827; display:block; margin-bottom:4px;">Enter 12-Digit UPI UTR / Reference No. (after paying):</label>
                    <div style="display:flex; gap:6px;">
                        <input type="text" id="coUpiUtrInput" class="co-input" placeholder="e.g. 423891028392" maxlength="12" style="font-size:0.8rem; font-weight:700; letter-spacing:0.05em;">
                        <button type="button" id="coSubmitUtrBtn" class="co-coupon-btn" style="white-space:nowrap;" onclick="submitUpiUtr()">Submit & Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════
             SUCCESS OVERLAY
        ══════════════════════════════════════════════════ -->
        <div class="co-success-overlay" id="coSuccessOverlay">
            <div class="co-success-seal">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h2 style="font-family:var(--font-serif); font-size:1.4rem; color:var(--co-gold-primary); margin:0 0 6px;">Order Placed Successfully!</h2>
            <div style="display:inline-block; padding:4px 14px; border-radius:20px; background:#FAF5E8; color:#8A681F; font-size:0.82rem; font-weight:800; border:1px solid #D4AF37; margin-bottom:12px;" id="coSuccessOrderId">#KLN-847291</div>
            <p style="font-size:0.84rem; color:#5A5348; max-width:380px; line-height:1.5; margin:0 0 20px;" id="coSuccessDesc">
                Thank you for choosing DT Brand's & Jai Hanuman Tex. Your order invoice has been generated and queued for priority dispatch.
            </p>
            <div style="display:flex; flex-direction:column; gap:10px; width:100%; max-width:320px;">
                <a href="#" class="co-submit-btn" id="coSuccessWhatsAppLink" target="_blank" style="background:#25D366; border-color:#128C7E; color:#FFFFFF; text-decoration:none;">
                    <svg style="width:18px;height:18px;fill:currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                    <span>Track on Official WhatsApp</span>
                </a>
                <button type="button" class="co-coupon-btn" style="background:#FAF8F4; border:1.5px solid #8A681F; color:#8A681F;" onclick="window.closeCheckout(); if(typeof window.renderCart==='function')window.renderCart();">Continue Shopping</button>
            </div>
        </div>

    </div>
</div>

<!-- ════════════════════════════════════════════════════
     CHECKOUT CONTROLLER SCRIPT
════════════════════════════════════════════════════ -->
<script>
(function() {
    'use strict';

    var activePaymentMethod = 'direct_upi';
    var appliedDiscountAmount = 0;
    var appliedCouponCode = '';
    var currentOrderData = null;
    var upiTimerInterval = null;

    var BRAND_WHATSAPP_NUMBER = '917046363528';

    /* Global open/close triggers */
    window.openCheckout = function() {
        var modal = document.getElementById('checkoutBackdrop');
        if (!modal) return;
        if (typeof window.closeCartDrawer === 'function') window.closeCartDrawer();

        var cart = window.cartState || JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
        if (!cart || cart.length === 0) {
            alert('Your shopping bag is empty! Add items to checkout.');
            return;
        }

        var successOverlay = document.getElementById('coSuccessOverlay');
        if (successOverlay) successOverlay.classList.remove('active');
        var upiOverlay = document.getElementById('coUpiModalOverlay');
        if (upiOverlay) upiOverlay.classList.remove('active');

        window.renderCheckoutItems();
        modal.removeAttribute('inert');
        modal.setAttribute('aria-hidden', 'false');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    window.openCheckoutModal = window.openCheckout;

    window.closeCheckout = function() {
        var modal = document.getElementById('checkoutBackdrop');
        if (modal) {
            modal.classList.remove('active');
            modal.setAttribute('aria-hidden', 'true');
            modal.setAttribute('inert', '');
        }
        document.body.style.overflow = '';
        if (upiTimerInterval) clearInterval(upiTimerInterval);
    };

    window.closeCheckoutModal = window.closeCheckout;

    window.selectPaymentMethod = function(method) {
        activePaymentMethod = method;
        document.querySelectorAll('.co-pay-option').forEach(function(opt) {
            opt.classList.toggle('selected', opt.dataset.method === method);
        });

        var btnTxt = document.querySelector('#coPlaceOrderBtn span');
        if (btnTxt) {
            if (method === 'direct_upi') {
                btnTxt.textContent = 'Proceed to Pay (Instant UPI)';
            } else if (method === 'razorpay') {
                btnTxt.textContent = 'Pay with Cards / NetBanking';
            } else if (method === 'cod') {
                btnTxt.textContent = 'Confirm Cash on Delivery Order';
            } else {
                btnTxt.textContent = 'Confirm & Order via WhatsApp';
            }
        }
    };

    /* Render Cart Items */
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

        cart.forEach(function(item) {
            var priceNum = parseInt(String(item.price).replace(/[^0-9]/g, ''), 10) || 0;
            var qty = item.qty || 1;
            var itemTotal = priceNum * qty;
            subtotal += itemTotal;
            var imgSrc = item.image || item.img || '/assets/images/product1.png';
            var itemName = item.name || item.title || 'Ethnic Attire';

            html += `
                <div class="co-item-row">
                    <img src="${imgSrc}" alt="${itemName}" class="co-item-img" onerror="this.src='/assets/images/product1.png';">
                    <div class="co-item-info">
                        <div class="co-item-name">${itemName}</div>
                        <div class="co-item-meta">Size: <strong>${item.size || 'Free Size'}</strong> | Color: <strong>${item.color || 'Standard'}</strong> | Qty: <strong>${qty}</strong></div>
                        <div class="co-item-price">₹${itemTotal.toLocaleString('en-IN')}</div>
                    </div>
                </div>
            `;
        });

        listContainer.innerHTML = html;

        var grandTotal = Math.max(0, subtotal - appliedDiscountAmount);
        var subtotalEl = document.getElementById('coSubtotalVal');
        var discountRow = document.getElementById('coDiscountRow');
        var discountEl = document.getElementById('coDiscountVal');
        var grandTotalEl = document.getElementById('coGrandTotalVal');

        if (subtotalEl) subtotalEl.textContent = '₹' + subtotal.toLocaleString('en-IN');
        if (discountRow && discountEl) {
            if (appliedDiscountAmount > 0) {
                discountRow.style.display = 'flex';
                discountEl.textContent = '-₹' + appliedDiscountAmount.toLocaleString('en-IN');
            } else {
                discountRow.style.display = 'none';
            }
        }
        if (grandTotalEl) grandTotalEl.textContent = '₹' + grandTotal.toLocaleString('en-IN');
    };

    /* Coupon Logic */
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

    /* Master Order Placement */
    function handlePlaceOrder() {
        var fullName = document.getElementById('coFullName').value.trim();
        var whatsApp = document.getElementById('coWhatsApp').value.trim();
        var email = document.getElementById('coEmail').value.trim();
        var address = document.getElementById('coAddress').value.trim();
        var pincode = document.getElementById('coPincode').value.trim();
        var city = document.getElementById('coCity').value.trim();
        var state = document.getElementById('coState').value.trim();
        var note = document.getElementById('coNote').value.trim();

        if (!fullName) { alert('Please enter your Full Name.'); document.getElementById('coFullName').focus(); return; }
        if (!whatsApp || whatsApp.length < 10) { alert('Please enter a valid 10-digit WhatsApp number.'); document.getElementById('coWhatsApp').focus(); return; }
        if (!address) { alert('Please enter your Delivery Address.'); document.getElementById('coAddress').focus(); return; }
        if (!pincode || pincode.length < 6) { alert('Please enter a valid 6-digit Pincode.'); document.getElementById('coPincode').focus(); return; }

        var cart = window.cartState || JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
        if (cart.length === 0) { alert('Your bag is empty.'); return; }

        var subtotal = cart.reduce(function(sum, item) {
            var p = parseInt(String(item.price).replace(/[^0-9]/g, ''), 10) || 0;
            return sum + (p * (item.qty || 1));
        }, 0);
        var grandTotal = Math.max(0, subtotal - appliedDiscountAmount);
        var randomNum = Math.floor(100000 + Math.random() * 900000);
        var orderNum = 'KLN-' + randomNum;

        var orderPayload = {
            order_number: orderNum,
            customer_name: fullName,
            customer_phone: whatsApp,
            customer_email: email,
            gateway: activePaymentMethod,
            amount: grandTotal,
            address: address,
            city: city,
            state: state,
            pincode: pincode,
            note: note,
            items: cart
        };

        var placeBtn = document.getElementById('coPlaceOrderBtn');
        placeBtn.disabled = true;
        placeBtn.innerHTML = '<span>Processing Order...</span>';

        // 1. Save Base Order in MySQL
        var orderFormData = new URLSearchParams();
        orderFormData.append('action', 'create');
        orderFormData.append('customer_name', fullName);
        orderFormData.append('customer_phone', whatsApp);
        orderFormData.append('payment_method', activePaymentMethod);
        orderFormData.append('discount', appliedDiscountAmount);
        orderFormData.append('items', JSON.stringify(cart));

        fetch('/api/orders.php', { method: 'POST', body: orderFormData })
        .then(r => r.json())
        .then(res => {
            if (res.order && res.order.order_number) {
                orderNum = res.order.order_number;
                orderPayload.order_number = orderNum;
            }
            return fetch('/api/payment/create_order.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(orderPayload)
            });
        })
        .then(r => r.json())
        .then(data => {
            placeBtn.disabled = false;
            window.selectPaymentMethod(activePaymentMethod);

            currentOrderData = {
                order_number: orderNum,
                amount: grandTotal,
                customer_name: fullName,
                customer_phone: whatsApp,
                address: `${address}, ${city}, ${state} - ${pincode}`,
                note: note,
                cart: cart
            };

            if (activePaymentMethod === 'direct_upi' && data.success && data.data) {
                launchUpiStudio(data.data, currentOrderData);
            } else if (activePaymentMethod === 'razorpay' && data.success) {
                launchRazorpayCheckout(data, currentOrderData);
            } else {
                // COD / WhatsApp Order Finalization
                completeOrderSuccess(orderNum, currentOrderData);
            }
        })
        .catch(err => {
            placeBtn.disabled = false;
            window.selectPaymentMethod(activePaymentMethod);
            // Fallback: Direct WhatsApp Order Routing
            completeOrderSuccess(orderNum, {
                order_number: orderNum,
                amount: grandTotal,
                customer_name: fullName,
                customer_phone: whatsApp,
                address: `${address}, ${city}, ${state} - ${pincode}`,
                note: note,
                cart: cart
            });
        });
    }

    /* ── Instant UPI Studio Modal Controller ── */
    function launchUpiStudio(upiData, order) {
        var modal = document.getElementById('coUpiModalOverlay');
        if (!modal) return;

        document.getElementById('coUpiModalAmount').textContent = '₹' + order.amount.toLocaleString('en-IN');
        document.getElementById('coUpiModalOrderNum').textContent = 'Order #' + order.order_number;
        document.getElementById('coUpiVpaText').textContent = upiData.upi_vpa;

        // Dynamic QR image
        var qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=${encodeURIComponent(upiData.upi_uri)}`;
        document.getElementById('coUpiDynamicQrImg').src = qrUrl;

        // Mobile Deep Links
        document.getElementById('coDirectUpiIntentBtn').href = upiData.upi_uri;
        document.getElementById('coGpayLink').href = upiData.app_links.gpay;
        document.getElementById('coPhonepeLink').href = upiData.app_links.phonepe;
        document.getElementById('coPaytmLink').href = upiData.app_links.paytm;
        document.getElementById('coCredLink').href = upiData.app_links.cred;

        modal.classList.add('active');

        // On mobile devices, automatically trigger deep link
        if (/Android|iPhone|iPad|iPod/i.test(navigator.userAgent) || window.innerWidth <= 768) {
            setTimeout(function() {
                window.location.href = upiData.upi_uri;
            }, 300);
        }

        // Start 5:00 countdown timer
        var secondsLeft = 300;
        var timerEl = document.getElementById('coUpiCountdown');
        if (upiTimerInterval) clearInterval(upiTimerInterval);
        upiTimerInterval = setInterval(function() {
            secondsLeft--;
            var mins = Math.floor(secondsLeft / 60);
            var secs = secondsLeft % 60;
            if (timerEl) timerEl.textContent = (mins < 10 ? '0' : '') + mins + ':' + (secs < 10 ? '0' : '') + secs;
            if (secondsLeft <= 0) {
                clearInterval(upiTimerInterval);
                if (timerEl) timerEl.textContent = 'Expired';
            }
        }, 1000);
    }

    /* Copy UPI VPA */
    window.copyUpiVpa = function() {
        var vpa = document.getElementById('coUpiVpaText').textContent;
        navigator.clipboard.writeText(vpa).then(() => alert('UPI ID ' + vpa + ' copied to clipboard!'));
    };

    /* Submit 12-Digit UTR */
    window.submitUpiUtr = function() {
        var utrInput = document.getElementById('coUpiUtrInput');
        var utr = utrInput ? utrInput.value.trim() : '';
        if (!utr || utr.length < 6) {
            alert('Please enter your 12-digit UPI Transaction Reference / UTR Number.');
            if (utrInput) utrInput.focus();
            return;
        }

        var btn = document.getElementById('coSubmitUtrBtn');
        btn.innerText = 'Verifying...';
        btn.disabled = true;

        fetch('/api/payment/verify.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                gateway: 'direct_upi',
                order_number: currentOrderData.order_number,
                utr_reference: utr
            })
        })
        .then(r => r.json())
        .then(data => {
            btn.innerText = 'Submit & Confirm';
            btn.disabled = false;
            document.getElementById('coUpiModalOverlay').classList.remove('active');
            completeOrderSuccess(currentOrderData.order_number, currentOrderData, utr);
        })
        .catch(err => {
            btn.innerText = 'Submit & Confirm';
            btn.disabled = false;
            document.getElementById('coUpiModalOverlay').classList.remove('active');
            completeOrderSuccess(currentOrderData.order_number, currentOrderData, utr);
        });
    };

    /* ── Razorpay Checkout Launcher ── */
    function launchRazorpayCheckout(rzpData, order) {
        function openRzp() {
            var options = {
                key: rzpData.key_id,
                amount: rzpData.amount_paise,
                currency: rzpData.currency || 'INR',
                name: "DT Brand's & Jai Hanuman Tex",
                description: 'Order #' + order.order_number,
                order_id: rzpData.gateway_order_id,
                prefill: {
                    name: order.customer_name,
                    contact: order.customer_phone,
                    email: order.customer_email || ''
                },
                theme: { color: '#8A681F' },
                handler: function(response) {
                    fetch('/api/payment/verify.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            gateway: 'razorpay',
                            order_number: order.order_number,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_signature: response.razorpay_signature
                        })
                    })
                    .then(r => r.json())
                    .then(() => completeOrderSuccess(order.order_number, order, response.razorpay_payment_id))
                    .catch(() => completeOrderSuccess(order.order_number, order, response.razorpay_payment_id));
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        }

        if (typeof Razorpay === 'undefined') {
            var script = document.createElement('script');
            script.src = 'https://checkout.razorpay.com/v1/checkout.js';
            script.onload = openRzp;
            document.head.appendChild(script);
        } else {
            openRzp();
        }
    }

    /* Complete Order Success Screen & WhatsApp Sync */
    function completeOrderSuccess(orderNum, order, refId) {
        var successOverlay = document.getElementById('coSuccessOverlay');
        var successOrderId = document.getElementById('coSuccessOrderId');
        var successWaLink = document.getElementById('coSuccessWhatsAppLink');

        if (successOrderId) successOrderId.textContent = '#' + orderNum;

        // Build luxury WhatsApp invoice text
        var itemsTxt = '';
        (order.cart || []).forEach(function(it, i) {
            var p = parseInt(String(it.price).replace(/[^0-9]/g, ''), 10) || 0;
            var q = it.qty || 1;
            itemsTxt += `${i + 1}. *${it.name || 'Ethnic Attire'}* (Size: ${it.size || 'Free Size'}, Qty: ${q}) — ₹${(p * q).toLocaleString('en-IN')}\n`;
        });

        var upiDeep = `upi://pay?pa=917046363528@okaxis&pn=DT%20Brands&am=${order.amount}&cu=INR&tr=${orderNum}`;

        var msg = `👑 *DT BRAND'S ETHNIC LUXURY — ORDER CONFIRMATION*\n\n` +
                  `🔖 *Order Number:* #${orderNum}\n` +
                  `👤 *Customer Name:* ${order.customer_name}\n` +
                  `📞 *WhatsApp:* +91 ${order.customer_phone}\n` +
                  `📍 *Shipping Address:* ${order.address}\n` +
                  (order.note ? `📝 *Custom Note:* ${order.note}\n` : '') +
                  `───────────────\n` +
                  `🛍️ *ORDERED ITEMS:*\n${itemsTxt}` +
                  `───────────────\n` +
                  `✨ *GRAND TOTAL:* ₹${order.amount.toLocaleString('en-IN')}\n` +
                  `💳 *Payment Method:* ${activePaymentMethod.toUpperCase()}` + (refId ? ` (Ref/UTR: ${refId})` : '') + `\n` +
                  `⚡ *Instant UPI Link:* ${upiDeep}\n\n` +
                  `Please confirm order booking and dispatch tracking. Thank you! 🙏`;

        var waUrl = `https://api.whatsapp.com/send?phone=${BRAND_WHATSAPP_NUMBER}&text=${encodeURIComponent(msg)}`;

        if (successWaLink) successWaLink.href = waUrl;
        if (successOverlay) successOverlay.classList.add('active');

        // Clear cart
        localStorage.removeItem('dtbrands_cart');
        window.cartState = [];
        if (typeof window.updateGlobalBadges === 'function') window.updateGlobalBadges();
        if (typeof window.syncBadges === 'function') window.syncBadges();
        if (typeof window.renderCart === 'function') window.renderCart();

        if (activePaymentMethod === 'whatsapp') {
            window.open(waUrl, '_blank');
        }
    }

    /* Event Listeners */
    document.addEventListener('DOMContentLoaded', function() {
        var closeBtn = document.getElementById('closeCheckoutBtn');
        if (closeBtn) closeBtn.addEventListener('click', window.closeCheckout);

        var backdrop = document.getElementById('checkoutBackdrop');
        if (backdrop) {
            backdrop.addEventListener('click', function(e) {
                if (e.target === backdrop) window.closeCheckout();
            });
        }

        var applyBtn = document.getElementById('coApplyCouponBtn');
        if (applyBtn) applyBtn.addEventListener('click', applyCoupon);

        var placeBtn = document.getElementById('coPlaceOrderBtn');
        if (placeBtn) placeBtn.addEventListener('click', handlePlaceOrder);
    });

})();
</script>
