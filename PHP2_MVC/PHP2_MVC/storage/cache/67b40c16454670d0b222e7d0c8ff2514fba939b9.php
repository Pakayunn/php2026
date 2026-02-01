

<?php $__env->startSection('title', 'Quản lý danh mục'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Danh sách danh mục</h1>
    <a href="/category/create" class="btn btn-primary">Thêm mới</a>
    
    <?php if(!empty($categories)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($category['id']); ?></td>
                    <td><?php echo e($category['name']); ?></td>
                    <td><?php echo e($category['description'] ?? ''); ?></td>
                    <td>
                        <a href="/category/edit/<?php echo e($category['id']); ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="/category/delete/<?php echo e($category['id']); ?>" class="btn btn-sm btn-danger" 
                           onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có danh mục nào</p>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\Php2\PHP2_MVC\app\views/category/index.blade.php ENDPATH**/ ?>