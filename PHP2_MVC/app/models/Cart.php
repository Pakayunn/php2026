<?php
// app/models/Cart.php

class Cart extends Model
{
    private $table = "cart";

    /**
     * Lấy tất cả sản phẩm trong giỏ hàng của user
     */
    public function getCartByUserId($userId)
    {
        $sql = "SELECT c.*, p.name, p.image, p.stock, p.status 
                FROM {$this->table} c 
                INNER JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = :user_id 
                ORDER BY c.created_at DESC";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart($userId, $productId, $quantity, $price)
    {
        // Kiểm tra xem sản phẩm đã có trong giỏ chưa
        $existing = $this->findByUserAndProduct($userId, $productId);
        
        if ($existing) {
            // Nếu có rồi thì tăng số lượng
            return $this->updateQuantity($existing['id'], $existing['quantity'] + $quantity);
        } else {
            // Nếu chưa có thì thêm mới
            $sql = "INSERT INTO {$this->table} (user_id, product_id, quantity, price) 
                    VALUES (:user_id, :product_id, :quantity, :price)";
            
            $conn = $this->connect();
            $stmt = $conn->prepare($sql);
            return $stmt->execute([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price
            ]);
        }
    }

    /**
     * Tìm sản phẩm trong giỏ của user
     */
    public function findByUserAndProduct($userId, $productId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = :user_id AND product_id = :product_id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ
     */
    public function updateQuantity($cartId, $quantity)
    {
        $sql = "UPDATE {$this->table} SET quantity = :quantity WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'quantity' => $quantity,
            'id' => $cartId
        ]);
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeItem($cartId)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $cartId]);
    }

    /**
     * Xóa toàn bộ giỏ hàng của user
     */
    public function clearCart($userId)
    {
        $sql = "DELETE FROM {$this->table} WHERE user_id = :user_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['user_id' => $userId]);
    }

    /**
     * Đếm số lượng sản phẩm trong giỏ
     */
    public function countItems($userId)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE user_id = :user_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalAmount($userId)
    {
        $sql = "SELECT SUM(quantity * price) as total FROM {$this->table} WHERE user_id = :user_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}