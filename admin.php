<?php
// Start session
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - تسجيل الدخول</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #54c8e8;
            --primary-dark: #083347;
            --primary-light: rgba(84, 200, 232, 0.153);
            --white: #ffffff;
            --dark: #083347;
            --border: #e2e8f0;
            --text-primary: #083347;
            --text-secondary: #4a6e7d;
            --text-muted: #b2bec3;
            --success: #2ecc71;
            --danger: #e74c3c;
            --font-main: 'Tajawal', sans-serif;
            --shadow: 0 4px 6px rgba(8, 51, 71, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(8, 51, 71, 0.1), 0 4px 6px -2px rgba(8, 51, 71, 0.05);
            --shadow-lg: 0 20px 25px -5px rgba(8, 51, 71, 0.1), 0 10px 10px -5px rgba(8, 51, 71, 0.04);
            --radius: 0.5rem;
            --radius-lg: 1rem;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: var(--font-main);
        }

        html, body {
            height: 100%;
            direction: rtl;
        }

        body {
            background-color: #f8fafc;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Login Container */
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 0;
            position: relative;
            overflow: hidden;
            background-color: var(--white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            animation: fade-in 0.6s ease-out;
        }

        .login-header {
            position: relative;
            padding: 2.5rem 2rem;
            text-align: center;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .login-logo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
            animation: pulse 2s infinite;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            opacity: 0.9;
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
            transition: var(--transition);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            color: var(--dark);
            background-color: var(--white);
            background-clip: padding-box;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            transition: var(--transition);
            box-shadow: 0 1px 2px rgba(8, 51, 71, 0.05);
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: 0;
            box-shadow: 0 0 0 3px rgba(84, 200, 232, 0.25);
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-right: 2.5rem;
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 2px solid transparent;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: var(--radius);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(8, 51, 71, 0.15);
        }

        .btn-icon {
            margin-left: 0.5rem;
        }

        .btn-block {
            display: flex;
            width: 100%;
        }

        /* Alert */
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: var(--radius);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-error {
            background-color: rgba(231, 76, 60, 0.1);
            border-right: 4px solid var(--danger);
            color: var(--danger);
        }

        /* Animations */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 0 8px rgba(255, 255, 255, 0.2);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.2);
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                border-radius: 0;
                height: 100%;
                max-width: 100%;
            }
            
            .login-header {
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-logo">
                <img src="https://rayansu.com/3/wp-content/uploads/2021/05/new-logo.png" alt="Logo">
            </div>
            <h1 class="login-title">لوحة تحكم اختبار توازن</h1>
            <p class="login-subtitle">قم بتسجيل الدخول للوصول إلى لوحة التحكم</p>
        </div>
        
        <div class="login-body">
            <div id="loginError" class="alert alert-error" style="display: none;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorMessage">بيانات الدخول غير صحيحة</span>
            </div>
            
            <form id="loginForm">
                <div class="form-group">
                    <label class="form-label" for="username">اسم المستخدم</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="username" placeholder="أدخل اسم المستخدم" required>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">كلمة المرور</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" placeholder="أدخل كلمة المرور" required>
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt btn-icon"></i>
                    تسجيل الدخول
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginError = document.getElementById('loginError');
            const errorMessage = document.getElementById('errorMessage');
            
            // Hard-coded credentials (as requested)
            const VALID_USERNAME = 'aziz';
            const VALID_PASSWORD = '123456';
            
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const username = document.getElementById('username').value;
                const password = document.getElementById('password').value;
                
                // Client-side authentication
                if (username === VALID_USERNAME && password === VALID_PASSWORD) {
                    // Hide any previous error
                    loginError.style.display = 'none';
                    
                    // Create a form to submit the authenticated status
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'dashboard.php';
                    
                    const authField = document.createElement('input');
                    authField.type = 'hidden';
                    authField.name = 'auth';
                    authField.value = 'true';
                    
                    form.appendChild(authField);
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    // Show error message
                    errorMessage.textContent = 'اسم المستخدم أو كلمة المرور غير صحيحة';
                    loginError.style.display = 'flex';
                    
                    // Shake effect for error
                    loginForm.classList.add('shake');
                    setTimeout(() => {
                        loginForm.classList.remove('shake');
                    }, 500);
                }
            });
        });
    </script>
</body>
</html>