<?php

class UserController extends Controller
{
    public function index()
    {
        $userModel = $this->model('User');
        $users = $userModel->all();

        $this->view('user.index', [
            'users' => $users,
            'title' => 'Quản lý người dùng'
        ]);
    }

    public function create()
    {
        $this->view('user.create', [
            'title' => 'Thêm người dùng mới'
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/user');
            return;
        }

        $validator = new Validator($_POST);
        $validator->required(['username', 'email', 'password', 'full_name'])
            ->min('username', 3)
            ->max('username', 100)
            ->email('email')
            ->min('password', 6)
            ->unique('username', 'users')
            ->unique('email', 'users');

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/user/create');
            return;
        }

        $userModel = $this->model('User');

        if ($userModel->create($_POST)) {
            $_SESSION['success'] = 'Thêm người dùng thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        $this->redirect('/user');
    }

    public function edit($id)
    {
        $userModel = $this->model('User');
        $user = $userModel->find($id);

        if (!$user) {
            $_SESSION['error'] = 'Không tìm thấy người dùng!';
            $this->redirect('/user');
            return;
        }

        $this->view('user.edit', [
            'user' => $user,
            'title' => 'Sửa người dùng'
        ]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/user');
            return;
        }

        $validator = new Validator($_POST);
        $validator->required(['username', 'email', 'full_name'])
            ->min('username', 3)
            ->max('username', 100)
            ->email('email')
            ->unique('username', 'users', $id)
            ->unique('email', 'users', $id);

        // Validate password nếu có nhập
        if (!empty($_POST['password'])) {
            $validator->min('password', 6);
        }

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/user/edit/' . $id);
            return;
        }

        $userModel = $this->model('User');

        if ($userModel->update($id, $_POST)) {
            $_SESSION['success'] = 'Cập nhật người dùng thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        $this->redirect('/user');
    }

    public function delete($id)
    {
        $userModel = $this->model('User');

        if ($userModel->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa người dùng thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra!']);
        }
        exit;
    }
   /* ==============================
   PROFILE - USER SIDE
   ============================== */

public function profile()
{
    if (!isset($_SESSION['user'])) {
        $this->redirect('/auth/login');
        return;
    }

    $userModel = $this->model('User');
    $user = $userModel->find($_SESSION['user']['id']);

    $this->view('user.profile', [
        'user' => $user,
        'title' => 'Thông tin cá nhân'
    ]);
}

public function editProfile()
{
    if (!isset($_SESSION['user'])) {
        $this->redirect('/auth/login');
        return;
    }

    $userModel = $this->model('User');
    $user = $userModel->find($_SESSION['user']['id']);

    $this->view('user.edit_profile', [
        'user' => $user,
        'title' => 'Chỉnh sửa hồ sơ'
    ]);
}

public function updateProfile()
{
    if (!isset($_SESSION['user'])) {
        $this->redirect('/auth/login');
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('/user/profile');
        return;
    }

    $id = $_SESSION['user']['id'];
    $userModel = $this->model('User');
    $currentUser = $userModel->find($id);

    if (!$currentUser) {
        $_SESSION['error'] = "Người dùng không tồn tại";
        $this->redirect('/user/profile');
        return;
    }

    // Chuẩn hóa dữ liệu được phép cập nhật
    $data = [
        'username'  => $currentUser['username'],   // Không cho sửa
        'email'     => $currentUser['email'],      // Không cho sửa
        'full_name' => $_POST['full_name'] ?? $currentUser['full_name'],
        'phone'     => $_POST['phone'] ?? $currentUser['phone'],
        'role'      => $currentUser['role'],       // Không cho sửa
        'status'    => $currentUser['status'],     // Không cho sửa
        'password'  => $currentUser['password']    // Giữ nguyên nếu không đổi
    ];

    // Nếu có nhập mật khẩu mới
    if (!empty($_POST['password'])) {

        if (strlen($_POST['password']) < 6) {
            $_SESSION['error'] = "Mật khẩu phải ít nhất 6 ký tự";
            $this->redirect('/user/editProfile');
            return;
        }

        if ($_POST['password'] !== ($_POST['password_confirmation'] ?? '')) {
            $_SESSION['error'] = "Mật khẩu xác nhận không khớp";
            $this->redirect('/user/editProfile');
            return;
        }

        $data['password'] = $_POST['password'];
    }

    // GỌI ĐÚNG THỨ TỰ THAM SỐ
    $userModel->update($id, $data);

    // Cập nhật lại session
    $_SESSION['user'] = $userModel->find($id);

    $_SESSION['success'] = "Cập nhật hồ sơ thành công";
    $this->redirect('/user/profile');
}
}