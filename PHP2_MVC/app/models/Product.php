<?php

class Product extends Model
{
    private $table = "products";

    /**
     * Lấy tất cả sản phẩm với thông tin category và brand
     */
    public function all()
    {
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN brands b ON p.brand_id = b.id 
                ORDER BY p.created_at DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy sản phẩm theo ID
     */
    public function find($id)
    {
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN brands b ON p.brand_id = b.id 
                WHERE p.id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy sản phẩm mới nhất
     */
    public function getRecent($limit = 5)
    {
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN brands b ON p.brand_id = b.id 
                ORDER BY p.created_at DESC 
                LIMIT :limit";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Tạo sản phẩm mới
     */
    public function create($data = [])
    {
        $sql = "INSERT INTO {$this->table} 
                (name, price, category_id, brand_id, description, image, stock) 
                VALUES 
                (:name, :price, :category_id, :brand_id, :description, :image, :stock)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            'name' => $data['name'] ?? '',
            'price' => $data['price'] ?? 0,
            'category_id' => $data['category_id'] ?? null,
            'brand_id' => $data['brand_id'] ?? null,
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? null,
            'stock' => $data['stock'] ?? 0,
        ]);
    }

    /**
     * Cập nhật sản phẩm
     */
    public function update($id, $data = [])
    {
        $sql = "UPDATE {$this->table} 
                SET name = :name, 
                    price = :price, 
                    category_id = :category_id, 
                    brand_id = :brand_id, 
                    description = :description, 
                    image = :image, 
                    stock = :stock 
                WHERE id = :id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            'name' => $data['name'] ?? '',
            'price' => $data['price'] ?? 0,
            'category_id' => $data['category_id'] ?? null,
            'brand_id' => $data['brand_id'] ?? null,
            'description' => $data['description'] ?? '',
            'image' => $data['image'] ?? null,
            'stock' => $data['stock'] ?? 0,
            'id' => $id
        ]);
    }

    /**
     * Xóa sản phẩm
     */
    public function delete($id)
    {
        // Lấy thông tin sản phẩm để xóa ảnh
        $product = $this->find($id);
        
        // Xóa file ảnh nếu có
        if ($product && !empty($product['image'])) {
            $imagePath = BASE_PATH . '/public/uploads/products/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Xóa bản ghi trong database
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Tìm kiếm sản phẩm
     */
    public function search($keyword)
    {
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN brands b ON p.brand_id = b.id 
                WHERE p.name LIKE :keyword 
                   OR p.description LIKE :keyword 
                ORDER BY p.created_at DESC";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['keyword' => "%{$keyword}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lọc sản phẩm theo category
     */
    public function filterByCategory($categoryId)
    {
        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN brands b ON p.brand_id = b.id 
                WHERE p.category_id = :category_id 
                ORDER BY p.created_at DESC";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['category_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}