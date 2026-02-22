<?php

class Order extends Model
{
    // ===============================
    // CREATE (GIỮ NGUYÊN CODE CŨ)
    // ===============================
    public function create($data)
    {
        $conn = $this->connect();

        $sql = "INSERT INTO orders 
                (user_id, total_amount, discount_amount, final_amount,
                 shipping_address, shipping_phone, shipping_name,
                 payment_method, payment_status, status, notes,
                 created_at, updated_at)
                VALUES 
                (:user_id, :total_amount, 0, :final_amount,
                 :shipping_address, :shipping_phone, :shipping_name,
                 :payment_method, 'unpaid', 'pending', :notes,
                 NOW(), NOW())";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':total_amount' => $data['total_amount'],
            ':final_amount' => $data['final_amount'],
            ':shipping_address' => $data['shipping_address'],
            ':shipping_phone' => $data['shipping_phone'],
            ':shipping_name' => $data['shipping_name'],
            ':payment_method' => $data['payment_method'],
            ':notes' => $data['notes']
        ]);

        return $conn->lastInsertId();
    }


    // ===============================
    // LẤY TẤT CẢ ĐƠN (ADMIN)
    // ===============================
    public function all()
    {
        $conn = $this->connect();

        $stmt = $conn->query("
            SELECT *
            FROM orders
            ORDER BY id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ===============================
    // TÌM THEO ID
    // ===============================
    public function find($id)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
            SELECT *
            FROM orders
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // ===============================
    // LẤY ĐƠN THEO USER (TRANG USER)
    // ===============================
    public function getByUser($userId)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
            SELECT *
            FROM orders
            WHERE user_id = ?
            ORDER BY id DESC
        ");

        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // ===============================
    // UPDATE STATUS (ADMIN)
    // ===============================
    public function updateStatus($id, $status)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
            UPDATE orders
            SET status = ?, updated_at = NOW()
            WHERE id = ?
        ");

        return $stmt->execute([$status, $id]);
    }


    // ===============================
    // UPDATE PAYMENT STATUS
    // ===============================
    public function updatePaymentStatus($id, $paymentStatus)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
            UPDATE orders
            SET payment_status = ?, updated_at = NOW()
            WHERE id = ?
        ");

        return $stmt->execute([$paymentStatus, $id]);
    }


    // ===============================
    // THỐNG KÊ DOANH THU (BASIC)
    // ===============================
    public function getTotalRevenue()
    {
        $conn = $this->connect();

        $stmt = $conn->query("
            SELECT SUM(final_amount) as revenue
            FROM orders
            WHERE status = 'completed'
        ");

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['revenue'] ?? 0;
    }


    // ===============================
    // ĐẾM SỐ ĐƠN THEO STATUS
    // ===============================
    public function countByStatus($status)
    {
        $conn = $this->connect();

        $stmt = $conn->prepare("
            SELECT COUNT(*) as total
            FROM orders
            WHERE status = ?
        ");

        $stmt->execute([$status]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] ?? 0;
    }
}