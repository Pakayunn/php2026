<?php

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm
     */
    public function index()
    {
        $productModel = $this->model('Product');
        $products = $productModel->all();
        
        $this->view('product.index', [
            'products' => $products,
            'title' => 'Quản lý sản phẩm'
        ]);
    }

    /**
     * Hiển thị form tạo sản phẩm mới
     */
    public function create()
    {
        $categoryModel = $this->model('Category');
        $brandModel = $this->model('Brand');
        
        $this->view('product.create', [
            'categories' => $categoryModel->all(),
            'brands' => $brandModel->all(),
            'title' => 'Thêm sản phẩm mới'
        ]);
    }

    /**
     * Xử lý thêm sản phẩm mới
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/product');
            return;
        }

        // Validate dữ liệu
        $validator = new Validator($_POST);
        $validator->required(['name', 'price', 'category_id', 'brand_id'])
                  ->min('name', 3)
                  ->max('name', 255)
                  ->numeric('price')
                  ->positive('price')
                  ->numeric('stock');

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/product/create');
            return;
        }

        // Xử lý upload ảnh
        $imageName = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/products/';
            
            // Tạo thư mục nếu chưa có
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $upload = new Upload($uploadDir);
            $upload->setAllowedTypes(['jpg', 'jpeg', 'png'])
                   ->setMaxSize(2097152); // 2MB

            $imageName = $upload->upload($_FILES['image']);
            
            if ($upload->hasErrors()) {
                $_SESSION['errors']['image'] = $upload->firstError();
                $_SESSION['old'] = $_POST;
                $this->redirect('/product/create');
                return;
            }
        }

        // Lưu vào database
        $productModel = $this->model('Product');
        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'category_id' => $_POST['category_id'],
            'brand_id' => $_POST['brand_id'],
            'description' => $_POST['description'] ?? '',
            'image' => $imageName,
            'stock' => $_POST['stock'] ?? 0
        ];

        if ($productModel->create($data)) {
            $_SESSION['success'] = 'Thêm sản phẩm thành công!';
            $this->redirect('/product');
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi thêm sản phẩm!';
            $this->redirect('/product');
        }

        
    }

    /**
     * Hiển thị form sửa sản phẩm
     */
    public function edit($id)
    {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');
        $brandModel = $this->model('Brand');
        
        $product = $productModel->find($id);
        
        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
            $this->redirect('/product');
            return;
        }

        $this->view('product.edit', [
            'product' => $product,
            'categories' => $categoryModel->all(),
            'brands' => $brandModel->all(),
            'title' => 'Sửa sản phẩm'
        ]);
    }

    /**
     * Xử lý cập nhật sản phẩm
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/product');
            return;
        }

        $productModel = $this->model('Product');
        $product = $productModel->find($id);

        if (!$product) {
            $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
            $this->redirect('/product');
            return;
        }

        $validator = new Validator($_POST);
        $validator->required(['name', 'price', 'category_id', 'brand_id'])
                  ->min('name', 3)
                  ->max('name', 255)
                  ->numeric('price')
                  ->positive('price')
                  ->numeric('stock');

        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $_POST;
            $this->redirect('/product/edit/' . $id);
            return;
        }

        $imageName = $product['image'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = BASE_PATH . '/public/uploads/products/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $upload = new Upload($uploadDir);
            $upload->setAllowedTypes(['jpg', 'jpeg', 'png'])
                   ->setMaxSize(2097152);

            $newImage = $upload->upload($_FILES['image']);

            if ($upload->hasErrors()) {
                $_SESSION['errors']['image'] = $upload->firstError();
                $_SESSION['old'] = $_POST;
                $this->redirect('/product/edit/' . $id);
                return;
            }

            if (!empty($product['image'])) {
                $oldImagePath = $uploadDir . $product['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imageName = $newImage;
        }

        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'category_id' => $_POST['category_id'],
            'brand_id' => $_POST['brand_id'],
            'description' => $_POST['description'] ?? '',
            'image' => $imageName,
            'stock' => $_POST['stock'] ?? 0
        ];

        if ($productModel->update($id, $data)) {
            $_SESSION['success'] = 'Cập nhật sản phẩm thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật sản phẩm!';
        }

        $this->redirect('/product');
    }

    /**
     * Xóa sản phẩm (AJAX)
     */
    public function delete($id)
    {
        $productModel = $this->model('Product');
        
        if ($productModel->delete($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra!']);
        }
        exit;
    }
}