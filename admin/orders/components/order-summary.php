<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

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
        <table class="dt-summary-table" style="width:100%;">
            <tr>
                <td class="dt-sum-label">Item Subtotal</td>
                <td class="dt-sum-val">
                    <div style="display:flex; align-items:center; justify-content:flex-end; gap:2px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="11" height="11"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span><?php echo number_format($subtotal); ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="dt-sum-label">Wholesale Bulk Discount</td>
                <td class="dt-sum-val" style="color:#15803D;">
                    <div style="display:flex; align-items:center; justify-content:flex-end; gap:2px;">
                        <span>-</span>
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="11" height="11"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span><?php echo number_format($discount); ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="dt-sum-label">GST Tax (5% Surat Handloom)</td>
                <td class="dt-sum-val">
                    <div style="display:flex; align-items:center; justify-content:flex-end; gap:2px;">
                        <span>+</span>
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="11" height="11"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span><?php echo number_format($tax_gst); ?></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="dt-sum-label">Depot Logistics / Freight</td>
                <td class="dt-sum-val" style="color:#15803D; font-weight:700;">FREE (Surat Factory)</td>
            </tr>
            <tr class="dt-sum-total" style="border-top:1px solid #E2DFD7; font-weight:800; font-size:13px; color:#181512;">
                <td class="dt-sum-label" style="padding-top:8px;">Grand Total Valuation</td>
                <td class="dt-sum-val" style="padding-top:8px; color:#8A681F;">
                    <div style="display:flex; align-items:center; justify-content:flex-end; gap:2px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="13" height="13"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span><?php echo number_format($grand_total); ?></span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
