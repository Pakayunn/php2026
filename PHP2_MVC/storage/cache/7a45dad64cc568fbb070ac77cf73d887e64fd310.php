<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Shop Home</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

<?php
    $user = $_SESSION['user'] ?? null;
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
<div class="container">

<a class="navbar-brand fw-semibold" href="/">DJI Hallo</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
    <span class="navbar-toggler-icon"></span>
</button>

<div id="nav" class="collapse navbar-collapse">

<ul class="navbar-nav me-auto">
    <li class="nav-item">
        <a class="nav-link active" href="/">Home</a>
    </li>
</ul>

<ul class="navbar-nav ms-auto">
<li class="nav-item dropdown">

<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
    <i class="fas fa-user"></i>
    <?php echo e($user['username'] ?? 'Tài khoản'); ?>

</a>

<ul class="dropdown-menu dropdown-menu-end">

<?php if(!$user): ?>

    <li>
        <a class="dropdown-item" href="/auth/login">
            <i class="fas fa-sign-in-alt"></i> Đăng nhập
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
            <i class="fas fa-tachometer-alt"></i> Dashboard
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

<!-- Main -->
<main class="container py-4">
<div class="row g-4">

<!-- Sidebar -->
<aside class="col-12 col-lg-3">
<div class="card shadow-sm">
<div class="card-header bg-white fw-semibold">Categories</div>
<div class="list-group list-group-flush">
    <a href="#" class="list-group-item active">All</a>
    <a href="#" class="list-group-item">Phones</a>
    <a href="#" class="list-group-item">Laptops</a>
</div>
</div>
</aside>

<!-- Products -->
<section class="col-12 col-lg-9">

<h1 class="h4 mb-3">Products</h1>

<div class="row g-3">

<?php for($i = 1; $i <= 6; $i++): ?>

<div class="col-12 col-sm-6 col-xl-4">
<div class="card h-100 shadow-sm">

<img src="https://picsum.photos/600/400?random=<?php echo e($i); ?>" class="card-img-top">

<div class="card-body">
<h5 class="card-title">Sản phẩm <?php echo e($i); ?></h5>

<div class="d-flex justify-content-between">
    <div class="fw-semibold">$199</div>
    <a href="#" class="btn btn-sm btn-outline-primary">View</a>
</div>

</div>
</div>
</div>

<?php endfor; ?>

</div>
</section>

</div>
</main>

<footer class="border-top bg-white">
<div class="container py-3 text-center">
© 2026 MyShop
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php /**PATH C:\Xamppp2\htdocs\hihi\php2026\PHP2_MVC\app\views/home/index.blade.php ENDPATH**/ ?>