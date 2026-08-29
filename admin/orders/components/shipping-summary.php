<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * shipping-summary.php — Shipping Partner & Dispatch Summary Component
 * DT Brand's & Jai Hanuman Tex
 */
$shipping_method = isset($order['shipping_method']) ? $order['shipping_method'] : 'Surat Central Depot Cargo Express';
$carrier = isset($order['carrier']) ? $order['carrier'] : 'VRL Logistics';
$tracking_id = isset($order['tracking_id']) ? $order['tracking_id'] : 'VRL-SURAT-99821';
?>
<div class="dt-detail-card">
    <div class="dt-detail-card-head">
        <h3 class="dt-detail-card-title">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            <span>Logistics &amp; Dispatch</span>
        </h3>
        <span class="dt-kpi-badge up" style="font-size:10px;"><?php echo htmlspecialchars($carrier); ?></span>
    </div>
    <div class="dt-detail-card-body" style="font-size:11.5px; display:flex; flex-direction:column; gap:8px;">
        <div style="display:flex; justify-content:space-between;">
            <span style="color:#64748B;">Logistics Plan:</span>
            <strong style="color:#181512;"><?php echo htmlspecialchars($shipping_method); ?></strong>
        </div>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="color:#64748B;">Tracking Number:</span>
            <div style="display:flex; align-items:center; gap:4px;">
                <span style="font-family:monospace; font-weight:800; color:#8A681F;"><?php echo htmlspecialchars($tracking_id); ?></span>
                <button type="button" class="dt-copy-btn" style="position:static;" onclick="if(window.DT_ORDERS) window.DT_ORDERS.copyText('<?php echo htmlspecialchars($tracking_id); ?>', 'Tracking ID');" title="Copy tracking">Copy</button>
            </div>
        </div>
        <div style="display:flex; justify-content:space-between;">
            <span style="color:#64748B;">Est. Delivery:</span>
            <strong style="color:#15803D;">22 Aug 2026 (Depot Dock)</strong>
        </div>
        <div style="display:flex; gap:6px; margin-top:4px;">
            <a href="/admin/orders/shipping-label.php?id=<?php echo htmlspecialchars($order['id'] ?? 'DTB-001624'); ?>" class="dt-btn dt-btn-pale" style="flex:1; height:28px; font-size:11px;">
                <span>Print Label</span>
            </a>
            <a href="/admin/orders/packing-slip.php?id=<?php echo htmlspecialchars($order['id'] ?? 'DTB-001624'); ?>" class="dt-btn dt-btn-pale" style="flex:1; height:28px; font-size:11px;">
                <span>Packing Slip</span>
            </a>
        </div>
    </div>
</div>
