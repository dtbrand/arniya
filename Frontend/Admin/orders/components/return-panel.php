<?php
/**
 * return-panel.php — Return Request Management Partial
 * DT Brand's & Jai Hanuman Tex
 */
$returns_list = [
    [
        'id' => 'RMA-9021',
        'order_id' => 'DTB-001618',
        'customer' => 'Shree Saree Niketan',
        'product' => 'Chanderi Zari Tissue Festive Saree (x5)',
        'reason' => 'Shade Variation in Lot',
        'amount' => 12450,
        'status' => 'pending',
        'date' => '20 Aug 2026'
    ],
    [
        'id' => 'RMA-9020',
        'order_id' => 'DTB-001614',
        'customer' => 'Kavita Agarwal',
        'product' => 'Banarasi Katan Silk Handloom (x1)',
        'reason' => 'Defective Zari Thread',
        'amount' => 6490,
        'status' => 'confirmed',
        'date' => '19 Aug 2026'
    ]
];
?>
<div class="dt-order-table-card">
    <div class="dt-table-responsive">
        <table class="dt-order-table">
            <thead>
                <tr>
                    <th>Return ID</th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Product &amp; Qty</th>
                    <th>Reason</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($returns_list as $r): ?>
                <tr id="returnRow_<?php echo $r['id']; ?>">
                    <td style="font-weight:800; color:#8A681F;"><?php echo $r['id']; ?></td>
                    <td>
                        <a href="/Frontend/Admin/orders/view.php?id=<?php echo $r['order_id']; ?>" class="dt-order-id-link"><?php echo $r['order_id']; ?></a>
                    </td>
                    <td style="font-weight:700; color:#181512;"><?php echo htmlspecialchars($r['customer']); ?></td>
                    <td style="font-size:11.5px; color:#475569;"><?php echo htmlspecialchars($r['product']); ?></td>
                    <td><span class="dt-return-reason-pill"><?php echo htmlspecialchars($r['reason']); ?></span></td>
                    <td style="font-weight:800; color:#181512;">₹<?php echo number_format($r['amount']); ?></td>
                    <td>
                        <span class="dt-status-badge <?php echo $r['status']; ?>">
                            <span class="dt-status-dot"></span>
                            <span><?php echo ucfirst($r['status']); ?></span>
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="dt-row-actions" style="justify-content:flex-end;">
                            <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:10.5px;" onclick="window.DT_RETURNS.approveReturn('<?php echo $r['id']; ?>')">Approve</button>
                            <button type="button" class="dt-btn dt-btn-danger" style="height:26px; padding:0 8px; font-size:10.5px;" onclick="window.DT_RETURNS.rejectReturn('<?php echo $r['id']; ?>')">Reject</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
