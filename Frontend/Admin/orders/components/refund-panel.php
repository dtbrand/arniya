<?php
/**
 * refund-panel.php — Refund Management & Processing Drawer Component
 * DT Brand's & Jai Hanuman Tex
 */
$refunds_list = [
    [
        'id' => 'REF-4012',
        'order_id' => 'DTB-001612',
        'customer' => 'Meenakshi Silk House',
        'amount' => 14940,
        'method' => 'ICICI Direct Bank Transfer',
        'status' => 'paid',
        'date' => '20 Aug 2026'
    ],
    [
        'id' => 'REF-4011',
        'order_id' => 'DTB-001609',
        'customer' => 'Shweta Joshi',
        'amount' => 4990,
        'method' => 'UPI Reversal (PhonePe)',
        'status' => 'processing',
        'date' => '19 Aug 2026'
    ]
];
?>
<!-- ══ Refund Processing Drawer ══ -->
<aside class="dt-filter-drawer" id="refundDrawer">
    <div class="dt-drawer-head">
        <h3 class="dt-drawer-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Process Customer Refund</span>
        </h3>
        <button type="button" class="dt-drawer-close" onclick="window.DT_REFUNDS.closeRefundDrawer()">✕</button>
    </div>

    <div class="dt-drawer-body">
        <div style="font-size:12px; color:#475569;">
            Order ID: <strong id="refundOrderIdText" style="color:#181512;">DTB-001624</strong>
        </div>

        <div class="dt-refund-breakdown">
            <div class="dt-refund-row">
                <span style="color:#64748B;">Total Paid:</span>
                <strong id="refundMaxAmountDisplay" style="color:#181512;">₹4,990</strong>
            </div>
            <div class="dt-refund-row">
                <span style="color:#64748B;">Already Refunded:</span>
                <span style="color:#64748B;">₹0</span>
            </div>
            <div class="dt-refund-row highlight">
                <span>Refundable Limit:</span>
                <span>100% Eligible</span>
            </div>
        </div>

        <div>
            <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Refund Amount (₹)</label>
            <input type="number" id="refundAmountInput" class="dt-order-search-input" value="4990" style="height:34px; font-weight:800; font-size:14px; color:#181512;">
        </div>

        <div>
            <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Payout Method</label>
            <select id="refundMethodSelect" class="dt-order-search-input" style="height:34px;">
                <option value="Original Payment Method">Original Payment Gateway (Instant UPI / Card)</option>
                <option value="Store Credit / Ledger Note">DT Brand's Store Credit / Ledger Balance</option>
                <option value="NEFT Bank Transfer">Manual NEFT Bank Transfer</option>
            </select>
        </div>

        <div>
            <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Internal Refund Reason</label>
            <input type="text" placeholder="e.g. Return inspection approved at Surat central depot" class="dt-order-search-input" style="height:32px;">
        </div>
    </div>

    <div class="dt-drawer-foot">
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_REFUNDS.closeRefundDrawer()">Cancel</button>
        <button type="button" class="dt-btn dt-btn-danger" onclick="window.DT_REFUNDS.confirmRefund()">Authorize Refund</button>
    </div>
</aside>
