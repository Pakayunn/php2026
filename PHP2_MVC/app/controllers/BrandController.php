<?php

class BrandController extends Controller
{
    public function index()
    {
        $brandModel = $this->model('Brand');
        $brands = $brandModel->all();
        
        $this->view('brand.index', [
            'brands' => $brands,
            'title' => 'Quản lý thương hiệu'
        ]);
    }

    public function create()
    {
        $this->view('brand.create', [
            'title' => 'Thêm thương hiệu mới'
        ]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('brand');
            return;
        }

        $validator = new Validator($_POST);
        $validator->required(['name'])
                  ->min('name', 2)
                  ->max('name', 255);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('brand/create');
            return;
        }

        // Xử lý upload logo
        $logoName = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/brands/';
            $upload = new Upload($uploadDir);
            $upload->setAllowedTypes(['jpg', 'jpeg', 'png'])
                   ->setMaxSize(2097152);

            $logoName = $upload->upload($_FILES['logo']);
            
            if ($upload->hasErrors()) {
                $_SESSION['errors']['logo'] = $upload->firstError();
                $_SESSION['old'] = $_POST;
                $this->redirect('brand/create');
                return;
            }
        }

        $brandModel = $this->model('Brand');
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'] ?? '',
            'logo' => $logoName
        ];
        
        if ($brandModel->create($data)) {
            $_SESSION['success'] = 'Thêm thương hiệu thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        $this->redirect('brand');
    }

    public function edit($id)
    {
        $brandModel = $this->model('Brand');
        $brand = $brandModel->find($id);
        
        if (!$brand) {
            $_SESSION['error'] = 'Không tìm thấy thương hiệu!';
            $this->redirect('brand');
            return;
        }

        $this->view('brand.edit', [
            'brand' => $brand,
            'title' => 'Sửa thương hiệu'
        ]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/brand');
            return;
        }

        $brandModel = $this->model('Brand');
        $brand = $brandModel->find($id);

        if (!$brand) {
            $_SESSION['error'] = 'Không tìm thấy thương hiệu!';
            $this->redirect('/brand');
            return;
        }

        $validator = new Validator($_POST);
        $validator->required(['name'])
                  ->min('name', 2)
                  ->max('name', 255);

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/brand/edit/' . $id);
            return;
        }

        // Xử lý upload logo mới
        $logoName = $brand['logo'];
        
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/brands/';
            $upload = new Upload($uploadDir);
            $upload->setAllowedTypes(['jpg', 'jpeg', 'png'])
                   ->setMaxSize(2097152);

            $newLogo = $upload->upload($_FILES['logo']);
            
            if ($upload->hasErrors()) {
                $_SESSION['errors']['logo'] = $upload->firstError();
                $_SESSION['old'] = $_POST;
                $this->redirect('/brand/edit/' . $id);
                return;
            }

            // Xóa logo cũ
            if (!empty($brand['logo'])) {
                $oldLogoPath = $uploadDir . $brand['logo'];
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }

            $logoName = $newLogo;
        }

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'] ?? '',
            'logo' => $logoName
        ];
        
        if ($brandModel->update($data, $id)) {
            $_SESSION['success'] = 'Cập nhật thương hiệu thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra!';
        }

        $this->redirect('/brand');
    }

    public function delete($id)
    {
        $brandModel = $this->model('Brand');
        
        // Kiểm tra có sản phẩm nào đang dùng brand này không
        if ($brandModel->countProducts($id) > 0) {
            echo json_encode(['success' => false, 'message' => 'Không thể xóa! Có sản phẩm đang sử dụng thương hiệu này.']);
            exit;
        }
        
        if ($brandModel->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa thương hiệu thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra!']);
        }
        exit;
    }
}