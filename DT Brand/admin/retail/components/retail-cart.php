<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-cart.php — DT Brand's & Jai Hanuman Tex
 * Retail Live Cart Sessions Monitor Component
 */
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <h4 class="dt-retail-card-title">Live Shopping Bag Monitor (42 Active Sessions)</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('🔄 Refreshed active retail carts!')">
            <span>Refresh Carts</span>
        </button>
    </div>

    <div style="padding:16px;">
        <div class="dt-cart-session-grid">
            <div class="dt-cart-session-card">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="color:#181512; font-size:0.85rem;">Pooja Agarwal</strong>
                        <span class="dt-status-pill-clean blue">Active Shopping</span>
                    </div>
                    <span style="font-size:0.72rem; color:#78716C;">Cart ID: CART-9041 • 3 Items</span>
                    <p style="font-size:0.75rem; color:#4B5563; margin:6px 0 0 0; font-weight:600;">2x Pure Kanjeevaram Silk + 1x Designer Blouse</p>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px dashed #EAE5D9; padding-top:8px;">
                    <span style="font-size:1.1rem; font-weight:900; color:#181512;">₹11,698</span>
                    <span style="font-size:0.7rem; color:#78716C;">Updated 2m ago</span>
                </div>
            </div>

            <div class="dt-cart-session-card">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="color:#181512; font-size:0.85rem;">Sneha Kulkarni</strong>
                        <span class="dt-status-pill-clean amber">At Checkout Step 4</span>
                    </div>
                    <span style="font-size:0.72rem; color:#78716C;">Cart ID: CART-9042 • 1 Item</span>
                    <p style="font-size:0.75rem; color:#4B5563; margin:6px 0 0 0; font-weight:600;">1x Surat Dola Silk Jacquard Saree</p>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px dashed #EAE5D9; padding-top:8px;">
                    <span style="font-size:1.1rem; font-weight:900; color:#181512;">₹2,249</span>
                    <span style="font-size:0.7rem; color:#78716C;">Updated 4m ago</span>
                </div>
            </div>

            <div class="dt-cart-session-card">
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="color:#181512; font-size:0.85rem;">Guest Visitor #8841</strong>
                        <span class="dt-status-pill-clean blue">Browsing</span>
                    </div>
                    <span style="font-size:0.72rem; color:#78716C;">Cart ID: CART-9043 • 2 Items</span>
                    <p style="font-size:0.75rem; color:#4B5563; margin:6px 0 0 0; font-weight:600;">2x Festive Chanderi Organza Saree</p>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px dashed #EAE5D9; padding-top:8px;">
                    <span style="font-size:1.1rem; font-weight:900; color:#181512;">₹5,198</span>
                    <span style="font-size:0.7rem; color:#78716C;">Updated 6m ago</span>
                </div>
            </div>
        </div>
    </div>
</div>
