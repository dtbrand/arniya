<?php
/**
 * Shared/Includes/account.php — Lightweight Compatibility Redirector
 * DT Brand's & Jai Hanuman Tex
 * Gracefully routes any legacy modal invocation to the master /account.php hub
 */
?>
<script>
window.openAccountModal = function(tab, role) {
    var url = '/account.php';
    if (tab) {
        url += '?tab=' + encodeURIComponent(tab);
        if (role) url += '&role=' + encodeURIComponent(role);
    }
    window.location.href = url;
};
window.openAuthModal = window.openAccountModal;
</script>
