<?php
/**
 * customer-summary.php — Customer Profile & Lifetime Metrics Component
 * DT Brand's & Jai Hanuman Tex
 */
$customer_name = isset($order['customer']) ? $order['customer'] : 'Rajesh Kumar (Vardhman Tex)';
$customer_type = isset($order['customer_type']) ? $order['customer_type'] : 'Wholesale B2B';
$customer_phone = isset($order['phone']) ? $order['phone'] : '+91 98220 19283';
$customer_email = isset($order['email']) ? $order['email'] : 'rajesh@vardhmantex.com';
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <span>Customer Profile</span>
        </h3>
        <span class="dt-kpi-badge up" style="font-size:10px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;"><?php echo htmlspecialchars($customer_type); ?></span>
    </div>
    <div class="dt-detail-card-body" style="display:flex; flex-direction:column; gap:10px;">
        <div style="display:flex; align-items:center; gap:10px;">
            <div style="width:38px; height:38px; border-radius:50%; background:linear-gradient(135deg, #181512 0%, #2A241E 100%); color:#D4AF37; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:14px; border:1px solid #8A681F; flex-shrink:0;">
                <?php echo strtoupper(substr($customer_name, 0, 2)); ?>
            </div>
            <div style="display:flex; flex-direction:column; gap:2px;">
                <span style="font-weight:800; font-size:13px; color:#181512;"><?php echo htmlspecialchars($customer_name); ?></span>
                <span style="font-size:11px; color:#64748B;">Surat Wholesaler Account • Verified</span>
            </div>
        </div>

        <div style="display:flex; flex-direction:column; gap:6px; background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px; font-size:11.5px;">
            <div style="display:flex; justify-content:space-between;">
                <span style="color:#64748B;">Phone:</span>
                <strong style="color:#181512;"><?php echo htmlspecialchars($customer_phone); ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span style="color:#64748B;">Email:</span>
                <strong style="color:#181512;"><?php echo htmlspecialchars($customer_email); ?></strong>
            </div>
            <div style="display:flex; justify-content:space-between;">
                <span style="color:#64748B;">Total Orders:</span>
                <strong style="color:#8A681F;">14 Lifetime Orders</strong>
            </div>
        </div>

        <div style="display:flex; gap:6px;">
            <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $customer_phone); ?>" target="_blank" class="dt-btn dt-btn-emerald" style="flex:1; height:30px; font-size:11px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <span>WhatsApp</span>
            </a>
            <button type="button" class="dt-btn dt-btn-pale" style="flex:1; height:30px; font-size:11px;" onclick="window.DT_ORDER_VIEW.openLedgerModal('<?php echo addslashes(htmlspecialchars($customer_name)); ?>', '<?php echo addslashes(htmlspecialchars($customer_phone)); ?>', '<?php echo addslashes(htmlspecialchars($customer_email)); ?>')">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                <span>View Ledger</span>
            </button>
        </div>
    </div>
</div>
