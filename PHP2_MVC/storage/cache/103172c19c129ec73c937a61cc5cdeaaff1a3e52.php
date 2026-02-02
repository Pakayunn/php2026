

<?php $__env->startSection('title', 'Sửa sản phẩm'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h2><i class="fas fa-edit"></i> Sửa sản phẩm</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/product">Sản phẩm</a></li>
                    <li class="breadcrumb-item active">Sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <form action="/product/update/<?php echo e($product['id']); ?>" method="POST" enctype="multipart/form-data" id="productForm">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control <?php echo isset($_SESSION['errors']['name']) ? 'is-invalid' : ''; ?>" 
                               id="name" 
                               name="name" 
                               value="<?php echo $_SESSION['old']['name'] ?? $product['name']; ?>"
                               required
                               minlength="3">
                        <?php if(isset($_SESSION['errors']['name'])): ?>
                            <div class="invalid-feedback"><?php echo $_SESSION['errors']['name']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" 
                               class="form-control" 
                               id="price" 
                               name="price" 
                               value="<?php echo $_SESSION['old']['price'] ?? $product['price']; ?>"
                               required
                               min="0">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category['id']); ?>" 
                                        <?php echo e(($product['category_id'] == $category['id']) ? 'selected' : ''); ?>>
                                    <?php echo e($category['name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="brand_id" class="form-label">Thương hiệu <span class="text-danger">*</span></label>
                        <select class="form-select" id="brand_id" name="brand_id" required>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($brand['id']); ?>" 
                                        <?php echo e(($product['brand_id'] == $brand['id']) ? 'selected' : ''); ?>>
                                    <?php echo e($brand['name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label">Số lượng tồn kho</label>
                        <input type="number" 
                               class="form-control" 
                               id="stock" 
                               name="stock" 
                               value="<?php echo $_SESSION['old']['stock'] ?? $product['stock']; ?>"
                               min="0">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Ảnh sản phẩm (JPG, PNG - Max 2MB)</label>
                        <input type="file" 
                               class="form-control" 
                               id="image" 
                               name="image" 
                               accept="image/jpeg,image/png"
                               onchange="previewImage(this)">
                        
                        <?php if(!empty($product['image'])): ?>
                            <div class="mt-2">
                                <p class="text-muted small">Ảnh hiện tại:</p>
                                <img src="/uploads/products/<?php echo e($product['image']); ?>" 
                                     alt="<?php echo e($product['name']); ?>" 
                                     class="img-thumbnail" 
                                     style="max-width: 150px;">
                            </div>
                        <?php endif; ?>
                        <div id="imagePreview" class="mt-2"></div>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4"><?php echo $_SESSION['old']['description'] ?? $product['description']; ?></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="/product" class="btn btn-secondary">
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
            preview.innerHTML = `<p class="text-muted small">Ảnh mới:</p><img src="${e.target.result}" class="img-thumbnail" style="max-width: 150px;">`;
        };
        reader.readAsDataURL(file);
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\Php2\PHP2_MVC\app\views/product/edit.blade.php ENDPATH**/ ?>