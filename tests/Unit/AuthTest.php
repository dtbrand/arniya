<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\Auth;
use DTBrand\Database;
use PDO;

/**
 * AuthTest — Enterprise Authentication & Role Management Unit Test Suite.
 *
 * Verifies:
 * 1. Customer & partner input validations (blank fields, short password).
 * 2. Offline security fail-closed contract (never fabricate privileged sessions when DB is down).
 * 3. Session lifecycle & cleanup (customer logout, admin logout).
 * 4. Admin login input validation and invalid credential rejection.
 * 5. In-memory SQLite fixture for real bcrypt registration, duplicate detection,
 *    password verification, session population, profile updates, and password changes.
 */
class AuthTest extends TestCase
{
    private ?PDO $sqlitePdo = null;

    protected function setUp(): void
    {
        parent::setUp();
        Auth::initSession();
        Auth::logout();
        Auth::adminLogout();
        Database::setPdo(null, true);
    }

    protected function tearDown(): void
    {
        Auth::logout();
        Auth::adminLogout();
        Database::reset();
        $this->sqlitePdo = null;
        parent::tearDown();
    }

    /**
     * Build an in-memory SQLite database matching DT Brand's customer schema.
     */
    private function createSqliteAuthDb(): PDO
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        if (method_exists($pdo, 'sqliteCreateFunction')) {
            $pdo->sqliteCreateFunction('NOW', static fn() => date('Y-m-d H:i:s'));
            $pdo->sqliteCreateFunction('now', static fn() => date('Y-m-d H:i:s'));
        }

        $pdo->exec("
            CREATE TABLE customers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                phone TEXT NOT NULL,
                email TEXT DEFAULT '',
                password_hash TEXT NOT NULL,
                type TEXT DEFAULT 'customer',
                tier TEXT DEFAULT 'Standard',
                city TEXT DEFAULT '',
                state TEXT DEFAULT '',
                gstin TEXT DEFAULT NULL,
                pan TEXT DEFAULT NULL,
                credit_limit REAL DEFAULT 0,
                outstanding_balance REAL DEFAULT 0,
                status TEXT DEFAULT 'active',
                last_login TEXT DEFAULT NULL,
                created_at TEXT
            );

            CREATE TABLE users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                phone TEXT DEFAULT NULL,
                password_hash TEXT NOT NULL,
                role TEXT DEFAULT 'admin',
                status TEXT DEFAULT 'active',
                last_login TEXT DEFAULT NULL,
                created_at TEXT
            );
        ");

        return $pdo;
    }

    // ─── Input Validation & Offline Security Contracts ──────────────────────

    public function testRegisterRejectsBlankFields(): void
    {
        $res = Auth::register([
            'name' => '',
            'phone' => '',
            'password' => '',
        ]);
        $this->assertFalse($res['success']);
        $this->assertStringContainsString('required', strtolower((string)($res['message'] ?? '')));
    }

    public function testRegisterRejectsShortPassword(): void
    {
        $res = Auth::register([
            'name' => 'Boutique Owner',
            'phone' => '9876543210',
            'password' => '123',
        ]);
        $this->assertFalse($res['success']);
        $this->assertStringContainsStringIgnoringCase('at least 6', (string)($res['message'] ?? ''));
    }

    public function testLoginRejectsBlankFields(): void
    {
        $res = Auth::login('', '');
        $this->assertFalse($res['success']);
        $this->assertStringContainsString('required', strtolower((string)($res['message'] ?? '')));

        $res2 = Auth::login('9876543210', '');
        $this->assertFalse($res2['success']);
    }

    public function testLoginFailsClosedWhenDatabaseOffline(): void
    {
        Database::setPdo(null, true);
        $res = Auth::login('9876543210', 'Password@123');
        $this->assertFalse($res['success']);
        $this->assertStringContainsString('unavailable', strtolower((string)($res['message'] ?? '')));
    }

    public function testLogoutClearsCustomerSession(): void
    {
        $_SESSION['user'] = ['id' => 42, 'name' => 'Meera Patel', 'type' => 'wholesale'];
        $_SESSION['user_type'] = 'wholesale';

        $this->assertTrue(Auth::isLoggedIn());
        $this->assertNotNull(Auth::getCurrentUser());

        Auth::logout();

        $this->assertFalse(Auth::isLoggedIn());
        $this->assertNull(Auth::getCurrentUser());
        $this->assertArrayNotHasKey('user', $_SESSION);
        $this->assertArrayNotHasKey('user_type', $_SESSION);
    }

    public function testAdminLogoutClearsAdminSession(): void
    {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = ['id' => 1, 'name' => 'DT Staff', 'role' => 'super_admin'];
        $_SESSION['admin_role'] = 'super_admin';

        $this->assertTrue(Auth::isAdminLoggedIn());

        Auth::adminLogout();

        $this->assertFalse(Auth::isAdminLoggedIn());
        $this->assertArrayNotHasKey('admin_logged_in', $_SESSION);
        $this->assertArrayNotHasKey('admin_user', $_SESSION);
        $this->assertArrayNotHasKey('admin_role', $_SESSION);
    }

    public function testAdminLoginRejectsBlankFields(): void
    {
        $res1 = Auth::adminLogin('', '');
        $this->assertFalse($res1['success']);

        $res2 = Auth::adminLogin('admin@dtbrand.in', '');
        $this->assertFalse($res2['success']);
    }

    public function testAdminLoginRejectsInvalidCredentials(): void
    {
        Database::setPdo(null, true);
        $res = Auth::adminLogin('unknown_staff@dtbrand.in', 'WrongPass@999');
        $this->assertFalse($res['success']);
    }

    public function testChangePasswordValidatesLength(): void
    {
        $res = Auth::changePassword(1, 'OldPass@123', 'short');
        $this->assertFalse($res['success']);
        $this->assertStringContainsStringIgnoringCase('at least 6', (string)($res['message'] ?? ''));
    }

    public function testUpdateProfileRejectsWhenDatabaseOffline(): void
    {
        Database::setPdo(null, true);
        $res = Auth::updateProfile(1, ['name' => 'Updated Name']);
        $this->assertFalse($res['success']);
        $this->assertStringContainsString('unavailable', strtolower((string)($res['message'] ?? '')));
    }

    // ─── In-Memory SQLite Fixture Tests ─────────────────────────────────────

    public function testRegisterCustomerAndVerifyBcryptInSqlite(): void
    {
        $pdo = $this->createSqliteAuthDb();
        Database::setPdo($pdo, false);

        $payload = [
            'name' => 'Radhika Textiles',
            'phone' => '9876543210',
            'email' => 'radhika@textiles.in',
            'password' => 'Wholesale@2026',
            'type' => 'wholesale',
            'city' => 'Surat',
            'state' => 'Gujarat',
            'gstin' => '24ABCDE1234F1Z5'
        ];

        $res = Auth::register($payload);
        $this->assertTrue($res['success']);
        $this->assertGreaterThan(0, $res['user']['id']);
        $this->assertEquals('Radhika Textiles', $res['user']['name']);
        $this->assertEquals('wholesale', $res['user']['type']);
        $this->assertEquals('Surat', $res['user']['city']);

        // Assert session was set
        $this->assertTrue(Auth::isLoggedIn());
        $this->assertEquals($res['user']['id'], Auth::getCurrentUser()['id']);

        // Verify password hash in database is valid bcrypt
        $stored = $pdo->query("SELECT * FROM customers WHERE id = " . (int)$res['user']['id'])->fetch();
        $this->assertNotEmpty($stored['password_hash']);
        $this->assertTrue(password_verify('Wholesale@2026', $stored['password_hash']));
        $this->assertFalse(password_verify('WrongPassword', $stored['password_hash']));
    }

    public function testRegisterDuplicatePhoneIsRejected(): void
    {
        $pdo = $this->createSqliteAuthDb();
        Database::setPdo($pdo, false);

        $first = Auth::register([
            'name' => 'First Buyer',
            'phone' => '9123456780',
            'email' => 'first@buyer.in',
            'password' => 'Secret@123',
            'type' => 'customer'
        ]);
        $this->assertTrue($first['success']);

        // Attempting to register again with same phone
        $second = Auth::register([
            'name' => 'Second Buyer',
            'phone' => '9123456780',
            'email' => 'second@buyer.in',
            'password' => 'Secret@456',
            'type' => 'customer'
        ]);
        $this->assertFalse($second['success']);
        $this->assertStringContainsString('already exists', strtolower((string)($second['message'] ?? '')));
    }

    public function testLoginSuccessAndFailureWithSqlite(): void
    {
        $pdo = $this->createSqliteAuthDb();
        Database::setPdo($pdo, false);

        // Seed an active customer
        $hash = password_hash('Passcode@999', PASSWORD_BCRYPT);
        $pdo->prepare("
            INSERT INTO customers (name, phone, email, password_hash, type, tier, city, state, status)
            VALUES ('Boutique Queen', '9898989898', 'queen@boutique.in', ?, 'reseller', 'Gold VIP', 'Jaipur', 'Rajasthan', 'active')
        ")->execute([$hash]);

        // 1. Successful login by phone
        $loginPhone = Auth::login('9898989898', 'Passcode@999');
        $this->assertTrue($loginPhone['success']);
        $this->assertEquals('Boutique Queen', $loginPhone['user']['name']);
        $this->assertEquals('reseller', $loginPhone['user']['type']);
        $this->assertTrue(Auth::isLoggedIn());

        // 2. Successful login by email
        Auth::logout();
        $loginEmail = Auth::login('queen@boutique.in', 'Passcode@999');
        $this->assertTrue($loginEmail['success']);
        $this->assertTrue(Auth::isLoggedIn());

        // 3. Failed login with wrong password
        Auth::logout();
        $badPass = Auth::login('9898989898', 'WrongPassword@000');
        $this->assertFalse($badPass['success']);
        $this->assertFalse(Auth::isLoggedIn());
        $this->assertStringContainsString('invalid', strtolower((string)($badPass['message'] ?? '')));
    }

    public function testUpdateProfileAndChangePasswordInSqlite(): void
    {
        $pdo = $this->createSqliteAuthDb();
        Database::setPdo($pdo, false);

        $hash = password_hash('OldPass@123', PASSWORD_BCRYPT);
        $pdo->prepare("
            INSERT INTO customers (name, phone, email, password_hash, type, city, state, status)
            VALUES ('Ananya Sharma', '9000012345', 'ananya@sharma.in', ?, 'customer', 'Mumbai', 'Maharashtra', 'active')
        ")->execute([$hash]);
        $customerId = (int)$pdo->lastInsertId();

        // Sign in user into session
        $_SESSION['user'] = [
            'id' => $customerId,
            'name' => 'Ananya Sharma',
            'phone' => '9000012345',
            'email' => 'ananya@sharma.in',
            'city' => 'Mumbai',
            'state' => 'Maharashtra'
        ];

        // 1. Update Profile
        $updRes = Auth::updateProfile($customerId, [
            'name' => 'Ananya S. Sharma',
            'city' => 'Pune'
        ]);
        $this->assertTrue($updRes['success']);

        // Verify in DB and session
        $row = $pdo->query("SELECT name, city FROM customers WHERE id = $customerId")->fetch();
        $this->assertEquals('Ananya S. Sharma', $row['name']);
        $this->assertEquals('Pune', $row['city']);
        $this->assertEquals('Ananya S. Sharma', $_SESSION['user']['name']);
        $this->assertEquals('Pune', $_SESSION['user']['city']);

        // 2. Change Password with wrong old password -> fails
        $badOld = Auth::changePassword($customerId, 'WrongOldPass', 'NewPass@456');
        $this->assertFalse($badOld['success']);
        $this->assertStringContainsString('current password does not match', strtolower((string)($badOld['message'] ?? '')));

        // 3. Change Password with correct old password -> succeeds
        $goodChange = Auth::changePassword($customerId, 'OldPass@123', 'NewPass@456');
        $this->assertTrue($goodChange['success']);

        // 4. Verify login with new password succeeds
        Auth::logout();
        $loginNew = Auth::login('9000012345', 'NewPass@456');
        $this->assertTrue($loginNew['success']);
    }
}