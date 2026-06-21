<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Record System - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('css/interactive.css') }}" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
                url("{{ asset('images/srs.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            color: #fff;
        }
        .login-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.35);
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
        }
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            font-weight: bold;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .app-title {
            color: #1d4ed8;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 8px rgba(29, 78, 216, 0.15);
            transition: transform 0.25s ease, color 0.25s ease, text-shadow 0.25s ease;
        }
        .app-title:hover {
            color: #2563eb;
            transform: translateY(-1px) scale(1.02);
            text-shadow: 0 6px 18px rgba(37, 99, 235, 0.25);
        }
        .text-muted {
            color: #6c757d !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-graduation-cap fa-4x text-primary"></i>
                            <h3 class="mt-2 app-title">Student Record System</h3>
                            <p class="text-muted">Please login to your account</p>
                        </div>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required autofocus value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                                <small class="form-text text-muted d-block mt-1">
                                    <strong>Requirements:</strong> 8+ chars, Uppercase, Lowercase, Number
                                </small>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-login">
                                <i class="fas fa-sign-in-alt me-2"></i> Login
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>