<?php
/**
 * edit.php — Edit Attribute Form
 * DT Brand's & Jai Hanuman Tex
 */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
header("Location: /DT%20Brand/admin/products/attributes/index.php?edit_id=" . $id);
exit;