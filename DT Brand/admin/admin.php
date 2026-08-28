<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * admin.php — compatibility shim for the executive dashboard.
 * DT Brand's & Jai Hanuman Tex
 *
 * This file used to be a byte-for-byte copy of admin/index.php (189 KB, 2620
 * lines, md5 361d7c309cefcae2cc0a5102d63a9f53). Only index.php is served at
 * /admin/, so every dashboard fix had to be applied twice or the two copies
 * drifted apart and /admin/admin.php quietly served stale, fabricated widgets.
 *
 * Three callers still reach this path, so the filename has to keep working:
 *   - admin/dashboard/index.php  (require_once __DIR__ . '/../admin.php')
 *   - admin/notifications/index.php  ("Back to Console" link)
 *   - admin/whatsapp/index.php       ("Back to Main Console" link)
 *
 * It now delegates to the single real implementation instead of duplicating it.
 */
require_once __DIR__ . '/index.php';
