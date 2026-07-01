<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #0D0D1A;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 20%, rgba(108,92,231,0.15) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(0,184,148,0.08) 0%, transparent 60%);
            pointer-events: none;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(26, 26, 46, 0.95);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 24px;
            padding: 48px 40px;
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 80px rgba(0,0,0,0.5);
            position: relative;
            z-index: 1;
        }

        .brand {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #6C5CE7, #a29bfe);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; color: #fff;
            margin: 0 auto 16px;
            box-shadow: 0 8px 30px rgba(108,92,231,0.4);
        }

        .brand h4 {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            margin: 0 0 4px;
        }

        .brand p {
            font-size: 13px;
            color: #8888A8;
            margin: 0;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #C0C0D8;
            margin-bottom: 6px;
        }

        .form-control {
            background: #0F0F1A;
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            color: #E8E8F0;
            font-size: 14px;
            padding: 12px 16px;
            transition: all 0.2s;
        }

        .form-control:focus {
            background: #0F0F1A;
            border-color: #6C5CE7;
            box-shadow: 0 0 0 3px rgba(108,92,231,0.2);
            color: #E8E8F0;
        }

        .form-control::placeholder { color: #555570; }

        .input-group-text {
            background: #0F0F1A;
            border: 1px solid rgba(255,255,255,0.08);
            color: #8888A8;
            border-radius: 12px 0 0 12px;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #6C5CE7, #a29bfe);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 6px 20px rgba(108,92,231,0.4);
            letter-spacing: 0.3px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 30px rgba(108,92,231,0.5);
        }

        .form-check-input:checked {
            background-color: #6C5CE7;
            border-color: #6C5CE7;
        }

        .form-check-label {
            font-size: 13px;
            color: #8888A8;
        }

        .invalid-feedback { font-size: 12px; }
        .alert-danger {
            background: rgba(214,48,49,0.1);
            border: 1px solid rgba(214,48,49,0.2);
            border-radius: 12px;
            color: #FF7675;
            font-size: 13px;
        }

        .footer-text {
            text-align: center;
            font-size: 12px;
            color: #555570;
            margin-top: 32px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
            <div class="brand-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <h4>BookingPro</h4>
            <p>Admin Panel · Sign in to continue</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="fa-solid fa-circle-exclamation me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email"
                       name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="admin@example.com"
                       value="{{ old('email') }}"
                       autocomplete="email"
                       required autofocus>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••"
                       autocomplete="current-password"
                       required>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Sign In
            </button>
        </form>

        <div class="footer-text">
            © {{ date('Y') }} BookingPro. All rights reserved.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
