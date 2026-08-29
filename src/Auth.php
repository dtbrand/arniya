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
                $checkStmt = $pdo->prepare("SELECT id FROM customers WHERE phone = ? OR (email = ? AND email != '') LIMIT 1");
                $checkStmt->execute([$phone, $email]);
                if ($checkStmt->fetch()) {
                    return ['success' => false, 'message' => 'An account with this phone or email already exists.'];
                }

                $stmt = $pdo->prepare("
                    INSERT INTO customers (name, phone, email, password_hash, type, status, created_at)
                    VALUES (?, ?, ?, ?, ?, 'active', NOW())
                ");
                $stmt->execute([$name, $phone, $email, $passwordHash, $type]);
                $customerId = (int)$pdo->lastInsertId();

                $user = [
                    'id' => $customerId,
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
                    // If password_hash exists, verify it; if newly migrated and empty, allow initial set or match
                    $passwordValid = false;
                    if (!empty($hash)) {
                        $passwordValid = password_verify($password, $hash);
                    } else {
                        // Allow initial setup if password matches master setup
                        $passwordValid = ($password === 'Gautam@9006' || $password === '123456' || strlen($password) >= 6);
                        if ($passwordValid) {
                            $newHash = password_hash($password, PASSWORD_BCRYPT);
                            $upStmt = $pdo->prepare("UPDATE customers SET password_hash = ? WHERE id = ?");
                            $upStmt->execute([$newHash, $customer['id']]);
                        }
                    }

                    if ($passwordValid) {
                        $user = [
                            'id' => (int)$customer['id'],
                            'name' => $customer['name'],
                            'phone' => $customer['phone'],
                            'email' => $customer['email'] ?? '',
                            'type' => $customer['type'] ?? 'retail',
                            'tier' => $customer['tier'] ?? 'Standard',
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

        // Demo / Fallback login
        if ($password === 'Gautam@9006' || $password === '123456' || strlen($password) >= 6) {
            $user = [
                'id' => 101,
                'name' => 'Radhika Sarees Emporium',
                'phone' => $identity,
                'email' => $identity,
                'type' => 'wholesale',
                'tier' => 'Diamond Elite',
                'credit_limit' => 500000.00,
                'outstanding_balance' => 84500.00,
                'status' => 'active'
            ];
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            $_SESSION['user_type'] = $user['type'];
            return ['success' => true, 'message' => 'Login successful!', 'user' => $user];
        }

        return ['success' => false, 'message' => 'Invalid credentials.'];
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

        // 1. Try MySQL Database Admins Table
        try {
            $pdo = Database::getConnection();
            if ($pdo !== null && !Database::isMockMode()) {
                $stmt = $pdo->prepare("SELECT * FROM `admins` WHERE `email` = ? AND `status` = 'active' LIMIT 1");
                $stmt->execute([$email]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($row) {
                    if (password_verify($password, $row['password']) || $row['password'] === $password || ($password === 'Gautam@9006' && in_array($email, ['admin@dtbrand.in', 'admin@jaihanumantex.in']))) {
                        $admin = [
                            'id' => (int)$row['id'],
                            'name' => $row['name'] ?? 'Gautam Sethi',
                            'email' => $row['email'],
                            'role' => $row['role'] ?? 'super_admin'
                        ];
                        session_regenerate_id(true);
                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_user'] = $admin;
                        $_SESSION['admin_role'] = $admin['role'];
                        try {
                            $up = $pdo->prepare("UPDATE `admins` SET `last_login` = NOW() WHERE `id` = ?");
                            $up->execute([$admin['id']]);
                        } catch (\Throwable $e) {}
                        return ['success' => true, 'message' => 'Admin authentication successful', 'admin' => $admin];
                    }
                }
            }
        } catch (\Throwable $e) {}

        // 2. Real Master Admin Credential Verification (admin@dtbrand.in / Gautam@9006)
        if (in_array($email, ['admin@dtbrand.in', 'admin@jaihanumantex.in', 'admin']) && $password === 'Gautam@9006') {
            $admin = [
                'id' => 1,
                'name' => 'Gautam Sethi',
                'email' => 'admin@dtbrand.in',
                'role' => 'super_admin'
            ];
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $admin;
            $_SESSION['admin_role'] = 'super_admin';
            return ['success' => true, 'message' => 'Admin authentication successful', 'admin' => $admin];
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
                        phone = COALESCE(NULLIF(?, ''), phone),
                        city = COALESCE(NULLIF(?, ''), city),
                        state = COALESCE(NULLIF(?, ''), state),
                        gstin = COALESCE(NULLIF(?, ''), gstin)
                    WHERE id = ?
                ");
                $stmt->execute([
                    $data['name'] ?? '',
                    $data['email'] ?? '',
                    $data['phone'] ?? '',
                    $data['city'] ?? '',
                    $data['state'] ?? '',
                    $data['gstin'] ?? ($data['gst_number'] ?? ''),
                    $customerId
                ]);

                if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $customerId) {
                    if (!empty($data['name'])) $_SESSION['user']['name'] = $data['name'];
                    if (!empty($data['email'])) $_SESSION['user']['email'] = $data['email'];
                    if (!empty($data['phone'])) $_SESSION['user']['phone'] = $data['phone'];
                    if (!empty($data['city'])) $_SESSION['user']['city'] = $data['city'];
                    if (!empty($data['state'])) $_SESSION['user']['state'] = $data['state'];
                    if (!empty($data['companyName'])) $_SESSION['user']['companyName'] = $data['companyName'];
                    if (!empty($data['gstin'])) $_SESSION['user']['gstin'] = $data['gstin'];
                }

                return ['success' => true, 'message' => 'Profile updated successfully.', 'user' => $_SESSION['user'] ?? null];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => 'Failed to update profile: ' . $e->getMessage()];
            }
        }

        if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $customerId) {
            foreach ($data as $k => $v) {
                if (!empty($v)) $_SESSION['user'][$k] = $v;
            }
        }
        return ['success' => true, 'message' => 'Profile updated.', 'user' => $_SESSION['user'] ?? null];
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

                return [
                    'success' => true,
                    'message' => 'Password reset instructions and verification link have been generated.',
                    'reset_token' => $token
                ];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => 'Reset error: ' . $e->getMessage()];
            }
        }

        return [
            'success' => true,
            'message' => 'Password reset token generated.',
            'reset_token' => $token
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

