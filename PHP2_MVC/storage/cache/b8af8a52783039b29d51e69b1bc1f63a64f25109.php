

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3>Lịch sử đơn hàng</h3>

    <?php if(empty($orders)): ?>
        <p>Bạn chưa có đơn hàng nào.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Ngày đặt</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>#<?php echo e($order['id']); ?></td>
                    <td><?php echo e(number_format($order['total'])); ?> đ</td>
                    <td><?php echo e($order['status']); ?></td>
                    <td><?php echo e($order['payment_status']); ?></td>
                    <td><?php echo e($order['created_at']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/orders/history.blade.php ENDPATH**/ ?>