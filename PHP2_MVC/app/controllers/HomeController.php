<?php

class HomeController extends Controller
{
    /**
     * Trang chủ
     */
    public function index()
    {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');

        // Lấy dữ liệu
        $products = $productModel->all();
        $categories = $categoryModel->all();

        // Render view
        $this->view('home.index', [
            'products'   => $products ?? [],
            'categories' => $categories ?? [],
            'title'      => 'Trang chủ'
        ]);
    }

    /**
     * Chi tiết sản phẩm
     */
    public function detail($id = null)
    {
        if (!$id || !is_numeric($id)) {
            $this->notFound('ID sản phẩm không hợp lệ');
            return;
        }

        $productModel = $this->model('Product');
        $product = $productModel->find($id);

        if (!$product) {
            $this->notFound('Không tìm thấy sản phẩm');
            return;
        }

        $this->view('home.detail', [
            'product' => $product,
            'title'   => $product['name'] ?? 'Chi tiết sản phẩm'
        ]);
    }
}