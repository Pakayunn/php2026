<?php

// class AuthController
// {
//     public function login()
//     {
//         $error = null;
//         require Views_PATH . '/auth/login.php';
//     }

//     public function register()
//     {
//         $error = null;
//         require Views_PATH . '/auth/register.php';
//     }
// }


class AuthController extends Controller
{
    // /auth/login
    public function login()
    {
        session_start();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = $this->model('User');
            $user = $userModel->findByEmail($email);

            if (!$user) {
                $error = "Email không tồn tại";
            }
            elseif (!password_verify($password, $user['password'])) {
                $error = "Sai mật khẩu";
            }
            elseif ($user['status'] != 'active') {
                $error = "Tài khoản đã bị khóa";
            }
            else {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                return $this->redirect('/home/index');
            }
        }

        return $this->view('auth.login', [
            'error' => $error
        ]);
    }

    // /auth/register
    public function register()
    {
        session_start();
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'username'  => $_POST['username'] ?? '',
                'email'     => $_POST['email'] ?? '',
                'password'  => $_POST['password'] ?? '',
                'full_name' => $_POST['full_name'] ?? ''
            ];

            $userModel = $this->model('User');

            if ($userModel->findByEmail($data['email'])) {
                $error = "Email đã tồn tại";
            }
            elseif ($userModel->findByUsername($data['username'])) {
                $error = "Username đã tồn tại";
            }
            else {
                $userModel->create($data);

                return $this->redirect('/auth/login');
            }
        }

        return $this->view('auth.register', [
            'error' => $error
        ]);
    }

    // /auth/logout
    public function logout()
    {
        session_start();
        unset($_SESSION['user']);

        return $this->redirect('/auth/login');
    }
}
