<?php
/**
 * adminlogin.php — Luxury Executive Admin Login & Recovery Portal
 * DT Brand's & Jai Hanuman Tex
 */
session_start();

// Handle Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['admin_logged_in']);
    unset($_SESSION['admin_user']);
    session_destroy();
    header("Location: /DT%20Brand/admin/adminlogin.php?logged_out=1");
    exit;
}

// If already logged in, redirect to Admin Dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: /DT%20Brand/admin/admin.php");
    exit;
}

$error = '';
$success = '';

if (isset($_GET['logged_out'])) {
    $success = 'You have successfully signed out of the Admin Console.';
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Default valid admin credentials
    if (($email === 'admin@jaihanumantex.in' || $email === 'gautam@jaihanumantex.in' || $email === 'admin') && ($password === 'admin123' || $password === 'Gautam@9006' || $password === 'admin')) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = [
            'name' => 'Gautam Sethi',
            'email' => $email,
            'role' => 'Super Admin'
        ];
        header("Location: /DT%20Brand/admin/admin.php");
        exit;
    } else {
        $error = 'Invalid email or password. Please verify your credentials or reset your password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Sign In — DT Brand's Executive Portal</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --adm-gold: #8A681F;
            --adm-gold-deep: #5A4210;
            --adm-gold-bright: #C5A859;
            --adm-gold-light: #D4AF37;
            --adm-gold-pale: #FAF5E8;
            --adm-gold-border: rgba(138, 104, 31, 0.35);
            --adm-gold-glow: rgba(212, 175, 55, 0.22);
            --adm-dark-900: #100E0C;
            --adm-dark-800: #171411;
            --adm-dark-700: #221E19;
            --adm-text-main: #181512;
            --adm-text-body: #3B352E;
            --adm-text-muted: #7A7266;
            --adm-bg-canvas: #F8F6F0;
            --adm-border-soft: #E5E1D7;
            --adm-success: #15803D;
            --adm-danger: #B91C1C;
            --adm-font-serif: 'Cinzel', Georgia, serif;
            --adm-font-sans: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --adm-transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(145deg, #FAF8F4 0%, #F1EDE4 50%, #E8E3D8 100%);
            font-family: var(--adm-font-sans);
            color: var(--adm-text-main);
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle Luxury Pattern Background */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 380px;
            background: radial-gradient(ellipse at 50% -20%, rgba(138, 104, 31, 0.15) 0%, rgba(248, 246, 240, 0) 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* Top Header Nav */
        .adm-login-header {
            position: relative;
            z-index: 10;
            padding: clamp(12px, 2.5vw, 18px) clamp(16px, 4vw, 40px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1.5px solid rgba(138, 104, 31, 0.2);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
        }

        .adm-login-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .adm-login-logo {
            height: 38px;
            width: auto;
            max-width: 140px;
            object-fit: contain;
        }

        .adm-login-brand-text {
            display: flex;
            flex-direction: column;
        }

        .adm-login-brand-title {
            font-family: var(--adm-font-serif);
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--adm-gold-deep);
            letter-spacing: 0.06em;
            line-height: 1.1;
        }

        .adm-login-brand-sub {
            font-size: 0.64rem;
            font-weight: 700;
            color: var(--adm-gold);
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .adm-return-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            border: 1.4px solid var(--adm-gold);
            background: #FFFFFF;
            color: var(--adm-gold-deep);
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            transition: var(--adm-transition);
        }

        .adm-return-btn:hover {
            background: var(--adm-gold);
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(138, 104, 31, 0.2);
        }

        /* Main Login Wrapper */
        .adm-login-container {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(20px, 4vw, 40px) 16px;
        }

        /* Login Card */
        .adm-login-card {
            width: 100%;
            max-width: 460px;
            background: #FFFFFF;
            border-radius: 20px;
            border: 2px solid var(--adm-gold-border);
            box-shadow: 0 16px 48px rgba(138, 104, 31, 0.12), 0 4px 16px rgba(0, 0, 0, 0.05);
            padding: clamp(24px, 5vw, 36px);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .adm-login-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--adm-gold) 0%, var(--adm-gold-bright) 50%, var(--adm-gold) 100%);
        }

        /* Card Head */
        .adm-card-header {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .adm-seal-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--adm-gold) 0%, var(--adm-gold-deep) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            box-shadow: 0 6px 18px rgba(138, 104, 31, 0.3);
            margin-bottom: 4px;
        }

        .adm-card-title {
            font-family: var(--adm-font-serif);
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--adm-text-main);
            letter-spacing: 0.02em;
        }

        .adm-card-desc {
            font-size: 0.82rem;
            color: var(--adm-text-muted);
            line-height: 1.4;
            max-width: 340px;
        }

        /* Alerts */
        .adm-alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .adm-alert.danger {
            background: #FEE2E2;
            color: var(--adm-danger);
            border: 1.2px solid rgba(185, 28, 28, 0.25);
        }

        .adm-alert.success {
            background: #DCFCE7;
            color: var(--adm-success);
            border: 1.2px solid rgba(21, 128, 61, 0.25);
        }

        /* Form */
        .adm-login-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .adm-field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .adm-field-label {
            font-size: 0.76rem;
            font-weight: 800;
            color: var(--adm-text-main);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .adm-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .adm-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: var(--adm-gold);
            width: 18px;
            height: 18px;
        }

        .adm-form-input {
            width: 100%;
            padding: 12px 42px 12px 44px; /* Left padding for icon, right for toggle */
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--adm-text-main);
            background: var(--adm-bg-canvas);
            border: 1.5px solid var(--adm-border-soft);
            border-radius: 10px;
            transition: var(--adm-transition);
        }

        .adm-form-input:focus {
            background: #FFFFFF;
            border-color: var(--adm-gold);
            box-shadow: 0 0 0 4px var(--adm-gold-glow);
            outline: none;
        }

        .adm-pwd-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--adm-text-muted);
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .adm-pwd-toggle:hover {
            color: var(--adm-gold);
        }

        /* Remember & Forgot Row */
        .adm-options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
        }

        .adm-remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--adm-text-body);
            font-weight: 600;
            cursor: pointer;
            user-select: none;
        }

        .adm-remember-checkbox {
            accent-color: var(--adm-gold);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .adm-forgot-link {
            color: var(--adm-gold-deep);
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: var(--adm-transition);
        }

        .adm-forgot-link:hover {
            color: var(--adm-gold);
            text-decoration: underline;
        }

        /* Sign In Button */
        .adm-submit-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--adm-gold) 0%, var(--adm-gold-deep) 100%);
            color: #FFFFFF;
            font-size: 0.92rem;
            font-weight: 800;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(138, 104, 31, 0.3);
            transition: var(--adm-transition);
            margin-top: 4px;
        }

        .adm-submit-btn:hover {
            background: linear-gradient(135deg, var(--adm-gold-bright) 0%, var(--adm-gold) 100%);
            box-shadow: 0 6px 22px rgba(138, 104, 31, 0.42);
            transform: translateY(-2px);
        }

        .adm-submit-btn:active {
            transform: translateY(0);
        }

        /* Demo Credentials Pill */
        .adm-demo-box {
            padding: 10px 12px;
            background: var(--adm-gold-pale);
            border: 1.2px dashed rgba(138, 104, 31, 0.4);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            font-size: 0.76rem;
        }

        .adm-demo-info {
            display: flex;
            flex-direction: column;
            color: var(--adm-gold-deep);
            line-height: 1.3;
        }

        .adm-demo-btn {
            padding: 4px 10px;
            background: var(--adm-gold);
            color: #FFFFFF;
            font-size: 0.72rem;
            font-weight: 800;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: var(--adm-transition);
        }

        .adm-demo-btn:hover {
            background: var(--adm-gold-deep);
        }

        /* Security Badges Footer */
        .adm-security-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            font-size: 0.72rem;
            color: var(--adm-text-muted);
            border-top: 1px solid var(--adm-border-soft);
            padding-top: 14px;
        }

        .adm-sec-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ════ FORGOT PASSWORD MODAL ════ */
        .adm-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(16, 14, 12, 0.7);
            backdrop-filter: blur(5px);
            z-index: 999;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
            animation: admFade 0.2s ease;
        }

        .adm-modal-backdrop.open {
            display: flex;
        }

        @keyframes admFade {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        .adm-modal-box {
            width: 100%;
            max-width: 440px;
            background: #FFFFFF;
            border-radius: 16px;
            border: 2px solid var(--adm-gold-border);
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.25);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
        }

        .adm-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .adm-modal-title {
            font-family: var(--adm-font-serif);
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--adm-gold-deep);
        }

        .adm-modal-close {
            background: none;
            border: none;
            font-size: 1.1rem;
            color: var(--adm-text-muted);
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .adm-modal-close:hover {
            background: #FEE2E2;
            color: var(--adm-danger);
        }
    </style>
</head>
<body>

    <!-- ══ Header ══ -->
    <header class="adm-login-header">
        <a href="/" class="adm-login-brand">
            <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" class="adm-login-logo">
            <div class="adm-login-brand-text">
                <span class="adm-login-brand-title">DT Brand's</span>
                <span class="adm-login-brand-sub">Enterprise CRM</span>
            </div>
        </a>
        <a href="/shop" class="adm-return-btn">
            <span>← Return to Shop</span>
        </a>
    </header>

    <!-- ══ Main Login Form ══ -->
    <main class="adm-login-container">
        <div class="adm-login-card">
            
            <!-- Card Head -->
            <div class="adm-card-header">
                <div class="adm-seal-icon">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2.2" fill="none"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </div>
                <h1 class="adm-card-title">Admin Sign In</h1>
                <p class="adm-card-desc">Enter your executive credentials to access the DT Brand's CRM and catalog control center.</p>
            </div>

            <!-- Error or Success Alert -->
            <?php if (!empty($error)): ?>
                <div class="adm-alert danger">
                    <span>⚠️</span>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="adm-alert success">
                    <span>✓</span>
                    <span><?php echo htmlspecialchars($success); ?></span>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form action="/DT%20Brand/admin/adminlogin.php" method="POST" class="adm-login-form">
                
                <!-- Email Field -->
                <div class="adm-field-group">
                    <label class="adm-field-label" for="adminEmail">Admin Email / Username</label>
                    <div class="adm-input-wrapper">
                        <svg class="adm-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <input type="text" id="adminEmail" name="email" class="adm-form-input" placeholder="admin@jaihanumantex.in" value="<?php echo htmlspecialchars($_POST['email'] ?? 'admin@jaihanumantex.in'); ?>" required autofocus>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="adm-field-group">
                    <label class="adm-field-label" for="adminPassword">Password</label>
                    <div class="adm-input-wrapper">
                        <svg class="adm-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <input type="password" id="adminPassword" name="password" class="adm-form-input" placeholder="••••••••••••" value="admin123" required>
                        <button type="button" class="adm-pwd-toggle" id="admPwdToggleBtn" title="Toggle password visibility" onclick="togglePasswordVisibility()">
                            <svg id="eyeIcon" viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password Options Row -->
                <div class="adm-options-row">
                    <label class="adm-remember-label">
                        <input type="checkbox" name="remember" class="adm-remember-checkbox" checked>
                        <span>Remember session</span>
                    </label>
                    <!-- FORGOT PASSWORD LINK -->
                    <a href="javascript:void(0)" class="adm-forgot-link" onclick="openForgotModal()">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="adm-submit-btn">
                    <span>Sign In to Admin Portal</span>
                    <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.5" fill="none"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
            </form>

            <!-- Quick Auto-Fill Demo Credentials -->
            <div class="adm-demo-box">
                <div class="adm-demo-info">
                    <strong>Demo Access:</strong>
                    <span><code>admin@jaihanumantex.in</code> / <code>admin123</code></span>
                </div>
                <button type="button" class="adm-demo-btn" onclick="fillDemoCredentials()">Auto-Fill</button>
            </div>

            <!-- Security Footer -->
            <div class="adm-security-footer">
                <div class="adm-sec-item">
                    <span>🛡️</span>
                    <span>256-bit SSL</span>
                </div>
                <div class="adm-sec-item">
                    <span>🔒</span>
                    <span>Session Guard</span>
                </div>
                <div class="adm-sec-item">
                    <span>📱</span>
                    <span>WhatsApp 2FA</span>
                </div>
            </div>

        </div>
    </main>

    <!-- ════ FORGOT PASSWORD MODAL ════ -->
    <div class="adm-modal-backdrop" id="admForgotModal">
        <div class="adm-modal-box">
            <div class="adm-modal-head">
                <h3 class="adm-modal-title">Reset Admin Password</h3>
                <button type="button" class="adm-modal-close" onclick="closeForgotModal()">✕</button>
            </div>
            <p style="font-size:0.82rem; color:#7A7266; line-height:1.4;">
                Enter your registered admin email or WhatsApp number. A secure 6-digit recovery OTP will be transmitted instantly.
            </p>
            <form onsubmit="handleForgotSubmit(event)" style="display:flex; flex-direction:column; gap:14px;">
                <div class="adm-field-group">
                    <label class="adm-field-label">Admin Email or WhatsApp Number</label>
                    <div class="adm-input-wrapper">
                        <svg class="adm-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        <input type="text" id="forgotInput" class="adm-form-input" placeholder="admin@jaihanumantex.in or +91 9822019283" required>
                    </div>
                </div>

                <div id="forgotStatusMsg" style="display:none; padding:10px; border-radius:8px; font-size:0.8rem; background:#DCFCE7; color:#15803D; border:1px solid #BBF7D0;">
                    ✓ <strong>OTP Sent!</strong> A verification code has been dispatched to your WhatsApp/Email.
                </div>

                <button type="submit" class="adm-submit-btn" id="forgotSubmitBtn">
                    <span>Send Password Reset OTP</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Interactive Script -->
    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('adminPassword');
            const eyeIcon = document.getElementById('eyeIcon');
            if (!pwdInput) return;

            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
            } else {
                pwdInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        }

        function fillDemoCredentials() {
            document.getElementById('adminEmail').value = 'admin@jaihanumantex.in';
            document.getElementById('adminPassword').value = 'admin123';
        }

        function openForgotModal() {
            document.getElementById('admForgotModal').classList.add('open');
            document.getElementById('forgotStatusMsg').style.display = 'none';
            document.getElementById('forgotInput').value = document.getElementById('adminEmail').value;
        }

        function closeForgotModal() {
            document.getElementById('admForgotModal').classList.remove('open');
        }

        function handleForgotSubmit(e) {
            e.preventDefault();
            const btn = document.getElementById('forgotSubmitBtn');
            const msg = document.getElementById('forgotStatusMsg');
            btn.innerHTML = '<span>Transmitting OTP...</span>';
            btn.disabled = true;

            setTimeout(() => {
                btn.innerHTML = '<span>OTP Sent Successfully</span>';
                msg.style.display = 'block';
                setTimeout(() => {
                    closeForgotModal();
                    btn.innerHTML = '<span>Send Password Reset OTP</span>';
                    btn.disabled = false;
                }, 2200);
            }, 800);
        }
    </script>
</body>
</html>
