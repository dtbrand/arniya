<?php
$raw = file_get_contents('php://stdin');
$input = json_decode($raw, true) ?: [];
$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);
$_SERVER['REQUEST_METHOD'] = $input['method'] ?? 'GET';
if (!empty($input['is_admin'])) {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_user'] = ['id' => 1, 'role' => 'super_admin', 'name' => 'Admin'];
}
$_GET = $input['params'] ?? [];
$_POST = $input['params'] ?? [];
$_REQUEST = $input['params'] ?? [];

require_once __DIR__ . '/../src/Database.php';

// In-memory test SQLite DB for isolated API execution
$sqlite = new \PDO('sqlite::memory:');
$sqlite->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$sqlite->exec("
    CREATE TABLE IF NOT EXISTS categories (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        slug TEXT,
        status TEXT DEFAULT 'active'
    );
    CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        name TEXT,
        slug TEXT,
        sku TEXT UNIQUE,
        category TEXT,
        category_id INTEGER,
        category_name TEXT,
        mrp REAL,
        price REAL,
        retail_price REAL,
        wholesale_price REAL,
        reseller_price REAL,
        customer_price REAL,
        cost_price REAL,
        stock_qty INTEGER,
        selling_type TEXT DEFAULT 'single_piece',
        status TEXT DEFAULT 'in_stock',
        primary_image TEXT,
        rating REAL DEFAULT 5.0,
        reviews_count INTEGER DEFAULT 0,
        created_at TEXT
    );
    CREATE TABLE IF NOT EXISTS product_variants (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_id INTEGER,
        sku TEXT,
        color_name TEXT,
        size_name TEXT,
        stock_qty INTEGER,
        price REAL,
        retail_price REAL,
        wholesale_price REAL,
        reseller_price REAL,
        selling_type TEXT DEFAULT 'single_piece',
        image TEXT
    );
    CREATE TABLE IF NOT EXISTS product_media (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_id INTEGER,
        image_url TEXT,
        is_primary INTEGER DEFAULT 0,
        sort_order INTEGER DEFAULT 0
    );
    CREATE TABLE IF NOT EXISTS reviews (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_id INTEGER,
        customer_name TEXT,
        rating REAL,
        review_title TEXT,
        review_text TEXT,
        status TEXT DEFAULT 'approved',
        verified_buyer INTEGER DEFAULT 1,
        created_at TEXT
    );

    INSERT INTO categories (id, name, slug, status) VALUES (1, 'Paithani', 'paithani', 'active');

    INSERT INTO products (id, title, name, slug, sku, category, category_id, category_name, mrp, price, retail_price, wholesale_price, reseller_price, customer_price, cost_price, stock_qty, status, primary_image, created_at)
    VALUES (1, 'Virasat Paithani Silk Saree', 'Virasat Paithani Silk Saree', 'virasat-paithani-silk-saree', 'PAITHANI-001', 'Paithani', 1, 'Paithani', 4999.00, 2499.00, 2499.00, 1850.00, 2100.00, 2499.00, 1100.00, 50, 'in_stock', '/assets/images/paithani-1.jpg', datetime('now'));

    INSERT INTO product_variants (id, product_id, sku, color_name, size_name, stock_qty, price, retail_price, wholesale_price, reseller_price, selling_type)
    VALUES (1, 1, 'PAITHANI-001-RED', 'Royal Red', 'Free Size', 50, 2499.00, 2499.00, 1850.00, 2100.00, 'single_piece');
");

\DTBrand\Database::setPdo($sqlite, false);

require __DIR__ . '/../api/products.php';
