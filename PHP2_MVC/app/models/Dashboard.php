<?php
class Dashboard extends Model
{
    public function getStatistics()
    {
        $productModel  = new Product();
        $categoryModel = new Category();
        $brandModel    = new Brand();
        $userModel     = new User();

        return [
            'totalProducts'   => $productModel->count(),
            'totalCategories' => $categoryModel->count(),
            'totalBrands'     => $brandModel->count(),
            'totalUsers'      => $userModel->count(),
            'recentProducts'  => $productModel->latest(5),
        ];
    }

    public function getChartData()
    {
        $productModel = new Product();

        return [
            'productsByCategory' => $productModel->countByCategory(),
            'productsByBrand'    => $productModel->countByBrand(),
        ];
    }
}
?>