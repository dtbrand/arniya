<?php
/**
 * wholesale-orders.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Sourcing Orders & Bulk POs Component
 */
$wholesale_orders = [
    [
        'id' => 'ORD-WHL-4821',
        'date' => '22 Aug 2026',
        'items' => '120 Saree Lots (Pure Kanjeevaram & Banarasi)',
        'amount' => '₹84,500',
        'payment' => 'Revolving Credit (Net 30)',
        'status' => 'Processing Dispatch',
        'badge' => 'amber'
    ],
    [
        'id' => 'ORD-WHL-4780',
        'date' => '10 Aug 2026',
        'items' => '240 Saree Lots (Surat Dola Silk Jacquard)',
        'amount' => '₹1,45,000',
        'payment' => 'Settled via NEFT',
        'status' => 'Delivered & Settled',
        'badge' => 'emerald'
    ],
    [
        'id' => 'ORD-WHL-4692',
        'date' => '25 Jul 2026',
        'items' => '300 Saree Lots (Chanderi & Organza Festive)',
        'amount' => '₹1,92,000',
        'payment' => 'Settled via RTGS',
        'status' => 'Delivered & Settled',
        'badge' => 'emerald'
    ]
];
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
            <h4 class="dt-card-title">Wholesale Purchase Orders &amp; Dispatches</h4>
        </div>
        <a href="/Frontend/Admin/orders/index.php" class="dt-btn dt-btn-pale dt-btn-sm">View in Orders Suite</a>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-wholesale-table">
            <thead>
                <tr>
                    <th style="white-space:nowrap;">PO / Order ID</th>
                    <th style="white-space:nowrap;">Order Date</th>
                    <th style="white-space:nowrap;">Product Lots &amp; SKUs</th>
                    <th style="text-align:right; white-space:nowrap;">Order Total (₹)</th>
                    <th style="white-space:nowrap;">Payment Mode</th>
                    <th style="white-space:nowrap;">Fulfillment Status</th>
                    <th style="text-align:right; white-space:nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($wholesale_orders as $o): ?>
                    <tr style="border-bottom:1px solid #F1ECE1;">
                        <td style="font-family:monospace; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $o['id']; ?></td>
                        <td style="color:#78716C; font-size:0.75rem; white-space:nowrap;"><?php echo $o['date']; ?></td>
                        <td style="font-weight:700; color:#181512; white-space:nowrap;"><?php echo $o['items']; ?></td>
                        <td style="text-align:right; font-weight:900; color:#181512; font-size:0.85rem; white-space:nowrap;"><?php echo $o['amount']; ?></td>
                        <td style="font-size:0.75rem; color:#78716C; white-space:nowrap;"><?php echo $o['payment']; ?></td>
                        <td style="white-space:nowrap;">
                            <span class="dt-status-pill-clean <?php echo $o['badge']; ?>"><?php echo $o['status']; ?></span>
                        </td>
                        <td style="text-align:right; white-space:nowrap;">
                            <a href="/Frontend/Admin/orders/view.php?id=<?php echo $o['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">View Order</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
