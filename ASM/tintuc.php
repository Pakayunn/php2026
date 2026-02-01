<?php
require_once 'database.php';

$db = new Database();
$conn = $db->getConnection();

class TinTuc {
    public $maTin;
    public $tieuDe;
    public $noiDung;
    public $ngayDang;
    public $tacGia;

    public function __construct($maTin = '', $tieuDe = '', $noiDung = '', $ngayDang = '', $tacGia = '') {
        $this->maTin = $maTin;
        $this->tieuDe = $tieuDe;
        $this->noiDung = $noiDung;
        $this->ngayDang = $ngayDang;
        $this->tacGia = $tacGia;
    }

    public function getTomTat($maxLength = 100) {
        if (strlen($this->noiDung) > $maxLength) {
            return substr($this->noiDung, 0, $maxLength) . '...';
        }
        return $this->noiDung;
    }

    public function tinhNgay() {
        $ngay = strtotime($this->ngayDang);
        $hienTai = time();
        $chenh = $hienTai - $ngay;
        
        $ngayLech = floor($chenh / (60 * 60 * 24));
        
        if ($ngayLech == 0) return "Hôm nay";
        if ($ngayLech == 1) return "Hôm qua";
        if ($ngayLech < 7) return $ngayLech . " ngày trước";
        return date('d/m/Y', $ngay);
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$maTin_edit = isset($_GET['matin']) ? $_GET['matin'] : '';
$message = '';

// XỬ LÝ THÊM/SỬA
if (isset($_POST['submit'])) {
    $tin = new TinTuc(
        trim($_POST['maTin']),
        trim($_POST['tieuDe']),
        trim($_POST['noiDung']),
        $_POST['ngayDang'],
        trim($_POST['tacGia'])
    );

    if ($action === 'edit' && !empty($maTin_edit)) {
        $sql = "UPDATE tintuc SET tieude = ?, noidung = ?, ngaydang = ?, tacgia = ? WHERE matin = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$tin->tieuDe, $tin->noiDung, $tin->ngayDang, $tin->tacGia, $maTin_edit]);
        header('Location: tintuc.php?msg=updated');
        exit;
    } else {
        try {
            $sql = "INSERT INTO tintuc (matin, tieude, noidung, ngaydang, tacgia) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$tin->maTin, $tin->tieuDe, $tin->noiDung, $tin->ngayDang, $tin->tacGia]);
            header('Location: tintuc.php?msg=added');
            exit;
        } catch (PDOException $e) {
            $message = 'Lỗi: Mã tin tức đã tồn tại';
        }
    }
}

// XỬ LÝ XÓA
if ($action === 'delete' && !empty($maTin_edit)) {
    $sql = "DELETE FROM tintuc WHERE matin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTin_edit]);
    header('Location: tintuc.php?msg=deleted');
    exit;
}

// THÔNG BÁO
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'added') $message = 'Thêm tin tức thành công';
    if ($_GET['msg'] === 'updated') $message = 'Cập nhật tin tức thành công';
    if ($_GET['msg'] === 'deleted') $message = 'Xóa tin tức thành công';
}

// LẤY DỮ LIỆU ĐỂ SỬA
$tin_edit = null;
if ($action === 'edit' && !empty($maTin_edit)) {
    $sql = "SELECT * FROM tintuc WHERE matin = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$maTin_edit]);
    $tin_edit = $stmt->fetch(PDO::FETCH_ASSOC);
}

// PHÂN TRANG
$limit = 5;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = max(1, $page);
$offset = ($page - 1) * $limit;

$sqlCount = "SELECT COUNT(*) as total FROM tintuc";
$stmtCount = $conn->prepare($sqlCount);
$stmtCount->execute();
$total = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($total / $limit);

$sql = "SELECT * FROM tintuc ORDER BY ngaydang DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $limit, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$tintucs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Tin tức</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f8f8f8; }
        h2 { color: #000; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; border: 1px solid #ccc; font-size: 14px; }
        th { background: #e8e8e8; font-weight: bold; }
        a { color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
        input[type="text"], input[type="date"], textarea { 
            width: 100%; padding: 8px; border: 1px solid #ccc; font-size: 14px; 
        }
        textarea { min-height: 100px; font-family: Arial, sans-serif; }
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
    <h2><?= $action === 'edit' ? 'Sửa tin tức' : 'Thêm tin tức mới' ?></h2>
    
    <form method="post" action="?action=<?= $action ?>&matin=<?= urlencode($maTin_edit) ?>">
        <label>Mã tin:</label>
        <input type="text" name="maTin" 
               value="<?= $tin_edit ? htmlspecialchars($tin_edit['matin']) : '' ?>" 
               <?= $action === 'edit' ? 'readonly' : 'required' ?>>

        <label>Tiêu đề:</label>
        <input type="text" name="tieuDe" 
               value="<?= $tin_edit ? htmlspecialchars($tin_edit['tieude']) : '' ?>" 
               required>

        <label>Nội dung:</label>
        <textarea name="noiDung" required><?= $tin_edit ? htmlspecialchars($tin_edit['noidung']) : '' ?></textarea>

        <label>Ngày đăng:</label>
        <input type="date" name="ngayDang" 
               value="<?= $tin_edit ? $tin_edit['ngaydang'] : date('Y-m-d') ?>" 
               required>

        <label>Tác giả:</label>
        <input type="text" name="tacGia" 
               value="<?= $tin_edit ? htmlspecialchars($tin_edit['tacgia']) : '' ?>" 
               required>

        <div style="margin-top: 15px;">
            <button type="submit" name="submit">
                <?= $action === 'edit' ? 'Cập nhật' : 'Thêm mới' ?>
            </button>
            <a href="tintuc.php" class="btn">Quay lại danh sách</a>
        </div>
    </form>

<?php else: ?>
    <!-- DANH SÁCH -->
    <h2>Quản lý Tin tức</h2>
    
    <div style="margin-bottom: 15px;">
        <a href="?action=add" class="btn">Thêm mới</a>
    </div>

    <?php if (count($tintucs) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Mã tin</th>
                    <th>Tiêu đề</th>
                    <th>Tóm tắt</th>
                    <th>Tác giả</th>
                    <th>Ngày đăng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tintucs as $row): 
                    $tin = new TinTuc($row['matin'], $row['tieude'], $row['noidung'], $row['ngaydang'], $row['tacgia']);
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['matin']) ?></td>
                    <td><?= htmlspecialchars($row['tieude']) ?></td>
                    <td><?= htmlspecialchars($tin->getTomTat(200)) ?></td>
                    <td><?= htmlspecialchars($row['tacgia']) ?></td>
                    <td><?= $tin->tinhNgay() ?></td>
                    <td>
                        <a href="?action=edit&matin=<?= urlencode($row['matin']) ?>">Sửa</a> |
                        <a href="?action=delete&matin=<?= urlencode($row['matin']) ?>" 
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
        <p>Chưa có tin tức nào.</p>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>