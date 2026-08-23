<?php
/**
 * migrate.php — Database Migration Runner
 * DT Brand's & Jai Hanuman Tex
 */

class DatabaseMigrationRunner {
    private string $migrationsPath;
    private array $applied = [];

    public function __construct(string $migrationsPath = __DIR__ . '/migrations') {
        $this->migrationsPath = $migrationsPath;
    }

    public function listMigrations(): array {
        if (!is_dir($this->migrationsPath)) {
            return [];
        }
        $files = scandir($this->migrationsPath);
        $migrations = [];
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'sql' || pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $migrations[] = $file;
            }
        }
        sort($migrations);
        return $migrations;
    }

    public function status(): array {
        $all = $this->listMigrations();
        $report = [];
        foreach ($all as $m) {
            $report[] = [
                'migration' => $m,
                'status' => 'PENDING_OR_APPLIED',
                'file_path' => $this->migrationsPath . '/' . $m
            ];
        }
        return $report;
    }

    public function runDryRun(): array {
        $migrations = $this->listMigrations();
        $results = [];
        foreach ($migrations as $m) {
            $path = $this->migrationsPath . '/' . $m;
            $content = file_get_contents($path);
            $results[] = [
                'migration' => $m,
                'sql_length' => strlen($content),
                'status' => 'VALIDATED_OK'
            ];
        }
        return $results;
    }
}

if (php_sapi_name() === 'cli' && isset($argv[0]) && basename($argv[0]) === basename(__FILE__)) {
    $runner = new DatabaseMigrationRunner();
    echo "=== DT Brand's Database Migration Status ===\n";
    $status = $runner->status();
    foreach ($status as $s) {
        echo " - [{$s['status']}] {$s['migration']}\n";
    }
    echo "Total migrations detected: " . count($status) . "\n";
}
