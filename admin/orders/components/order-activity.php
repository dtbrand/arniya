<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-activity.php — Audit Trail & Activity History Component
 * DT Brand's & Jai Hanuman Tex
 */
$activities = [
    ['title' => 'Depot Dispatch Manifest Generated', 'meta' => 'Today, 11:45 AM • By Gautam Sethi (Admin)', 'dot' => '#15803D'],
    ['title' => 'Packed in Master Carton #12', 'meta' => 'Today, 11:40 AM • Warehouse Floor Surat', 'dot' => '#8A681F'],
    ['title' => 'Payment Verified via Bank Wire', 'meta' => 'Today, 11:25 AM • Automatic ICICI Gateway Webhook', 'dot' => '#15803D'],
    ['title' => 'Order Created by Customer', 'meta' => 'Today, 11:20 AM • B2B Wholesale Portal', 'dot' => '#64748B']
];
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            <span>Activity History &amp; Audit Trail</span>
        </h3>
    </div>
    <div class="dt-detail-card-body">
        <div class="dt-activity-timeline">
            <?php foreach ($activities as $a): ?>
            <div class="dt-activity-item">
                <div class="dt-activity-dot" style="background:<?php echo $a['dot']; ?>;"></div>
                <span class="dt-activity-title"><?php echo htmlspecialchars($a['title']); ?></span>
                <span class="dt-activity-meta"><?php echo htmlspecialchars($a['meta']); ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
