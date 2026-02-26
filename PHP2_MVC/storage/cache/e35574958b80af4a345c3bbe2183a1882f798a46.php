

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <h3>Lịch sử mua hàng</h3>

        <?php if(empty($orders)): ?>
            <div class="alert alert-info">
                Bạn chưa có đơn hàng nào.
            </div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($order['id']); ?></td>
                            <td><?php echo e(number_format($order['final_amount'])); ?>đ</td>
                            <td><?php echo e($order['status']); ?></td>
                            <td><?php echo e($order['created_at']); ?></td>
                            <td>
                                <a href="/orders/myOrderDetail/<?php echo e($order['id']); ?>" 
                                   class="btn btn-sm btn-primary">
                                    Xem chi tiết
                                </a>

                                <?php if($order['status'] == 'pending'): ?>
                                    <a href="/orders/cancel/<?php echo e($order['id']); ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Bạn có chắc muốn hủy đơn này?')">
                                        Hủy đơn
                                    </a>
                                <?php endif; ?>

                                <?php if($order['status'] == 'completed'): ?>
                                    <a href="/orders/reorder/<?php echo e($order['id']); ?>" 
                                       class="btn btn-sm btn-success">
                                        Mua lại
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/user/orders.blade.php ENDPATH**/ ?>