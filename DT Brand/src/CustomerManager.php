<?php

namespace DTBrand;

/**
 * CustomerManager — B2B Partner, Wholesale & Retail Identity Engine
 * DT Brand's & Jai Hanuman Tex — Live Production Standard
 */
class CustomerManager
{
    // Deliberately no sample/fallback customer roster here. Every read method
    // returns real rows or nothing at all. A hardcoded roster used to be served
    // whenever the table was empty or unreachable, which put invented names and
    // real-format phone numbers into the admin directory, the WhatsApp
    // broadcast list and the CRM stat cards.

    public static function getAll(): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            // No database means we know nothing about the customer base. Returning
            // sample people here would put invented names, cities and — worst of
            // all — real-format phone numbers in front of an admin who can click
            // "WhatsApp Connect" and message a stranger.
            return [];
        }

        try {
            $rows = Database::query("
                SELECT `id`, `name`, `phone`, `email`, `type`, `city`, `state`, `tier`,
                       `credit_limit`, `outstanding_balance`, `total_orders`,
                       `lifetime_spend`, `commission_rate`, `gstin`, `pan`,
                       `status`, `created_at`
                FROM `customers`
                ORDER BY `id` ASC
            ");
        } catch (\Exception $e) {
            return [];
        }

        $result = [];
        foreach (($rows ?: []) as $r) {
            // Blank stays blank. A missing city is not "Surat" and a missing
            // email is not "customer@example.com" — the admin needs to be able
            // to see that a field is empty so they can go and fill it in.
            $result[] = [
                'id'                  => (int)$r['id'],
                'name'                => (string)($r['name'] ?? ''),
                'phone'               => (string)($r['phone'] ?? ''),
                'email'               => (string)($r['email'] ?? ''),
                'type'                => (string)($r['type'] ?? 'retail'),
                'city'                => (string)($r['city'] ?? ''),
                'state'               => (string)($r['state'] ?? ''),
                'tier'                => (string)($r['tier'] ?? ''),
                'gstin'               => (string)($r['gstin'] ?? ''),
                'pan'                 => (string)($r['pan'] ?? ''),
                'credit_limit'        => (float)($r['credit_limit'] ?? 0),
                'outstanding_balance' => (float)($r['outstanding_balance'] ?? 0),
                'total_orders'        => (int)($r['total_orders'] ?? 0),
                'lifetime_spend'      => (float)($r['lifetime_spend'] ?? 0),
                'commission_rate'     => (float)($r['commission_rate'] ?? 0),
                'created_at'          => (string)($r['created_at'] ?? ''),
                'status'              => (string)($r['status'] ?? 'active')
            ];
        }
        return $result;
    }

    public static function getById(int $id): ?array
    {
        if ($id <= 0) return null;

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return null;
        }

        try {
            // Targeted lookup. This used to filter getAll(), which read every
            // row in the customers table to find one.
            $stmt = $pdo->prepare("
                SELECT `id`, `name`, `phone`, `email`, `type`, `city`, `state`, `tier`,
                       `credit_limit`, `outstanding_balance`, `total_orders`,
                       `lifetime_spend`, `commission_rate`, `gstin`, `pan`,
                       `status`, `created_at`
                FROM `customers`
                WHERE `id` = ?
                LIMIT 1
            ");
            $stmt->execute([$id]);
            $r = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            return null;
        }

        if (!$r) return null;

        return [
            'id'                  => (int)$r['id'],
            'name'                => (string)($r['name'] ?? ''),
            'phone'               => (string)($r['phone'] ?? ''),
            'email'               => (string)($r['email'] ?? ''),
            'type'                => (string)($r['type'] ?? 'retail'),
            'city'                => (string)($r['city'] ?? ''),
            'state'               => (string)($r['state'] ?? ''),
            'tier'                => (string)($r['tier'] ?? ''),
            'gstin'               => (string)($r['gstin'] ?? ''),
            'pan'                 => (string)($r['pan'] ?? ''),
            'credit_limit'        => (float)($r['credit_limit'] ?? 0),
            'outstanding_balance' => (float)($r['outstanding_balance'] ?? 0),
            'total_orders'        => (int)($r['total_orders'] ?? 0),
            'lifetime_spend'      => (float)($r['lifetime_spend'] ?? 0),
            'commission_rate'     => (float)($r['commission_rate'] ?? 0),
            'created_at'          => (string)($r['created_at'] ?? ''),
            'status'              => (string)($r['status'] ?? 'active')
        ];
    }

    public static function getByType(string $type): array
    {
        $all = self::getAll();
        return array_values(array_filter($all, fn($c) => strcasecmp($c['type'], $type) === 0));
    }

    public static function create(array $data): array
    {
        $pdo = Database::getConnection();
        $name = trim($data['name'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $email = trim($data['email'] ?? '');
        $type = trim($data['type'] ?? 'retail');
        $type = in_array($type, ['retail', 'wholesale', 'reseller'], true) ? $type : 'retail';
        $tier = trim($data['tier'] ?? ($type === 'wholesale' ? 'Diamond Elite' : ($type === 'reseller' ? 'Gold VIP' : 'Silver Consumer')));
        $city = trim($data['city'] ?? '');
        $state = trim($data['state'] ?? '');
        $gst = trim($data['gstin'] ?? $data['gst_number'] ?? '');
        $creditLimit = (float)($data['credit_limit'] ?? 0.0);
        $status = trim($data['status'] ?? 'active');
        $status = in_array($status, ['active', 'pending', 'suspended'], true) ? $status : 'active';

        // customers.phone is NOT NULL UNIQUE and is the login identity, so a
        // blank one cannot be stored and a blank name leaves an unidentifiable
        // row. Reject before touching the database.
        if ($name === '') {
            return ['success' => false, 'message' => 'A customer name is required.'];
        }
        if ($phone === '') {
            return ['success' => false, 'message' => 'A phone number is required — it is the login identity.'];
        }

        // Never fall back to a shared literal password. Every account created
        // without one would otherwise be sign-in-able by anyone who has read
        // this file. A random secret means the customer must use the password
        // reset flow, which is the correct path anyway.
        $suppliedPassword = (string)($data['password'] ?? '');
        if ($suppliedPassword === '') {
            $suppliedPassword = bin2hex(random_bytes(18));
        }
        $passwordHash = password_hash($suppliedPassword, PASSWORD_BCRYPT);

        if ($pdo === null || Database::isMockMode()) {
            // Appending to a static array would vanish at the end of the request.
            // Reporting success would tell an admin a customer exists when it does not.
            return ['success' => false, 'message' => 'The customer database is unavailable, so this customer was not created.'];
        }

        try {
            $chk = $pdo->prepare("SELECT id FROM customers WHERE phone = ? LIMIT 1");
            $chk->execute([$phone]);
            if ($chk->fetch()) {
                return ['success' => false, 'message' => 'Customer with this phone number already exists.'];
            }

            $stmt = $pdo->prepare("
                INSERT INTO customers
                (name, phone, email, password_hash, gstin, type, tier, city, state, credit_limit, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$name, $phone, $email, $passwordHash, $gst, $type, $tier, $city, $state, $creditLimit, $status]);
            $newId = (int)$pdo->lastInsertId();
            if ($newId <= 0) {
                return ['success' => false, 'message' => 'The customer could not be created.'];
            }

            // The admin create form collects a street address, but customers has
            // no address columns -- an address is a row in `addresses`. Without
            // this the address an admin typed was accepted and dropped. Optional:
            // a customer created from a phone call may not have given one yet.
            $line1 = trim((string)($data['address'] ?? $data['address_line1'] ?? ''));
            $line2 = trim((string)($data['landmark'] ?? $data['address_line2'] ?? ''));
            $pin   = trim((string)($data['postal_code'] ?? $data['pincode'] ?? ''));
            if ($line1 !== '' || $pin !== '') {
                try {
                    $addrType = $type === 'retail' ? 'home' : 'warehouse';
                    $addr = $pdo->prepare("
                        INSERT INTO addresses
                        (customer_id, recipient_name, phone, address_line1, address_line2,
                         city, state, pincode, address_type, is_default, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())
                    ");
                    $addr->execute([$newId, $name, $phone, $line1, $line2, $city, $state, $pin, $addrType]);
                } catch (\Exception $e) {
                    // The customer exists and is usable; report the partial result
                    // rather than implying the address was stored.
                    return [
                        'success' => true,
                        'id' => $newId,
                        'message' => 'Customer created, but the address could not be saved.',
                    ];
                }
            }

            return ['success' => true, 'id' => $newId, 'message' => 'Customer created successfully!'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function update(int $id, array $data): array
    {
        if ($id <= 0) return ['success' => false, 'message' => 'Invalid ID'];

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            // admin/customers/edit.php only navigates away when this reports
            // success, so reporting success with no database would tell the
            // admin their edits were saved while discarding them.
            return ['success' => false, 'message' => 'The customer database is unavailable, so nothing was saved.'];
        }

        try {
            // Accept the legacy gst_number alias but write to the real gstin column
            if (isset($data['gst_number']) && !isset($data['gstin'])) {
                $data['gstin'] = $data['gst_number'];
            }
            // status and type are ENUMs. Outside strict mode MySQL silently
            // coerces an unknown value to '' while execute() still returns true,
            // which would quietly strip a customer's account type.
            if (isset($data['status']) && !in_array($data['status'], ['active', 'pending', 'suspended'], true)) {
                return ['success' => false, 'message' => 'Status must be active, pending or suspended.'];
            }
            if (isset($data['type']) && !in_array($data['type'], ['retail', 'wholesale', 'reseller'], true)) {
                return ['success' => false, 'message' => 'Account type must be retail, wholesale or reseller.'];
            }

            $fields = [];
            $params = [];
            foreach (['name', 'phone', 'email', 'gstin', 'pan', 'type', 'tier', 'city', 'state', 'credit_limit', 'outstanding_balance', 'commission_rate', 'status'] as $f) {
                if (isset($data[$f])) {
                    $fields[] = "`{$f}` = ?";
                    $params[] = $data[$f];
                }
            }
            if (empty($fields)) {
                return ['success' => false, 'message' => 'There was nothing to update.'];
            }

            $params[] = $id;
            $stmt = $pdo->prepare("UPDATE customers SET " . implode(', ', $fields) . " WHERE id = ?");
            $stmt->execute($params);

            // rowCount() is 0 both when no such customer exists and when the
            // submitted values already matched. Only the second is a success.
            if ($stmt->rowCount() === 0) {
                $chk = $pdo->prepare("SELECT id FROM customers WHERE id = ? LIMIT 1");
                $chk->execute([$id]);
                if (!$chk->fetch()) {
                    return ['success' => false, 'message' => 'That customer no longer exists.'];
                }
            }
            return ['success' => true, 'id' => $id, 'message' => 'Customer updated successfully!'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public static function delete(int $id): bool
    {
        if ($id <= 0) return false;

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("DELETE FROM customers WHERE id = ?");
            $stmt->execute([$id]);
            // execute() is true for a statement that matched nothing, so a
            // delete of a non-existent id would otherwise look like it worked.
            return $stmt->rowCount() > 0;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Flip a customer account between active / pending / suspended.
     *
     * This is the switch that grants trade pricing: a wholesale or reseller
     * signup is parked at 'pending' by Auth::register, and only becomes able to
     * sign in and buy at mill rates once it is 'active'. So it must not report
     * success unless a row really changed.
     *
     * customers.status is an ENUM, and MySQL outside strict mode silently
     * coerces an unknown value to '' while execute() still returns true — which
     * would blank the status and read back as a successful approval. Hence the
     * whitelist.
     */
    public static function updateStatus(int $id, string $status): bool
    {
        if ($id <= 0) return false;

        $status = strtolower(trim($status));
        if (!in_array($status, ['active', 'pending', 'suspended'], true)) {
            return false;
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            // No database means nothing was stored. Saying otherwise would let
            // an admin believe a trade account had been approved.
            return false;
        }

        try {
            $stmt = $pdo->prepare("UPDATE customers SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            if ($stmt->rowCount() > 0) {
                return true;
            }
            // rowCount() is 0 both for "no such customer" and for "already had
            // this status". Only the second is a success.
            $check = $pdo->prepare("SELECT status FROM customers WHERE id = ? LIMIT 1");
            $check->execute([$id]);
            $current = $check->fetchColumn();
            return $current !== false && strtolower((string)$current) === $status;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function updateCreditLimit(int $id, float $creditLimit): bool
    {
        if ($id <= 0) return false;

        // A credit limit is how much stock a wholesale buyer may take before
        // paying. Silently failing to store it, then reporting success, would
        // let an admin believe they had extended credit that no order check
        // will ever see.
        if ($creditLimit < 0) return false;

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return false;
        }

        try {
            $stmt = $pdo->prepare("UPDATE customers SET credit_limit = ? WHERE id = ?");
            $stmt->execute([$creditLimit, $id]);
            if ($stmt->rowCount() > 0) return true;

            // Unchanged value on an existing customer is still a success;
            // a missing customer is not.
            $chk = $pdo->prepare("SELECT id FROM customers WHERE id = ? LIMIT 1");
            $chk->execute([$id]);
            return (bool)$chk->fetch();
        } catch (\Exception $e) {
            return false;
        }
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


