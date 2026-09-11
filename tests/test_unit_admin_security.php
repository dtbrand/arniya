<?php
/**
 * test_unit_admin_security.php — Comprehensive Unit Test Suite for Admin Security Suite
 * DT Brand's & Jai Hanuman Tex — Section 34: Admin Users / Roles / Permissions
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/AdminSecurityManager.php';

use DTBrand\Database;
use DTBrand\AdminSecurityManager;

$testsPassed = 0;
$testsFailed = 0;

function it(string $description, bool $condition): void
{
    global $testsPassed, $testsFailed;
    if ($condition) {
        $testsPassed++;
        echo "  [PASS] {$description}\n";
    } else {
        $testsFailed++;
        echo "  [FAIL] {$description}\n";
    }
}

echo "\n======================================================================\n";
echo "  DT BRAND'S & JAI HANUMAN TEX — SECTION 34 ADMIN SECURITY SUITE TESTS\n";
echo "======================================================================\n\n";

// ── TEST GROUP 1: MANAGER INSTANTIATION & STRUCTURE ──
echo "--- 1. Manager Instantiation & Architecture ---\n";
$manager = AdminSecurityManager::getInstance();
it("AdminSecurityManager singleton instantiation", $manager instanceof AdminSecurityManager);
it("AdminSecurityManager defined modules count is 14", count(AdminSecurityManager::MODULES) === 14);
it("AdminSecurityManager defined actions count is 16", count(AdminSecurityManager::ACTIONS) === 16);

// Verify required 16 actions from Master Specification Section 34
$requiredActions = [
    'view', 'create', 'edit', 'delete', 'archive', 'restore', 'import', 'export',
    'approve', 'publish', 'adjust_stock', 'refund', 'manage_users', 'manage_settings',
    'manage_integrations', 'view_logs'
];
$actionsCatalog = array_keys(AdminSecurityManager::ACTIONS);
foreach ($requiredActions as $act) {
    it("Action '{$act}' is registered in actions catalog", in_array($act, $actionsCatalog, true));
}

// ── TEST GROUP 2: PERMISSION ENGINE & SUPER-ADMIN EXPLICIT BYPASS ──
echo "\n--- 2. Permission Engine & Super-Admin Explicit Bypass ---\n";
it("Super Admin has unrestricted bypass on products:delete", $manager->hasPermission('super_admin', 'products', 'delete') === true);
it("Super Admin has unrestricted bypass on system:manage_settings", $manager->hasPermission('super_admin', 'system', 'manage_settings') === true);
it("Super Admin has unrestricted bypass on users:manage_users", $manager->hasPermission('super_admin', 'users', 'manage_users') === true);
it("Super Admin has unrestricted bypass on reports:export", $manager->hasPermission('super_admin', 'reports', 'export') === true);

// Standard role permissions
it("Admin role has permission products:create", $manager->hasPermission('admin', 'products', 'create') === true);
it("Admin role has permission orders:refund", $manager->hasPermission('admin', 'orders', 'refund') === true);
it("Admin role denied users:manage_users", $manager->hasPermission('admin', 'users', 'manage_users') === false);
it("Operations Manager has permission inventory:adjust_stock", $manager->hasPermission('manager', 'inventory', 'adjust_stock') === true);
it("Operations Manager denied products:delete", $manager->hasPermission('manager', 'products', 'delete') === false);
it("Catalog Staff has permission products:create", $manager->hasPermission('catalog_staff', 'products', 'create') === true);
it("Catalog Staff denied payments:refund", $manager->hasPermission('catalog_staff', 'payments', 'refund') === false);
it("Support Staff has permission reviews:approve", $manager->hasPermission('support_staff', 'reviews', 'approve') === true);
it("Support Staff denied system:manage_settings", $manager->hasPermission('support_staff', 'system', 'manage_settings') === false);

$adminPerms = $manager->getRolePermissions('admin');
it("getRolePermissions('admin') returns array of module permissions", is_array($adminPerms) && !empty($adminPerms));
it("getRolePermissions('admin') includes products module", isset($adminPerms['products']));

// ── TEST GROUP 3: ADMIN USERS ROSTER & GOVERNANCE ──
echo "\n--- 3. Admin Users Roster & Governance ---\n";
$users = $manager->getAdminUsers();
it("getAdminUsers returns non-empty list of staff accounts", is_array($users) && count($users) > 0);
$firstUser = $users[0];
it("First user has expected fields (id, name, email, role, status)", 
    isset($firstUser['id'], $firstUser['name'], $firstUser['email'], $firstUser['role'], $firstUser['status'])
);
it("First user role is super_admin (highest privilege first)", $firstUser['role'] === 'super_admin');

// Validation tests
$invalidCreate = $manager->createAdminUser(['name' => '', 'email' => 'bad'], 'Test Admin');
it("createAdminUser rejects empty name/invalid email", $invalidCreate['success'] === false);

$shortPass = $manager->createAdminUser(['name' => 'Rajesh', 'email' => 'rajesh@dtbrand.in', 'password' => 'short'], 'Test Admin');
it("createAdminUser rejects password under 8 characters", $shortPass['success'] === false);

$rolesList = $manager->getRoles();
it("getRoles returns 5 standard administrative roles", is_array($rolesList) && count($rolesList) === 5);
$roleSlugs = array_column($rolesList, 'slug');
it("Roles include 'super_admin'", in_array('super_admin', $roleSlugs, true));
it("Roles include 'admin'", in_array('admin', $roleSlugs, true));
it("Roles include 'manager'", in_array('manager', $roleSlugs, true));
it("Roles include 'catalog_staff'", in_array('catalog_staff', $roleSlugs, true));
it("Roles include 'support_staff'", in_array('support_staff', $roleSlugs, true));

// ── TEST GROUP 4: ACTIVE SESSIONS & REVOCATION ──
echo "\n--- 4. Active Sessions & Device Revocation ---\n";
$sessions = $manager->getActiveSessions();
it("getActiveSessions returns list of active sessions", is_array($sessions) && count($sessions) > 0);
$firstSess = $sessions[0];
it("Active session contains session_id, user_name, ip_address, device_type", 
    isset($firstSess['session_id'], $firstSess['user_name'], $firstSess['ip_address'], $firstSess['device_type'])
);
it("Device type is properly detected", in_array($firstSess['device_type'], ['desktop', 'mobile', 'tablet'], true));

$fakeSessionId = 'sess_test_' . time();
$manager->recordSession(99, 'Test Staff', 'manager', $fakeSessionId, '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)');
$revokeRes = $manager->revokeSession($fakeSessionId, 'Super Admin');
it("revokeSession executes without error", $revokeRes === true);

// ── TEST GROUP 5: LOGIN AUDIT LEDGER ──
echo "\n--- 5. Login Audit Ledger & Statistics ---\n";
$manager->recordLoginAttempt('test_staff@dtbrand.in', true, 2, null, '127.0.0.1', 'PHPUnit Test');
$manager->recordLoginAttempt('intruder@unknown.com', false, null, 'user_not_found', '185.10.10.1', 'cURL');

$auditLogs = $manager->getLoginAudit(['limit' => 20]);
it("getLoginAudit returns array of audit records", is_array($auditLogs) && count($auditLogs) > 0);
$firstLog = $auditLogs[0];
it("Audit log record contains attempted_identity, ip_address, status", 
    isset($firstLog['attempted_identity'], $firstLog['ip_address'], $firstLog['status'])
);

$loginStats = $manager->getLoginStats();
it("getLoginStats returns total, success_24h, failed_24h, unique_ips_24h", 
    isset($loginStats['total'], $loginStats['success_24h'], $loginStats['failed_24h'], $loginStats['unique_ips_24h'])
);

// ── TEST GROUP 6: SECURITY EVENTS & THREAT OVERVIEW ──
echo "\n--- 6. Security Events & Threat Forensics ---\n";
$manager->recordSecurityEvent('auth', 'info', 'Test administrator login handshake verified', ['unit_test' => true]);
$manager->recordSecurityEvent('brute_force_alert', 'warning', 'Rate limit threshold reached for IP 192.168.1.1', ['ip' => '192.168.1.1']);

$events = $manager->getSecurityEvents(['limit' => 20]);
it("getSecurityEvents returns list of security events", is_array($events) && count($events) > 0);
$firstEvent = $events[0];
it("Security event contains category, severity, description", 
    isset($firstEvent['category'], $firstEvent['severity'], $firstEvent['description'])
);

$overview = $manager->getSecurityOverview();
it("getSecurityOverview returns comprehensive health dictionary", 
    isset($overview['total_staff'], $overview['active_sessions'], $overview['health_score'], $overview['status_label'])
);
it("Security health score is between 50 and 100", $overview['health_score'] >= 50 && $overview['health_score'] <= 100);

// ── TEST GROUP 7: CSV EXPORT & FORMULA INJECTION PROTECTION ──
echo "\n--- 7. CSV Export & Formula Injection Protection ---\n";
$csvLogin = $manager->exportAuditCsv('login');
it("exportAuditCsv('login') returns non-empty CSV string", !empty($csvLogin) && strpos($csvLogin, 'Attempted Identity') !== false);

$csvEvents = $manager->exportAuditCsv('events');
it("exportAuditCsv('events') returns non-empty CSV string", !empty($csvEvents) && strpos($csvEvents, 'Category') !== false);

it("Formula injection sanitization prefixes '=' with quote", AdminSecurityManager::sanitizeCsvValue('=cmd|calc!A0') === "'=cmd|calc!A0");
it("Formula injection sanitization prefixes '+' with quote", AdminSecurityManager::sanitizeCsvValue('+1+2') === "'+1+2");
it("Formula injection sanitization prefixes '-' with quote", AdminSecurityManager::sanitizeCsvValue('-100') === "'-100");
it("Formula injection sanitization prefixes '@' with quote", AdminSecurityManager::sanitizeCsvValue('@SUM(A1:A10)') === "'@SUM(A1:A10)");
it("Formula injection sanitization leaves normal text unchanged", AdminSecurityManager::sanitizeCsvValue('Rajesh Mehta') === 'Rajesh Mehta');

// ── TEST GROUP 8: ADMIN UI PAGES INTEGRITY & LINT CHECK ──
echo "\n--- 8. Admin UI Pages Integrity & Guard Verification ---\n";
$adminPages = [
    'admin/users/index.php',
    'admin/users/admins.php',
    'admin/users/roles.php',
    'admin/users/permissions.php',
    'admin/users/sessions.php',
    'admin/users/login-audit.php',
    'admin/users/security-events.php'
];

foreach ($adminPages as $pageRel) {
    $fullPath = dirname(__DIR__) . '/' . $pageRel;
    it("Page exists: {$pageRel}", file_exists($fullPath));
    
    $content = file_get_contents($fullPath);
    it("Page {$pageRel} has relative adminguard check", strpos($content, 'adminguard.php') !== false);
    it("Page {$pageRel} complies with zero emojis in navigation/buttons", !preg_match('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u', $content));
}

// REST API endpoint check
$apiPath = dirname(__DIR__) . '/api/admin_security.php';
it("API endpoint api/admin_security.php exists", file_exists($apiPath));
$apiContent = file_get_contents($apiPath);
it("API endpoint enforces _guard.php", strpos($apiContent, '_guard.php') !== false);

// Migration file check
$migrationPath = dirname(__DIR__) . '/database/migrations/2026_09_12_000010_create_admin_security_roles_and_permissions_tables.sql';
it("Migration file 2026_09_12_000010 exists", file_exists($migrationPath));

// Sidebar navigation check
$sidebarContent = file_get_contents(dirname(__DIR__) . '/admin/includes/adminsidebar.php');
it("Sidebar includes Admin Security RBAC item", strpos($sidebarContent, 'Admin Security') !== false);
it("Sidebar includes subnav link to permissions.php", strpos($sidebarContent, '/admin/users/permissions.php') !== false);
it("Sidebar includes subnav link to sessions.php", strpos($sidebarContent, '/admin/users/sessions.php') !== false);
it("Sidebar includes subnav link to login-audit.php", strpos($sidebarContent, '/admin/users/login-audit.php') !== false);
it("Sidebar includes subnav link to security-events.php", strpos($sidebarContent, '/admin/users/security-events.php') !== false);

// ── SUMMARY REPORT ──
echo "\n======================================================================\n";
echo "  SECTION 34 TEST RESULTS: {$testsPassed} PASSED, {$testsFailed} FAILED\n";
echo "======================================================================\n\n";

if ($testsFailed > 0) {
    exit(1);
}
exit(0);
