<?php
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

class SanPham {
    public $maSP;
    public $tenSP;
    public $gia;
    public $soLuong;

    public function __construct($maSP = '', $tenSP = '', $gia = 0, $soLuong = 0) {
        $this->maSP = $maSP;
        $this->tenSP = $tenSP;
        $this->gia = floatval($gia);
        $this->soLuong = intval($soLuong);
    }

    public function tinhThanhTien() {
        return $this->gia * $this->soLuong;
    }

    public function trangThai() {
        if ($this->soLuong == 0) return "hết hàng";
        if ($this->soLuong < 10) return "sắp hết";
        return "còn hàng";
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$maSP_edit = isset($_GET['masp']) ? $_GET['masp'] : '';
$message = '';

// XỬ LÝ THÊM/SỬA
if (isset($_POST['submit'])) {
    $sp = new SanPham(
        trim($_POST['maSP']),
        trim($_POST['tenSP']),
        $_POST['gia'],
        $_POST['soLuong']
    );
    if(empty($sp->maSP) || empty($sp->tenSP)) {
        $message = 'Lỗi: Mã sản phẩm và Tên sản phẩm không được để trống';
    }

    if ($action === 'edit' && !empty($maSP_edit)) {
        $sql = "UPDATE sanpham SET tensp = ?, gia = ?, soluong = ? WHERE masp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$sp->tenSP, $sp->gia, $sp->soLuong, $maSP_edit]);
        header('Location: sanpham.php?msg=updated');
        exit;
    } else {
        try {
            $sql = "INSERT INTO sanpham (masp, tensp, gia, soluong) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$sp->maSP, $sp->tenSP, $sp->gia, $sp->soLuong]);
            header('Location: sanpham.php?msg=added');
            exit;
        } catch (PDOException $e) {
            $message = 'Lỗi: Mã sản phẩm đã tồn tại';
        }
    }
}

// XỬ LÝ XÓA
if ($action === 'delete' && !empty($maSP_edit)) {
    $sql = "DELETE FROM sanpham WHERE masp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maSP_edit]);
    header('Location: sanpham.php?msg=deleted');
    exit;
}

// THÔNG BÁO
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'added') $message = 'Thêm sản phẩm thành công';
    if ($_GET['msg'] === 'updated') $message = 'Cập nhật sản phẩm thành công';
    if ($_GET['msg'] === 'deleted') $message = 'Xóa sản phẩm thành công';
}

// LẤY DỮ LIỆU ĐỂ SỬA
$sp_edit = null;
if ($action === 'edit' && !empty($maSP_edit)) {
    $sql = "SELECT * FROM sanpham WHERE masp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maSP_edit]);
    $sp_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// PHÂN TRANG
$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);
$offset = ($page - 1) * $limit;

$sqlCount = "SELECT COUNT(*) as total FROM sanpham";
$stmtCount = $conn->prepare($sqlCount);
$stmtCount->execute();
$total = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($total / $limit);

$sql = "SELECT * FROM sanpham ORDER BY masp LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $limit, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$sanphams = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sản phẩm</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f8f8f8; }
        h2 { color: #000; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ccc; font-size: 14px; }
        th { background: #e8e8e8; font-weight: bold; }
        a { color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
        input[type="text"], input[type="number"] { 
            width: 100%; padding: 8px; border: 1px solid #ccc; font-size: 14px; 
        }
        button, .btn { 
            padding: 8px 16px; background: #fff; border: 1px solid #ccc; 
            cursor: pointer; font-size: 14px; color: #000; text-decoration: none; 
            display: inline-block; 
        }
        button:hover, .btn:hover { background: #f0f0f0; }
        label { display: block; margin: 10px 0 5px; font-weight: bold; }
        .message { color: green; margin-bottom: 15px; }
        .error { color: red; margin-bottom: 15px; }
        .pagination { margin-top: 15px; }
        .pagination a { 
            padding: 5px 10px; border: 1px solid #ccc; margin: 0 2px; 
            display: inline-block; background: #fff; 
        }
        .pagination a.active { background: #e8e8e8; }
    </style>
</head>
<body>

<?php include 'admin_menu.php'; ?>

<?php if ($message): ?>
    <p class="<?= strpos($message, 'Lỗi') !== false ? 'error' : 'message' ?>"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <!-- FORM THÊM/SỬA -->
    <h2><?= $action === 'edit' ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới' ?></h2>
    
    <form method="post" action="?action=<?= $action ?>&masp=<?= urlencode($maSP_edit) ?>">
        <label>Mã sản phẩm:</label>
        <input type="text" name="maSP" 
               value="<?= $sp_edit ? htmlspecialchars($sp_edit['masp']) : '' ?>" 
               <?= $action === 'edit' ? 'readonly' : 'required' ?>>

        <label>Tên sản phẩm:</label>
        <input type="text" name="tenSP" 
               value="<?= $sp_edit ? htmlspecialchars($sp_edit['tensp']) : '' ?>" 
               required>

        <label>Giá:</label>
        <input type="number" name="gia" 
               value="<?= $sp_edit ? $sp_edit['gia'] : '' ?>" 
               min="0" step="1000" required>

        <label>Số lượng:</label>
        <input type="number" name="soLuong" 
               value="<?= $sp_edit ? $sp_edit['soluong'] : '' ?>" 
               min="0" required>

        <div style="margin-top: 15px;">
            <button type="submit" name="submit">
                <?= $action === 'edit' ? 'Cập nhật' : 'Thêm mới' ?>
            </button>
            <a href="sanpham.php" class="btn">Quay lại danh sách</a>
        </div>
    </form>

<?php else: ?>
    <!-- DANH SÁCH -->
    <h2>Quản lý Sản phẩm</h2>
    
    <div style="margin-bottom: 15px;">
        <a href="?action=add" class="btn">Thêm mới</a>
    </div>

    <?php if (count($sanphams) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sanphams as $row): 
                    $sp = new SanPham($row['masp'], $row['tensp'], $row['gia'], $row['soluong']);
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['masp']) ?></td>
                    <td><?= htmlspecialchars($row['tensp']) ?></td>
                    <td><?= number_format($row['gia'], 0, ',', '.') ?></td>
                    <td><?= $row['soluong'] ?></td>
                    <td><?= number_format($sp->tinhThanhTien(), 0, ',', '.') ?></td>
                    <td><?= $sp->trangThai() ?></td>
                    <td>
                        <a href="?action=edit&masp=<?= urlencode($row['masp']) ?>">Sửa</a> |
                        <a href="?action=delete&masp=<?= urlencode($row['masp']) ?>" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>">Trước</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>">Sau</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Chưa có sản phẩm nào.</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>