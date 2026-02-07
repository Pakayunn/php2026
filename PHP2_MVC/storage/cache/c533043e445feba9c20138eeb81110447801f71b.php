

<?php $__env->startSection('title', 'Quên mật khẩu'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5">

                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        <h3 class="text-center mb-4">
                            <i class="fas fa-key"></i> Quên mật khẩu
                        </h3>

                        
                        <?php if(isset($error) && $error): ?>
                            <div class="alert alert-danger">
                                <?php echo e($error); ?>

                            </div>
                        <?php endif; ?>

                        
                        <?php if(isset($success) && $success): ?>
                            <div class="alert alert-success">
                                <?php echo e($success); ?>

                            </div>
                        <?php endif; ?>

                        <form method="post">

                            <div class="mb-3">
                                <label class="form-label">Email của bạn</label>
                                <input type="email" name="email" class="form-control" placeholder="Nhập email đã đăng ký"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu mới</label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới"
                                    required>
                            </div>


                            <button class="btn btn-primary w-100">
                                <i class="fas fa-paper-plane"></i> Gửi yêu cầu
                            </button>

                        </form>

                        <div class="text-center mt-3">
                            <a href="/auth/login" class="text-decoration-none">
                                ← Quay lại đăng nhập
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Xamppp2\htdocs\hihi\php2026\PHP2_MVC\app\views/auth/forgot.blade.php ENDPATH**/ ?>