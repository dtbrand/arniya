<?php
/**
 * checkout.php — Standalone & Modal Partial Component
 * Next-Level Luxury Multi-Gateway Checkout Engine
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
     NEXT-LEVEL LUXURY CHECKOUT STYLES
════════════════════════════════════════════════════ -->
<style>
/* ── Design Tokens ── */
:root {
    --co-gold-primary: #8A681F;
    --co-gold-deep: #6F5218;
    --co-gold-light: #C5A859;
    --co-gold-bg: #FAF5E8;
    --co-gold-border: rgba(138, 104, 31, 0.28);
    --co-dark-text: #111827;
    --co-mid-text: #334155;
    --co-light-text: #64748B;
    --co-cream-bg: #FCFBF8;
    --co-white: #FFFFFF;
    --co-green: #15803D;
    --co-green-bg: #DCFCE7;
    --co-wa-green: #25D366;
    --co-wa-dark: #128C7E;
    --co-shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
    --co-shadow-md: 0 8px 24px rgba(138,104,31,0.12);
    --co-shadow-lg: 0 16px 40px rgba(0,0,0,0.22);
}

@property --dt-border-angle {
    syntax: "<angle>";
    inherits: false;
    initial-value: 0deg;
}

@keyframes dtBorderRotate {
    to { --dt-border-angle: 360deg; }
}

@keyframes dtGoldPlatinumGlow {
    0% { box-shadow: 0 0 8px rgba(212, 175, 55, 0.45), 0 0 16px rgba(226, 232, 240, 0.35); }
    100% { box-shadow: 0 0 16px rgba(212, 175, 55, 0.75), 0 0 28px rgba(255, 255, 255, 0.6); }
}

@keyframes dtQrScanLaser {
    0% { top: 6px; opacity: 0.8; }
    50% { top: calc(100% - 10px); opacity: 1; }
    100% { top: 6px; opacity: 0.8; }
}

@keyframes dtPulseGlow {
    0% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(21, 128, 61, 0.5); }
    70% { transform: scale(1.04); box-shadow: 0 0 0 10px rgba(21, 128, 61, 0); }
    100% { transform: scale(0.96); box-shadow: 0 0 0 0 rgba(21, 128, 61, 0); }
}

@keyframes dtSparklePop {
    0% { transform: scale(0.8); opacity: 0; }
    50% { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); opacity: 1; }
}

/* Modal Backdrop */
.checkout-backdrop {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(20, 16, 12, 0.84);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
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

/* Main Container */
.checkout-wrapper {
    background: var(--co-cream-bg);
    width: 100%;
    max-width: 1140px;
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
    font-family: 'Inter', 'Plus Jakarta Sans', -apple-system, sans-serif;
    -webkit-font-smoothing: antialiased;
    letter-spacing: -0.011em;
    color: var(--co-dark-text);
}
@media (min-width: 900px) {
    .checkout-wrapper {
        height: 94vh;
        max-height: 860px;
        border-radius: 16px;
        transform: scale(0.96);
    }
}
.checkout-backdrop.active .checkout-wrapper {
    transform: translateY(0) scale(1);
}

/* Header */
.co-header {
    background: #FFFFFF;
    border-bottom: 2px solid var(--co-gold-primary);
    padding: clamp(10px, 2vw, 16px) clamp(14px, 3vw, 26px);
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
    font-family: 'Cinzel', serif;
    font-size: clamp(1rem, 2.5vw, 1.25rem);
    font-weight: 800;
    color: var(--co-gold-primary);
    margin: 0;
    letter-spacing: 0.04em;
}
.co-title-group span {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--co-light-text);
    letter-spacing: 0.08em;
    text-transform: uppercase;
}
.co-close-btn {
    width: 34px;
    height: 34px;
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
    transform: rotate(90deg);
}

/* Progress Steps */
.co-progress-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 18px;
    background: #FAF8F4;
    padding: 9px 16px;
    border-bottom: 1px solid var(--co-gold-border);
    flex-shrink: 0;
}
.co-step-pill {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 0.74rem;
    font-weight: 800;
    color: var(--co-light-text);
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.co-step-pill.active {
    color: var(--co-gold-primary);
}
.co-step-num {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #DDD8CD;
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.68rem;
    font-weight: 800;
}
.co-step-pill.active .co-step-num {
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
    box-shadow: 0 2px 6px rgba(184, 134, 11, 0.35);
}
.co-step-divider {
    width: 32px;
    height: 2px;
    background: #DDD8CD;
}

/* Body Layout */
.co-content-body {
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
@media (min-width: 900px) {
    .co-content-body {
        display: grid;
        grid-template-columns: 1.38fr 1fr;
        overflow: hidden;
    }
}

/* Form Section */
.co-form-column {
    padding: clamp(14px, 3vw, 24px);
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.co-section-card {
    background: #FFFFFF;
    border: 1.5px solid var(--co-gold-border);
    border-radius: 12px;
    padding: clamp(14px, 2.5vw, 20px);
    box-shadow: var(--co-shadow-sm);
}
.co-sec-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(138,104,31,0.14);
}
.co-sec-header svg {
    width: 20px;
    height: 20px;
    stroke: var(--co-gold-primary);
    stroke-width: 2.2;
    fill: none;
}
.co-sec-title {
    font-family: 'Cinzel', serif;
    font-size: clamp(0.86rem, 2.2vw, 0.98rem);
    font-weight: 800;
    color: var(--co-gold-primary);
    margin: 0;
}

/* Form Inputs with Animated Gold & Platinum Focus Line */
.co-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
@media (max-width: 600px) {
    .co-grid-2 { grid-template-columns: 1fr; }
}
.co-input-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin-bottom: 10px;
}
.co-label {
    font-size: 0.74rem;
    font-weight: 700;
    color: #1F2937;
}
.co-label .required { color: #DC2626; font-weight: 800; }
.co-input, .co-textarea {
    width: 100%;
    padding: 10px 13px;
    border-radius: 8px;
    border: 1.5px solid #DDD8CD;
    background: #FAF9F5;
    font-family: inherit;
    font-size: 0.84rem;
    font-weight: 600;
    color: #111827;
    box-sizing: border-box;
    transition: all 0.2s ease;
}

/* Animated Gold & Platinum Mix Running Line on Focus */
.co-input:focus, .co-textarea:focus, .co-phone-wrap:focus-within {
    outline: none !important;
    border: 2px solid transparent !important;
    background: linear-gradient(#FFFFFF, #FFFFFF) padding-box,
                conic-gradient(from var(--dt-border-angle), #D4AF37 0deg, #FFFFFF 60deg, #E2E8F0 120deg, #D4AF37 180deg, #FFFFFF 240deg, #B8860B 300deg, #D4AF37 360deg) border-box !important;
    animation: dtBorderRotate 2s linear infinite, dtGoldPlatinumGlow 1.5s ease-in-out infinite alternate !important;
    color: #111827 !important;
}

.co-phone-wrap {
    display: flex;
    align-items: center;
    border: 1.5px solid #DDD8CD;
    border-radius: 8px;
    background: #FAF9F5;
    overflow: hidden;
    transition: all 0.2s ease;
}
.co-phone-prefix {
    padding: 0 12px;
    font-size: 0.84rem;
    font-weight: 800;
    color: var(--co-gold-primary);
    background: #F0EAD8;
    height: 40px;
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
    gap: 12px;
}
.co-pay-option {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: 12px;
    border: 1.5px solid #DDD8CD;
    background: #FAF9F5;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
}
.co-pay-option:hover {
    border-color: var(--co-gold-primary);
    background: #FFFFFF;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(138, 104, 31, 0.08);
}
.co-pay-option.selected {
    border-color: #8A681F;
    background: #FCF8EE;
    box-shadow: 0 4px 16px rgba(138,104,31,0.16);
    border-width: 2px;
}
.co-pay-radio {
    width: 20px;
    height: 20px;
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
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: var(--co-gold-primary);
}
.co-pay-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.co-pay-icon.upi { background: linear-gradient(135deg, #FAF5E8 0%, #EDE7F6 100%); color: #673AB7; }
.co-pay-icon.cards { background: linear-gradient(135deg, #F0F9FF 0%, #E0F2FE 100%); color: #0284C7; }
.co-pay-icon.cod { background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 100%); color: #D97706; }
.co-pay-icon.wa { background: linear-gradient(135deg, #F0FDF4 0%, #DCFCE7 100%); color: var(--co-wa-green); }
.co-pay-icon svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 2.2; }
.co-pay-text { flex: 1; min-width: 0; }
.co-pay-name {
    font-size: 0.88rem;
    font-weight: 800;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 8px;
}
.co-pay-tag {
    font-size: 0.6rem;
    padding: 3px 8px;
    border-radius: 12px;
    background: #E8F5E9;
    color: #15803D;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.co-pay-desc {
    font-size: 0.72rem;
    font-weight: 500;
    color: #64748B;
    margin-top: 3px;
}

/* Right Summary Column */
.co-summary-column {
    background: #FFFFFF;
    padding: clamp(14px, 3vw, 26px);
    display: flex;
    flex-direction: column;
    gap: 16px;
    border-top: 1px solid var(--co-gold-border);
    overflow-y: auto;
}
@media (min-width: 900px) {
    .co-summary-column { border-top: none; }
}
.co-items-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 230px;
    overflow-y: auto;
    scrollbar-width: thin;
}
.co-item-row {
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 10px;
    border-radius: 10px;
    background: #FAF8F4;
    border: 1px solid var(--co-gold-border);
}
.co-item-img {
    width: 48px;
    height: 64px;
    aspect-ratio: 3/4;
    border-radius: 6px;
    object-fit: cover;
    border: 1px solid var(--co-gold-border);
}
.co-item-info { flex: 1; min-width: 0; }
.co-item-name {
    font-size: 0.84rem;
    font-weight: 700;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.co-item-meta { font-size: 0.7rem; color: #64748B; font-weight: 500; }
.co-item-price { font-size: 0.82rem; font-weight: 800; color: #8A681F; }

/* Coupon & Price Breakdown */
.co-coupon-wrap { display: flex; gap: 8px; }
.co-coupon-input {
    flex: 1;
    padding: 9px 12px;
    border-radius: 8px;
    border: 1.5px solid #DDD8CD;
    background: #FAF9F5;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
}
.co-coupon-btn {
    padding: 9px 18px;
    border-radius: 8px;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
    border: 1px solid #8A681F;
    color: #111827;
    font-weight: 800;
    font-size: 0.78rem;
    cursor: pointer;
    transition: all 0.2s;
}
.co-price-breakdown {
    background: #FAF9F5;
    padding: 14px;
    border-radius: 12px;
    border: 1px solid var(--co-gold-border);
    display: flex;
    flex-direction: column;
    gap: 8px;
    font-size: 0.82rem;
}
.co-price-row { display: flex; justify-content: space-between; color: #475569; font-weight: 500; }
.co-price-row.total {
    border-top: 1.5px solid var(--co-gold-primary);
    padding-top: 10px;
    margin-top: 4px;
    font-size: 1.05rem;
    font-weight: 800;
    color: #111827;
}
.co-price-row.total .val { color: var(--co-gold-primary); font-weight: 900; }

/* Radiant Gold Master Submit Button */
.co-submit-btn {
    padding: 14px 22px;
    border-radius: 12px;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    border: 1.2px solid #8A681F;
    color: #111827;
    font-weight: 800;
    font-size: 0.92rem;
    letter-spacing: -0.011em;
    cursor: pointer;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 4px 14px rgba(184,134,11,0.38);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.co-submit-btn:hover {
    background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
    transform: translateY(-2px);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.5), 0 6px 20px rgba(184,134,11,0.5);
}
.co-submit-btn svg { width: 20px; height: 20px; stroke: #111827; stroke-width: 2.4; fill: none; }

/* UPI Interactive Modal (Dynamic QR & Intent) */
.co-upi-modal-overlay {
    position: absolute;
    inset: 0;
    background: rgba(17, 24, 39, 0.92);
    backdrop-filter: blur(8px);
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
    border-radius: 16px;
    width: 100%;
    max-width: 450px;
    padding: 24px;
    text-align: center;
    border: 2px solid #D4AF37;
    box-shadow: 0 16px 44px rgba(0,0,0,0.35);
    max-height: 90vh;
    overflow-y: auto;
}
.co-upi-qr-wrapper {
    position: relative;
    width: 190px;
    height: 190px;
    margin: 0 auto 12px;
    padding: 10px;
    border: 2px solid #D4AF37;
    border-radius: 12px;
    background: #FAF9F5;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.co-upi-qr-laser {
    position: absolute;
    left: 8px;
    right: 8px;
    height: 2.5px;
    background: linear-gradient(90deg, transparent 0%, #DC2626 50%, transparent 100%);
    box-shadow: 0 0 10px #DC2626, 0 0 20px #DC2626;
    animation: dtQrScanLaser 2.2s ease-in-out infinite;
    pointer-events: none;
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
    gap: 8px;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #CBD5E1;
    background: #F8FAFC;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    color: #1E293B;
    transition: all 0.2s;
}
.co-upi-app-btn:hover {
    background: #FAF5E8;
    border-color: #D4AF37;
    color: #8A681F;
    transform: translateY(-1px);
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
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    margin-bottom: 16px;
    box-shadow: 0 8px 24px rgba(37, 211, 102, 0.4);
}
.co-success-seal svg { width: 36px; height: 36px; stroke: #FFFFFF; stroke-width: 2.6; fill: none; }
</style>

<!-- ════════════════════════════════════════════════════
     CHECKOUT MODAL MARKUP
════════════════════════════════════════════════════ -->
<div class="checkout-backdrop" id="checkoutBackdrop" role="dialog" aria-modal="true" aria-label="Secure Checkout" aria-hidden="true" inert>
    <div class="checkout-wrapper">
        
        <!-- Header -->
        <div class="co-header">
            <div class="co-header-brand">
                <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/Shared/Asset/images/logo.png';" alt="DT Brand's" style="height:34px; width:auto; max-width:130px; object-fit:contain;">
                <div class="co-title-group">
                    <h2>Secure Luxury Checkout</h2>
                    <span>DT Brand's &amp; Jai Hanuman Tex</span>
                </div>
            </div>
            <button class="co-close-btn" id="closeCheckoutBtn" aria-label="Close Checkout">✕</button>
        </div>

        <!-- Progress Steps -->
        <div class="co-progress-bar">
            <div class="co-step-pill active" id="coStep1">
                <span class="co-step-num">1</span>
                <span>Shipping &amp; Payment</span>
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
                        <label class="co-label" for="coEmail">Email Address (for GST Tax Invoice)</label>
                        <input type="email" id="coEmail" class="co-input" placeholder="radhika@example.com">
                    </div>
                </div>

                <!-- 2. Shipping Address -->
                <div class="co-section-card">
                    <div class="co-sec-header">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        <h3 class="co-sec-title">2. Delivery Address</h3>
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
                        <label class="co-label" for="coNote">Special Custom Stitching Instructions / Box Note</label>
                        <textarea id="coNote" class="co-textarea" placeholder="e.g. Blouse size 38 stitching, or luxury gift packing requested"></textarea>
                    </div>
                </div>

                <!-- 3. Payment Preference -->
                <div class="co-section-card">
                    <div class="co-sec-header">
                        <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                        <h3 class="co-sec-title">3. Payment Method</h3>
                    </div>
                    <div class="co-payment-options">
                        
                        <!-- ⚡ Option 1: Instant Direct UPI (Recommended - 0% Fee) -->
                        <div class="co-pay-option selected" data-method="direct_upi" onclick="window.selectPaymentMethod('direct_upi')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon upi">
                                <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">
                                    <span>Instant UPI / Apps / QR</span>
                                    <span class="co-pay-tag">⚡ Recommended (0% Fee)</span>
                                </div>
                                <div class="co-pay-desc">Auto-opens GPay, PhonePe, Paytm, CRED on mobile or dynamic QR on desktop</div>
                            </div>
                        </div>

                        <!-- 💳 Option 2: Razorpay Online Cards & NetBanking -->
                        <div class="co-pay-option" data-method="razorpay" onclick="window.selectPaymentMethod('razorpay')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon cards">
                                <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">
                                    <span>Credit / Debit Cards &amp; NetBanking</span>
                                    <span class="co-pay-tag">50+ Banks</span>
                                </div>
                                <div class="co-pay-desc">Visa, Mastercard, RuPay, NetBanking, Wallets &amp; EMI</div>
                            </div>
                        </div>

                        <!-- 🚚 Option 3: Cash on Delivery (COD) -->
                        <div class="co-pay-option" data-method="cod" onclick="window.selectPaymentMethod('cod')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon cod">
                                <svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name"><span>Cash on Delivery (COD)</span></div>
                                <div class="co-pay-desc">Pay in cash upon doorstep courier delivery</div>
                            </div>
                        </div>

                        <!-- 💬 Option 4: Direct WhatsApp Concierge Order -->
                        <div class="co-pay-option" data-method="whatsapp" onclick="window.selectPaymentMethod('whatsapp')">
                            <div class="co-pay-radio"></div>
                            <div class="co-pay-icon wa">
                                <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </div>
                            <div class="co-pay-text">
                                <div class="co-pay-name">
                                    <span>Direct WhatsApp Order &amp; Pay</span>
                                    <span class="co-pay-tag">Stylist Help</span>
                                </div>
                                <div class="co-pay-desc">Instant booking with live concierge stylist on WhatsApp (+91 70463 63528)</div>
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
                <div id="coCouponMessage" style="font-size: 0.72rem; font-weight: 700; display: none;"></div>

                <!-- Price Breakdown -->
                <div class="co-price-breakdown">
                    <div class="co-price-row">
                        <span>Items Subtotal</span>
                        <span id="coSubtotalVal">₹0</span>
                    </div>
                    <div class="co-price-row discount" id="coDiscountRow" style="display: none; color: #15803D;">
                        <span>Luxury Discount</span>
                        <span id="coDiscountVal">-₹0</span>
                    </div>
                    <div class="co-price-row">
                        <span>⚡ Express Priority Delivery</span>
                        <span style="color: var(--co-green); font-weight: 800;">FREE DISPATCH</span>
                    </div>
                    <div class="co-price-row">
                        <span>GST &amp; Taxes</span>
                        <span style="color: #15803D; font-weight: 800;">Included (100% Tax Paid)</span>
                    </div>
                    <div class="co-price-row total">
                        <span>Grand Total</span>
                        <span class="val" id="coGrandTotalVal">₹0</span>
                    </div>
                </div>

                <!-- Master Place Order Button -->
                <button class="co-submit-btn" id="coPlaceOrderBtn">
                    <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path></svg>
                    <span>Proceed to Pay (Instant UPI)</span>
                </button>

                <div style="font-size: 0.72rem; color: #64748B; font-weight: 600; text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <span>100% Secure Checkout • Original Ethnic Product • 7-Day Exchange</span>
                </div>

            </div>

        </div>

        <!-- ══════════════════════════════════════════════════
             UPI INTERACTIVE STUDIO MODAL (DYNAMIC QR & APPS)
        ══════════════════════════════════════════════════ -->
        <div class="co-upi-modal-overlay" id="coUpiModalOverlay">
            <div class="co-upi-modal-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                    <h3 style="margin:0; font-family:'Cinzel', serif; font-size:1.1rem; font-weight:800; color:#8A681F;">⚡ Instant UPI Payment</h3>
                    <button type="button" style="background:none; border:none; font-size:18px; cursor:pointer; color:#64748B;" onclick="document.getElementById('coUpiModalOverlay').classList.remove('active')">✕</button>
                </div>

                <div style="display:inline-flex; align-items:center; gap:6px; padding:4px 12px; background:#FEF3C7; color:#B45309; border-radius:20px; font-size:0.75rem; font-weight:800; margin-bottom:12px;">
                    <span>⏱ Session Expires in: <strong id="coUpiCountdown">04:59</strong></span>
                </div>

                <!-- Order Amount Header -->
                <div style="background:#FAF8F4; padding:10px 14px; border-radius:10px; margin-bottom:14px; border:1.5px solid #D4AF37;">
                    <div style="font-size:0.75rem; color:#64748B; font-weight:700;">Amount Payable:</div>
                    <div style="font-size:1.4rem; font-weight:900; color:#111827;" id="coUpiModalAmount">₹0</div>
                    <div style="font-size:0.75rem; color:#8A681F; font-weight:800;" id="coUpiModalOrderNum">Order #KLN-000000</div>
                </div>

                <!-- Desktop Dynamic QR Section with Laser Ray -->
                <div id="coUpiQrSection">
                    <div class="co-upi-qr-wrapper">
                        <div class="co-upi-qr-laser"></div>
                        <img id="coUpiDynamicQrImg" src="" alt="Scan & Pay QR" style="width:100%; height:100%; object-fit:contain;">
                    </div>
                    <div style="font-size:0.75rem; color:#475569; font-weight:600; margin-bottom:10px;">
                        Scan with <strong>Google Pay, PhonePe, Paytm, BHIM, CRED</strong>
                    </div>
                </div>

                <!-- Mobile 1-Tap App Launcher Buttons -->
                <div style="margin-bottom:12px;">
                    <a href="#" id="coDirectUpiIntentBtn" class="co-submit-btn" style="padding:11px; font-size:0.84rem; margin-bottom:10px; text-decoration:none;">
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
                <div style="display:flex; align-items:center; justify-content:space-between; padding:9px 12px; background:#F1F5F9; border-radius:8px; margin-bottom:14px; font-size:0.78rem;">
                    <span style="color:#334155; font-weight:600;">UPI VPA: <strong id="coUpiVpaText">917046363528@okaxis</strong></span>
                    <button type="button" class="co-coupon-btn" style="padding:4px 10px; font-size:0.72rem;" onclick="copyUpiVpa()">Copy</button>
                </div>

                <!-- 12-Digit UTR Input Form -->
                <div style="border-top:1px solid #E2E8F0; padding-top:14px; text-align:left;">
                    <label style="font-size:0.76rem; font-weight:800; color:#111827; display:block; margin-bottom:5px;">Enter 12-Digit UPI UTR / Reference No. (after paying):</label>
                    <div style="display:flex; gap:6px;">
                        <input type="text" id="coUpiUtrInput" class="co-input" placeholder="e.g. 423891028392" maxlength="12" style="font-size:0.84rem; font-weight:800; letter-spacing:0.06em;">
                        <button type="button" id="coSubmitUtrBtn" class="co-coupon-btn" style="white-space:nowrap;" onclick="submitUpiUtr()">Submit &amp; Confirm</button>
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
            <h2 style="font-family:'Cinzel', serif; font-size:1.45rem; font-weight:800; color:var(--co-gold-primary); margin:0 0 6px;">Order Placed Successfully!</h2>
            <div style="display:inline-block; padding:4px 14px; border-radius:20px; background:#FAF5E8; color:#8A681F; font-size:0.84rem; font-weight:900; border:1px solid #D4AF37; margin-bottom:12px;" id="coSuccessOrderId">#KLN-847291</div>
            <p style="font-size:0.86rem; color:#475569; max-width:400px; line-height:1.5; margin:0 0 20px;" id="coSuccessDesc">
                Thank you for choosing DT Brand's &amp; Jai Hanuman Tex. Your order invoice has been generated and queued for priority dispatch.
            </p>
            <div style="display:flex; flex-direction:column; gap:10px; width:100%; max-width:320px;">
                <a href="#" class="co-submit-btn" id="coSuccessWhatsAppLink" target="_blank" style="background:#25D366; border-color:#128C7E; color:#FFFFFF; text-decoration:none;">
                    <svg style="width:20px;height:20px;stroke:#FFFFFF;" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
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
                msg.style.color = '#15803D';
                msg.textContent = '✨ Coupon ROYAL10 applied! 10% Royal Festive discount saved.';
            }
        } else if (code === 'FESTIVE500') {
            appliedDiscountAmount = Math.min(subtotal, 500);
            appliedCouponCode = 'FESTIVE500';
            if (msg) {
                msg.style.display = 'block';
                msg.style.color = '#15803D';
                msg.textContent = '✨ Coupon FESTIVE500 applied! Flat ₹500 discount saved.';
            }
        } else {
            appliedDiscountAmount = 0;
            appliedCouponCode = '';
            if (msg) {
                msg.style.display = 'block';
                msg.style.color = '#DC2626';
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
