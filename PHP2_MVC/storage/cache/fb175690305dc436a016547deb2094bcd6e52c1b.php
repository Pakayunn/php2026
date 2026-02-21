

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3"><i class="fas fa-chart-line"></i> Admin Dashboard</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Sản phẩm</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['totalProducts'] ?? 0); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Danh mục</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['totalCategories'] ?? 0); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Thương hiệu</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['totalBrands'] ?? 0); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Người dùng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['totalUsers'] ?? 0); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Products by Category Chart -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sản phẩm theo danh mục</h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Products by Brand Chart -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Sản phẩm theo thương hiệu</h6>
                </div>
                <div class="card-body">
                    <canvas id="brandChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sản phẩm mới nhất</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Danh mục</th>
                                    <th>Thương hiệu</th>
                                    <th>Tồn kho</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($stats['recentProducts'])): ?>
                                    <?php $__currentLoopData = $stats['recentProducts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($product['id'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($product['name'] ?? 'N/A'); ?></td>
                                        <td><?php echo e(isset($product['price']) ? number_format($product['price'], 0, ',', '.') : 0); ?> đ</td>
                                        <td><?php echo e($product['category_name'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($product['brand_name'] ?? 'N/A'); ?></td>
                                        <td><?php echo e($product['stock'] ?? 0); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Chưa có sản phẩm nào</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df!important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a!important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc!important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e!important;
}
</style>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3/dist/chart.min.js"></script>
<script>
    // Chart sản phẩm theo danh mục
    const categoryData = <?php echo json_encode($chartData['productsByCategory'] ?? []); ?>;
    if (categoryData && Object.keys(categoryData).length > 0) {
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCategory, {
            type: 'pie',
            data: {
                labels: Object.keys(categoryData),
                datasets: [{
                    data: Object.values(categoryData),
                    backgroundColor: [
                        '#4e73df', '#858796', '#1cc88a', '#36b9cc',
                        '#f6c23e', '#e74a3b', '#fd7e14', '#6f42c1'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // Chart sản phẩm theo thương hiệu
    const brandData = <?php echo json_encode($chartData['productsByBrand'] ?? []); ?>;
    if (brandData && Object.keys(brandData).length > 0) {
        const ctxBrand = document.getElementById('brandChart').getContext('2d');
        new Chart(ctxBrand, {
            type: 'bar',
            data: {
                labels: Object.keys(brandData),
                datasets: [{
                    label: 'Sản phẩm',
                    data: Object.values(brandData),
                    backgroundColor: '#4e73df',
                    borderColor: '#224abe',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } }
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/admin/dashboard.blade.php ENDPATH**/ ?>