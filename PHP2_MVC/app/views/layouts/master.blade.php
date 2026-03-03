<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PHP2 MVC')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }

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

        .main-content {
            padding: 24px;
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: all .2s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        }

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

        .alert {
            border-radius: 8px;
        }

        .dropdown-menu {
            border-radius: 8px;
            border: 1px solid #eaeaea;
        }

        .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
        }
    </style>
</head>

<body>

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

                @php $user = $_SESSION['user'] ?? null; @endphp

                <ul class="navbar-nav ms-auto">
                    {{-- ICON WISHLIST --}}
                    @if($user && $user['role'] !== 'admin')
                        @php
                            $wishlistCount = 0;
                            try {
                                if (isset($user['id'])) {
                                    $pdo = \Database::connect();
                                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM wishlist WHERE user_id = ?");
                                    $stmt->execute([$user['id']]);
                                    $wishlistCount = $stmt->fetchColumn() ?? 0;
                                }
                            } catch (Exception $e) {
                                $wishlistCount = 0;
                            }
                        @endphp

                        <li class="nav-item position-relative me-3">
                            <a class="nav-link" href="/wishlist">
                                <i class="fas fa-heart fa-lg text-danger"></i>
                                @if($wishlistCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $wishlistCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif
                    {{-- ICON CART --}}
                    @if($user && $user['role'] !== 'admin')
                        @php
                            $cartCount = 0;
                            try {
                                if (isset($user['id'])) {
                                    $pdo = \Database::connect();
                                    $stmt = $pdo->prepare("SELECT SUM(quantity) FROM carts WHERE user_id = ?");
                                    $stmt->execute([$user['id']]);
                                    $cartCount = $stmt->fetchColumn() ?? 0;
                                }
                            } catch (Exception $e) {
                                $cartCount = 0;
                            }
                        @endphp

                        <li class="nav-item position-relative me-3">
                            <a class="nav-link" href="/cart">
                                <i class="fas fa-shopping-cart fa-lg"></i>
                                @if($cartCount > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif

                    {{-- USER DROPDOWN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i>
                            {{ $user['username'] ?? 'Tài khoản' }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(!$user)
                                <li><a class="dropdown-item" href="/auth/login"><i class="fas fa-sign-in"></i> Đăng nhập</a>
                                </li>
                                <li><a class="dropdown-item" href="/auth/register"><i class="fas fa-user-plus"></i> Đăng
                                        ký</a></li>
                            @else
                                @if($user['role'] === 'admin')
                                    <li><a class="dropdown-item" href="/admin"><i class="fas fa-tachometer-alt"></i>
                                            Trang Admin</a></li>
                                @endif
                                <li><a class="dropdown-item" href="/orders/myOrders"><i class="fas fa-receipt"></i> Lịch sử
                                        đơn hàng</a></li>
                                <li>
                                    <a class="dropdown-item" href="/user/profile">
                                        <i class="fas fa-user-circle"></i> Profile
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="/auth/logout"><i class="fas fa-sign-out-alt"></i> Đăng
                                        xuất</a></li>
                            @endif
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    {{-- ================== XÁC ĐỊNH TRANG ADMIN ================== --}}
    @php
        $user = $_SESSION['user'] ?? null;
        $uri = $_SERVER['REQUEST_URI'] ?? '';

        $adminRoutes = [
            '/admin',
            '/product',
            '/category',
            '/brand',
            '/user',
            '/orders'
        ];

        $isAdminPage = false;

        foreach ($adminRoutes as $route) {
            if (strpos($uri, $route) === 0) {
                $isAdminPage = true;
                break;
            }
        }
    @endphp

    <div class="container-fluid">
        <div class="row">

            @if($user && $user['role'] === 'admin' && $isAdminPage)

                <div class="col-md-2 p-0 sidebar">
                    <nav class="nav flex-column mt-3">

                        <a class="nav-link" href="/admin">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>

                        <a class="nav-link" href="/product">
                            <i class="fas fa-box"></i> Sản phẩm
                        </a>

                        <a class="nav-link" href="/category">
                            <i class="fas fa-list"></i> Danh mục
                        </a>

                        <a class="nav-link" href="/brand">
                            <i class="fas fa-tags"></i> Thương hiệu
                        </a>

                        <a class="nav-link" href="/user">
                            <i class="fas fa-users"></i> Người dùng
                        </a>

                        <a class="nav-link" href="/orders">
                            <i class="fas fa-receipt"></i> Đơn hàng
                        </a>

                    </nav>
                </div>

                <div class="col-md-10 main-content">

            @else

                    <div class="col-12 main-content">

                @endif

                    @yield('content')

                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @yield('scripts')
        @stack('scripts')
</body>

</html>