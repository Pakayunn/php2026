


<?php $__env->startSection('title', 'Trang chủ - PHP2 MVC Shop'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Hero Section -->
    <div class="jumbotron bg-light p-5 rounded-3 mb-4">
        <h1 class="display-4"><i class="fas fa-shopping-cart"></i> Chào mừng đến với PHP2 MVC Shop!</h1>
        <hr class="my-4">
        <p>Khám phá các sản phẩm chất lượng của chúng tôi</p>
        <a class="btn btn-primary btn-lg" href="#products" role="button">
            <i class="fas fa-arrow-down"></i> Xem sản phẩm
        </a>
        <a class="btn btn-success btn-lg ms-2" href="/admin" role="button">
            <i class="fas fa-tachometer-alt"></i> Admin Panel
        </a>
    </div>

    <!-- Categories Filter -->
    <?php if(!empty($categories)): ?>
    <div class="mb-4">
        <h4 class="mb-3"><i class="fas fa-filter"></i> Danh mục sản phẩm</h4>
        <div class="btn-group flex-wrap" role="group">
            <button type="button" class="btn btn-outline-primary active">Tất cả</button>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" class="btn btn-outline-primary">
                    <?php echo e($category['name']); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Products Grid -->
    <div id="products">
        <h2 class="mb-4"><i class="fas fa-box-open"></i> Danh sách sản phẩm</h2>
        
        <?php if(!empty($products) && count($products) > 0): ?>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    <div class="card h-100 shadow-sm product-card">
                        <?php if(!empty($product['image'])): ?>
                            <img src="/uploads/products/<?php echo e($product['image']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo e($product['name']); ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/300x200?text=<?php echo e(urlencode($product['name'])); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo e($product['name']); ?>"
                                 style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo e($product['name']); ?></h5>
                            <p class="card-text text-muted small">
                                <i class="fas fa-tag"></i> <?php echo e($product['category_name'] ?? 'N/A'); ?><br>
                                <i class="fas fa-copyright"></i> <?php echo e($product['brand_name'] ?? 'N/A'); ?>

                            </p>
                            <div class="mt-auto">
                                <p class="h5 text-danger mb-2">
                                    <?php echo e(number_format($product['price'], 0, ',', '.')); ?> đ
                                </p>
                                <?php if($product['stock'] > 0): ?>
                                    <span class="badge bg-success mb-2">
                                        <i class="fas fa-check"></i> Còn hàng: <?php echo e($product['stock']); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger mb-2">
                                        <i class="fas fa-times"></i> Hết hàng
                                    </span>
                                <?php endif; ?>
                                <div class="d-grid">
                                    <a href="/home/detail/<?php echo e($product['id']); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                <h4>Chưa có sản phẩm nào</h4>
                <p>Vui lòng quay lại sau hoặc <a href="/admin">vào Admin</a> để thêm sản phẩm</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
.jumbotron {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\Php2\PHP2_MVC\app\views/home/index.blade.php ENDPATH**/ ?>