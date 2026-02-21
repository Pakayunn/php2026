

<?php $__env->startSection('content'); ?>

<div class="container mt-5">
    <div class="row">

        <!-- Ảnh -->
        <div class="col-md-6">
            <img src="<?php echo e($product['image'] ?? 'https://via.placeholder.com/500x400'); ?>"
                 class="img-fluid rounded">
        </div>

        <!-- Thông tin -->
        <div class="col-md-6">

            <h3><?php echo e($product['name']); ?></h3>

            <h4 class="text-danger">
                <?php echo e(number_format($product['price'])); ?> VNĐ
            </h4>

            <p><?php echo e($product['description'] ?? ''); ?></p>

            <!-- ===== BIẾN THỂ CỨNG ===== -->
            <div class="mb-3">
                <label class="form-label">Chọn màu:</label>
                <select class="form-select" name="variant_color">
                    <option value="Đen">Đen</option>
                    <option value="Trắng">Trắng</option>
                    <option value="Xanh">Xanh</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Dung lượng:</label>
                <select class="form-select" name="variant_storage">
                    <option value="128GB">128GB</option>
                    <option value="256GB">256GB</option>
                </select>
            </div>

            <!-- ===== NÚT HÀNH ĐỘNG ===== -->
            <div class="mt-4">
                <a href="/cart/add/<?php echo e($product['id']); ?>" class="btn btn-primary">
                    Thêm vào giỏ hàng
                </a>

                <a href="/order/buy-now/<?php echo e($product['id']); ?>" class="btn btn-danger">
                    Mua ngay
                </a>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/home/detail.blade.php ENDPATH**/ ?>