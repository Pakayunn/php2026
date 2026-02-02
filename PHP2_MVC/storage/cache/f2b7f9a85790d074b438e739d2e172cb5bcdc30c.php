

<?php $__env->startSection('title', 'Thêm danh mục mới'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2><i class="fas fa-plus-circle"></i> Thêm danh mục mới</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/category">Danh mục</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="/category/store" method="POST" id="categoryForm">
                <div class="row">
                    <!-- Tên danh mục -->
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" 
                               id="name" 
                               name="name" 
                               value="<?php echo $_SESSION['old']['name'] ?? ''; ?>"
                               required
                               minlength="3"
                               maxlength="255">
                        <?php if(isset($_SESSION['errors']['name'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['name']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Mô tả -->
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Mô tả danh mục</label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4"><?php echo $_SESSION['old']['description'] ?? ''; ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/category" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu danh mục
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
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    
    if (!name || name.length < 3) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Tên danh mục phải có ít nhất 3 ký tự', 'error');
        return false;
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\Php2\PHP2_MVC\app\views/category/create.blade.php ENDPATH**/ ?>