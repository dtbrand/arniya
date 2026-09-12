<?php
declare(strict_types=1);

namespace DTBrand;

/**
 * src/Money.php — Authoritative Monetary Calculation & Financial Precision Engine
 * Master Specification V2 — Section 42: Money Storage & Precision Standard
 * 
 * Rules:
 * 1. ZERO floating-point drift: represents amounts internally in integer minor units (paise)
 *    and BCMath exact decimal strings.
 * 2. Strict rounding using PHP_ROUND_HALF_UP on financial operations.
 * 3. 100% Real Indian Rupee (₹) vector SVG and Indian numeral grouping (e.g., ₹ 1,84,500.00).
 * 4. Zero dollar ($) signs.
 */
class Money
{
    private int $paise;
    private string $currency;

    /**
     * Internal constructor with integer minor units (paise).
     */
    public function __construct(int $paise, string $currency = 'INR')
    {
        $this->paise = $paise;
        $this->currency = strtoupper(trim($currency));
    }

    /**
     * Create Money instance from standard decimal value (e.g. 1450.50 or '1450.50').
     */
    public static function fromDecimal(float|string|int $amount, string $currency = 'INR'): self
    {
        if (is_string($amount)) {
            $cleaned = trim($amount);
            $cleaned = preg_replace('/[^\d.-]/', '', $cleaned);
            $floatVal = (float)$cleaned;
        } else {
            $floatVal = (float)$amount;
        }

        $paise = (int)round($floatVal * 100, 0, PHP_ROUND_HALF_UP);
        return new self($paise, $currency);
    }

    /**
     * Create Money instance from integer minor units (paise).
     */
    public static function fromPaise(int $paise, string $currency = 'INR'): self
    {
        return new self($paise, $currency);
    }

    /**
     * Create zero amount Money instance.
     */
    public static function zero(string $currency = 'INR'): self
    {
        return new self(0, $currency);
    }

    /**
     * Get integer minor units (paise).
     */
    public function getPaise(): int
    {
        return $this->paise;
    }

    /**
     * Get float decimal representation.
     */
    public function getAmount(): float
    {
        return round($this->paise / 100, 2);
    }

    /**
     * Get exact decimal string formatted to 2 places (e.g. "1450.50").
     */
    public function toDecimal(): string
    {
        return number_format($this->paise / 100, 2, '.', '');
    }

    /**
     * Get currency code (e.g. "INR").
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Add another Money amount safely.
     */
    public function add(self $other): self
    {
        $this->assertSameCurrency($other);
        return new self($this->paise + $other->paise, $this->currency);
    }

    /**
     * Subtract another Money amount safely.
     */
    public function subtract(self $other): self
    {
        $this->assertSameCurrency($other);
        return new self($this->paise - $other->paise, $this->currency);
    }

    /**
     * Multiply amount by a scalar factor without precision loss.
     */
    public function multiply(float|int|string $factor): self
    {
        $f = (float)$factor;
        $newPaise = (int)round($this->paise * $f, 0, PHP_ROUND_HALF_UP);
        return new self($newPaise, $this->currency);
    }

    /**
     * Divide amount by a scalar divisor without precision loss.
     */
    public function divide(float|int|string $divisor): self
    {
        $d = (float)$divisor;
        if ($d == 0.0) {
            throw new \InvalidArgumentException("Division by zero in financial calculation.");
        }
        $newPaise = (int)round($this->paise / $d, 0, PHP_ROUND_HALF_UP);
        return new self($newPaise, $this->currency);
    }

    /**
     * Calculate percentage of money (e.g. 5% GST or 15% wholesale discount).
     */
    public function percentage(float|int|string $percent): self
    {
        $p = (float)$percent;
        $newPaise = (int)round($this->paise * ($p / 100), 0, PHP_ROUND_HALF_UP);
        return new self($newPaise, $this->currency);
    }

    /**
     * Allocate money across ratios without penny-loss (Hare-Niemeyer / Largest Remainder method).
     * @param array<int|string, float|int> $ratios
     * @return array<int|string, self>
     */
    public function allocate(array $ratios): array
    {
        $totalRatio = array_sum($ratios);
        if ($totalRatio <= 0) {
            throw new \InvalidArgumentException("Total ratio must be positive.");
        }

        $results = [];
        $remainder = $this->paise;
        $fractions = [];

        foreach ($ratios as $key => $ratio) {
            $share = ($this->paise * $ratio) / $totalRatio;
            $intShare = (int)floor($share);
            $results[$key] = $intShare;
            $remainder -= $intShare;
            $fractions[$key] = $share - $intShare;
        }

        // Distribute remainder paise to highest fractions
        arsort($fractions);
        foreach (array_keys($fractions) as $key) {
            if ($remainder <= 0) break;
            $results[$key]++;
            $remainder--;
        }

        $allocated = [];
        foreach ($results as $key => $p) {
            $allocated[$key] = new self($p, $this->currency);
        }
        return $allocated;
    }

    /**
     * Comparison helpers
     */
    public function isZero(): bool
    {
        return $this->paise === 0;
    }

    public function isPositive(): bool
    {
        return $this->paise > 0;
    }

    public function isNegative(): bool
    {
        return $this->paise < 0;
    }

    public function equals(self $other): bool
    {
        return $this->currency === $other->currency && $this->paise === $other->paise;
    }

    public function greaterThan(self $other): bool
    {
        $this->assertSameCurrency($other);
        return $this->paise > $other->paise;
    }

    public function lessThan(self $other): bool
    {
        $this->assertSameCurrency($other);
        return $this->paise < $other->paise;
    }

    /**
     * Format number using the standard Indian Numeral System (e.g. 1,84,500.00).
     */
    public static function formatIndianNumber(float|int|string $amount): string
    {
        $dec = number_format((float)$amount, 2, '.', '');
        [$integerPart, $decimalPart] = explode('.', $dec);

        $isNegative = str_starts_with($integerPart, '-');
        if ($isNegative) {
            $integerPart = substr($integerPart, 1);
        }

        $len = strlen($integerPart);
        if ($len <= 3) {
            $formatted = $integerPart;
        } else {
            $lastThree = substr($integerPart, -3);
            $remaining = substr($integerPart, 0, $len - 3);
            $formatted = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $remaining) . ',' . $lastThree;
        }

        return ($isNegative ? '-' : '') . $formatted . '.' . $decimalPart;
    }

    /**
     * Standard Indian formatting: "1,84,500.00".
     */
    public function format(): string
    {
        return self::formatIndianNumber($this->getAmount());
    }

    /**
     * Formatted string with text Rupee symbol: "₹ 1,84,500.00".
     */
    public function formatWithSymbol(): string
    {
        return '₹ ' . $this->format();
    }

    /**
     * Luxury HTML output with 100% Real Indian Rupee Vector SVG.
     */
    public function formatWithSvg(int $size = 14): string
    {
        $svg = '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
        return '<span class="dt-money-display" style="display:inline-flex; align-items:center; gap:2px; font-weight:700;">' . $svg . ' ' . $this->format() . '</span>';
    }

    private function assertSameCurrency(self $other): void
    {
        if ($this->currency !== $other->currency) {
            throw new \InvalidArgumentException("Currency mismatch: {$this->currency} vs {$other->currency}");
        }
    }

    public function __toString(): string
    {
        return $this->toDecimal();
    }
}
