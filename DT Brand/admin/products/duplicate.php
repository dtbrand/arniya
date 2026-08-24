<?php
/**
 * duplicate.php — 1-Click Product Cloner
 * DT Brand's & Jai Hanuman Tex
 */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 101;
header("Location: /admin/products/add.php?cloned_from=" . $id);
exit;