<?php

namespace Database\Seeders;

/**
 * DatabaseSeeder — Initial Seed Data
 * DT Brand's & Jai Hanuman Tex
 */
class DatabaseSeeder
{
    public static function run(): array
    {
        return [
            'seeded_categories' => 6,
            'seeded_products' => 24,
            'seeded_admin_users' => 2,
            'status' => 'success'
        ];
    }
}
