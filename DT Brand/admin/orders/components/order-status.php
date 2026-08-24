<?php
/**
 * order-status.php — Status Badges & Helper Functions
 * DT Brand's & Jai Hanuman Tex
 */

if (!function_exists('renderOrderStatusBadge')) {
    function renderOrderStatusBadge($status) {
        $clean = str_replace('_', ' ', $status);
        return '<span class="dt-status-badge ' . htmlspecialchars($status) . '"><span class="dt-status-dot"></span><span>' . ucwords($clean) . '</span></span>';
    }
}

if (!function_exists('renderPaymentStatusBadge')) {
    function renderPaymentStatusBadge($status) {
        return '<span class="dt-pay-badge ' . htmlspecialchars($status) . '">' . strtoupper($status) . '</span>';
    }
}
?>
