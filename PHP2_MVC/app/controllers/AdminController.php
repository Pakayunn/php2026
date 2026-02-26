<?php

class AdminController extends Controller
{
    /**
     * Dashboard admin - hiển thị thống kê tổng quan
     */
    public function index()
    {
        // Bảo vệ admin
        Auth::checkAdmin();

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
            'totalProducts'   => $this->countRecords('products'),
            'totalCategories' => $this->countRecords('categories'),
            'totalBrands'     => $this->countRecords('brands'),
            'totalUsers'      => $this->countRecords('users'),

            // ===== THỐNG KÊ DOANH THU =====
            'totalRevenue'    => $this->getTotalRevenue(),
            'monthlyRevenue'  => $this->getMonthlyRevenue(),
            'totalOrders'     => $this->getTotalOrders(),
            'todayOrders'     => $this->getTodayOrders(),

            'recentProducts'  => $productModel->getRecent(5),
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
     * ===== DOANH THU =====
     */

    // Tổng doanh thu
    private function getTotalRevenue()
    {
        $conn = Database::connect();
        $sql = "SELECT SUM(final_amount) 
                FROM orders 
                WHERE status = 'completed' 
                AND payment_status = 'paid'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn() ?? 0;
    }

    // Doanh thu tháng hiện tại
    private function getMonthlyRevenue()
    {
        $conn = Database::connect();
        $sql = "SELECT SUM(final_amount) 
                FROM orders 
                WHERE status = 'completed' 
                AND payment_status = 'paid'
                AND MONTH(created_at) = MONTH(CURRENT_DATE())
                AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn() ?? 0;
    }

    // Tổng số đơn hoàn thành
    private function getTotalOrders()
    {
        $conn = Database::connect();
        $sql = "SELECT COUNT(*) 
                FROM orders 
                WHERE status = 'completed'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Đơn hàng hôm nay
    private function getTodayOrders()
    {
        $conn = Database::connect();
        $sql = "SELECT COUNT(*) 
                FROM orders 
                WHERE DATE(created_at) = CURRENT_DATE()";
        $stmt = $conn->prepare($sql);
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
            'productsByBrand'    => $this->getProductsByBrand(),
            'usersByRole'        => $this->getUsersByRole(),
            'revenueByMonth'     => $this->getRevenueByMonth(),
            'topProducts'        => $this->getTopProducts(),
        ];
    }

    /**
     * Doanh thu theo tháng (biểu đồ)
     */
    private function getRevenueByMonth()
    {
        $conn = Database::connect();
        $sql = "SELECT MONTH(created_at) as month,
                       SUM(final_amount) as revenue
                FROM orders
                WHERE status = 'completed'
                AND payment_status = 'paid'
                GROUP BY MONTH(created_at)
                ORDER BY MONTH(created_at)";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    /**
     * Sản phẩm bán chạy
     */
    private function getTopProducts()
    {
        $conn = Database::connect();
        $sql = "SELECT product_name,
                       SUM(quantity) as total_sold,
                       SUM(subtotal) as revenue
                FROM order_items
                GROUP BY product_id, product_name
                ORDER BY total_sold DESC
                LIMIT 5";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}