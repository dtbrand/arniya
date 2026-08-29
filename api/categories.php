<?php
/**
 * api/categories.php — Category Tree & Lookbooks Feed API & Real Database CRUD
 * DT Brand's & Jai Hanuman Tex
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

try {

    if ($method === 'POST' || $method === 'DELETE') {
        // Admin-only. GET stays public so the category feed can be read by the
        // storefront; every write caller lives under /admin/products/categories/.
        // This block was unauthenticated, so any visitor could rename, re-order,
        // create or bulk-delete the shop's entire category tree.
        dt_api_require_admin('change product categories');

        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true) ?: [];
        $data = array_merge($_POST, $jsonData);

        $action = trim($data['action'] ?? ($method === 'DELETE' ? 'delete' : 'create'));
        $targetId = (int)($data['id'] ?? ($_GET['id'] ?? 0));

        if ($action === 'create') {
            $res = ProductCatalog::createCategory($data);
            echo json_encode($res, JSON_PRETTY_PRINT);
            exit;
        }

        if ($action === 'update') {
            if ($targetId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Category ID required for update.'], JSON_PRETTY_PRINT);
                exit;
            }
            $res = ProductCatalog::updateCategory($targetId, $data);
            echo json_encode($res, JSON_PRETTY_PRINT);
            exit;
        }

        if ($action === 'reorder') {
            $items = $data['items'] ?? ($data['categories'] ?? $data['order'] ?? []);
            if (is_string($items)) {
                $items = json_decode($items, true) ?: [];
            }
            $res = ProductCatalog::reorderCategories((array)$items);
            echo json_encode($res, JSON_PRETTY_PRINT);
            exit;
        }

        if ($action === 'delete') {
            if ($targetId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Category ID required.'], JSON_PRETTY_PRINT);
                exit;
            }
            // deleteCategory() deliberately refuses while products still point at
            // the category. Reporting that as the generic "Failed to delete"
            // left the admin guessing; the real reason and the count are named.
            $held = ProductCatalog::categoryProductCount($targetId);
            if ($held > 0) {
                echo json_encode([
                    'success' => false,
                    'id' => $targetId,
                    'products_count' => $held,
                    'message' => $held . ' product(s) are still in this category. Move or delete them first.'
                ], JSON_PRETTY_PRINT);
                exit;
            }
            $ok = ProductCatalog::deleteCategory($targetId);
            echo json_encode([
                'success' => $ok,
                'id' => $targetId,
                'message' => $ok ? 'Category deleted.' : 'The category was not deleted.'
            ], JSON_PRETTY_PRINT);
            exit;
        }

        if ($action === 'bulk_delete') {
            $ids = $data['ids'] ?? [];
            if (is_string($ids)) {
                $ids = explode(',', $ids);
            }
            $ids = array_values(array_filter(array_map('intval', is_array($ids) ? $ids : [])));
            $count = ProductCatalog::bulkDeleteCategories($ids);
            // "Successfully removed {$count} categories" was reported even when
            // count was 0 because every category still held products.
            $skipped = max(0, count($ids) - $count);
            $msg = $count > 0
                ? ('Deleted ' . $count . ' categor' . ($count === 1 ? 'y' : 'ies') . '.')
                : 'No categories were deleted.';
            if ($skipped > 0) {
                $msg .= ' ' . $skipped . ' kept because product(s) are still filed under them.';
            }
            echo json_encode([
                'success' => ($count > 0),
                'affected_count' => $count,
                'skipped_count' => $skipped,
                'message' => $msg
            ], JSON_PRETTY_PRINT);
            exit;
        }

    }

    $categories = ProductCatalog::getCategoriesWithDetails();

    echo json_encode([
        'success' => true,
        'count' => count($categories),
        'categories' => $categories
    ], JSON_PRETTY_PRINT);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to process category request: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

