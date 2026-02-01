<?php

class HomeController extends Controller
{
    
    public function index()
    {
        $productModel = $this->model('Product');
        $categoryModel = $this->model('Category');
        
        $products = $productModel->all();
        $categories = $categoryModel->all();
        
        $this->view('home.index', [
            'products' => $products,
            'categories' => $categories,
            'title' => 'Trang chủ'
        ]);
    }

    /**
     * Chi tiết sản phẩm
     */
    public function detail($id)
    {
        $productModel = $this->model('Product');
        $product = $productModel->find($id);
        
        if (!$product) {
            $this->notFound('Không tìm thấy sản phẩm');
            return;
        }
        
        $this->view('home.detail', [
            'product' => $product,
            'title' => $product['name']
        ]);
    }
}