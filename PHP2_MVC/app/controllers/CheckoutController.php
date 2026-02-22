<?php

class CheckoutController extends Controller
{
    private $cartModel;
    private $productModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->productModel = new Product();
    }

    // ===============================
    // HIỂN THỊ TRANG CHECKOUT
    // ===============================
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /auth/login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $items = $this->cartModel->getByUser($userId);

        if (empty($items)) {
            header("Location: /cart/index?error=empty");
            exit;
        }

        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $this->view('checkout.index', [
            'items' => $items,
            'total' => $total
        ]);
    }

    // ===============================
    // XỬ LÝ ĐẶT HÀNG
    // ===============================
    public function place()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /auth/login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $items = $this->cartModel->getByUser($userId);

        if (empty($items)) {
            header("Location: /cart/index");
            exit;
        }

        $pdo = Database::connect();
        $pdo->beginTransaction();

        try {

            foreach ($items as $item) {

                $product = $this->productModel->find($item['product_id']);

                if ($item['quantity'] > $product['stock']) {
                    throw new Exception("Không đủ tồn kho");
                }

                $stmt = $pdo->prepare("
                    UPDATE products 
                    SET stock = stock - ? 
                    WHERE id = ?
                ");
                $stmt->execute([
                    $item['quantity'],
                    $item['product_id']
                ]);
            }

            $stmt = $pdo->prepare("DELETE FROM carts WHERE user_id = ?");
            $stmt->execute([$userId]);

            $pdo->commit();

            header("Location: /checkout/success");
            exit;

        } catch (Exception $e) {

            $pdo->rollBack();
            header("Location: /cart/index?error=stock");
            exit;
        }
    }

    public function success()
    {
        return $this->view('checkout.success');
    }
}