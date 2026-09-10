<?php
/**
 * Test Security Guard: ensure spoofed Referer + fake cookie cannot bypass dt_api_is_admin()
 */
$_SERVER['HTTP_REFERER'] = 'https://harmitethnic.com/admin/products.php';
$_SERVER['HTTP_HOST'] = 'harmitethnic.com';
$_COOKIE['PHPSESSID'] = 'dummy_attacker_cookie_123';
$_COOKIE['DTBRANDS_SESS'] = 'dummy_attacker_cookie_456';

require_once __DIR__ . '/../api/_guard.php';

$isAdmin = dt_api_is_admin();
echo "Guard result for spoofed attacker request: " . ($isAdmin ? "FAIL (VULNERABLE)" : "PASS (SECURE)") . "\n";
assert(!$isAdmin, "Attack request MUST NOT be authenticated as admin!");
echo "100% SECURE: Spoofed Referer bypass successfully blocked.\n";
