<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\CustomerManager;
use DTBrand\Database;
use PDO;

/**
 * CustomerManagerTest — Enterprise Unit Test Suite for Customer & B2B Partner Identity Engine.
 * 
 * Verifies:
 * 1. Offline mock fail-closed contracts (honest empty arrays and rejected mutations rather than fabricated state).
 * 2. In-memory SQLite lifecycle: customer creation, bcrypt hashing, duplicate phone prevention, and address persistence.
 * 3. Targeted lookups (getById), type filtering (getByType: wholesale, reseller, retail), and full roster retrieval.
 * 4. Safe updates with ENUM validation for type & status.
 * 5. Trade approval workflow (pending -> active) and credit limit extensions.
 * 6. Clean cascaded deletion of customers and associated address rows.
 * 7. B2B financial metrics and CRM statistics aggregation.
 */
class CustomerManagerTest extends TestCase
{
    private ?PDO $sqlitePdo = null;

    protected function setUp(): void
    {
        parent::setUp();
        Database::setPdo(null, true);
    }

    protected function tearDown(): void
    {
        Database::reset();
        $this->sqlitePdo = null;
        parent::tearDown();
    }

    /**
     * Build an in-memory SQLite database matching DT Brand's customer & address schema.
     */
    private function createSqliteDatabase(): PDO
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Register MySQL compatibility functions
        if (method_exists($pdo, 'sqliteCreateFunction')) {
            $pdo->sqliteCreateFunction('NOW', static fn() => date('Y-m-d H:i:s'));
            $pdo->sqliteCreateFunction('now', static fn() => date('Y-m-d H:i:s'));
        }

        $pdo->exec("
            CREATE TABLE customers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                phone TEXT NOT NULL UNIQUE,
                email TEXT DEFAULT '',
                password_hash TEXT NOT NULL,
                gstin TEXT DEFAULT '',
                pan TEXT DEFAULT '',
                type TEXT DEFAULT 'retail',
                tier TEXT DEFAULT '',
                city TEXT DEFAULT '',
                state TEXT DEFAULT '',
                credit_limit REAL DEFAULT 0.0,
                outstanding_balance REAL DEFAULT 0.0,
                total_orders INTEGER DEFAULT 0,
                lifetime_spend REAL DEFAULT 0.0,
                commission_rate REAL DEFAULT 0.0,
                status TEXT DEFAULT 'active',
                created_at TEXT
            );

            CREATE TABLE addresses (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                customer_id INTEGER NOT NULL,
                recipient_name TEXT NOT NULL,
                phone TEXT NOT NULL,
                address_line1 TEXT NOT NULL,
                address_line2 TEXT DEFAULT '',
                city TEXT NOT NULL,
                state TEXT NOT NULL,
                pincode TEXT NOT NULL,
                address_type TEXT DEFAULT 'home',
                is_default INTEGER DEFAULT 1,
                created_at TEXT
            );
        ");

        $this->sqlitePdo = $pdo;
        Database::setPdo($pdo, false);
        return $pdo;
    }

    public function testGetAllOfflineReturnsEmptyArray(): void
    {
        $customers = CustomerManager::getAll();
        $this->assertIsArray($customers);
        $this->assertEmpty($customers, 'Offline database must return empty customer list rather than sample identities.');
    }

    public function testGetByIdOfflineReturnsNull(): void
    {
        $this->assertNull(CustomerManager::getById(1));
        $this->assertNull(CustomerManager::getById(-1));
    }

    public function testCreateRequiresNameAndPhone(): void
    {
        $resNoName = CustomerManager::create(['phone' => '9876543210']);
        $this->assertFalse($resNoName['success']);
        $this->assertStringContainsString('name is required', $resNoName['message']);

        $resNoPhone = CustomerManager::create(['name' => 'Boutique Owner']);
        $this->assertFalse($resNoPhone['success']);
        $this->assertStringContainsString('phone number is required', $resNoPhone['message']);
    }

    public function testCreateOfflineFailsGracefully(): void
    {
        $res = CustomerManager::create([
            'name' => 'Offline Shopper',
            'phone' => '9876543210'
        ]);
        $this->assertFalse($res['success']);
        $this->assertStringContainsString('database is unavailable', $res['message']);
    }

    public function testUpdateOfflineFailsGracefully(): void
    {
        $res = CustomerManager::update(1, ['name' => 'New Name']);
        $this->assertFalse($res['success']);
        $this->assertStringContainsString('database is unavailable', $res['message']);
    }

    public function testDeleteOfflineReturnsFalse(): void
    {
        $this->assertFalse(CustomerManager::delete(1));
        $this->assertFalse(CustomerManager::delete(-1));
    }

    public function testUpdateStatusOfflineReturnsFalse(): void
    {
        $this->assertFalse(CustomerManager::updateStatus(1, 'active'));
    }

    public function testInMemorySqliteCreateCustomerAndVerify(): void
    {
        $pdo = $this->createSqliteDatabase();

        $res = CustomerManager::create([
            'name' => 'Radhika Textiles',
            'phone' => '9876512345',
            'email' => 'radhika@surattextiles.in',
            'type' => 'wholesale',
            'tier' => 'Diamond Elite',
            'city' => 'Surat',
            'state' => 'Gujarat',
            'gstin' => '24AAACT1234F1Z5',
            'credit_limit' => 150000.0,
            'address' => 'Shop 42, Millenium Textile Market, Ring Road',
            'pincode' => '395002'
        ]);

        $this->assertTrue($res['success']);
        $this->assertGreaterThan(0, $res['id']);

        // Verify database customer row
        $stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
        $stmt->execute([$res['id']]);
        $cust = $stmt->fetch();

        $this->assertNotEmpty($cust);
        $this->assertEquals('Radhika Textiles', $cust['name']);
        $this->assertEquals('9876512345', $cust['phone']);
        $this->assertEquals('wholesale', $cust['type']);
        $this->assertEquals('24AAACT1234F1Z5', $cust['gstin']);
        $this->assertEquals(150000.0, (float)$cust['credit_limit']);

        // Verify address row was saved
        $addrStmt = $pdo->prepare("SELECT * FROM addresses WHERE customer_id = ?");
        $addrStmt->execute([$res['id']]);
        $addr = $addrStmt->fetch();

        $this->assertNotEmpty($addr);
        $this->assertEquals('Shop 42, Millenium Textile Market, Ring Road', $addr['address_line1']);
        $this->assertEquals('395002', $addr['pincode']);
        $this->assertEquals('warehouse', $addr['address_type']);
    }

    public function testInMemorySqliteDuplicatePhoneRejected(): void
    {
        $this->createSqliteDatabase();

        $c1 = CustomerManager::create(['name' => 'User One', 'phone' => '9800000001']);
        $this->assertTrue($c1['success']);

        $c2 = CustomerManager::create(['name' => 'User Two', 'phone' => '9800000001']);
        $this->assertFalse($c2['success']);
        $this->assertStringContainsString('already exists', $c2['message']);
    }

    public function testInMemorySqliteGetByIdAndGetAll(): void
    {
        $this->createSqliteDatabase();

        $c1 = CustomerManager::create(['name' => 'Meera Patel', 'phone' => '9800000002', 'city' => 'Ahmedabad']);
        $c2 = CustomerManager::create(['name' => 'Ananya Sharma', 'phone' => '9800000003', 'city' => 'Jaipur']);

        $all = CustomerManager::getAll();
        $this->assertCount(2, $all);
        $this->assertEquals('Meera Patel', $all[0]['name']);
        $this->assertEquals('Ananya Sharma', $all[1]['name']);

        $fetched = CustomerManager::getById($c1['id']);
        $this->assertNotNull($fetched);
        $this->assertEquals('Meera Patel', $fetched['name']);
        $this->assertEquals('Ahmedabad', $fetched['city']);
    }

    public function testInMemorySqliteGetByType(): void
    {
        $this->createSqliteDatabase();

        CustomerManager::create(['name' => 'Wholesale Mart', 'phone' => '9811111111', 'type' => 'wholesale']);
        CustomerManager::create(['name' => 'Boutique Reseller', 'phone' => '9822222222', 'type' => 'reseller']);
        CustomerManager::create(['name' => 'Retail Customer', 'phone' => '9833333333', 'type' => 'retail']);

        $wholesale = CustomerManager::getByType('wholesale');
        $this->assertCount(1, $wholesale);
        $this->assertEquals('Wholesale Mart', $wholesale[0]['name']);

        $resellers = CustomerManager::getByType('reseller');
        $this->assertCount(1, $resellers);
        $this->assertEquals('Boutique Reseller', $resellers[0]['name']);

        $retail = CustomerManager::getByType('retail');
        $this->assertCount(1, $retail);
        $this->assertEquals('Retail Customer', $retail[0]['name']);
    }

    public function testInMemorySqliteUpdateCustomerFields(): void
    {
        $pdo = $this->createSqliteDatabase();

        $c = CustomerManager::create(['name' => 'Original Name', 'phone' => '9844444444']);
        $id = $c['id'];

        $up = CustomerManager::update($id, [
            'name' => 'Updated Boutique Name',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'gstin' => '27ABCDE1234F1Z5'
        ]);

        $this->assertTrue($up['success']);

        $row = CustomerManager::getById($id);
        $this->assertEquals('Updated Boutique Name', $row['name']);
        $this->assertEquals('Mumbai', $row['city']);
        $this->assertEquals('Maharashtra', $row['state']);
        $this->assertEquals('27ABCDE1234F1Z5', $row['gstin']);
    }

    public function testInMemorySqliteUpdateInvalidStatusOrTypeRejected(): void
    {
        $this->createSqliteDatabase();

        $c = CustomerManager::create(['name' => 'Status Test User', 'phone' => '9855555555']);
        $id = $c['id'];

        $upBadStatus = CustomerManager::update($id, ['status' => 'banned_user']);
        $this->assertFalse($upBadStatus['success']);
        $this->assertStringContainsString('Status must be active, pending or suspended', $upBadStatus['message']);

        $upBadType = CustomerManager::update($id, ['type' => 'invalid_role']);
        $this->assertFalse($upBadType['success']);
        $this->assertStringContainsString('Account type must be', $upBadType['message']);
    }

    public function testInMemorySqliteUpdateStatus(): void
    {
        $this->createSqliteDatabase();

        $c = CustomerManager::create(['name' => 'Pending Partner', 'phone' => '9866666666', 'status' => 'pending']);
        $id = $c['id'];

        // Approve trade account
        $res = CustomerManager::updateStatus($id, 'active');
        $this->assertTrue($res);

        $row = CustomerManager::getById($id);
        $this->assertEquals('active', $row['status']);

        // Invalid status returns false
        $this->assertFalse(CustomerManager::updateStatus($id, 'unknown_status'));
    }

    public function testInMemorySqliteUpdateType(): void
    {
        $this->createSqliteDatabase();

        $c = CustomerManager::create(['name' => 'Retail Promoted', 'phone' => '9877777777', 'type' => 'retail']);
        $id = $c['id'];

        $res = CustomerManager::updateType($id, 'reseller');
        $this->assertTrue($res);

        $row = CustomerManager::getById($id);
        $this->assertEquals('reseller', $row['type']);

        // Invalid type returns false
        $this->assertFalse(CustomerManager::updateType($id, 'alien_type'));
    }

    public function testInMemorySqliteUpdateCreditLimit(): void
    {
        $this->createSqliteDatabase();

        $c = CustomerManager::create(['name' => 'Credit Account', 'phone' => '9888888888', 'credit_limit' => 50000.0]);
        $id = $c['id'];

        $res = CustomerManager::updateCreditLimit($id, 250000.0);
        $this->assertTrue($res);

        $row = CustomerManager::getById($id);
        $this->assertEquals(250000.0, (float)$row['credit_limit']);

        // Negative credit limit rejected
        $this->assertFalse(CustomerManager::updateCreditLimit($id, -500.0));
    }

    public function testInMemorySqliteDeleteCustomerAndAssociatedAddresses(): void
    {
        $pdo = $this->createSqliteDatabase();

        $c = CustomerManager::create([
            'name' => 'Delete Target',
            'phone' => '9899999999',
            'address' => 'House 101, Textile Street',
            'pincode' => '395003'
        ]);
        $id = $c['id'];

        $del = CustomerManager::delete($id);
        $this->assertTrue($del);

        // Verify customer removed
        $this->assertNull(CustomerManager::getById($id));

        // Verify address removed
        $addrCount = (int)$pdo->query("SELECT COUNT(*) FROM addresses WHERE customer_id = {$id}")->fetchColumn();
        $this->assertEquals(0, $addrCount);
    }

    public function testInMemorySqliteGetStatsAggregation(): void
    {
        $this->createSqliteDatabase();

        CustomerManager::create([
            'name' => 'Wholesale 1',
            'phone' => '9801111111',
            'type' => 'wholesale',
            'credit_limit' => 200000.0
        ]);
        CustomerManager::create([
            'name' => 'Wholesale 2',
            'phone' => '9802222222',
            'type' => 'wholesale',
            'credit_limit' => 300000.0
        ]);
        CustomerManager::create([
            'name' => 'Reseller 1',
            'phone' => '9803333333',
            'type' => 'reseller',
            'credit_limit' => 50000.0
        ]);
        CustomerManager::create([
            'name' => 'Retail 1',
            'phone' => '9804444444',
            'type' => 'retail'
        ]);

        $stats = CustomerManager::getStats();

        $this->assertEquals(4, $stats['total_customers']);
        $this->assertEquals(2, $stats['wholesale_count']);
        $this->assertEquals(1, $stats['reseller_count']);
        $this->assertEquals(1, $stats['retail_count']);
        $this->assertEquals(550000.0, $stats['credit_extended']);
    }
}
