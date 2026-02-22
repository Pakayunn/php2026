<?php

class Cart extends Model
{
    /**
     * ==========================================
     * Tìm sản phẩm trong cart theo user + product
     * ==========================================
     */
    public function findByUserAndProduct($user_id, $product_id)
    {
        $conn = $this->connect();

        $sql = "SELECT * FROM cart 
                WHERE user_id = :user_id 
                AND product_id = :product_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id,
            ':product_id' => $product_id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * ==========================================
     * Thêm sản phẩm vào cart
     * ==========================================
     */
    public function insert($data)
    {
        $conn = $this->connect();

        $sql = "INSERT INTO cart 
                (user_id, product_id, quantity, price, created_at, updated_at)
                VALUES (:user_id, :product_id, :quantity, :price, NOW(), NOW())";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':user_id' => $data['user_id'],
            ':product_id' => $data['product_id'],
            ':quantity' => $data['quantity'],
            ':price' => $data['price']
        ]);
    }

    /**
     * ==========================================
     * Cập nhật số lượng
     * ==========================================
     */
    public function updateQuantity($id, $quantity)
    {
        $conn = $this->connect();

        $sql = "UPDATE cart 
                SET quantity = :quantity,
                    updated_at = NOW()
                WHERE id = :id";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':quantity' => $quantity,
            ':id' => $id
        ]);
    }

    /**
     * ==========================================
     * Lấy cart theo user (JOIN sản phẩm)
     * ==========================================
     */
    public function getByUser($user_id)
    {
        $conn = $this->connect();

        $sql = "SELECT c.*, p.name, p.image
                FROM cart c
                JOIN products p ON p.id = c.product_id
                WHERE c.user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * ==========================================
     * Xóa 1 sản phẩm khỏi cart
     * ==========================================
     */
    public function delete($id)
    {
        $conn = $this->connect();

        $sql = "DELETE FROM cart WHERE id = :id";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    /**
     * ==========================================
     * Đếm tổng quantity (badge)
     * ==========================================
     */
    public function countByUser($user_id)
    {
        $conn = $this->connect();

        $sql = "SELECT SUM(quantity) as total 
                FROM cart 
                WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $user_id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] ?? 0;
    }

    /**
     * ==========================================
     * Xóa toàn bộ cart (dùng cho checkout)
     * ==========================================
     */
    public function clearCart($user_id)
    {
        $conn = $this->connect();

        $sql = "DELETE FROM cart WHERE user_id = :user_id";

        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':user_id' => $user_id
        ]);
    }
}