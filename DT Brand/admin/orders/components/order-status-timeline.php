<?php
/**
 * order-status-timeline.php — Visual Order Progression Timeline Stepper
 * DT Brand's & Jai Hanuman Tex
 */
$current_order_status = isset($order['status']) ? $order['status'] : 'shipped';

$steps = [
    ['key' => 'pending', 'label' => 'Order Placed', 'time' => '11:20 AM'],
    ['key' => 'confirmed', 'label' => 'Payment Confirmed', 'time' => '11:25 AM'],
    ['key' => 'processing', 'label' => 'Processing', 'time' => '11:30 AM'],
    ['key' => 'packed', 'label' => 'Packed in Box', 'time' => '11:40 AM'],
    ['key' => 'shipped', 'label' => 'Depot Dispatched', 'time' => '11:45 AM'],
    ['key' => 'delivered', 'label' => 'Delivered', 'time' => 'Est. Tomorrow']
];

$order_status_order = ['pending' => 1, 'confirmed' => 2, 'processing' => 3, 'packed' => 4, 'shipped' => 5, 'out_for_delivery' => 5, 'delivered' => 6];
$current_rank = isset($order_status_order[$current_order_status]) ? $order_status_order[$current_order_status] : 1;
?>
<!-- ══ Visual Status Progression Stepper ══ -->
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Live Order Fulfillment Lifecycle</span>
        </h3>
        <div style="display:flex; align-items:center; gap:6px;">
            <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 10px; font-size:10.5px;" onclick="window.DT_ORDER_STATUS.openStatusModal('<?php echo htmlspecialchars($order['id'] ?? 'DTB-001624'); ?>', '<?php echo htmlspecialchars($current_order_status); ?>')">
                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span>Change Stage</span>
            </button>
        </div>
    </div>
    <div class="dt-detail-card-body" style="padding:10px 16px 16px 16px;">
        <div class="dt-status-stepper">
            <?php foreach ($steps as $idx => $s): ?>
            <?php
                $step_rank = $order_status_order[$s['key']] ?? 1;
                $is_completed = $current_rank > $step_rank;
                $is_current = $current_rank === $step_rank;
                $cls = $is_completed ? 'completed' : ($is_current ? 'current' : '');
            ?>
            <div class="dt-step-node <?php echo $cls; ?>" style="cursor:pointer;" onclick="window.DT_ORDER_STATUS.openStatusModal('<?php echo htmlspecialchars($order['id'] ?? 'DTB-001624'); ?>', '<?php echo $s['key']; ?>')" title="Click to transition to <?php echo $s['label']; ?>">
                <div class="dt-step-icon">
                    <?php if ($is_completed): ?>
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#FFFFFF" stroke-width="3" style="margin:auto;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <?php else: ?>
                    <?php echo ($idx + 1); ?>
                    <?php endif; ?>
                </div>
                <span class="dt-step-label"><?php echo $s['label']; ?></span>
                <span class="dt-step-time"><?php echo $s['time']; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
