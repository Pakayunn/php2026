<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
/* Reset cơ bản */
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
}

/* Thanh menu */
.admin-menu {
    background: #333;
    border-bottom: 1px solid #ccc;
}

/* Danh sách menu */
.admin-menu ul {
    list-style: none;
    margin: 0;
    padding: 0 20px;
    display: flex;
    align-items: center;
}

/* Logo */
.admin-menu .logo {
    color: #fff;
    font-weight: bold;
    margin-right: 30px;
}

/* Link menu */
.admin-menu a {
    display: block;
    padding: 14px 18px;
    color: #fff;
    text-decoration: none;
    font-size: 14px;
}

/* Hover đơn giản */
.admin-menu a:hover {
    background: #555;
}

/* Active */
.admin-menu a.active {
    background: #000;
    font-weight: bold;
}
</style>

<nav class="admin-menu">
    <ul>
        <li class="logo">ADMIN</li>

        <li>
            <a href="sinhvien.php" class="<?= $current_page === 'sinhvien.php' ? 'active' : '' ?>">
                Sinh viên
            </a>
        </li>

        <li>
            <a href="sanpham.php" class="<?= $current_page === 'sanpham.php' ? 'active' : '' ?>">
                Sản phẩm
            </a>
        </li>

        <li>
            <a href="tintuc.php" class="<?= $current_page === 'tintuc.php' ? 'active' : '' ?>">
                Tin tức
            </a>
        </li>
    </ul>
</nav>
