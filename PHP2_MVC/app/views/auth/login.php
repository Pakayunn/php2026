<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f8;
        }
        .box {
            width: 360px;
            margin: 100px auto;
            padding: 25px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #0d6efd;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Đăng nhập</h2>

    <?php if (!empty($error)) : ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form action="/login" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng nhập</button>
    </form>

    <a href="/register">Chưa có tài khoản? Đăng ký</a>
</div>

</body>
</html>
