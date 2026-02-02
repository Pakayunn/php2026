<?php

class Category extends Model
{
    private $table = "categories";

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
        $sql = "INSERT INTO {$this->table} (name, description) VALUES (:name, :description)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? ''
        ]);
    }

    public function update($id, $data = [])
    {
        $sql = "UPDATE {$this->table} SET name = :name, description = :description WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'] ?? '',
            'description' => $data['description'] ?? '',
            'id' => $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Đếm số sản phẩm trong category
     */
    public function countProducts($id)
    {
        $sql = "SELECT COUNT(*) FROM products WHERE category_id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }
}