<?php
/**
 * order-address.php — Billing & Shipping Addresses with 1-Click Copy
 * DT Brand's & Jai Hanuman Tex
 */
$billing_addr = isset($order['address']['billing']) ? $order['address']['billing'] : 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
$shipping_addr = isset($order['address']['shipping']) ? $order['address']['shipping'] : 'Godown 12, Transport Nagar, Surat, Gujarat - 395010';
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Delivery &amp; Billing Destination</span>
        </h3>
    </div>
    <div class="dt-detail-card-body" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <!-- Shipping Address -->
        <div class="dt-address-box">
            <button type="button" class="dt-copy-btn" onclick="window.DT_ORDER_VIEW.copyAddress('shippingAddressDisplay', 'Shipping Address')">Copy</button>
            <strong style="color:#181512; font-size:11px; text-transform:uppercase; display:block; margin-bottom:4px;">Shipping / Godown Destination</strong>
            <div id="shippingAddressDisplay"><?php echo nl2br(htmlspecialchars($shipping_addr)); ?></div>
        </div>

        <!-- Billing Address -->
        <div class="dt-address-box">
            <button type="button" class="dt-copy-btn" onclick="window.DT_ORDER_VIEW.copyAddress('billingAddressDisplay', 'Billing Address')">Copy</button>
            <strong style="color:#181512; font-size:11px; text-transform:uppercase; display:block; margin-bottom:4px;">GST Invoicing Billing Address</strong>
            <div id="billingAddressDisplay"><?php echo nl2br(htmlspecialchars($billing_addr)); ?></div>
        </div>
    </div>
</div>
