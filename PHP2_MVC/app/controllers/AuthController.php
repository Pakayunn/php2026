<?php

class AuthController extends Controller
{
    // /auth/login
    public function login()
    {
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
        unset($_SESSION['user']);

        return $this->redirect('/auth/login');
    }
   public function forgot()
{
    $error = null;
    $success = null;

    // Blade render
    $this->view('auth.forgot', compact('error', 'success'));
}

public function forgotPost()
{
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = "Vui lòng nhập đầy đủ thông tin";
        $this->view('auth.forgot', compact('error'));
        return;
    }

    $userModel = new User();
    $user = $userModel->findByEmail($email);

    if (!$user) {
        $error = "Email không tồn tại";
        $this->view('auth.forgot', compact('error'));
        return;
    }

    // cập nhật mật khẩu mới
    $userModel->update($user['id'], [
        'username'  => $user['username'],
        'email'     => $user['email'],
        'password'  => $password,
        'full_name' => $user['full_name'],
        'role'      => $user['role'],
        'status'    => $user['status'],
    ]);

    $_SESSION['success'] = "Đã cập nhật mật khẩu mới, hãy đăng nhập";

    $this->redirect('/auth/login');
}
}