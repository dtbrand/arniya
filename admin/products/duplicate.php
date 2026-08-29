<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * duplicate.php — 1-Click Product Cloner
 * DT Brand's & Jai Hanuman Tex
 *
 * A missing or non-numeric id used to default to 101, which is not a product in
 * this database, so "Duplicate" silently opened a blank Add Product form as if
 * the clone had loaded. An invalid id now goes back to the catalogue instead.
 */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: /admin/products/");
    exit;
}
header("Location: /admin/products/add.php?cloned_from=" . $id);
exit;