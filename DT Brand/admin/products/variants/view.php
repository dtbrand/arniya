<?php
/**
 * view.php — View Product Variant Details
 * DT Brand's & Jai Hanuman Tex
 */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
header("Location: /DT%20Brand/admin/products/variants/index.php?view_id=" . $id);
exit;