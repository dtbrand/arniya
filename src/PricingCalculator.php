<?php

namespace DTBrand;

/**
 * PricingCalculator — Core B2B, Wholesale, and Retail Price Calculation Engine
 * DT Brand's & Jai Hanuman Tex
 */
class PricingCalculator
{
    /**
     * Default B2B wholesale quantity tier discounts
     */
    public const DEFAULT_WHOLESALE_TIERS = [
        ['min_qty' => 100, 'discount_percent' => 15.0, 'tier_name' => 'Master Lot (100+)'],
        ['min_qty' => 50,  'discount_percent' => 10.0, 'tier_name' => 'Full Bale (50+)'],
        ['min_qty' => 10,  'discount_percent' => 5.0,  'tier_name' => 'Half Bale (10+)'],
        ['min_qty' => 1,   'discount_percent' => 0.0,  'tier_name' => 'Standard Lot (1-9)'],
    ];

    /**
     * Calculate wholesale price from MRP and discount percentage
     */
    public static function calculateWholesalePrice(float $mrp, float $discountPercent): float
    {
        if ($mrp < 0 || $discountPercent < 0 || $discountPercent > 100) {
            throw new \InvalidArgumentException('Invalid MRP or discount percentage');
        }
        return round($mrp * (1 - ($discountPercent / 100)), 2);
    }

    /**
     * Calculate GST amount
     */
    public static function calculateGst(float $amount, float $gstRate = 5.0): float
    {
        if ($amount < 0 || $gstRate < 0) {
            throw new \InvalidArgumentException('Invalid amount or GST rate');
        }
        return round($amount * ($gstRate / 100), 2);
    }

    /**
     * Convert float/string into authoritative Money instance
     */
    public static function toMoney(float|string|int $amount, string $currency = 'INR'): Money
    {
        return Money::fromDecimal($amount, $currency);
    }

    /**
     * Calculate Net Total with GST and Gateway Fees using exact Money arithmetic
     */
    public static function calculateOrderTotal(float $subtotal, float $discount = 0.0, float $shipping = 0.0, float $gstRate = 5.0): array
    {
        $subMoney = Money::fromDecimal($subtotal);
        $discMoney = Money::fromDecimal($discount);
        $shipMoney = Money::fromDecimal($shipping);

        $taxableMoney = $subMoney->greaterThan($discMoney) ? $subMoney->subtract($discMoney) : Money::zero();
        $gstMoney = $taxableMoney->percentage($gstRate);
        $grandTotalMoney = $taxableMoney->add($gstMoney)->add($shipMoney);

        return [
            'subtotal' => $subMoney->getAmount(),
            'discount' => $discMoney->getAmount(),
            'taxable' => $taxableMoney->getAmount(),
            'gst' => $gstMoney->getAmount(),
            'gst_amount' => $gstMoney->getAmount(),
            'shipping' => $shipMoney->getAmount(),
            'grand_total' => $grandTotalMoney->getAmount(),
            'formatted_grand_total' => $grandTotalMoney->formatWithSvg()
        ];
    }

    /**
     * Calculate tiered volume discounts for wholesale bale purchases
     */
    public static function calculateTieredVolumeDiscount(float $basePrice, int $quantity, array $tiers = []): array
    {
        if ($basePrice < 0 || $quantity <= 0) {
            throw new \InvalidArgumentException('Base price must be non-negative and quantity must be greater than zero');
        }

        $activeTiers = !empty($tiers) ? $tiers : self::DEFAULT_WHOLESALE_TIERS;
        
        // Sort tiers descending by min_qty
        usort($activeTiers, function ($a, $b) {
            return ($b['min_qty'] ?? 0) <=> ($a['min_qty'] ?? 0);
        });

        $matchedDiscount = 0.0;
        $matchedTierName = 'Standard Lot';

        foreach ($activeTiers as $tier) {
            $minQty = (int)($tier['min_qty'] ?? 1);
            if ($quantity >= $minQty) {
                $matchedDiscount = (float)($tier['discount_percent'] ?? 0.0);
                $matchedTierName = (string)($tier['tier_name'] ?? 'Tier');
                break;
            }
        }

        $unitDiscount = round($basePrice * ($matchedDiscount / 100), 2);
        $unitPrice = round($basePrice - $unitDiscount, 2);
        $totalPrice = round($unitPrice * $quantity, 2);
        $totalDiscount = round($unitDiscount * $quantity, 2);

        return [
            'base_unit_price' => round($basePrice, 2),
            'quantity' => $quantity,
            'discount_percent' => $matchedDiscount,
            'tier_name' => $matchedTierName,
            'unit_discount' => $unitDiscount,
            'discounted_unit_price' => $unitPrice,
            'total_discount' => $totalDiscount,
            'total_price' => $totalPrice,
        ];
    }

    /**
     * Calculate Reseller profit margin and markup metrics
     */
    public static function calculateResellerMargin(float $wholesaleCost, float $retailPrice): array
    {
        if ($wholesaleCost <= 0 || $retailPrice < 0) {
            throw new \InvalidArgumentException('Wholesale cost must be positive and retail price non-negative');
        }

        $marginAmount = round($retailPrice - $wholesaleCost, 2);
        $marginPercent = round(($marginAmount / $wholesaleCost) * 100, 2);
        $profitPercentageOnSale = $retailPrice > 0 ? round(($marginAmount / $retailPrice) * 100, 2) : 0.0;

        return [
            'wholesale_cost' => round($wholesaleCost, 2),
            'retail_price' => round($retailPrice, 2),
            'margin_amount' => $marginAmount,
            'margin_percent' => $marginPercent,
            'profit_margin_on_sale' => $profitPercentageOnSale,
            'is_profitable' => $marginAmount >= 0,
        ];
    }

    /**
     * Calculate Indian GST split (CGST + SGST for intra-state Gujarat sales, IGST for inter-state)
     */
    public static function calculateGstSplit(
        float $taxableAmount,
        float $gstRate = 5.0,
        string $customerState = 'Gujarat',
        string $sellerState = 'Gujarat'
    ): array {
        if ($taxableAmount < 0 || $gstRate < 0) {
            throw new \InvalidArgumentException('Invalid taxable amount or GST rate');
        }

        $cleanCustomerState = strtolower(trim($customerState));
        $cleanSellerState = strtolower(trim($sellerState));
        $isInterstate = ($cleanCustomerState !== '' && $cleanCustomerState !== $cleanSellerState);

        if ($isInterstate) {
            $igstAmount = round($taxableAmount * ($gstRate / 100), 2);
            return [
                'taxable_amount' => round($taxableAmount, 2),
                'gst_rate' => $gstRate,
                'is_interstate' => true,
                'seller_state' => trim($sellerState),
                'customer_state' => trim($customerState),
                'cgst_rate' => 0.0,
                'cgst_amount' => 0.0,
                'sgst_rate' => 0.0,
                'sgst_amount' => 0.0,
                'igst_rate' => $gstRate,
                'igst_amount' => $igstAmount,
                'total_gst' => $igstAmount,
            ];
        }

        $halfRate = round($gstRate / 2, 2);
        $cgstAmount = round($taxableAmount * ($halfRate / 100), 2);
        $sgstAmount = round($taxableAmount * ($halfRate / 100), 2);
        $totalGst = round($cgstAmount + $sgstAmount, 2);

        return [
            'taxable_amount' => round($taxableAmount, 2),
            'gst_rate' => $gstRate,
            'is_interstate' => false,
            'seller_state' => trim($sellerState),
            'customer_state' => trim($customerState),
            'cgst_rate' => $halfRate,
            'cgst_amount' => $cgstAmount,
            'sgst_rate' => $halfRate,
            'sgst_amount' => $sgstAmount,
            'igst_rate' => 0.0,
            'igst_amount' => 0.0,
            'total_gst' => $totalGst,
        ];
    }

    /**
     * Format currency amount according to the Indian Numbering System (Lakhs & Crores)
     * Example: 150000.00 -> ₹1,50,000.00
     */
    public static function formatInr(float $amount, bool $includeSymbol = true): string
    {
        $isNegative = $amount < 0;
        $absAmount = abs($amount);

        // Separate integer and fractional parts
        $parts = explode('.', sprintf('%.2f', $absAmount));
        $integerPart = $parts[0];
        $fractionalPart = $parts[1] ?? '00';

        // Apply Indian formatting to integer part:
        // Last 3 digits grouped, then groups of 2 digits
        if (strlen($integerPart) > 3) {
            $lastThree = substr($integerPart, -3);
            $remaining = substr($integerPart, 0, -3);
            
            // Format remaining digits in groups of 2 from right to left
            $groups = [];
            while (strlen($remaining) > 2) {
                array_unshift($groups, substr($remaining, -2));
                $remaining = substr($remaining, 0, -2);
            }
            if (strlen($remaining) > 0) {
                array_unshift($groups, $remaining);
            }
            $formattedInteger = implode(',', $groups) . ',' . $lastThree;
        } else {
            $formattedInteger = $integerPart;
        }

        $formatted = $formattedInteger . '.' . $fractionalPart;
        $sign = $isNegative ? '-' : '';
        $symbol = $includeSymbol ? '₹' : '';

        return $sign . $symbol . $formatted;
    }
}
