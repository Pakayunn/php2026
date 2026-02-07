

<?php $__env->startSection('title', 'Quản lý danh mục'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h2><i class="fas fa-list"></i> Quản lý danh mục</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="/category/create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Thêm danh mục mới
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="30%">Tên danh mục</th>
                            <th width="40%">Mô tả</th>
                            <th width="20%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($categories) && count($categories) > 0): ?>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($category['id']); ?></td>
                                <td><?php echo e($category['name']); ?></td>
                                <td><?php echo e($category['description'] ?? 'N/A'); ?></td>
                                <td>
                                    <a href="/category/edit/<?php echo e($category['id']); ?>" 
                                       class="btn btn-sm btn-warning" 
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteCategory(<?php echo e($category['id']); ?>)" 
                                            class="btn btn-sm btn-danger" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                    <p class="text-muted">Chưa có danh mục nào</p>
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
function deleteCategory(id) {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: "Danh mục sẽ bị xóa vĩnh viễn!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/category/delete/${id}`,
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
                    Swal.fire('Lỗi!', 'Có lỗi xảy ra khi xóa danh mục!', 'error');
                }
            });
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hihi\php2026\PHP2_MVC\app\views/category/index.blade.php ENDPATH**/ ?>