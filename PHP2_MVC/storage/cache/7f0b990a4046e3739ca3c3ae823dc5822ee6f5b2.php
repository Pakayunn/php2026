

<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin tài khoản</h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <strong>Họ tên:</strong>
                        <span><?php echo e($user['full_name'] ?? 'Chưa cập nhật'); ?></span>
                    </div>

                    <div class="mb-3">
                        <strong>Username:</strong>
                        <span><?php echo e($user['username'] ?? ''); ?></span>
                    </div>

                    <div class="mb-3">
                        <strong>Email:</strong>
                        <span><?php echo e($user['email'] ?? ''); ?></span>
                    </div>

                    <div class="mb-3">
                        <strong>Điện thoại:</strong>
                        <span><?php echo e($user['phone'] ?? 'Chưa cập nhật'); ?></span>
                    </div>

                    <div class="mb-3">
                        <strong>Vai trò:</strong>
                        <span class="badge bg-info text-dark">
                            <?php echo e($user['role'] ?? ''); ?>

                        </span>
                    </div>

                    <hr>

                    <a href="/user/editProfile" class="btn btn-warning">
                        Chỉnh sửa thông tin
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/user/profile.blade.php ENDPATH**/ ?>