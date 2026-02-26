

<?php $__env->startSection('title', 'Chỉnh sửa hồ sơ'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">Chỉnh sửa thông tin</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="/user/updateProfile">

                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control"
                                   value="<?php echo e($user['phone'] ?? ''); ?>">
                        </div>

                        <hr>

                        <h6>Đổi mật khẩu (không bắt buộc)</h6>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu mới</label>
                            <input type="password"
                                   name="password"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">
                            Cập nhật
                        </button>

                        <a href="/user/profile" class="btn btn-secondary">
                            Hủy
                        </a>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hi\php2026\PHP2_MVC\app\views/user/edit_profile.blade.php ENDPATH**/ ?>