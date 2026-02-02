@extends('layouts.master')

@section('title', $product['name'] . ' - PHP2 MVC Shop')

@section('content')
<div class="product-detail-wrapper">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="/">Trang chủ</a>
            <span>/</span>
            <a href="/">Sản phẩm</a>
            <span>/</span>
            <span>{{ $product['name'] }}</span>
        </nav>

        <div class="product-detail">
            <!-- Product Image -->
            <div class="product-image-section">
                <div class="image-container">
                    @if(!empty($product['image']))
                        <img src="/uploads/products/{{ $product['image'] }}" alt="{{ $product['name'] }}">
                    @else
                        <img src="https://via.placeholder.com/600x600/e5e7eb/666666?text=No+Image" alt="{{ $product['name'] }}">
                    @endif
                    
                    @if(isset($product['stock']) && $product['stock'] > 0)
                        <span class="stock-badge badge-success">Còn hàng</span>
                    @else
                        <span class="stock-badge badge-danger">Hết hàng</span>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info-section">
                <div class="category-badge">{{ $product['category_name'] ?? 'Chưa phân loại' }}</div>
                
                <h1 class="product-name">{{ $product['name'] }}</h1>
                
                <div class="product-price">
                    <span class="current-price">{{ number_format($product['price'], 0, ',', '.') }}đ</span>
                    <span class="original-price">{{ number_format($product['price'] * 1.2, 0, ',', '.') }}đ</span>
                    <span class="discount">-20%</span>
                </div>

                <div class="product-meta">
                    <div class="meta-row">
                        <strong>Thương hiệu:</strong>
                        <span>{{ $product['brand_name'] ?? 'N/A' }}</span>
                    </div>
                    <div class="meta-row">
                        <strong>Tồn kho:</strong>
                        <span>{{ $product['stock'] ?? 0 }} sản phẩm</span>
                    </div>
                    <div class="meta-row">
                        <strong>Bảo hành:</strong>
                        <span>12 tháng</span>
                    </div>
                    <div class="meta-row">
                        <strong>Vận chuyển:</strong>
                        <span>Miễn phí toàn quốc</span>
                    </div>
                </div>

                <div class="product-description">
                    <h4>Mô tả sản phẩm</h4>
                    <p>{{ $product['description'] ?? 'Sản phẩm chất lượng cao, đảm bảo nguồn gốc xuất xứ rõ ràng.' }}</p>
                </div>

                <div class="action-buttons">
                    <button class="btn btn-primary btn-large">Thêm vào giỏ hàng</button>
                    <button class="btn btn-success btn-large">Mua ngay</button>
                </div>

                <div class="product-features">
                    <div class="feature-item">✓ Hàng chính hãng 100%</div>
                    <div class="feature-item">✓ Đổi trả trong 7 ngày</div>
                    <div class="feature-item">✓ Thanh toán khi nhận hàng</div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-tabs">
            <div class="tabs-header">
                <button class="tab-button active" data-tab="description">Mô tả chi tiết</button>
                <button class="tab-button" data-tab="specs">Thông số kỹ thuật</button>
                <button class="tab-button" data-tab="reviews">Đánh giá</button>
            </div>

            <div class="tabs-content">
                <div class="tab-pane active" id="description">
                    <h4>Thông tin chi tiết về sản phẩm</h4>
                    <p>{{ $product['description'] ?? 'Đang cập nhật...' }}</p>
                    <ul>
                        <li>Chất lượng cao cấp, bền bỉ theo thời gian</li>
                        <li>Thiết kế hiện đại, phù hợp với mọi không gian</li>
                        <li>Dễ dàng sử dụng và bảo quản</li>
                        <li>Được kiểm tra chất lượng nghiêm ngặt trước khi xuất xưởng</li>
                    </ul>
                </div>

                <div class="tab-pane" id="specs">
                    <table class="specs-table">
                        <tr>
                            <th>Mã sản phẩm</th>
                            <td>SP{{ str_pad($product['id'], 6, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <th>Danh mục</th>
                            <td>{{ $product['category_name'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Thương hiệu</th>
                            <td>{{ $product['brand_name'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Tình trạng</th>
                            <td>
                                @if(isset($product['stock']) && $product['stock'] > 0)
                                    <span class="badge badge-success">Còn hàng</span>
                                @else
                                    <span class="badge badge-danger">Hết hàng</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Bảo hành</th>
                            <td>12 tháng chính hãng</td>
                        </tr>
                    </table>
                </div>

                <div class="tab-pane" id="reviews">
                    <div class="reviews-summary">
                        <h3>5.0</h3>
                        <div class="stars">★★★★★</div>
                        <p>128 đánh giá</p>
                    </div>
                    <div class="alert-info">Chức năng đánh giá đang được phát triển</div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="back-button">
            <a href="/" class="btn">← Quay lại trang chủ</a>
        </div>
    </div>
</div>

<style>
/* Base */
.product-detail-wrapper {
    background: #f5f5f5;
    padding: 20px 0 40px;
    min-height: calc(100vh - 56px);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Breadcrumb */
.breadcrumb {
    background: #fff;
    padding: 12px 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    border: 1px solid #ddd;
    font-size: 14px;
}

.breadcrumb a {
    color: #007bff;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.breadcrumb span {
    color: #666;
    margin: 0 8px;
}

/* Product Detail */
.product-detail {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.product-image-section {
    background: #fff;
    padding: 20px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

.image-container {
    position: relative;
}

.image-container img {
    width: 100%;
    border-radius: 4px;
}

.stock-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 500;
    border-radius: 4px;
}

.badge-success {
    background: #28a745;
    color: #fff;
}

.badge-danger {
    background: #dc3545;
    color: #fff;
}

.product-info-section {
    background: #fff;
    padding: 25px;
    border-radius: 6px;
    border: 1px solid #ddd;
}

.category-badge {
    display: inline-block;
    background: #007bff;
    color: #fff;
    padding: 5px 12px;
    border-radius: 3px;
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.product-name {
    font-size: 26px;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
    line-height: 1.3;
}

.product-price {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px;
    background: #fff9e6;
    border: 1px solid #ffe7a0;
    border-radius: 4px;
    margin-bottom: 20px;
}

.current-price {
    font-size: 28px;
    font-weight: 700;
    color: #dc3545;
}

.original-price {
    font-size: 18px;
    color: #999;
    text-decoration: line-through;
}

.discount {
    background: #dc3545;
    color: #fff;
    padding: 4px 10px;
    border-radius: 3px;
    font-size: 13px;
    font-weight: 600;
}

.product-meta {
    margin-bottom: 20px;
}

.meta-row {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.meta-row strong {
    width: 140px;
    color: #333;
    font-weight: 600;
}

.meta-row span {
    color: #666;
}

.product-description {
    margin-bottom: 25px;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 4px;
    border-left: 3px solid #007bff;
}

.product-description h4 {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.product-description p {
    color: #666;
    line-height: 1.6;
}

.action-buttons {
    display: flex;
    gap: 12px;
    margin-bottom: 25px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff;
    color: #fff;
    text-decoration: none;
    border: none;
    border-radius: 4px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s;
    text-align: center;
}

.btn:hover {
    background: #0056b3;
}

.btn-large {
    flex: 1;
    padding: 14px 24px;
    font-size: 16px;
}

.btn-primary {
    background: #007bff;
}

.btn-primary:hover {
    background: #0056b3;
}

.btn-success {
    background: #28a745;
}

.btn-success:hover {
    background: #1e7e34;
}

.product-features {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 15px;
    background: #f0f9ff;
    border-radius: 4px;
    border: 1px solid #bee5eb;
}

.feature-item {
    color: #0c5460;
    font-size: 14px;
}

/* Product Tabs */
.product-tabs {
    background: #fff;
    border-radius: 6px;
    border: 1px solid #ddd;
    margin-bottom: 25px;
}

.tabs-header {
    display: flex;
    border-bottom: 2px solid #eee;
}

.tab-button {
    flex: 1;
    padding: 15px 20px;
    background: none;
    border: none;
    font-size: 15px;
    font-weight: 500;
    color: #666;
    cursor: pointer;
    transition: all 0.2s;
    border-bottom: 3px solid transparent;
}

.tab-button:hover {
    color: #333;
    background: #f9f9f9;
}

.tab-button.active {
    color: #007bff;
    border-bottom-color: #007bff;
}

.tabs-content {
    padding: 25px;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

.tab-pane h4 {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.tab-pane p {
    color: #666;
    line-height: 1.7;
    margin-bottom: 15px;
}

.tab-pane ul {
    padding-left: 20px;
    color: #666;
    line-height: 1.8;
}

.specs-table {
    width: 100%;
    border-collapse: collapse;
}

.specs-table th,
.specs-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.specs-table th {
    width: 200px;
    font-weight: 600;
    color: #333;
    background: #f9f9f9;
}

.specs-table td {
    color: #666;
}

.reviews-summary {
    text-align: center;
    padding: 30px;
    background: #f9f9f9;
    border-radius: 4px;
    margin-bottom: 20px;
}

.reviews-summary h3 {
    font-size: 48px;
    font-weight: 700;
    color: #007bff;
    margin: 0;
}

.reviews-summary .stars {
    font-size: 24px;
    color: #ffc107;
    margin: 10px 0;
}

.reviews-summary p {
    color: #666;
    margin: 0;
}

.alert-info {
    padding: 12px 15px;
    background: #d1ecf1;
    border: 1px solid #bee5eb;
    border-radius: 4px;
    color: #0c5460;
    font-size: 14px;
}

/* Back Button */
.back-button {
    text-align: center;
}

.back-button .btn {
    padding: 10px 24px;
}

/* Responsive */
@media (max-width: 768px) {
    .product-detail {
        grid-template-columns: 1fr;
    }
    
    .product-name {
        font-size: 22px;
    }
    
    .current-price {
        font-size: 24px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .tabs-header {
        flex-direction: column;
    }
    
    .tab-button {
        border-bottom: 1px solid #eee;
        border-left: 3px solid transparent;
    }
    
    .tab-button.active {
        border-left-color: #007bff;
        border-bottom-color: #eee;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));
            
            // Add active class to clicked button and corresponding pane
            this.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });
});
</script>
@endsection