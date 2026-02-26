

<?php $__env->startSection('content'); ?>

<div class="container mt-5">
    <div class="row">

        <!-- ẢNH -->
        <div class="col-md-6 position-relative">

            
            <?php if(isset($_SESSION['user'])): ?>
                <a href="/wishlist/add/<?php echo e($product['id']); ?>"
                   class="btn position-absolute top-0 end-0 m-2 
                   <?php echo e(!empty($product['is_liked']) ? 'btn-danger' : 'btn-outline-danger'); ?>"
                   style="z-index:10;">
                    <i class="fas fa-heart"></i>
                </a>
            <?php endif; ?>

            <img src="<?php echo e($product['image'] ?? 'https://via.placeholder.com/500x400'); ?>"
                 class="img-fluid rounded shadow-sm"
                 style="width:100%; object-fit:cover;">
        </div>


        <!-- THÔNG TIN -->
        <div class="col-md-6">

            <h3 class="fw-bold"><?php echo e($product['name']); ?></h3>

            <h4 class="text-danger mb-3">
                <?php echo e(number_format($product['price'])); ?> VNĐ
            </h4>

            <p class="text-muted">
                <?php echo e($product['description'] ?? ''); ?>

            </p>


            <!-- ===== BIẾN THỂ CỨNG ===== -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Chọn màu:</label>
                <select class="form-select" name="variant_color">
                    <option value="Đen">Đen</option>
                    <option value="Trắng">Trắng</option>
                    <option value="Xanh">Xanh</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Dung lượng:</label>
                <select class="form-select" name="variant_storage">
                    <option value="128GB">128GB</option>
                    <option value="256GB">256GB</option>
                </select>
            </div>


            <!-- ===== NÚT HÀNH ĐỘNG ===== -->
            <div class="mt-4 d-flex gap-2">

                <?php if($product['stock'] > 0): ?>
                    <a href="/cart/add/<?php echo e($product['id']); ?>" 
                       class="btn btn-primary">
                        Thêm vào giỏ hàng
                    </a>

                    <a href="/order/buy-now/<?php echo e($product['id']); ?>" 
                       class="btn btn-danger">
                        Mua ngay
                    </a>
                <?php else: ?>
                    <button class="btn btn-secondary" disabled>
                        Hết hàng
                    </button>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/home/detail.blade.php ENDPATH**/ ?>