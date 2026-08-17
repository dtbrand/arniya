<?php
// Backwards-compatible route forwarder to modular structure
header("Location: Shared/Auth/myaccount.php" . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
exit;
?>