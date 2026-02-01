<?php

class CategoryController extends Controller
{
    public function index()
    {
        $categoryModel = $this->model('Category');
        $categories = $categoryModel->all();
        
        $this->view('category.index', [
            'categories' => $categories,
            'title' => 'Quản lý danh mục'
        ]);
    }

    public function create()
    {
        $this->view('category.create', [
            'title' => 'Thêm danh mục mới'
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/category');
            return;
        }

        $validator = new Validator($_POST);
        $validator->required(['name'])
                  ->min('name', 3)
                  ->max('name', 255);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/category/create');
            return;
        }

        $categoryModel = $this->model('Category');
        
        if ($categoryModel->create($_POST)) {
            $_SESSION['success'] = 'Thêm danh mục thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        $this->redirect('/category');
    }

    public function edit($id)
    {
        $categoryModel = $this->model('Category');
        $category = $categoryModel->find($id);
        
        if (!$category) {
            $_SESSION['error'] = 'Không tìm thấy danh mục!';
            $this->redirect('/category');
            return;
        }

        $this->view('category.edit', [
            'category' => $category,
            'title' => 'Sửa danh mục'
        ]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/category');
            return;
        }

        $validator = new Validator($_POST);
        $validator->required(['name'])
                  ->min('name', 3)
                  ->max('name', 255);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/category/edit/' . $id);
            return;
        }

        $categoryModel = $this->model('Category');
        
        if ($categoryModel->update($_POST, $id)) {
            $_SESSION['success'] = 'Cập nhật danh mục thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        $this->redirect('/category');
    }

    public function delete($id)
    {
        $categoryModel = $this->model('Category');
        
        // Kiểm tra xem có sản phẩm nào đang dùng category này không
        if ($categoryModel->countProducts($id) > 0) {
            echo json_encode(['success' => false, 'message' => 'Không thể xóa! Có sản phẩm đang sử dụng danh mục này.']);
            exit;
        }
        
        if ($categoryModel->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa danh mục thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra!']);
        }
        exit;
    }
}