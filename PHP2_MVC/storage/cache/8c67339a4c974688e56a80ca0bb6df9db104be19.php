

<?php $__env->startSection('title', 'Sửa người dùng'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2><i class="fas fa-edit"></i> Sửa người dùng</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/user">Người dùng</a></li>
                    <li class="breadcrumb-item active">Sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="/user/update/<?php echo e($user['id']); ?>" method="POST" id="userForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo isset($_SESSION['errors']['username']) ? 'is-invalid' : ''; ?>" 
                               id="username" 
                               name="username" 
                               value="<?php echo $_SESSION['old']['username'] ?? $user['username']; ?>"
                               required
                               minlength="3">
                        <?php if(isset($_SESSION['errors']['username'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['username']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               class="form-control <?php echo isset($_SESSION['errors']['email']) ? 'is-invalid' : ''; ?>" 
                               id="email" 
                               name="email" 
                               value="<?php echo $_SESSION['old']['email'] ?? $user['email']; ?>"
                               required>
                        <?php if(isset($_SESSION['errors']['email'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['email']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="full_name" class="form-label">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="full_name" 
                               name="full_name" 
                               value="<?php echo $_SESSION['old']['full_name'] ?? $user['full_name']; ?>"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                        <input type="password" 
                               class="form-control <?php echo isset($_SESSION['errors']['password']) ? 'is-invalid' : ''; ?>" 
                               id="password" 
                               name="password" 
                               minlength="6">
                        <?php if(isset($_SESSION['errors']['password'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['password']; ?></div>
                        <?php endif; ?>
                        <small class="text-muted">Tối thiểu 6 ký tự</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user" <?php echo e(($user['role'] == 'user') ? 'selected' : ''); ?>>User</option>
                            <option value="admin" <?php echo e(($user['role'] == 'admin') ? 'selected' : ''); ?>>Admin</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active" <?php echo e(($user['status'] == 'active') ? 'selected' : ''); ?>>Hoạt động</option>
                            <option value="inactive" <?php echo e(($user['status'] == 'inactive') ? 'selected' : ''); ?>>Khóa</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/user" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php unset($_SESSION['old'], $_SESSION['errors']); ?>

<script>
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
    
    if (password && password.length < 6) {
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hihi\php2026\PHP2_MVC\app\views/user/edit.blade.php ENDPATH**/ ?>