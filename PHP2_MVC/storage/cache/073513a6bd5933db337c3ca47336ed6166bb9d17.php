
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
        }

        .register-box {
            max-width: 450px;
            margin: 60px auto;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
        }

        .card-header {
            background: white;
            border-bottom: none;
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            padding-top: 20px;
        }

        .form-control {
            border-radius: 8px;
            height: 44px;
        }

        .btn-primary {
            height: 44px;
            border-radius: 8px;
            font-weight: 500;
        }

        .error-text {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="register-box">
    <div class="card">
        <div class="card-header">
            Tạo tài khoản mới
        </div>

        <div class="card-body">

            <?php if($error): ?>
                <div class="error-text">
                    <?php echo e($error); ?>

                </div>
            <?php endif; ?>

            <form method="post">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input name="username" class="form-control" placeholder="Nhập username">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input name="email" class="form-control" placeholder="Nhập email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                </div>

                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input name="full_name" class="form-control" placeholder="Nhập họ tên">
                </div>

                <button class="btn btn-primary w-100">
                    Đăng ký
                </button>

            </form>

            <div class="login-link">
                <a href="/auth/login">Đã có tài khoản? Đăng nhập</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\Xamppp2\htdocs\hihi\php2026\PHP2_MVC\app\views/auth/register.blade.php ENDPATH**/ ?>