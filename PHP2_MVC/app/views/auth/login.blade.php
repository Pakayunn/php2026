<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
        }

        .login-container {
            max-width: 420px;
            margin: 60px auto;
        }

        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
        }

        .login-header {
            background: #0d6efd;
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 20px;
            text-align: center;
        }

        .btn-primary {
            padding: 10px;
        }

        .form-control {
            padding: 10px;
        }

        .error-box {
            background: #ffecec;
            border-left: 4px solid #dc3545;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="card login-card">

        <div class="login-header">
            <h4 class="mb-0">Đăng nhập hệ thống</h4>
        </div>

        <div class="card-body p-4">

            @if($error)
                <div class="error-box text-danger">
                    {{ $error }}
                </div>
            @endif

            <form method="post">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input 
                        name="email" 
                        class="form-control" 
                        placeholder="Nhập email..."
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Mật khẩu</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control"
                        placeholder="Nhập mật khẩu..."
                    >
                </div>

                <button class="btn btn-primary w-100">
                    <i class="fas fa-sign-in"></i> Đăng nhập
                </button>

            </form>
            <a href="/auth/forgot">Quên mật khẩu?</a>


            <div class="text-center mt-3">
                <a class="text-decoration-none" href="{{ $baseUrl ?? '/auth/register' }}">
                    Chưa có tài khoản? Đăng ký
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
