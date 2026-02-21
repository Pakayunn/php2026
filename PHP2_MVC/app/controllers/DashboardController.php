<?php 
class DashboardController extends Controller
{
    public function index()
    {
        // Lấy thống kê
        $stats = $this->getStatistics();
        
        // Lấy dữ liệu cho biểu đồ
        $chartData = $this->getChartData();
        
        $this->view('admin.dashboard', [
            'stats' => $stats,
            'chartData' => $chartData
        ]);
    }

    /**
     * Lấy thống kê tổng quan
     */
    private function getStatistics()
    {
        $productModel = $this->model('Product');

        return [
            'totalProducts' => $this->countRecords('products'),
            'totalCategories' => $this->countRecords('categories'),
            'totalBrands' => $this->countRecords('brands'),
            'totalUsers' => $this->countRecords('users'),
            'recentProducts' => $productModel->getRecent(5),
        ];
    }

    /**
     * Đếm số bản ghi trong bảng
     */
    private function countRecords($table)
    {
        $conn = Database::connect();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM {$table}");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * Lấy dữ liệu cho biểu đồ
     */
    private function getChartData()
    {
        return [
            'productsByCategory' => $this->getProductsByCategory(),
            'productsByBrand' => $this->getProductsByBrand(),
        ];
    }

    /**
     * Thống kê sản phẩm theo danh mục
     */
    private function getProductsByCategory()
    {
        $conn = Database::connect();
        $sql = "SELECT c.name, COUNT(p.id) as total 
                FROM categories c 
                LEFT JOIN products p ON c.id = p.category_id 
                GROUP BY c.id, c.name";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Chuyển đổi sang format {name: total}
        $data = [];
        foreach ($results as $row) {
            $data[$row['name']] = (int)$row['total'];
        }
        return $data;
    }

    /**
     * Thống kê sản phẩm theo thương hiệu
     */
    private function getProductsByBrand()
    {
        $conn = Database::connect();
        $sql = "SELECT b.name, COUNT(p.id) as total 
                FROM brands b 
                LEFT JOIN products p ON b.id = p.brand_id 
                GROUP BY b.id, b.name 
                LIMIT 10";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Chuyển đổi sang format {name: total}
        $data = [];
        foreach ($results as $row) {
            $data[$row['name']] = (int)$row['total'];
        }
        return $data;
    }
}
?>