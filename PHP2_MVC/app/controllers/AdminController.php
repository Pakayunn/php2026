<?php

class AdminController extends Controller
{
    /**
     * Dashboard admin - hiển thị thống kê tổng quan
     */
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
        $categoryModel = $this->model('Category');
        $brandModel = $this->model('Brand');
        $userModel = $this->model('User');

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
            'usersByRole' => $this->getUsersByRole(),
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Thống kê người dùng theo vai trò
     */
    private function getUsersByRole()
    {
        $conn = Database::connect();
        $sql = "SELECT role, COUNT(*) as total 
                FROM users 
                GROUP BY role";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function dashboard()
{
    Auth::checkAdmin();

    return $this->view('admin.dashboard');
}

}