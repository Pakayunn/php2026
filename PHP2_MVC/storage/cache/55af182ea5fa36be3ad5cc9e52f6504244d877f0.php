

<?php $__env->startSection('title', 'Quản lý thương hiệu'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="fas fa-tags"></i> Quản lý thương hiệu</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="/brand/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm thương hiệu mới
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Logo</th>
                            <th width="25%">Tên thương hiệu</th>
                            <th width="35%">Mô tả</th>
                            <th width="20%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($brands) && count($brands) > 0): ?>
                            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($brand['id']); ?></td>
                                <td>
                                    <?php if(!empty($brand['logo'])): ?>
                                        <img src="/uploads/brands/<?php echo e($brand['logo']); ?>" 
                                             alt="<?php echo e($brand['name']); ?>" 
                                             class="img-thumbnail" 
                                             style="max-width: 60px; height: auto;">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/60" 
                                             alt="No logo" 
                                             class="img-thumbnail">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($brand['name']); ?></td>
                                <td><?php echo e($brand['description'] ?? 'N/A'); ?></td>
                                <td>
                                    <a href="/brand/edit/<?php echo e($brand['id']); ?>" 
                                       class="btn btn-sm btn-warning" 
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteBrand(<?php echo e($brand['id']); ?>)" 
                                            class="btn btn-sm btn-danger" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Chưa có thương hiệu nào</p>
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
function deleteBrand(id) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Thương hiệu sẽ bị xóa vĩnh viễn!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/brand/delete/${id}`,
                type: 'POST',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Lỗi!', data.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Lỗi!', 'Có lỗi xảy ra khi xóa thương hiệu!', 'error');
                }
            });
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hihi\php2026\PHP2_MVC\app\views/brand/index.blade.php ENDPATH**/ ?>