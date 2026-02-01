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
        
        if ($userModel->update($_POST, $id)) {
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
}