

<?php $__env->startSection('content'); ?>
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Chi tiết đơn #<?php echo e($order['id']); ?></h3>
        <a href="/" class="btn btn-secondary">
            ← Quay lại trang chủ
        </a>
    </div>

    <p><strong>Trạng thái:</strong> <?php echo e($order['status']); ?></p>
    <p><strong>Ngày đặt:</strong> <?php echo e($order['created_at']); ?></p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($item['name']); ?></td>
                <td><?php echo e(number_format($item['price'] ?? 0)); ?>đ</td>
                <td><?php echo e($item['quantity']); ?></td>
                <td><?php echo e(number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0))); ?>đ</td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <h5 class="text-end">
        Tổng cộng: <?php echo e(number_format($order['final_amount'] ?? 0)); ?>đ
    </h5>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/orders/myOrderdetail.blade.php ENDPATH**/ ?>