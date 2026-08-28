<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reseller-profile.php — DT Brand's & Jai Hanuman Tex
 * Luxury Gold & Silver/Platinum Glass Hero Banner & Identity Card
 */
$reseller = isset($reseller) && is_array($reseller) ? $reseller : [
    'id' => 'RES-1048',
    'name' => 'Shree Krishna Sarees & Boutique',
    'contact' => 'Rameshwar Vyas',
    'email' => 'krishna.boutique@gmail.com',
    'phone' => '+91 70463 63528',
    'city' => 'Surat',
    'state' => 'Gujarat',
    'pincode' => '395002',
    'tier' => 'Platinum',
    'status' => 'Active',
    'kyc' => 'Verified',
    'orders' => 142,
    'purchase' => 845000,
    'credit' => 65000,
    'credit_limit' => 150000,
    'joined' => '2025-11-12'
];
?>

<div class="dt-reseller-hero-banner">
    <div class="dt-reseller-hero-left">
        <div class="dt-reseller-hero-avatar">
            <?php echo strtoupper(substr($reseller['name'], 0, 1)); ?>
        </div>
        <div>
            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:4px;">
                <h2 class="dt-reseller-hero-title"><?php echo htmlspecialchars($reseller['name']); ?></h2>
                <span class="dt-tier-badge platinum">★ <?php echo $reseller['tier']; ?> Elite</span>
                <?php if ($reseller['status'] === 'Active'): ?>
                    <span class="dt-reseller-badge emerald">● Active Partner</span>
                <?php elseif ($reseller['status'] === 'Pending'): ?>
                    <span class="dt-reseller-badge amber">● Pending Review</span>
                <?php else: ?>
                    <span class="dt-reseller-badge purple">● Suspended</span>
                <?php endif; ?>
            </div>
            <p class="dt-reseller-hero-sub">
                <strong>ID:</strong> <?php echo $reseller['id']; ?> • 
                <strong>Contact:</strong> <?php echo htmlspecialchars($reseller['contact']); ?> • 
                <strong>Location:</strong> <?php echo htmlspecialchars($reseller['city'] . ', ' . $reseller['state']); ?> • 
                <strong>Joined:</strong> <?php echo date('d M Y', strtotime($reseller['joined'])); ?>
            </p>
        </div>
    </div>

    <!-- Right Summary Metrics -->
    <div class="dt-reseller-hero-metrics">
        <div class="dt-reseller-hero-metric-item">
            <span class="dt-reseller-hero-metric-lbl">Total Gross Sales (GMV)</span>
            <span class="dt-reseller-hero-metric-val">₹<?php echo number_format($reseller['purchase']); ?></span>
        </div>
        <div class="dt-reseller-hero-metric-item">
            <span class="dt-reseller-hero-metric-lbl">Total Orders</span>
            <span class="dt-reseller-hero-metric-val" style="color:#FFFFFF;"><?php echo $reseller['orders']; ?></span>
        </div>
        <div class="dt-reseller-hero-metric-item">
            <span class="dt-reseller-hero-metric-lbl">Available Credit</span>
            <span class="dt-reseller-hero-metric-val" style="color:#86EFAC;">₹<?php echo number_format($reseller['credit_limit'] - $reseller['credit']); ?></span>
        </div>
    </div>
</div>
