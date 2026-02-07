

<?php $__env->startSection('title', 'Sửa thương hiệu'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2><i class="fas fa-edit"></i> Sửa thương hiệu</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/brand">Thương hiệu</a></li>
                    <li class="breadcrumb-item active">Sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="/brand/update/<?php echo e($brand['id']); ?>" method="POST" enctype="multipart/form-data" id="brandForm">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Tên thương hiệu <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" 
                               id="name" 
                               name="name" 
                               value="<?php echo $_SESSION['old']['name'] ?? $brand['name']; ?>"
                               required
                               minlength="2">
                        <?php if(isset($_SESSION['errors']['name'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['name']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="logo" class="form-label">Logo thương hiệu (JPG, PNG - Max 2MB)</label>
                        <input type="file" 
                               class="form-control" 
                               id="logo" 
                               name="logo" 
                               accept="image/jpeg,image/png"
                               onchange="previewImage(this)">
                        
                        <?php if(!empty($brand['logo'])): ?>
                            <div class="mt-2">
                                <p class="text-muted small">Logo hiện tại:</p>
                                <img src="/uploads/brands/<?php echo e($brand['logo']); ?>" 
                                     alt="<?php echo e($brand['name']); ?>" 
                                     class="img-thumbnail" 
                                     style="max-width: 150px;">
                            </div>
                        <?php endif; ?>
                        <div id="imagePreview" class="mt-2"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Mô tả thương hiệu</label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4"><?php echo $_SESSION['old']['description'] ?? $brand['description']; ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/brand" class="btn btn-secondary">
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
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        if (file.size > 2097152) {
            Swal.fire('Lỗi!', 'File quá lớn! Tối đa 2MB', 'error');
            input.value = '';
            return;
        }
        
        const allowedTypes = ['image/jpeg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire('Lỗi!', 'Chỉ chấp nhận JPG hoặc PNG', 'error');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<p class="text-muted small">Logo mới:</p><img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px;">`;
        };
        reader.readAsDataURL(file);
    }
}

document.getElementById('brandForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    
    if (!name || name.length < 2) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Tên thương hiệu phải có ít nhất 2 ký tự', 'error');
        return false;
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hihi\php2026\PHP2_MVC\app\views/brand/edit.blade.php ENDPATH**/ ?>