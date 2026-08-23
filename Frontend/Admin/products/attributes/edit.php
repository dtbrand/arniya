<?php
/**
 * edit.php — Edit Attribute Form
 * DT Brand's & Jai Hanuman Tex
 */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
header("Location: /Frontend/Admin/products/attributes/index.php?edit_id=" . $id);
exit;