<?php
/**
 * api/variants.php — High-Performance Product Variants REST API & Real Database CRUD Engine
 * DT Brand's & Jai Hanuman Tex
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

try {
    // ── 1. WRITE ACTIONS (POST / PUT / DELETE) ──
    if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
        dt_api_require_admin('manage product variants');

        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true) ?: [];
        $data = !empty($jsonData) ? $jsonData : $_POST;

        $action = $data['action'] ?? ($_GET['action'] ?? 'save');
        $pdo = Database::getConnection();

        if ($pdo === null && !Database::isMockMode()) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'error' => 'Database connection unavailable'
            ]);
            exit;
        }

        // ── ACTION: GENERATE MATRIX (Colors x Sizes) ──
        if ($action === 'generate_matrix') {
            $productId = (int)($data['product_id'] ?? 0);
            $colorIds = is_array($data['color_ids'] ?? null) ? $data['color_ids'] : [];
            $sizeIds = is_array($data['size_ids'] ?? null) ? $data['size_ids'] : [];
            $basePrice = (float)($data['base_price'] ?? 0);
            $baseMrp = (float)($data['base_mrp'] ?? ($basePrice * 1.5));
            $baseStock = (int)($data['base_stock'] ?? 10);
            $baseWholesale = (float)($data['base_wholesale_price'] ?? ($basePrice * 0.85));
            $baseReseller = (float)($data['base_reseller_price'] ?? ($basePrice * 0.90));

            if ($productId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid product_id']);
                exit;
            }

            if (empty($colorIds)) $colorIds = [null];
            if (empty($sizeIds)) $sizeIds = [null];

            $createdCount = 0;
            $colorsLookup = [];
            $sizesLookup = [];

            if ($pdo !== null) {
                $cRows = $pdo->query("SELECT id, name FROM product_colors")->fetchAll();
                foreach ($cRows as $r) $colorsLookup[$r['id']] = $r['name'];

                $sRows = $pdo->query("SELECT id, name FROM product_sizes")->fetchAll();
                foreach ($sRows as $r) $sizesLookup[$r['id']] = $r['name'];

                $pRow = $pdo->query("SELECT sku FROM products WHERE id = " . (int)$productId)->fetch();
                $baseSku = $pRow['sku'] ?? 'PROD' . $productId;

                $stmt = $pdo->prepare("
                    INSERT INTO product_variants 
                    (product_id, color_id, color_name, size_id, size_name, sku, stock_qty, mrp, price, wholesale_price, reseller_price, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')
                    ON DUPLICATE KEY UPDATE 
                    stock_qty = VALUES(stock_qty), price = VALUES(price), mrp = VALUES(mrp)
                ");

                foreach ($colorIds as $cId) {
                    foreach ($sizeIds as $sId) {
                        $cName = $cId ? ($colorsLookup[$cId] ?? null) : null;
                        $sName = $sId ? ($sizesLookup[$sId] ?? null) : null;
                        $vSku = $baseSku . ($cId ? '-' . ($cName ? strtoupper(substr($cName, 0, 3)) : $cId) : '') . ($sId ? '-' . ($sName ? strtoupper(substr($sName, 0, 2)) : $sId) : '-' . uniqid());

                        $stmt->execute([
                            $productId,
                            $cId ?: null,
                            $cName,
                            $sId ?: null,
                            $sName,
                            $vSku,
                            $baseStock,
                            $baseMrp,
                            $basePrice,
                            $baseWholesale,
                            $baseReseller
                        ]);
                        $createdCount++;
                    }
                }
            }

            echo json_encode([
                'success' => true,
                'message' => "Generated {$createdCount} variants in matrix",
                'count' => $createdCount
            ]);
            exit;
        }

        // ── ACTION: SAVE / CREATE SINGLE VARIANT ──
        if ($action === 'create' || $action === 'save') {
            $id = (int)($data['id'] ?? 0);
            $productId = (int)($data['product_id'] ?? 0);
            $colorId = !empty($data['color_id']) ? (int)$data['color_id'] : null;
            $colorName = trim($data['color_name'] ?? '');
            $sizeId = !empty($data['size_id']) ? (int)$data['size_id'] : null;
            $sizeName = trim($data['size_name'] ?? '');
            $sku = trim($data['sku'] ?? '');
            $stockQty = (int)($data['stock_qty'] ?? 10);
            $price = (float)($data['price'] ?? 0);
            $mrp = (float)($data['mrp'] ?? 0);
            $wholesalePrice = (float)($data['wholesale_price'] ?? 0);
            $resellerPrice = (float)($data['reseller_price'] ?? 0);
            $image = trim($data['image'] ?? '');
            $status = in_array($data['status'] ?? 'active', ['active', 'inactive']) ? $data['status'] : 'active';

            if ($productId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Valid product_id is required']);
                exit;
            }

            if ($id > 0 && $pdo !== null) {
                $stmt = $pdo->prepare("
                    UPDATE product_variants 
                    SET color_id = ?, color_name = ?, size_id = ?, size_name = ?, sku = ?, 
                        stock_qty = ?, mrp = ?, price = ?, wholesale_price = ?, reseller_price = ?, 
                        image = ?, status = ?
                    WHERE id = ? AND product_id = ?
                ");
                $stmt->execute([
                    $colorId, $colorName, $sizeId, $sizeName, $sku,
                    $stockQty, $mrp, $price, $wholesalePrice, $resellerPrice,
                    $image, $status, $id, $productId
                ]);
            } elseif ($pdo !== null) {
                if (empty($sku)) {
                    $sku = 'VAR-' . $productId . '-' . time();
                }
                $stmt = $pdo->prepare("
                    INSERT INTO product_variants 
                    (product_id, color_id, color_name, size_id, size_name, sku, stock_qty, mrp, price, wholesale_price, reseller_price, image, status)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $productId, $colorId, $colorName, $sizeId, $sizeName, $sku,
                    $stockQty, $mrp, $price, $wholesalePrice, $resellerPrice, $image, $status
                ]);
                $id = (int)$pdo->lastInsertId();
            }

            echo json_encode([
                'success' => true,
                'message' => 'Variant saved successfully',
                'variant_id' => $id
            ]);
            exit;
        }

        // ── ACTION: DELETE VARIANT ──
        if ($action === 'delete' || $method === 'DELETE') {
            $id = (int)($data['id'] ?? ($_GET['id'] ?? 0));
            if ($id > 0 && $pdo !== null) {
                $stmt = $pdo->prepare("DELETE FROM product_variants WHERE id = ?");
                $stmt->execute([$id]);
            }
            echo json_encode([
                'success' => true,
                'message' => 'Variant deleted successfully'
            ]);
            exit;
        }

        // ── ACTION: BULK STOCK / PRICE UPDATE ──
        if ($action === 'bulk_update') {
            $updates = is_array($data['variants'] ?? null) ? $data['variants'] : [];
            $updated = 0;
            if ($pdo !== null && !empty($updates)) {
                $stmt = $pdo->prepare("
                    UPDATE product_variants 
                    SET price = ?, mrp = ?, stock_qty = ?
                    WHERE id = ?
                ");
                foreach ($updates as $u) {
                    $vId = (int)($u['id'] ?? 0);
                    if ($vId > 0) {
                        $stmt->execute([
                            (float)($u['price'] ?? 0),
                            (float)($u['mrp'] ?? 0),
                            (int)($u['stock_qty'] ?? 0),
                            $vId
                        ]);
                        $updated++;
                    }
                }
            }
            echo json_encode([
                'success' => true,
                'message' => "Updated {$updated} variants in bulk",
                'updated' => $updated
            ]);
            exit;
        }
    }

    // ── 2. READ ACTION (GET) ──
    $productId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);
    $pdo = Database::getConnection();

    if ($pdo !== null && !Database::isMockMode()) {
        if ($productId > 0) {
            $stmt = $pdo->prepare("
                SELECT v.*, c.hex_code as color_hex, s.sort_order as size_sort
                FROM product_variants v
                LEFT JOIN product_colors c ON v.color_id = c.id
                LEFT JOIN product_sizes s ON v.size_id = s.id
                WHERE v.product_id = ?
                ORDER BY v.id ASC
            ");
            $stmt->execute([$productId]);
            $variants = $stmt->fetchAll() ?: [];
        } else {
            $stmt = $pdo->query("
                SELECT v.*, p.title as product_title, c.hex_code as color_hex
                FROM product_variants v
                LEFT JOIN products p ON v.product_id = p.id
                LEFT JOIN product_colors c ON v.color_id = c.id
                ORDER BY v.product_id DESC, v.id ASC
                LIMIT 100
            ");
            $variants = $stmt->fetchAll() ?: [];
        }
    } else {
        $variants = [];
    }

    echo json_encode([
        'success' => true,
        'count' => count($variants),
        'variants' => $variants
    ], JSON_PRETTY_PRINT);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Variant operation failed: ' . $e->getMessage()
    ]);
    exit;
}
