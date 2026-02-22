

<?php $__env->startSection('title', 'Quản lý đơn hàng'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="fas fa-shopping-cart"></i> Quản lý đơn hàng</h2>
        </div>
        <div class="col-md-6 text-end">
            <span class="badge bg-primary fs-6">
                Tổng: <?php echo e(!empty($orders) ? count($orders) : 0); ?> đơn
            </span>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="25%">Khách hàng</th>
                            <th width="20%">Tổng tiền</th>
                            <th width="20%">Trạng thái</th>
                            <th width="20%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($orders) && count($orders) > 0): ?>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $status = $order['status'] ?? 'pending';
                            ?>
                            <tr>
                                <td><?php echo e($order['id']); ?></td>
                                <td><?php echo e($order['shipping_name']); ?></td>
                                <td>
                                    <strong class="text-danger">
                                        <?php echo e(number_format($order['final_amount'])); ?> đ
                                    </strong>
                                </td>

                                
                                <td>
                                    <select class="form-select form-select-sm"
                                            onchange="updateStatus(<?php echo e($order['id']); ?>, this.value)">
                                        <option value="pending" <?php echo e($status == 'pending' ? 'selected' : ''); ?>>
                                            Chờ xử lý
                                        </option>
                                        <option value="processing" <?php echo e($status == 'processing' ? 'selected' : ''); ?>>
                                            Đang xử lý
                                        </option>
                                        <option value="completed" <?php echo e($status == 'completed' ? 'selected' : ''); ?>>
                                            Hoàn thành
                                        </option>
                                        <option value="cancelled" <?php echo e($status == 'cancelled' ? 'selected' : ''); ?>>
                                            Đã hủy
                                        </option>
                                    </select>
                                </td>

                                <td>
                                    <a href="/admin/orders/show/<?php echo e($order['id']); ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Chưa có đơn hàng nào</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function updateStatus(id, status) {
    fetch(`/admin/orders/update-status/${id}/${status}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Cập nhật thành công',
                    timer: 1200,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Lỗi!', 'Không thể cập nhật trạng thái', 'error');
            }
        })
        .catch(() => {
            Swal.fire('Lỗi!', 'Có lỗi xảy ra!', 'error');
        });
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/orders/index.blade.php ENDPATH**/ ?>