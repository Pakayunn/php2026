@extends('layouts.master')

@section('title', 'Thêm người dùng mới')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2><i class="fas fa-plus-circle"></i> Thêm người dùng mới</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/user">Người dùng</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="/user/store" method="POST" id="userForm">
                <div class="row">
                    <!-- Username -->
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo isset($_SESSION['errors']['username']) ? 'is-invalid' : ''; ?>" 
                               id="username" 
                               name="username" 
                               value="<?php echo $_SESSION['old']['username'] ?? ''; ?>"
                               required
                               minlength="3"
                               maxlength="100">
                        <?php if(isset($_SESSION['errors']['username'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['username']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control <?php echo isset($_SESSION['errors']['email']) ? 'is-invalid' : ''; ?>" 
                               id="email" 
                               name="email" 
                               value="<?php echo $_SESSION['old']['email'] ?? ''; ?>"
                               required>
                        <?php if(isset($_SESSION['errors']['email'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['email']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Họ tên -->
                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo isset($_SESSION['errors']['full_name']) ? 'is-invalid' : ''; ?>" 
                               id="full_name" 
                               name="full_name" 
                               value="<?php echo $_SESSION['old']['full_name'] ?? ''; ?>"
                               required>
                        <?php if(isset($_SESSION['errors']['full_name'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['full_name']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Mật khẩu -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control <?php echo isset($_SESSION['errors']['password']) ? 'is-invalid' : ''; ?>" 
                               id="password" 
                               name="password" 
                               required
                               minlength="6">
                        <?php if(isset($_SESSION['errors']['password'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['password']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Vai trò -->
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                        <select class="form-select" 
                                id="role" 
                                name="role" 
                                required>
                            <option value="user" <?php echo (isset($_SESSION['old']['role']) && $_SESSION['old']['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo (isset($_SESSION['old']['role']) && $_SESSION['old']['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>

                    <!-- Trạng thái -->
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select class="form-select" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="active" <?php echo (isset($_SESSION['old']['status']) && $_SESSION['old']['status'] == 'active') ? 'selected' : 'selected'; ?>>Hoạt động</option>
                            <option value="inactive" <?php echo (isset($_SESSION['old']['status']) && $_SESSION['old']['status'] == 'inactive') ? 'selected' : ''; ?>>Khóa</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/user" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu người dùng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
// Clear old input and errors
unset($_SESSION['old'], $_SESSION['errors']);
?>

<script>
// Form validation
document.getElementById('userForm').addEventListener('submit', function(e) {
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const fullName = document.getElementById('full_name').value.trim();
    
    if (!username || username.length < 3) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Username phải có ít nhất 3 ký tự', 'error');
        return false;
    }
    
    if (!email) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Vui lòng nhập email', 'error');
        return false;
    }
    
    if (!password || password.length < 6) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Mật khẩu phải có ít nhất 6 ký tự', 'error');
        return false;
    }
    
    if (!fullName) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Vui lòng nhập họ tên', 'error');
        return false;
    }
});
</script>
@endsection