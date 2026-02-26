<?php

class Wishlist extends Model
{
    protected $table = "wishlists";

    public function add($userId, $productId)
    {
        $sql = "INSERT IGNORE INTO {$this->table} (user_id, product_id) VALUES (?, ?)";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$userId, $productId]);
    }

    public function remove($userId, $productId)
    {
        $sql = "DELETE FROM {$this->table} WHERE user_id = ? AND product_id = ?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$userId, $productId]);
    }

    public function getByUser($userId)
    {
        $sql = "SELECT p.* 
                FROM wishlists w
                JOIN products p ON w.product_id = p.id
                WHERE w.user_id = ?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isLiked($userId, $productId)
    {
        $sql = "SELECT 1 FROM {$this->table} 
                WHERE user_id = ? AND product_id = ? 
                LIMIT 1";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$userId, $productId]);

        return $stmt->fetch() ? true : false;
    }
}