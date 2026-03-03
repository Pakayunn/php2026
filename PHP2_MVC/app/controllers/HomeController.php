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

    $categories = $categoryModel->all();

    // ===== PHÂN TRANG =====
    $limit = 9;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;

    $offset = ($page - 1) * $limit;

    $products = $productModel->paginate($limit, $offset);

    $totalProducts = $productModel->count();
    $totalPages = ceil($totalProducts / $limit);

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
        'products' => $products,
        'categories' => $categories,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'title' => 'Trang chủ'
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
    $wishlistModel = $this->model('Wishlist');

    $product = $productModel->find($id);

    if (!$product) {
        $this->notFound('Không tìm thấy sản phẩm');
        return;
    }

    // GẮN TRẠNG THÁI YÊU THÍCH
    if (isset($_SESSION['user'])) {
        $product['is_liked'] = $wishlistModel->isLiked(
            $_SESSION['user']['id'],
            $product['id']
        );
    }

    // LẤY SẢN PHẨM LIÊN QUAN (CÙNG CATEGORY, KHÁC ID)
    $relatedProducts = $productModel->getRelated(
        $product['category_id'],
        $product['id'],
        4
    );

    $this->view('home.detail', [
        'product'         => $product,
        'relatedProducts' => $relatedProducts,
        'title'           => $product['name'] ?? 'Chi tiết sản phẩm'
    ]);
}

}