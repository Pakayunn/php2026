<?php

class OrdersController extends Controller
{
    /* ==========================
       ADMIN - Danh sách đơn hàng
    ========================== */
    public function index()
    {
        if (empty($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

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

    /* ==========================
       ADMIN - Xem chi tiết đơn
    ========================== */
 public function show($id)
{
    if (empty($_SESSION['user'])) {
        header("Location: /login");
        exit;
    }

    $pdo = Database::connect();

    $stmtCheck = $pdo->prepare("
        SELECT * FROM orders WHERE id = ?
    ");
    $stmtCheck->execute([$id]);
    $order = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die("Không tìm thấy đơn hàng");
    }

    if ($_SESSION['user']['id'] != $order['user_id']) {
        die("Bạn không có quyền xem đơn này");
    }

    $stmt = $pdo->prepare("
        SELECT * FROM order_items
        WHERE order_id = ?
    ");
    $stmt->execute([$id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $this->view('orders.show', [
        'order' => $order,   
        'items' => $items
    ]);
}

    /* ==========================
       ADMIN - Update trạng thái (AJAX)
    ========================== */
    public function updateStatus($id, $status)
    {
        if (empty($_SESSION['user'])) {
            echo json_encode(['success' => false]);
            return;
        }

        $allowed = ['pending', 'processing', 'completed', 'cancelled'];

        if (!in_array($status, $allowed)) {
            echo json_encode(['success' => false]);
            return;
        }

        $pdo = Database::connect();

        $stmt = $pdo->prepare("
            UPDATE orders
            SET status = ?, updated_at = NOW()
            WHERE id = ?
        ");

        $success = $stmt->execute([$status, $id]);

        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    /* ==========================
       USER - Trang checkout
    ========================== */
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

    /* ==========================
       USER - Đặt hàng
    ========================== */
    public function placeOrder()
    {
        if (empty($_SESSION['cart'])) {
            header("Location: /cart");
            exit;
        }

        if (empty($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $pdo = Database::connect();
        $pdo->beginTransaction();

        try {

            $userId = $_SESSION['user']['id'];

            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $finalAmount = $total;

            $stmt = $pdo->prepare("
                INSERT INTO orders (
                    user_id,
                    total_amount,
                    discount_amount,
                    final_amount,
                    shipping_name,
                    shipping_phone,
                    shipping_address,
                    payment_method,
                    payment_status,
                    status,
                    notes,
                    created_at,
                    updated_at
                )
                VALUES (?, ?, 0, ?, ?, ?, ?, ?, 'pending', 'pending', ?, NOW(), NOW())
            ");

            $stmt->execute([
                $userId,
                $total,
                $finalAmount,
                $_POST['shipping_name'] ?? '',
                $_POST['shipping_phone'] ?? '',
                $_POST['shipping_address'] ?? '',
                $_POST['payment_method'] ?? 'cod',
                $_POST['notes'] ?? ''
            ]);

            $orderId = $pdo->lastInsertId();

            $stmtItem = $pdo->prepare("
                INSERT INTO order_items (
                    order_id,
                    product_id,
                    product_name,
                    product_image,
                    quantity,
                    price,
                    subtotal,
                    created_at
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            foreach ($_SESSION['cart'] as $item) {
                $stmtItem->execute([
                    $orderId,
                    $item['product_id'],
                    $item['name'] ?? '',
                    $item['image'] ?? '',
                    $item['quantity'],
                    $item['price'],
                    $item['price'] * $item['quantity']
                ]);
            }

            $pdo->commit();

            unset($_SESSION['cart']);

            header("Location: /orders/myOrders");
            exit;

        } catch (Exception $e) {

            $pdo->rollBack();
            echo "Lỗi đặt hàng: " . $e->getMessage();
        }
    }

    /* ==========================
       USER - Lịch sử đơn hàng
    ========================== */
    public function myOrders()
    {
        if (empty($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $pdo = Database::connect();

        $stmt = $pdo->prepare("
            SELECT id, final_amount, status, created_at
            FROM orders
            WHERE user_id = ?
            ORDER BY id DESC
        ");

        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->view('user.orders', [
            'orders' => $orders
        ]);
    }

    /* ==========================
       USER - Chi tiết đơn hàng
    ========================== */
    public function myOrderDetail($id)
    {
        if (empty($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $pdo = Database::connect();

        $stmt = $pdo->prepare("
            SELECT *
            FROM orders
            WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$id, $userId]);

        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$order) {
            die("Không tìm thấy đơn hàng");
        }

        $stmtItem = $pdo->prepare("
            SELECT oi.*, p.name
            FROM order_items oi
            JOIN products p ON p.id = oi.product_id
            WHERE oi.order_id = ?
        ");
        $stmtItem->execute([$id]);

        $items = $stmtItem->fetchAll(PDO::FETCH_ASSOC);

        return $this->view('orders.myOrderdetail', [
            'order' => $order,
            'items' => $items
        ]);
    }
public function cancel($id)
{
    if (empty($_SESSION['user'])) {
        header("Location: /login");
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $pdo = Database::connect();

    // Kiểm tra đơn có tồn tại và thuộc user không
    $stmt = $pdo->prepare("
        SELECT status 
        FROM orders 
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$id, $userId]);

    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die("Không tìm thấy đơn hàng");
    }

    // Chỉ cho hủy khi đang pending
    if ($order['status'] !== 'pending') {
        die("Chỉ có thể hủy đơn khi đang chờ xử lý");
    }

    // Cập nhật trạng thái
    $stmtUpdate = $pdo->prepare("
        UPDATE orders
        SET status = 'cancelled', updated_at = NOW()
        WHERE id = ?
    ");

    $stmtUpdate->execute([$id]);

    header("Location: /orders/myOrders");
    exit;
}
public function reorder($id)
{
    if (empty($_SESSION['user'])) {
        header("Location: /login");
        exit;
    }

    $userId = $_SESSION['user']['id'];
    $pdo = Database::connect();

    // Kiểm tra đơn thuộc user
    $stmt = $pdo->prepare("
        SELECT status 
        FROM orders 
        WHERE id = ? AND user_id = ?
    ");
    $stmt->execute([$id, $userId]);

    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die("Không tìm thấy đơn hàng");
    }

    // 🔥 CHỈ cho mua lại khi đã completed
    if ($order['status'] !== 'completed') {
        die("Chỉ những đơn đã hoàn tất mới được mua lại");
    }

    // Lấy sản phẩm trong đơn
    $stmtItems = $pdo->prepare("
        SELECT product_id, product_name, product_image, quantity, price
        FROM order_items
        WHERE order_id = ?
    ");
    $stmtItems->execute([$id]);

    $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

    if (!$items) {
        die("Đơn hàng không có sản phẩm");
    }

    // Thêm vào giỏ hàng
    foreach ($items as $item) {
        $_SESSION['cart'][$item['product_id']] = [
            'product_id' => $item['product_id'],
            'name'       => $item['product_name'],
            'image'      => $item['product_image'],
            'price'      => $item['price'],
            'quantity'   => $item['quantity']
        ];
    }

    header("Location: /cart");
    exit;
}
}