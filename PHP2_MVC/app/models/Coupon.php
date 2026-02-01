<?php
// app/models/User.php (MỞ RỘNG)

class User extends Model
{
    private $table = "users";

    public function all()
    {
        $sql = "SELECT id, username, email, full_name, phone, role, status, last_login_at, created_at 
                FROM {$this->table} ORDER BY created_at DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT id, username, email, full_name, phone, avatar, role, status, created_at 
                FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    /**
     * Tìm user theo Google ID
     */
    public function findByGoogleId($googleId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE google_id = :google_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['google_id' => $googleId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Đăng ký user mới
     */
    public function register($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (username, email, password, full_name, phone, role, status) 
                VALUES 
                (:username, :email, :password, :full_name, :phone, :role, :status)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'full_name' => $data['full_name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'role' => 'user',
            'status' => 'active'
        ]);
    }

    /**
     * Tạo hoặc cập nhật user từ Google OAuth
     */
    public function createOrUpdateFromGoogle($googleUser)
    {
        // Kiểm tra xem user đã tồn tại chưa
        $existingUser = $this->findByGoogleId($googleUser['id']);
        
        if ($existingUser) {
            // Cập nhật thông tin
            $sql = "UPDATE {$this->table} SET 
                    email = :email, 
                    full_name = :full_name, 
                    avatar = :avatar,
                    email_verified_at = NOW(),
                    last_login_at = NOW()
                    WHERE google_id = :google_id";
            
            $conn = $this->connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'email' => $googleUser['email'],
                'full_name' => $googleUser['name'],
                'avatar' => $googleUser['picture'] ?? null,
                'google_id' => $googleUser['id']
            ]);
            
            return $this->findByGoogleId($googleUser['id']);
        } else {
            // Tạo user mới
            $username = $this->generateUniqueUsername($googleUser['email']);
            
            $sql = "INSERT INTO {$this->table} 
                    (username, email, full_name, avatar, google_id, role, status, email_verified_at) 
                    VALUES 
                    (:username, :email, :full_name, :avatar, :google_id, 'user', 'active', NOW())";
            
            $conn = $this->connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'email' => $googleUser['email'],
                'full_name' => $googleUser['name'],
                'avatar' => $googleUser['picture'] ?? null,
                'google_id' => $googleUser['id']
            ]);
            
            return $this->findByGoogleId($googleUser['id']);
        }
    }

  
    private function generateUniqueUsername($email)
    {
        $username = explode('@', $email)[0];
        $originalUsername = $username;
        $counter = 1;
        
        while ($this->findByUsername($username)) {
            $username = $originalUsername . $counter;
            $counter++;
        }
        
        return $username;
    }

 
    public function update($data = [], $id)
    {
        $sql = "UPDATE {$this->table} SET 
                username = :username, 
                email = :email, 
                full_name = :full_name, 
                phone = :phone,
                role = :role, 
                status = :status 
                WHERE id = :id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'full_name' => $data['full_name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'role' => $data['role'],
            'status' => $data['status'],
            'id' => $id
        ]);
    }

    public function changePassword($userId, $newPassword)
    {
        $sql = "UPDATE {$this->table} SET password = :password WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'id' => $userId
        ]);
    }

    public function createPasswordResetToken($email)
    {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $sql = "UPDATE {$this->table} SET 
                reset_token = :token, 
                reset_token_expires_at = :expires_at 
                WHERE email = :email";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'token' => $token,
            'expires_at' => $expiresAt,
            'email' => $email
        ]);
        
        return $token;
    }

 
    public function findByResetToken($token)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE reset_token = :token 
                AND reset_token_expires_at > NOW()";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resetPassword($token, $newPassword)
    {
        $user = $this->findByResetToken($token);
        
        if (!$user) {
            return false;
        }
        
        $sql = "UPDATE {$this->table} SET 
                password = :password, 
                reset_token = NULL, 
                reset_token_expires_at = NULL 
                WHERE id = :id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'id' => $user['id']
        ]);
    }


    public function updateLastLogin($userId)
    {
        $sql = "UPDATE {$this->table} SET last_login_at = NOW() WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $userId]);
    }


    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }
}