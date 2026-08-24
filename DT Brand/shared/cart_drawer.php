<?php
/**
 * DT Brand/shared/cart_drawer.php — Universal Shopping Bag Drawer
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ════════════ CART DRAWER MODAL ════════════ -->
<div class="dt-drawer-overlay" id="dtCartDrawerOverlay" aria-hidden="true">
    <div class="dt-drawer dt-cart-drawer" id="dtCartDrawer" role="dialog" aria-label="Shopping Bag">
        
        <!-- Header -->
        <div class="dt-drawer-header">
            <div class="dt-drawer-title-wrap">
                <svg viewBox="0 0 24 24" class="dt-drawer-title-svg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                <h3 class="dt-drawer-title">Shopping Bag (<span id="dtCartDrawerCount">0</span>)</h3>
            </div>
            <button type="button" class="dt-drawer-close" onclick="closeCartDrawer()" aria-label="Close Shopping Bag">✕</button>
        </div>

        <!-- Free Delivery Progress Bar -->
        <div class="dt-delivery-bar" id="dtDeliveryBar">
            <div class="dt-delivery-text" id="dtDeliveryText">Add ₹1,500 more for <strong>FREE Express Shipping</strong></div>
            <div class="dt-delivery-progress-track">
                <div class="dt-delivery-progress-fill" id="dtDeliveryProgressFill" style="width: 0%;"></div>
            </div>
        </div>

        <!-- Body / Items List -->
        <div class="dt-drawer-body" id="dtCartItemsList">
            <!-- Dynamically populated from JS -->
            <div class="dt-empty-state" id="dtCartEmptyState">
                <div class="dt-empty-icon">🛍️</div>
                <h4 class="dt-empty-title">Your Bag is Empty</h4>
                <p class="dt-empty-desc">Discover pure handloom sarees and designer ethnic collections.</p>
                <a href="/DT Brand/shop.php" class="dt-btn-gold" onclick="closeCartDrawer()">Explore Catalog &rarr;</a>
            </div>
        </div>

        <!-- Footer / Checkout Area -->
        <div class="dt-drawer-footer" id="dtCartDrawerFooter" style="display:none;">
            <!-- Coupon Code Strip -->
            <div class="dt-coupon-box">
                <input type="text" class="dt-coupon-input" id="dtCouponInput" placeholder="Enter Coupon Code (e.g. FESTIVE25)" />
                <button type="button" class="dt-coupon-btn" id="dtApplyCouponBtn" onclick="applyCartCoupon()">Apply</button>
            </div>
            <div class="dt-coupon-applied-tag" id="dtCouponAppliedTag" style="display:none;">
                <span>Applied: <strong id="dtAppliedCouponCode"></strong> (<span id="dtAppliedDiscountVal"></span>)</span>
                <button type="button" onclick="removeCartCoupon()">✕</button>
            </div>

            <!-- Price Breakdown -->
            <div class="dt-cart-summary-table">
                <div class="dt-summary-row">
                    <span>Subtotal</span>
                    <span id="dtCartSubtotal">₹0</span>
                </div>
                <div class="dt-summary-row" id="dtCartDiscountRow" style="display:none; color:#15803D;">
                    <span>Discount</span>
                    <span id="dtCartDiscount">-₹0</span>
                </div>
                <div class="dt-summary-row">
                    <span>GST (5% Included)</span>
                    <span id="dtCartGst">₹0</span>
                </div>
                <div class="dt-summary-row">
                    <span>Shipping</span>
                    <span id="dtCartShipping" style="color:#15803D; font-weight:700;">FREE</span>
                </div>
                <div class="dt-summary-row total-row">
                    <span>Grand Total</span>
                    <span id="dtCartGrandTotal">₹0</span>
                </div>
            </div>

            <!-- Checkout Action Buttons -->
            <div class="dt-cart-actions">
                <button type="button" class="dt-btn-gold dt-checkout-btn" onclick="openCheckoutModal()">
                    <span>Proceed to Checkout</span>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
                <button type="button" class="dt-btn-emerald dt-wa-order-btn" onclick="checkoutViaWhatsApp()">
                    <svg viewBox="0 0 24 24"><path fill="#FFF" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                    <span>Instant WhatsApp Order</span>
                </button>
            </div>
        </div>

    </div>
</div>
