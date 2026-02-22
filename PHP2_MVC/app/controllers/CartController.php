<?php

class CartController extends Controller
{
    private $cartModel;
    private $productModel;
    private $orderModel;
    private $orderItemModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->orderItemModel = new OrderItem();
    }

    // ===============================
    // THÊM VÀO GIỎ HÀNG
    // ===============================
    public function add($productId)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /auth/login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $product = $this->productModel->find($productId);

        if (!$product) {
            header("Location: /");
            exit;
        }

        $existing = $this->cartModel->findByUserAndProduct($userId, $productId);

        if ($existing) {
            $this->cartModel->updateQuantity($existing['id'], $existing['quantity'] + 1);
        } else {
            $this->cartModel->insert([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product['price']
            ]);
        }

        header("Location: /cart/index");
        exit;
    }

    // ===============================
    // HIỂN THỊ GIỎ HÀNG
    // ===============================
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /auth/login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $items = $this->cartModel->getByUser($userId);

        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $this->view('cart.index', [
            'items' => $items,
            'total' => $total
        ]);
    }

    // ===============================
    // XÓA SẢN PHẨM
    // ===============================
    public function remove($id)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /auth/login");
            exit;
        }

        $this->cartModel->delete($id);

        header("Location: /cart/index");
        exit;
    }

    // ===============================
    // COUNT BADGE
    // ===============================
    public function count()
    {
        if (!isset($_SESSION['user'])) {
            return 0;
        }

        $userId = $_SESSION['user']['id'];
        return $this->cartModel->countByUser($userId);
    }

    // ===============================
    // UPDATE AJAX
    // ===============================
    public function updateQuantity()
    {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false]);
            return;
        }

        $userId = $_SESSION['user']['id'];
        $productId = $_POST['product_id'] ?? null;
        $action = $_POST['action'] ?? null;

        if (!$productId || !$action) {
            echo json_encode(['success' => false]);
            return;
        }

        $pdo = Database::connect();

        $stmt = $pdo->prepare("SELECT quantity, price FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$cart) {
            echo json_encode(['success' => false]);
            return;
        }

        $quantity = $cart['quantity'];

        if ($action === 'increase') {
            $quantity++;
        }

        if ($action === 'decrease') {
            $quantity--;
            if ($quantity <= 0) {
                $delete = $pdo->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
                $delete->execute([$userId, $productId]);

                echo json_encode(['deleted' => true]);
                return;
            }
        }

        $update = $pdo->prepare("UPDATE carts SET quantity = ?, updated_at = NOW() WHERE user_id = ? AND product_id = ?");
        $update->execute([$quantity, $userId, $productId]);

        echo json_encode([
            'success' => true,
            'quantity' => $quantity,
            'subtotal' => $quantity * $cart['price']
        ]);
    }

    // ===============================
    // TĂNG (NON-AJAX)
    // ===============================
    public function increase($productId)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /auth/login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cart = $this->cartModel->findByUserAndProduct($userId, $productId);
        $product = $this->productModel->find($productId);

        if ($cart && $product) {

            if ($cart['quantity'] >= $product['stock']) {
                header("Location: /cart/index?error=out_of_stock");
                exit;
            }

            $this->cartModel->updateQuantity($cart['id'], $cart['quantity'] + 1);
        }

        header("Location: /cart/index");
        exit;
    }

    // ===============================
    // GIẢM (NON-AJAX)
    // ===============================
    public function decrease($productId)
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /auth/login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $cart = $this->cartModel->findByUserAndProduct($userId, $productId);

        if ($cart) {
            if ($cart['quantity'] <= 1) {
                $this->cartModel->delete($cart['id']);
            } else {
                $this->cartModel->updateQuantity($cart['id'], $cart['quantity'] - 1);
            }
        }

        header("Location: /cart/index");
        exit;
    }

    // ==========================================================
    // ======================= CHECKOUT =========================
    // ==========================================================

    public function checkout()
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
    // PLACE ORDER
    // ===============================
    public function placeOrder()
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

        // ===== VALIDATE INPUT =====
        $shippingName = $_POST['shipping_name'] ?? '';
        $shippingPhone = $_POST['shipping_phone'] ?? '';
        $shippingAddress = $_POST['shipping_address'] ?? '';
        $paymentMethod = $_POST['payment_method'] ?? 'cod';
        $notes = $_POST['notes'] ?? '';

        if (!$shippingName || !$shippingPhone || !$shippingAddress) {
            header("Location: /cart/checkout?error=missing_info");
            exit;
        }

        // ===== VALIDATE TỒN KHO =====
        foreach ($items as $item) {

            $product = $this->productModel->find($item['product_id']);

            if (!$product || $item['quantity'] > $product['stock']) {
                header("Location: /cart/checkout?error=out_of_stock");
                exit;
            }
        }

        // ===== TÍNH TOTAL =====
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // ===== TẠO ORDER =====
        $orderId = $this->orderModel->create([
            'user_id' => $userId,
            'total_amount' => $total,
            'final_amount' => $total,
            'shipping_name' => $shippingName,
            'shipping_phone' => $shippingPhone,
            'shipping_address' => $shippingAddress,
            'payment_method' => $paymentMethod,
            'notes' => $notes
        ]);

        // ===== LƯU ORDER ITEMS + TRỪ STOCK =====
        foreach ($items as $item) {

    $product = $this->productModel->find($item['product_id']);

    $subtotal = $item['price'] * $item['quantity'];

    $this->orderItemModel->insert([
        'order_id' => $orderId,
        'product_id' => $item['product_id'],
        'product_name' => $product['name'],      // lấy từ products
        'product_image' => $product['image'],   // lấy từ products
        'quantity' => $item['quantity'],
        'price' => $item['price'],
        'subtotal' => $subtotal
    ]);

    // Trừ tồn kho
    $newStock = $product['stock'] - $item['quantity'];
    $this->productModel->updateStock($item['product_id'], $newStock);
}

        // ===== XÓA GIỎ HÀNG =====
        $this->cartModel->clearCart($userId);

        header("Location: /cart/success");
        exit;
    }

    // ===============================
    // SUCCESS
    // ===============================  
    public function success()
    {
        return $this->view('checkout.success');
    }
}