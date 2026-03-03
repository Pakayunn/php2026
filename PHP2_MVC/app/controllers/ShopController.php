<?php

class ShopController extends Controller
{
public function index()
{
    $productModel = $this->model('Product');
    $categoryModel = $this->model('Category');

    $categories = $categoryModel->all();

    // ===== LẤY FILTER =====
    $filters = [
        'category_id' => $_GET['category_id'] ?? null,
        'min' => $_GET['min'] ?? null,
        'max' => $_GET['max'] ?? null,
        'keyword' => $_GET['keyword'] ?? null,
        'sort' => $_GET['sort'] ?? null,
    ];

    // ===== PHÂN TRANG =====
    $limit = 9;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;

    $offset = ($page - 1) * $limit;

    // ===== LỌC + LẤY TẤT CẢ KẾT QUẢ =====
    $allProducts = $productModel->filterAdvanced($filters);

    $totalProducts = count($allProducts);
    $totalPages = ceil($totalProducts / $limit);

    // ===== CẮT THEO TRANG =====
    $products = array_slice($allProducts, $offset, $limit);

    $this->view('shop.index', [
        'products' => $products,
        'categories' => $categories,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'title' => 'Sản phẩm'
    ]);
}

    public function detail($id)
    {
        $productModel = $this->model('Product');
        $product = $productModel->find($id);

        $relatedProducts = $productModel->getRelated(
            $product['category_id'],
            $product['id'],
            4
        );

        $this->view('shop.detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

 
}

