<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * categories.php - legacy stub, forwards to the live category manager.
 * DT Brand's & Jai Hanuman Tex
 *
 * Nothing in the project links here - no include, require, anchor or rewrite
 * target anywhere - because the sidebar and the products suite both point at
 * /admin/products/categories/. This file was an older second copy of that
 * screen, and whenever the categories table came back empty it printed nine
 * invented collections ("Kanjivaram Silk - 840 SKUs", "Banarasi Silk - 620
 * SKUs", "Paithani Handloom - 410 SKUs", and so on), a hardcoded "5007 / 5%"
 * HSN and GST column on every row, an "Active" badge regardless of the row's
 * real status, and a "16 Categories" page badge. The products table has no hsn
 * column and none of those categories exist in this database, so anyone who
 * opened this URL directly was reading figures that came from nowhere.
 *
 * It forwards to the real manager instead of being deleted, so an old
 * bookmark still lands somewhere useful.
 */
header('Location: /admin/products/categories/', true, 302);
exit;
