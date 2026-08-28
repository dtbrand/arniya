<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-address.php — Full Billing & Shipping Addresses with Edit Option & 1-Click Copy
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($order['id']) ? $order['id'] : 'DTB-001620';
$customer_name = isset($order['customer']) ? $order['customer'] : 'Wholesale Consignee (Surat Depot)';
$phone = isset($order['phone']) ? $order['phone'] : '+91 70463 63528';
$shipping_addr = isset($order['address']['shipping']) ? $order['address']['shipping'] : 'Godown 12, Transport Nagar, Surat, Gujarat - 395010';
$billing_addr = isset($order['address']['billing']) ? $order['address']['billing'] : 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
$gstin = isset($order['gstin']) ? $order['gstin'] : '24AAECJ1928K1Z5';
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head" style="display:flex; justify-content:space-between; align-items:center;">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Delivery &amp; Billing Destination</span>
        </h3>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.openAddressEditModal('<?php echo htmlspecialchars($order_id); ?>')" style="padding:4px 10px; font-size:11px; height:28px; display:inline-flex; align-items:center; gap:5px;">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            <span>Edit Addresses</span>
        </button>
    </div>
    <div class="dt-detail-card-body" style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
        <!-- Shipping Address -->
        <div class="dt-address-box" id="shippingAddressCardBox" style="position:relative; background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px;">
            <button type="button" class="dt-copy-btn" onclick="window.DT_ORDER_VIEW.copyAddress('shippingAddressFullBlock', 'Shipping Address')" style="position:absolute; top:10px; right:10px;">Copy</button>
            <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                <strong style="color:#8A681F; font-size:11px; text-transform:uppercase; letter-spacing:0.4px;">Shipping / Godown Destination</strong>
            </div>
            
            <div id="shippingAddressFullBlock">
                <div id="shippingRecipientText" style="color:#181512; font-weight:800; font-size:13px; margin-bottom:2px;"><?php echo htmlspecialchars($customer_name); ?></div>
                <div id="shippingPhoneText" style="color:#64748B; font-size:11.5px; font-weight:600; margin-bottom:4px;">TEL: <?php echo htmlspecialchars($phone); ?></div>
                <div id="shippingAddressDisplay" style="color:#334155; font-size:12px; line-height:1.45;"><?php echo nl2br(htmlspecialchars($shipping_addr)); ?></div>
            </div>
        </div>

        <!-- Billing Address -->
        <div class="dt-address-box" id="billingAddressCardBox" style="position:relative; background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px;">
            <button type="button" class="dt-copy-btn" onclick="window.DT_ORDER_VIEW.copyAddress('billingAddressFullBlock', 'Billing Address')" style="position:absolute; top:10px; right:10px;">Copy</button>
            <div style="display:flex; align-items:center; gap:6px; margin-bottom:6px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M3 21h18"></path><path d="M5 21V7l8-4v18"></path><path d="M19 21V11l-6-4"></path><path d="M9 9h1"></path><path d="M9 13h1"></path><path d="M9 17h1"></path></svg>
                <strong style="color:#8A681F; font-size:11px; text-transform:uppercase; letter-spacing:0.4px;">GST Invoicing Billing Address</strong>
            </div>
            
            <div id="billingAddressFullBlock">
                <div id="billingFirmText" style="color:#181512; font-weight:800; font-size:13px; margin-bottom:2px;"><?php echo htmlspecialchars($customer_name); ?></div>
                <div id="billingGstinText" style="color:#64748B; font-size:11.5px; font-weight:600; margin-bottom:4px;">GSTIN: <span style="color:#8A681F; font-weight:800; font-family:monospace;"><?php echo htmlspecialchars($gstin); ?></span></div>
                <div id="billingAddressDisplay" style="color:#334155; font-size:12px; line-height:1.45;"><?php echo nl2br(htmlspecialchars($billing_addr)); ?></div>
            </div>
        </div>
    </div>
</div>
