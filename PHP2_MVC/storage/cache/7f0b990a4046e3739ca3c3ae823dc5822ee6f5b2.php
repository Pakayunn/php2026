

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Thông tin tài khoản</h5>
        </div>
        <div class="card-body">

            <p><strong>Họ tên:</strong> <?php echo e($user['full_name'] ?? ''); ?></p>
            <p><strong>Username:</strong> <?php echo e($user['username'] ?? ''); ?></p>
            <p><strong>Email:</strong> <?php echo e($user['email'] ?? ''); ?></p>
            <p><strong>Điện thoại:</strong> <?php echo e($user['phone'] ?? 'Chưa cập nhật'); ?></p>
            <p><strong>Vai trò:</strong> <?php echo e($user['role'] ?? ''); ?></p>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.customer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/user/profile.blade.php ENDPATH**/ ?>