<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'PHP2 MVC'); ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8f9fa;
}

/* ===== NAVBAR ===== */
.navbar {
    background: #ffffff !important;
    border-bottom: 1px solid #eaeaea;
}

.navbar .nav-link {
    color: #333 !important;
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.4rem;
    color: #0d6efd !important;
}

/* ===== SIDEBAR ===== */
.sidebar {
    min-height: 100vh;
    background: #ffffff;
    border-right: 1px solid #eaeaea;
}

.sidebar .nav-link {
    color: #333;
    padding: 12px 20px;
    border-bottom: 1px solid #f1f1f1;
}

.sidebar .nav-link:hover {
    background: #f1f5ff;
    color: #0d6efd;
}

.sidebar .nav-link.active {
    background: #0d6efd;
    color: white;
}

/* ===== MAIN CONTENT ===== */
.main-content {
    padding: 24px;
}

/* ===== CARD STYLE GIỐNG INDEX ===== */
.card {
    border: none;
    border-radius: 10px;
    transition: all .2s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,.08);
}

.card-img-top {
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

/* ===== BUTTON ===== */
.btn-primary {
    background: #0d6efd;
    border: none;
}

.btn-outline-primary {
    border-color: #0d6efd;
    color: #0d6efd;
}

.btn-outline-primary:hover {
    background: #0d6efd;
    color: white;
}

/* ===== ALERT ===== */
.alert {
    border-radius: 8px;
}

/* ===== DROPDOWN ===== */
.dropdown-menu {
    border-radius: 8px;
    border: 1px solid #eaeaea;
}

/* ===== PAGINATION ===== */
.pagination .page-link {
    border-radius: 6px;
    margin: 0 2px;
}
</style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-store"></i> DJI Hallo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">

                        <?php
                            $user = $_SESSION['user'] ?? null;
                        ?>

                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i>
                            <?php echo e($user['username'] ?? 'Tài khoản'); ?>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            <?php if(!$user): ?>
                                <li>
                                    <a class="dropdown-item" href="/auth/login">
                                        <i class="fas fa-sign-in"></i> Đăng nhập
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="/auth/register">
                                        <i class="fas fa-user-plus"></i> Đăng ký
                                    </a>
                                </li>

                            <?php else: ?>

                                <?php if($user['role'] === 'admin'): ?>
                                    <li>
                                        <a class="dropdown-item" href="/admin/dashboard">
                                            <i class="fas fa-tachometer-alt"></i> Trang Admin
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <li>
                                    <a class="dropdown-item" href="/auth/logout">
                                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                    </a>
                                </li>

                            <?php endif; ?>

                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (chỉ hiện khi ở trang admin) -->
            <?php if(
                    strpos($_SERVER['REQUEST_URI'] ?? '', '/admin') !== false ||
                    strpos($_SERVER['REQUEST_URI'] ?? '', '/product') !== false ||
                    strpos($_SERVER['REQUEST_URI'] ?? '', '/category') !== false ||
                    strpos($_SERVER['REQUEST_URI'] ?? '', '/brand') !== false ||
                    strpos($_SERVER['REQUEST_URI'] ?? '', '/user') !== false
                ): ?>
                <div class="col-md-2 p-0 sidebar">
                    <nav class="nav flex-column mt-3">
                        <a class="nav-link <?php echo e(strpos($_SERVER['REQUEST_URI'], '/admin') !== false ? 'active' : ''); ?>"
                            href="/admin">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a class="nav-link <?php echo e(strpos($_SERVER['REQUEST_URI'], '/product') !== false ? 'active' : ''); ?>"
                            href="/product">
                            <i class="fas fa-box"></i> Sản phẩm
                        </a>
                        <a class="nav-link <?php echo e(strpos($_SERVER['REQUEST_URI'], '/category') !== false ? 'active' : ''); ?>"
                            href="/category">
                            <i class="fas fa-list"></i> Danh mục
                        </a>
                        <a class="nav-link <?php echo e(strpos($_SERVER['REQUEST_URI'], '/brand') !== false ? 'active' : ''); ?>"
                            href="/brand">
                            <i class="fas fa-tags"></i> Thương hiệu
                        </a>
                        <a class="nav-link <?php echo e(strpos($_SERVER['REQUEST_URI'], '/user') !== false ? 'active' : ''); ?>"
                            href="/user">
                            <i class="fas fa-users"></i> Người dùng
                        </a>
                    </nav>
                </div>
                <div class="col-md-10 main-content">
            <?php else: ?>
                    <div class="col-12 main-content">
                <?php endif; ?>
                    <!-- Flash Messages -->
                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo e($_SESSION['success']); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php    unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo e($_SESSION['error']); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <?php    unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <!-- Main Content -->
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Custom Admin JS -->
        <script src="/js/admin.js"></script>

        <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html><?php /**PATH C:\Xamppp2\htdocs\hihi\php2026\PHP2_MVC\app\views/layouts/master.blade.php ENDPATH**/ ?>