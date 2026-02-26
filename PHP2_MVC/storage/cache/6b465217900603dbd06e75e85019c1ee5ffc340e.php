

<?php $__env->startSection('title','Sản phẩm yêu thích'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">

    <h4 class="mb-4">
        <i class="fas fa-heart text-danger me-2"></i>
        Sản phẩm yêu thích
    </h4>

    <?php if(empty($items)): ?>
        <div class="alert alert-info">
            Bạn chưa có sản phẩm yêu thích nào.
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">

                        
                        <a href="/product/detail/<?php echo e($item['id']); ?>">
                            <img src="<?php echo e($item['image'] ?? 'https://via.placeholder.com/300x300'); ?>"
                                 class="card-img-top"
                                 style="height:220px; object-fit:cover;">
                        </a>

                        <div class="card-body d-flex flex-column">
                            <h6 class="mb-2">
                                <a href="/product/detail/<?php echo e($item['id']); ?>"
                                   class="text-decoration-none text-dark">
                                    <?php echo e($item['name']); ?>

                                </a>
                            </h6>

                            <p class="text-danger fw-bold mt-auto">
                                <?php echo e(number_format($item['price'],0,',','.')); ?> đ
                            </p>
                        </div>

                        <div class="card-footer bg-white border-0">
                            <a href="/wishlist/remove/<?php echo e($item['id']); ?>"
                               class="btn btn-sm btn-outline-danger w-100"
                               onclick="return confirm('Xóa sản phẩm này khỏi yêu thích?')">
                                <i class="fas fa-trash me-1"></i>
                                Xóa khỏi yêu thích
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/wishlist/index.blade.php ENDPATH**/ ?>