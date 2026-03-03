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

    /**
     * Đếm tổng số sản phẩm
     */
    public function count()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    /**
     * Lấy các sản phẩm mới nhất (alias cho getRecent)
     */
    public function latest($limit = 5)
    {
        return $this->getRecent($limit);
    }

    /**
     * Đếm sản phẩm theo category
     */
    public function countByCategory()
    {
        $sql = "SELECT c.name, COUNT(p.id) as count 
                FROM {$this->table} p 
                RIGHT JOIN categories c ON p.category_id = c.id 
                GROUP BY c.id, c.name 
                ORDER BY count DESC";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($results as $row) {
            $data[$row['name']] = $row['count'];
        }
        return $data;
    }

    /**
     * Đếm sản phẩm theo brand
     */
    public function countByBrand()
    {
        $sql = "SELECT b.name, COUNT(p.id) as count 
                FROM {$this->table} p 
                RIGHT JOIN brands b ON p.brand_id = b.id 
                GROUP BY b.id, b.name 
                ORDER BY count DESC";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];
        foreach ($results as $row) {
            $data[$row['name']] = $row['count'];
        }
        return $data;
    }
    public function updateStock($productId, $newStock)
    {
        $pdo = $this->connect();

        $stmt = $pdo->prepare("UPDATE products SET stock = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$newStock, $productId]);
    }
        /**
     * Lấy sản phẩm liên quan (không ảnh hưởng code cũ)
     */
    public function getRelated($categoryId, $currentId, $limit = 4)
{
    $conn = $this->connect();

    $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
            FROM {$this->table} p 
            LEFT JOIN categories c ON p.category_id = c.id 
            LEFT JOIN brands b ON p.brand_id = b.id 
            WHERE p.category_id = ?
            AND p.id != ?
            ORDER BY p.created_at DESC
            LIMIT $limit";   // bỏ bind LIMIT

    $stmt = $conn->prepare($sql);
    $stmt->execute([$categoryId, $currentId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


public function getRandomExcept($productId, $limit = 4)
{
    $conn = $this->connect();

    $sql = "SELECT *
            FROM {$this->table}
            WHERE id != ?
            ORDER BY RAND()
            LIMIT $limit";   // bỏ bind LIMIT

    $stmt = $conn->prepare($sql);
    $stmt->execute([$productId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function filterAdvanced($filters = [])
{
    $conn = $this->connect();

    $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            WHERE 1=1";

    $params = [];

    // Lọc theo category
    if (!empty($filters['category_id'])) {
        $sql .= " AND p.category_id = :category_id";
        $params[':category_id'] = $filters['category_id'];
    }

    // Lọc theo brand
    if (!empty($filters['brand_id'])) {
        $sql .= " AND p.brand_id = :brand_id";
        $params[':brand_id'] = $filters['brand_id'];
    }

    // Lọc theo giá tối thiểu
    if (!empty($filters['min'])) {
        $sql .= " AND p.price >= :min";
        $params[':min'] = $filters['min'];
    }

    // Lọc theo giá tối đa
    if (!empty($filters['max'])) {
        $sql .= " AND p.price <= :max";
        $params[':max'] = $filters['max'];
    }

    // Tìm theo từ khóa
    if (!empty($filters['keyword'])) {
        $sql .= " AND (p.name LIKE :keyword OR p.description LIKE :keyword)";
        $params[':keyword'] = "%" . $filters['keyword'] . "%";
    }

    // Sắp xếp
    if (!empty($filters['sort'])) {
        switch ($filters['sort']) {
            case 'price_asc':
                $sql .= " ORDER BY p.price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY p.price DESC";
                break;
            case 'newest':
                $sql .= " ORDER BY p.created_at DESC";
                break;
            default:
                $sql .= " ORDER BY p.created_at DESC";
        }
    } else {
        $sql .= " ORDER BY p.created_at DESC";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function paginate($limit, $offset)
{
    $sql = "SELECT p.*, c.name as category_name, b.name as brand_name 
            FROM {$this->table} p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN brands b ON p.brand_id = b.id
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset";

    $conn = $this->connect();
    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}