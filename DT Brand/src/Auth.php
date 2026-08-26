<?php

namespace DTBrand;

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
        $type = in_array($data['type'] ?? '', ['retail', 'wholesale', 'reseller']) ? $data['type'] : 'retail';
        $city = trim($data['city'] ?? '');
        $state = trim($data['state'] ?? '');

        if (empty($name) || empty($phone) || empty($password)) {
            return ['success' => false, 'message' => 'Name, phone number, and password are required.'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Password must be at least 6 characters.'];
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $pdo = Database::getConnection();

        if ($pdo !== null && !Database::isMockMode()) {
            try {
                // Check if phone or email already registered
                $checkStmt = $pdo->prepare("SELECT id, password_hash FROM customers WHERE phone = ? OR (email = ? AND email != '') LIMIT 1");
                $checkStmt->execute([$phone, $email]);
                $existing = $checkStmt->fetch(\PDO::FETCH_ASSOC);

                if ($existing) {
                    // A row that already has a password belongs to a registered
                    // customer — never allow it to be silently taken over.
                    if (!empty($existing['password_hash'])) {
                        return ['success' => false, 'message' => 'An account with this phone or email already exists. Please sign in instead.'];
                    }
                    // Password-less row (e.g. created during guest checkout): let the
                    // owner claim it by setting their password and details now.
                    $customerId = (int)$existing['id'];
                    $upd = $pdo->prepare("UPDATE customers SET name = ?, email = COALESCE(NULLIF(?, ''), email), password_hash = ?, type = ?, city = COALESCE(NULLIF(?, ''), city), state = COALESCE(NULLIF(?, ''), state) WHERE id = ?");
                    $upd->execute([$name, $email, $passwordHash, $type, $city, $state, $customerId]);
                } else {
                    $stmt = $pdo->prepare("
                        INSERT INTO customers (name, phone, email, password_hash, type, city, state, status, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())
                    ");
                    $stmt->execute([$name, $phone, $email, $passwordHash, $type, $city, $state]);
                    $customerId = (int)$pdo->lastInsertId();
                }

                $user = [
                    'id' => $customerId,
                    'name' => $name,
                    'phone' => $phone,
                    'email' => $email,
                    'type' => $type,
                    'tier' => 'Standard',
                    'city' => $city,
                    'state' => $state,
                    'status' => 'active'
                ];

                session_regenerate_id(true);
                $_SESSION['user'] = $user;
                $_SESSION['user_type'] = $type;

                return ['success' => true, 'message' => 'Registration successful! Welcome to DT Brand\'s.', 'user' => $user];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
            }
        }

        // Fallback session registration
        $user = [
            'id' => 999,
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'type' => $type,
            'tier' => 'Standard',
            'status' => 'active'
        ];
        session_regenerate_id(true);
        $_SESSION['user'] = $user;
        $_SESSION['user_type'] = $type;

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
                $stmt = $pdo->prepare("
                    SELECT * FROM customers 
                    WHERE (phone = ? OR email = ?) AND status = 'active' 
                    LIMIT 1
                ");
                $stmt->execute([$identity, $identity]);
                $customer = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($customer) {
                    $hash = $customer['password_hash'] ?? '';
                    // Only accept a login when a real bcrypt hash is present and
                    // verifies. Accounts with no password set (e.g. created during
                    // guest checkout or admin import) cannot be logged into until a
                    // password is created via registration — no "any password" bypass.
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
                            'type' => $customer['type'] ?? 'retail',
                            'tier' => $customer['tier'] ?? 'Standard',
                            'city' => $customer['city'] ?? '',
                            'state' => $customer['state'] ?? '',
                            'gstin' => $customer['gstin'] ?? '',
                            'credit_limit' => (float)($customer['credit_limit'] ?? 0),
                            'outstanding_balance' => (float)($customer['outstanding_balance'] ?? 0),
                            'status' => $customer['status']
                        ];

                        session_regenerate_id(true);
                        $_SESSION['user'] = $user;
                        $_SESSION['user_type'] = $user['type'];

                        // Update last_login
                        try {
                            $pdo->prepare("UPDATE customers SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);
                        } catch (\Exception $ex) {
                            // Column may not exist yet
                        }

                        return ['success' => true, 'message' => 'Login successful! Welcome back, ' . htmlspecialchars($user['name']) . '.', 'user' => $user];
                    }
                }

                return ['success' => false, 'message' => 'Invalid phone/email or password. Please try again.'];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => 'Authentication error: ' . $e->getMessage()];
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

        // Resolve the configured master/bootstrap administrator credential. These
        // are overridable via environment on the server; the defaults preserve the
        // owner's existing credential so a fresh deploy is never locked out. The
        // bootstrap only functions while NO admin exists yet — it self-closes the
        // moment the first `users` row is created (here or by the migration seed).
        $bootstrapEmail = strtolower(trim(getenv('ADMIN_EMAIL') ?: 'admin@dtbrand.in'));
        $bootstrapPass  = getenv('ADMIN_PASSWORD') ?: 'Gautam@9006';
        $bootstrapName  = getenv('ADMIN_NAME') ?: 'DT Brand Admin';

        // 1. Authenticate against the real admin/staff `users` table
        try {
            $pdo = Database::getConnection();
            if ($pdo !== null && !Database::isMockMode()) {
                $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `email` = ? AND `status` = 'active' LIMIT 1");
                $stmt->execute([$email]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($row) {
                    // Existing admin: verify the stored bcrypt hash only. No
                    // plaintext comparison and no credential bypass.
                    if (!empty($row['password_hash']) && password_verify($password, $row['password_hash'])) {
                        $admin = [
                            'id' => (int)$row['id'],
                            'name' => $row['name'] ?? 'Administrator',
                            'email' => $row['email'],
                            'role' => $row['role'] ?? 'admin'
                        ];
                        session_regenerate_id(true);
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_user'] = $admin;
                        $_SESSION['admin_role'] = $admin['role'];
                        try {
                            $up = $pdo->prepare("UPDATE `users` SET `last_login` = NOW() WHERE `id` = ?");
                            $up->execute([$admin['id']]);
                        } catch (\Throwable $e) {}
                        return ['success' => true, 'message' => 'Admin authentication successful', 'admin' => $admin];
                    }

                    // A matching admin exists but the password is wrong — reject.
                    return ['success' => false, 'message' => 'Invalid administrative credentials.'];
                }

                // First-run bootstrap: only when the users table has no admin yet,
                // allow the configured master credential to create the first
                // super-admin. This path is dead as soon as one admin exists.
                $adminCount = (int)$pdo->query("SELECT COUNT(*) FROM `users`")->fetchColumn();
                if ($adminCount === 0 && $email === $bootstrapEmail && $password === $bootstrapPass) {
                    $hash = password_hash($bootstrapPass, PASSWORD_BCRYPT);
                    $ins = $pdo->prepare("INSERT INTO `users` (`name`, `email`, `password_hash`, `role`, `status`, `created_at`) VALUES (?, ?, ?, 'super_admin', 'active', NOW())");
                    $ins->execute([$bootstrapName, $bootstrapEmail, $hash]);
                    $admin = [
                        'id' => (int)$pdo->lastInsertId(),
                        'name' => $bootstrapName,
                        'email' => $bootstrapEmail,
                        'role' => 'super_admin'
                    ];
                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_user'] = $admin;
                    $_SESSION['admin_role'] = 'super_admin';
                    return ['success' => true, 'message' => 'Admin account initialised. Please change this password immediately.', 'admin' => $admin];
                }

                return ['success' => false, 'message' => 'Invalid administrative credentials.'];
            }
        } catch (\Throwable $e) {}

        // 2. Offline fallback (database unreachable): accept ONLY the configured
        // master credential so the console remains reachable during an outage.
        if (Database::isMockMode() && $email === $bootstrapEmail && $password === $bootstrapPass) {
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
            return ['success' => true, 'message' => 'Admin authentication successful (offline mode).', 'admin' => $admin];
        }

        return ['success' => false, 'message' => 'Invalid administrative credentials.'];
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
                return ['success' => false, 'message' => 'Failed to update profile: ' . $e->getMessage()];
            }
        }
        return ['success' => true, 'message' => 'Profile updated.'];
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
                return ['success' => false, 'message' => 'Error changing password: ' . $e->getMessage()];
            }
        }

        return ['success' => true, 'message' => 'Password updated.'];
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
                return ['success' => false, 'message' => 'Reset error: ' . $e->getMessage()];
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

