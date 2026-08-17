<?php
// Backwards-compatible route forwarder to modular structure
header("Location: Shared/Includes/account.php" . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
exit;
?>