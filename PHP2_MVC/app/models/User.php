<?php

class User extends Model
{
    private $table = "users";

    public function all()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
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
        $sql = "INSERT INTO {$this->table} (username, email, password, full_name, role, status) 
                VALUES (:username, :email, :password, :full_name, :role, :status)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            'username' => $data['username'] ?? '',
            'email' => $data['email'] ?? '',
            'password' => password_hash($data['password'] ?? '', PASSWORD_DEFAULT),
            'full_name' => $data['full_name'] ?? '',
            'role' => $data['role'] ?? 'user',
            'status' => $data['status'] ?? 'active'
        ]);
    }

    public function update($id, $data = [])
    {
        // Nếu có password mới thì hash, không thì giữ nguyên
        if (!empty($data['password'])) {
            $sql = "UPDATE {$this->table} 
                    SET username = :username, 
                        email = :email, 
                        password = :password, 
                        full_name = :full_name, 
                        role = :role, 
                        status = :status 
                    WHERE id = :id";
            
            $params = [
                'username' => $data['username'] ?? '',
                'email' => $data['email'] ?? '',
                'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                'full_name' => $data['full_name'] ?? '',
                'role' => $data['role'] ?? 'user',
                'status' => $data['status'] ?? 'active',
                'id' => $id
            ];
        } else {
            $sql = "UPDATE {$this->table} 
                    SET username = :username, 
                        email = :email, 
                        full_name = :full_name, 
                        role = :role, 
                        status = :status 
                    WHERE id = :id";
            
            $params = [
                'username' => $data['username'] ?? '',
                'email' => $data['email'] ?? '',
                'full_name' => $data['full_name'] ?? '',
                'role' => $data['role'] ?? 'user',
                'status' => $data['status'] ?? 'active',
                'id' => $id
            ];
        }
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Tìm user theo email
     */
    public function findByEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Tìm user theo username
     */
    public function findByUsername($username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE username = :username";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}