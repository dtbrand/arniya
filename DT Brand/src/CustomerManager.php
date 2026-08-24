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

    public static function create(array $data): array
    {
        $pdo = Database::getConnection();
        $name = trim($data['name'] ?? 'New Customer');
        $phone = trim($data['phone'] ?? '');
        $email = trim($data['email'] ?? '');
        $type = trim($data['type'] ?? 'retail');
        $tier = trim($data['tier'] ?? ($type === 'wholesale' ? 'Diamond Elite' : ($type === 'reseller' ? 'Gold VIP' : 'Silver Consumer')));
        $city = trim($data['city'] ?? 'Surat');
        $state = trim($data['state'] ?? 'Gujarat');
        $company = trim($data['company_name'] ?? '');
        $gst = trim($data['gst_number'] ?? '');
        $creditLimit = (float)($data['credit_limit'] ?? 0.0);
        $status = trim($data['status'] ?? 'active');
        $passwordHash = password_hash($data['password'] ?? 'dtbrand123', PASSWORD_BCRYPT);

        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $chk = $pdo->prepare("SELECT id FROM customers WHERE phone = ? LIMIT 1");
                $chk->execute([$phone]);
                if ($chk->fetch()) {
                    return ['success' => false, 'message' => 'Customer with this phone number already exists.'];
                }

                $stmt = $pdo->prepare("
                    INSERT INTO customers 
                    (name, phone, email, password_hash, company_name, gst_number, type, tier, city, state, credit_limit, status, created_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                $stmt->execute([$name, $phone, $email, $passwordHash, $company, $gst, $type, $tier, $city, $state, $creditLimit, $status]);
                $newId = (int)$pdo->lastInsertId();
                return ['success' => true, 'id' => $newId, 'message' => 'Customer created successfully!'];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => $e->getMessage()];
            }
        }

        $newId = rand(200, 999);
        $newRecord = array_merge($data, ['id' => $newId, 'status' => $status]);
        self::$customers[] = $newRecord;
        return ['success' => true, 'id' => $newId, 'message' => 'Customer saved!'];
    }

    public static function update(int $id, array $data): array
    {
        if ($id <= 0) return ['success' => false, 'message' => 'Invalid ID'];

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $fields = [];
                $params = [];
                foreach (['name', 'phone', 'email', 'company_name', 'gst_number', 'type', 'tier', 'city', 'state', 'credit_limit', 'outstanding_balance', 'status'] as $f) {
                    if (isset($data[$f])) {
                        $fields[] = "{$f} = ?";
                        $params[] = $data[$f];
                    }
                }
                if (!empty($fields)) {
                    $params[] = $id;
                    $stmt = $pdo->prepare("UPDATE customers SET " . implode(', ', $fields) . " WHERE id = ?");
                    $stmt->execute($params);
                    return ['success' => true, 'id' => $id, 'message' => 'Customer updated successfully!'];
                }
            } catch (\Exception $e) {
                return ['success' => false, 'message' => $e->getMessage()];
            }
        }
        return ['success' => true, 'id' => $id, 'message' => 'Customer updated!'];
    }

    public static function delete(int $id): bool
    {
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("DELETE FROM customers WHERE id = ?");
                return $stmt->execute([$id]);
            } catch (\Exception $e) {}
        }
        return true;
    }

    public static function updateStatus(int $id, string $status): bool
    {
        if ($id <= 0) return false;
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("UPDATE customers SET status = ? WHERE id = ?");
                return $stmt->execute([$status, $id]);
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }

    public static function updateCreditLimit(int $id, float $creditLimit): bool
    {
        if ($id <= 0) return false;
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("UPDATE customers SET credit_limit = ? WHERE id = ?");
                return $stmt->execute([$creditLimit, $id]);
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }

    public static function getStats(): array
    {
        $all = self::getAll();
        $totalWholesale = 0;
        $totalResellers = 0;
        $totalRetail = 0;
        $totalCreditExtended = 0;
        $totalOutstanding = 0;

        foreach ($all as $c) {
            if ($c['type'] === 'wholesale') $totalWholesale++;
            elseif ($c['type'] === 'reseller') $totalResellers++;
            else $totalRetail++;

            $totalCreditExtended += (float)($c['credit_limit'] ?? 0);
            $totalOutstanding += (float)($c['outstanding_balance'] ?? 0);
        }

        return [
            'total_customers' => count($all),
            'wholesale_count' => $totalWholesale,
            'reseller_count' => $totalResellers,
            'retail_count' => $totalRetail,
            'credit_extended' => $totalCreditExtended,
            'outstanding_balance' => $totalOutstanding
        ];
    }
}


