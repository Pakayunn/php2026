<?php 
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

class SinhVien {
    public $maSV;
    public $hoTen;  
    public $diemTB;

    public function __construct($maSV, $hoTen, $diemTB) {
        $this->maSV = $maSV;
        $this->hoTen = $hoTen;
        $this->diemTB = floatval($diemTB);
    }

    public function xepLoai() {
        if ($this->diemTB >= 8) return "Giỏi";
        if ($this->diemTB >= 6.5) return "Khá";
        if ($this->diemTB >= 5) return "Trung Bình";
        return "Yếu";
    }

    public function hienThiThongTin() {
        echo "Mã SV: $this->maSV<br>";
        echo "Họ tên: $this->hoTen<br>";
        echo "Điểm TB: $this->diemTB<br>";
        echo "Xếp loại: " . $this->xepLoai() . "<br>";
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$maSV_edit = isset($_GET['masv']) ? $_GET['masv'] : '';
$message = '';

// XỬ LÝ THÊM/SỬA
if (isset($_POST['submit'])) {
    $sv = new SinhVien(
        trim($_POST['maSV']),
        trim($_POST['hoTen']),
        $_POST['diemTB']
    );

    if ($action === 'edit' && !empty($maSV_edit)) {
        $sql = "UPDATE sinhvien SET ten = ?, diemsv = ? WHERE mssv = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$sv->hoTen, $sv->diemTB, $maSV_edit]);
        header('Location: sinhvien.php?msg=updated');
        exit;
    } else {
        try {
            $sql = "INSERT INTO sinhvien (mssv, ten, diemsv) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$sv->maSV, $sv->hoTen, $sv->diemTB]);
            header('Location: sinhvien.php?msg=added');
            exit;
        } catch (PDOException $e) {
            $message = 'Lỗi: Mã sinh viên đã tồn tại';
        }
    }
}

// XỬ LÝ XÓA
if ($action === 'delete' && !empty($maSV_edit)) {
    $sql = "DELETE FROM sinhvien WHERE mssv = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maSV_edit]);
    header('Location: sinhvien.php?msg=deleted');
    exit;
}

// THÔNG BÁO
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'added') $message = 'Thêm sinh viên thành công';
    if ($_GET['msg'] === 'updated') $message = 'Cập nhật sinh viên thành công';
    if ($_GET['msg'] === 'deleted') $message = 'Xóa sinh viên thành công';
}

// LẤY DỮ LIỆU ĐỂ SỬA
$sv_edit = null;
if ($action === 'edit' && !empty($maSV_edit)) {
    $sql = "SELECT * FROM sinhvien WHERE mssv = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maSV_edit]);
    $sv_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// LẤY DANH SÁCH
$sql = "SELECT * FROM sinhvien ORDER BY mssv";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sinhviens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh viên</title>
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
    </style>
</head>
<body>

<?php include 'admin_menu.php'; ?>

<?php if ($message): ?>
    <p class="<?= strpos($message, 'Lỗi') !== false ? 'error' : 'message' ?>"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <!-- FORM THÊM/SỬA -->
    <h2><?= $action === 'edit' ? 'Sửa sinh viên' : 'Thêm sinh viên mới' ?></h2>
    
    <form method="post" action="?action=<?= $action ?>&masv=<?= urlencode($maSV_edit) ?>">
        <label>Mã sinh viên:</label>
        <input type="text" name="maSV" 
               value="<?= $sv_edit ? htmlspecialchars($sv_edit['mssv']) : '' ?>" 
               <?= $action === 'edit' ? 'readonly' : 'required' ?>>

        <label>Họ và tên:</label>
        <input type="text" name="hoTen" 
               value="<?= $sv_edit ? htmlspecialchars($sv_edit['ten']) : '' ?>" 
               required>

        <label>Điểm trung bình:</label>
        <input type="number" name="diemTB" 
               value="<?= $sv_edit ? $sv_edit['diemsv'] : '' ?>" 
               step="0.1" min="0" max="10" required>

        <div style="margin-top: 15px;">
            <button type="submit" name="submit">
                <?= $action === 'edit' ? 'Cập nhật' : 'Thêm mới' ?>
            </button>
            <a href="sinhvien.php" class="btn">Quay lại danh sách</a>
        </div>
    </form>

<?php else: ?>
    <!-- DANH SÁCH -->
    <h2>Quản lý Sinh viên</h2>
    
    <div style="margin-bottom: 15px;">
        <a href="?action=add" class="btn">Thêm mới</a>
    </div>

    <?php if (count($sinhviens) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Mã SV</th>
                    <th>Họ và tên</th>
                    <th>Điểm TB</th>
                    <th>Xếp loại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sinhviens as $row): 
                    $sv = new SinhVien($row['mssv'], $row['ten'], $row['diemsv']);
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['mssv']) ?></td>
                    <td><?= htmlspecialchars($row['ten']) ?></td>
                    <td><?= number_format($row['diemsv'], 1) ?></td>
                    <td><?= $sv->xepLoai() ?></td>
                    <td>
                        <a href="?action=edit&masv=<?= urlencode($row['mssv']) ?>">Sửa</a> |
                        <a href="?action=delete&masv=<?= urlencode($row['mssv']) ?>" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có sinh viên nào.</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>