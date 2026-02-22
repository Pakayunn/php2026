    <?php

    class OrdersController extends Controller
    {
        public function index()
{
    $pdo = Database::connect();

    $stmt = $pdo->prepare("
        SELECT id, shipping_name, final_amount, payment_status, status, created_at
        FROM orders
        ORDER BY id DESC
    ");

    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $this->view('orders.index', [
        'orders' => $orders
    ]);
}

        public function show($id)
        {
            $pdo = Database::connect();

            $stmt = $pdo->prepare("
                SELECT * FROM order_items
                WHERE order_id = ?
            ");

            $stmt->execute([$id]);

            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $this->view('orders.show', [
                'items' => $items
            ]);
        }

        public function updateStatus($id)
        {
            $status = $_POST['status'] ?? 'processing';

            $pdo = Database::connect();

            $pdo->prepare("
                UPDATE orders
                SET status = ?
                WHERE id = ?
            ")->execute([$status, $id]);

            header("Location: /orders");
            exit;
        }
        public function checkout()
{
    $items = $_SESSION['cart'] ?? [];

    if (empty($items)) {
        header("Location: /cart");
        exit;
    }

    $total = 0;
    foreach ($items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return $this->view('orders.checkout', [
        'items' => $items,
        'total' => $total
    ]);
}

public function placeOrder()
{
    if (empty($_SESSION['cart'])) {
        header("Location: /cart");
        exit;
    }

    $pdo = Database::connect();
    $pdo->beginTransaction();

    try {

        $userId = $_SESSION['user']['id'] ?? null;

        // 1. Tạo order
        $stmt = $pdo->prepare("
            INSERT INTO orders (user_id, total, status, created_at)
            VALUES (?, ?, 'pending', NOW())
        ");

        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $stmt->execute([$userId, $total]);

        $orderId = $pdo->lastInsertId();

        // 2. Thêm order_items
        $stmtItem = $pdo->prepare("
            INSERT INTO order_items (order_id, product_id, price, quantity)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($_SESSION['cart'] as $item) {
            $stmtItem->execute([
                $orderId,
                $item['product_id'],
                $item['price'],
                $item['quantity']
            ]);
        }

        $pdo->commit();

        // 3. Xóa cart
        unset($_SESSION['cart']);

        header("Location: /");
        exit;

    } catch (Exception $e) {

        $pdo->rollBack();
        echo "Lỗi đặt hàng: " . $e->getMessage();
    }
}
    }
