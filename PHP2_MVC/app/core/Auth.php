<?php
class Auth
{
    public static function checkAdmin()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: /auth/login");
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            echo "Bạn không có quyền vào trang này";
            exit;
        }
    }
}
