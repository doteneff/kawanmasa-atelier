<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Kawanmasa Atelier</title>
    <style>
        body {
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgb(0 0 0 / 0.08);
            padding: 2rem 1.25rem;
            width: 100%;
            display: flex;
            flex-direction: column;
            max-width: 400px;
        }
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #232136;
            margin-bottom: 0.5rem;
            text-align: center;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        }
        .login-subtitle {
            color: #7c3aed;
            text-align: center;
            font-size: 1.1rem;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            font-weight: 500;
            margin-bottom: 2rem;
        }
        .login-label {
            display: block;
            font-weight: 500;
            color: #232136;
            margin-bottom: 0.25rem;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
        }
        .login-input {
            width: 100%;
            max-width: 360px;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            background: #f1f5f9;
            font-size: 1rem;
            margin-bottom: 1.25rem;
            transition: border 0.2s;
            font-family: inherit;
        }
        .login-input:focus {
            border-color: #a78bfa;
            outline: none;
            background: #ede9fe;
        }
        .login-btn {
            width: 100%;
            background: #a78bfa;
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.75rem 0;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }
        .login-btn:hover {
            background: #7c3aed;
            transform: scale(1.03);
        }
        .login-error {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .login-footer {
            margin-top: 2rem;
            text-align: center;
            color: #94a3b8;
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-title">Welcome Back</div>
        <div class="login-subtitle">Sign in to your account</div>
        <?php if (isset($error)): ?>
            <div class="login-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <form method="post" action="/login">
            <label for="email" class="login-label">Email Address</label>
            <input type="text" id="email" name="email" required class="login-input" />

            <label for="password" class="login-label">Password</label>
            <input type="password" id="password" name="password" required class="login-input" />

            <button type="submit" class="login-btn">Login</button>
        </form>
        <div class="login-footer">
            &copy; <?= date('Y') ?> Kawanmasa Atelier
        </div>
    </div>
</body>
</html>