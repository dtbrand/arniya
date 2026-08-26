<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-stats.php — DT Brand's & Jai Hanuman Tex
 * 12-Card Master Retail KPI Metrics Ribbon
 */
require_once __DIR__ . '/retail-data.php';
$kpi_metrics = getRetailKpiMetrics();
?>

<div class="dt-retail-kpi-grid">
    <?php foreach ($kpi_metrics as $k): ?>
        <div class="dt-retail-kpi-card">
            <div class="dt-retail-kpi-top">
                <span class="dt-retail-kpi-label"><?php echo htmlspecialchars($k['label']); ?></span>
                <div class="dt-retail-kpi-icon <?php echo $k['badge']; ?>">
                    <?php if ($k['icon'] === 'rupee'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    <?php elseif ($k['icon'] === 'box'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    <?php elseif ($k['icon'] === 'users'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <?php elseif ($k['icon'] === 'user-plus'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                    <?php elseif ($k['icon'] === 'repeat'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                    <?php elseif ($k['icon'] === 'trending-up'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    <?php elseif ($k['icon'] === 'shopping-bag'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    <?php elseif ($k['icon'] === 'layers'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <?php elseif ($k['icon'] === 'percent'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                    <?php elseif ($k['icon'] === 'rotate-ccw'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                    <?php elseif ($k['icon'] === 'x-circle'): ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    <?php endif; ?>
                </div>
            </div>
            <div class="dt-retail-kpi-val"><?php echo htmlspecialchars($k['val']); ?></div>
            <div class="dt-retail-kpi-bot">
                <span><?php echo htmlspecialchars($k['sub']); ?></span>
                <span class="dt-status-pill-clean <?php echo $k['badge']; ?>"><?php echo strtoupper($k['trend']); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>
