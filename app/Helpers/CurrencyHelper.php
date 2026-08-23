<?php

namespace App\Helpers;

/**
 * CurrencyHelper — Real Indian Rupee (₹) Formatting Standard
 * DT Brand's & Jai Hanuman Tex
 */
class CurrencyHelper
{
    /**
     * Format number to Indian Rupee with comma grouping (Lakh / Crore)
     */
    public static function format(float $amount, bool $showSymbol = true): string
    {
        $symbol = $showSymbol ? '₹' : '';
        $formatted = number_format($amount, 2, '.', ',');
        return $symbol . $formatted;
    }

    /**
     * Parse currency string to float
     */
    public static function parse(string $currencyString): float
    {
        $clean = preg_replace('/[^0-9.]/', '', $currencyString);
        return (float)$clean;
    }
}
