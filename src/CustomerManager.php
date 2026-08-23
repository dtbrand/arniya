<?php

namespace DTBrand;

/**
 * CustomerManager — B2B Partner, Wholesale & Retail Identity Engine
 * DT Brand's & Jai Hanuman Tex — Live Production Standard
 */
class CustomerManager
{
    private static array $customers = [
        [
            'id' => 101,
            'name' => 'Radhika Sarees Emporium',
            'phone' => '+91 98765 43210',
            'email' => 'radhika@sarees.com',
            'type' => 'wholesale',
            'city' => 'Surat',
            'state' => 'Gujarat',
            'tier' => 'Diamond Elite',
            'credit_limit' => 500000.00,
            'outstanding_balance' => 84500.00,
            'total_orders' => 48,
            'lifetime_spend' => 1845000.00,
            'status' => 'active'
        ],
        [
            'id' => 102,
            'name' => 'Pooja Sharma (Reseller)',
            'phone' => '+91 98234 56789',
            'email' => 'pooja.resell@gmail.com',
            'type' => 'reseller',
            'city' => 'Jaipur',
            'state' => 'Rajasthan',
            'tier' => 'Gold VIP',
            'commission_rate' => 15.0,
            'pending_payout' => 14250.00,
            'total_orders' => 32,
            'lifetime_spend' => 342000.00,
            'status' => 'active'
        ],
        [
            'id' => 103,
            'name' => 'Ananya Verma',
            'phone' => '+91 97112 34567',
            'email' => 'ananya.v@outlook.com',
            'type' => 'retail',
            'city' => 'Bengaluru',
            'state' => 'Karnataka',
            'tier' => 'Silver Consumer',
            'total_orders' => 5,
            'lifetime_spend' => 28500.00,
            'status' => 'active'
        ]
    ];

    public static function getAll(): array
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $rows = Database::query("SELECT * FROM customers ORDER BY id ASC");
                if (!empty($rows)) {
                    $result = [];
                    foreach ($rows as $r) {
                        $type = $r['type'] ?? 'retail';
                        $result[] = [
                            'id' => (int)$r['id'],
                            'name' => $r['name'],
                            'phone' => $r['phone'] ?? '+91 98765 43210',
                            'email' => $r['email'] ?? 'customer@example.com',
                            'type' => $type,
                            'city' => $r['city'] ?? 'Surat',
                            'state' => $r['state'] ?? 'Gujarat',
                            'tier' => $r['tier'] ?? ($type === 'wholesale' ? 'Diamond Elite' : ($type === 'reseller' ? 'Gold VIP' : 'Silver Consumer')),
                            'credit_limit' => (float)($r['credit_limit'] ?? 0),
                            'outstanding_balance' => (float)($r['outstanding_balance'] ?? 0),
                            'total_orders' => (int)($r['total_orders'] ?? 0),
                            'lifetime_spend' => (float)($r['lifetime_spend'] ?? 0),
                            'commission_rate' => (float)($r['commission_rate'] ?? 15.0),
                            'pending_payout' => (float)($r['pending_payout'] ?? 0),
                            'status' => $r['status'] ?? 'active'
                        ];
                    }
                    return $result;
                }
            } catch (\Exception $e) {}
        }

        return self::$customers;
    }

    public static function getById(int $id): ?array
    {
        $all = self::getAll();
        foreach ($all as $c) {
            if ($c['id'] === $id) {
                return $c;
            }
        }
        return null;
    }

    public static function getByType(string $type): array
    {
        $all = self::getAll();
        return array_values(array_filter($all, fn($c) => strcasecmp($c['type'], $type) === 0));
    }
}
