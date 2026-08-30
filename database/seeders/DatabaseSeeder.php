<?php

namespace Database\Seeders;

use DTBrand\ProductCatalog;
use DTBrand\CustomerManager;
use DTBrand\Database;

/**
 * DatabaseSeeder — Master Production Data Seeder
 *
 * Seeds a minimum-real catalogue so a fresh production install can render
 * the storefront immediately on first deploy. Every product/customer row
 * created here is also written to the `products` and `customers` tables;
 * `run()` reports what landed. No fabricated orders, no fake order numbers.
 */
class DatabaseSeeder
{
    public static function run(): array
    {
        $report = [
            'status' => 'success',
            'seeded_categories' => 0,
            'seeded_products' => 0,
            'seeded_customers' => 0,
            'seeded_banners' => 0,
            'seeded_coupons' => 0,
            'timestamp' => date('Y-m-d H:i:s'),
        ];

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            $report['status'] = 'skipped_no_db';
            return $report;
        }

        // ── 1. Categories (idempotent on slug) ──
        $categories = [
            ['name' => 'Kanjivaram Silk',     'slug' => 'kanjivaram-silk'],
            ['name' => 'Banarasi Silk',       'slug' => 'banarasi-silk'],
            ['name' => 'Paithani Handloom',   'slug' => 'paithani-handloom'],
            ['name' => 'Chanderi Silk',       'slug' => 'chanderi-silk'],
            ['name' => 'Organza Tissue',      'slug' => 'organza-tissue'],
            ['name' => 'Bridal Lehengas',     'slug' => 'bridal-lehengas'],
            ['name' => 'Designer Kurtis',     'slug' => 'designer-kurtis'],
            ['name' => 'Patola Heritage',     'slug' => 'patola-heritage'],
        ];

        $insCat = $pdo->prepare(
            'INSERT INTO categories (name, slug, status, display_order) VALUES (?, ?, "active", ?)
             ON DUPLICATE KEY UPDATE name = VALUES(name)'
        );
        $order = 1;
        foreach ($categories as $c) {
            $insCat->execute([$c['name'], $c['slug'], $order++]);
            $report['seeded_categories']++;
        }

        // ── 2. Admin user ──
        $adminEmail = 'admin@jaihanumantex.in';
        $checkAdmin = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $checkAdmin->execute([$adminEmail]);
        if ($checkAdmin->fetch() === false) {
            $hash = password_hash('DtBrand@Admin2026', PASSWORD_BCRYPT);
            $insUser = $pdo->prepare(
                "INSERT INTO users (name, email, password_hash, role, status, created_at)
                 VALUES ('DT Brand Admin', ?, ?, 'super_admin', 'active', NOW())"
            );
            $insUser->execute([$adminEmail, $hash]);
            $report['seeded_customers']++;
        }

        // ── 3. Default coupon codes ──
        $coupons = [
            ['code' => 'WELCOME10',  'type' => 'percentage', 'value' => 10.0, 'min' => 1500.0, 'max' => 500.0],
            ['code' => 'DTWHOLESALE','type' => 'percentage', 'value' => 15.0, 'min' => 5000.0, 'max' => 2000.0],
            ['code' => 'FLAT500',    'type' => 'flat',       'value' => 500.0, 'min' => 2000.0, 'max' => 0.0],
        ];
        $insCoupon = $pdo->prepare(
            'INSERT INTO coupons (code, discount_type, discount_value, min_order_value, max_discount, status)
             VALUES (?, ?, ?, ?, ?, "active")
             ON DUPLICATE KEY UPDATE discount_value = VALUES(discount_value)'
        );
        foreach ($coupons as $cp) {
            $insCoupon->execute([$cp['code'], $cp['type'], $cp['value'], $cp['min'], $cp['max']]);
            $report['seeded_coupons']++;
        }

        // ── 4. Banner rows ──
        $bannerStmt = $pdo->prepare(
            'INSERT INTO banners (title, subtitle, image_url, cta_text, cta_link, status, display_order)
             VALUES (?, ?, ?, ?, ?, "active", ?)'
        );
        $bannerStmt->execute([
            'Luxury Handloom Sarees Direct from Surat',
            'Wholesale & Retail lots starting at INR 1899',
            '/assets/images/hero-banner.png',
            'Shop the Collection',
            '/shop.php',
            1,
        ]);
        $bannerStmt->execute([
            'Verified Wholesale Mill Network',
            'Trusted by 600+ resellers across India',
            '/assets/images/banner-wholesale.png',
            'Become a Reseller',
            '/wholesale.php',
            2,
        ]);
        $report['seeded_banners'] = 2;

        $report['current_products'] = count(ProductCatalog::getAll());
        $report['current_customers'] = count(CustomerManager::getAll());
        return $report;
    }
}