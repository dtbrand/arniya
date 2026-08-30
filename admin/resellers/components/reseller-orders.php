<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reseller-orders.php — DT Brand's & Jai Hanuman Tex
 * Reseller Sourced Customer Orders & Dropship History Component
 */
$orders = [
    [
        'id' => 'ORD-9842',
        'date' => '20 Aug 2026',
        'customer' => 'Meena Agarwal (Dropship)',
        'items' => '4x Banarasi Kanjivaram Sarees',
        'amount' => 14800,
        'margin' => 3200,
        'status' => 'Delivered',
        'pay_status' => 'Paid (Credit)'
    ],
    [
        'id' => 'ORD-9831',
        'date' => '18 Aug 2026',
        'customer' => 'Pooja Fashion House',
        'items' => '12x Heavy Bridal Lehengas',
        'amount' => 64200,
        'margin' => 14200,
        'status' => 'Dispatched',
        'pay_status' => 'Paid (Bank Transfer)'
    ],
    [
        'id' => 'ORD-9810',
        'date' => '14 Aug 2026',
        'customer' => 'Komal Boutique Rajkot',
        'items' => '8x Pure Silk Designer Kurtis',
        'amount' => 22400,
        'margin' => 4800,
        'status' => 'Delivered',
        'pay_status' => 'Paid (Credit)'
    ]
];
?>

<div class="dt-card">
    <div class="dt-card-head" style="padding:16px 18px; border-bottom:1.2px solid #EAE5D9;">
        <h4 class="dt-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#1D4ED8" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            <span>Reseller Sourced Orders (142 Completed)</span>
        </h4>
        <a href="/admin/orders/index.php" class="dt-btn dt-btn-pale dt-btn-sm">View All in Orders Module →</a>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-reseller-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer / Dropship Consignee</th>
                    <th>Items</th>
                    <th style="text-align:right;">Order Value (₹)</th>
                    <th style="text-align:right;">Reseller Margin</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $o): ?>
                    <tr>
                        <td style="font-weight:800; color:#8A681F;"><?php echo $o['id']; ?></td>
                        <td style="color:#78716C; font-size:0.72rem;"><?php echo $o['date']; ?></td>
                        <td style="font-weight:700; color:#181512;"><?php echo htmlspecialchars($o['customer']); ?></td>
                        <td style="font-size:0.75rem; color:#4B5563;"><?php echo htmlspecialchars($o['items']); ?></td>
                        <td style="text-align:right; font-weight:800; color:#181512;">₹<?php echo number_format($o['amount']); ?></td>
                        <td style="text-align:right; font-weight:800; color:#15803D;">+₹<?php echo number_format($o['margin']); ?></td>
                        <td><span class="dt-reseller-badge emerald">● <?php echo $o['status']; ?></span></td>
                        <td><span class="dt-reseller-badge gold"><?php echo $o['pay_status']; ?></span></td>
                        <td style="text-align:center;">
                            <a href="/admin/orders/view.php?id=<?php echo $o['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">View Order</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
