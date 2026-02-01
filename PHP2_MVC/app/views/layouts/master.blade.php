<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PHP2 MVC')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
        }
        .sidebar .nav-link {
            color: #fff;
            padding: 10px 20px;
        }
        .sidebar .nav-link:hover {
            background: #495057;
        }
        .sidebar .nav-link.active {
            background: #007bff;
        }
        .main-content {
            padding: 20px;
        }
        .alert {
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-store"></i> PHP2 MVC Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="fas fa-home"></i> Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin">
                            <i class="fas fa-tachometer-alt"></i> Admin
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Cài đặt</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (chỉ hiện khi ở trang admin) -->
            @if(strpos($_SERVER['REQUEST_URI'] ?? '', '/admin') !== false || 
                strpos($_SERVER['REQUEST_URI'] ?? '', '/product') !== false ||
                strpos($_SERVER['REQUEST_URI'] ?? '', '/category') !== false ||
                strpos($_SERVER['REQUEST_URI'] ?? '', '/brand') !== false ||
                strpos($_SERVER['REQUEST_URI'] ?? '', '/user') !== false)
            <div class="col-md-2 p-0 sidebar">
                <nav class="nav flex-column mt-3">
                    <a class="nav-link {{ strpos($_SERVER['REQUEST_URI'], '/admin') !== false ? 'active' : '' }}" href="/admin">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a class="nav-link {{ strpos($_SERVER['REQUEST_URI'], '/product') !== false ? 'active' : '' }}" href="/product">
                        <i class="fas fa-box"></i> Sản phẩm
                    </a>
                    <a class="nav-link {{ strpos($_SERVER['REQUEST_URI'], '/category') !== false ? 'active' : '' }}" href="/category">
                        <i class="fas fa-list"></i> Danh mục
                    </a>
                    <a class="nav-link {{ strpos($_SERVER['REQUEST_URI'], '/brand') !== false ? 'active' : '' }}" href="/brand">
                        <i class="fas fa-tags"></i> Thương hiệu
                    </a>
                    <a class="nav-link {{ strpos($_SERVER['REQUEST_URI'], '/user') !== false ? 'active' : '' }}" href="/user">
                        <i class="fas fa-users"></i> Người dùng
                    </a>
                </nav>
            </div>
            <div class="col-md-10 main-content">
            @else
            <div class="col-12 main-content">
            @endif
                <!-- Flash Messages -->
                @if(isset($_SESSION['success']))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ $_SESSION['success'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['success']); ?>
                @endif

                @if(isset($_SESSION['error']))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ $_SESSION['error'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['error']); ?>
                @endif

                <!-- Main Content -->
                @yield('content')
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

    @yield('scripts')
</body>
</html>