<?php
/**
 * order-summary.php — Financial Pricing Summary Component
 * DT Brand's & Jai Hanuman Tex
 */
$subtotal = isset($order['amount']) ? $order['amount'] : 112250;
$discount = isset($order['discount']) ? $order['discount'] : 0;
$tax_gst = round($subtotal * 0.05); // 5% GST Textile standard
$shipping_cost = 0; // Free Surat depot dispatch on bulk
$grand_total = $subtotal - $discount + $tax_gst + $shipping_cost;
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Payment &amp; Financial Summary</span>
        </h3>
        <span class="dt-pay-badge <?php echo htmlspecialchars($order['payment_status'] ?? 'paid'); ?>"><?php echo strtoupper($order['payment_status'] ?? 'PAID'); ?></span>
    </div>
    <div class="dt-detail-card-body" style="padding:10px 16px;">
        <table class="dt-summary-table">
            <tr>
                <td class="dt-sum-label">Item Subtotal</td>
                <td class="dt-sum-val">₹<?php echo number_format($subtotal); ?></td>
            </tr>
            <tr>
                <td class="dt-sum-label">Wholesale Bulk Discount</td>
                <td class="dt-sum-val" style="color:#15803D;">- ₹<?php echo number_format($discount); ?></td>
            </tr>
            <tr>
                <td class="dt-sum-label">GST Tax (5% Surat Handloom)</td>
                <td class="dt-sum-val">+ ₹<?php echo number_format($tax_gst); ?></td>
            </tr>
            <tr>
                <td class="dt-sum-label">Depot Logistics / Freight</td>
                <td class="dt-sum-val" style="color:#15803D;">FREE (Surat Factory)</td>
            </tr>
            <tr class="dt-sum-total">
                <td class="dt-sum-label">Grand Total</td>
                <td class="dt-sum-val">₹<?php echo number_format($grand_total); ?></td>
            </tr>
        </table>
    </div>
</div>
