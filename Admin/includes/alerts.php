<?php
/**
 * alerts.php — ARNIYA Admin Toast & Alert Banners Container
 */
?>
<!-- ══ Floating Toast Notifications Container ══ -->
<div class="adm-toast-container" id="admToastContainer"></div>

<!-- ══ Global Alert Banner (if needed) ══ -->
<?php if (isset($global_alert) && !empty($global_alert)): ?>
    <div class="adm-alert-banner <?php echo htmlspecialchars(isset($global_alert['type']) ? $global_alert['type'] : 'info'); ?>">
        <div class="adm-alert-content">
            <span class="adm-alert-icon">⚡</span>
            <span><?php echo htmlspecialchars($global_alert['message']); ?></span>
        </div>
        <button type="button" class="adm-alert-close" onclick="this.parentElement.style.display='none'">✕</button>
    </div>
<?php endif; ?>
