import urllib.request
import ftplib
import json
import ssl
import time

FTP_HOST = '147.93.99.134'
FTP_USER = 'u602484543.harmitethnic.com'
FTP_PASS = 'Gautam@9006'

PROBE_PHP = """<?php
require_once __DIR__ . '/src/Database.php';
use DTBrand\\Database;

$pdo = Database::getConnection();
if (!$pdo || Database::isMockMode()) {
    echo json_encode(['error' => 'No live DB connection']);
    exit;
}

$tables = ['addresses', 'order_items', 'orders', 'customers', 'products', 'product_variants', 'customer_notes', 'product_attributes', 'product_brands', 'payment_transactions'];
$schema = [];

foreach ($tables as $t) {
    try {
        $cols = $pdo->query("SHOW COLUMNS FROM `{$t}`")->fetchAll(\\PDO::FETCH_ASSOC);
        $count = (int)$pdo->query("SELECT COUNT(*) FROM `{$t}`")->fetchColumn();
        $schema[$t] = [
            'count' => $count,
            'columns' => array_map(function($c) {
                return $c['Field'] . ' (' . $c['Type'] . ', Null:' . $c['Null'] . ', Def:' . ($c['Default'] ?? 'NULL') . ')';
            }, $cols)
        ];
    } catch (\\Throwable $e) {
        $schema[$t] = ['error' => $e->getMessage()];
    }
}

// Sample addresses
try {
    $schema['sample_addresses'] = $pdo->query("SELECT * FROM `addresses` LIMIT 5")->fetchAll(\\PDO::FETCH_ASSOC);
} catch (\\Throwable $e) {
    $schema['sample_addresses'] = ['error' => $e->getMessage()];
}

echo json_encode($schema, JSON_PRETTY_PRINT);
"""

print("1. Uploading probe script to HarmitEthnic...")
ftp = ftplib.FTP()
ftp.connect(FTP_HOST, 21, timeout=30)
ftp.login(FTP_USER, FTP_PASS)
ftp.makepasv = lambda: ftplib.parse229(ftp.sendcmd('EPSV'), ftp.sock.getpeername())
ftp.cwd('/public_html')

import io
ftp.storbinary('STOR db_probe_temp.php', io.BytesIO(PROBE_PHP.encode('utf-8')))
ftp.quit()

print("2. Fetching schema from live server...")
ctx = ssl._create_unverified_context()
req = urllib.request.Request('https://harmitethnic.com/db_probe_temp.php', headers={'User-Agent': 'Mozilla/5.0'})
try:
    with urllib.request.urlopen(req, context=ctx, timeout=15) as res:
        output = res.read().decode('utf-8')
        data = json.loads(output)
        print("\n=== LIVE MARIADB DATABASE SCHEMA ===")
        for t, info in data.items():
            if t == 'sample_addresses':
                print(f"\n--- {t} ---")
                print(json.dumps(info, indent=2))
            else:
                print(f"\nTable: `{t}` (Rows: {info.get('count', 'N/A')})")
                for c in info.get('columns', []):
                    print(f"  • {c}")
finally:
    print("\n3. Cleaning up temporary probe script...")
    ftp = ftplib.FTP()
    ftp.connect(FTP_HOST, 21, timeout=30)
    ftp.login(FTP_USER, FTP_PASS)
    ftp.makepasv = lambda: ftplib.parse229(ftp.sendcmd('EPSV'), ftp.sock.getpeername())
    ftp.cwd('/public_html')
    try:
        ftp.delete('db_probe_temp.php')
        print("Probe script removed.")
    except Exception as e:
        print("Delete probe error:", e)
    ftp.quit()
