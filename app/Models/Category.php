<?php

namespace App\Models;

/**
 * Category Model
 * DT Brand's & Jai Hanuman Tex
 */
class Category
{
    private static array $categories = [
        ['id' => 1, 'name' => 'Kanjivaram Silk', 'slug' => 'kanjivaram-silk'],
        ['id' => 2, 'name' => 'Banarasi Silk', 'slug' => 'banarasi-silk'],
        ['id' => 3, 'name' => 'Paithani', 'slug' => 'paithani'],
        ['id' => 4, 'name' => 'Chanderi', 'slug' => 'chanderi'],
        ['id' => 5, 'name' => 'Organza', 'slug' => 'organza'],
        ['id' => 6, 'name' => 'Patola', 'slug' => 'patola']
    ];

    public static function all(): array
    {
        return self::$categories;
    }
}
