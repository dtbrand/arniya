<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * duplicate.php — 1-Click Product Cloner
 * DT Brand's & Jai Hanuman Tex
 */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 101;
header("Location: /admin/products/add.php?cloned_from=" . $id);
exit;