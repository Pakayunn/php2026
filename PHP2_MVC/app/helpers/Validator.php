<?php

class Validator
{
    private $errors = [];
    private $data = [];

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Validate required fields
     */
    public function required($fields)
    {
        foreach ($fields as $field) {
            if (empty($this->data[$field])) {
                $this->errors[$field] = ucfirst($field) . " là bắt buộc";
            }
        }
        return $this;
    }

    /**
     * Validate email
     */
    public function email($field)
    {
        if (!empty($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = "Email không hợp lệ";
        }
        return $this;
    }

    /**
     * Validate min length
     */
    public function min($field, $length)
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->errors[$field] = ucfirst($field) . " phải có ít nhất {$length} ký tự";
        }
        return $this;
    }

    /**
     * Validate max length
     */
    public function max($field, $length)
    {
        if (!empty($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->errors[$field] = ucfirst($field) . " không được quá {$length} ký tự";
        }
        return $this;
    }

    /**
     * Validate numeric
     */
    public function numeric($field)
    {
        if (!empty($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->errors[$field] = ucfirst($field) . " phải là số";
        }
        return $this;
    }

    /**
     * Validate positive number
     */
    public function positive($field)
    {
        if (!empty($this->data[$field]) && $this->data[$field] <= 0) {
            $this->errors[$field] = ucfirst($field) . " phải là số dương";
        }
        return $this;
    }

    /**
     * Validate unique in database
     */
    public function unique($field, $table, $excludeId = null)
    {
        if (!empty($this->data[$field])) {
            $conn = Database::connect();
            
            if ($excludeId) {
                // Khi update, loại trừ ID hiện tại
                $sql = "SELECT COUNT(*) FROM {$table} WHERE {$field} = :{$field} AND id != :id";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    $field => $this->data[$field],
                    'id' => $excludeId
                ]);
            } else {
                // Khi tạo mới, chỉ kiểm tra field
                $sql = "SELECT COUNT(*) FROM {$table} WHERE {$field} = :{$field}";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    $field => $this->data[$field]
                ]);
            }
            
            if ($stmt->fetchColumn() > 0) {
                $this->errors[$field] = ucfirst($field) . " đã tồn tại";
            }
        }
        return $this;
    }

    /**
     * Check if validation passed
     */
    public function passes()
    {
        return empty($this->errors);
    }

    /**
     * Check if validation failed
     */
    public function fails()
    {
        return !$this->passes();
    }

    /**
     * Get all errors
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Get first error
     */
    public function firstError($field = null)
    {
        if ($field) {
            return $this->errors[$field] ?? null;
        }
        return !empty($this->errors) ? reset($this->errors) : null;
    }
}