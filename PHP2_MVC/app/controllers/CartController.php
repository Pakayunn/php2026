<?php

class CartController extends Controller
{
    public function add($id)
    {
        session_start();

        $productModel = $this->model('Product');
        $product = $productModel->find($id);

        if (!$product) {
            echo "Sản phẩm không tồn tại";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }

        header("Location: /cart/show");
    }

    public function show()
    {
        session_start();
        $cart = $_SESSION['cart'] ?? [];

        $this->view('cart.index', [
            'cart' => $cart,
            'title' => 'Giỏ hàng'
        ]);
    }
}