

<?php $__env->startSection('title', $title ?? 'Trang chủ'); ?>

<?php $__env->startSection('content'); ?>

<div class="row g-4">

    <!-- ===== SIDEBAR ===== -->
    <aside class="col-12 col-lg-3">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">
                Categories
            </div>

            <div class="list-group list-group-flush">

                <a href="/" class="list-group-item active">
                    All
                </a>

                <?php if(isset($categories)): ?>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="/product/filterByCategory/<?php echo e($category['id']); ?>"
                           class="list-group-item">
                            <?php echo e($category['name']); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

            </div>
        </div>
    </aside>


    <!-- ===== PRODUCTS ===== -->
    <section class="col-12 col-lg-9">

        <h1 class="h4 mb-3">Products</h1>

        <div class="row g-3">

        <?php if(isset($products) && count($products) > 0): ?>

            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-12 col-sm-6 col-xl-4">
                <div class="card h-100 shadow-sm">

                    <!-- CLICK ẢNH → DETAIL -->
                    <a href="/home/detail/<?php echo e($product['id']); ?>">
                        <?php if(!empty($product['image'])): ?>
                            <img src="/uploads/products/<?php echo e($product['image']); ?>"
                                 class="card-img-top"
                                 style="height:200px; object-fit:cover;">
                        <?php else: ?>
                            <img src="https://picsum.photos/600/400"
                                 class="card-img-top"
                                 style="height:200px; object-fit:cover;">
                        <?php endif; ?>
                    </a>

                    <div class="card-body d-flex flex-column">

                        <!-- CLICK TÊN → DETAIL -->
                        <h5 class="card-title">
                            <a href="/home/detail/<?php echo e($product['id']); ?>"
                               class="text-decoration-none text-dark">
                                <?php echo e($product['name']); ?>

                            </a>
                        </h5>

                        <div class="fw-semibold text-danger mb-2">
                            <?php echo e(number_format($product['price'])); ?> đ
                        </div>

                        <!-- Badge biến thể (chuẩn bị nâng cấp sau) -->
                        <?php if(isset($product['has_variant']) && $product['has_variant']): ?>
                            <span class="badge bg-info mb-2">
                                Có biến thể
                            </span>
                        <?php endif; ?>

                        <div class="mt-auto d-grid gap-2">

                            <a href="/home/detail/<?php echo e($product['id']); ?>"
                               class="btn btn-sm btn-outline-dark">
                                Xem chi tiết
                            </a>

                            <?php if($product['stock'] > 0): ?>
                                <a href="/cart/add/<?php echo e($product['id']); ?>"
                                   class="btn btn-sm btn-outline-primary">
                                   Thêm vào giỏ
                                </a>
                            <?php else: ?>
                                <button class="btn btn-sm btn-secondary" disabled>
                                    Hết hàng
                                </button>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
            </div>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php else: ?>

            <div class="alert alert-info">
                Không có sản phẩm nào.
            </div>

        <?php endif; ?>

        </div>
    </section>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/home/index.blade.php ENDPATH**/ ?>