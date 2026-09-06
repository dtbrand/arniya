<?php
namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../database/migrate.php';

/**
 * MigrationRunnerTest — Unit validations for DatabaseMigrationRunner.
 * Tests file discovery, status reporting, idempotency, and offline resilience.
 */
class MigrationRunnerTest extends TestCase
{
    private string $tempDir = '';

    protected function tearDown(): void
    {
        if ($this->tempDir !== '' && is_dir($this->tempDir)) {
            foreach (glob($this->tempDir . '/*') as $f) {
                @unlink($f);
            }
            @rmdir($this->tempDir);
        }
        parent::tearDown();
    }

    public function testListMigrationsReturnsSortedSqlFiles(): void
    {
        $runner = new \DatabaseMigrationRunner();
        $migrations = $runner->listMigrations();

        $this->assertIsArray($migrations);
        $this->assertGreaterThanOrEqual(7, count($migrations));

        // Check canonical migrations are present
        $this->assertContains('2026_08_23_000001_create_initial_schema.sql', $migrations);
        $this->assertContains('2026_08_24_000001_full_production_schema.sql', $migrations);
        $this->assertContains('2026_08_25_production_upgrade.sql', $migrations);
        $this->assertContains('2026_08_29_000001_reconcile_full_schema.sql', $migrations);
        $this->assertContains('2026_08_30_000001_add_brands_and_admin_tables.sql', $migrations);
        $this->assertContains('2026_08_31_000001_seed_ethnic_pillars_and_subcategories.sql', $migrations);
        $this->assertContains('2026_09_02_000001_create_payment_gateways_and_webhooks.sql', $migrations);

        // Verify sorted ordering
        $sorted = $migrations;
        sort($sorted);
        $this->assertEquals($sorted, $migrations, "Migrations must be strictly sorted by timestamp prefix.");
    }

    public function testStatusReportsAllMigrationsWithValidFilePaths(): void
    {
        $runner = new \DatabaseMigrationRunner();
        $status = $runner->status();

        $this->assertIsArray($status);
        $this->assertNotEmpty($status);

        foreach ($status as $entry) {
            $this->assertArrayHasKey('migration', $entry);
            $this->assertArrayHasKey('status', $entry);
            $this->assertArrayHasKey('file_path', $entry);
            $this->assertFileExists($entry['file_path'], "Migration SQL file '{$entry['migration']}' must physically exist.");
        }
    }

    public function testRunMigrationsFailsGracefullyWithoutDatabase(): void
    {
        $runner = new \DatabaseMigrationRunner();
        $runner->setPDO(null);

        // Force a non-existent port to prevent connection attempt
        putenv('DB_HOST=127.0.0.1');
        putenv('DB_PORT=59999');

        $result = $runner->runMigrations(true);
        $this->assertIsArray($result);
        $this->assertEquals('error', $result['status'] ?? '');
        $this->assertStringContainsString('connect', strtolower($result['message'] ?? ''));

        // Restore environment
        putenv('DB_HOST=');
        putenv('DB_PORT=');
    }

    public function testIdempotentExecutionWithTestDatabase(): void
    {
        // Set up in-memory SQLite database
        $pdo = new \PDO('sqlite::memory:');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        // Create temporary migrations folder with sample migration
        $this->tempDir = sys_get_temp_dir() . '/dt_test_migrations_' . bin2hex(random_bytes(4));
        mkdir($this->tempDir, 0777, true);

        $migration1 = '2026_01_01_000001_create_sample_table.sql';
        file_put_contents($this->tempDir . '/' . $migration1, "
            CREATE TABLE IF NOT EXISTS sample_items (
                id INTEGER PRIMARY KEY,
                name TEXT NOT NULL
            );
        ");

        $runner = new \DatabaseMigrationRunner($this->tempDir, '');
        $runner->setPDO($pdo);

        // First run: executes migration
        $res1 = $runner->runMigrations(true);
        $this->assertEquals('success', $res1['status']);
        $this->assertCount(1, $res1['executed']);
        $this->assertEquals('EXECUTED_SUCCESSFULLY', $res1['executed'][0]['status']);

        // Second run: idempotent check reports already applied
        $res2 = $runner->runMigrations(true);
        $this->assertEquals('success', $res2['status']);
        $this->assertCount(1, $res2['executed']);
        $this->assertEquals('ALREADY_APPLIED', $res2['executed'][0]['status']);
    }
}
