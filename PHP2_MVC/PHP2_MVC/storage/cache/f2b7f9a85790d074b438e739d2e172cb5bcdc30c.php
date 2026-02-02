

<?php $__env->startSection('title', 'Thêm danh mục'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Thêm danh mục mới</h1>
    
    <form action="/category/store" method="POST">
        <div class="form-group">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="/category" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\Php2\PHP2_MVC\app\views/category/create.blade.php ENDPATH**/ ?>