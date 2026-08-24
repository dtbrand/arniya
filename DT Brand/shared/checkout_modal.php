<?php
/**
 * DT Brand/shared/checkout_modal.php — Universal Multi-Step Checkout Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ════════════ CHECKOUT MODAL ════════════ -->
<div class="dt-modal-overlay" id="dtCheckoutModalOverlay" aria-hidden="true">
    <div class="dt-modal dt-checkout-modal" id="dtCheckoutModal" role="dialog" aria-label="Secure Checkout">
        
        <!-- Header -->
        <div class="dt-modal-header">
            <div class="dt-modal-title-wrap">
                <span class="dt-secure-shield">🔒</span>
                <h3 class="dt-modal-title">Secure Checkout</h3>
            </div>
            <button type="button" class="dt-modal-close" onclick="closeCheckoutModal()" aria-label="Close">✕</button>
        </div>

        <!-- Step Indicator -->
        <div class="dt-checkout-steps">
            <div class="dt-step-item active" id="dtStepIndicator1">
                <span class="dt-step-num">1</span>
                <span class="dt-step-text">Delivery</span>
            </div>
            <div class="dt-step-line" id="dtStepLine1"></div>
            <div class="dt-step-item" id="dtStepIndicator2">
                <span class="dt-step-num">2</span>
                <span class="dt-step-text">Payment</span>
            </div>
            <div class="dt-step-line" id="dtStepLine2"></div>
            <div class="dt-step-item" id="dtStepIndicator3">
                <span class="dt-step-num">3</span>
                <span class="dt-step-text">Confirmation</span>
            </div>
        </div>

        <!-- Body -->
        <div class="dt-modal-body">
            
            <!-- Step 1: Address & Contact -->
            <div class="dt-checkout-step-content active" id="dtCheckoutStep1">
                <h4 class="dt-form-section-title">Shipping & Contact Details</h4>
                <div class="dt-form-grid">
                    <div class="dt-field-group">
                        <label class="dt-field-label">Full Name *</label>
                        <input type="text" class="dt-input-field" id="dtCoName" placeholder="e.g. Radhika Sharma" required />
                    </div>
                    <div class="dt-field-group">
                        <label class="dt-field-label">Mobile Number *</label>
                        <input type="tel" class="dt-input-field" id="dtCoPhone" placeholder="e.g. 9876543210" required />
                    </div>
                    <div class="dt-field-group full-width">
                        <label class="dt-field-label">Email Address (for invoice & tracking)</label>
                        <input type="email" class="dt-input-field" id="dtCoEmail" placeholder="e.g. radhika@gmail.com" />
                    </div>
                    <div class="dt-field-group full-width">
                        <label class="dt-field-label">Street Address / Shop No / Building *</label>
                        <textarea class="dt-input-field dt-textarea" id="dtCoAddress" rows="2" placeholder="Full delivery address with landmark" required></textarea>
                    </div>
                    <div class="dt-field-group">
                        <label class="dt-field-label">City *</label>
                        <input type="text" class="dt-input-field" id="dtCoCity" placeholder="e.g. Surat" required />
                    </div>
                    <div class="dt-field-group">
                        <label class="dt-field-label">State *</label>
                        <input type="text" class="dt-input-field" id="dtCoState" placeholder="e.g. Gujarat" required />
                    </div>
                    <div class="dt-field-group">
                        <label class="dt-field-label">Pincode *</label>
                        <input type="text" class="dt-input-field" id="dtCoPincode" placeholder="e.g. 395002" maxlength="6" required />
                    </div>
                    <div class="dt-field-group">
                        <label class="dt-field-label">GSTIN (Optional for Wholesale)</label>
                        <input type="text" class="dt-input-field" id="dtCoGst" placeholder="e.g. 24AAAAA0000A1Z5" />
                    </div>
                </div>

                <div class="dt-step-action-row">
                    <button type="button" class="dt-btn-gold" onclick="goToCheckoutStep(2)">
                        <span>Continue to Payment</span>
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
            </div>

            <!-- Step 2: Payment Options -->
            <div class="dt-checkout-step-content" id="dtCheckoutStep2" style="display:none;">
                <h4 class="dt-form-section-title">Select Payment Mode</h4>
                <div class="dt-payment-options">
                    <label class="dt-payment-option active">
                        <input type="radio" name="dtPaymentMode" value="upi" checked />
                        <div class="dt-payment-info">
                            <strong>Instant UPI / QR Code / Netbanking</strong>
                            <span>Fast verification & priority mill dispatch</span>
                        </div>
                        <span class="dt-payment-badge">Recommended</span>
                    </label>
                    <label class="dt-payment-option">
                        <input type="radio" name="dtPaymentMode" value="cod" />
                        <div class="dt-payment-info">
                            <strong>Cash on Delivery (COD)</strong>
                            <span>Pay at your doorstep upon verification</span>
                        </div>
                    </label>
                    <label class="dt-payment-option">
                        <input type="radio" name="dtPaymentMode" value="whatsapp_pay" />
                        <div class="dt-payment-info">
                            <strong>WhatsApp Pay / Direct Mill Transfer</strong>
                            <span>Connect with accounts concierge for RTGS/NEFT</span>
                        </div>
                    </label>
                </div>

                <!-- Order Summary Mini Strip -->
                <div class="dt-checkout-summary-mini">
                    <div class="dt-cs-row">
                        <span>Items Total:</span>
                        <strong id="dtCoItemsTotal">₹0</strong>
                    </div>
                    <div class="dt-cs-row">
                        <span>GST (5%):</span>
                        <strong id="dtCoGstTotal">₹0</strong>
                    </div>
                    <div class="dt-cs-row total">
                        <span>Net Payable:</span>
                        <strong id="dtCoGrandTotal" style="color:var(--dark-gold, #8A681F); font-size:1.1rem;">₹0</strong>
                    </div>
                </div>

                <div class="dt-step-action-row">
                    <button type="button" class="dt-btn-pale" onclick="goToCheckoutStep(1)">&larr; Back</button>
                    <button type="button" class="dt-btn-gold" id="dtPlaceOrderBtn" onclick="submitFinalOrder()">
                        <span>Place Order &bull; <span id="dtPlaceOrderBtnTotal">₹0</span></span>
                    </button>
                </div>
            </div>

            <!-- Step 3: Success Confirmation -->
            <div class="dt-checkout-step-content" id="dtCheckoutStep3" style="display:none;">
                <div class="dt-order-success-card">
                    <div class="dt-success-icon">✓</div>
                    <h3 class="dt-success-title">Order Placed Successfully!</h3>
                    <p class="dt-success-desc">
                        Your order <strong><span id="dtSuccessOrderNumber">DT-ORD-123456</span></strong> has been confirmed and scheduled for Surat express dispatch.
                    </p>
                    <div class="dt-success-box">
                        <p>We have sent order details and tracking link to your registered phone.</p>
                    </div>
                    <div class="dt-success-actions">
                        <a href="/account.php" class="dt-btn-pale">View My Orders</a>
                        <a href="/shop.php" class="dt-btn-gold" onclick="closeCheckoutModal()">Continue Shopping</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
