<?php

class AuthController
{
    public function login()
    {
        $error = null;
        require Views_PATH . '/auth/login.php';
    }

    public function register()
    {
        $error = null;
        require Views_PATH . '/auth/register.php';
    }
}
