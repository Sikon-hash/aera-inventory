<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - AERA Frozen Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f1b35 0%, #0096c7 100%);
            min-height: 100vh; display:flex; align-items:center; justify-content:center;
        }
        .login-card {
            background: white; border-radius: 16px; padding: 40px;
            width: 100%; max-width: 420px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-logo { text-align:center; margin-bottom:24px; }
        .login-logo i { font-size: 2.5rem; color: #0096c7; }
        .login-logo h4 { margin:8px 0 0; font-weight:700; color:#0f1b35; }
        .login-logo small { color:#64748b; }
        .form-control { border-radius:8px; padding:10px 14px; border:1.5px solid #e0e7ef; }
        .form-control:focus { border-color:#0096c7; box-shadow:none; }
        .btn-login {
            background: #0096c7; color:white; width:100%; padding:12px;
            border-radius:8px; font-weight:600; border:none;
        }
        .btn-login:hover { background:#0077a3; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-logo">
        <i class="fas fa-snowflake"></i>
        <h4>AERA Frozen Food</h4>
        <small>Sistem Informasi Inventaris</small>
    </div>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="email@example.com" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="••••••••" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-login">
            <i class="fas fa-sign-in-alt me-2"></i>Masuk
        </button>
    </form>
    <div class="mt-3 text-center">
        <small class="text-muted">Default: owner@aera.com / admin@aera.com | password: <b>password</b></small>
    </div>
</div>
</body>
</html>