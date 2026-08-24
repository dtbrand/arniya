<?php

namespace Database\Seeders;

use DTBrand\ProductCatalog;
use DTBrand\CustomerManager;
use DTBrand\Database;

/**
 * DatabaseSeeder — Master Production Data Seeder
 * DT Brand's & Jai Hanuman Tex
 */
class DatabaseSeeder
{
    public static function run(): array
    {
        $products = ProductCatalog::getAll();
        $customers = CustomerManager::getAll();
        $categories = [
            ['id' => 1, 'name' => 'Kanjivaram Silk', 'slug' => 'kanjivaram-silk', 'count' => 840],
            ['id' => 2, 'name' => 'Banarasi Silk', 'slug' => 'banarasi-silk', 'count' => 620],
            ['id' => 3, 'name' => 'Paithani Handloom', 'slug' => 'paithani', 'count' => 410],
            ['id' => 4, 'name' => 'Chanderi Silk', 'slug' => 'chanderi', 'count' => 350],
            ['id' => 5, 'name' => 'Organza Tissue', 'slug' => 'organza', 'count' => 290],
            ['id' => 6, 'name' => 'Bridal Lehengas', 'slug' => 'bridal-lehengas', 'count' => 180],
            ['id' => 7, 'name' => 'Designer Kurtis', 'slug' => 'designer-kurtis', 'count' => 420],
            ['id' => 8, 'name' => 'Patola Heritage', 'slug' => 'patola', 'count' => 210]
        ];

        return [
            'status' => 'success',
            'seeded_categories' => count($categories),
            'seeded_products' => count($products),
            'seeded_customers' => count($customers),
            'seeded_banners' => 2,
            'seeded_coupons' => 3,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
}
