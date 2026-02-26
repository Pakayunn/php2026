

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-3">
                <i class="fas fa-chart-line"></i> Admin Dashboard
            </h1>
        </div>
    </div>

    <!-- ================= STATISTICS CARDS ================= -->
    <div class="row mb-4">

        <!-- Products -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Sản phẩm
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e($stats['totalProducts'] ?? 0); ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Danh mục
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e($stats['totalCategories'] ?? 0); ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Brands -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Thương hiệu
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e($stats['totalBrands'] ?? 0); ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Người dùng
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e($stats['totalUsers'] ?? 0); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= REVENUE CARDS ================= -->
    <div class="row mb-4">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                        Tổng doanh thu
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e(number_format($stats['totalRevenue'] ?? 0, 0, ',', '.')); ?> đ
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Doanh thu tháng này
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e(number_format($stats['monthlyRevenue'] ?? 0, 0, ',', '.')); ?> đ
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Tổng đơn hoàn thành
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e($stats['totalOrders'] ?? 0); ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Đơn hôm nay
                    </div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php echo e($stats['todayOrders'] ?? 0); ?>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= CHARTS ================= -->
    <div class="row">

        <!-- Category Chart -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Sản phẩm theo danh mục
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Brand Chart -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        Sản phẩm theo thương hiệu
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="brandChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        Doanh thu theo tháng
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
/* Card tổng thể */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

/* Viền trái mỏng hơn */
.border-left-primary { border-left: 4px solid #4e73df !important; }
.border-left-success { border-left: 4px solid #1cc88a !important; }
.border-left-info { border-left: 4px solid #36b9cc !important; }
.border-left-warning { border-left: 4px solid #f6c23e !important; }
.border-left-dark { border-left: 4px solid #343a40 !important; }

/* Chữ gọn hơn */
.text-xs {
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}

/* Số lớn rõ ràng hơn */
.h5 {
    font-size: 1.4rem;
}

/* Chart không quá cao */
canvas {
    max-height: 300px;
}
</style>    

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3/dist/chart.min.js"></script>
<script>

document.addEventListener("DOMContentLoaded", function () {

    /* ================= CATEGORY CHART ================= */
    const categoryData = <?php echo json_encode($chartData['productsByCategory'] ?? []); ?>;

    if (Array.isArray(categoryData) && categoryData.length > 0) {

        const labels = categoryData.map(item => item.name);
        const values = categoryData.map(item => parseInt(item.total));

        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e',
                        '#e74a3b',
                        '#858796'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }


    /* ================= BRAND CHART ================= */
    const brandData = <?php echo json_encode($chartData['productsByBrand'] ?? []); ?>;

    if (Array.isArray(brandData) && brandData.length > 0) {

        const labels = brandData.map(item => item.name);
        const values = brandData.map(item => parseInt(item.total));

        new Chart(document.getElementById('brandChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số sản phẩm',
                    data: values,
                    backgroundColor: '#1cc88a'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }


    /* ================= REVENUE CHART ================= */
    const revenueData = <?php echo json_encode($chartData['revenueByMonth'] ?? []); ?>;

    if (Array.isArray(revenueData) && revenueData.length > 0) {

        const labels = revenueData.map(item => 'Tháng ' + item.month);
        const values = revenueData.map(item => parseFloat(item.revenue));

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu (đ)',
                    data: values,
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(231,74,59,0.2)',
                    borderColor: '#e74a3b'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

});

</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/admin/dashboard.blade.php ENDPATH**/ ?>