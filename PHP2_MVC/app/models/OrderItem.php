<?php

class OrderItem extends Model
{
    // ===============================
    // INSERT (giữ nguyên logic cũ)
    // ===============================
    public function insert($data)
    {
        $conn = $this->connect();

        $sql = "INSERT INTO order_items
                (order_id, product_id, product_name, product_image,
                 quantity, price, subtotal, created_at)
                VALUES
                (:order_id, :product_id, :product_name, :product_image,
                 :quantity, :price, :subtotal, NOW())";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':order_id' => $data['order_id'],
            ':product_id' => $data['product_id'],
            ':product_name' => $data['product_name'],
            ':product_image' => $data['product_image'],
            ':quantity' => $data['quantity'],
            ':price' => $data['price'],
            ':subtotal' => $data['subtotal']
        ]);
    }

    // ===============================
    // LẤY ITEM THEO ORDER (CHO ADMIN)
    // ===============================
    public function getByOrder($orderId)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
            SELECT *
            FROM order_items
            WHERE order_id = ?
            ORDER BY id DESC
        ");

        $stmt->execute([$orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===============================
    // TÍNH TỔNG TIỀN THEO ORDER
    // ===============================
    public function getTotalByOrder($orderId)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
            SELECT SUM(subtotal) as total
            FROM order_items
            WHERE order_id = ?
        ");

        $stmt->execute([$orderId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] ?? 0;
    }

    // ===============================
    // ĐẾM SỐ SẢN PHẨM TRONG ORDER
    // ===============================
    public function countItems($orderId)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
            SELECT COUNT(*) as total_items
            FROM order_items
            WHERE order_id = ?
        ");

        $stmt->execute([$orderId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total_items'] ?? 0;
    }

}