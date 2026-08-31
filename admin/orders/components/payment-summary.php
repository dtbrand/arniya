<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * payment-summary.php — Payment Gateway Details Component
 * DT Brand's & Jai Hanuman Tex
 */
$pay_method = isset($order['payment_method']) ? $order['payment_method'] : 'Bank Wire / RTGS';
$pay_ref = isset($order['payment_ref']) ? $order['payment_ref'] : 'UTR-9821039812';
$pay_status = isset($order['payment_status']) ? $order['payment_status'] : 'paid';
$pay_amount = isset($order['amount']) ? $order['amount'] : 112250;
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
            <span>Payment Information</span>
        </h3>
        <span class="dt-pay-badge <?php echo $pay_status; ?>"><?php echo strtoupper($pay_status); ?></span>
    </div>
    <div class="dt-detail-card-body" style="font-size:11.5px; display:flex; flex-direction:column; gap:6px;">
        <div style="display:flex; justify-content:space-between;">
            <span style="color:#64748B;">Method:</span>
            <strong style="color:#181512;"><?php echo htmlspecialchars($pay_method); ?></strong>
        </div>
        <div style="display:flex; justify-content:space-between;">
            <span style="color:#64748B;">Transaction Ref:</span>
            <span style="font-family:monospace; font-weight:700; color:#0369A1;"><?php echo htmlspecialchars($pay_ref); ?></span>
        </div>
        <div style="display:flex; justify-content:space-between;">
            <span style="color:#64748B;">Paid Amount:</span>
            <strong style="color:#15803D; font-size:12.5px;">₹<?php echo number_format($pay_amount); ?></strong>
        </div>
        <div style="display:flex; justify-content:space-between;">
            <span style="color:#64748B;">Verified By:</span>
            <span style="color:#475569;">ICICI Corporate Bank Gateway</span>
        </div>
    </div>
</div>
