<?php

class Brand extends Model
{
    private $table = "brands";

    public function all()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data = [])
    {
        $sql = "INSERT INTO {$this->table} (name, logo, description) VALUES (:name, :logo, :description)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'] ?? '',
            'logo' => $data['logo'] ?? null,
            'description' => $data['description'] ?? ''
        ]);
    }

    public function update($id, $data = [])
    {
        $sql = "UPDATE {$this->table} SET name = :name, logo = :logo, description = :description WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'] ?? '',
            'logo' => $data['logo'] ?? null,
            'description' => $data['description'] ?? '',
            'id' => $id
        ]);
    }

    public function delete($id)
    {
        // Lấy thông tin brand để xóa logo
        $brand = $this->find($id);

        // Xóa file logo nếu có
        if ($brand && !empty($brand['logo'])) {
            $logoPath = BASE_PATH . '/public/uploads/brands/' . $brand['logo'];
            if (file_exists($logoPath)) {
                unlink($logoPath);
            }
        }

        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Đếm số sản phẩm của brand
     */
    public function countProducts($id)
    {
        $sql = "SELECT COUNT(*) FROM products WHERE brand_id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }
}
