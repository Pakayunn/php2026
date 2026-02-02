

<?php $__env->startSection('title', 'Thêm sản phẩm mới'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2><i class="fas fa-plus-circle"></i> Thêm sản phẩm mới</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/product">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="/product/store" method="POST" enctype="multipart/form-data" id="productForm">
                <div class="row">
                    <!-- Tên sản phẩm -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
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

                    <!-- Giá -->
                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control <?php echo isset($_SESSION['errors']['price']) ? 'is-invalid' : ''; ?>" 
                               id="price" 
                               name="price" 
                               value="<?php echo $_SESSION['old']['price'] ?? ''; ?>"
                               required
                               min="0"
                               step="1000">
                        <?php if(isset($_SESSION['errors']['price'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['price']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Danh mục -->
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select <?php echo isset($_SESSION['errors']['category_id']) ? 'is-invalid' : ''; ?>" 
                                id="category_id" 
                                name="category_id" 
                                required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category['id']); ?>" 
                                        <?php echo (isset($_SESSION['old']['category_id']) && $_SESSION['old']['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                    <?php echo e($category['name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if(isset($_SESSION['errors']['category_id'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['category_id']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Thương hiệu -->
                    <div class="col-md-6 mb-3">
                        <label for="brand_id" class="form-label">Thương hiệu <span class="text-danger">*</span></label>
                        <select class="form-select <?php echo isset($_SESSION['errors']['brand_id']) ? 'is-invalid' : ''; ?>" 
                                id="brand_id" 
                                name="brand_id" 
                                required>
                            <option value="">-- Chọn thương hiệu --</option>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand['id']); ?>" 
                                        <?php echo (isset($_SESSION['old']['brand_id']) && $_SESSION['old']['brand_id'] == $brand['id']) ? 'selected' : ''; ?>>
                                    <?php echo e($brand['name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if(isset($_SESSION['errors']['brand_id'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['brand_id']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Tồn kho -->
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Số lượng tồn kho</label>
                        <input type="number" 
                               class="form-control <?php echo isset($_SESSION['errors']['stock']) ? 'is-invalid' : ''; ?>" 
                               id="stock" 
                               name="stock" 
                               value="<?php echo $_SESSION['old']['stock'] ?? '0'; ?>"
                               min="0">
                        <?php if(isset($_SESSION['errors']['stock'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['stock']; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Upload ảnh -->
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Ảnh sản phẩm (JPG, PNG - Max 2MB)</label>
                        <input type="file" 
                               class="form-control <?php echo isset($_SESSION['errors']['image']) ? 'is-invalid' : ''; ?>" 
                               id="image" 
                               name="image" 
                               accept="image/jpeg,image/png"
                               onchange="previewImage(this)">
                        <?php if(isset($_SESSION['errors']['image'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['image']; ?></div>
                        <?php endif; ?>
                        <div id="imagePreview" class="mt-2"></div>
                    </div>

                    <!-- Mô tả -->
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4"><?php echo $_SESSION['old']['description'] ?? ''; ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/product" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu sản phẩm
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
// Preview image before upload
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size (2MB)
        if (file.size > 2097152) {
            Swal.fire({
                icon: 'error',
                title: 'File quá lớn!',
                text: 'Vui lòng chọn ảnh nhỏ hơn 2MB'
            });
            input.value = '';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Định dạng không hợp lệ!',
                text: 'Chỉ chấp nhận file JPG hoặc PNG'
            });
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px;">`;
        };
        reader.readAsDataURL(file);
    }
}

// Form validation
document.getElementById('productForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const price = document.getElementById('price').value;
    const categoryId = document.getElementById('category_id').value;
    const brandId = document.getElementById('brand_id').value;
    
    if (!name || name.length < 3) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Tên sản phẩm phải có ít nhất 3 ký tự', 'error');
        return false;
    }
    
    if (!price || price <= 0) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Giá phải lớn hơn 0', 'error');
        return false;
    }
    
    if (!categoryId) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Vui lòng chọn danh mục', 'error');
        return false;
    }
    
    if (!brandId) {
        e.preventDefault();
        Swal.fire('Lỗi!', 'Vui lòng chọn thương hiệu', 'error');
        return false;
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\Php2\PHP2_MVC\app\views/product/create.blade.php ENDPATH**/ ?>