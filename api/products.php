<?php
/**
 * api/products.php — High-Performance Product Catalog REST API & Real Database CRUD Engine
 * DT Brand's & Jai Hanuman Tex
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$allowedOrigin = 'https://jaihanumantex.in';
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if ($origin === $allowedOrigin) {
    header('Access-Control-Allow-Origin: ' . $allowedOrigin);
} else {
    header('Access-Control-Allow-Origin: ' . $allowedOrigin);
}
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');
header('Vary: Origin');
header('Content-Type: application/json; charset=utf-8');

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

    // ── Session init for role-based pricing ──
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }
    $currentUser = $_SESSION['user'] ?? null;
    $sessionRole = strtolower(trim((string)($currentUser['role'] ?? ($currentUser['type'] ?? ''))));
    $requestedRole = strtolower(trim((string)($_REQUEST['role'] ?? ($_REQUEST['channel'] ?? ''))));
    if ($requestedRole === 'wholesaler') { $requestedRole = 'wholesale'; }

    $isAdmin = !empty($_SESSION['admin_logged_in']) || !empty($_SESSION['admin_user']);
    if ($isAdmin) {
        $userRole = 'admin';
    } elseif ($requestedRole !== '' && in_array($requestedRole, ['wholesale', 'retailer', 'reseller', 'customer', 'retail'], true)) {
        $userRole = ($requestedRole === 'retail' || $requestedRole === 'customer') ? 'retail' : $requestedRole;
    } elseif ($sessionRole !== '') {
        $userRole = ($sessionRole === 'wholesale' || $sessionRole === 'wholesaler') ? 'wholesale' : (($sessionRole === 'retailer' || $sessionRole === 'reseller') ? $sessionRole : 'retail');
    } else {
        $userRole = 'guest';
    }
    $isTradeRole = ($userRole === 'admin' || $userRole === 'wholesale' || $userRole === 'retailer');

    // ── 1. WRITE ACTIONS (POST / PUT / DELETE) ──
    if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
        // Admin-only. GET reads stay public because the storefront quickview and
        // smart-share modals fetch /api/products.php?id=… (assets/js/modals.js),
        // but every write caller lives under /admin/ — the product form, the
        // product list, bulk actions and the five inventory screens.
        //
        // This block had no authentication, so any visitor could create, edit,
        // duplicate, bulk-delete or re-price the entire catalogue, and
        // action=adjust_stock let them rewrite stock levels at will.
        dt_api_require_admin('change the product catalogue');

        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true) ?: [];
        $data = array_merge($_POST, $jsonData);

        $action = trim($data['action'] ?? ($method === 'DELETE' ? 'delete' : 'create'));
        $targetId = (int)($data['id'] ?? ($_GET['id'] ?? 0));

        // Create Product
        if ($action === 'create') {
            $res = ProductCatalog::create($data);
            if ($res['success']) {
                http_response_code(201);
                echo json_encode($res, JSON_PRETTY_PRINT);
            } else {
                http_response_code(400);
                echo json_encode($res, JSON_PRETTY_PRINT);
            }
            exit;
        }

        // Update / Quick Edit Product
        if ($action === 'update' || $action === 'quick_edit') {
            if ($targetId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Product ID is required for update.'], JSON_PRETTY_PRINT);
                exit;
            }
            $res = ProductCatalog::update($targetId, $data);
            echo json_encode($res, JSON_PRETTY_PRINT);
            exit;
        }

        // Adjust Stock (Increment / Decrement Delta)
        if ($action === 'adjust_stock') {
            if ($targetId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Product ID is required for stock adjustment.'], JSON_PRETTY_PRINT);
                exit;
            }
            $delta = (int)($data['adjustment'] ?? $data['delta'] ?? 0);
            $res = ProductCatalog::adjustStock($targetId, $delta);
            echo json_encode($res, JSON_PRETTY_PRINT);
            exit;
        }

        // Duplicate Product
        if ($action === 'duplicate') {
            if ($targetId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Product ID is required for duplication.'], JSON_PRETTY_PRINT);
                exit;
            }
            $res = ProductCatalog::duplicate($targetId);
            echo json_encode($res, JSON_PRETTY_PRINT);
            exit;
        }

        // Delete / Trash Product
        if ($action === 'delete' || $action === 'trash') {
            if ($targetId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Product ID is required for deletion.'], JSON_PRETTY_PRINT);
                exit;
            }
            $ok = ProductCatalog::delete($targetId, true);
            echo json_encode(['success' => $ok, 'id' => $targetId, 'message' => $ok ? 'Product permanently removed from database.' : 'Failed to remove product.'], JSON_PRETTY_PRINT);
            exit;
        }

        // Bulk Delete Products
        if ($action === 'bulk_delete') {
            $ids = $data['ids'] ?? [];
            if (is_string($ids)) {
                $ids = array_filter(array_map('trim', explode(',', $ids)));
            }
            if (!is_array($ids) || empty($ids)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'List of product IDs required.'], JSON_PRETTY_PRINT);
                exit;
            }
            $count = ProductCatalog::bulkDelete($ids, true);
            echo json_encode(['success' => true, 'affected_count' => $count, 'message' => "Permanently deleted {$count} products from database."], JSON_PRETTY_PRINT);
            exit;
        }

        // Bulk Update Products
        if ($action === 'bulk_update') {
            $ids = $data['ids'] ?? [];
            if (is_string($ids)) {
                $ids = array_filter(array_map('trim', explode(',', $ids)));
            }
            if (!is_array($ids) || empty($ids)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'List of product IDs required for bulk update.'], JSON_PRETTY_PRINT);
                exit;
            }
            $count = ProductCatalog::bulkUpdate($ids, $data);
            echo json_encode(['success' => true, 'affected_count' => $count, 'message' => "Successfully updated {$count} products in database."], JSON_PRETTY_PRINT);
            exit;
        }

        // Toggle Status
        if ($action === 'toggle_status') {
            if ($targetId <= 0 || empty($data['status'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Product ID and new status required.'], JSON_PRETTY_PRINT);
                exit;
            }
            $ok = ProductCatalog::updateStatus($targetId, trim($data['status']));
            echo json_encode(['success' => $ok, 'id' => $targetId, 'status' => $data['status']], JSON_PRETTY_PRINT);
            exit;
        }
    }

    // ── 2. READ ACTIONS (GET) ──
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $sku = isset($_GET['sku']) ? trim($_GET['sku']) : '';
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    $fabric = isset($_GET['fabric']) ? trim($_GET['fabric']) : '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
    $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 0;
    $sort = isset($_GET['sort']) ? trim($_GET['sort']) : 'recommended';
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;

    // Single product by ID
    if ($id > 0) {
        $product = ProductCatalog::getById($id);
        if ($product) {
            // Apply role-based price filtering
            $saleDisc = (float)($product['sale_price'] ?? $product['sale_discount'] ?? 0);
            $isFullSet = ($product['selling_type'] ?? 'single_piece') === 'full_set';
            
            if ($isFullSet) {
                if (!$isTradeRole) {
                    http_response_code(403);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Full Set products are exclusively available to verified Retailers and Wholesalers.'
                    ], JSON_PRETTY_PRINT);
                    exit;
                }
                $basePrice = (float)($product['wholesale_price'] ?? $product['retail_price'] ?? 0);
                $product['price'] = max(0, $basePrice - $saleDisc);
                $product['trade_price'] = $product['price'];
            } else {
                if ($userRole === 'reseller') {
                    $basePrice = (float)($product['reseller_price'] ?? $product['retail_price'] ?? 0);
                } elseif ($userRole === 'wholesale') {
                    $basePrice = (float)($product['wholesale_price'] ?? $product['retail_price'] ?? 0);
                } elseif ($userRole === 'retailer') {
                    $basePrice = (float)($product['retail_price'] ?? $product['price'] ?? 0);
                } else {
                    $basePrice = (float)($product['customer_price'] ?? $product['retail_price'] ?? $product['price'] ?? 0);
                }
                $product['price'] = max(0, $basePrice - $saleDisc);
                
                if (!$isTradeRole) {
                    $product['wholesale_price'] = null;
                    $product['reseller_price'] = null;
                    $product['customer_price'] = null;
                    $product['trade_price'] = $product['price'];
                } else {
                    $product['trade_price'] = max(0, (float)($product['retail_price'] ?? 0) - $saleDisc);
                }
            }
            $product['effective_price'] = $product['price'];
            
            $recommendations = ProductCatalog::getRecommendations($id, 4);
            echo json_encode([
                'success' => true,
                'product' => $product,
                'recommendations' => $recommendations
            ], JSON_PRETTY_PRINT);
            exit;
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found.'], JSON_PRETTY_PRINT);
            exit;
        }
    }

    // Single product by SKU
    if (!empty($sku)) {
        $product = ProductCatalog::getBySku($sku);
        if ($product) {
            // Apply role-based price filtering
            $saleDisc = (float)($product['sale_price'] ?? $product['sale_discount'] ?? 0);
            $isFullSet = ($product['selling_type'] ?? 'single_piece') === 'full_set';
            
            if ($isFullSet) {
                if (!$isTradeRole) {
                    http_response_code(403);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Full Set products are exclusively available to verified Retailers and Wholesalers.'
                    ], JSON_PRETTY_PRINT);
                    exit;
                }
                $basePrice = (float)($product['wholesale_price'] ?? $product['retail_price'] ?? 0);
                $product['price'] = max(0, $basePrice - $saleDisc);
                $product['trade_price'] = $product['price'];
            } else {
                if ($userRole === 'reseller') {
                    $basePrice = (float)($product['reseller_price'] ?? $product['retail_price'] ?? 0);
                } elseif ($userRole === 'wholesale') {
                    $basePrice = (float)($product['wholesale_price'] ?? $product['retail_price'] ?? 0);
                } elseif ($userRole === 'retailer') {
                    $basePrice = (float)($product['retail_price'] ?? $product['price'] ?? 0);
                } else {
                    $basePrice = (float)($product['customer_price'] ?? $product['retail_price'] ?? $product['price'] ?? 0);
                }
                $product['price'] = max(0, $basePrice - $saleDisc);
                
                if (!$isTradeRole) {
                    $product['wholesale_price'] = null;
                    $product['reseller_price'] = null;
                    $product['customer_price'] = null;
                    $product['trade_price'] = $product['price'];
                } else {
                    $product['trade_price'] = max(0, (float)($product['retail_price'] ?? 0) - $saleDisc);
                }
            }
            $product['effective_price'] = $product['price'];
            
            echo json_encode(['success' => true, 'product' => $product], JSON_PRETTY_PRINT);
            exit;
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product SKU not found.'], JSON_PRETTY_PRINT);
            exit;
        }
    }

    // Query list
    $criteria = [];
    if (!empty($category) && strtolower($category) !== 'all') {
        $criteria['category'] = $category;
    }
    if (!empty($fabric)) {
        $criteria['fabric'] = $fabric;
    }
    if (!empty($search)) {
        $criteria['search'] = $search;
    }
    if ($minPrice > 0) {
        $criteria['min_price'] = $minPrice;
    }
    if ($maxPrice > 0) {
        $criteria['max_price'] = $maxPrice;
    }

    $criteria['role'] = $userRole;
    $products = ProductCatalog::filter($criteria);

    // Completely omit full_set products for non-trade roles (Guest, Customer, Reseller)
    if (!$isTradeRole) {
        $products = array_values(array_filter($products, function($p) {
            return ($p['selling_type'] ?? 'single_piece') !== 'full_set';
        }));
    }

    // Apply role-based price filtering
    $products = array_map(function($p) use ($userRole, $isTradeRole) {
        $saleDisc = (float)($p['sale_price'] ?? $p['sale_discount'] ?? 0);
        
        // Determine the correct price for this user role
        if ($p['selling_type'] === 'full_set') {
            $basePrice = (float)($p['wholesale_price'] ?? $p['retail_price'] ?? 0);
            $p['price'] = max(0, $basePrice - $saleDisc);
            $p['trade_price'] = $p['price'];
        } else {
            // Single piece - role-based pricing
            if ($userRole === 'reseller') {
                $basePrice = (float)($p['reseller_price'] ?? $p['retail_price'] ?? 0);
            } elseif ($userRole === 'wholesale') {
                $basePrice = (float)($p['wholesale_price'] ?? $p['retail_price'] ?? 0);
            } elseif ($userRole === 'retailer') {
                $basePrice = (float)($p['retail_price'] ?? $p['price'] ?? 0);
            } else { // guest / retail
                $basePrice = (float)($p['customer_price'] ?? $p['retail_price'] ?? $p['price'] ?? 0);
            }
            $p['price'] = max(0, $basePrice - $saleDisc);
            
            // Hide trade prices from retail customers
            if (!$isTradeRole) {
                $p['wholesale_price'] = null;
                $p['reseller_price'] = null;
                $p['customer_price'] = null;
                $p['trade_price'] = $p['price'];
            } else {
                $p['trade_price'] = max(0, (float)($p['retail_price'] ?? 0) - $saleDisc);
            }
        }
        
        $p['effective_price'] = $p['price'];
        return $p;
    }, $products);

    // Apply sorting
    if ($sort === 'price_asc') {
        usort($products, fn($a, $b) => $a['retail_price'] <=> $b['retail_price']);
    } elseif ($sort === 'price_desc') {
        usort($products, fn($a, $b) => $b['retail_price'] <=> $a['retail_price']);
    } elseif ($sort === 'discount') {
        usort($products, fn($a, $b) => ($b['discount'] ?? 0) <=> ($a['discount'] ?? 0));
    } elseif ($sort === 'newest') {
        usort($products, fn($a, $b) => $b['id'] <=> $a['id']);
    }

    if ($limit > 0) {
        $products = array_slice($products, 0, $limit);
    }

    echo json_encode([
        'success' => true,
        'count' => count($products),
        'categories' => ProductCatalog::getCategoriesWithDetails(),
        'products' => $products
    ], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server Error: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);
}

