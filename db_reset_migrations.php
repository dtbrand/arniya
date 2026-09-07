<?php
/**
 * TEMPORARY ONE-TIME SCRIPT — Delete after use!
 * Full reset: wipes ALL migration tracking + drops settings/users tables so
 * install.php can run everything cleanly from scratch.
 */
$key = $_GET['key'] ?? '';
if ($key !== 'dtbrand2026reset') { http_response_code(403); die('Forbidden'); }
try {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=u602484543_demodt121;charset=utf8mb4', 'u602484543_demodt121', 'Gautam@9006', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Wipe ALL migration tracking so every migration re-runs
    $pdo->exec("DELETE FROM `_migrations`");
    $deleted_mig = $pdo->query("SELECT ROW_COUNT()")->fetchColumn();

    // Drop settings table so it gets recreated with correct schema
    $pdo->exec("DROP TABLE IF EXISTS `settings`");

    // Drop users table so admin gets re-seeded
    $pdo->exec("DROP TABLE IF EXISTS `users`");

    // Drop order_status_history (has FK, drop first)
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $pdo->exec("DROP TABLE IF EXISTS `order_status_history`");
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");

    echo "<pre style='font-family:monospace; background:#111; color:#0f0; padding:20px; border-radius:8px; font-size:14px;'>";
    echo "FULL RESET COMPLETE!\n\n";
    echo "  * All migrations cleared from tracking table\n";
    echo "  * settings table dropped (will be recreated correctly)\n";
    echo "  * users table dropped (admin will be re-seeded)\n";
    echo "  * order_status_history dropped (will be recreated)\n\n";
    echo "NOW go to:\n";
    echo "  https://harmitethnic.com/install.php?step=5\n\n";
    echo "Click 'Launch Installation' -- should complete 100% successfully!\n\n";
    echo "DELETE this file (db_reset_migrations.php) from server after install!\n";
    echo "</pre>";
} catch (PDOException $e) {
    echo "<pre style='background:#300; color:#f00; padding:20px;'>Error: " . htmlspecialchars($e->getMessage()) . "</pre>";
}
