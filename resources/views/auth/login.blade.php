<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinical Entry - {{ \App\Models\Setting::getValue('clinic_name', 'ClinicEase') }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.9);
        }

        body {
            background: #f0f2f5;
            background-image:
                radial-gradient(at 0% 0%, hsla(253, 16%, 7%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225, 39%, 30%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339, 49%, 30%, 1) 0, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            perspective: 1000px;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            padding: 3rem 2.5rem;
            transition: transform 0.3s ease;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
            background: var(--primary-gradient);
            border-radius: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
        }

        .form-control {
            border-radius: 100px;
            padding: 0.75rem 1.5rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            transition: all 0.2s;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            border-color: #667eea;
            background: white;
        }

        .btn-entry {
            background: var(--primary-gradient);
            border: none;
            border-radius: 100px;
            color: white;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 0.85rem;
            transition: all 0.3s;
            box-shadow: 0 10px 15px -3px rgba(118, 75, 162, 0.4);
        }

        .btn-entry:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(118, 75, 162, 0.5);
            color: white;
        }

        .info-pill {
            background: rgba(0, 0, 0, 0.03);
            border-radius: 1rem;
            padding: 1rem;
            margin-top: 2rem;
        }

        .floating-circles div {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="glass-card">
            <div class="text-center mb-5">
                <div class="brand-logo">
                    <i class="fas fa-stethoscope text-white fa-2x"></i>
                </div>
                <h2 class="fw-bold text-dark mb-1">{{ \App\Models\Setting::getValue('clinic_name', 'ClinicEase') }}</h2>
                <p class="text-muted small">Digital Health Information System v2.0</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger border-0 rounded-4 mb-4 small">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary ps-3">Authorized Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 pe-0 ps-3">
                            <i class="fas fa-envelope text-muted"></i>
                        </span>
                        <input type="email" name="email" class="form-control" placeholder="e.g. admin@clinic.com"
                            required value="{{ old('email') }}">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary ps-3">Secure Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 pe-0 ps-3">
                            <i class="fas fa-lock text-muted"></i>
                        </span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 ps-3 pe-3">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small text-muted" for="remember">Keep me sessionized</label>
                    </div>
                    <a href="#" class="text-decoration-none small fw-bold text-primary">Forgot Key?</a>
                </div>

                <button type="submit" class="btn btn-entry w-100 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i>Access Workspace
                </button>
            </form>

            <div class="info-pill text-center">
                <small class="text-secondary d-block mb-2 fw-bold">Demo Credentials (Password: password)</small>
                <div class="d-flex justify-content-around gap-2">
                    <span class="badge bg-white text-primary border rounded-pill px-2 py-1">Admin</span>
                    <span class="badge bg-white text-success border rounded-pill px-2 py-1">Doctor</span>
                    <span class="badge bg-white text-info border rounded-pill px-2 py-1">Reception</span>
                </div>
            </div>

            <p class="text-center mt-5 mb-0 text-muted small">
                © {{ date('Y') }} {{ \App\Models\Setting::getValue('clinic_name', 'ClinicEase') }}. All Rights Reserved.
            </p>
        </div>
    </div>
</body>

</html>