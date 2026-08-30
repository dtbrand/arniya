<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-summary.php — Customer Profile & Lifetime Metrics Component
 * DT Brand's & Jai Hanuman Tex
 */
$customer_name = isset($order['customer']) ? $order['customer'] : 'Rajesh Kumar (Vardhman Tex)';
$customer_type = isset($order['customer_type']) ? $order['customer_type'] : 'Wholesale B2B';
$customer_phone = isset($order['phone']) ? $order['phone'] : '+91 70463 63528';
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
            <div style="width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg, #2A2010 0%, #443416 50%, #1C150B 100%); color:#FFE57F; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:14px; border:1.5px solid #D4AF37; box-shadow:0 2px 8px rgba(212,175,55,0.3); flex-shrink:0;">
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
                <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.24-8.24 8.24-1.48 0-2.93-.4-4.2-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.196 8.196 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.52 11.66c-.25-.13-1.47-.72-1.7-.81-.23-.08-.39-.13-.56.13-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.13-1.06-.39-2.03-1.24-.75-.67-1.26-1.5-1.41-1.75-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.44.13-.14.17-.25.25-.42.08-.17.04-.31-.02-.44-.06-.13-.56-1.34-.76-1.84-.2-.49-.4-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.88.86-.88 2.1 0 1.24.9 2.44 1.03 2.61.13.17 1.77 2.7 4.29 3.79.6.26 1.07.41 1.44.53.6.19 1.15.16 1.59.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.15-1.18-.07-.12-.23-.19-.48-.31z"/></svg>
                <span>WhatsApp</span>
            </a>
            <a href="/admin/orders/ledger.php?id=<?php echo urlencode($order['id'] ?? ($order_id ?? 'DTB-001624')); ?>" target="_blank" class="dt-btn dt-btn-pale" style="flex:1; height:30px; font-size:11px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                <span>View Ledger</span>
            </a>
        </div>
    </div>
</div>
