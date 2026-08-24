<?php
/**
 * edit.php — Edit Product Variant Form
 * DT Brand's & Jai Hanuman Tex
 */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
header("Location: /DT%20Brand/admin/products/variants/index.php?edit_id=" . $id);
exit;