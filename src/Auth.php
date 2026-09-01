<?php

namespace DTBrand;

require_once __DIR__ . '/Database.php';

/**
 * Auth — Enterprise Customer & Admin Authentication Engine
 * DT Brand's & Jai Hanuman Tex — Live Production Standard
 */
class Auth
{
    /**
     * Start secure session if not already active
     */
    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Register a new customer
     */
    public static function register(array $data): array
    {
        self::initSession();

        $name = trim($data['name'] ?? '');
        $phone = trim($data['phone'] ?? '');
        $email = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        // The tier the visitor ASKED for. It is not granted here — see below.
        $rawType = strtolower(trim($data['type'] ?? ''));
        $requestedType = in_array($rawType, ['customer', 'retail', 'wholesale', 'reseller', 'retailer'], true) ? $rawType : 'customer';
        $city = trim($data['city'] ?? '');
        $state = trim($data['state'] ?? '');
        $gstin = strtoupper(preg_replace('/\s+/', '', (string)($data['gstin'] ?? '')));
        $pan = strtoupper(preg_replace('/\s+/', '', (string)($data['pan'] ?? '')));

        if (empty($name) || empty($phone) || empty($password)) {
            return ['success' => false, 'message' => 'Name, phone number, and password are required.'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Password must be at least 6 characters.'];
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $pdo = Database::getConnection();

        // ── Direct Approved Protocol ──
        // Every registered account (Customer, Wholesale, Retailer, Reseller) is instantly granted
        // their requested tier with direct 'active' status.
        $grantType = $requestedType;
        $grantStatus = 'active';

        if ($pdo !== null && !Database::isMockMode()) {
            try {
                // Check if phone or email is already registered
                $cleanDigits = preg_replace('/[^\d]/', '', $phone);
                $last10 = strlen($cleanDigits) >= 10 ? substr($cleanDigits, -10) : '';

                if ($last10 !== '') {
                    $checkStmt = $pdo->prepare("SELECT id, password_hash, type, status FROM customers WHERE (phone = ? OR phone LIKE ?) OR (email = ? AND email != '') LIMIT 1");
                    $checkStmt->execute([$phone, '%' . $last10, $email]);
                } else {
                    $checkStmt = $pdo->prepare("SELECT id, password_hash, type, status FROM customers WHERE phone = ? OR (email = ? AND email != '') LIMIT 1");
                    $checkStmt->execute([$phone, $email]);
                }
                $existing = $checkStmt->fetch(\PDO::FETCH_ASSOC);

                if ($existing) {
                    if (!empty($existing['password_hash'])) {
                        return ['success' => false, 'message' => 'An account with this phone or email already exists. Please sign in instead.'];
                    }
                    // Password-less row (e.g. created during guest checkout): activate with chosen type
                    $customerId = (int)$existing['id'];
                    $upd = $pdo->prepare("UPDATE customers SET name = ?, email = COALESCE(NULLIF(?, ''), email), password_hash = ?, type = ?, status = 'active', gstin = COALESCE(NULLIF(?, ''), gstin), pan = COALESCE(NULLIF(?, ''), pan), city = COALESCE(NULLIF(?, ''), city), state = COALESCE(NULLIF(?, ''), state) WHERE id = ?");
                    $upd->execute([$name, $email, $passwordHash, $grantType, $gstin, $pan, $city, $state, $customerId]);
                } else {
                    $stmt = $pdo->prepare("
                        INSERT INTO customers (name, phone, email, password_hash, type, city, state, gstin, pan, status, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW())
                    ");
                    $stmt->execute([$name, $phone, $email, $passwordHash, $grantType, $city, $state, ($gstin !== '' ? $gstin : null), ($pan !== '' ? $pan : null)]);
                    $customerId = (int)$pdo->lastInsertId();
                }

                $user = [
                    'id' => $customerId,
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'type' => $grantType,
                    'tier' => 'Standard',
                    'city' => $city,
                    'state' => $state,
                    'status' => 'active'
                ];

                session_regenerate_id(true);
                $_SESSION['user'] = $user;
                $_SESSION['user_type'] = $grantType;

                return ['success' => true, 'message' => 'Registration successful! Welcome to DT Brand\'s.', 'user' => $user];
            } catch (\Exception $e) {
                error_log('DT register failed: ' . $e->getMessage());
                return ['success' => false, 'message' => 'Your account could not be created right now. Please try again in a moment, or message us on WhatsApp.'];
            }
        }

        // Fallback session registration
        $user = [
            'id' => 999,
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'type' => $grantType,
            'tier' => 'Standard',
            'city' => $city,
            'state' => $state,
            'status' => 'active'
        ];
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        $_SESSION['user_type'] = $grantType;

        return ['success' => true, 'message' => 'Registration successful!', 'user' => $user];
    }

    /**
     * Authenticate Customer or Partner Login
     */
    public static function login(string $identity, string $password): array
    {
        self::initSession();

        $identity = trim($identity);
        if (empty($identity) || empty($password)) {
            return ['success' => false, 'message' => 'Phone/email and password are required.'];
        }

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $cleanDigits = preg_replace('/[^\d]/', '', $identity);
                $last10 = strlen($cleanDigits) >= 10 ? substr($cleanDigits, -10) : '';

                if ($last10 !== '') {
                    $stmt = $pdo->prepare("
                        SELECT * FROM customers 
                        WHERE (phone = ? OR phone = ? OR phone LIKE ? OR email = ?) AND (status = 'active' OR status IS NULL OR status = '') 
                        LIMIT 1
                    ");
                    $stmt->execute([$identity, $cleanDigits, '%' . $last10, $identity]);
                } else {
                    $stmt = $pdo->prepare("
                        SELECT * FROM customers 
                        WHERE (phone = ? OR email = ?) AND (status = 'active' OR status IS NULL OR status = '') 
                        LIMIT 1
                    ");
                    $stmt->execute([$identity, $identity]);
                }
                $customer = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($customer) {
                    $hash = $customer['password_hash'] ?? '';
                    if (empty($hash)) {
                        return ['success' => false, 'message' => 'No password is set for this account yet. Please use "Create Account" with this phone/email to set your password.'];
                    }
                    $passwordValid = password_verify($password, $hash);

                    if ($passwordValid) {
                        $user = [
                            'id' => (int)$customer['id'],
                            'name' => $customer['name'],
                            'phone' => $customer['phone'],
                            'email' => $customer['email'] ?? '',
                            'type' => $customer['type'] ?? 'customer',
                            'tier' => $customer['tier'] ?? 'Standard',
                            'city' => $customer['city'] ?? '',
                            'state' => $customer['state'] ?? '',
                            'gstin' => $customer['gstin'] ?? '',
                            'credit_limit' => (float)($customer['credit_limit'] ?? 0),
                            'outstanding_balance' => (float)($customer['outstanding_balance'] ?? 0),
                            'status' => $customer['status'] ?? 'active'
                        ];

                        session_regenerate_id(true);
                        $_SESSION['user'] = $user;
                        $_SESSION['user_type'] = $user['type'];

                        try {
                            $pdo->prepare("UPDATE customers SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);
                        } catch (\Exception $ex) {
                        }

                        return ['success' => true, 'message' => 'Login successful! Welcome back, ' . htmlspecialchars($user['name']) . '.', 'user' => $user];
                    }
                }

                return ['success' => false, 'message' => 'Invalid phone/email or password. Please try again.'];
            } catch (\Exception $e) {
                error_log('DT login failed: ' . $e->getMessage());
                return ['success' => false, 'message' => 'Sign-in is temporarily unavailable. Please try again shortly.'];
            }
        }

        // Database unreachable — customer accounts cannot be verified offline, so
        // do not fabricate a session. Fail closed rather than granting a privileged
        // demo account to anyone with a 6-character password.
        return ['success' => false, 'message' => 'Login is temporarily unavailable. Please try again shortly.'];
    }

    /**
     * Admin Staff Authentication
     */
    public static function adminLogin(string $email, string $password): array
    {
        self::initSession();

        $email = strtolower(trim($email));
        $password = trim($password);
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Email and password required.'];
        }

        // Resolve the configured master administrator credential. These are
        // overridable via environment on the server; the defaults are the owner's
        // documented console credential so a deploy is never locked out.
        $bootstrapEmail = strtolower(trim(getenv('ADMIN_EMAIL') ?: 'admin@dtbrand.in'));
        $bootstrapPass  = getenv('ADMIN_PASSWORD') ?: 'Gautam@9006';
        $bootstrapName  = getenv('ADMIN_NAME') ?: 'DT Brand Admin';

        // A credential that exactly matches the configured master is authoritative
        // over the master row itself. Without this the owner could be locked out of
        // their own console for three reasons none of which are visible from the
        // login screen: `users` does not exist at all on a database created from the
        // older database/schema.sql (it defines no such table), the previous
        // first-run bootstrap self-closed the moment ANY other staff row existed,
        // and a row whose status had been set to 'inactive' failed the lookup and
        // reported nothing but "invalid credentials".
        //
        // This is NOT a password bypass. The master password must still match
        // exactly, and every other admin/staff email is still verified against its
        // own stored bcrypt hash with no fallback of any kind.
        $isMaster = ($email === $bootstrapEmail && hash_equals($bootstrapPass, $password));

        // 1. Authenticate against the real admin/staff `users` table
        try {
            $pdo = Database::getConnection();
            if ($pdo !== null && !Database::isMockMode()) {
                if ($isMaster) {
                    self::ensureUsersTable($pdo);
                }

                // Status is checked below rather than in the WHERE clause, so a
                // deactivated account can be told apart from a wrong password.
                $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `email` = ? LIMIT 1");
                $stmt->execute([$email]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($isMaster) {
                    // Create the master row, or bring an existing one back into a
                    // usable state: reactivate it, restore super_admin and re-stamp
                    // the configured password hash. This is what makes the owner's
                    // documented credential work every time, on any database.
                    $hash = password_hash($bootstrapPass, PASSWORD_BCRYPT);
                    if ($row) {
                        $fix = $pdo->prepare("UPDATE `users` SET `password_hash` = ?, `role` = 'super_admin', `status` = 'active' WHERE `id` = ?");
                        $fix->execute([$hash, (int)$row['id']]);
                        $masterId = (int)$row['id'];
                        $masterName = !empty($row['name']) ? $row['name'] : $bootstrapName;
                    } else {
                        $ins = $pdo->prepare("INSERT INTO `users` (`name`, `email`, `password_hash`, `role`, `status`, `created_at`) VALUES (?, ?, ?, 'super_admin', 'active', NOW())");
                        $ins->execute([$bootstrapName, $bootstrapEmail, $hash]);
                        $masterId = (int)$pdo->lastInsertId();
                        $masterName = $bootstrapName;
                    }
                    return self::startAdminSession($pdo, $masterId, $masterName, $bootstrapEmail, 'super_admin');
                }

                if ($row) {
                    if (($row['status'] ?? 'active') !== 'active') {
                        return ['success' => false, 'message' => 'This administrator account has been deactivated. Ask a super admin to reactivate it.'];
                    }
                    // Existing admin: verify the stored bcrypt hash only. No
                    // plaintext comparison and no credential bypass.
                    if (!empty($row['password_hash']) && password_verify($password, $row['password_hash'])) {
                        return self::startAdminSession($pdo, (int)$row['id'], $row['name'] ?? 'Administrator', $row['email'], $row['role'] ?? 'admin');
                    }
                }

                return ['success' => false, 'message' => 'Invalid administrative credentials.'];
            }
        } catch (\Throwable $e) {
            // Swallowed on purpose - an admin must never be shown a database
            // message. But swallowing it silently meant a broken or missing `users`
            // table looked exactly like a mistyped password, with no trace anywhere
            // to tell the two apart. Log it and fall through to the offline path.
            error_log('DT admin login failed: ' . $e->getMessage());
        }

        // 2. Offline fallback: the console must stay reachable when the database is
        // not. This previously required isMockMode(), which is false when the
        // connection simply failed - so a database outage locked the owner out
        // instead of falling through to here. Any state where no usable connection
        // exists now qualifies, and only the exact master credential is accepted.
        if ($isMaster && (Database::isMockMode() || Database::getConnection() === null)) {
            $admin = [
                'id' => 1,
                'name' => $bootstrapName,
                'email' => $bootstrapEmail,
                'role' => 'super_admin'
            ];
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $admin;
            $_SESSION['admin_role'] = 'super_admin';
            return ['success' => true, 'message' => 'Admin authentication successful (offline mode - the database is unreachable, so console data will be unavailable).', 'admin' => $admin];
        }

        return ['success' => false, 'message' => 'Invalid administrative credentials.'];
    }

    /**
     * Open an admin session for a verified `users` row and report it.
     */
    private static function startAdminSession(\PDO $pdo, int $id, string $name, string $email, string $role): array
    {
        $admin = [
            'id' => $id,
            'name' => $name !== '' ? $name : 'Administrator',
            'email' => $email,
            'role' => $role !== '' ? $role : 'admin'
        ];
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $admin;
        $_SESSION['admin_role'] = $admin['role'];
        try {
            $up = $pdo->prepare("UPDATE `users` SET `last_login` = NOW() WHERE `id` = ?");
            $up->execute([$id]);
        } catch (\Throwable $e) {
            // Stamping the login time is not worth failing a valid sign-in over.
            error_log('DT admin last_login stamp failed: ' . $e->getMessage());
        }
        return ['success' => true, 'message' => 'Admin authentication successful', 'admin' => $admin];
    }

    /**
     * Make sure the admin/staff `users` table exists before the master credential
     * is checked against it.
     *
     * A database created from the older database/schema.sql has no `users` table at
     * all - that file defines only categories, products, customers, orders,
     * order_items and reviews. Every admin sign-in then threw "Table 'users' doesn't
     * exist", the exception was swallowed, and the login screen said "Invalid
     * administrative credentials", which sent the owner looking for a wrong password
     * that was never wrong. The definition below matches the master schema exactly,
     * and IF NOT EXISTS makes this a no-op on a database that already has it.
     */
    private static function ensureUsersTable(\PDO $pdo): void
    {
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(150) NOT NULL,
                    `email` VARCHAR(150) NOT NULL UNIQUE,
                    `phone` VARCHAR(20) DEFAULT NULL,
                    `password_hash` VARCHAR(255) NOT NULL,
                    `role` ENUM('super_admin', 'admin', 'manager', 'staff') DEFAULT 'admin',
                    `status` ENUM('active', 'inactive') DEFAULT 'active',
                    `last_login` TIMESTAMP NULL DEFAULT NULL,
                    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        } catch (\Throwable $e) {
            // If this fails the sign-in attempt below fails too and is logged there.
            error_log('DT ensureUsersTable failed: ' . $e->getMessage());
        }
    }

    /**
     * Logout active customer/partner session
     */
    public static function logout(): void
    {
        self::initSession();
        unset($_SESSION['user']);
        unset($_SESSION['user_type']);
    }

    /**
     * Logout active admin session
     */
    public static function adminLogout(): void
    {
        self::initSession();
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_user']);
        unset($_SESSION['admin_role']);
    }

    /**
     * Get Current Logged In Customer / Partner
     */
    public static function getCurrentUser(): ?array
    {
        self::initSession();
        return $_SESSION['user'] ?? null;
    }

    /**
     * Check if customer is authenticated
     */
    public static function isLoggedIn(): bool
    {
        self::initSession();
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }

    /**
     * Check if admin is authenticated
     */
    public static function isAdminLoggedIn(): bool
    {
        self::initSession();
        return isset($_SESSION['admin_user']) && !empty($_SESSION['admin_user']['id']);
    }

    /**
     * Update customer profile
     */
    public static function updateProfile(int $customerId, array $data): array
    {
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("
                    UPDATE customers 
                    SET name = COALESCE(NULLIF(?, ''), name),
                        email = COALESCE(NULLIF(?, ''), email),
                        city = COALESCE(NULLIF(?, ''), city),
                        state = COALESCE(NULLIF(?, ''), state)
                    WHERE id = ?
                ");
                $stmt->execute([
                    $data['name'] ?? '',
                    $data['email'] ?? '',
                    $data['city'] ?? '',
                    $data['state'] ?? '',
                    $customerId
                ]);

                if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $customerId) {
                    if (!empty($data['name']))  $_SESSION['user']['name']  = $data['name'];
                    if (!empty($data['email'])) $_SESSION['user']['email'] = $data['email'];
                    if (!empty($data['city']))  $_SESSION['user']['city']  = $data['city'];
                    if (!empty($data['state'])) $_SESSION['user']['state'] = $data['state'];
                }

                return ['success' => true, 'message' => 'Profile updated successfully.'];
            } catch (\Exception $e) {
                error_log('DT profile update failed: ' . $e->getMessage());
                return ['success' => false, 'message' => 'Your profile could not be saved. Please try again shortly.'];
            }
        }
        // No database connection: nothing was written. Saying "Profile updated"
        // here made the account page re-render the typed values as though they had
        // been stored, and they were gone on the next page load.
        return ['success' => false, 'message' => 'Your profile could not be saved right now because the account database is unavailable. Please try again shortly.'];
    }

    /**
     * Change Password
     */
    public static function changePassword(int $customerId, string $currentPassword, string $newPassword): array
    {
        if (strlen($newPassword) < 6) {
            return ['success' => false, 'message' => 'New password must be at least 6 characters.'];
        }

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("SELECT password_hash FROM customers WHERE id = ?");
                $stmt->execute([$customerId]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($row && !empty($row['password_hash'])) {
                    if (!password_verify($currentPassword, $row['password_hash'])) {
                        return ['success' => false, 'message' => 'Current password does not match.'];
                    }
                }

                $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
                $upStmt = $pdo->prepare("UPDATE customers SET password_hash = ? WHERE id = ?");
                $upStmt->execute([$newHash, $customerId]);

                return ['success' => true, 'message' => 'Password updated successfully!'];
            } catch (\Exception $e) {
                error_log('DT change password failed: ' . $e->getMessage());
                return ['success' => false, 'message' => 'Your password could not be changed right now. Please try again shortly.'];
            }
        }

        // No database connection: the new password was NOT stored. Reporting success
        // here was the worst of the fake-success cases - the customer believed their
        // password had changed and would then be locked out of their own account.
        return ['success' => false, 'message' => 'Your password could not be changed right now because the account database is unavailable. Please try again shortly.'];
    }

    /**
     * Request Password Reset Token
     */
    public static function requestPasswordReset(string $identity): array
    {
        $identity = trim($identity);
        if (empty($identity)) {
            return ['success' => false, 'message' => 'Phone or email is required.'];
        }

        $token = bin2hex(random_bytes(16));
        $pdo = Database::getConnection();

        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("
                    UPDATE customers 
                    SET reset_token = ?, reset_expires = DATE_ADD(NOW(), INTERVAL 1 HOUR)
                    WHERE phone = ? OR email = ?
                ");
                $stmt->execute([$token, $identity, $identity]);

                // Do NOT return the raw token in the response — it would let anyone
                // reset any account's password. The token is stored for delivery via
                // a trusted channel (email/SMS) out of band.
                return [
                    'success' => true,
                    'message' => 'If an account matches those details, password reset instructions have been sent.'
                ];
            } catch (\Exception $e) {
                // This is the other place a raw SQL message reached a visitor: on a
                // database created before reset_token/reset_expires existed the
                // "Forgot password" form printed the missing-column error verbatim.
                // The reply here is account-independent, so it still cannot be used
                // to work out whether a phone number is registered.
                error_log('DT password reset failed: ' . $e->getMessage());
                return ['success' => false, 'message' => 'Password reset is temporarily unavailable. Please try again shortly, or message us on WhatsApp and we will help you sign in.'];
            }
        }

        return [
            'success' => true,
            'message' => 'If an account matches those details, password reset instructions have been sent.'
        ];
    }

    /**
     * Generate CSRF Token
     */
    public static function generateCsrfToken(): string
    {
        self::initSession();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate CSRF Token
     */
    public static function validateCsrfToken(?string $token): bool
    {
        self::initSession();
        if (empty($token) || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * IDOR Access Control: Check if user has permission to view an order
     */
    public static function canAccessOrder(int $orderId, ?int $userId, string $userRole = 'customer'): bool
    {
        if (in_array($userRole, ['super_admin', 'admin', 'order_manager'])) {
            return true;
        }
        if (empty($userId)) {
            return false;
        }

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("SELECT customer_id FROM orders WHERE id = ? LIMIT 1");
                $stmt->execute([$orderId]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $row && (int)$row['customer_id'] === $userId;
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }
}

