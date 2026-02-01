<?php

class Upload
{
    private $errors = [];
    private $uploadDir = '';
    private $allowedTypes = [];
    private $maxSize = 2097152; // 2MB default

    public function __construct($uploadDir = 'uploads/')
    {
        $this->uploadDir = rtrim($uploadDir, '/') . '/';
        
        // Tạo thư mục nếu chưa tồn tại
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    /**
     * Set allowed file types
     */
    public function setAllowedTypes($types = [])
    {
        $this->allowedTypes = $types;
        return $this;
    }

    /**
     * Set max file size in bytes
     */
    public function setMaxSize($bytes)
    {
        $this->maxSize = $bytes;
        return $this;
    }

    /**
     * Upload single file
     */
    public function upload($file, $fieldName = 'file')
    {
        // Reset errors
        $this->errors = [];

        // Check if file was uploaded
        if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
            $this->errors[] = "Không có file được tải lên";
            return false;
        }

        // Check for upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = $this->getUploadErrorMessage($file['error']);
            return false;
        }

        // Validate file size
        if ($file['size'] > $this->maxSize) {
            $maxSizeMB = $this->maxSize / 1048576;
            $this->errors[] = "File vượt quá dung lượng cho phép ({$maxSizeMB}MB)";
            return false;
        }

        // Validate file type
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mimeType = mime_content_type($file['tmp_name']);
        
        if (!empty($this->allowedTypes)) {
            $allowedExtensions = array_map('strtolower', $this->allowedTypes);
            
            if (!in_array($fileExtension, $allowedExtensions)) {
                $this->errors[] = "Định dạng file không được hỗ trợ. Chỉ chấp nhận: " . implode(', ', $this->allowedTypes);
                return false;
            }
        }

        // Validate image mime type
        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($mimeType, $allowedMimeTypes)) {
                $this->errors[] = "File không phải là ảnh hợp lệ";
                return false;
            }
        }

        // Generate unique filename
        $newFileName = $this->generateFileName($file['name']);
        $destination = $this->uploadDir . $newFileName;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return $newFileName;
        } else {
            $this->errors[] = "Không thể lưu file";
            return false;
        }
    }

    /**
     * Generate unique filename
     */
    private function generateFileName($originalName)
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $filename = pathinfo($originalName, PATHINFO_FILENAME);
        
        // Clean filename
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '', $filename);
        
        // Add timestamp for uniqueness
        return $filename . '_' . time() . '.' . $extension;
    }

    /**
     * Delete file
     */
    public function delete($filename)
    {
        $filePath = $this->uploadDir . $filename;
        
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        
        return false;
    }

    /**
     * Get upload error message
     */
    private function getUploadErrorMessage($errorCode)
    {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'File vượt quá dung lượng cho phép trong php.ini',
            UPLOAD_ERR_FORM_SIZE => 'File vượt quá dung lượng cho phép trong form',
            UPLOAD_ERR_PARTIAL => 'File chỉ được tải lên một phần',
            UPLOAD_ERR_NO_FILE => 'Không có file nào được tải lên',
            UPLOAD_ERR_NO_TMP_DIR => 'Thiếu thư mục tạm',
            UPLOAD_ERR_CANT_WRITE => 'Không thể ghi file vào đĩa',
            UPLOAD_ERR_EXTENSION => 'Một extension PHP đã dừng việc tải file'
        ];

        return $errors[$errorCode] ?? 'Lỗi không xác định khi tải file';
    }

    /**
     * Get errors
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Check if has errors
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Get first error
     */
    public function firstError()
    {
        return !empty($this->errors) ? $this->errors[0] : null;
    }
}