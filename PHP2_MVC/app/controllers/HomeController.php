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
    $wishlistModel = $this->model('Wishlist');

    $products = $productModel->all();
    $categories = $categoryModel->all();

    // GẮN TRẠNG THÁI YÊU THÍCH
    if (isset($_SESSION['user'])) {
        foreach ($products as &$product) {
            $product['is_liked'] = $wishlistModel->isLiked(
                $_SESSION['user']['id'],
                $product['id']
            );
        }
    }

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