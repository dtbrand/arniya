<?php

namespace App\Controllers;

use App\Helpers\ResponseHelper;
use DTBrand\Database;
use DTBrand\ProductCatalog;

/**
 * ApiController
 * DT Brand's & Jai Hanuman Tex
 */
class ApiController
{
    public function health(): void
    {
        $dbConnected = (Database::getConnection() !== null);
        $totalProducts = count(ProductCatalog::getAll());

        ResponseHelper::success([
            'api_version' => '1.0.0',
            'environment' => getenv('APP_ENV') ?: 'production',
            'subsystems' => [
                'api_router' => 'ONLINE',
                'database_pdo' => $dbConnected ? 'CONNECTED' : 'MOCK_FALLBACK_ACTIVE',
                'catalog_engine' => 'ACTIVE',
                'total_skus' => $totalProducts,
                'cart_session' => 'READY',
                'order_processor' => 'READY'
            ]
        ], 'API is healthy');
    }
}
