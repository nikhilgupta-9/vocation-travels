<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../db-conn.php';

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true && !empty($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

$error = null;
$success = null;

// Handle logout notification
if (isset($_GET['logged_out']) && $_GET['logged_out'] == '1') {
    $success = "You have been safely logged out.";
}

// Generate CSRF token if missing
if (empty($_SESSION['admin_csrf_token'])) {
    $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $submitted_token = $_POST['csrf_token'] ?? '';
    
    // CSRF verification
    if (empty($submitted_token) || !hash_equals($_SESSION['admin_csrf_token'], $submitted_token)) {
        $error = "Session expired or invalid security token. Please try again.";
    } else {
        $login_input = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = !empty($_POST['remember']);

        if (empty($login_input) || empty($password)) {
            $error = "Please enter both username/email and password.";
        } else {
            // Find admin by username OR email
            $stmt = $conn->prepare("SELECT id, username, password, email, first_name, last_name, role, status, failed_attempts, locked_until FROM admin_user WHERE username = ? OR email = ? LIMIT 1");
            
            if ($stmt) {
                $stmt->bind_param("ss", $login_input, $login_input);
                $stmt->execute();
                $res = $stmt->get_result();
                $admin = $res ? $res->fetch_assoc() : null;
                $stmt->close();

                if ($admin) {
                    $now = date('Y-m-d H:i:s');
                    
                    // Check if account is locked
                    if (!empty($admin['locked_until']) && $admin['locked_until'] > $now) {
                        $lock_time = strtotime($admin['locked_until']) - time();
                        $lock_minutes = max(1, ceil($lock_time / 60));
                        $error = "Account temporarily locked due to multiple failed attempts. Try again in {$lock_minutes} minute(s).";
                    } elseif ($admin['status'] !== 'active') {
                        $error = "Your account is marked as {$admin['status']}. Please contact administrator.";
                    } elseif (password_verify($password, $admin['password'])) {
                        // Password correct - Regenerate session ID
                        session_regenerate_id(true);

                        $full_name = trim(($admin['first_name'] ?? '') . ' ' . ($admin['last_name'] ?? ''));
                        if (empty($full_name)) {
                            $full_name = $admin['username'];
                        }

                        $_SESSION['admin_logged_in'] = true;
                        $_SESSION['admin_id'] = (int)$admin['id'];
                        $_SESSION['admin_user'] = $admin['username'];
                        $_SESSION['admin_name'] = $full_name;
                        $_SESSION['admin_email'] = $admin['email'] ?? '';
                        $_SESSION['admin_role'] = $admin['role'] ?? 'admin';
                        $_SESSION['login_time'] = time();

                        // Update last login timestamp, IP and reset failed attempts
                        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
                        $update_stmt = $conn->prepare("UPDATE admin_user SET last_login = NOW(), last_login_ip = ?, failed_attempts = 0, locked_until = NULL WHERE id = ?");
                        if ($update_stmt) {
                            $update_stmt->bind_param("si", $ip, $admin['id']);
                            $update_stmt->execute();
                            $update_stmt->close();
                        }

                        // Generate fresh CSRF token for next session
                        $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));

                        // Redirect to admin dashboard
                        header("Location: ../index.php");
                        exit();
                    } else {
                        // Password wrong - increment failed attempts
                        $failed = (int)($admin['failed_attempts'] ?? 0) + 1;
                        $lock_sql = "";
                        if ($failed >= 5) {
                            // Lock account for 15 minutes
                            $lock_time = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                            $upd = $conn->prepare("UPDATE admin_user SET failed_attempts = ?, locked_until = ? WHERE id = ?");
                            if ($upd) {
                                $upd->bind_param("isi", $failed, $lock_time, $admin['id']);
                                $upd->execute();
                                $upd->close();
                            }
                            $error = "Account locked for 15 minutes due to 5 failed attempts.";
                        } else {
                            $upd = $conn->prepare("UPDATE admin_user SET failed_attempts = ? WHERE id = ?");
                            if ($upd) {
                                $upd->bind_param("ii", $failed, $admin['id']);
                                $upd->execute();
                                $upd->close();
                            }
                            $remaining = 5 - $failed;
                            $error = "Invalid password. {$remaining} attempt(s) remaining before temporary lockout.";
                        }
                    }
                } else {
                    // Constant-time sleep to mitigate enumeration
                    usleep(rand(200000, 400000));
                    $error = "No account found matching that username or email.";
                }
            } else {
                $error = "Database query error. Please verify database connection.";
            }
        }
    }
}

// Refresh CSRF token on render
$_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
$csrf_token = $_SESSION['admin_csrf_token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Login | Vocation Travels &amp; Tours</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= $site ?>assets/images/logo.png">

    <!-- Vendor Icons & Fonts -->
    <link rel="stylesheet" href="<?= $site ?>assets/vendor/fontawesome/css/all.min.css">
    
    <style>
        :root {
            --brand-green: #1ec700;
            --brand-green-hover: #17a500;
            --brand-rose: #e11d48;
            --bg-dark: #080c14;
            --card-dark: rgba(15, 23, 42, 0.75);
            --card-border: rgba(255, 255, 255, 0.12);
            --text-light: #f8fafc;
            --text-muted: #94a3b8;
            --input-bg: rgba(2, 6, 23, 0.7);
            --input-border: rgba(255, 255, 255, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
            color: var(--text-light);
        }

        /* Ambient animated background grid and glow */
        .ambient-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .ambient-glow-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 550px;
            height: 550px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(30, 199, 0, 0.18) 0%, rgba(30, 199, 0, 0) 70%);
            filter: blur(60px);
            animation: pulseGlow 12s ease-in-out infinite alternate;
        }

        .ambient-glow-2 {
            position: absolute;
            bottom: -15%;
            right: -10%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(225, 29, 72, 0.16) 0%, rgba(225, 29, 72, 0) 70%);
            filter: blur(70px);
            animation: pulseGlow 14s ease-in-out infinite alternate-reverse;
        }

        .ambient-grid {
            position: absolute;
            inset: 0;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.7;
        }

        @keyframes pulseGlow {
            0% { transform: scale(1) translate(0, 0); opacity: 0.6; }
            100% { transform: scale(1.15) translate(30px, 30px); opacity: 0.9; }
        }

        /* Main Container */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            margin: auto;
        }

        /* Top Return Link */
        .top-return-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding: 0 0.25rem;
        }

        .top-return-bar a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.825rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.2s ease;
        }

        .top-return-bar a:hover {
            color: var(--brand-green);
        }

        .live-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            color: #4ade80;
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.25);
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            font-weight: 500;
        }

        .live-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 8px #22c55e;
        }

        /* Glassmorphism Card */
        .login-card {
            background: var(--card-dark);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            padding: 2.25rem 2rem;
            box-shadow: 
                0 20px 40px -15px rgba(0, 0, 0, 0.7),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            position: relative;
        }

        .card-header-badge {
            text-align: center;
            margin-bottom: 1.75rem;
        }

        .logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 72px;
            height: 72px;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 10px;
            margin-bottom: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }

        .logo-wrap:hover {
            transform: scale(1.05);
        }

        .logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .portal-title {
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #ffffff;
            margin-bottom: 0.25rem;
        }

        .portal-title span {
            background: linear-gradient(135deg, var(--brand-green), #38ef7d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .portal-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* Quick Credentials Pill Banner */
        .quick-cred-banner {
            background: rgba(30, 199, 0, 0.08);
            border: 1px dashed rgba(30, 199, 0, 0.35);
            border-radius: 0.75rem;
            padding: 0.75rem 0.9rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .quick-cred-text {
            font-size: 0.78rem;
            color: #d1fae5;
            line-height: 1.3;
        }

        .quick-cred-text strong {
            color: #ffffff;
        }

        .btn-autofill {
            background: rgba(30, 199, 0, 0.2);
            color: #86efac;
            border: 1px solid rgba(30, 199, 0, 0.4);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.35rem 0.65rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-autofill:hover {
            background: var(--brand-green);
            color: #000000;
        }

        /* Alerts */
        .alert-box {
            padding: 0.85rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.825rem;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            line-height: 1.4;
            animation: shakeAlert 0.4s ease;
        }

        @keyframes shakeAlert {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-4px); }
            40%, 80% { transform: translateX(4px); }
        }

        .alert-error {
            background: rgba(225, 29, 72, 0.15);
            border: 1px solid rgba(225, 29, 72, 0.35);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.35);
            color: #86efac;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #cbd5e1;
            margin-bottom: 0.45rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #64748b;
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .form-input {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 0.75rem;
            padding: 0.8rem 1rem 0.8rem 2.75rem;
            color: #ffffff;
            font-size: 0.925rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            background: rgba(15, 23, 42, 0.95);
            border-color: var(--brand-green);
            box-shadow: 0 0 0 3px rgba(30, 199, 0, 0.2);
        }

        .form-input:focus + .input-icon,
        .input-box:focus-within .input-icon {
            color: var(--brand-green);
        }

        .toggle-pwd-btn {
            position: absolute;
            right: 0.85rem;
            background: transparent;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 0.35rem;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .toggle-pwd-btn:hover {
            color: #e2e8f0;
        }

        /* Extra Options Row */
        .extra-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 0.825rem;
        }

        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            user-select: none;
            color: var(--text-muted);
        }

        .remember-wrap input[type="checkbox"] {
            accent-color: var(--brand-green);
            width: 16px;
            height: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--brand-green);
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--brand-green) 0%, #159c00 100%);
            color: #ffffff;
            border: none;
            border-radius: 0.75rem;
            padding: 0.9rem;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 10px 25px -5px rgba(30, 199, 0, 0.4);
            transition: all 0.25s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #24e000 0%, #18a800 100%);
            transform: translateY(-2px);
            box-shadow: 0 14px 28px -5px rgba(30, 199, 0, 0.5);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Security Badges Footer */
        .login-footer-info {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            justify-content: space-around;
            text-align: center;
            font-size: 0.72rem;
            color: #64748b;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .security-item i {
            color: var(--brand-green);
            font-size: 0.8rem;
        }

        /* Help Modal */
        .help-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(8px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 100;
            padding: 1rem;
        }

        .help-modal-card {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            max-width: 400px;
            width: 100%;
            padding: 1.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75);
            position: relative;
        }

        .help-modal-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .help-modal-desc {
            font-size: 0.85rem;
            color: #94a3b8;
            line-height: 1.5;
            margin-bottom: 1.25rem;
        }

        .help-modal-box {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 0.8rem;
            color: #cbd5e1;
            margin-bottom: 1.25rem;
        }

        .btn-modal-close {
            width: 100%;
            padding: 0.65rem;
            border-radius: 0.5rem;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .btn-modal-close:hover {
            background: rgba(255, 255, 255, 0.18);
        }
    </style>
</head>
<body>
    <!-- Ambient glowing backdrop -->
    <div class="ambient-bg">
        <div class="ambient-grid"></div>
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <div class="login-wrapper">
        <!-- Top navigation breadcrumb / live badge -->
        <div class="top-return-bar">
            <a href="<?= $site ?>">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Vocation Travels Website</span>
            </a>
            <div class="live-badge">
                <span class="live-dot"></span>
                <span>Protected Portal</span>
            </div>
        </div>

        <!-- Main Glass Card -->
        <div class="login-card">
            <div class="card-header-badge">
                <div class="logo-wrap">
                    <img src="<?= $site ?>assets/images/logo.png" alt="Vocation Travels Logo" onerror="this.src='../assets/img/logo_icon.jpg'">
                </div>
                <h1 class="portal-title">Admin <span>Control Center</span></h1>
                <p class="portal-subtitle">Secure management portal for tours, visas &amp; inquiries</p>
            </div>

            <!-- Quick Credentials Helper Chip -->
            <div class="quick-cred-banner">
                <div class="quick-cred-text">
                    <i class="fa-solid fa-key" style="color: #1ec700; margin-right: 4px;"></i>
                    Default Login: <strong>admin</strong> / <strong>admin123</strong>
                </div>
                <button type="button" class="btn-autofill" onclick="autofillDemo()">
                    Auto-Fill
                </button>
            </div>

            <!-- Feedback Messages -->
            <?php if (!empty($error)): ?>
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-triangle-exclamation" style="margin-top: 2px;"></i>
                    <div><?= htmlspecialchars($error) ?></div>
                </div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check" style="margin-top: 2px;"></i>
                    <div><?= htmlspecialchars($success) ?></div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="" autocomplete="on" id="loginForm">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

                <!-- Username or Email Field -->
                <div class="form-group">
                    <label class="form-label" for="username">Username or Email</label>
                    <div class="input-box">
                        <input type="text" 
                               id="username" 
                               name="username" 
                               class="form-input" 
                               required 
                               autocomplete="username"
                               placeholder="e.g. admin or nikhilgupta@gmail.com"
                               value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                        <i class="fa-solid fa-user-shield input-icon"></i>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-box">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-input" 
                               required 
                               autocomplete="current-password"
                               placeholder="Enter your security password">
                        <i class="fa-solid fa-lock input-icon"></i>
                        <button type="button" class="toggle-pwd-btn" onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
                            <i class="fa-solid fa-eye" id="pwdEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Extra Options (Remember Me & Forgot Password) -->
                <div class="extra-row">
                    <label class="remember-wrap">
                        <input type="checkbox" name="remember" id="remember" value="1">
                        <span>Remember credentials</span>
                    </label>
                    <a href="javascript:void(0)" class="forgot-link" onclick="openForgotModal()">
                        Need help?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                    <span>Secure Admin Login</span>
                </button>
            </form>

            <!-- Bottom Security Badges -->
            <div class="login-footer-info">
                <div class="security-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>256-Bit SSL</span>
                </div>
                <div class="security-item">
                    <i class="fa-solid fa-fingerprint"></i>
                    <span>IP Logged</span>
                </div>
                <div class="security-item">
                    <i class="fa-solid fa-user-lock"></i>
                    <span>RBAC Protected</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password / Help Modal -->
    <div class="help-modal-backdrop" id="helpModal">
        <div class="help-modal-card">
            <h2 class="help-modal-title">
                <i class="fa-solid fa-circle-info" style="color: #1ec700;"></i>
                Admin Access Assistance
            </h2>
            <p class="help-modal-desc">
                If you are having trouble logging into the Vocation Travels management portal, you can use the default authorized administrative account:
            </p>
            <div class="help-modal-box">
                <p><strong>Username:</strong> <code>admin</code></p>
                <p><strong>Email:</strong> <code>nikhilgupta@gmail.com</code></p>
                <p><strong>Password:</strong> <code>admin123</code></p>
            </div>
            <button type="button" class="btn-modal-close" onclick="closeForgotModal()">
                Dismiss &amp; Back to Login
            </button>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById("password");
            const eyeIcon = document.getElementById("pwdEyeIcon");
            if (pwdInput.type === "password") {
                pwdInput.type = "text";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            } else {
                pwdInput.type = "password";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            }
        }

        function autofillDemo() {
            document.getElementById("username").value = "admin";
            document.getElementById("password").value = "admin123";
            const btn = document.getElementById("submitBtn");
            btn.focus();
        }

        function openForgotModal() {
            document.getElementById("helpModal").style.display = "flex";
        }

        function closeForgotModal() {
            document.getElementById("helpModal").style.display = "none";
        }

        // Close modal when clicking on backdrop
        document.getElementById("helpModal").addEventListener("click", function(e) {
            if (e.target === this) {
                closeForgotModal();
            }
        });

        // Add loading state on submit
        document.getElementById("loginForm").addEventListener("submit", function() {
            const btn = document.getElementById("submitBtn");
            btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i><span>Verifying Credentials...</span>';
            btn.style.opacity = "0.85";
            btn.style.pointerEvents = "none";
        });
    </script>
</body>
</html>