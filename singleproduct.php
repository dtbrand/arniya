<?php
// Backwards-compatible route forwarder to modular structure
header("Location: Frontend/Single-Product/singleproduct.php" . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
exit;
?>